<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main>

  <!-- ========== HERO ========== -->
  <section class="hero" id="inicio">
    <div class="container">
      <div class="hero-grid">
        <div class="hero-content" data-animate>
          <span class="badge"><?php esc_html_e('Tecnología + Arrendamiento', 'twentytwentyfive-child'); ?></span>
          <h1 class="h1">
            <?php esc_html_e('Administramos tu', 'twentytwentyfive-child'); ?>
            <span class="text-gradient"><?php esc_html_e('hospedaje', 'twentytwentyfive-child'); ?></span>
          </h1>
          <p class="p">
            <?php esc_html_e('Gestión inteligente de arriendos y limpieza de habitaciones. Maximizamos tu rentabilidad inmobiliaria con IA.', 'twentytwentyfive-child'); ?>
          </p>

          <div class="cta-row">
            <a class="btn btn--primary btn--lg" href="#contacto">
              <?php esc_html_e('Quiero administrar mi hospedaje', 'twentytwentyfive-child'); ?>
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a class="btn btn--outline btn--lg" href="#como-funciona">
              <?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?>
            </a>
          </div>
        </div>

        <div class="hero-visual" data-animate>
          <div class="hero-card" aria-label="<?php esc_attr_e('Panel de control AI', 'twentytwentyfive-child'); ?>">
            <div class="mock-header">
              <div class="dot-row" aria-hidden="true">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
              </div>
              <span class="badge">AI Dashboard</span>
            </div>
            <div class="mock-body">
              <div class="block" aria-hidden="true"></div>
              <div class="block" aria-hidden="true"></div>
              <div class="block" aria-hidden="true"></div>
              <div class="block" aria-hidden="true"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== STATS BAR ========== -->
  <section class="section" style="padding-top: 0;">
    <div class="container">
      <div class="stats-bar" data-animate>
        <div class="stat-item">
          <div class="stat-number">+150</div>
          <div class="stat-label"><?php esc_html_e('Propiedades gestionadas', 'twentytwentyfive-child'); ?></div>
        </div>
        <div class="stat-item">
          <div class="stat-number">98%</div>
          <div class="stat-label"><?php esc_html_e('Tasa de ocupación', 'twentytwentyfive-child'); ?></div>
        </div>
        <div class="stat-item">
          <div class="stat-number">+25%</div>
          <div class="stat-label"><?php esc_html_e('Incremento en rentabilidad', 'twentytwentyfive-child'); ?></div>
        </div>
        <div class="stat-item">
          <div class="stat-number">24/7</div>
          <div class="stat-label"><?php esc_html_e('Soporte con IA', 'twentytwentyfive-child'); ?></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROBLEMAS ========== -->
  <section class="section section--soft">
    <div class="container">
      <div class="text-center" data-animate>
        <h2 class="h2"><?php esc_html_e('¿Te identificas con esto?', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('Los propietarios de hospedajes enfrentan desafíos operativos que reducen su rentabilidad.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="problem-grid">
        <div class="problem-card" data-animate>
          <div class="problem-icon">⏰</div>
          <h3 class="h3"><?php esc_html_e('Operación desgastante', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('Coordinar la limpieza consume tu tiempo. El trabajo reactivo incrementa costos.', 'twentytwentyfive-child'); ?></p>
        </div>
        <div class="problem-card" data-animate>
          <div class="problem-icon">📊</div>
          <h3 class="h3"><?php esc_html_e('Poca claridad financiera', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('No conoces el costo real por reserva. Gastos inesperados reducen tu rentabilidad.', 'twentytwentyfive-child'); ?></p>
        </div>
        <div class="problem-card" data-animate>
          <div class="problem-icon">💬</div>
          <h3 class="h3"><?php esc_html_e('Gestión del huésped', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('Mensajes, incidencias y reglas sin proceso definido. Documentación dispersa.', 'twentytwentyfive-child'); ?></p>
        </div>
      </div>

      <div class="solution-highlight" data-animate>
        <h3 class="h3"><?php esc_html_e('Nosotros lo resolvemos por ti', 'twentytwentyfive-child'); ?></h3>
        <p class="p"><?php esc_html_e('Nos encargamos de todo: coordinación de reservas, limpieza profesional entre huéspedes, atención 24/7 y reportes automáticos. Tú solo recibes tus ganancias.', 'twentytwentyfive-child'); ?></p>
      </div>
    </div>
  </section>

  <!-- ========== SERVICIOS ========== -->
  <section class="section" id="servicios">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Soluciones integrales', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('Nuestros servicios', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('Todo lo que necesitas para profesionalizar tu hospedaje y maximizar ingresos.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="kv-grid">
        <div class="card" data-animate>
          <div class="card-icon">🏠</div>
          <h3><?php esc_html_e('Gestión de arriendos', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Reservas y calendario unificado', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Atención al huésped con procesos automatizados', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Optimización de precios dinámicos', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Reportes financieros de arriendamientos', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>

        <div class="card" data-animate>
          <div class="card-icon">✨</div>
          <h3><?php esc_html_e('Limpieza de habitaciones', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Programación automática de limpiezas', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Checklist digital de calidad', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Mantenimiento preventivo programado', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Red de proveedores verificados', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>

        <div class="card" data-animate>
          <div class="card-icon">🤖</div>
          <h3><?php esc_html_e('IA y automatización', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Predicción de costos y proyecciones', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Chatbot 24/7 para huéspedes', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Generación automática de documentos', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROPIEDADES DESTACADAS ========== -->
  <section class="section section--soft" id="arrendamiento">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Portafolio activo', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('Propiedades bajo nuestra gestión', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('Descubre las propiedades que maximizan su rentabilidad con nuestra operación inteligente.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="showcase" data-home-showcase>
        <div class="showcase-head">
          <strong><?php esc_html_e('Propiedad destacada', 'twentytwentyfive-child'); ?></strong>
          <div class="carousel-controls">
            <button class="icon-btn" type="button" data-carousel-prev aria-label="<?php esc_attr_e('Anterior', 'twentytwentyfive-child'); ?>">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="icon-btn" type="button" data-carousel-next aria-label="<?php esc_attr_e('Siguiente', 'twentytwentyfive-child'); ?>">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>

        <div class="showcase-body">
          <div class="showcase-media">
            <a href="#" data-property-link>
              <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/arriendo-facil-logo-full-placeholder.jpg" alt="<?php esc_attr_e('Propiedad destacada', 'twentytwentyfive-child'); ?>" data-property-image>
            </a>
          </div>

          <div class="showcase-info">
            <h3 data-property-title><?php esc_html_e('Suite Ejecutiva Centro Histórico', 'twentytwentyfive-child'); ?></h3>
            <p class="p" style="margin:0 0 10px;">
              <span data-property-location><?php esc_html_e('Quito, Ecuador', 'twentytwentyfive-child'); ?></span> •
              <strong data-property-price>$85/noche</strong>
            </p>

            <div class="badges" data-property-badges>
              <span class="badge badge--feature">WiFi</span>
              <span class="badge badge--feature">Cocina</span>
              <span class="badge badge--feature">Parking</span>
              <span class="badge badge--feature">Smart TV</span>
            </div>

            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top: 20px;">
              <a class="btn btn--primary" href="#contacto"><?php esc_html_e('Quiero rentabilizar mi propiedad', 'twentytwentyfive-child'); ?></a>
              <a class="btn btn--outline" href="#" data-property-link-secondary><?php esc_html_e('Ver detalles', 'twentytwentyfive-child'); ?></a>
            </div>

            <p class="small" style="margin-top: 16px;">
              <?php esc_html_e('¿Eres propietario? Agenda una asesoría y evaluamos tu potencial de ingresos.', 'twentytwentyfive-child'); ?>
            </p>
          </div>
        </div>

        <div class="dots" data-carousel-dots aria-label="<?php esc_attr_e('Navegación del carrusel', 'twentytwentyfive-child'); ?>">
          <button class="dot-btn is-active" aria-label="Imagen 1"></button>
          <button class="dot-btn" aria-label="Imagen 2"></button>
          <button class="dot-btn" aria-label="Imagen 3"></button>
        </div>

        <div class="featured-strip" data-featured-strip>
          <div class="featured-item">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/arriendo-facil-logo-full-placeholder.jpg" alt="">
            <div class="fi-title"><?php esc_html_e('Loft Moderno La Carolina', 'twentytwentyfive-child'); ?></div>
          </div>
          <div class="featured-item">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/arriendo-facil-logo-full-placeholder.jpg" alt="">
            <div class="fi-title"><?php esc_html_e('Penthouse Cumbayá', 'twentytwentyfive-child'); ?></div>
          </div>
          <div class="featured-item">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/arriendo-facil-logo-full-placeholder.jpg" alt="">
            <div class="fi-title"><?php esc_html_e('Casa de Campo Tumbaco', 'twentytwentyfive-child'); ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CÓMO FUNCIONA ========== -->
  <section class="section" id="como-funciona">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Proceso simple', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('En 4 simples pasos empezamos a maximizar la rentabilidad de tu propiedad.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="steps-container">
        <div class="steps">
          <div class="step" data-animate>
            <div class="step-number">1</div>
            <h4><?php esc_html_e('Registra tu propiedad', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Completa datos básicos, fotos y define tus objetivos de rentabilidad.', 'twentytwentyfive-child'); ?></span>
          </div>
          <div class="step" data-animate>
            <div class="step-number">3</div>
            <h4><?php esc_html_e('Activamos operación', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Gestionamos limpieza, mantenimiento, reservas y atención al huésped.', 'twentytwentyfive-child'); ?></span>
          </div>
          <div class="step" data-animate>
            <div class="step-number">2</div>
            <h4><?php esc_html_e('Automatización con IA', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Evaluamos huéspedes y optimizamos tu plan operativo de arriendos personalizado.', 'twentytwentyfive-child'); ?></span>
          </div>
          <div class="step" data-animate>
            <div class="step-number">4</div>
            <h4><?php esc_html_e('Recibes ganancias', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Reportes automáticos y transferencias con total transparencia.', 'twentytwentyfive-child'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== BENEFICIOS ========== -->
  <section class="section section--dark">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Ventajas competitivas', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('¿Por qué elegir Arriendo Fácil?', 'twentytwentyfive-child'); ?></h2>
      </div>

      <div class="kv-grid">
        <div class="card" data-animate>
          <div class="card-icon">📈</div>
          <h3><?php esc_html_e('Más rentabilidad', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Costos previstos y controlados', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Precios dinámicos optimizados por IA', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Mejor ocupación con operación ordenada', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card" data-animate>
          <div class="card-icon">😌</div>
          <h3><?php esc_html_e('Menos estrés', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Delegas coordinación completa', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Incidencias con respuesta inmediata', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Soporte 24/7 para ti y tus huéspedes', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card" data-animate>
          <div class="card-icon">🔍</div>
          <h3><?php esc_html_e('Transparencia total', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Dashboard en tiempo real', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Reportes automáticos semanales', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Historial completo y trazabilidad', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== TESTIMONIOS + CONTACTO ========== -->
  <section class="section" id="contacto">
    <div class="container split-cta">
      <div>
        <span class="badge" data-animate><?php esc_html_e('Casos de éxito', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2" data-animate><?php esc_html_e('Lo que dicen nuestros clientes', 'twentytwentyfive-child'); ?></h2>
        
        <div class="testimonials-mini">
          <div class="quote-mini" data-animate>
            <strong><?php esc_html_e('Carlos M. — Propietario en Quito', 'twentytwentyfive-child'); ?></strong>
            <p>"<?php esc_html_e('Delegué la operación y ahora tengo ingresos 40% más estables. La plataforma con IA es increíble.', 'twentytwentyfive-child'); ?>"</p>
          </div>
          <div class="quote-mini" data-animate>
            <strong><?php esc_html_e('María L. — Dueña en Guayaquil', 'twentytwentyfive-child'); ?></strong>
            <p>"<?php esc_html_e('La limpieza y mantenimiento dejaron de ser mi problema. Todo está automatizado y bajo control.', 'twentytwentyfive-child'); ?>"</p>
          </div>
          <div class="quote-mini" data-animate>
            <strong><?php esc_html_e('Roberto S. — Inversionista', 'twentytwentyfive-child'); ?></strong>
            <p>"<?php esc_html_e('Tengo 5 propiedades y ahora las gestiono desde mi celular. El ROI mejoró significativamente.', 'twentytwentyfive-child'); ?>"</p>
          </div>
        </div>
      </div>

      <div class="contact-card" data-animate>
        <h2 class="h2"><?php esc_html_e('¿Listo para profesionalizar tu hospedaje?', 'twentytwentyfive-child'); ?></h2>
        <p class="p"><?php esc_html_e('Agenda una asesoría gratuita. Evaluamos tu propiedad y te mostramos el potencial real de ingresos.', 'twentytwentyfive-child'); ?></p>

        <div class="form-placeholder">
          <p class="small" style="margin:0;">
            <?php esc_html_e('Formulario de contacto', 'twentytwentyfive-child'); ?><br>
            <code>[contact-form-7 id="123"]</code>
          </p>
        </div>

        <a class="btn btn--primary btn--wide btn--lg" href="#">
          <?php esc_html_e('Agenda tu asesoría gratuita', 'twentytwentyfive-child'); ?>
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>

</main>

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

<?php get_footer(); ?>
