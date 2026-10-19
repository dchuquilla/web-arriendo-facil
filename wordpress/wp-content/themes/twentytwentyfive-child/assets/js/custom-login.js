(function () {
  'use strict';

  var root = document.querySelector('[data-afl]');
  if (!root) return;

  var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var form = root.querySelector('[data-afl-form]');

  // Password visibility + caps lock hint
  var toggle = root.querySelector('[data-toggle-pass]');
  var pass = root.querySelector('#user_pass');
  var caps = root.querySelector('[data-caps]');
  if (toggle && pass) {
    toggle.addEventListener('click', function () {
      var show = pass.type === 'password';
      pass.type = show ? 'text' : 'password';
      toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
      toggle.setAttribute('aria-label', show ? 'Ocultar contraseña' : 'Mostrar contraseña');
      pass.focus();
    });
  }
  if (pass && caps) {
    var capsCheck = function (e) {
      if (e.getModifierState) caps.hidden = !e.getModifierState('CapsLock');
    };
    pass.addEventListener('keydown', capsCheck);
    pass.addEventListener('keyup', capsCheck);
    pass.addEventListener('blur', function () { caps.hidden = true; });
  }

  // Inline validation
  function setError(field, msg) {
    var out = field.querySelector('[data-error]');
    field.classList.toggle('is-invalid', !!msg);
    field.classList.toggle('is-valid', !msg && field.querySelector('input').value !== '');
    if (out) out.textContent = msg || '';
  }
  function validate(input) {
    var field = input.closest('.afl__field');
    var v = input.value.trim();
    if (!v) {
      setError(field, input.type === 'password' || input.id === 'user_pass' ? 'Ingresa tu contraseña.' : 'Ingresa tu usuario o correo.');
      return false;
    }
    if (input.id === 'user_login' && v.indexOf('@') !== -1 && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
      setError(field, 'El correo no parece válido.');
      return false;
    }
    setError(field, '');
    return true;
  }

  if (form) {
    var inputs = form.querySelectorAll('.afl__input');
    inputs.forEach(function (input) {
      input.addEventListener('blur', function () { if (input.value) validate(input); });
      input.addEventListener('input', function () {
        if (input.closest('.afl__field').classList.contains('is-invalid')) validate(input);
      });
    });

    var submitting = false;
    form.addEventListener('submit', function (e) {
      if (submitting) { e.preventDefault(); return; }
      var ok = true;
      var firstBad = null;
      inputs.forEach(function (input) {
        if (!validate(input)) {
          ok = false;
          if (!firstBad) firstBad = input;
        }
      });
      if (!ok) {
        e.preventDefault();
        firstBad.focus();
        return;
      }
      submitting = true; // prevents double submit
      var btn = form.querySelector('[data-submit]');
      btn.classList.add('is-loading');
      btn.setAttribute('aria-busy', 'true');
      // Keep the button enabled until the browser has serialized the form.
      setTimeout(function () { btn.disabled = true; }, 0);
    });

    // Ripple on the main button
    var submit = form.querySelector('[data-submit]');
    if (submit && !reduced) {
      submit.addEventListener('pointerdown', function (e) {
        var r = submit.getBoundingClientRect();
        var size = Math.max(r.width, r.height);
        var dot = document.createElement('span');
        dot.className = 'afl__ripple';
        dot.style.width = dot.style.height = size + 'px';
        dot.style.left = (e.clientX - r.left - size / 2) + 'px';
        dot.style.top = (e.clientY - r.top - size / 2) + 'px';
        submit.appendChild(dot);
        setTimeout(function () { dot.remove(); }, 650);
      });
    }

    // Restoring from bfcache must not leave the button stuck in loading state
    window.addEventListener('pageshow', function (e) {
      if (!e.persisted) return;
      submitting = false;
      var btn = form.querySelector('[data-submit]');
      btn.classList.remove('is-loading');
      btn.disabled = false;
    });

    var first = form.querySelector('.afl__input');
    if (first && window.matchMedia('(min-width: 861px)').matches) first.focus({ preventScroll: true });
  }

  // Feature list: auto-rotate, hover/click to select, pause on interaction
  var list = root.querySelector('[data-features]');
  if (list) {
    var items = Array.prototype.slice.call(list.children);
    var idx = 0;
    var timer = null;
    var activate = function (i) {
      idx = i;
      items.forEach(function (li, n) { li.classList.toggle('is-active', n === i); });
    };
    var start = function () {
      if (reduced || timer) return;
      timer = setInterval(function () { activate((idx + 1) % items.length); }, 3500);
    };
    var stop = function () { clearInterval(timer); timer = null; };
    items.forEach(function (li, n) {
      li.addEventListener('mouseenter', function () { stop(); activate(n); });
      li.addEventListener('click', function () { activate(n); });
    });
    list.addEventListener('mouseleave', start);
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
    start();
  }

  // Subtle parallax tilt on the brand panel (pointer devices only)
  var panel = root.querySelector('[data-tilt]');
  if (panel && !reduced && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
    var inner = panel.querySelector('.afl__panel-inner');
    var raf = 0;
    panel.addEventListener('pointermove', function (e) {
      if (raf) return;
      raf = requestAnimationFrame(function () {
        raf = 0;
        var r = panel.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        inner.style.transform = 'rotateY(' + (x * 5).toFixed(2) + 'deg) rotateX(' + (-y * 5).toFixed(2) + 'deg)';
      });
    });
    panel.addEventListener('pointerleave', function () { inner.style.transform = ''; });
  }
})();
