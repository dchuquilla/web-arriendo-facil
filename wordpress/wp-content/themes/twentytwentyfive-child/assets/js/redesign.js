/**
 * ArriendoFácil · Rediseño
 * - Menú móvil, submenú y acordeón FAQ (sin dependencias).
 * - GSAP + ScrollTrigger + Observer:
 *     · "Cómo funciona", FAQ y Planes: sección fija (pin) con fondo que cambia por opacidad sincronizada
 *       con el scroll (scrub) en pantallas amplias; en móvil/reduced-motion se apilan sin pin.
 *     · Scroll natural con reveals por lote y header que se oculta (Observer "scroll").
 *     · Parallax de profundidad con el puntero (Observer "pointer").
 *   Respeta prefers-reduced-motion: sin animaciones, todo visible.
 */
(function () {
  'use strict';

  var doc = document;
  var win = window;
  var root = doc.documentElement;

  function $(sel, ctx) { return (ctx || doc).querySelector(sel); }
  function $$(sel, ctx) { return Array.prototype.slice.call((ctx || doc).querySelectorAll(sel)); }

  /* ------------------------------------------------------------------ *
   * Header: menú móvil + submenú
   * ------------------------------------------------------------------ */
  var header = $('#site-header');
  var burger = $('#afx-burger');
  var nav = $('#afx-nav');

  function menuOpen() { return !!(nav && nav.classList.contains('is-open')); }

  /* ------------------------------------------------------------------ *
   * Decisión de cookies: el sitio espera una elección (aceptar, rechazar o personalizar)
   * ------------------------------------------------------------------ */
  var modalEl = null;
  function gated() { return root.classList.contains('afx-gated'); }
  function blocked() { return menuOpen() || gated() || !!modalEl; }
  function hasConsent() { return /(?:^|;\s*)cmplz_banner-status=dismissed/.test(doc.cookie); }

  function setGate(on) {
    root.classList.toggle('afx-gated', on);
    $$('#site-header, #main-content, .afx-footer').forEach(function (el) {
      if (on) { el.setAttribute('inert', ''); } else { el.removeAttribute('inert'); }
    });
  }

  if (!hasConsent()) {
    setGate(true);
    var gateStart = Date.now();
    var gateTimer = win.setInterval(function () {
      if (hasConsent()) { setGate(false); win.clearInterval(gateTimer); return; }
      // Si Complianz no llegó a cargar, no dejamos el sitio bloqueado para siempre.
      if (!$('.cmplz-cookiebanner') && Date.now() - gateStart > 10000) { setGate(false); win.clearInterval(gateTimer); }
    }, 250);
  } else {
    root.classList.remove('afx-gated');
  }

  /* ------------------------------------------------------------------ *
   * Modal de video (YouTube, máxima calidad disponible)
   * ------------------------------------------------------------------ */
  var modalOpener = null;

  function closeVideo() {
    if (!modalEl) { return; }
    var el = modalEl;
    modalEl = null;
    el.classList.remove('is-open');
    root.style.overflow = menuOpen() ? 'hidden' : '';
    win.setTimeout(function () { el.remove(); }, 260);
    if (modalOpener && modalOpener.focus) { modalOpener.focus(); }
  }

  function openVideo(btn) {
    if (modalEl || gated()) { return; }
    var id = btn.getAttribute('data-afx-video');
    var title = btn.getAttribute('data-afx-video-title') || '';
    if (!id) { return; }
    modalOpener = btn;

    var m = doc.createElement('div');
    m.className = 'afx-modal';
    m.setAttribute('role', 'dialog');
    m.setAttribute('aria-modal', 'true');
    m.setAttribute('aria-label', title);
    m.innerHTML =
      '<div class="afx-modal__backdrop" data-afx-close></div>' +
      '<div class="afx-modal__box">' +
        '<button class="afx-modal__close" type="button" data-afx-close aria-label="Cerrar video">' +
          '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>' +
        '</button>' +
        '<div class="afx-modal__frame"></div>' +
        '<p class="afx-modal__title"></p>' +
      '</div>';
    m.querySelector('.afx-modal__title').textContent = title;

    var iframe = doc.createElement('iframe');
    iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) +
      '?autoplay=1&rel=0&modestbranding=1&playsinline=1&hl=es&vq=hd1080&iv_load_policy=3';
    iframe.title = title;
    iframe.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
    iframe.setAttribute('allowfullscreen', '');
    iframe.referrerPolicy = 'strict-origin-when-cross-origin';
    m.querySelector('.afx-modal__frame').appendChild(iframe);

    doc.body.appendChild(m);
    modalEl = m;
    root.style.overflow = 'hidden';
    win.requestAnimationFrame(function () { m.classList.add('is-open'); });
    m.querySelector('.afx-modal__close').focus();

    m.addEventListener('click', function (e) {
      if (e.target.closest && e.target.closest('[data-afx-close]')) { closeVideo(); }
    });
  }

  doc.addEventListener('click', function (e) {
    var t = e.target.closest ? e.target.closest('[data-afx-video]') : null;
    if (t) { e.preventDefault(); openVideo(t); }
  });

  /* Diálogo de acceso: pasos que requieren una sesión iniciada */
  function openAuth(btn) {
    if (modalEl || gated()) { return; }
    modalOpener = btn;
    var title = btn.getAttribute('data-afx-auth-title') || '';
    var text = btn.getAttribute('data-afx-auth-text') || '';

    var m = doc.createElement('div');
    m.className = 'afx-modal afx-modal--auth';
    m.setAttribute('role', 'dialog');
    m.setAttribute('aria-modal', 'true');
    m.setAttribute('aria-labelledby', 'afx-auth-title');
    m.innerHTML =
      '<div class="afx-modal__backdrop" data-afx-close></div>' +
      '<div class="afx-modal__box"><div class="afx-authbox">' +
        '<button class="afx-modal__close" type="button" data-afx-close aria-label="Cerrar">' +
          '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>' +
        '</button>' +
        '<span class="afx-authbox__icon"><svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg></span>' +
        '<h2 id="afx-auth-title"></h2>' +
        '<p></p>' +
        '<div class="afx-authbox__actions">' +
          '<a class="afx-btn afx-btn--dark afx-btn--lg afx-btn--block" data-afx-login>Iniciar sesión</a>' +
          '<a class="afx-btn afx-btn--soft afx-btn--lg afx-btn--block" data-afx-signup>Crear cuenta gratis</a>' +
        '</div>' +
      '</div></div>';
    m.querySelector('h2').textContent = title;
    m.querySelector('p').textContent = text;
    m.querySelector('[data-afx-login]').setAttribute('href', btn.getAttribute('data-afx-auth-login') || '#');
    m.querySelector('[data-afx-signup]').setAttribute('href', btn.getAttribute('data-afx-auth-signup') || '#');

    doc.body.appendChild(m);
    modalEl = m;
    root.style.overflow = 'hidden';
    win.requestAnimationFrame(function () { m.classList.add('is-open'); });
    m.querySelector('[data-afx-login]').focus();

    m.addEventListener('click', function (e) {
      if (e.target.closest && e.target.closest('[data-afx-close]')) { closeVideo(); }
    });
  }

  doc.addEventListener('click', function (e) {
    var t = e.target.closest ? e.target.closest('[data-afx-auth]') : null;
    if (t) { e.preventDefault(); openAuth(t); }
  });

  doc.addEventListener('keydown', function (e) {
    if (!modalEl) { return; }
    if (e.key === 'Escape') { e.preventDefault(); closeVideo(); return; }
    if (e.key === 'Tab') {
      var f = $$('button, iframe, [href]', modalEl);
      if (!f.length) { return; }
      var first = f[0];
      var last = f[f.length - 1];
      if (e.shiftKey && doc.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && doc.activeElement === last) { e.preventDefault(); first.focus(); }
    }
  });

  function setMenu(open) {
    if (!burger || !nav) { return; }
    nav.classList.toggle('is-open', open);
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    burger.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
    root.style.overflow = open ? 'hidden' : '';
    if (header) { header.classList.remove('is-hidden'); }
  }

  if (burger && nav) {
    burger.addEventListener('click', function () { setMenu(!menuOpen()); });
    nav.addEventListener('click', function (e) {
      if (e.target.closest && e.target.closest('a')) { setMenu(false); }
    });
    win.addEventListener('resize', function () { if (win.innerWidth > 1000 && menuOpen()) { setMenu(false); } });
  }

  $$('.afx-nav__item--has-menu').forEach(function (item) {
    var btn = $('.afx-nav__link--menu', item);
    if (!btn) { return; }
    btn.addEventListener('click', function () {
      var open = !item.classList.contains('is-open');
      item.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    doc.addEventListener('click', function (e) {
      if (!item.contains(e.target) && item.classList.contains('is-open')) {
        item.classList.remove('is-open');
        btn.setAttribute('aria-expanded', 'false');
      }
    });
  });

  doc.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') { return; }
    if (menuOpen()) { setMenu(false); if (burger) { burger.focus(); } }
    $$('.afx-nav__item.is-open').forEach(function (item) {
      item.classList.remove('is-open');
      var b = $('.afx-nav__link--menu', item);
      if (b) { b.setAttribute('aria-expanded', 'false'); }
    });
  });

  /* ------------------------------------------------------------------ *
   * Acordeón FAQ
   * ------------------------------------------------------------------ */
  var accButtons = $$('.afx-acc__btn');
  accButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var open = btn.getAttribute('aria-expanded') === 'true';
      accButtons.forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
      btn.setAttribute('aria-expanded', open ? 'false' : 'true');
    });
  });

  /* Tarjeta de plan que se voltea */
  $$('[data-afx-flip]').forEach(function (card) {
    var faces = $$('.afx-plan__face', card);
    function setFlip(on) {
      card.classList.toggle('is-flipped', on);
      faces.forEach(function (face, i) {
        var visible = (i === 0) !== on;
        face.setAttribute('aria-hidden', visible ? 'false' : 'true');
        $$('button, a', face).forEach(function (el) {
          if (visible) { el.removeAttribute('tabindex'); } else { el.setAttribute('tabindex', '-1'); }
        });
      });
      var next = $('.afx-plan__face:not([aria-hidden="true"]) [data-afx-flip-btn]', card);
      if (next && doc.activeElement && card.contains(doc.activeElement)) { next.focus(); }
    }
    card.addEventListener('click', function (e) {
      if (e.target.closest('a')) { return; }
      setFlip(!card.classList.contains('is-flipped'));
    });
  });

  /* ------------------------------------------------------------------ *
   * FAQ: categoría activa según el scroll
   * ------------------------------------------------------------------ */
  var faqLinks = $$('.afx-faqnav__link');
  if (faqLinks.length && 'IntersectionObserver' in win) {
    var setActive = function (id) {
      faqLinks.forEach(function (a) {
        var on = a.getAttribute('href') === '#' + id;
        a.classList.toggle('is-active', on);
        if (on) {
          a.setAttribute('aria-current', 'true');
          var ul = a.parentNode.parentNode;
          [ul, ul.parentNode].forEach(function (host) {
            if (host.scrollHeight > host.clientHeight + 2) { host.scrollTop = a.offsetTop - (host.clientHeight - a.offsetHeight) / 2; }
            if (host.scrollWidth > host.clientWidth + 2) { host.scrollLeft = a.offsetLeft - (host.clientWidth - a.offsetWidth) / 2; }
          });
        } else { a.removeAttribute('aria-current'); }
      });
    };
    var secObs = new win.IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { setActive(en.target.id); } });
    }, { rootMargin: '-25% 0px -60% 0px' });
    $$('.afx-faqsec').forEach(function (sec) { secObs.observe(sec); });
  }

  /* ------------------------------------------------------------------ *
   * GSAP
   * ------------------------------------------------------------------ */
  var gsap = win.gsap;
  if (!gsap || !win.Observer || !win.ScrollTrigger) { return; }
  gsap.registerPlugin(win.Observer, win.ScrollTrigger);

  var story = $('[data-afx-story]');
  var stages = story ? $$('[data-afx-stage]', story) : [];
  var hero = $('#inicio');
  var fpApi = null;

  function fmt(n) { return String(Math.round(n)).replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }

  function hide(el) {
    var isCard = el.hasAttribute('data-afx-card');
    if (isCard && el._afxRot === undefined) { el._afxRot = Number(gsap.getProperty(el, 'rotation')) || 0; }
    gsap.set(el, isCard ? { autoAlpha: 0, y: 80, rotation: el._afxRot - 9 } : { autoAlpha: 0, y: 34 });
  }

  function playExtras(el, delay) {
    $$('.afx-bar', el).forEach(function (bar, i) {
      gsap.fromTo(bar, { scaleY: 0 }, { scaleY: 1, duration: 0.9, ease: 'back.out(1.5)', delay: delay + 0.45 + i * 0.08, overwrite: true });
    });
    $$('[data-count]', el).forEach(function (node) {
      var end = Number(node.getAttribute('data-count')) || 0;
      var state = { v: 0 };
      if (node._afxTween) { node._afxTween.kill(); }
      node.textContent = fmt(0);
      node._afxTween = gsap.to(state, {
        v: end, duration: 1.6, delay: delay + 0.4, ease: 'power2.out',
        onUpdate: function () { node.textContent = fmt(state.v); },
        onComplete: function () { node.textContent = fmt(end); }
      });
    });
  }

  function animateIn(els, delay) {
    delay = delay || 0;
    els.forEach(function (el, i) {
      var d = delay + i * 0.07;
      var vars = { autoAlpha: 1, y: 0, duration: 0.85, ease: 'power3.out', delay: d, overwrite: 'auto' };
      if (el.hasAttribute('data-afx-card')) {
        vars.rotation = el._afxRot || 0;
        vars.duration = 1.2;
        vars.ease = 'expo.out';
      }
      gsap.to(el, vars);
      playExtras(el, d);
    });
  }

  var mm = gsap.matchMedia();

  mm.add({
    pin: '(min-width: 961px) and (min-height: 700px) and (prefers-reduced-motion: no-preference)',
    motion: '(prefers-reduced-motion: no-preference)'
  }, function (ctx) {
    if (!ctx.conditions.motion) { return undefined; }

    var cleanups = [];
    var pinned = ctx.conditions.pin && stages.length > 1 && setupFullpage(cleanups);
    if (!pinned) {
      $$('[data-afx-stagec]').forEach(function (el) { el.setAttribute('data-afx', ''); });
      cleanups.push(function () {
        $$('[data-afx-stagec]').forEach(function (el) { el.removeAttribute('data-afx'); gsap.set(el, { clearProps: 'all' }); });
      });
      setupStackedSpy();
    }
    if (!pinned) { setupNatural(cleanups); }
    setupPointerDepth(cleanups);

    return function () { cleanups.forEach(function (fn) { fn(); }); };
  });

  /* ---------- Navegación interna (Inicio / Cómo funciona / FAQ / Planes) ---------- */
  var navLinks = $$('[data-afx-go]');

  function setNavActive(id) {
    $$('.afx-nav__link[data-afx-go]').forEach(function (a) {
      var on = a.getAttribute('data-afx-go') === id;
      a.classList.toggle('is-active', on);
      if (on) { a.setAttribute('aria-current', 'page'); } else { a.removeAttribute('aria-current'); }
    });
  }

  function goToId(id, smooth) {
    var behavior = smooth === false ? 'auto' : 'smooth';
    if (fpApi && (id === 'inicio' || id === 'footer')) { return fpApi.goTo(id, smooth === false); }
    if (id === 'inicio') { win.scrollTo({ top: 0, behavior: behavior }); return true; }
    var el = doc.getElementById(id);
    if (!el || !story || !story.contains(el)) { return false; }
    if (fpApi) { return fpApi.goTo(id, smooth === false); }
    var offset = (header ? header.offsetHeight : 0) + (doc.body.classList.contains('admin-bar') ? 32 : 0);
    win.scrollTo({ top: el.getBoundingClientRect().top + win.pageYOffset - offset, behavior: behavior });
    return true;
  }

  if (story) {
    navLinks.forEach(function (a) {
      var id = a.getAttribute('data-afx-go');
      if (id !== 'inicio' && !doc.getElementById(id)) { return; }
      a.setAttribute('data-no-loader', 'true');
      a.addEventListener('click', function (e) {
        if (e.defaultPrevented || blocked()) { return; }
        e.preventDefault();
        goToId(id);
        if (win.history && win.history.replaceState) {
          win.history.replaceState(null, '', id === 'inicio' ? win.location.pathname + win.location.search : '#' + id);
        }
      });
    });

    var startId = win.location.hash.replace('#', '');
    if (startId && doc.getElementById(startId) && story.contains(doc.getElementById(startId))) {
      var jump = function () { win.ScrollTrigger.refresh(); goToId(startId, false); };
      if (doc.readyState === 'complete') { win.setTimeout(jump, 120); } else { win.addEventListener('load', function () { win.setTimeout(jump, 120); }); }
    }
  }

  /* ---------- Menú activo en modo apilado (sin pin) ---------- */
  function setupStackedSpy() {
    var targets = [hero].concat(stages).filter(Boolean);
    targets.forEach(function (el) {
      win.ScrollTrigger.create({
        trigger: el, start: 'top 55%', end: 'bottom 55%',
        onToggle: function (self) { if (self.isActive) { setNavActive(el.id); } }
      });
    });
  }

  /* ---------- Pantalla completa con Observer: Inicio · ¿Cómo funciona? · FAQ · Planes · Footer ---------- */
  function setupFullpage(cleanups) {
    var main = $('#main-content');
    var footer = $('.afx-footer');
    var panels = [hero].concat(stages);
    var N = panels.length; // índice N = footer
    var ids = ['inicio'].concat(stages.map(function (s) { return s.id; }));
    var cur = 0;
    var animating = false;
    var pending = null;
    var cool = 0;
    var htmlEl = doc.documentElement;

    htmlEl.classList.add('afx-fp');

    function contentOf(i) { return i === 0 ? $$('[data-afx]', hero) : $$('[data-afx-stagec]', stages[i - 1]); }

    // Si algún panel no cabe en la pantalla se usa el modo apilado
    var fits = panels.every(function (p, i) {
      var inner = i === 0 ? $('.afx-hero__grid', p) : $('.afx-stage__grid', p);
      var box = i === 0 ? $('.afx-hero', p) : p;
      return !inner || inner.offsetHeight <= box.clientHeight - 8;
    });
    if (!fits || !main) { htmlEl.classList.remove('afx-fp'); return false; }

    gsap.set(panels, { autoAlpha: 0, zIndex: 0 });
    gsap.set(panels[0], { autoAlpha: 1, zIndex: 2 });
    panels.forEach(function (p, i) { contentOf(i).forEach(hide); });
    var introCall = gsap.delayedCall(0.25, function () { animateIn(contentOf(0), 0); });

    var dotsWrap = doc.createElement('nav');
    dotsWrap.className = 'afx-dots';
    dotsWrap.setAttribute('aria-label', 'Secciones de la página');
    var labels = panels.map(function (p) { return p.getAttribute('data-title') || 'Inicio'; }).concat(['Contacto']);
    var dots = labels.map(function (label, i) {
      var btn = doc.createElement('button');
      btn.type = 'button';
      btn.setAttribute('data-label', label);
      btn.setAttribute('aria-label', label);
      btn.addEventListener('click', function () { if (!blocked()) { goTo(i); } });
      dotsWrap.appendChild(btn);
      return btn;
    });
    main.appendChild(dotsWrap);

    function sync() {
      dots.forEach(function (d, n) {
        d.classList.toggle('is-active', n === cur);
        if (n === cur) { d.setAttribute('aria-current', 'true'); } else { d.removeAttribute('aria-current'); }
      });
      dotsWrap.classList.toggle('is-light', cur === 0);
      setNavActive(cur < N ? ids[cur] : '');
      if (header) { header.classList.toggle('is-scrolled', cur === N); }
    }
    sync();

    function maxY() { return Math.max(0, htmlEl.scrollHeight - win.innerHeight); }

    function scrollTween(y, dur, done) {
      var p = { y: win.pageYOffset };
      gsap.to(p, {
        y: y, duration: dur, ease: 'power3.inOut', overwrite: true,
        onUpdate: function () { win.scrollTo({ top: p.y, behavior: 'instant' }); },
        onComplete: done
      });
    }

    function showPanel(i) {
      panels.forEach(function (p, n) {
        gsap.killTweensOf(p);
        gsap.set(p, { autoAlpha: n === i ? 1 : 0, yPercent: 0, scale: 1, zIndex: n === i ? 2 : 0 });
        if (n !== i) { contentOf(n).forEach(hide); }
      });
    }

    function goTo(target, instant) {
      target = Math.max(0, Math.min(N, target));
      if (animating) { pending = target; return; }
      if (target === cur) { return; }

      animating = true;
      pending = null;
      var from = cur;
      cur = target;
      sync();

      var finished = false;
      var guard = null;
      var finish = function () {
        if (finished) { return; }
        finished = true;
        if (guard) { guard.kill(); }
        animating = false;
        cool = Date.now() + 380;
        var next = pending;
        pending = null;
        if (next !== null && next !== cur) { goTo(next); }
      };
      guard = gsap.delayedCall(2.4, finish);

      if (target === N) {
        if (from !== N - 1) { showPanel(N - 1); contentOf(N - 1).forEach(function (el) { gsap.set(el, { autoAlpha: 1, y: 0 }); }); }
        if (instant) { win.scrollTo({ top: maxY(), behavior: 'instant' }); finish(); } else { scrollTween(maxY(), 0.95, finish); }
        return;
      }

      if (from === N) {
        if (target !== N - 1) { showPanel(target); animateIn(contentOf(target), 0.2); }
        if (instant) { win.scrollTo({ top: 0, behavior: 'instant' }); finish(); } else { scrollTween(0, 0.85, finish); }
        return;
      }

      var dir = target > from ? 1 : -1;
      var inc = panels[target];
      var out = panels[from];

      if (instant) {
        showPanel(target);
        contentOf(target).forEach(function (el) { gsap.set(el, { autoAlpha: 1, y: 0 }); });
        finish();
        return;
      }

      contentOf(target).forEach(hide);
      gsap.set(inc, { autoAlpha: 1, yPercent: 100 * dir, scale: 1, zIndex: 2 });
      gsap.set(out, { zIndex: 1 });
      var bg = $('.afx-stage__bg', inc);
      if (bg) { gsap.fromTo(bg, { scale: 1.16 }, { scale: 1.02, duration: 2.2, ease: 'power2.out' }); }

      gsap.timeline({ defaults: { duration: 1, ease: 'expo.inOut' }, onComplete: finish })
        .to(inc, { yPercent: 0 }, 0)
        .to(out, { yPercent: -18 * dir, scale: 0.96, autoAlpha: 0.55 }, 0)
        .add(function () { animateIn(contentOf(target), 0); }, 0.5)
        .set(out, { autoAlpha: 0, yPercent: 0, scale: 1, zIndex: 0 })
        .add(function () { contentOf(from).forEach(hide); });
    }

    function step(d) {
      if (blocked() || animating || Date.now() < cool) { return; }
      goTo(cur + d);
    }

    var obs = win.Observer.create({
      type: 'wheel,touch',
      wheelSpeed: -1,
      tolerance: 14,
      preventDefault: true,
      ignore: '.afx-header,.afx-nav,.afx-modal,.cmplz-cookiebanner,.cmplz-manage-consent,input,textarea,select',
      onUp: function () { step(1); },
      onDown: function () { step(-1); }
    });

    function onKey(e) {
      if (blocked() || e.altKey || e.ctrlKey || e.metaKey) { return; }
      var t = e.target;
      if (t && /^(INPUT|TEXTAREA|SELECT)$/.test(t.tagName)) { return; }
      var k = e.key;
      if (k === 'ArrowDown' || k === 'PageDown' || (k === ' ' && !e.shiftKey && (!t || t === doc.body))) { e.preventDefault(); step(1); }
      else if (k === 'ArrowUp' || k === 'PageUp' || (k === ' ' && e.shiftKey && (!t || t === doc.body))) { e.preventDefault(); step(-1); }
      else if (k === 'Home') { e.preventDefault(); goTo(0); }
      else if (k === 'End') { e.preventDefault(); goTo(N); }
    }
    doc.addEventListener('keydown', onKey);

    // El scroll nativo (barra, foco con Tab) nunca debe dejar la página a medias
    var settle = null;
    function onScroll() {
      if (animating) { return; }
      win.clearTimeout(settle);
      settle = win.setTimeout(function () {
        if (animating) { return; }
        var y = win.pageYOffset;
        if (cur === N) { if (Math.abs(y - maxY()) > 2) { win.scrollTo({ top: maxY(), behavior: 'instant' }); } }
        else if (y > 2) { win.scrollTo({ top: 0, behavior: 'instant' }); }
      }, 120);
    }
    win.addEventListener('scroll', onScroll, { passive: true });

    function onFocusIn(e) { if (footer && footer.contains(e.target) && cur !== N) { goTo(N, true); } }
    doc.addEventListener('focusin', onFocusIn);

    function onResize() { if (cur === N) { win.scrollTo({ top: maxY(), behavior: 'instant' }); } }
    win.addEventListener('resize', onResize);

    if ('scrollRestoration' in win.history) { win.history.scrollRestoration = 'manual'; }
    win.scrollTo({ top: 0, behavior: 'instant' });

    fpApi = {
      goTo: function (id, instant) {
        var idx = ids.indexOf(id);
        if (idx < 0) { return false; }
        goTo(idx, instant);
        return true;
      }
    };

    cleanups.push(function () {
      fpApi = null;
      obs.kill();
      introCall.kill();
      doc.removeEventListener('keydown', onKey);
      doc.removeEventListener('focusin', onFocusIn);
      win.removeEventListener('scroll', onScroll);
      win.removeEventListener('resize', onResize);
      dotsWrap.remove();
      htmlEl.classList.remove('afx-fp');
      var all = [];
      panels.forEach(function (p, i) { all.push(p); all = all.concat(contentOf(i)); });
      gsap.killTweensOf(all);
      gsap.set(all, { clearProps: 'all' });
      $$('.afx-stage__bg', story).forEach(function (el) { gsap.killTweensOf(el); gsap.set(el, { clearProps: 'all' }); });
      if (header) { header.classList.remove('is-scrolled'); }
    });
    return true;
  }

  /* ---------- Modo natural (scroll nativo) ---------- */
  function setupNatural(cleanups) {
    var targets = $$('[data-afx]');
    var lastY = win.pageYOffset;

    if (targets.length && 'IntersectionObserver' in win) {
      targets.forEach(hide);
      var queue = [];
      var scheduled = false;
      var flush = function () {
        scheduled = false;
        var batch = queue.splice(0, queue.length);
        batch.sort(function (a, b) { return a.getBoundingClientRect().top - b.getBoundingClientRect().top || a.getBoundingClientRect().left - b.getBoundingClientRect().left; });
        animateIn(batch, 0.05);
      };
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) { return; }
          io.unobserve(entry.target);
          queue.push(entry.target);
        });
        if (queue.length && !scheduled) { scheduled = true; win.requestAnimationFrame(flush); }
      }, { threshold: 0.12, rootMargin: '0px 0px -5% 0px' });
      targets.forEach(function (el) { io.observe(el); });
      cleanups.push(function () { io.disconnect(); });
    }

    var hider = win.Observer.create({
      type: 'scroll',
      tolerance: 4,
      onChangeY: function () {
        var y = win.pageYOffset;
        if (header) {
          header.classList.toggle('is-scrolled', y > 8);
          if (Math.abs(y - lastY) > 6) {
            header.classList.toggle('is-hidden', y > lastY && y > 160 && !menuOpen());
          }
        }
        lastY = y;
      }
    });
    cleanups.push(function () {
      hider.kill();
      if (header) { header.classList.remove('is-hidden', 'is-scrolled'); }
    });
  }

  /* ---------- Parallax de profundidad con el puntero ---------- */
  function setupPointerDepth(cleanups) {
    if (!win.matchMedia('(hover: hover) and (pointer: fine)').matches) { return; }

    $$('[data-afx-tilt]').forEach(function (area) {
      var layers = $$('[data-afx-depth]', area).map(function (el) {
        return {
          depth: Number(el.getAttribute('data-afx-depth')) || 10,
          x: gsap.quickTo(el, 'x', { duration: 0.7, ease: 'power3.out' }),
          y: gsap.quickTo(el, 'y', { duration: 0.7, ease: 'power3.out' })
        };
      });
      if (!layers.length) { return; }

      var armed = false;
      var timer = gsap.delayedCall(2.2, function () { armed = true; });
      var obs = win.Observer.create({
        target: area,
        type: 'pointer',
        onMove: function (self) {
          if (!armed) { return; }
          var r = area.getBoundingClientRect();
          var nx = ((self.x - r.left) / r.width - 0.5) * 2;
          var ny = ((self.y - r.top) / r.height - 0.5) * 2;
          layers.forEach(function (l) { l.x(nx * l.depth); l.y(ny * l.depth * 0.7); });
        },
        onHoverEnd: function () { layers.forEach(function (l) { l.x(0); l.y(0); }); }
      });
      cleanups.push(function () { obs.kill(); timer.kill(); });
    });
  }
})();
