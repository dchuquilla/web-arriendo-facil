(function () {
  'use strict';

  if (!window.afReservationIntent) {
    return;
  }

  var cfg = window.afReservationIntent;
  var body = document.body;
  var modal = document.getElementById('af-reservation-modal');
  var modalBackdrop = document.getElementById('af-reservation-modal-backdrop');
  var closeButtons = document.querySelectorAll('[data-af-reserve-close]');
  var form = document.getElementById('af-reservation-form');
  var statusEl = document.getElementById('af-reservation-status');
  var submitBtn = document.getElementById('af-reservation-submit');
  var accommodationField = document.getElementById('af-reservation-accommodation-id');
  var slotField = document.getElementById('af-reservation-slot-id');
  var titleEl = document.getElementById('af-reservation-modal-title');
  var accommodationEl = document.getElementById('af-reservation-modal-accommodation');
  var subtitleEl = document.getElementById('af-reservation-modal-subtitle');

  if (!modal || !form || !submitBtn || !accommodationField) {
    return;
  }

  var lastFocused = null;

  function esc(str) {
    var div = document.createElement('div');
    div.textContent = str || '';
    return div.innerHTML;
  }

  function showStatus(message, isError) {
    if (!statusEl) {
      return;
    }

    statusEl.className = 'af-reservation-status' + (isError ? ' is-error' : ' is-success');
    statusEl.innerHTML = message;
    statusEl.removeAttribute('hidden');
  }

  function hideStatus() {
    if (!statusEl) {
      return;
    }

    statusEl.setAttribute('hidden', 'hidden');
    statusEl.textContent = '';
    statusEl.className = 'af-reservation-status';
  }

  function setLoading(loading) {
    submitBtn.disabled = loading;
    submitBtn.textContent = loading ? (cfg.i18n && cfg.i18n.sending ? cfg.i18n.sending : 'Enviando...') : (cfg.i18n && cfg.i18n.submit ? cfg.i18n.submit : 'Confirmar reserva');
  }

  function openModal(trigger) {
    var accommodationId = parseInt(trigger.getAttribute('data-af-accommodation-id') || '0', 10);
    if (!accommodationId) {
      return;
    }

    lastFocused = trigger;
    hideStatus();
    form.reset();

    accommodationField.value = String(accommodationId);
    slotField.value = trigger.getAttribute('data-af-slot-id') || '';

    var title = trigger.getAttribute('data-af-accommodation-title') || '';
    if (titleEl) {
      titleEl.textContent = cfg.i18n && cfg.i18n.title ? cfg.i18n.title : 'Reservar visita';
    }
    if (accommodationEl) {
      accommodationEl.textContent = title ? 'Alojamiento: ' + title : 'Alojamiento: -';
    }
    if (subtitleEl) {
      subtitleEl.textContent = (cfg.i18n && cfg.i18n.subtitle) ? cfg.i18n.subtitle : 'Completa tus datos para reservar.';
    }

    modal.classList.add('af-reservation-modal--open');
    modal.setAttribute('aria-hidden', 'false');
    body.classList.add('af-modal-open');

    var first = form.querySelector('input[name="guest_name"]');
    var canAutoFocus = window.matchMedia && window.matchMedia('(min-width: 768px) and (pointer: fine)').matches;
    if (first && canAutoFocus) {
      first.focus();
    }
  }

  function closeModal() {
    modal.classList.remove('af-reservation-modal--open');
    modal.setAttribute('aria-hidden', 'true');
    body.classList.remove('af-modal-open');
    hideStatus();
    setLoading(false);

    if (lastFocused && typeof lastFocused.focus === 'function') {
      lastFocused.focus();
    }
  }

  function parseErrorMessage(payload, httpStatus) {
    var data = payload && payload.data ? payload.data : payload;
    var reason = data && data.reason_code ? String(data.reason_code) : '';
    var message = data && data.message ? String(data.message) : '';

    if (httpStatus === 409 || reason) {
      var availabilityMsg = cfg.i18n && cfg.i18n.conflict ? cfg.i18n.conflict : 'Ya no hay disponibilidad para ese horario. Elige otro horario o envianos una intencion de visita.';
      if (message) {
        availabilityMsg += '<br><small>Detalle: ' + esc(message) + (reason ? ' (' + esc(reason) + ')' : '') + '</small>';
      }
      return availabilityMsg;
    }

    if (message) {
      return esc(message);
    }

    return cfg.i18n && cfg.i18n.error ? cfg.i18n.error : 'No se pudo registrar tu reserva. Intenta de nuevo.';
  }

  function postAjax(data) {
    var fd = new FormData();
    Object.keys(data).forEach(function (key) {
      if (data[key] !== null && data[key] !== undefined && data[key] !== '') {
        fd.append(key, data[key]);
      }
    });

    return fetch(cfg.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body: fd,
    }).then(function (response) {
      return response.json()
        .catch(function () {
          return {};
        })
        .then(function (payload) {
          return {
            status: response.status,
            ok: response.ok,
            payload: payload,
          };
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
      showStatus(cfg.i18n && cfg.i18n.required ? cfg.i18n.required : 'Nombre y correo son obligatorios.', true);
      return;
    }

    setLoading(true);

    postAjax({
      action: 'af_create_reservation_intent',
      nonce: cfg.nonce,
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
        var msg = data.message || (cfg.i18n && cfg.i18n.success ? cfg.i18n.success : 'Solicitud enviada con exito.');

        if (status === 'visit_booked' && data.booking_id) {
          msg += '<br><small>Codigo de reserva: #' + esc(String(data.booking_id)) + '</small>';
        }

        showStatus(esc(msg), false);
        form.reset();

        window.setTimeout(function () {
          closeModal();
        }, 1800);
        return;
      }

      showStatus(parseErrorMessage(payload, result.status), true);
    }).catch(function () {
      setLoading(false);
      showStatus(cfg.i18n && cfg.i18n.network ? cfg.i18n.network : 'Error de red. Verifica tu conexion e intenta nuevamente.', true);
    });
  });

  document.addEventListener('click', function (event) {
    var trigger = event.target.closest('[data-af-reserve-trigger]');
    if (trigger) {
      event.preventDefault();
      openModal(trigger);
      return;
    }

    if (event.target.closest('[data-af-reserve-close]')) {
      event.preventDefault();
      closeModal();
      return;
    }

    if (modalBackdrop && event.target === modalBackdrop) {
      closeModal();
    }
  });

  closeButtons.forEach(function (btn) {
    btn.addEventListener('click', function (event) {
      event.preventDefault();
      closeModal();
    });
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !modal.hasAttribute('hidden')) {
      closeModal();
    }
  });
})();
