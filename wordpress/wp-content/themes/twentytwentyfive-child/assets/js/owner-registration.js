(function () {
  'use strict';

  var wizard = document.querySelector('.af-wizard');
  if (!wizard) return;

  var panels = wizard.querySelectorAll('.af-wizard__panel');
  var steps = wizard.querySelectorAll('.af-wizard__step');
  var progressBar = wizard.querySelector('.af-wizard__progress-bar');
  var prevBtn = wizard.querySelector('.af-wizard__prev');
  var nextBtn = wizard.querySelector('.af-wizard__next');
  var submitBtn = wizard.querySelector('.af-wizard__submit');
  var feedbackEl = document.getElementById('af-wizard-feedback');
  var summaryEl = document.getElementById('af-wizard-summary');
  var nonce = (window.afOwnerRegister && window.afOwnerRegister.nonce) || '';

  var currentStep = 1;
  var totalSteps = panels.length;
  var isSubmitting = false;

  var MAX_FILE_SIZE = 5 * 1024 * 1024;

  function init() {
    prevBtn.addEventListener('click', goBack);
    nextBtn.addEventListener('click', goForward);
    submitBtn.addEventListener('click', submitForm);

    submitBtn.style.display = 'none';

    initFileUploads();
    initLegalAgentToggle();
    initModals();
    updateNav();
  }

  function initFileUploads() {
    var uploads = wizard.querySelectorAll('.af-file-upload');
    uploads.forEach(function (el) {
      var input = el.querySelector('input[type="file"]');
      var nameEl = el.querySelector('.af-file-upload__name');
      var labelEl = el.querySelector('.af-file-upload__label');

      input.addEventListener('change', function () {
        if (this.files.length) {
          var file = this.files[0];
          var isDocx = input.accept && input.accept.indexOf('.docx') !== -1;
          var maxSize = MAX_FILE_SIZE;

          if (file.size > maxSize) {
            showFieldError(input, 'El archivo excede el tamaño máximo de 5MB.');
            this.value = '';
            nameEl.textContent = '';
            labelEl.hidden = false;
            return;
          }

          if (!isDocx && file.type !== 'application/pdf') {
            showFieldError(input, 'Solo se permiten archivos PDF.');
            this.value = '';
            nameEl.textContent = '';
            labelEl.hidden = false;
            return;
          }

          if (isDocx && file.type !== 'application/pdf' &&
              file.type !== 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' &&
              file.type !== 'application/msword') {
            showFieldError(input, 'Solo se permiten archivos PDF o Word (.docx).');
            this.value = '';
            nameEl.textContent = '';
            labelEl.hidden = false;
            return;
          }

          clearFieldError(input);
          nameEl.textContent = file.name;
          labelEl.hidden = true;
        } else {
          nameEl.textContent = '';
          labelEl.hidden = false;
        }
      });
    });
  }

  function initLegalAgentToggle() {
    var radios = wizard.querySelectorAll('input[name="has_legal_agent"]');
    var fieldsContainer = document.getElementById('af-legal-fields');

    radios.forEach(function (radio) {
      radio.addEventListener('change', function () {
        if (this.value === 'yes') {
          fieldsContainer.hidden = false;
        } else {
          fieldsContainer.hidden = true;
        }
      });
    });
  }

  function initModals() {
    var triggers = document.querySelectorAll('.af-modal-trigger');
    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault();
        var modalId = this.getAttribute('data-modal');
        var modal = document.getElementById(modalId);
        if (modal) {
          modal.hidden = false;
          var body = modal.querySelector('.af-modal__body');
          if (body) body.scrollTop = 0;
          document.body.style.overflow = 'hidden';
        }
      });
    });

    var modals = document.querySelectorAll('.af-modal');
    modals.forEach(function (modal) {
      var closeBtn = modal.querySelector('.af-modal__close');
      var backdrop = modal.querySelector('.af-modal__backdrop');

      closeBtn.addEventListener('click', function () {
        modal.hidden = true;
        document.body.style.overflow = '';
      });

      backdrop.addEventListener('click', function () {
        modal.hidden = true;
        document.body.style.overflow = '';
      });
    });
  }

  function goForward() {
    if (!validateStep(currentStep)) return;
    if (currentStep < totalSteps) {
      currentStep++;
      if (currentStep === totalSteps) buildSummary();
      showStep(currentStep);
    }
  }

  function goBack() {
    if (currentStep > 1) {
      currentStep--;
      showStep(currentStep);
    }
  }

  function showStep(step) {
    panels.forEach(function (p) { p.classList.remove('is-active'); });
    steps.forEach(function (s) { s.classList.remove('is-active', 'is-completed'); });

    panels[step - 1].classList.add('is-active');

    for (var i = 0; i < step; i++) {
      if (i < step - 1) steps[i].classList.add('is-completed');
      else steps[i].classList.add('is-active');
    }

    progressBar.style.width = ((step / totalSteps) * 100) + '%';
    wizard.querySelector('.af-wizard__progress').setAttribute('aria-valuenow', step);
    updateNav();

    panels[step - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function updateNav() {
    prevBtn.disabled = currentStep === 1;
    if (currentStep === totalSteps) {
      nextBtn.style.display = 'none';
      submitBtn.style.display = '';
    } else {
      nextBtn.style.display = '';
      submitBtn.style.display = 'none';
    }
  }

  function validateStep(step) {
    var panel = panels[step - 1];
    var valid = true;

    var inputs = panel.querySelectorAll('input[required], select[required], textarea[required]');
    inputs.forEach(function (input) {
      if (!validateField(input)) valid = false;
    });

    if (step === 1) {
      var idType = panel.querySelector('#af-id-type');
      var idNumber = panel.querySelector('#af-id-number');
      var email = panel.querySelector('#af-email');

      if (idType.value && idNumber.value) {
        if (!validateDocumentNumber(idType.value, idNumber.value)) {
          showFieldError(idNumber, getDocumentError(idType.value));
          valid = false;
        }
      }

      if (email.value && !isValidEmail(email.value)) {
        showFieldError(email, 'Ingresa un correo electrónico válido.');
        valid = false;
      }
    }

    if (step === 2) {
      var hasAgent = wizard.querySelector('input[name="has_legal_agent"]:checked');
      if (hasAgent && hasAgent.value === 'yes') {
        var legalEmail = panel.querySelector('#af-legal-email');
        var legalPhone = panel.querySelector('#af-legal-phone');
        if (legalEmail.value && !isValidEmail(legalEmail.value)) {
          showFieldError(legalEmail, 'Ingresa un correo electrónico válido.');
          valid = false;
        }
        if (legalPhone.value && !isValidPhone(legalPhone.value)) {
          showFieldError(legalPhone, 'Ingresa un número de teléfono válido.');
          valid = false;
        }
      }
    }

    if (step === 3) {
      var terms = panel.querySelector('#af-terms');
      if (!terms.checked) {
        showFieldError(terms, 'Debes aceptar los términos y condiciones.');
        valid = false;
      }
    }

    return valid;
  }

  function validateField(input) {
    clearFieldError(input);

    if (input.type === 'checkbox') {
      if (input.required && !input.checked) {
        showFieldError(input, 'Este campo es obligatorio.');
        return false;
      }
      return true;
    }

    if (input.type === 'file') {
      if (input.required && !input.files.length) {
        showFieldError(input, 'Este archivo es obligatorio.');
        return false;
      }
      return true;
    }

    var value = input.value.trim();
    if (input.required && !value) {
      showFieldError(input, 'Este campo es obligatorio.');
      return false;
    }

    return true;
  }

  function validateDocumentNumber(type, number) {
    var clean = number.replace(/[^0-9]/g, '');

    if (type === 'cedula') {
      return clean.length === 10;
    } else if (type === 'ruc') {
      return validateRUC(clean);
    } else if (type === 'pasaporte') {
      return number.trim().length >= 5 && number.trim().length <= 15;
    }
    return true;
  }

  function validateRUC(ruc) {
    if (ruc.length !== 13) return false;
    if (!ruc.endsWith('001')) return false;
    return true;
  }

  function getDocumentError(type) {
    if (type === 'cedula') return 'La cédula debe tener exactamente 10 dígitos.';
    if (type === 'ruc') return 'RUC inválido (13 dígitos terminando en 001).';
    if (type === 'pasaporte') return 'Pasaporte inválido (5-15 caracteres).';
    return 'Documento inválido.';
  }

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function isValidPhone(phone) {
    var clean = phone.replace(/[\s\-\(\)]/g, '');
    return /^(09\d{8}|0[2-7]\d{7})$/.test(clean) || /^(\+593\d{9})$/.test(clean);
  }

  function showFieldError(input, message) {
    var group = input.closest('.af-form-group') || input.closest('.af-form-group--full') || input.parentNode;
    var errorEl = group.querySelector('.af-form-error');
    if (errorEl) {
      errorEl.textContent = message;
      errorEl.hidden = false;
    }
    if (input.type !== 'checkbox' && input.type !== 'file') {
      input.classList.add('is-error');
    }
  }

  function clearFieldError(input) {
    var group = input.closest('.af-form-group') || input.closest('.af-form-group--full') || input.parentNode;
    var errorEl = group.querySelector('.af-form-error');
    if (errorEl) {
      errorEl.textContent = '';
      errorEl.hidden = true;
    }
    input.classList.remove('is-error');
  }

  function buildSummary() {
    var fields = [
      { label: 'Tipo Documento', id: 'af-id-type', isSelect: true },
      { label: 'Número Documento', id: 'af-id-number' },
      { label: 'Nombre del Cliente', id: 'af-client-name' },
      { label: 'Email', id: 'af-email' },
      { label: 'Observaciones', id: 'af-observations' },
    ];

    var html = '<dl class="af-summary-list">';
    fields.forEach(function (f) {
      var el = document.getElementById(f.id);
      if (!el) return;
      var val = f.isSelect ? (el.options[el.selectedIndex] ? el.options[el.selectedIndex].text : '') : el.value.trim();
      if (!val || val === 'Seleccionar...') return;
      html += '<dt>' + escHtml(f.label) + '</dt><dd>' + escHtml(val) + '</dd>';
    });

    var hasAgent = wizard.querySelector('input[name="has_legal_agent"]:checked');
    if (hasAgent && hasAgent.value === 'yes') {
      html += '<dt>Representante Legal</dt><dd>Sí</dd>';
      var legalFields = [
        { label: 'Nombre Rep. Legal', id: 'af-legal-name' },
        { label: 'Doc. Rep. Legal', id: 'af-legal-id-number' },
        { label: 'Tel. Rep. Legal', id: 'af-legal-phone' },
        { label: 'Email Rep. Legal', id: 'af-legal-email' },
      ];
      legalFields.forEach(function (f) {
        var el = document.getElementById(f.id);
        if (!el || !el.value.trim()) return;
        html += '<dt>' + escHtml(f.label) + '</dt><dd>' + escHtml(el.value.trim()) + '</dd>';
      });
    }

    var files = [
      { label: 'Servicios Básicos', id: 'af-doc-servicios' },
      { label: 'Documentos Identidad', id: 'af-doc-identidad' },
      { label: 'Contratos', id: 'af-doc-contratos' },
      { label: 'Ejemplo Contrato', id: 'af-doc-contrato-ejemplo' },
    ];
    files.forEach(function (f) {
      var el = document.getElementById(f.id);
      if (el && el.files.length) {
        html += '<dt>' + escHtml(f.label) + '</dt><dd>' + escHtml(el.files[0].name) + '</dd>';
      }
    });

    html += '</dl>';
    summaryEl.innerHTML = html;
  }

  function submitForm() {
    if (isSubmitting) return;
    isSubmitting = true;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enviando...';

    var formData = new FormData();
    formData.append('nonce', nonce);

    var textFields = ['id_type', 'id_number', 'client_name', 'email',
      'has_legal_agent', 'observations'];

    textFields.forEach(function (name) {
      var el = wizard.querySelector('[name="' + name + '"]');
      if (el) {
        if (el.type === 'radio') {
          var checked = wizard.querySelector('[name="' + name + '"]:checked');
          if (checked) formData.append(name, checked.value);
        } else {
          formData.append(name, el.value.trim());
        }
      }
    });

    var hasAgent = wizard.querySelector('input[name="has_legal_agent"]:checked');
    if (hasAgent && hasAgent.value === 'yes') {
      var legalTextFields = ['legal_agent_name', 'legal_agent_id_type',
        'legal_agent_id_number', 'legal_agent_phone', 'legal_agent_email'];
      legalTextFields.forEach(function (name) {
        var el = wizard.querySelector('[name="' + name + '"]');
        if (el) formData.append(name, el.value.trim());
      });
    }

    var fileFields = ['doc_servicios_basicos', 'doc_identidad', 'doc_contratos', 'doc_contrato_ejemplo'];
    fileFields.forEach(function (name) {
      var el = wizard.querySelector('[name="' + name + '"]');
      if (el && el.files.length) formData.append(name, el.files[0]);
    });

    var apiUrl = (window.afOwnerRegister && window.afOwnerRegister.endpoint)
      ? window.afOwnerRegister.endpoint
      : '/wp-json/af/v1/owner-register';

    var headers = {};
    if (window.afOwnerRegister && window.afOwnerRegister.restNonce) {
      headers['X-WP-Nonce'] = window.afOwnerRegister.restNonce;
    }

    fetch(apiUrl, {
      method: 'POST',
      headers: headers,
      body: formData,
      credentials: 'same-origin',
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showResult('success', data.message || 'Registro exitoso. Revisa tu correo electrónico para activar tu cuenta.');
        } else {
          showResult('error', data.message || 'Ocurrió un error al enviar tu solicitud.');
        }
      })
      .catch(function () {
        showResult('error', 'Error de conexión. Verifica tu internet e intenta de nuevo.');
      });
  }

  function showResult(type, message) {
    panels.forEach(function (p) { p.classList.remove('is-active'); });
    wizard.querySelector('.af-wizard__nav').style.display = 'none';

    var icon = type === 'success'
      ? '<svg class="af-result-icon af-result-icon--success" viewBox="0 0 52 52"><circle cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M14 27l7 7 16-16"/></svg>'
      : '<svg class="af-result-icon af-result-icon--error" viewBox="0 0 52 52"><circle cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" d="M16 16l20 20M36 16l-20 20"/></svg>';

    var btnHtml = type === 'success'
      ? '<a href="/" class="btn btn--primary af-result-btn">Volver</a>'
      : '<button type="button" class="btn btn--primary af-result-btn" id="af-retry-btn">Volver a intentar</button>';

    feedbackEl.className = 'af-wizard__feedback af-wizard__feedback--' + type;
    feedbackEl.innerHTML = icon + '<p class="af-result-message">' + escHtml(message) + '</p>' + btnHtml;
    feedbackEl.hidden = false;
    feedbackEl.scrollIntoView({ behavior: 'smooth', block: 'center' });

    if (type === 'error') {
      var retryBtn = document.getElementById('af-retry-btn');
      retryBtn.addEventListener('click', function () {
        feedbackEl.hidden = true;
        wizard.querySelector('.af-wizard__nav').style.display = '';
        isSubmitting = false;
        submitBtn.disabled = false;
        submitBtn.textContent = 'Enviar Solicitud';
        currentStep = 1;
        showStep(1);
      });
    }
  }

  function escHtml(str) {
    var div = document.createElement('div');
    div.textContent = str || '';
    return div.innerHTML;
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
