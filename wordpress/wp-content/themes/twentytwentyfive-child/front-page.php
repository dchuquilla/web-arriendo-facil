<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main>

  <!-- HERO -->
  <section class="hero" id="inicio">
    <div class="container hero-grid">
      <div>
        <h1 class="h1"><?php esc_html_e('Administramos tu hospedaje', 'twentytwentyfive-child'); ?></h1>
        <p class="p">
          <?php esc_html_e('Gestión de arriendos, limpieza y mantenimiento con inteligencia artificial para maximizar tu rentabilidad.', 'twentytwentyfive-child'); ?>
        </p>

        <div class="cta-row">
          <a class="btn btn--primary" href="#contacto"><?php esc_html_e('Quiero administrar mi hospedaje', 'twentytwentyfive-child'); ?></a>
          <a class="btn" href="#como-funciona"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></a>
        </div>
      </div>

      <div class="hero-card" aria-label="<?php esc_attr_e('Vista previa del panel', 'twentytwentyfive-child'); ?>">
        <div class="mock-header">
          <div class="dot-row" aria-hidden="true">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
          </div>
          <span class="badge">AI</span>
        </div>
        <div class="mock-body">
          <div class="block" aria-hidden="true"></div>
          <div class="block" aria-hidden="true"></div>
          <div class="block" aria-hidden="true"></div>
          <div class="block" aria-hidden="true"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROBLEMAS -->
  <section class="section section--soft">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('¿Te pasa esto?', 'twentytwentyfive-child'); ?></h2>

      <div class="kv-grid" style="margin-top:14px;">
        <div class="card">
          <h3><?php esc_html_e('Operación desgastante', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Coordinar limpieza consume tiempo y energía.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Mantenimiento reactivo y costoso.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card">
          <h3><?php esc_html_e('Poca claridad financiera', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('No sabes el costo real por reserva/mes.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Gastos inesperados reducen tu rentabilidad.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card">
          <h3><?php esc_html_e('Gestión del huésped', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Mensajes, incidencias y reglas sin proceso.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Documentación desordenada.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>

      <hr class="sep">
      <p class="p" style="max-width: none;">
        <strong><?php esc_html_e('Nosotros lo resolvemos por ti.', 'twentytwentyfive-child'); ?></strong>
      </p>
    </div>
  </section>

  <!-- SERVICIOS -->
  <section class="section" id="servicios">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('Nuestros servicios', 'twentytwentyfive-child'); ?></h2>

      <div class="kv-grid" style="margin-top:14px;">
        <div class="card">
          <h3><?php esc_html_e('Gestión de arriendos', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Coordinación de reservas y calendario.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Atención al huésped con procesos claros.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Optimización operativa y reportes.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>

        <div class="card">
          <h3><?php esc_html_e('Limpieza y mantenimiento', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Programación de limpieza y checklist.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Mantenimiento preventivo y correctivo.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Supervisión y control de calidad.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>

        <div class="card">
          <h3><?php esc_html_e('IA y automatización', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Predicción de costos y proyecciones.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Generación de documentación.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Gestión inteligente del huésped.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ARRRENDAMIENTO + CARRUSEL + PROPIEDADES DESTACADAS -->
  <section class="section section--soft" id="arrendamiento">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('Arrienda tu propiedad con nosotros', 'twentytwentyfive-child'); ?></h2>
      <p class="p"><?php esc_html_e('Vista rápida de propiedades destacadas y llamada a la acción para maximizar ingresos con operación completa.', 'twentytwentyfive-child'); ?></p>

      <div class="showcase" data-home-showcase>
        <div class="showcase-head">
          <strong><?php esc_html_e('Propiedad destacada', 'twentytwentyfive-child'); ?></strong>
          <div class="carousel-controls">
            <button class="icon-btn" type="button" data-carousel-prev aria-label="<?php esc_attr_e('Anterior', 'twentytwentyfive-child'); ?>">‹</button>
            <button class="icon-btn" type="button" data-carousel-next aria-label="<?php esc_attr_e('Siguiente', 'twentytwentyfive-child'); ?>">›</button>
          </div>
        </div>

        <div class="showcase-body">
          <div class="showcase-media">
            <a href="#" data-property-link>
              <img src="" alt="" data-property-image>
            </a>
          </div>

          <div class="showcase-info">
            <h3 style="margin: 0 0 8px;" data-property-title>Propiedad Destacada</h3>
            <p class="p" style="margin:0 0 10px;">
              <span data-property-location>Ubicación</span>,
              <strong data-property-price>$xx por noche</strong>
            </p>

            <div class="badges" data-property-badges></div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top: 14px;">
              <a class="btn btn--primary" href="#contacto"><?php esc_html_e('Quiero rentabilizar mi propiedad', 'twentytwentyfive-child'); ?></a>
              <a class="btn" href="#" data-property-link-secondary><?php esc_html_e('Ver detalles', 'twentytwentyfive-child'); ?></a>
            </div>

            <p class="small" style="margin-top: 12px;">
              <?php esc_html_e('¿Eres propietario? Agenda una asesoría y evaluamos tu potencial de ingresos.', 'twentytwentyfive-child'); ?>
            </p>
          </div>
        </div>

        <!-- dots para imágenes del carrusel principal (representa “imágenes” del inmueble) -->
        <div class="dots" data-carousel-dots aria-label="<?php esc_attr_e('Navegación del carrusel', 'twentytwentyfive-child'); ?>"></div>

        <!-- Strip de “otras propiedades destacadas” -->
        <div class="featured-strip" data-featured-strip>
          <!-- JS inyecta items -->
        </div>
      </div>

      <div style="display:flex; justify-content:center; margin-top: 18px;">
        <a class="btn btn--primary btn--wide" href="#contacto"><?php esc_html_e('Agenda tu asesoría gratuita', 'twentytwentyfive-child'); ?></a>
      </div>
    </div>
  </section>

  <!-- CÓMO FUNCIONA -->
  <section class="section" id="como-funciona">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></h2>
      <div class="steps" style="margin-top:14px;">
        <div class="step">1. <?php esc_html_e('Registras tu propiedad', 'twentytwentyfive-child'); ?><span><?php esc_html_e('Datos básicos y objetivos.', 'twentytwentyfive-child'); ?></span></div>
        <div class="step">2. <?php esc_html_e('Análisis con IA', 'twentytwentyfive-child'); ?><span><?php esc_html_e('Costos, proyección y plan operativo.', 'twentytwentyfive-child'); ?></span></div>
        <div class="step">3. <?php esc_html_e('Activamos operación', 'twentytwentyfive-child'); ?><span><?php esc_html_e('Limpieza, mantenimiento y procesos.', 'twentytwentyfive-child'); ?></span></div>
        <div class="step">4. <?php esc_html_e('Recibes ganancias', 'twentytwentyfive-child'); ?><span><?php esc_html_e('Reportes y control transparente.', 'twentytwentyfive-child'); ?></span></div>
      </div>
    </div>
  </section>

  <!-- BENEFICIOS -->
  <section class="section section--soft">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('Beneficios', 'twentytwentyfive-child'); ?></h2>

      <div class="kv-grid" style="margin-top:14px;">
        <div class="card">
          <h3><?php esc_html_e('Más rentabilidad', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Costos previstos y controlados.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Mejor ocupación con operación ordenada.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card">
          <h3><?php esc_html_e('Menos estrés', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Delegas coordinación y soporte.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Incidencias con respuesta rápida.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card">
          <h3><?php esc_html_e('Transparencia', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Reportes automáticos y documentación.', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Historial y trazabilidad.', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIOS + CTA -->
  <section class="section" id="contacto">
    <div class="container split-cta">
      <div>
        <h2 class="h2"><?php esc_html_e('Testimonios', 'twentytwentyfive-child'); ?></h2>
        <div class="testimonials" style="margin-top:14px;">
          <div class="quote">
            <strong><?php esc_html_e('Propietario en Quito', 'twentytwentyfive-child'); ?></strong>
            <p><?php esc_html_e('“Delegué la operación y ahora tengo ingresos más estables sin estrés.”', 'twentytwentyfive-child'); ?></p>
          </div>
          <div class="quote">
            <strong><?php esc_html_e('Dueña en Guayaquil', 'twentytwentyfive-child'); ?></strong>
            <p><?php esc_html_e('“La limpieza y el mantenimiento dejaron de ser un problema. Todo está controlado.”', 'twentytwentyfive-child'); ?></p>
          </div>
        </div>
      </div>

      <div class="card">
        <h2 class="h2"><?php esc_html_e('¿Listo para profesionalizar tu hospedaje?', 'twentytwentyfive-child'); ?></h2>
        <p class="p"><?php esc_html_e('Agenda una asesoría gratuita. Evaluamos tu propiedad y te mostramos el potencial real.', 'twentytwentyfive-child'); ?></p>

        <!-- Aquí puedes insertar un shortcode de formulario (Contact Form 7, WPForms, etc.) -->
        <div class="card" style="background: var(--bg-soft); border-style:dashed;">
          <p class="small" style="margin:0;">
            <?php esc_html_e('Formulario aquí (shortcode). Ej: [contact-form-7 id="123" title="Asesoría"]', 'twentytwentyfive-child'); ?>
          </p>
        </div>

        <div style="margin-top:14px;">
          <a class="btn btn--primary btn--wide" href="#"><?php esc_html_e('Agenda tu asesoría gratuita', 'twentytwentyfive-child'); ?></a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>