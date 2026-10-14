<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-contact-page">
  <!-- Hero Compacto -->
  <section class="af-contact-hero">
    <div class="container">
      <h1><?php esc_html_e('Contacto', 'twentytwentyfive-child'); ?></h1>
      <p><?php esc_html_e('¿Preguntas? Estamos aquí para ayudarte', 'twentytwentyfive-child'); ?></p>
    </div>
  </section>

  <!-- Contact Grid -->
  <section class="af-contact-section">
    <div class="container">
      <div class="af-contact-grid">
        <!-- Formulario -->
        <div class="af-contact-form-box">
          <h2><?php esc_html_e('Envíanos un mensaje', 'twentytwentyfive-child'); ?></h2>
          
          <?php
          $contact_status = isset( $_GET['contacto'] ) ? sanitize_key( wp_unslash( $_GET['contacto'] ) ) : '';
          $contact_notices = array(
            'ok'      => array( 'success', __( '¡Gracias! Recibimos tu mensaje y te responderemos en menos de 24 horas hábiles.', 'twentytwentyfive-child' ) ),
            'invalid' => array( 'error', __( 'Revisa que todos los campos estén completos y que el email sea válido.', 'twentytwentyfive-child' ) ),
            'error'   => array( 'error', __( 'No pudimos enviar tu mensaje. Inténtalo de nuevo o escríbenos a arriendofacilnet@gmail.com.', 'twentytwentyfive-child' ) ),
          );
          if ( isset( $contact_notices[ $contact_status ] ) ) :
            ?>
            <p class="af-contact-notice af-contact-notice--<?php echo esc_attr( $contact_notices[ $contact_status ][0] ); ?>" role="status"><?php echo esc_html( $contact_notices[ $contact_status ][1] ); ?></p>
          <?php endif; ?>

          <form class="af-contact-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="af_contact">
            <?php wp_nonce_field( 'af_contact_form', 'af_contact_nonce' ); ?>
            <div style="position:absolute;left:-9999px;" aria-hidden="true">
              <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
            <div class="af-form-row">
              <div class="af-form-group">
                <label><?php esc_html_e('Nombre', 'twentytwentyfive-child'); ?> *</label>
                <input type="text" name="name" required placeholder="Tu nombre">
              </div>
              <div class="af-form-group">
                <label><?php esc_html_e('Email', 'twentytwentyfive-child'); ?> *</label>
                <input type="email" name="email" required placeholder="tu@email.com">
              </div>
            </div>

            <div class="af-form-group">
              <label><?php esc_html_e('Asunto', 'twentytwentyfive-child'); ?> *</label>
              <select name="subject" required>
                <option value=""><?php esc_html_e('Selecciona un asunto', 'twentytwentyfive-child'); ?></option>
                <option value="demo"><?php esc_html_e('Quiero conocer el sistema', 'twentytwentyfive-child'); ?></option>
                <option value="support"><?php esc_html_e('Soporte técnico', 'twentytwentyfive-child'); ?></option>
                <option value="billing"><?php esc_html_e('Facturación', 'twentytwentyfive-child'); ?></option>
                <option value="other"><?php esc_html_e('Otro', 'twentytwentyfive-child'); ?></option>
              </select>
            </div>

            <div class="af-form-group">
              <label><?php esc_html_e('Mensaje', 'twentytwentyfive-child'); ?> *</label>
              <textarea name="message" required rows="5" placeholder="Cuéntanos cómo podemos ayudarte..."></textarea>
            </div>

            <button type="submit" class="btn btn--primary">
              <?php esc_html_e('Enviar', 'twentytwentyfive-child'); ?>
            </button>
          </form>
        </div>

        <!-- Info de Contacto -->
        <div class="af-contact-info-box">
          <h2><?php esc_html_e('Información de contacto', 'twentytwentyfive-child'); ?></h2>
          
          <div class="af-contact-info-items">
            <div class="af-contact-info-item">
              <div class="af-contact-icon">✉️</div>
              <div>
                <h4><?php esc_html_e('Email', 'twentytwentyfive-child'); ?></h4>
                <p><a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a></p>
              </div>
            </div>

            <div class="af-contact-info-item">
              <div class="af-contact-icon">⏱️</div>
              <div>
                <h4><?php esc_html_e('Tiempo de respuesta', 'twentytwentyfive-child'); ?></h4>
                <p><?php esc_html_e('Menos de 24 horas hábiles', 'twentytwentyfive-child'); ?></p>
              </div>
            </div>

            <div class="af-contact-info-item">
              <div class="af-contact-icon">📍</div>
              <div>
                <h4><?php esc_html_e('Ubicación', 'twentytwentyfive-child'); ?></h4>
                <p><?php esc_html_e('Quito, Ecuador', 'twentytwentyfive-child'); ?></p>
              </div>
            </div>

            <div class="af-contact-info-item">
              <div class="af-contact-icon">🌐</div>
              <div>
                <h4><?php esc_html_e('Idioma', 'twentytwentyfive-child'); ?></h4>
                <p><?php esc_html_e('100% en español', 'twentytwentyfive-child'); ?></p>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="af-contact-links">
            <h3><?php esc_html_e('Enlaces útiles', 'twentytwentyfive-child'); ?></h3>
            <ul>
              <li><a href="<?php echo esc_url(home_url('/preguntas-frecuentes/')); ?>"><?php esc_html_e('Preguntas Frecuentes', 'twentytwentyfive-child'); ?></a></li>
              <li><a href="<?php echo esc_url(home_url('/politica-de-privacidad/')); ?>"><?php esc_html_e('Política de Privacidad', 'twentytwentyfive-child'); ?></a></li>
              <li><a href="<?php echo esc_url(home_url('/terminos-y-condiciones/')); ?>"><?php esc_html_e('Términos y Condiciones', 'twentytwentyfive-child'); ?></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="af-contact-cta">
    <div class="container">
      <h2><?php esc_html_e('¿Listo para gestionar tus propiedades?', 'twentytwentyfive-child'); ?></h2>
      <a href="<?php echo esc_url(af_signup_url()); ?>" class="btn btn--primary">
        <?php esc_html_e('Crear mi cuenta', 'twentytwentyfive-child'); ?>
      </a>
    </div>
  </section>
</main>

<style>
.af-contact-page { background: var(--color-bg-primary); }
.af-contact-notice { padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.95rem; }
.af-contact-notice--success { background: #e6f6ec; color: #14532d; }
.af-contact-notice--error { background: #fdecec; color: #7f1d1d; }

.af-contact-hero {
  background: linear-gradient(135deg, var(--color-bg-inverse) 0%, var(--color-accent-primary-active) 100%);
  color: var(--color-text-inverse);
  padding: var(--space-7) 0;
  text-align: center;
}

.af-contact-hero h1 {
  font-size: var(--font-size-4xl);
  line-height: var(--line-height-tight);
  margin: 0 0 var(--space-2);
  font-weight: 700;
  color: inherit;
}

.af-contact-hero p {
  margin: 0;
  font-size: var(--font-size-lg);
  opacity: 0.9;
}

.af-contact-section { padding: var(--space-7) 0; }

.af-contact-grid {
  display: grid;
  grid-template-columns: 1.15fr 1fr;
  gap: var(--space-6);
  align-items: start;
}

@media (max-width: 860px) {
  .af-contact-hero { padding: var(--space-6) 0; }
  .af-contact-hero h1 { font-size: var(--font-size-3xl); }
  .af-contact-section { padding: var(--space-6) 0; }
  .af-contact-grid {
    grid-template-columns: 1fr;
    gap: var(--space-5);
  }
}

.af-contact-form-box,
.af-contact-info-box {
  background: var(--color-bg-primary);
  border: 1px solid var(--color-border-primary);
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-sm);
  padding: var(--space-6);
}

.af-contact-info-box { background: var(--color-bg-secondary); }

@media (max-width: 600px) {
  .af-contact-form-box,
  .af-contact-info-box { padding: var(--space-4); }
}

.af-contact-form-box h2,
.af-contact-info-box h2 {
  font-size: var(--font-size-xl);
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 var(--space-4);
}

.af-form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-4);
}

@media (max-width: 600px) {
  .af-form-row { grid-template-columns: 1fr; gap: 0; }
}

.af-form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: var(--space-4);
}

.af-form-group label {
  font-size: var(--font-size-sm);
  font-weight: 600;
  margin-bottom: var(--space-1);
  color: var(--color-text-primary);
}

.af-form-group input,
.af-form-group textarea,
.af-form-group select {
  padding: var(--space-3) var(--space-4);
  border: 1px solid var(--color-border-primary);
  border-radius: var(--border-radius-sm);
  font-size: var(--font-size-base);
  font-family: inherit;
  color: var(--color-text-primary);
  background: var(--color-bg-primary);
  width: 100%;
  box-sizing: border-box;
}

.af-form-group textarea {
  min-height: 120px;
  resize: vertical;
}

.af-form-group input:focus,
.af-form-group textarea:focus,
.af-form-group select:focus {
  outline: none;
  border-color: var(--color-border-focus);
  box-shadow: var(--shadow-focus);
}

.af-contact-form .btn { width: 100%; justify-content: center; }

.af-contact-info-items {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-3);
  margin-bottom: var(--space-5);
}

@media (max-width: 600px) {
  .af-contact-info-items { grid-template-columns: 1fr; }
}

.af-contact-info-item {
  display: flex;
  align-items: flex-start;
  gap: var(--space-3);
  padding: var(--space-4);
  background: var(--color-bg-primary);
  border: 1px solid var(--color-border-secondary);
  border-radius: var(--border-radius-sm);
}

.af-contact-info-item:first-child { grid-column: 1 / -1; }

.af-contact-icon {
  font-size: var(--font-size-xl);
  line-height: 1;
  flex-shrink: 0;
}

.af-contact-info-item h4 {
  font-size: var(--font-size-sm);
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 var(--space-1);
}

.af-contact-info-item p {
  margin: 0;
  font-size: var(--font-size-sm);
  color: var(--color-accent-secondary);
  line-height: var(--line-height-normal);
  overflow-wrap: anywhere;
}

.af-contact-info-item a {
  color: var(--color-accent-primary-active);
  text-decoration: none;
  font-weight: 500;
}

.af-contact-info-item a:hover {
  text-decoration: underline;
}

.af-contact-links {
  border-top: 1px solid var(--color-border-primary);
  padding-top: var(--space-4);
}

.af-contact-links h3 {
  font-size: var(--font-size-base);
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 var(--space-3);
}

.af-contact-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2) var(--space-4);
}

.af-contact-links a {
  color: var(--color-accent-primary-active);
  text-decoration: none;
  font-size: var(--font-size-sm);
  font-weight: 500;
}

.af-contact-links a:hover {
  text-decoration: underline;
}

.af-contact-cta {
  background: linear-gradient(135deg, var(--color-bg-inverse) 0%, var(--color-accent-primary-active) 100%);
  color: var(--color-text-inverse);
  padding: var(--space-7) 0;
  text-align: center;
}

.af-contact-cta h2 {
  font-size: var(--font-size-2xl);
  margin: 0 0 var(--space-4);
  font-weight: 700;
  color: inherit;
}
</style>

<?php get_footer(); ?>
