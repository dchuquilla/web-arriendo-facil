(function () {
  'use strict';

  function initGlobalLoadingScreen() {
    var loader = document.getElementById('af-loading-screen');
    var textEl = loader ? loader.querySelector('.af-loading-screen__text') : null;
    var showTimer = null;
    var hideTimer = null;
    var lastShownAt = 0;
    var minVisibleMs = 220;
    var pendingAsyncRequests = 0;

    if (!loader || !document.body) {
      return;
    }

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      minVisibleMs = 0;
    }

    function setText(nextText) {
      if (textEl && nextText) {
        textEl.textContent = nextText;
      }
    }

    function clearShowTimer() {
      if (showTimer) {
        window.clearTimeout(showTimer);
        showTimer = null;
      }
    }

    function clearHideTimer() {
      if (hideTimer) {
        window.clearTimeout(hideTimer);
        hideTimer = null;
      }
    }

    function showNow(nextText) {
      clearHideTimer();

      if (nextText) {
        setText(nextText);
      }

      if (loader.classList.contains('is-visible')) {
        return;
      }

      loader.hidden = false;
      loader.setAttribute('aria-hidden', 'false');
      document.body.classList.add('af-is-loading');
      lastShownAt = Date.now();

      window.requestAnimationFrame(function () {
        loader.classList.add('is-visible');
      });
    }

    function hideNow() {
      clearShowTimer();
      loader.classList.remove('is-visible');
      loader.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('af-is-loading');

      clearHideTimer();
      hideTimer = window.setTimeout(function () {
        if (!loader.classList.contains('is-visible')) {
          loader.hidden = true;
        }
      }, 180);
    }

    function hideRespectingMinimum() {
      var elapsed = Date.now() - lastShownAt;
      var remaining = minVisibleMs - elapsed;

      if (!loader.classList.contains('is-visible')) {
        hideNow();
        return;
      }

      if (remaining > 0) {
        clearHideTimer();
        hideTimer = window.setTimeout(hideNow, remaining);
        return;
      }

      hideNow();
    }

    function showDelayed(nextText, delayMs) {
      var wait = typeof delayMs === 'number' ? delayMs : 140;
      clearShowTimer();
      showTimer = window.setTimeout(function () {
        showNow(nextText);
      }, wait);
    }

    function getRequestUrl(input) {
      if (!input) {
        return '';
      }

      if (typeof input === 'string') {
        return input;
      }

      if (typeof input.url === 'string') {
        return input.url;
      }

      return '';
    }

    function isLikelyStaticAsset(pathname) {
      return /\.(?:css|js|png|jpe?g|gif|webp|avif|svg|ico|woff2?|ttf|eot|mp4|webm|pdf)$/i.test(pathname);
    }

    function shouldTrackRequest(urlValue, methodValue) {
      var method = (methodValue || 'GET').toUpperCase();
      var parsed;

      if (!urlValue) {
        return false;
      }

      try {
        parsed = new URL(urlValue, window.location.href);
      } catch (error) {
        return false;
      }

      if (parsed.origin !== window.location.origin) {
        return false;
      }

      // Skip static assets to avoid unnecessary overlays and preserve smoothness.
      if (isLikelyStaticAsset(parsed.pathname)) {
        return false;
      }

      if (parsed.pathname.indexOf('/wp-json/') === 0 || parsed.pathname.indexOf('/wp-admin/admin-ajax.php') === 0) {
        return true;
      }

      return method !== 'GET';
    }

    function beginAsyncRequest() {
      pendingAsyncRequests += 1;

      if (pendingAsyncRequests === 1) {
        showDelayed('Cargando datos...', 180);
      }
    }

    function endAsyncRequest() {
      if (pendingAsyncRequests > 0) {
        pendingAsyncRequests -= 1;
      }

      if (pendingAsyncRequests === 0) {
        hideRespectingMinimum();
      }
    }

    function installFetchTracking() {
      var nativeFetch = window.fetch;

      if (typeof nativeFetch !== 'function') {
        return;
      }

      window.fetch = function (input, init) {
        var urlValue = getRequestUrl(input);
        var methodValue = init && init.method ? init.method : (input && input.method ? input.method : 'GET');
        var shouldTrack = shouldTrackRequest(urlValue, methodValue);
        var fetchPromise;

        if (shouldTrack) {
          beginAsyncRequest();
        }

        try {
          fetchPromise = nativeFetch.call(this, input, init);
        } catch (error) {
          if (shouldTrack) {
            endAsyncRequest();
          }
          throw error;
        }

        if (shouldTrack && fetchPromise) {
          if (typeof fetchPromise.finally === 'function') {
            fetchPromise.finally(endAsyncRequest);
          } else {
            // Older mobile browsers may not implement Promise.finally.
            Promise.resolve(fetchPromise).then(endAsyncRequest, endAsyncRequest);
          }
        }

        return fetchPromise;
      };
    }

    function installXhrTracking() {
      var OriginalXHR = window.XMLHttpRequest;

      if (typeof OriginalXHR !== 'function') {
        return;
      }

      function TrackedXHR() {
        var xhr = new OriginalXHR();
        var tracked = false;
        var settled = false;
        var requestUrl = '';
        var requestMethod = 'GET';

        var originalOpen = xhr.open;
        xhr.open = function (method, url) {
          requestMethod = method || 'GET';
          requestUrl = url || '';
          return originalOpen.apply(xhr, arguments);
        };

        var originalSend = xhr.send;
        xhr.send = function () {
          tracked = shouldTrackRequest(requestUrl, requestMethod);

          if (tracked) {
            beginAsyncRequest();
          }

          xhr.addEventListener('loadend', function onLoadEnd() {
            if (settled) {
              return;
            }

            settled = true;
            if (tracked) {
              endAsyncRequest();
            }
          }, { once: true });

          return originalSend.apply(xhr, arguments);
        };

        return xhr;
      }

      window.XMLHttpRequest = TrackedXHR;
    }

    function shouldIgnoreLink(link, event) {
      var href = link.getAttribute('href') || '';
      var parsed;

      if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
        return true;
      }

      if (!href || href.charAt(0) === '#') {
        return true;
      }

      if (href.indexOf('javascript:') === 0 || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) {
        return true;
      }

      if (link.target && link.target !== '_self') {
        return true;
      }

      if (link.hasAttribute('download') || link.dataset.noLoader === 'true') {
        return true;
      }

      try {
        parsed = new URL(href, window.location.href);
      } catch (error) {
        return true;
      }

      if (parsed.origin !== window.location.origin) {
        return true;
      }

      if (parsed.pathname === window.location.pathname && parsed.search === window.location.search && parsed.hash) {
        return true;
      }

      return false;
    }

    if (document.readyState !== 'complete') {
      showDelayed(null, 180);
    }

    window.addEventListener('load', hideRespectingMinimum, { once: true });

    // Ensures BFCache navigations do not leave the overlay visible.
    window.addEventListener('pageshow', function () {
      hideNow();
    });

    window.addEventListener('beforeunload', function () {
      showNow('Cargando...');
    });

    installFetchTracking();
    installXhrTracking();

    document.addEventListener('pointerdown', function (event) {
      var link = event.target && event.target.closest ? event.target.closest('a') : null;

      if (!link || shouldIgnoreLink(link, event)) {
        return;
      }

      // Show as early as possible so the loader paints before navigation starts.
      showNow('Cargando...');
    }, true);

    document.addEventListener('click', function (event) {
      var link = event.target && event.target.closest ? event.target.closest('a') : null;

      if (!link || shouldIgnoreLink(link, event)) {
        return;
      }

      showNow('Cargando...');
    }, true);

    document.addEventListener('submit', function (event) {
      var form = event.target;

      if (!form || form.dataset.noLoader === 'true') {
        return;
      }

      showDelayed(null, 110);
    }, true);

    window.AFLoadingScreen = {
      show: showNow,
      showDelayed: showDelayed,
      hide: hideNow,
      begin: beginAsyncRequest,
      end: endAsyncRequest,
    };
  }

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
    initGlobalLoadingScreen();
    initHeader();
    initScrollAnimations();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();