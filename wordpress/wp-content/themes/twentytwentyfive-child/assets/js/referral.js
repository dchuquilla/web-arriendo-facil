(function () {
 'use strict';
 var NAME_LIMITS = Object.freeze({
 min: 2,
 max: 60,
 });
 var NAME_ALLOWED_PATTERN = /^[A-Za-z\u00C0-\u017F' .-]{2,60}$/;
 var FRIENDLY_FATAL_ERROR = 'No se pudo validar el formulario. Recarga la página e inténtalo nuevamente.';
 var WHATSAPP_NUMBER = '';
 if (window.afReferral && window.afReferral.whatsapp) {
 WHATSAPP_NUMBER = window.afReferral.whatsapp.replace('+', '');
 } else if (window.afChatbot && window.afChatbot.whatsapp) {
 WHATSAPP_NUMBER = window.afChatbot.whatsapp.replace('+', '');
 }
 var referralBtn = document.getElementById('referral-whatsapp-btn');
 var nameInput = document.getElementById('referral-name');
 var errorEl = document.getElementById('referral-name-error');
 if (!referralBtn || !nameInput) return;
 var isFatalState = false;
 var lastErrorMsg = '';
 var lastBtnEnabled = null;
 var PROFANITY_LIST = [
 'puta', 'mierda', 'hijo de', 'cabron', 'cabrón', 'pendejo',
 'verga', 'culo', 'marica', 'joder', 'coño', 'idiota',
 'estupido', 'estúpido', 'imbecil', 'imbécil', 'malparido',
 'gonorrea', 'hp', 'hdp', 'ctm', 'ptm', 'fuck', 'shit',
 'bitch', 'ass', 'damn', 'bastard', 'maldita', 'maldito',
 'perra', 'zorra', 'maricon', 'maricón', 'huevon', 'huevón',
 'chucha', 'conchatumadre', 'vergon', 'cojudo', 'carajo',
 'putas', 'mierdas', 'pendejos', 'culero', 'pajero'
 ];
 var LEET_MAP = {
 '0': 'o', '1': 'i', '2': 'z', '3': 'e', '4': 'a',
 '5': 's', '6': 'g', '7': 't', '8': 'b', '9': 'g',
 '@': 'a', '$': 's', '!': 'i', '|': 'l', '+': 't',
 '(': 'c', ')': 'o', '{': 'c', '}': 'o', '[': 'c',
 ']': 'o', '<': 'c', '>': 'o', '/': 'l', '\\': 'l',
 '^': 'a', '*': 'a', '~': 'n', '#': 'h', '&': 'y'
 };
 function normalizeLeet(text) {
 var result = '';
 for (var i = 0; i < text.length; i++) {
 var ch = text[i].toLowerCase();
 result += LEET_MAP[ch] || ch;
 }
 return result
 .replace(/[áàäâ]/g, 'a')
 .replace(/[éèëê]/g, 'e')
 .replace(/[íìïî]/g, 'i')
 .replace(/[óòöô]/g, 'o')
 .replace(/[úùüû]/g, 'u')
 .replace(/ñ/g, 'n')
 .replace(/[^a-z\s]/g, '')
 .replace(/\s+/g, ' ')
 .trim();
 }
 function containsProfanity(text) {
 var normalized = normalizeLeet(text);
 var noSpaces = normalized.replace(/\s/g, '');
 for (var i = 0; i < PROFANITY_LIST.length; i++) {
 var word = normalizeLeet(PROFANITY_LIST[i]);
 if (normalized.indexOf(word) !== -1 || noSpaces.indexOf(word) !== -1) {
 return true;
 }
 }
 return false;
 }
 var INJECTION_PATTERNS = [
 /<[^>]*>/,
 /javascript:/i,
 /on\w+\s*=/i,
 /\{\{/,
 /\$\{/,
 /%3C/i,
 /%3E/i,
 /&#/,
 /\\/,
 /['";]/,
 /\b(select|insert|update|delete|drop|union|exec)\b/i,
 /http[s]?:\/\//i
 ];
 function debounce(fn, wait) {
 var timer = null;
 return function () {
 var args = arguments;
 var context = this;
 if (timer) {
 window.clearTimeout(timer);
 }
 timer = window.setTimeout(function () {
 fn.apply(context, args);
 }, wait);
 };
 }
 function sanitizePreflight(raw) {
 if (typeof raw !== 'string') {
 return '';
 }
 return raw
 .replace(/[\u0000-\u001F\u007F]/g, '')
 .replace(/[<>`]/g, '')
 .replace(/\s+/g, ' ')
 .trim()
 .slice(0, NAME_LIMITS.max);
 }
 function sanitizeName(raw) {
 return sanitizePreflight(raw)
 .replace(/[^A-Za-z\u00C0-\u017F\s\-'.]/g, '')
 .replace(/\s+/g, ' ')
 .trim();
 }
 function validateName(rawName) {
 var name = sanitizeName(rawName);
 if (!name || name.length < NAME_LIMITS.min) {
 return 'Ingresa tu nombre (mínimo 2 caracteres).';
 }
 if (name.length > NAME_LIMITS.max) {
 return 'El nombre es demasiado largo (máximo 60 caracteres).';
 }
 if (!NAME_ALLOWED_PATTERN.test(name)) {
 return 'El nombre contiene caracteres no permitidos.';
 }
 if (containsProfanity(name)) {
 return 'El nombre contiene contenido inapropiado.';
 }
 for (var j = 0; j < INJECTION_PATTERNS.length; j++) {
 if (INJECTION_PATTERNS[j].test(name)) {
 return 'El nombre contiene caracteres no permitidos.';
 }
 }
 if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]/.test(name)) {
 return 'El nombre debe contener al menos una letra.';
 }
 return null;
 }
 function showError(msg) {
 if (!errorEl) {
 return;
 }
 if (lastErrorMsg === msg && !errorEl.hidden) {
 return;
 }
 lastErrorMsg = msg;
 errorEl.textContent = msg;
 errorEl.hidden = false;
 nameInput.classList.add('is-invalid');
 nameInput.setAttribute('aria-invalid', 'true');
 }
 function clearError() {
 if (!errorEl) {
 return;
 }
 if (errorEl.hidden && !lastErrorMsg) {
 return;
 }
 errorEl.hidden = true;
 errorEl.textContent = '';
 lastErrorMsg = '';
 nameInput.classList.remove('is-invalid');
 nameInput.setAttribute('aria-invalid', 'false');
 }
 function setButtonEnabled(enabled) {
 if (lastBtnEnabled === enabled) {
 return;
 }
 lastBtnEnabled = enabled;
 if (enabled) {
 referralBtn.classList.remove('is-disabled');
 referralBtn.removeAttribute('aria-disabled');
 referralBtn.removeAttribute('tabindex');
 return;
 }
 referralBtn.classList.add('is-disabled');
 referralBtn.setAttribute('aria-disabled', 'true');
 referralBtn.setAttribute('tabindex', '-1');
 }
 function lockUi(message) {
 isFatalState = true;
 setButtonEnabled(false);
 nameInput.setAttribute('aria-invalid', 'true');
 if (message) {
 showError(message);
 }
 }
 function buildWhatsAppUrl(name) {
 var message = 'Hola, soy ' + name + ', quiero recomendar una propiedad para la plataforma, me gustaría saber cuál es su metodología de trabajo y cómo puedo ganar dinero.';
 var encoded = encodeURIComponent(message);
 if (WHATSAPP_NUMBER) {
 return 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' + encoded;
 }
 return 'https://wa.me/?text=' + encoded;
 }
 function computeValidationState(rawValue) {
 var cleanName = sanitizeName(rawValue);
 var validationError = validateName(cleanName);
 return {
 cleanName: cleanName,
 isValid: !validationError,
 error: validationError,
 };
 }
 var debouncedValidateInput = debounce(function () {
 try {
 if (isFatalState) {
 return;
 }
 var state = computeValidationState(nameInput.value);
 if (state.error) {
 clearError();
 setButtonEnabled(false);
 return;
 }
 if (!errorEl.hidden) {
 clearError();
 }
 if (nameInput.value !== state.cleanName) {
 nameInput.value = state.cleanName;
 }
 setButtonEnabled(state.isValid);
 } catch (err) {
 lockUi(FRIENDLY_FATAL_ERROR);
 if (window.console && typeof window.console.error === 'function') {
 window.console.error('Referral validation error', err);
 }
 }
 }, 120);
 function initReferralButton() {
 setButtonEnabled(false);
 referralBtn.addEventListener('click', function(e) {
 try {
 e.preventDefault();
 if (isFatalState || referralBtn.classList.contains('is-disabled')) {
 nameInput.focus();
 return;
 }
 var state = computeValidationState(nameInput.value);
 if (!state.isValid) {
 showError(state.error || 'Ingresa un nombre válido.');
 setButtonEnabled(false);
 nameInput.focus();
 return;
 }
 clearError();
 var url = buildWhatsAppUrl(state.cleanName);
 if (window.gtag) {
 gtag('event', 'referral_whatsapp_click', {
 'event_category': 'engagement',
 'event_label': 'referral_program'
 });
 }
 window.open(url, '_blank', 'noopener,noreferrer');
 nameInput.value = '';
 setButtonEnabled(false);
 } catch (err) {
 lockUi(FRIENDLY_FATAL_ERROR);
 if (window.console && typeof window.console.error === 'function') {
 window.console.error('Referral submit error', err);
 }
 }
 });
 nameInput.addEventListener('input', function() {
 debouncedValidateInput();
 });
 nameInput.addEventListener('blur', function() {
 if (isFatalState) {
 return;
 }
 try {
 var state = computeValidationState(nameInput.value);
 if (!state.isValid) {
 showError(state.error || 'Ingresa un nombre válido.');
 setButtonEnabled(false);
 return;
 }
 nameInput.value = state.cleanName;
 clearError();
 } catch (err) {
 lockUi(FRIENDLY_FATAL_ERROR);
 }
 });
 }
 function initScrollAnimations() {
 var animatedElements = document.querySelectorAll('#recomendaciones [data-animate]');
 if (!animatedElements.length) return;
 if ('IntersectionObserver' in window) {
 var observer = new IntersectionObserver(function(entries) {
 entries.forEach(function(entry) {
 if (entry.isIntersecting) {
 entry.target.classList.add('is-visible');
 observer.unobserve(entry.target);
 }
 });
 }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
 animatedElements.forEach(function(el) { observer.observe(el); });
 } else {
 animatedElements.forEach(function(el) { el.classList.add('is-visible'); });
 }
 }
 function init() {
 try {
 initReferralButton();
 initScrollAnimations();
 } catch (err) {
 lockUi(FRIENDLY_FATAL_ERROR);
 if (window.console && typeof window.console.error === 'function') {
 window.console.error('Referral init error', err);
 }
 }
 }
 if (document.readyState === 'loading') {
 document.addEventListener('DOMContentLoaded', init);
 } else {
 init();
 }
})();
