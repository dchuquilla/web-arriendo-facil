(function() {
  'use strict';

  const carouselContainer = document.querySelector('[data-carousel-container]');
  if (!carouselContainer) return;

  const slides = Array.from(carouselContainer.querySelectorAll('[data-carousel-slide]'));
  const dots = Array.from(carouselContainer.querySelectorAll('[data-carousel-dot]'));
  const prevBtn = carouselContainer.querySelector('[data-carousel-prev]');
  const nextBtn = carouselContainer.querySelector('[data-carousel-next]');
  const blurBg = carouselContainer.querySelector('.carousel-blur-bg');

  if (slides.length === 0) return;

  let currentIndex = 0;

  function showSlide(index) {
    // Ensure index is within bounds with circular navigation
    currentIndex = (index + slides.length) % slides.length;

    // Hide all slides
    slides.forEach(slide => slide.classList.remove('is-active'));
    dots.forEach(dot => dot.classList.remove('is-active'));

    // Show current slide and dot
    slides[currentIndex].classList.add('is-active');
    if (dots[currentIndex]) {
      dots[currentIndex].classList.add('is-active');
      dots[currentIndex].setAttribute('aria-current', 'true');
      dots.forEach((dot, idx) => {
        if (idx !== currentIndex) {
          dot.setAttribute('aria-current', 'false');
        }
      });
    }

    // Update blur background image if available
    if (blurBg && singleCarouselData && singleCarouselData.images && singleCarouselData.images[currentIndex]) {
      const smallImageUrl = singleCarouselData.images[currentIndex].url_small;
      if (smallImageUrl) {
        blurBg.style.setProperty('--image-url', `url('${smallImageUrl}')`);
      }
    }
  }

  // Navigation event listeners
  if (prevBtn) {
    prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));
  }

  // Dot navigation
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => showSlide(index));
  });

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') showSlide(currentIndex - 1);
    if (e.key === 'ArrowRight') showSlide(currentIndex + 1);
  });

  // Initialize first slide
  showSlide(0);
})();
