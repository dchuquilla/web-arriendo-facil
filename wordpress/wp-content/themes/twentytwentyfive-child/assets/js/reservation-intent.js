/* global window, document, fetch, FormData */
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
    var cfg = window.afReservationIntent || {};
    if (!cfg.ajaxUrl) {
      // Backend not configured — still allow the modal to open, just disable AJAX.
      cfg.ajaxUrl = (window.ajaxurl || '/wp-admin/admin-ajax.php');
    }

    var i18n = cfg.i18n || {};
    var body = document.body;
    var modal = document.getElementById('af-reservation-modal');
    var form = document.getElementById('af-reservation-form');
    var statusEl = document.getElementById('af-reservation-status');
    var submitBtn = document.getElementById('af-reservation-submit');
    var accommodationField = document.getElementById('af-reservation-accommodation-id');
    var slotField = document.getElementById('af-reservation-slot-id');
    var titleEl = document.getElementById('af-reservation-modal-title');
    var accommodationEl = document.getElementById('af-reservation-modal-accommodation');
    var subtitleEl = document.getElementById('af-reservation-modal-subtitle');

    if (!modal || !form || !submitBtn || !accommodationField) {
      // Modal markup missing — bail silently. Buttons will fall back to native link if any.
      return;
    }

    var lastFocused = null;

    function esc(str) {
      var div = document.createElement('div');
      div.textContent = (str == null) ? '' : String(str);
      return div.innerHTML;
    }

    function showStatus(message, isError) {
      if (!statusEl) return;
      statusEl.className = 'af-reservation-status ' + (isError ? 'is-error' : 'is-success');
      statusEl.innerHTML = message;
      statusEl.removeAttribute('hidden');
    }

    function hideStatus() {
      if (!statusEl) return;
      statusEl.setAttribute('hidden', 'hidden');
      statusEl.textContent = '';
      statusEl.className = 'af-reservation-status';
    }

    function setLoading(loading) {
      submitBtn.disabled = loading;
      submitBtn.textContent = loading
        ? (i18n.sending || 'Enviando...')
        : (i18n.submit || 'Confirmar reserva');
    }

    function openModal(trigger) {
      var accommodationId = parseInt(trigger.getAttribute('data-af-accommodation-id') || '0', 10);
      if (!accommodationId) return;

      lastFocused = trigger;
      hideStatus();
      setLoading(false);
      form.reset();

      accommodationField.value = String(accommodationId);
      slotField.value = trigger.getAttribute('data-af-slot-id') || '';

      var title = trigger.getAttribute('data-af-accommodation-title') || '';
      if (titleEl) titleEl.textContent = i18n.title || 'Reserva tu visita';
      if (accommodationEl) accommodationEl.textContent = title ? ('Alojamiento: ' + title) : 'Alojamiento: -';
      if (subtitleEl) subtitleEl.textContent = i18n.subtitle || 'Completa solo los datos esenciales.';

      modal.classList.add('af-reservation-modal--open');
      modal.setAttribute('aria-hidden', 'false');
      body.classList.add('af-modal-open');

      var first = form.querySelector('input[name="guest_name"]');
      var canAutoFocus = window.matchMedia && window.matchMedia('(min-width: 768px) and (pointer: fine)').matches;
      if (first && canAutoFocus) {
        try { first.focus(); } catch (e) { /* noop */ }
      }
    }

    function closeModal() {
      modal.classList.remove('af-reservation-modal--open');
      modal.setAttribute('aria-hidden', 'true');
      body.classList.remove('af-modal-open');
      hideStatus();
      setLoading(false);

      if (lastFocused && typeof lastFocused.focus === 'function') {
        try { lastFocused.focus(); } catch (e) { /* noop */ }
      }
    }

    function parseErrorMessage(payload, httpStatus) {
      var data = (payload && payload.data) ? payload.data : payload || {};
      var reason = data && data.reason_code ? String(data.reason_code) : '';
      var message = data && data.message ? String(data.message) : '';

      if (httpStatus === 409 || reason) {
        var msg = i18n.conflict || 'Ya no hay disponibilidad para ese horario. Elige otro horario o envía una solicitud sin horario.';
        if (message) {
          msg += '<br><small>' + esc(message) + (reason ? ' (' + esc(reason) + ')' : '') + '</small>';
        }
        return msg;
      }

      if (message) return esc(message);
      return i18n.error || 'No se pudo registrar tu reserva.';
    }

    function postAjax(data) {
      var fd = new FormData();
      Object.keys(data).forEach(function (key) {
        var v = data[key];
        if (v !== null && v !== undefined && v !== '') {
          fd.append(key, v);
        }
      });

      return fetch(cfg.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: fd,
      }).then(function (response) {
        return response.json().catch(function () { return {}; })
          .then(function (payload) {
            return { status: response.status, ok: response.ok, payload: payload };
          });
      });
    }

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      hideStatus();

      var name = (form.elements.guest_name.value || '').trim();
      var email = (form.elements.guest_email.value || '').trim();
      var phone = (form.elements.guest_phone.value || '').trim();

      if (!name || !email) {
        showStatus(i18n.required || 'Nombre y correo son obligatorios.', true);
        return;
      }

      setLoading(true);

      postAjax({
        action: 'af_create_reservation_intent',
        // Send nonce under both common field names to match either backend convention.
        nonce: cfg.nonce || '',
        _ajax_nonce: cfg.nonce || '',
        accommodation_id: accommodationField.value,
        slot_id: slotField.value,
        guest_name: name,
        guest_email: email,
        guest_phone: phone,
        preferred_date: form.elements.preferred_date.value,
        preferred_time: form.elements.preferred_time.value,
        notes: form.elements.notes.value,
      }).then(function (result) {
        setLoading(false);

        var payload = result.payload || {};
        var data = payload.data || {};

        if (payload.success) {
          var status = data.status || '';
          var baseMsg = esc(data.message || (i18n.success || 'Solicitud registrada correctamente.'));

          if (status === 'visit_booked' && data.booking_id) {
            baseMsg += '<br><small>Código de reserva: #' + esc(String(data.booking_id)) + '</small>';
          }

          showStatus(baseMsg, false);
          form.reset();

          window.setTimeout(function () { closeModal(); }, 1800);
          return;
        }

        showStatus(parseErrorMessage(payload, result.status), true);
      }).catch(function () {
        setLoading(false);
        showStatus(i18n.network || 'Error de red. Intenta nuevamente.', true);
      });
    });

    // Delegated click handler for triggers and close buttons.
    document.addEventListener('click', function (event) {
      var trigger = event.target.closest('[data-af-reserve-trigger]');
      if (trigger) {
        event.preventDefault();
        event.stopPropagation();
        openModal(trigger);
        return;
      }

      if (event.target.closest('[data-af-reserve-close]')) {
        event.preventDefault();
        closeModal();
      }
    }, true);

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && modal.classList.contains('af-reservation-modal--open')) {
        closeModal();
      }
    });
  });
})();
