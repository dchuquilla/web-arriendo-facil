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
          
          <form class="af-contact-form" method="POST" action="">
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

.af-contact-hero {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-6) 0;
  text-align: center;
  margin-bottom: var(--space-8);
}

.af-contact-hero h1 { 
  font-size: 1.75rem; 
  margin-bottom: var(--space-2);
  font-weight: 700;
}

.af-contact-hero p { 
  margin: 0;
  opacity: 0.95;
}

.af-contact-section { padding: var(--space-8) 0; }

.af-contact-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-8);
}

@media (max-width: 768px) {
  .af-contact-grid {
    grid-template-columns: 1fr;
    gap: var(--space-6);
  }
}

.af-contact-form-box h2,
.af-contact-info-box h2 {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--color-primary);
  margin-bottom: var(--space-4);
}

.af-form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-3);
}

.af-form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: var(--space-3);
}

.af-form-group label {
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: var(--space-1);
  color: var(--color-text-primary);
}

.af-form-group input,
.af-form-group textarea,
.af-form-group select {
  padding: var(--space-2) var(--space-3);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-sm);
  font-size: 0.95rem;
  font-family: inherit;
  background: white;
}

.af-form-group input:focus,
.af-form-group textarea:focus,
.af-form-group select:focus {
  outline: none;
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.1);
}

.af-contact-info-items {
  display: flex;
  flex-direction: column;
  gap: var(--space-4);
  margin-bottom: var(--space-6);
}

.af-contact-info-item {
  display: grid;
  grid-template-columns: 40px 1fr;
  gap: var(--space-3);
  padding: var(--space-3);
  border-left: 3px solid var(--color-primary);
  background: var(--color-bg-secondary);
  border-radius: var(--radius-sm);
}

.af-contact-icon {
  font-size: 1.5rem;
  text-align: center;
}

.af-contact-info-item h4 {
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--color-primary);
  margin: 0 0 var(--space-1) 0;
}

.af-contact-info-item p {
  margin: 0;
  font-size: 0.9rem;
  color: var(--color-text-secondary);
  line-height: 1.5;
}

.af-contact-info-item a {
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 500;
}

.af-contact-info-item a:hover {
  text-decoration: underline;
}

.af-contact-links h3 {
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--color-primary);
  margin-bottom: var(--space-3);
}

.af-contact-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.af-contact-links li {
  margin-bottom: var(--space-2);
}

.af-contact-links a {
  color: var(--color-primary);
  text-decoration: none;
  font-size: 0.9rem;
}

.af-contact-links a:hover {
  text-decoration: underline;
}

.af-contact-cta {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-8) 0;
  text-align: center;
  margin-top: var(--space-8);
}

.af-contact-cta h2 {
  font-size: 1.5rem;
  margin-bottom: var(--space-4);
  font-weight: 700;
}
</style>

<?php get_footer(); ?>
