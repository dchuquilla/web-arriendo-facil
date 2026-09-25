<?php
/**
 * Landing page — Arriendo Fácil (modelo PMS interno)
 *
 * Secciones: hero, "Por qué Arriendo Fácil", "Qué gestionamos por ti"
 * (tarjetas con volteo 3D), "Cómo operamos" (3 pasos) y CTA final.
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-landing-v2">

  <!-- ========== HERO ========== -->
  <section class="pms-hero" id="inicio">
    <div class="container">
      <div class="pms-hero__content">
        <span class="pms-eyebrow pms-eyebrow--light"><?php esc_html_e( 'Administración de arriendos sin complicaciones', 'twentytwentyfive-child' ); ?></span>
        <h1>
          <?php esc_html_e( 'Ya está arrendada.', 'twentytwentyfive-child' ); ?><br>
          <?php esc_html_e( 'Nosotros la operamos.', 'twentytwentyfive-child' ); ?>
        </h1>
        <p class="pms-hero__sub">
          <?php esc_html_e( 'Cobramos, facturamos y cuidamos tu propiedad. Tú solo recibes el pago.', 'twentytwentyfive-child' ); ?>
        </p>

        <div class="pms-hero__ctas">
          <a class="btn btn--primary btn--lg" href="#como-funciona">
            <?php esc_html_e( 'Conoce cómo funciona', 'twentytwentyfive-child' ); ?>
          </a>
          <a class="pms-hero__link" href="<?php echo esc_url( af_demo_preview_url() ); ?>">
            <?php esc_html_e( 'Ver demo →', 'twentytwentyfive-child' ); ?>
          </a>
        </div>

        <div class="pms-hero__stats">
          <div class="pms-hero__stat">
            <div class="pms-hero__stat-num">+2,500</div>
            <div class="pms-hero__stat-label"><?php esc_html_e( 'propiedades activas', 'twentytwentyfive-child' ); ?></div>
          </div>
          <div class="pms-hero__stat">
            <div class="pms-hero__stat-num">99.7%</div>
            <div class="pms-hero__stat-label"><?php esc_html_e( 'tasa de recaudo', 'twentytwentyfive-child' ); ?></div>
          </div>
          <div class="pms-hero__stat">
            <div class="pms-hero__stat-num">&lt; 5 min</div>
            <div class="pms-hero__stat-label"><?php esc_html_e( 'liquidación mensual', 'twentytwentyfive-child' ); ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== POR QUÉ ARRIENDO FÁCIL (cards → detalle) ========== -->
  <section id="servicios" class="pms-section" data-animate>
    <div class="container">
      <div class="pms-section__header">
        <span class="pms-eyebrow"><?php esc_html_e( 'Por qué somos tu mejor opción', 'twentytwentyfive-child' ); ?></span>
        <h2 class="h2"><?php esc_html_e( 'Cobras sin perseguir pagos', 'twentytwentyfive-child' ); ?></h2>
        <p><?php esc_html_e( 'Desde el día uno nosotros operamos tu arriendo para que tú solo revises y cobres.', 'twentytwentyfive-child' ); ?></p>
      </div>

      <div class="af-svc-grid af-svc-grid--why">
        <?php foreach ( array_values( af_service_cards( 'why' ) ) as $i => $srv ) : ?>
          <a class="af-svc-card af-svc-card--<?php echo esc_attr( $srv['accent'] ); ?><?php echo 'reportes-mensuales' === $srv['slug'] ? ' af-svc-card--featured' : ''; ?>" href="<?php echo esc_url( af_service_detail_url( $srv['slug'] ) ); ?>" aria-label="<?php echo esc_attr( $srv['card_title'] . ' — toca para ver más' ); ?>">
            <span class="af-svc-card__idx"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
            <span class="af-svc-card__icon af-svc-card__icon--<?php echo esc_attr( $srv['accent'] ); ?>"><?php echo esc_html( $srv['icon'] ); ?></span>
            <span class="af-svc-card__body">
              <span class="af-svc-card__title"><?php echo esc_html( $srv['card_title'] ); ?></span>
              <span class="af-svc-card__desc"><?php echo esc_html( $srv['card_desc'] ); ?></span>
            </span>
            <span class="af-svc-card__more"><?php esc_html_e( 'Toca para ver más', 'twentytwentyfive-child' ); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ========== QUÉ GESTIONAMOS POR TI (cards → detalle) ========== -->
  <section class="pms-section pms-section--muted" data-animate>
    <div class="container">
      <div class="pms-section__header">
        <span class="pms-eyebrow"><?php esc_html_e( 'Lo que hacemos por ti', 'twentytwentyfive-child' ); ?></span>
        <h2 class="h2"><?php esc_html_e( 'Así funciona por dentro', 'twentytwentyfive-child' ); ?></h2>
      </div>

      <div class="af-svc-grid af-svc-grid--auto">
        <?php foreach ( array_values( af_service_cards( 'auto' ) ) as $i => $srv ) : ?>
          <a class="af-svc-card af-svc-card--compact af-svc-card--<?php echo esc_attr( $srv['accent'] ); ?>" href="<?php echo esc_url( af_service_detail_url( $srv['slug'] ) ); ?>" aria-label="<?php echo esc_attr( $srv['title'] . ' — toca para ver más' ); ?>">
            <span class="af-svc-card__idx"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
            <span class="af-svc-card__icon af-svc-card__icon--<?php echo esc_attr( $srv['accent'] ); ?>"><?php echo esc_html( $srv['icon'] ); ?></span>
            <span class="af-svc-card__title"><?php echo esc_html( $srv['title'] ); ?></span>
            <span class="af-svc-card__more"><?php esc_html_e( 'Toca para ver más', 'twentytwentyfive-child' ); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ========== CÓMO OPERAMOS ========== -->
  <section id="como-funciona" class="pms-section" data-animate>
    <div class="container">
      <div class="pms-section__header">
        <span class="pms-eyebrow"><?php esc_html_e( 'Cómo funciona', 'twentytwentyfive-child' ); ?></span>
        <h2 class="h2"><?php esc_html_e( 'Empiezas hoy. Cobras este mes.', 'twentytwentyfive-child' ); ?></h2>
        <p><?php esc_html_e( 'Tres pasos simples para despreocuparte de la gestión y dedicarte a lo que importa.', 'twentytwentyfive-child' ); ?></p>
      </div>

      <div class="pms-steps">
        <div class="pms-step">
          <div class="pms-step__num">1</div>
          <h3><?php esc_html_e( 'Sube tu inmueble', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Carga el contrato y los datos de la propiedad. Nosotros armamos todo tu perfil en minutos.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="pms-step">
          <div class="pms-step__num">2</div>
          <h3><?php esc_html_e( 'Nosotros operamos', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Facturamos, cobramos, calculamos servicios y coordinamos el mantenimiento sin que intervengas.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="pms-step">
          <div class="pms-step__num">3</div>
          <h3><?php esc_html_e( 'Recibes tu dinero', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Cada mes te transferimos tu saldo limpio con un reporte claro, detallado y puntual.', 'twentytwentyfive-child' ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CTA FINAL ========== -->
  <section class="pms-cta" id="contacto" data-animate>
    <div class="container">
      <div class="pms-cta__content">
        <span class="pms-eyebrow pms-eyebrow--light"><?php esc_html_e( 'Pruébalo sin compromiso', 'twentytwentyfive-child' ); ?></span>
        <h2><?php esc_html_e( '¿Listo para cobrar sin perseguir?', 'twentytwentyfive-child' ); ?></h2>
        <p><?php esc_html_e( 'Agenda una demo y descubre cómo Arriendo Fácil se encarga de todo desde el primer mes.', 'twentytwentyfive-child' ); ?></p>
        <div class="pms-cta__buttons">
          <a href="<?php echo esc_url( af_demo_preview_url() ); ?>" class="btn btn--primary btn--lg">
            <?php esc_html_e( 'Solicita tu demo', 'twentytwentyfive-child' ); ?>
          </a>
          <a href="#como-funciona" class="pms-cta__link">
            <?php esc_html_e( 'Ver cómo funciona →', 'twentytwentyfive-child' ); ?>
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