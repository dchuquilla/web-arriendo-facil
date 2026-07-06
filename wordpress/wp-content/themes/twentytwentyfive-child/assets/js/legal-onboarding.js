/* global window, document, fetch, FormData, localStorage, URLSearchParams */
(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn, { once: true });
    } else {
      fn();
    }
  }

  ready(function init() {
    var cfg = window.afGuestProfile || {};
    if (!cfg.ajaxUrl) {
      cfg.ajaxUrl = (window.ajaxurl || '/wp-admin/admin-ajax.php');
    }

    var i18n = cfg.i18n || {};
    var form = document.getElementById('af-guest-profile-form');
    var statusEl = document.getElementById('af-guest-profile-status');
    var loadingEl = document.getElementById('af-guest-profile-loading');
    var contextEl = document.getElementById('af-guest-profile-context');
    var submitBtn = document.getElementById('af-guest-profile-submit');
    var actionsEl = form ? form.querySelector('.af-guest-profile-actions') : null;
    var cancelBtn = null;

    if (!form || !submitBtn) return;

    function getUrlParam(name) {
      var params = new URLSearchParams(window.location.search || '');
      var value = params.get(name) || params.get('amp;' + name) || '';

      if (!value && window.location.hash && window.location.hash.indexOf('=') !== -1) {
        var hashParams = new URLSearchParams(window.location.hash.replace(/^#/, ''));
        value = hashParams.get(name) || hashParams.get('amp;' + name) || '';
      }

      return String(value || '').trim();
    }

    var selector = getUrlParam('selector');
    var token = getUrlParam('token');
    var draftKey = '';
    var autosaveTimer = null;
    var submitStageTimer = null;
    var activeSubmit = null;

    function ensureCancelButton() {
      if (!actionsEl || cancelBtn) return;
      cancelBtn = document.createElement('button');
      cancelBtn.type = 'button';
      cancelBtn.id = 'af-guest-profile-cancel';
      cancelBtn.className = 'btn btn--ghost btn--lg';
      cancelBtn.textContent = i18n.cancel || 'Cancelar envio';
      cancelBtn.setAttribute('hidden', 'hidden');

      cancelBtn.addEventListener('click', function () {
        if (!activeSubmit || typeof activeSubmit.abort !== 'function') return;
        activeSubmit.abortedByUser = true;
        showStatus(i18n.manualCancel || 'Cancelaste el envio. Puedes revisar tus datos y volver a intentarlo.', true);
        setLoading(false);
        activeSubmit.abort('manual');
      });

      actionsEl.appendChild(cancelBtn);
    }

    function showStatus(message, isError) {
      if (!statusEl) return;
      statusEl.textContent = message;
      statusEl.className = 'af-guest-profile-status ' + (isError ? 'is-error' : 'is-success');
      statusEl.removeAttribute('hidden');
    }

    function clearStatus() {
      if (!statusEl) return;
      statusEl.textContent = '';
      statusEl.className = 'af-guest-profile-status';
      statusEl.setAttribute('hidden', 'hidden');
    }

    function setFormDisabled(disabled) {
      Array.prototype.forEach.call(form.elements, function (el) {
        if (!el) return;
        if (cancelBtn && el === cancelBtn) return;
        el.disabled = !!disabled;
      });
    }

    function setLoading(loading, loadingText, submitText) {
      if (loadingEl) {
        if (loadingText) {
          loadingEl.textContent = loadingText;
        }
        if (loading) {
          loadingEl.removeAttribute('hidden');
          loadingEl.setAttribute('aria-live', 'polite');
        } else {
          loadingEl.setAttribute('hidden', 'hidden');
        }
      }
      setFormDisabled(loading);
      submitBtn.textContent = loading
        ? (submitText || i18n.sendingStep1 || i18n.sending || 'Enviando datos...')
        : (i18n.submit || 'Enviar perfil legal');
      if (cancelBtn) {
        if (loading) cancelBtn.removeAttribute('hidden');
        else cancelBtn.setAttribute('hidden', 'hidden');
      }
    }

    function fetchWithTimeout(url, options, timeoutMs) {
      var supportsAbort = typeof window.AbortController === 'function';
      var controller = supportsAbort ? new window.AbortController() : null;
      var timerId = null;
      var abortReason = '';

      if (controller) {
        options = Object.assign({}, options, { signal: controller.signal });
      }

      timerId = window.setTimeout(function () {
        abortReason = 'timeout';
        if (controller) {
          controller.abort();
        }
      }, Math.max(1000, timeoutMs || 45000));

      var request = fetch(url, options).catch(function (error) {
        if (error && error.name === 'AbortError' && !error.afAbortReason) {
          error.afAbortReason = abortReason || 'manual';
        }
        throw error;
      }).finally(function () {
        if (timerId) {
          window.clearTimeout(timerId);
        }
      });

      return {
        promise: request,
        abort: function (reason) {
          abortReason = reason || 'manual';
          if (controller) {
            controller.abort();
          }
        },
      };
    }

    function postFormData(data) {
      var fd = new FormData();
      Object.keys(data).forEach(function (k) {
        if (data[k] !== null && data[k] !== undefined && data[k] !== '') {
          fd.append(k, data[k]);
        }
      });
      return fetchWithTimeout(cfg.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: fd,
      }, 30000).promise.then(function (response) {
        return parseResponseJson(response)
          .then(function (parsedPayload) {
            return { status: response.status, payload: parsedPayload };
          });
      });
    }

    function parseJsonFromText(rawText) {
      if (!rawText) return {};

      try {
        return JSON.parse(rawText);
      } catch (e) {
        var firstBrace = rawText.indexOf('{');
        var lastBrace = rawText.lastIndexOf('}');
        if (firstBrace !== -1 && lastBrace > firstBrace) {
          var fragment = rawText.slice(firstBrace, lastBrace + 1);
          try {
            return JSON.parse(fragment);
          } catch (inner) {
            return {};
          }
        }
        return {};
      }
    }

    function parseResponseJson(response) {
      return response.text().catch(function () { return ''; })
        .then(function (rawText) {
          return parseJsonFromText(rawText);
        });
    }

    function isTimeoutError(error) {
      return !!(error && (error.name === 'AbortError' || /timeout/i.test(String(error.message || ''))) && error.afAbortReason === 'timeout');
    }

    function isManualAbort(error) {
      return !!(error && error.name === 'AbortError' && error.afAbortReason === 'manual');
    }

    function buildHttpErrorMessage(status, fallbackMessage) {
      if (status === 400) return fallbackMessage || (i18n.error400 || 'Revisa los datos ingresados e intenta nuevamente.');
      if (status === 403) return i18n.error403 || 'Tu sesion expiro, recarga la pagina.';
      if (status === 413) return i18n.error413 || 'Los archivos son demasiado grandes. Reduce su tamano e intenta nuevamente.';
      if (status >= 500) return i18n.error500 || 'Tuvimos un problema en el servidor. Intentalo nuevamente.';
      if (status >= 400) return fallbackMessage || (i18n.errorGeneric || 'No se pudo completar la solicitud en este momento.');
      return fallbackMessage || '';
    }

    function sendProfileForm(fd) {
      var request = fetchWithTimeout(cfg.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: fd,
      }, 420000);

      return {
        abort: request.abort,
        promise: request.promise.then(function (response) {
          return parseResponseJson(response).then(function (parsedPayload) {
            return { status: response.status, payload: parsedPayload };
          });
        }),
      };
    }

    function setFieldValue(name, value) {
      if (form.elements[name] && value !== null && value !== undefined && value !== '') {
        form.elements[name].value = value;
      }
    }

    function getFieldValue(name) {
      var field = form.elements[name];
      if (!field || typeof field.value === 'undefined' || field.value === null) return '';
      return String(field.value).trim();
    }

    function readDraft() {
      if (!draftKey) return;
      try {
        var raw = localStorage.getItem(draftKey);
        if (!raw) return;
        var parsed = JSON.parse(raw);
        Object.keys(parsed).forEach(function (name) {
          if (form.elements[name] && form.elements[name].type !== 'file') {
            form.elements[name].value = parsed[name];
          }
        });
      } catch (e) { /* ignore corrupt draft */ }
    }

    function writeDraft() {
      if (!draftKey) return;
      var snapshot = {};
      Array.prototype.forEach.call(form.elements, function (el) {
        if (!el.name || el.type === 'file' || el.type === 'submit' || el.type === 'button') return;
        snapshot[el.name] = el.value;
      });
      try { localStorage.setItem(draftKey, JSON.stringify(snapshot)); }
      catch (e) { /* storage full */ }
    }

    function scheduleDraftSave() {
      if (autosaveTimer) window.clearTimeout(autosaveTimer);
      autosaveTimer = window.setTimeout(writeDraft, 180);
    }

    function validateBeforeSubmit() {
      var rentalStartDate = getFieldValue('rental_start_date');
      var phone = getFieldValue('phone');
      var idNumber = getFieldValue('id_number');
      var personasEl = (form && form.elements && typeof form.elements.namedItem === 'function')
        ? form.elements.namedItem('personas_viviran')
        : null;
      var personasRaw = (personasEl && typeof personasEl.value !== 'undefined' && personasEl.value !== null)
        ? String(personasEl.value).trim()
        : '';
      var personas = personasRaw !== '' ? parseInt(personasRaw, 10) : NaN;

      if (!rentalStartDate) return 'La fecha de inicio de arriendo es obligatoria.';
      if (!phone) return 'El teléfono es obligatorio.';
      if (!/^\d{10}$/.test(phone)) return 'El teléfono debe tener exactamente 10 dígitos.';
      if (!idNumber) return 'La cédula es obligatoria.';
      if (!/^\d{10}$/.test(idNumber)) return 'La cédula debe tener exactamente 10 dígitos.';
      if (personasRaw !== '' && (isNaN(personas) || personas < 1 || personas > 20)) return 'Personas que vivirán debe ser un número entre 1 y 20.';
      return '';
    }

    function setContext(data) {
      if (!contextEl) return;
      var parts = [];
      if (data.name) parts.push('Nombre: ' + data.name);
      if (data.email) parts.push('Correo: ' + data.email);
      if (data.phone) parts.push('Teléfono: ' + data.phone);
      if (data.expires_at) parts.push('Expira: ' + data.expires_at);
      contextEl.textContent = parts.join(' | ');
    }

    function bootstrapTokenValidation() {
      if (!selector || !token) {
        showStatus('Token incompleto.', true);
        setFormDisabled(true);
        submitBtn.disabled = true;
        return;
      }

      setFieldValue('selector', selector);
      setFieldValue('token', token);
      draftKey = 'af_guest_profile_draft_' + selector;
      setLoading(true, i18n.validatingLink || 'Validando enlace seguro...', i18n.sending || 'Enviando...');

      postFormData({
        action: 'af_validate_guest_profile_token',
        selector: selector,
        token: token,
      }).then(function (result) {
        setLoading(false);
        var payload = result.payload || {};
        var data = payload.data || {};

        if (!payload.success) {
          showStatus(data.message || 'No se pudo validar el enlace de onboarding.', true);
          submitBtn.disabled = true;
          return;
        }

        setFieldValue('name', data.name || '');
        setFieldValue('phone', data.phone || '');
        setContext(data);
        readDraft();
        clearStatus();
      }).catch(function () {
        setLoading(false);
        showStatus('Error de red al validar el enlace. Intenta de nuevo.', true);
        submitBtn.disabled = true;
      });
    }

    form.addEventListener('input', scheduleDraftSave);
    form.addEventListener('change', scheduleDraftSave);

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      clearStatus();

      if (activeSubmit) {
        return;
      }

      var resolvedSelector = getFieldValue('selector') || selector;
      var resolvedToken = getFieldValue('token') || token;

      if (!resolvedSelector || !resolvedToken) {
        showStatus('Token incompleto.', true);
        return;
      }

      var preValidation = validateBeforeSubmit();
      if (preValidation) {
        showStatus(preValidation, true);
        return;
      }

      var fd = new FormData(form);

      setLoading(true, i18n.sendingStep1 || 'Enviando datos...', i18n.sendingStep1 || 'Enviando datos...');

      if (submitStageTimer) {
        window.clearTimeout(submitStageTimer);
      }
      submitStageTimer = window.setTimeout(function () {
        if (activeSubmit) {
          setLoading(true, i18n.sendingStep2 || 'Estamos generando tu contrato, esto puede tardar unos minutos.', i18n.sendingStep2 || 'Generando contrato...');
        }
      }, 1400);

      fd.delete('selector');
      fd.delete('token');
      fd.append('selector', resolvedSelector);
      fd.append('token', resolvedToken);
      fd.append('action', 'af_submit_guest_profile_by_token');
      activeSubmit = sendProfileForm(fd);

      activeSubmit.promise.then(function (result) {
        if (activeSubmit && activeSubmit.abortedByUser) {
          return;
        }

        var payload = result.payload || {};
        var data = payload.data || {};

        if (!payload.success) {
          showStatus(buildHttpErrorMessage(result.status, data.message || 'No se pudo enviar el perfil legal.'), true);
          return;
        }

        try { if (draftKey) localStorage.removeItem(draftKey); } catch (e) { /* noop */ }

        var documents = Array.isArray(data.uploaded_documents) ? data.uploaded_documents.length : 0;
        var message = data.message || (i18n.success || 'Perfil legal enviado correctamente.');
        if (data.contract && data.contract.generated) {
          message += ' ' + (i18n.contractGenerated || 'Contrato generado correctamente.');
        }
        if (documents > 0) message += ' Documentos subidos: ' + documents + '.';
        showStatus(message, false);
        setLoading(false);
        form.reset();
        setFieldValue('selector', selector);
        setFieldValue('token', token);
        form.setAttribute('hidden', 'hidden');
        if (contextEl) {
          contextEl.setAttribute('hidden', 'hidden');
        }
      }).catch(function (error) {
        if (isTimeoutError(error)) {
          showStatus(i18n.timeout || 'La solicitud tardo demasiado, intentalo nuevamente.', true);
          return;
        }
        if (isManualAbort(error) || (activeSubmit && activeSubmit.abortedByUser)) {
          showStatus(i18n.manualCancel || 'Cancelaste el envio. Puedes revisar tus datos y volver a intentarlo.', true);
          return;
        }
        showStatus(i18n.networkError || 'Error de red al enviar el perfil legal.', true);
      }).finally(function () {
        if (submitStageTimer) {
          window.clearTimeout(submitStageTimer);
          submitStageTimer = null;
        }
        setLoading(false);
        activeSubmit = null;
      });
    });

    ensureCancelButton();
    bootstrapTokenValidation();
  });
})();
