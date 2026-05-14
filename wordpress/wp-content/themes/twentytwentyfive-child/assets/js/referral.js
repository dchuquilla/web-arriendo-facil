(function () {
  'use strict';

  var WHATSAPP_NUMBER = '';
  if (window.afReferral && window.afReferral.whatsapp) {
    WHATSAPP_NUMBER = window.afReferral.whatsapp.replace('+', '');
  } else if (window.afChatbot && window.afChatbot.whatsapp) {
    WHATSAPP_NUMBER = window.afChatbot.whatsapp.replace('+', '');
  }
  var WHATSAPP_MESSAGE = encodeURIComponent('Hola, quiero recomendar una propiedad para la plataforma y conocer cómo funciona el programa de recompensas.');

  var referralBtn = document.getElementById('referral-whatsapp-btn');

  if (!referralBtn) return;

  function initReferralButton() {
    if (WHATSAPP_NUMBER) {
      referralBtn.href = 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' + WHATSAPP_MESSAGE;
    } else {
      referralBtn.href = 'https://wa.me/?text=' + WHATSAPP_MESSAGE;
    }

    referralBtn.setAttribute('target', '_blank');
    referralBtn.setAttribute('rel', 'noopener noreferrer');

    referralBtn.addEventListener('click', function() {
      if (window.gtag) {
        gtag('event', 'referral_whatsapp_click', {
          'event_category': 'engagement',
          'event_label': 'referral_program'
        });
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
