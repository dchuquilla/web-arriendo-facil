(function () {
  'use strict';

  if (!window.afGuestProfile) {
    return;
  }

  var cfg = window.afGuestProfile;
  var form = document.getElementById('af-guest-profile-form');
  var statusEl = document.getElementById('af-guest-profile-status');
  var loadingEl = document.getElementById('af-guest-profile-loading');
  var contextEl = document.getElementById('af-guest-profile-context');
  var submitBtn = document.getElementById('af-guest-profile-submit');

  if (!form || !submitBtn) {
    return;
  }

  var params = new URLSearchParams(window.location.search);
  var selector = params.get('selector') || '';
  var token = params.get('token') || '';
  var draftKey = '';
  var autosaveTimer = null;

  function showStatus(message, isError) {
    if (!statusEl) {
      return;
    }

    statusEl.textContent = message;
    statusEl.className = 'af-guest-profile-status' + (isError ? ' is-error' : ' is-success');
    statusEl.removeAttribute('hidden');
  }

  function clearStatus() {
    if (!statusEl) {
      return;
    }

    statusEl.textContent = '';
    statusEl.className = 'af-guest-profile-status';
    statusEl.setAttribute('hidden', 'hidden');
  }

  function setLoading(loading) {
    if (loadingEl) {
      if (loading) {
        loadingEl.removeAttribute('hidden');
      } else {
        loadingEl.setAttribute('hidden', 'hidden');
      }
    }

    submitBtn.disabled = loading;
    submitBtn.textContent = loading
      ? (cfg.i18n && cfg.i18n.sending ? cfg.i18n.sending : 'Enviando...')
      : (cfg.i18n && cfg.i18n.submit ? cfg.i18n.submit : 'Enviar perfil legal');
  }

  function postFormData(data) {
    var fd = new FormData();
    Object.keys(data).forEach(function (k) {
      if (data[k] !== null && data[k] !== undefined && data[k] !== '') {
        fd.append(k, data[k]);
      }
    });

    return fetch(cfg.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body: fd,
    }).then(function (response) {
      return response.json()
        .catch(function () { return {}; })
        .then(function (payload) {
          return {
            status: response.status,
            payload: payload,
          };
        });
    });
  }

  function setFieldValue(name, value) {
    if (form.elements[name] && value !== null && value !== undefined && value !== '') {
      form.elements[name].value = value;
    }
  }

  function readDraft() {
    if (!draftKey) {
      return;
    }

    try {
      var raw = localStorage.getItem(draftKey);
      if (!raw) {
        return;
      }

      var parsed = JSON.parse(raw);
      Object.keys(parsed).forEach(function (name) {
        if (form.elements[name] && form.elements[name].type !== 'file') {
          form.elements[name].value = parsed[name];
        }
      });
    } catch (e) {
      // Ignore corrupt draft.
    }
  }

  function writeDraft() {
    if (!draftKey) {
      return;
    }

    var snapshot = {};
    Array.prototype.forEach.call(form.elements, function (el) {
      if (!el.name || el.type === 'file' || el.type === 'submit' || el.type === 'button') {
        return;
      }
      snapshot[el.name] = el.value;
    });

    try {
      localStorage.setItem(draftKey, JSON.stringify(snapshot));
    } catch (e) {
      // Ignore storage full errors.
    }
  }

  function scheduleDraftSave() {
    if (autosaveTimer) {
      window.clearTimeout(autosaveTimer);
    }

    autosaveTimer = window.setTimeout(writeDraft, 180);
  }

  function validateBeforeSubmit() {
    var rentalStartDate = (form.elements.rental_start_date.value || '').trim();
    var rentalYears = parseInt(form.elements.rental_years.value || '0', 10);
    var phone = (form.elements.phone.value || '').trim();
    var idNumber = (form.elements.id_number.value || '').trim();

    if (!rentalStartDate) {
      return 'La fecha de inicio de arriendo es obligatoria.';
    }

    if (!rentalYears || rentalYears < 1 || rentalYears > 20) {
      return 'El tiempo de arriendo debe estar entre 1 y 20 anos.';
    }

    if (phone && !/^\d{10}$/.test(phone)) {
      return 'El telefono debe tener exactamente 10 digitos.';
    }

    if (idNumber && !/^\d{10}$/.test(idNumber)) {
      return 'La cedula debe tener exactamente 10 digitos.';
    }

    return '';
  }

  function setContext(data) {
    if (!contextEl) {
      return;
    }

    var parts = [];
    if (data.name) {
      parts.push('Nombre: ' + data.name);
    }
    if (data.email) {
      parts.push('Correo: ' + data.email);
    }
    if (data.phone) {
      parts.push('Telefono: ' + data.phone);
    }
    if (data.expires_at) {
      parts.push('Expira: ' + data.expires_at);
    }

    contextEl.textContent = parts.join(' | ');
  }

  function bootstrapTokenValidation() {
    if (!selector || !token) {
      showStatus('Enlace invalido. Falta selector o token.', true);
      submitBtn.disabled = true;
      return;
    }

    setFieldValue('selector', selector);
    setFieldValue('token', token);

    draftKey = 'af_guest_profile_draft_' + selector;
    setLoading(true);

    postFormData({
      action: 'af_validate_guest_profile_token',
      selector: selector,
      token: token,
    }).then(function (result) {
      setLoading(false);

      var payload = result.payload || {};
      var data = payload.data || {};
      if (!payload.success) {
        var msg = data.message || 'No se pudo validar el enlace de onboarding.';
        showStatus(msg, true);
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

    var preValidation = validateBeforeSubmit();
    if (preValidation) {
      showStatus(preValidation, true);
      return;
    }

    setLoading(true);

    var fd = new FormData(form);
    fd.append('action', 'af_submit_guest_profile_by_token');

    fetch(cfg.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body: fd,
    }).then(function (response) {
      return response.json()
        .catch(function () { return {}; })
        .then(function (payload) {
          setLoading(false);
          var data = payload.data || {};

          if (!payload.success) {
            showStatus(data.message || 'No se pudo enviar el perfil legal.', true);
            return;
          }

          try {
            if (draftKey) {
              localStorage.removeItem(draftKey);
            }
          } catch (e) {
            // noop
          }

          var documents = Array.isArray(data.uploaded_documents) ? data.uploaded_documents.length : 0;
          var message = data.message || 'Perfil legal enviado correctamente.';
          if (documents > 0) {
            message += ' Documentos subidos: ' + documents + '.';
          }
          showStatus(message, false);
          form.reset();
          setFieldValue('selector', selector);
          setFieldValue('token', token);
        });
    }).catch(function () {
      setLoading(false);
      showStatus('Error de red al enviar el perfil legal.', true);
    });
  });

  bootstrapTokenValidation();
})();
