(function () {
  'use strict';

  function initFlipCards() {
    var cards = document.querySelectorAll('[data-flip]');
    if (!cards.length) {
      return;
    }

    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function setFlipped(card, flipped) {
      card.classList.toggle('is-flipped', flipped);
      card.setAttribute('aria-pressed', flipped ? 'true' : 'false');
    }

    function flipCard(card) {
      var isFlipped = card.classList.contains('is-flipped');
      cards.forEach(function (other) {
        setFlipped(other, false);
      });
      setFlipped(card, !isFlipped);
    }

    cards.forEach(function (card) {
      card.setAttribute('role', 'button');
      card.setAttribute('tabindex', '0');
      card.setAttribute('aria-pressed', 'false');

      card.addEventListener('click', function (event) {
        if (event.target.closest('a[href], button')) {
          return;
        }
        flipCard(card);
      });

      card.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          flipCard(card);
        }
      });
    });

    if (prefersReducedMotion) {
      document.documentElement.classList.add('has-reduced-motion');
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFlipCards, { once: true });
  } else {
    initFlipCards();
  }
})();