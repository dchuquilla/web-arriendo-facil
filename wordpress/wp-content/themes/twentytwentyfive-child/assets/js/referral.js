(function () {
  'use strict';

  var WHATSAPP_NUMBER = '';
  if (window.afReferral && window.afReferral.whatsapp) {
    WHATSAPP_NUMBER = window.afReferral.whatsapp.replace('+', '');
  } else if (window.afChatbot && window.afChatbot.whatsapp) {
    WHATSAPP_NUMBER = window.afChatbot.whatsapp.replace('+', '');
  }

  var referralBtn = document.getElementById('referral-whatsapp-btn');
  var nameInput = document.getElementById('referral-name');
  var errorEl = document.getElementById('referral-name-error');

  if (!referralBtn || !nameInput) return;

  var PROFANITY_LIST = [
    'puta', 'mierda', 'hijo de', 'cabron', 'cabrón', 'pendejo',
    'verga', 'culo', 'marica', 'joder', 'coño', 'idiota',
    'estupido', 'estúpido', 'imbecil', 'imbécil', 'malparido',
    'gonorrea', 'hp', 'hdp', 'ctm', 'ptm', 'fuck', 'shit',
    'bitch', 'ass', 'damn', 'bastard', 'maldita', 'maldito',
    'perra', 'zorra', 'maricon', 'maricón', 'huevon', 'huevón',
    'chucha', 'conchatumadre', 'vergon', 'cojudo', 'carajo',
    'putas', 'mierdas', 'pendejos', 'culero', 'pajero'
  ];

  var LEET_MAP = {
    '0': 'o', '1': 'i', '2': 'z', '3': 'e', '4': 'a',
    '5': 's', '6': 'g', '7': 't', '8': 'b', '9': 'g',
    '@': 'a', '$': 's', '!': 'i', '|': 'l', '+': 't',
    '(': 'c', ')': 'o', '{': 'c', '}': 'o', '[': 'c',
    ']': 'o', '<': 'c', '>': 'o', '/': 'l', '\\': 'l',
    '^': 'a', '*': 'a', '~': 'n', '#': 'h', '&': 'y'
  };

  function normalizeLeet(text) {
    var result = '';
    for (var i = 0; i < text.length; i++) {
      var ch = text[i].toLowerCase();
      result += LEET_MAP[ch] || ch;
    }
    return result
      .replace(/[áàäâ]/g, 'a')
      .replace(/[éèëê]/g, 'e')
      .replace(/[íìïî]/g, 'i')
      .replace(/[óòöô]/g, 'o')
      .replace(/[úùüû]/g, 'u')
      .replace(/ñ/g, 'n')
      .replace(/[^a-z\s]/g, '')
      .replace(/\s+/g, ' ')
      .trim();
  }

  function containsProfanity(text) {
    var normalized = normalizeLeet(text);
    var noSpaces = normalized.replace(/\s/g, '');

    for (var i = 0; i < PROFANITY_LIST.length; i++) {
      var word = normalizeLeet(PROFANITY_LIST[i]);
      if (normalized.indexOf(word) !== -1 || noSpaces.indexOf(word) !== -1) {
        return true;
      }
    }
    return false;
  }

  var INJECTION_PATTERNS = [
    /<[^>]*>/,
    /javascript:/i,
    /on\w+\s*=/i,
    /\{\{/,
    /\$\{/,
    /%3C/i,
    /%3E/i,
    /&#/,
    /\\/,
    /['";]/,
    /\b(select|insert|update|delete|drop|union|exec)\b/i,
    /http[s]?:\/\//i
  ];

  function sanitizeName(raw) {
    return raw.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-'\.]/g, '').trim();
  }

  function validateName(name) {
    if (!name || name.length < 2) {
      return 'Ingresa tu nombre (mínimo 2 caracteres).';
    }

    if (name.length > 60) {
      return 'El nombre es demasiado largo (máximo 60 caracteres).';
    }

    if (containsProfanity(name)) {
      return 'El nombre contiene contenido inapropiado.';
    }

    for (var j = 0; j < INJECTION_PATTERNS.length; j++) {
      if (INJECTION_PATTERNS[j].test(name)) {
        return 'El nombre contiene caracteres no permitidos.';
      }
    }

    if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]/.test(name)) {
      return 'El nombre debe contener al menos una letra.';
    }

    return null;
  }

  function showError(msg) {
    errorEl.textContent = msg;
    errorEl.hidden = false;
    nameInput.style.borderColor = '#e53e3e';
  }

  function clearError() {
    errorEl.hidden = true;
    errorEl.textContent = '';
    nameInput.style.borderColor = '';
  }

  function buildWhatsAppUrl(name) {
    var message = 'Hola, soy ' + name + ', quiero recomendar una propiedad para la plataforma, me gustaría saber cuál es su metodología de trabajo y cómo puedo ganar dinero.';
    var encoded = encodeURIComponent(message);

    if (WHATSAPP_NUMBER) {
      return 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' + encoded;
    }
    return 'https://wa.me/?text=' + encoded;
  }

  function initReferralButton() {
    referralBtn.classList.add('is-disabled');
    referralBtn.setAttribute('aria-disabled', 'true');
    referralBtn.setAttribute('tabindex', '-1');

    referralBtn.addEventListener('click', function(e) {
      e.preventDefault();

      if (referralBtn.classList.contains('is-disabled')) {
        nameInput.focus();
        return;
      }

      var rawValue = nameInput.value;
      var cleanName = sanitizeName(rawValue);
      var validationError = validateName(cleanName);

      if (validationError) {
        showError(validationError);
        nameInput.focus();
        return;
      }

      clearError();

      var url = buildWhatsAppUrl(cleanName);

      if (window.gtag) {
        gtag('event', 'referral_whatsapp_click', {
          'event_category': 'engagement',
          'event_label': 'referral_program'
        });
      }

      window.open(url, '_blank', 'noopener,noreferrer');

      nameInput.value = '';
      referralBtn.classList.add('is-disabled');
      referralBtn.setAttribute('aria-disabled', 'true');
      referralBtn.setAttribute('tabindex', '-1');
    });

    nameInput.addEventListener('input', function() {
      if (!errorEl.hidden) {
        clearError();
      }

      var clean = sanitizeName(this.value);
      var isValid = clean.length >= 2 && !validateName(clean);

      if (isValid) {
        referralBtn.classList.remove('is-disabled');
        referralBtn.removeAttribute('aria-disabled');
        referralBtn.removeAttribute('tabindex');
      } else {
        referralBtn.classList.add('is-disabled');
        referralBtn.setAttribute('aria-disabled', 'true');
        referralBtn.setAttribute('tabindex', '-1');
      }
    });
  }

  function initScrollAnimations() {
    var animatedElements = document.querySelectorAll('#recomendaciones [data-animate]');
    if (!animatedElements.length) return;

    if ('IntersectionObserver' in window) {
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

      animatedElements.forEach(function(el) { observer.observe(el); });
    } else {
      animatedElements.forEach(function(el) { el.classList.add('is-visible'); });
    }
  }

  function init() {
    initReferralButton();
    initScrollAnimations();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
