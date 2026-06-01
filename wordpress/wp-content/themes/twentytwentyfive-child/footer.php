<?php if ( ! defined('ABSPATH') ) { exit; } ?>

<script>
// Simple scroll animation
document.addEventListener('DOMContentLoaded', function() {
  const animatedElements = document.querySelectorAll('[data-animate]');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
      }
    });
  }, { threshold: 0.1 });

  animatedElements.forEach(el => observer.observe(el));
});
</script>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">
          <span class="logo-box notranslate" translate="no">AF</span>
          <span><?php bloginfo('name'); ?></span>
        </div>
        <p class="footer-desc">
          <?php esc_html_e('Encuentra tu próximo hogar en segundos. Propiedades verificadas, propietarios confiables, proceso transparente. Bienvenido a Arriendo Fácil.', 'twentytwentyfive-child'); ?>
        </p>
        <p class="footer-contact-info" style="margin-top: var(--space-3); font-size: 0.85rem; color: var(--color-text-secondary);">
          📍 Quito, Pichincha, Ecuador<br>
          ✉️ <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a>
        </p>
        <div class="social-links" style="margin-top: var(--space-5);">
          <a href="https://www.facebook.com/profile.php?id=61590015435478" aria-label="Facebook" target="_blank" rel="noopener">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
          </a>
          <a href="https://www.instagram.com/arriendofacilnet/" aria-label="Instagram" target="_blank" rel="noopener">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
          </a>
          <a href="https://www.tiktok.com/@arriendofacil.net?lang=es-419" aria-label="TikTok" target="_blank" rel="noopener">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19.589 6.686a4.793 4.793 0 01-3.77-4.715h-3.307v13.362a2.939 2.939 0 11-2.94-2.94c.245 0 .483.03.711.086V9.12a6.29 6.29 0 00-.71-.041A6.247 6.247 0 109.57 21.57a6.246 6.246 0 006.25-6.246V9.013a8.06 8.06 0 004.72 1.523V7.231a4.778 4.778 0 01-.951-.545z"/></svg>
          </a>
          <a href="" aria-label="YouTube" target="_blank" rel="noopener">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a2.99 2.99 0 00-2.104-2.115C19.53 3.5 12 3.5 12 3.5s-7.53 0-9.394.571A2.99 2.99 0 00.502 6.186C0 8.066 0 12 0 12s0 3.934.502 5.814a2.99 2.99 0 002.104 2.115C4.47 20.5 12 20.5 12 20.5s7.53 0 9.394-.571a2.99 2.99 0 002.104-2.115C24 15.934 24 12 24 12s0-3.934-.502-5.814zM9.6 15.568V8.432L15.818 12 9.6 15.568z"/></svg>
          </a>
          <a href="https://www.linkedin.com/company/arriendofacil" aria-label="LinkedIn" target="_blank" rel="noopener">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
        </div>
      </div>

      <div class="footer-col">
        <h4><?php esc_html_e('Para Renters', 'twentytwentyfive-child'); ?></h4>
        <div class="footer-links">
          <a href="<?php echo esc_url(home_url('/propiedades/')); ?>"><?php esc_html_e('Buscar propiedades', 'twentytwentyfive-child'); ?></a>
          <a href="#como-funciona"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(home_url('/contacto/')); ?>"><?php esc_html_e('Contacto y soporte', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(home_url('/contacto/#faq')); ?>"><?php esc_html_e('Preguntas frecuentes', 'twentytwentyfive-child'); ?></a>
        </div>
      </div>

      <div class="footer-col">
        <h4><?php esc_html_e('Sobre nosotros', 'twentytwentyfive-child'); ?></h4>
        <div class="footer-links">
          <a href="<?php echo esc_url(home_url('/quienes-somos/')); ?>"><?php esc_html_e('Acerca de Arriendo Fácil', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Blog y recursos', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(home_url('/contacto/')); ?>"><?php esc_html_e('Trabaja con nosotros', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(wp_login_url()); ?>" class="footer-owner-link">
            <?php esc_html_e('Iniciar sesión', 'twentytwentyfive-child'); ?>
          </a>
        </div>
      </div>

      <div class="footer-col">
        <h4><?php esc_html_e('Legal', 'twentytwentyfive-child'); ?></h4>
        <div class="footer-links">
          <a href="<?php echo esc_url(home_url('/terminos-y-condiciones/')); ?>"><?php esc_html_e('Términos y condiciones', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(home_url('/politica-de-privacidad/')); ?>"><?php esc_html_e('Política de privacidad', 'twentytwentyfive-child'); ?></a>
          <a href="<?php echo esc_url(home_url('/cookie-policy-eu/')); ?>"><?php esc_html_e('Política de cookies', 'twentytwentyfive-child'); ?></a>
        </div>
      </div>
    </div>

    <?php if ( ! is_page( 'registro-propietario' ) ) : ?>
    <!-- CTA Registro Propietario -->
    <div class="footer-cta-owner">
      <div class="footer-cta-owner__content">
        <div class="footer-cta-owner__text">
          <h4><?php esc_html_e('¿Eres propietario?', 'twentytwentyfive-child'); ?></h4>
          <p><?php esc_html_e('Regístrate como propietario y accede a nuestra plataforma de gestión profesional. Te ayudamos a administrar tus arriendos de forma segura y eficiente.', 'twentytwentyfive-child'); ?></p>
        </div>
        <a href="<?php echo esc_url(home_url('/registro-propietario/')); ?>" class="btn btn--accent footer-cta-owner__btn">
          <?php esc_html_e('Registrarme como propietario', 'twentytwentyfive-child'); ?>
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
    <?php endif; ?>

    <div class="footer-bottom">
      <p>© <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Todos los derechos reservados.', 'twentytwentyfive-child'); ?></p>
      <p><?php esc_html_e('Hecho con', 'twentytwentyfive-child'); ?> ❤️ <?php esc_html_e('en Ecuador', 'twentytwentyfive-child'); ?></p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>