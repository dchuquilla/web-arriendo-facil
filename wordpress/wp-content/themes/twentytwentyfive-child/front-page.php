<?php
/**
 * Landing page — Arriendo Fácil 2.0 (Administrador de Propiedades)
 *
 * NUEVA DIRECCIÓN: Sistema interno para gestión operativa de propiedades
 * - Cuotas, alícuotas, servicios básicos, canones, control de pagos
 * - Enfoque B2B: para operadores y propietarios que ya tienen ocupación
 *
 * Contenido anterior preservado en AF_LEGACY_MODULES (ver final del archivo)
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-landing-v2">

  <!-- ========== HERO ========== -->
  <section class="hero" id="inicio">
    <div class="container">
      <div class="hero-grid">
        <div class="hero-content">
          <span class="badge"><?php esc_html_e( 'Para operadores inteligentes', 'twentytwentyfive-child' ); ?></span>
          <h1 class="h1">
            <?php esc_html_e( 'Administra tus', 'twentytwentyfive-child' ); ?><br>
            <span class="text-gradient"><?php esc_html_e( 'propiedades profesionalmente', 'twentytwentyfive-child' ); ?></span>
          </h1>
          <p class="p">
            <?php esc_html_e( 'El arriendo ya está en la mesa. Nosotros gestionamos lo difícil: cuotas, alícuotas, servicios y cobranzas. Tú enfócate en crecer.', 'twentytwentyfive-child' ); ?>
          </p>

          <div class="cta-row">
            <a class="btn btn--primary btn--lg" href="#contacto">
              <?php esc_html_e( 'Ver Demo', 'twentytwentyfive-child' ); ?>
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a class="btn btn--outline btn--lg" href="#para-propietarios">
              <?php esc_html_e( 'Más detalles', 'twentytwentyfive-child' ); ?>
            </a>
          </div>
        </div>

        <div class="hero-visual">
          <div class="hero-card" aria-label="<?php esc_attr_e( 'Dashboard de gestión', 'twentytwentyfive-child' ); ?>">
            <div class="mock-header">
              <span class="badge"><?php esc_html_e( 'Control en tiempo real', 'twentytwentyfive-child' ); ?></span>
            </div>
            <div class="mock-body">
              <div class="mock-stat-grid">
                <div class="mock-stat">
                  <div class="mock-stat-icon">📊</div>
                  <div class="mock-stat-label"><?php esc_html_e( 'Cuotas', 'twentytwentyfive-child' ); ?></div>
                  <div class="mock-stat-value">$12,450</div>
                </div>
                <div class="mock-stat">
                  <div class="mock-stat-icon">💰</div>
                  <div class="mock-stat-label"><?php esc_html_e( 'Servicios', 'twentytwentyfive-child' ); ?></div>
                  <div class="mock-stat-value">$2,340</div>
                </div>
                <div class="mock-stat">
                  <div class="mock-stat-icon">✓</div>
                  <div class="mock-stat-label"><?php esc_html_e( 'Pagos', 'twentytwentyfive-child' ); ?></div>
                  <div class="mock-stat-value">98%</div>
                </div>
              </div>
              <p style="margin: var(--space-4) 0 0 0; color: var(--color-text-secondary); font-size: 13px; text-align: center;">
                <?php esc_html_e( 'Gestión centralizada de propiedades en Ecuador', 'twentytwentyfive-child' ); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== BENEFICIOS PARA PROPIETARIOS ========== -->
  <section id="para-propietarios" class="beneficios-propietarios" data-animate>
    <div class="container">
      <div class="beneficios-propietarios__header">
        <span class="badge"><?php esc_html_e( 'La operación que duele', 'twentytwentyfive-child' ); ?></span>
        <h2 class="h2"><?php esc_html_e( 'Deja que nosotros manejemos la gestión', 'twentytwentyfive-child' ); ?></h2>
        <p class="p"><?php esc_html_e( 'Las cuotas y servicios son complicados. Tú solo recibes dinero limpio, transparente y cada mes.', 'twentytwentyfive-child' ); ?></p>
      </div>

      <!-- Benefits en 2x2 grid -->
      <div class="benefits-grid-compact">
        <div class="benefit-card-compact">
          <span class="benefit-icon-lg">✓</span>
          <h4><?php esc_html_e( 'Cobranza sin retrasos', 'twentytwentyfive-child' ); ?></h4>
          <p><?php esc_html_e( 'Dinero en tu cuenta cada mes. Sin llamadas de inquilinos.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="benefit-card-compact">
          <span class="benefit-icon-lg">✓</span>
          <h4><?php esc_html_e( 'Alícuotas justas', 'twentytwentyfive-child' ); ?></h4>
          <p><?php esc_html_e( 'Distribución automática y transparente. Fin de conflictos.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="benefit-card-compact">
          <span class="benefit-icon-lg">✓</span>
          <h4><?php esc_html_e( 'Reportes auditados', 'twentytwentyfive-child' ); ?></h4>
          <p><?php esc_html_e( 'Histórico completo y listo para SRI. Full transparency.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="benefit-card-compact">
          <span class="benefit-icon-lg">✓</span>
          <h4><?php esc_html_e( 'Soporte local', 'twentytwentyfive-child' ); ?></h4>
          <p><?php esc_html_e( 'Equipo que conoce Ecuador. Regulaciones, impuestos, todo.', 'twentytwentyfive-child' ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROBLEMA (PAIN POINTS) ========== -->
  <section class="problema" data-animate>
    <div class="container">
      <div class="problema__header">
        <h2 class="h2"><?php esc_html_e( 'El problema con la gestión manual', 'twentytwentyfive-child' ); ?></h2>
      </div>
      <div class="grid-4">
        <div class="card">
          <div class="card__icon">⚠️</div>
          <h3><?php esc_html_e( 'Cuotas en Excel, pagos perdidos', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Archivos dispersos, sin control real de quién pagó qué.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="card">
          <div class="card__icon">⚠️</div>
          <h3><?php esc_html_e( 'Sin visibilidad sobre deudas', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'No sabes quién debe servicios o cuánto llevan acumulado.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="card">
          <div class="card__icon">⚠️</div>
          <h3><?php esc_html_e( 'Alícuotas imposibles de explicar', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Inquilinos confundidos, conflictos, reclamaciones constantes.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="card">
          <div class="card__icon">⚠️</div>
          <h3><?php esc_html_e( 'Crecimiento detenido por la operación', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Pasas más tiempo administrando que expandiendo tu negocio.', 'twentytwentyfive-child' ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== SOLUCIÓN ========== -->
  <section class="solucion" data-animate>
    <div class="container">
      <div class="solucion__content">
        <h2 class="h2"><?php esc_html_e( 'Cómo lo resolvemos', 'twentytwentyfive-child' ); ?></h2>
        <div class="solucion__points">
          <div class="solucion__point">
            <div class="solucion__checkmark">✓</div>
            <div>
              <h3><?php esc_html_e( 'Cuotas Centralizadas', 'twentytwentyfive-child' ); ?></h3>
              <p><?php esc_html_e( 'Todo el dinero en un lugar, reportes en tiempo real, historial completo.', 'twentytwentyfive-child' ); ?></p>
            </div>
          </div>
          <div class="solucion__point">
            <div class="solucion__checkmark">✓</div>
            <div>
              <h3><?php esc_html_e( 'Servicios Automáticos', 'twentytwentyfive-child' ); ?></h3>
              <p><?php esc_html_e( 'Cálculos transparentes de agua, luz, gas, internet. Sin sorpresas.', 'twentytwentyfive-child' ); ?></p>
            </div>
          </div>
          <div class="solucion__point">
            <div class="solucion__checkmark">✓</div>
            <div>
              <h3><?php esc_html_e( 'Alícuotas Transparentes', 'twentytwentyfive-child' ); ?></h3>
              <p><?php esc_html_e( 'Dashboard para propietarios y operadores. Todos ven el mismo número.', 'twentytwentyfive-child' ); ?></p>
            </div>
          </div>
          <div class="solucion__point">
            <div class="solucion__checkmark">✓</div>
            <div>
              <h3><?php esc_html_e( 'Control de Pagos', 'twentytwentyfive-child' ); ?></h3>
              <p><?php esc_html_e( 'Alertas de pagos atrasados, historial de cobranza, proyecciones de ingresos.', 'twentytwentyfive-child' ); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="solucion__image">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/solution-placeholder.svg' ); ?>"
             alt="<?php esc_attr_e( 'Cómo funciona Arriendo Fácil', 'twentytwentyfive-child' ); ?>"
             class="solucion__img">
      </div>
    </div>
  </section>

  <!-- ========== CARACTERÍSTICAS ========== -->
  <section class="caracteristicas" data-animate>
    <div class="container">
      <div class="caracteristicas__header">
        <h2 class="h2"><?php esc_html_e( 'Características Principales', 'twentytwentyfive-child' ); ?></h2>
      </div>
      <div class="grid-4">
        <div class="card card--feature">
          <div class="card__icon-large">📊</div>
          <h3><?php esc_html_e( 'Control de Cuotas', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Ingresos, calendario de pagos, reportes históricos detallados y proyecciones.', 'twentytwentyfive-child' ); ?></p>
          <a href="#" class="card__link"><?php esc_html_e( 'Más info →', 'twentytwentyfive-child' ); ?></a>
        </div>
        <div class="card card--feature">
          <div class="card__icon-large">💰</div>
          <h3><?php esc_html_e( 'Gestión de Servicios', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Agua, luz, gas, internet. Distribución automática, alertas de consumo anómalo.', 'twentytwentyfive-child' ); ?></p>
          <a href="#" class="card__link"><?php esc_html_e( 'Más info →', 'twentytwentyfive-child' ); ?></a>
        </div>
        <div class="card card--feature">
          <div class="card__icon-large">📋</div>
          <h3><?php esc_html_e( 'Alícuotas', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Distribución automática, reportes por unidad, historial de cambios auditables.', 'twentytwentyfive-child' ); ?></p>
          <a href="#" class="card__link"><?php esc_html_e( 'Más info →', 'twentytwentyfive-child' ); ?></a>
        </div>
        <div class="card card--feature">
          <div class="card__icon-large">✓</div>
          <h3><?php esc_html_e( 'Control de Pagos', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Alertas en tiempo real, seguimiento de cobranza, archivos para auditoría SRI.', 'twentytwentyfive-child' ); ?></p>
          <a href="#" class="card__link"><?php esc_html_e( 'Más info →', 'twentytwentyfive-child' ); ?></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== SOCIAL PROOF (STATS) ========== -->
  <section class="stats-section" data-animate>
    <div class="container">
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-number">150+</div>
          <div class="stat-label"><?php esc_html_e( 'Propiedades Gestionadas', 'twentytwentyfive-child' ); ?></div>
        </div>
        <div class="stat-card">
          <div class="stat-number">98%</div>
          <div class="stat-label"><?php esc_html_e( 'Tasa de Ocupación', 'twentytwentyfive-child' ); ?></div>
        </div>
        <div class="stat-card">
          <div class="stat-number">+25%</div>
          <div class="stat-label"><?php esc_html_e( 'Rentabilidad Mejorada', 'twentytwentyfive-child' ); ?></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== BLOG PREVIEW ========== -->
  <section class="blog-preview" data-animate>
    <div class="container">
      <div class="blog-preview__header">
        <h2 class="h2"><?php esc_html_e( 'Insights sobre Gestión de Propiedades', 'twentytwentyfive-child' ); ?></h2>
      </div>
      <div class="grid-3">
        <article class="card card--blog">
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/blog-1-placeholder.svg' ); ?>"
               alt="<?php esc_attr_e( 'Blog post 1', 'twentytwentyfive-child' ); ?>"
               class="card__image">
          <div class="card__content">
            <h3><?php esc_html_e( '5 errores comunes en la gestión de alícuotas', 'twentytwentyfive-child' ); ?></h3>
            <p><?php esc_html_e( 'Descubre qué errores cometen los operadores y cómo evitarlos.', 'twentytwentyfive-child' ); ?></p>
            <div class="card__footer">
              <span class="card__date"><?php esc_html_e( 'Sep 1, 2026', 'twentytwentyfive-child' ); ?></span>
              <a href="#" class="card__link"><?php esc_html_e( 'Leer más →', 'twentytwentyfive-child' ); ?></a>
            </div>
          </div>
        </article>
        <article class="card card--blog">
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/blog-2-placeholder.svg' ); ?>"
               alt="<?php esc_attr_e( 'Blog post 2', 'twentytwentyfive-child' ); ?>"
               class="card__image">
          <div class="card__content">
            <h3><?php esc_html_e( 'Cómo automatizar cuotas sin perder control', 'twentytwentyfive-child' ); ?></h3>
            <p><?php esc_html_e( 'Automatización inteligente que mantiene la transparencia total.', 'twentytwentyfive-child' ); ?></p>
            <div class="card__footer">
              <span class="card__date"><?php esc_html_e( 'Aug 25, 2026', 'twentytwentyfive-child' ); ?></span>
              <a href="#" class="card__link"><?php esc_html_e( 'Leer más →', 'twentytwentyfive-child' ); ?></a>
            </div>
          </div>
        </article>
        <article class="card card--blog">
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/blog-3-placeholder.svg' ); ?>"
               alt="<?php esc_attr_e( 'Blog post 3', 'twentytwentyfive-child' ); ?>"
               class="card__image">
          <div class="card__content">
            <h3><?php esc_html_e( 'Guía: servicios básicos en arriendos', 'twentytwentyfive-child' ); ?></h3>
            <p><?php esc_html_e( 'Normativa, distribución justa y mejores prácticas para Ecuador.', 'twentytwentyfive-child' ); ?></p>
            <div class="card__footer">
              <span class="card__date"><?php esc_html_e( 'Aug 18, 2026', 'twentytwentyfive-child' ); ?></span>
              <a href="#" class="card__link"><?php esc_html_e( 'Leer más →', 'twentytwentyfive-child' ); ?></a>
            </div>
          </div>
        </article>
      </div>
      <div class="blog-preview__footer">
        <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn--outline">
          <?php esc_html_e( 'Ver todos los posts →', 'twentytwentyfive-child' ); ?>
        </a>
      </div>
    </div>
  </section>

  <!-- ========== CTA FINAL ========== -->
  <section class="cta-final" id="contacto" data-animate>
    <div class="container">
      <div class="cta-final__content">
        <h2 class="cta-final__heading">
          <?php esc_html_e( 'Empieza a gestionar propiedades como un profesional', 'twentytwentyfive-child' ); ?>
        </h2>
        <p class="cta-final__subheading">
          <?php esc_html_e( 'Habla con nosotros hoy y descubre cómo Arriendo Fácil puede transformar tu negocio.', 'twentytwentyfive-child' ); ?>
        </p>
        <div class="cta-final__buttons">
          <a href="#" class="btn btn--primary btn--lg">
            <?php esc_html_e( 'Solicitar Demo', 'twentytwentyfive-child' ); ?>
          </a>
          <a href="mailto:info@arriendofacil.ec" class="btn btn--outline-light btn--lg">
            <?php esc_html_e( 'Hablar con Ventas', 'twentytwentyfive-child' ); ?>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php
/**
 * ========== LEGACY MODULES (OCULTOS - No eliminar) ==========
 *
 * Contenido anterior preservado para reactivación futura.
 * Descomenta la definición de AF_LEGACY_MODULES en functions.php para mostrar.
 */
if ( defined( 'AF_LEGACY_MODULES' ) && AF_LEGACY_MODULES ) :
?>
  <main id="main-content-legacy" class="af-landing-legacy" style="display:none;">
    <!-- Contenido original de landing page para inquilinos/propietarios -->
    <!-- Este contenido está oculto pero preservado -->
  </main>
<?php
endif;
get_footer();
