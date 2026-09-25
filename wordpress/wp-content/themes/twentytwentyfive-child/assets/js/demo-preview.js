/**
 * Arriendo Fácil — Vista previa del panel (modo demo).
 * Control del modal "¿Deseas comenzar a ocuparlo?" y del ribbon.
 */
(function () {
  'use strict';

  var modal = document.getElementById('af-demo-modal');
  if (!modal) {
    return;
  }

  var openTriggers = document.querySelectorAll('[data-af-demo-open]');
  var closeTriggers = document.querySelectorAll('[data-af-demo-close]');
  var backdrop = modal.querySelector('.af-demo-modal__backdrop');
  var lastFocused = null;

  function openModal() {
    lastFocused = document.activeElement;
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    var focusTarget = modal.querySelector('.af-demo-modal__primary, .af-demo-modal__close');
    if (focusTarget) {
      focusTarget.focus();
    }
    var event = new Event('af-demo-modal:open', { bubbles: true });
    modal.dispatchEvent(event);
  }

  function closeModal() {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (lastFocused) {
      lastFocused.focus();
    }
  }

  function handleKeydown(e) {
    if (e.key === 'Escape') {
      closeModal();
    }
    if (e.key === 'Tab') {
      var focusables = Array.prototype.slice.call(
        modal.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])')
      );
      if (!focusables.length) {
        return;
      }
      var first = focusables[0];
      var last = focusables[focusables.length - 1];
      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }
  }

  Array.prototype.forEach.call(openTriggers, function (trigger) {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      openModal();
    });
  });

  Array.prototype.forEach.call(closeTriggers, function (trigger) {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      closeModal();
    });
  });

  if (backdrop) {
    backdrop.addEventListener('click', closeModal);
  }

  document.addEventListener('keydown', handleKeydown);

  // Mostrar el modal poco después de cargar la página (vista previa, no intrusivo).
  var loadDelay = parseInt(modal.getAttribute('data-af-demo-delay') || '3500', 10);
  var shown = sessionStorage.getItem('af-demo-modal-shown');
  if (!shown) {
    window.setTimeout(function () {
      openModal();
    }, loadDelay);
  } else {
    modal.setAttribute('aria-hidden', 'true');
  }
})();