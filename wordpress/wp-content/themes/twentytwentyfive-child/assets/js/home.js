(function () {
  console.log('Home JS loaded');
  function qs(sel, root = document) { return root.querySelector(sel); }

  const root = qs('[data-home-showcase]');

  // Carousel of featured properties (wireframe)
  console.log('Initializing carousel');
  const slides = Array.from(root.querySelectorAll('[data-carousel-slide]'));
  const prevBtn = root.querySelector('[data-carousel-prev]');
  const nextBtn = root.querySelector('[data-carousel-next]');
  const dots = Array.from(root.querySelectorAll('[data-carousel-dot]'));

  let index = 0;

  const render = (i) => {
    index = (i + slides.length) % slides.length;

    slides.forEach((slide, slideIndex) => {
      slide.classList.toggle('is-active', slideIndex === index);
    });

    dots.forEach((dot, dotIndex) => {
      dot.classList.toggle('is-active', dotIndex === index);
      dot.setAttribute('aria-current', dotIndex === index ? 'true' : 'false');
    });
  };

  prevBtn?.addEventListener('click', () => {
    console.log('Prev clicked');
    render(index - 1)
  });
  nextBtn?.addEventListener('click', () => {
    console.log('Next clicked');
    render(index + 1)
  });

  dots.forEach((dot) => {
    dot.addEventListener('click', () => render(Number(dot.dataset.carouselDot || 0)));
  });

  render(0);
})();