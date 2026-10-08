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
        <span class="pms-eyebrow pms-eyebrow--light"><?php esc_html_e( 'Software para gestores de propiedades', 'twentytwentyfive-child' ); ?></span>
        <h1>
          <?php esc_html_e( 'Gestiona más propiedades.', 'twentytwentyfive-child' ); ?><br>
          <?php esc_html_e( 'Con menos esfuerzo.', 'twentytwentyfive-child' ); ?>
        </h1>
        <p class="pms-hero__sub">
          <?php esc_html_e( 'Facturación SRI, control de pagos y mantenimiento en un solo panel.', 'twentytwentyfive-child' ); ?>
        </p>

        <div class="pms-hero__ctas">
          <a class="btn btn--primary btn--lg" href="<?php echo esc_url( af_signup_url() ); ?>">
            <?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?>
          </a>
          <a class="pms-hero__link" href="#como-funciona">
            <?php esc_html_e( 'Conoce cómo funciona →', 'twentytwentyfive-child' ); ?>
          </a>
        </div>

        <div class="pms-hero__stats">
          <div class="pms-hero__stat pms-hero__stat--green">
            <span class="pms-hero__stat-icon" aria-hidden="true">🏠</span>
            <div class="pms-hero__stat-num">1 panel</div>
            <div class="pms-hero__stat-label"><?php esc_html_e( 'para toda tu cartera', 'twentytwentyfive-child' ); ?></div>
          </div>
          <div class="pms-hero__stat pms-hero__stat--blue">
            <span class="pms-hero__stat-icon" aria-hidden="true">💰</span>
            <div class="pms-hero__stat-num">SRI</div>
            <div class="pms-hero__stat-label"><?php esc_html_e( 'facturación electrónica integrada', 'twentytwentyfive-child' ); ?></div>
          </div>
          <div class="pms-hero__stat pms-hero__stat--amber">
            <span class="pms-hero__stat-icon" aria-hidden="true">⚡</span>
            <div class="pms-hero__stat-num">Día 1</div>
            <div class="pms-hero__stat-label"><?php esc_html_e( 'detección automática de mora', 'twentytwentyfive-child' ); ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== POR QUÉ ARRIENDO FÁCIL (cards → detalle) ========== -->
  <section id="servicios" class="pms-section" data-animate>
    <div class="container">
      <div class="pms-section__header">
        <span class="pms-eyebrow"><?php esc_html_e( 'Todo lo que necesita un gestor de propiedades', 'twentytwentyfive-child' ); ?></span>
        <h2 class="h2"><?php esc_html_e( 'Facturación en regla, propiedad cuidada', 'twentytwentyfive-child' ); ?></h2>
        <p><?php esc_html_e( 'Una plataforma para facturar, dar seguimiento a contratos y mantener tu cartera al día.', 'twentytwentyfive-child' ); ?></p>
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
        <span class="pms-eyebrow"><?php esc_html_e( 'Lo que automatiza el sistema', 'twentytwentyfive-child' ); ?></span>
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
        <h2 class="h2"><?php esc_html_e( 'Empieza hoy. Gestiona todo desde un panel.', 'twentytwentyfive-child' ); ?></h2>
        <p><?php esc_html_e( 'Tres pasos para ordenar tu operación.', 'twentytwentyfive-child' ); ?></p>
      </div>

      <div class="pms-steps">
        <div class="pms-step pms-step--blue">
          <span class="pms-step__icon" aria-hidden="true">📤</span>
          <div class="pms-step__num">1</div>
          <h3><?php esc_html_e( 'Crea tu cuenta', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Regístrate y verifica tu correo. Tu espacio de trabajo queda listo en minutos.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="pms-step pms-step--violet">
          <span class="pms-step__icon" aria-hidden="true">⚙️</span>
          <div class="pms-step__num">2</div>
          <h3><?php esc_html_e( 'Carga tu cartera', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Registra edificios, propiedades, inquilinos y contratos.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <div class="pms-step pms-step--green">
          <span class="pms-step__icon" aria-hidden="true">💸</span>
          <div class="pms-step__num">3</div>
          <h3><?php esc_html_e( 'Gestiona con el sistema', 'twentytwentyfive-child' ); ?></h3>
          <p><?php esc_html_e( 'Facturación SRI, control de pagos, mantenimiento y liquidaciones desde un solo panel.', 'twentytwentyfive-child' ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CTA FINAL ========== -->
  <section class="pms-cta" id="contacto" data-animate>
    <div class="container">
      <div class="pms-cta__content">
        <span class="pms-eyebrow pms-eyebrow--light"><?php esc_html_e( 'Crea tu cuenta en minutos', 'twentytwentyfive-child' ); ?></span>
        <h2><?php esc_html_e( '¿Listo para gestionar tus propiedades con menos esfuerzo?', 'twentytwentyfive-child' ); ?></h2>
        <p><?php esc_html_e( 'Regístrate, verifica tu correo y empieza a organizar tu cartera hoy.', 'twentytwentyfive-child' ); ?></p>
        <div class="pms-cta__buttons">
          <a href="<?php echo esc_url( af_signup_url() ); ?>" class="btn btn--primary btn--lg">
            <?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?>
          </a>
          <a href="#como-funciona" class="pms-cta__link">
            <?php esc_html_e( 'Ver cómo funciona →', 'twentytwentyfive-child' ); ?>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer();
