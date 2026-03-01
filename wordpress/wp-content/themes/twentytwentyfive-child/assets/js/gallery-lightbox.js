/* global document, window */
(function () {
  'use strict';

  const GALLERY_SELECTOR = '.wp-block-gallery';

  const qs = (sel, root = document) => root.querySelector(sel);

  const buildLightbox = () => {
    const overlay = document.createElement('div');
    overlay.className = 'af-lightbox';
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.setAttribute('aria-hidden', 'true');

    const closeBtn = document.createElement('button');
    closeBtn.className = 'af-lightbox__close';
    closeBtn.type = 'button';
    closeBtn.setAttribute('aria-label', 'Cerrar');
    closeBtn.textContent = '×';

    const content = document.createElement('div');
    content.className = 'af-lightbox__content';

    const img = document.createElement('img');
    img.className = 'af-lightbox__img';
    img.alt = '';

    content.appendChild(img);
    overlay.appendChild(closeBtn);
    overlay.appendChild(content);

    return { overlay, closeBtn, img };
  };

  const { overlay, closeBtn, img } = buildLightbox();

  const mount = () => {
    if (!document.body) return;
    if (!document.body.contains(overlay)) {
      document.body.appendChild(overlay);
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mount);
  } else {
    mount();
  }

  const open = (src, alt) => {
    mount();
    img.src = src;
    img.alt = alt || '';

    overlay.classList.add('is-open');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.classList.add('is-lightbox-open');

    closeBtn.focus();
  };

  const close = () => {
    overlay.classList.remove('is-open');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('is-lightbox-open');

    img.removeAttribute('src');
  };

  const isOpen = () => overlay.classList.contains('is-open');

  // Click on gallery image opens lightbox
  document.addEventListener('click', (e) => {
    const gallery = e.target && e.target.closest ? e.target.closest(GALLERY_SELECTOR) : null;
    if (!gallery) return;

    const clickedImg = e.target && e.target.tagName === 'IMG' ? e.target : null;
    if (!clickedImg) return;

    // Prevent navigation if image is wrapped in a link
    const link = clickedImg.closest('a');
    if (link) e.preventDefault();

    const src = clickedImg.currentSrc || clickedImg.src;
    if (!src) return;

    open(src, clickedImg.alt);
  });

  // Close button
  closeBtn.addEventListener('click', () => close());

  // Click outside image closes
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) close();
  });

  // Esc closes
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen()) {
      e.preventDefault();
      close();
    }
  });
})();
