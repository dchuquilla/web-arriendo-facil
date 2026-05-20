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
  var nonce = wizard.getAttribute('data-nonce');

  var currentStep = 1;
  var totalSteps = panels.length;
  var isSubmitting = false;

  var MAX_FILE_SIZE = 5 * 1024 * 1024;

  function init() {
    prevBtn.addEventListener('click', goBack);
    nextBtn.addEventListener('click', goForward);
    submitBtn.addEventListener('click', submitForm);

    initFileUploads();
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
          if (file.size > MAX_FILE_SIZE) {
            showFieldError(input, 'El archivo excede el tamaño máximo de 5MB.');
            this.value = '';
            nameEl.textContent = '';
            labelEl.hidden = false;
            return;
          }
          if (file.type !== 'application/pdf') {
            showFieldError(input, 'Solo se permiten archivos PDF.');
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
      nextBtn.hidden = true;
      submitBtn.hidden = false;
    } else {
      nextBtn.hidden = false;
      submitBtn.hidden = true;
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
      var phone = panel.querySelector('#af-phone');

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

      if (phone.value && !isValidPhone(phone.value)) {
        showFieldError(phone, 'Ingresa un número de teléfono ecuatoriano válido.');
        valid = false;
      }
    }

    if (step === 3) {
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

    if (step === 4) {
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
      return validateCedula(clean);
    } else if (type === 'ruc') {
      return validateRUC(clean);
    } else if (type === 'pasaporte') {
      return number.trim().length >= 5 && number.trim().length <= 20;
    }
    return true;
  }

  function validateCedula(cedula) {
    if (cedula.length !== 10) return false;

    var province = parseInt(cedula.substring(0, 2), 10);
    if (province < 1 || province > 24) return false;

    var thirdDigit = parseInt(cedula[2], 10);
    if (thirdDigit > 5) return false;

    var coefficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    var total = 0;

    for (var i = 0; i < 9; i++) {
      var digit = parseInt(cedula[i], 10) * coefficients[i];
      if (digit > 9) digit -= 9;
      total += digit;
    }

    var checkDigit = (10 - (total % 10)) % 10;
    return checkDigit === parseInt(cedula[9], 10);
  }

  function validateRUC(ruc) {
    if (ruc.length !== 13) return false;
    if (!ruc.endsWith('001')) return false;

    var cedulaPart = ruc.substring(0, 10);
    var thirdDigit = parseInt(ruc[2], 10);

    if (thirdDigit <= 5) {
      return validateCedula(cedulaPart);
    } else if (thirdDigit === 6) {
      return ruc.length === 13;
    } else if (thirdDigit === 9) {
      return ruc.length === 13;
    }

    return false;
  }

  function getDocumentError(type) {
    if (type === 'cedula') return 'Cédula ecuatoriana inválida (10 dígitos, módulo 10).';
    if (type === 'ruc') return 'RUC inválido (13 dígitos terminando en 001).';
    if (type === 'pasaporte') return 'Pasaporte inválido (5-20 caracteres).';
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
      { label: 'Nombre', id: 'af-fullname' },
      { label: 'Email', id: 'af-email' },
      { label: 'Teléfono', id: 'af-phone' },
      { label: 'Tipo Propiedad', id: 'af-property-type-reg', isSelect: true },
      { label: 'Observaciones', id: 'af-message' },
      { label: 'Rep. Legal', id: 'af-legal-name' },
      { label: 'Tel. Rep. Legal', id: 'af-legal-phone' },
      { label: 'Email Rep. Legal', id: 'af-legal-email' },
    ];

    var html = '<dl class="af-summary-list">';
    fields.forEach(function (f) {
      var el = document.getElementById(f.id);
      if (!el) return;
      var val = f.isSelect ? (el.options[el.selectedIndex] ? el.options[el.selectedIndex].text : '') : el.value.trim();
      if (!val || val === 'Seleccionar...') return;
      html += '<dt>' + escHtml(f.label) + '</dt><dd>' + escHtml(val) + '</dd>';
    });

    var files = [
      { label: 'Poder Notarial', id: 'af-legal-pdf' },
      { label: 'Cédula PDF', id: 'af-doc-cedula' },
      { label: 'RUC PDF', id: 'af-doc-ruc' },
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

    var textFields = ['id_type', 'id_number', 'fullname', 'email', 'phone',
      'property_type_interest', 'message', 'legal_agent_name',
      'legal_agent_phone', 'legal_agent_email'];

    textFields.forEach(function (name) {
      var el = wizard.querySelector('[name="' + name + '"]');
      if (el) formData.append(name, el.value.trim());
    });

    var fileFields = ['legal_agent_pdf', 'doc_cedula', 'doc_ruc'];
    fileFields.forEach(function (name) {
      var el = wizard.querySelector('[name="' + name + '"]');
      if (el && el.files.length) formData.append(name, el.files[0]);
    });

    var apiUrl = (window.afOwnerReg && window.afOwnerReg.apiUrl)
      ? window.afOwnerReg.apiUrl
      : '/wp-json/af/v1/owner-register';

    fetch(apiUrl, {
      method: 'POST',
      body: formData,
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showFeedback('success', data.message || 'Tu solicitud ha sido enviada exitosamente. Te contactaremos en 24-48 horas.');
          wizard.querySelector('.af-wizard__nav').hidden = true;
          panels.forEach(function (p) { p.classList.remove('is-active'); });
        } else {
          showFeedback('error', data.message || 'Ocurrió un error al enviar tu solicitud. Intenta de nuevo.');
          isSubmitting = false;
          submitBtn.disabled = false;
          submitBtn.textContent = 'Enviar Solicitud';
        }
      })
      .catch(function () {
        showFeedback('error', 'Error de conexión. Verifica tu internet e intenta de nuevo.');
        isSubmitting = false;
        submitBtn.disabled = false;
        submitBtn.textContent = 'Enviar Solicitud';
      });
  }

  function showFeedback(type, message) {
    feedbackEl.className = 'af-wizard__feedback af-wizard__feedback--' + type;
    feedbackEl.textContent = message;
    feedbackEl.hidden = false;
    feedbackEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
