(function () {
  'use strict';

  function hasCookieConsent() {
    var match = document.cookie.match(/cmplz_consent_status=([^;]+)/);
    return match && match[1] === 'allow';
  }

  if (hasCookieConsent()) return;

  function watchBanner() {
    var denyBtn = document.querySelector('.cmplz-btn.cmplz-deny');
    if (!denyBtn) {
      setTimeout(watchBanner, 200);
      return;
    }

    denyBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopImmediatePropagation();
      document.body.classList.add('cmplz-denied-message');
    }, true);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', watchBanner);
  } else {
    watchBanner();
  }
})();
