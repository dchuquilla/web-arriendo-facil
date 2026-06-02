(function () {
  'use strict';

  function initHeader() {
    var header = document.getElementById('site-header');
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.querySelector('.nav');
    var ticking = false;

    if (!header || !nav) {
      return;
    }

    function getDirectMenuLink(li) {
      var first = li && li.firstElementChild;
      if (first && first.tagName === 'A') {
        return first;
      }

      return li && li.querySelector ? li.querySelector('a') : null;
    }

    function closeAllSubmenus() {
      nav.querySelectorAll('.menu-item.is-submenu-open').forEach(function (li) {
        li.classList.remove('is-submenu-open');
        var link = getDirectMenuLink(li);
        if (link) {
          link.setAttribute('aria-expanded', 'false');
        }
      });
    }

    function updateHeaderState() {
      header.classList.toggle('scrolled', window.scrollY > 50);
      ticking = false;
    }

    function onScroll() {
      if (ticking) {
        return;
      }

      ticking = true;
      window.requestAnimationFrame(updateHeaderState);
    }

    updateHeaderState();
    window.addEventListener('scroll', onScroll, { passive: true });

    if (toggle) {
      toggle.addEventListener('click', function (event) {
        event.stopPropagation();

        var isOpen = nav.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.classList.toggle('is-active', isOpen);

        if (!isOpen) {
          closeAllSubmenus();
        }
      });
    }

    document.addEventListener('click', function (event) {
      if (!toggle) {
        return;
      }

      if (nav.classList.contains('is-open') && !nav.contains(event.target) && !toggle.contains(event.target)) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.classList.remove('is-active');
        closeAllSubmenus();
      }
    });

    nav.addEventListener('click', function (event) {
      event.stopPropagation();
    });

    nav.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
      link.setAttribute('aria-haspopup', 'true');
      link.setAttribute('aria-expanded', 'false');

      link.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          link.click();
        }
      });
    });

    nav.addEventListener('click', function (event) {
      var link = event.target.closest('a');
      var parentLi;
      var submenu;
      var willOpen;

      if (!link || !nav.contains(link)) {
        return;
      }

      parentLi = link.parentElement;
      submenu = link.nextElementSibling;

      if (parentLi && parentLi.classList.contains('menu-item-has-children') && submenu && submenu.classList.contains('sub-menu')) {
        event.preventDefault();
        willOpen = !parentLi.classList.contains('is-submenu-open');

        Array.from(parentLi.parentElement ? parentLi.parentElement.children : []).forEach(function (li) {
          if (li !== parentLi && li.classList && li.classList.contains('menu-item') && li.classList.contains('is-submenu-open')) {
            li.classList.remove('is-submenu-open');

            var siblingLink = getDirectMenuLink(li);
            if (siblingLink) {
              siblingLink.setAttribute('aria-expanded', 'false');
            }
          }
        });

        parentLi.classList.toggle('is-submenu-open', willOpen);
        link.setAttribute('aria-expanded', String(willOpen));
        return;
      }

      nav.classList.remove('is-open');

      if (toggle) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.classList.remove('is-active');
      }

      closeAllSubmenus();
    });
  }

  function initScrollAnimations() {
    var animatedElements = document.querySelectorAll('[data-animate]');
    var isMobile = window.matchMedia && window.matchMedia('(max-width: 900px)').matches;
    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var shouldAnimate = !isMobile && !prefersReducedMotion && 'IntersectionObserver' in window;

    if (!animatedElements.length) {
      return;
    }

    if (!shouldAnimate) {
      animatedElements.forEach(function (element) {
        element.classList.add('is-visible');
      });
      return;
    }

    document.documentElement.classList.add('has-scroll-animations');

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -8% 0px' });

    animatedElements.forEach(function (element) {
      observer.observe(element);
    });
  }

  function init() {
    initHeader();
    initScrollAnimations();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();