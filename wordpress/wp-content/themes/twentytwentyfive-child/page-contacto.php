<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content">
  <!-- ========== CONTACT HERO ========== -->
  <section class="contact-hero">
    <div class="container">
      <div class="contact-hero-content" data-animate>
        <h1 class="h1"><?php esc_html_e('Ponte en contacto con nosotros', 'twentytwentyfive-child'); ?></h1>
        <p class="p"><?php esc_html_e('Estamos aquí para responder tus preguntas. Nuestro equipo te ayudará en cualquier momento.', 'twentytwentyfive-child'); ?></p>
      </div>
    </div>
  </section>

  <!-- ========== CONTACT SECTION ========== -->
  <section class="section">
    <div class="container">
      <div class="contact-grid">
        <!-- Contact Form -->
        <div class="contact-form-wrapper">
          <h2 class="h2"><?php esc_html_e('Envíanos un mensaje', 'twentytwentyfive-child'); ?></h2>

          <form class="contact-form" method="POST" action="">
            <div class="form-row">
              <div class="form-group">
                <label for="name"><?php esc_html_e('Nombre completo', 'twentytwentyfive-child'); ?> *</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  required
                  placeholder="<?php esc_attr_e('Tu nombre', 'twentytwentyfive-child'); ?>"
                >
              </div>
              <div class="form-group">
                <label for="email"><?php esc_html_e('Correo electrónico', 'twentytwentyfive-child'); ?> *</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  required
                  placeholder="<?php esc_attr_e('tu@email.com', 'twentytwentyfive-child'); ?>"
                >
              </div>
            </div>

            <div class="form-group">
              <label for="phone"><?php esc_html_e('Teléfono (opcional)', 'twentytwentyfive-child'); ?></label>
              <input
                type="tel"
                id="phone"
                name="phone"
                placeholder="<?php esc_attr_e('Tu número de contacto (opcional)', 'twentytwentyfive-child'); ?>"
              >
            </div>

            <div class="form-group">
              <label for="subject"><?php esc_html_e('Asunto', 'twentytwentyfive-child'); ?> *</label>
              <select id="subject" name="subject" required>
                <option value=""><?php esc_html_e('Selecciona un asunto', 'twentytwentyfive-child'); ?></option>
                <option value="property_question"><?php esc_html_e('Pregunta sobre una propiedad', 'twentytwentyfive-child'); ?></option>
                <option value="general_question"><?php esc_html_e('Pregunta general', 'twentytwentyfive-child'); ?></option>
                <option value="support"><?php esc_html_e('Soporte técnico', 'twentytwentyfive-child'); ?></option>
                <option value="feedback"><?php esc_html_e('Comentarios o sugerencias', 'twentytwentyfive-child'); ?></option>
                <option value="other"><?php esc_html_e('Otro', 'twentytwentyfive-child'); ?></option>
              </select>
            </div>

            <div class="form-group">
              <label for="message"><?php esc_html_e('Mensaje', 'twentytwentyfive-child'); ?> *</label>
              <textarea
                id="message"
                name="message"
                required
                rows="6"
                placeholder="<?php esc_attr_e('Cuéntanos cómo podemos ayudarte...', 'twentytwentyfive-child'); ?>"
              ></textarea>
            </div>

            <button type="submit" class="btn btn--primary btn--lg">
              <?php esc_html_e('Enviar mensaje', 'twentytwentyfive-child'); ?>
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
            </button>
          </form>
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
          <h2 class="h2"><?php esc_html_e('Información de contacto', 'twentytwentyfive-child'); ?></h2>

          <div class="contact-info-items">
            <!-- Email -->
            <div class="contact-info-item">
              <div class="contact-icon">✉️</div>
              <div>
                <h4><?php esc_html_e('Email', 'twentytwentyfive-child'); ?></h4>
                <p>
                  <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a>
                </p>
              </div>
            </div>

            <!-- Phone -->
            <div class="contact-info-item">
              <div class="contact-icon">📞</div>
              <div>
                <h4><?php esc_html_e('Atención', 'twentytwentyfive-child'); ?></h4>
                <p>
                  <?php esc_html_e('Atención por correo electrónico.', 'twentytwentyfive-child'); ?><br>
                  <?php esc_html_e('Respuesta en menos de 24 horas hábiles.', 'twentytwentyfive-child'); ?>
                </p>
              </div>
            </div>

            <!-- WhatsApp -->
            <div class="contact-info-item">
              <div class="contact-icon">💬</div>
              <div>
                <h4><?php esc_html_e('Canal rápido', 'twentytwentyfive-child'); ?></h4>
                <p>
                  <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a><br>
                  <?php esc_html_e('Respuesta en minutos en horario laboral', 'twentytwentyfive-child'); ?>
                </p>
              </div>
            </div>

            <!-- Location -->
            <div class="contact-info-item">
              <div class="contact-icon">📍</div>
              <div>
                <h4><?php esc_html_e('Oficina', 'twentytwentyfive-child'); ?></h4>
                <p>
                  <?php esc_html_e('Quito, Ecuador', 'twentytwentyfive-child'); ?><br>
                  <?php esc_html_e('América del Sur', 'twentytwentyfive-child'); ?>
                </p>
              </div>
            </div>
          </div>

          <!-- FAQ -->
          <div class="faq-section">
            <h3><?php esc_html_e('Preguntas frecuentes', 'twentytwentyfive-child'); ?></h3>
            <ul class="small">
              <li><strong><?php esc_html_e('¿Cuál es el tiempo de respuesta?', 'twentytwentyfive-child'); ?></strong><br>
                <?php esc_html_e('Respondemos en menos de 24 horas hábiles.', 'twentytwentyfive-child'); ?></li>
              <li><strong><?php esc_html_e('¿Ofrecen soporte en español?', 'twentytwentyfive-child'); ?></strong><br>
                <?php esc_html_e('Sí, soporte 100% en español.', 'twentytwentyfive-child'); ?></li>
              <li><strong><?php esc_html_e('¿Puedo contactar fuera del horario?', 'twentytwentyfive-child'); ?></strong><br>
                <?php esc_html_e('Envía un email y responderemos al día siguiente.', 'twentytwentyfive-child'); ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== FINAL CTA ========== -->
  <section class="section section--soft">
    <div class="container text-center">
      <h2 class="h2"><?php esc_html_e('¿Listo para comenzar?', 'twentytwentyfive-child'); ?></h2>
      <p class="p mx-auto"><?php esc_html_e('Explora nuestro catálogo de propiedades verificadas y encuentra tu próximo hogar hoy.', 'twentytwentyfive-child'); ?></p>
      <a href="<?php echo esc_url(home_url('/propiedades')); ?>" class="btn btn--primary btn--lg" style="margin-top: var(--space-8);">
        <?php esc_html_e('Buscar propiedades', 'twentytwentyfive-child'); ?>
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </section>

</main>

<?php get_footer(); ?>
