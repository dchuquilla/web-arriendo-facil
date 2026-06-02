(function() {
  'use strict';

  var carousel = document.querySelector('[data-flip-carousel]');
  if (!carousel) return;

  var track = carousel.querySelector('[data-flip-track]');
  var cards = Array.from(carousel.querySelectorAll('[data-flip-card]'));
  var prevBtn = carousel.querySelector('[data-flip-prev]');
  var nextBtn = carousel.querySelector('[data-flip-next]');

  if (cards.length === 0) return;

  var currentIndex = 0;
  var cardWidth = 0;
  var visibleCards = 3;
  var maxIndex = 0;

  var startX = 0;
  var startY = 0;
  var deltaX = 0;
  var isDragging = false;
  var isHorizontal = null;
  var dragRafId = null;
  var resizeRafId = null;

  function calculateDimensions() {
    var gap = parseFloat(getComputedStyle(track).gap) || 20;
    cardWidth = cards[0].offsetWidth + gap;
    var viewportWidth = carousel.offsetWidth;
    visibleCards = viewportWidth <= 600 ? 1 : viewportWidth <= 900 ? 2 : 3;
    maxIndex = Math.max(0, cards.length - visibleCards);
    currentIndex = Math.min(currentIndex, maxIndex);

    // Center track when cards don't fill the viewport
    if (cards.length <= visibleCards) {
      var totalWidth = (cards.length * cardWidth) - gap;
      var offset = (viewportWidth - totalWidth) / 2;
      track.style.paddingLeft = Math.max(0, offset) + 'px';
    } else {
      track.style.paddingLeft = '0px';
    }

    applyTransform(false);
  }

  function applyTransform(animate) {
    if (animate) {
      track.style.transition = 'transform 400ms cubic-bezier(0.4, 0, 0.2, 1)';
    } else {
      track.style.transition = 'none';
    }
    track.style.transform = 'translateX(' + (-(currentIndex * cardWidth) + deltaX) + 'px)';
  }

  function scheduleDragTransform() {
    if (dragRafId) return;
    dragRafId = window.requestAnimationFrame(function() {
      dragRafId = null;
      track.style.transform = 'translateX(' + (-(currentIndex * cardWidth) + deltaX) + 'px)';
    });
  }

  function resetFlippedCards() {
    cards.forEach(function(card) {
      card.classList.remove('is-flipped');
    });
  }

  function slideTo(index) {
    currentIndex = Math.max(0, Math.min(index, maxIndex));
    deltaX = 0;
    resetFlippedCards();
    applyTransform(true);
  }

  // --- Button Navigation ---
  if (prevBtn) {
    prevBtn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      slideTo(currentIndex - 1);
    });
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      slideTo(currentIndex + 1);
    });
  }

  // --- Touch/Pointer Swipe ---
  track.addEventListener('touchstart', function(e) {
    if (e.touches.length !== 1) return;
    isDragging = true;
    isHorizontal = null;
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
    deltaX = 0;
    track.style.transition = 'none';
  }, { passive: true });

  track.addEventListener('touchmove', function(e) {
    if (!isDragging || e.touches.length !== 1) return;

    var dx = e.touches[0].clientX - startX;
    var dy = e.touches[0].clientY - startY;

    if (isHorizontal === null) {
      if (Math.abs(dx) > 8 || Math.abs(dy) > 8) {
        isHorizontal = Math.abs(dx) > Math.abs(dy);
      }
      return;
    }

    if (!isHorizontal) return;

    e.preventDefault();
    deltaX = dx;
    track.style.transform = 'translateX(' + (-(currentIndex * cardWidth) + deltaX) + 'px)';
  }, { passive: false });

  track.addEventListener('touchend', function() {
    if (!isDragging) return;
    isDragging = false;

    if (!isHorizontal) {
      deltaX = 0;
      return;
    }

    var threshold = cardWidth * 0.2;
    if (deltaX > threshold) {
      slideTo(currentIndex - 1);
    } else if (deltaX < -threshold) {
      slideTo(currentIndex + 1);
    } else {
      deltaX = 0;
      applyTransform(true);
    }
  });

  // --- Mouse drag (desktop) ---
  track.addEventListener('mousedown', function(e) {
    if (e.button !== 0) return;
    isDragging = true;
    isHorizontal = true;
    startX = e.clientX;
    deltaX = 0;
    track.style.transition = 'none';
    track.style.cursor = 'grabbing';
    e.preventDefault();
  });

  document.addEventListener('mousemove', function(e) {
    if (!isDragging || !isHorizontal) return;
    deltaX = e.clientX - startX;
    scheduleDragTransform();
  });

  document.addEventListener('mouseup', function() {
    if (!isDragging) return;
    isDragging = false;
    track.style.cursor = '';

    var threshold = cardWidth * 0.2;
    if (deltaX > threshold) {
      slideTo(currentIndex - 1);
    } else if (deltaX < -threshold) {
      slideTo(currentIndex + 1);
    } else {
      deltaX = 0;
      applyTransform(true);
    }
  });

  // --- Tap to flip on mobile ---
  var tapStartX = 0;
  var tapOnClose = false;
  cards.forEach(function(card) {
    var closeBtn = card.querySelector('.flip-card__close');

    card.addEventListener('touchstart', function(e) {
      tapOnClose = closeBtn && closeBtn.contains(e.target);
      tapStartX = e.touches[0].clientX;
    }, { passive: true });

    card.addEventListener('touchend', function(e) {
      if (tapOnClose) return;
      var dx = Math.abs(e.changedTouches[0].clientX - tapStartX);
      if (dx < 10 && window.innerWidth <= 900) {
        card.classList.remove('is-closed');
        card.classList.toggle('is-flipped');
      }
    });

    // Re-enable hover when mouse leaves card
    card.addEventListener('mouseleave', function() {
      card.classList.remove('is-closed');
    });

    // Close button on back face
    if (closeBtn) {
      closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        card.classList.remove('is-flipped');
        card.classList.add('is-closed');
      });
      closeBtn.addEventListener('touchend', function(e) {
        e.preventDefault();
        e.stopPropagation();
        card.classList.remove('is-flipped');
        card.classList.add('is-closed');
      });
      closeBtn.addEventListener('touchstart', function(e) {
        e.stopPropagation();
      }, { passive: false });
    }
  });

  // --- Init ---
  calculateDimensions();
  window.addEventListener('resize', function() {
    if (resizeRafId) return;
    resizeRafId = window.requestAnimationFrame(function() {
      resizeRafId = null;
      calculateDimensions();
    });
  });
})();
