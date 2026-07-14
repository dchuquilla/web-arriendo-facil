/**
 * Input Normalizer
 *
 * Applies case normalization to form inputs on blur (or input for email).
 * Activate on any <input> by adding the data-normalize attribute:
 *
 *   data-normalize="name"           → Proper Case on blur
 *   data-normalize="address"        → Proper Case on blur
 *   data-normalize="email"          → lowercase on every keystroke
 *   data-normalize="document-upper" → strip spaces/dashes + UPPERCASE on blur (passport)
 *
 * CSS text-transform provides the visual hint while typing.
 * JS applies the real normalization on blur so the value sent to the server is clean.
 *
 * @package Arriendo_Facil
 */
(function () {
  'use strict';

  /**
   * Convert a string to Proper Case (each word capitalized).
   * Handles all-caps, all-lowercase and mixed-case input.
   * Works with accented characters (é, ñ, ü, etc.).
   *
   * @param {string} str
   * @returns {string}
   */
  function toProperCase(str) {
    if (!str) return '';
    return str
      .toLowerCase()
      .replace(
        // Match the first character of every word (including accented letters).
        /\b([a-záéíóúüñàèìòùâêîôûãõçœ])/gi,
        function (ch) { return ch.toUpperCase(); }
      );
  }

  /**
   * Normalize an email: trim + lowercase.
   *
   * @param {string} str
   * @returns {string}
   */
  function toEmailCase(str) {
    return (str || '').trim().toLowerCase();
  }

  /**
   * Normalize a passport/document: strip spaces & dashes, uppercase.
   *
   * @param {string} str
   * @returns {string}
   */
  function toDocumentUpper(str) {
    return (str || '').replace(/[\s\-]/g, '').toUpperCase();
  }

  /**
   * Set the value of an input while preserving the cursor position.
   *
   * @param {HTMLInputElement} input
   * @param {string} newValue
   */
  function setValuePreservingCursor(input, newValue) {
    var pos = input.selectionStart;
    input.value = newValue;
    try { input.setSelectionRange(pos, pos); } catch (_) {}
  }

  function init() {
    // ── Proper name / address ────────────────────────────────────────────────
    var nameInputs = document.querySelectorAll(
      'input[data-normalize="name"], input[data-normalize="address"]'
    );
    Array.prototype.forEach.call(nameInputs, function (input) {
      input.addEventListener('blur', function () {
        var normalized = toProperCase(this.value);
        if (normalized !== this.value) {
          this.value = normalized;
        }
      });
    });

    // ── Email ─────────────────────────────────────────────────────────────────
    // Normalize on every keystroke so the value is always lowercase.
    var emailInputs = document.querySelectorAll('input[data-normalize="email"]');
    Array.prototype.forEach.call(emailInputs, function (input) {
      input.addEventListener('input', function () {
        var lower = toEmailCase(this.value);
        if (lower !== this.value) {
          setValuePreservingCursor(this, lower);
        }
      });
    });

    // ── Passport / uppercase document ────────────────────────────────────────
    var docUpperInputs = document.querySelectorAll(
      'input[data-normalize="document-upper"]'
    );
    Array.prototype.forEach.call(docUpperInputs, function (input) {
      input.addEventListener('blur', function () {
        var normalized = toDocumentUpper(this.value);
        if (normalized !== this.value) {
          this.value = normalized;
        }
      });
    });
  }

  // Run after DOM is ready.
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();
