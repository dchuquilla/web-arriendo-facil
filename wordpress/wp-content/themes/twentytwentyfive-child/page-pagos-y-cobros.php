<?php
/**
 * Pagos y Cobros — rediseño ArriendoFácil.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_rows = array(
  array( __( 'Edificio Los Álamos', 'twentytwentyfive-child' ), '$850.00', true, 'center 20%' ),
  array( __( 'Suite Horizonte', 'twentytwentyfive-child' ), '$720.00', false, 'center 52%' ),
  array( __( 'Departamento Norte', 'twentytwentyfive-child' ), '$780.00', true, 'center 85%' ),
);
?>

<?php $afx_img = get_stylesheet_directory_uri() . '/assets/img/'; ?>
<main id="main-content" class="afx-main afx-subhero afx-subhero--payments" data-afx-page>
  <section class="afx-hero afx-hero--sub">
    <div class="afx-hero__bg" style="background-image:url('<?php echo esc_url( $afx_img . 'hero-recepcion.jpg' ); ?>')" role="img" aria-label="<?php esc_attr_e( 'Recepción de un edificio residencial moderno', 'twentytwentyfive-child' ); ?>"></div>
    <div class="afx-hero__tint" aria-hidden="true"></div>
    <svg class="afx-hero__wave" viewBox="0 0 1440 520" preserveAspectRatio="none" aria-hidden="true" focusable="false">
      <path class="afx-wave afx-wave--sage" d="M0 520C300 505 640 420 1000 250 1180 165 1330 110 1440 90V520Z" opacity=".55"/>
      <path class="afx-wave afx-wave--green" d="M520 520C800 470 1100 360 1440 210V520Z"/>
    </svg>

    <div class="afx-hero__grid">
      <div class="afx-hero__copy">
      <p class="afx-hero__tag" data-afx><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Pagos y Cobros', 'twentytwentyfive-child' ); ?></p>
      <h1 class="afx-hero__title" data-afx><?php esc_html_e( 'Controla tus pagos', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'en tiempo real', 'twentytwentyfive-child' ); ?></span></h1>
      <p class="afx-hero__lead" data-afx><?php esc_html_e( 'Visualiza el estado de tus pagos, recibe notificaciones y mantén un control total.', 'twentytwentyfive-child' ); ?></p>
      <div class="afx-hero__cta" data-afx>
        <a class="afx-btn afx-btn--light afx-btn--lg" href="<?php echo esc_url( af_signup_url() ); ?>">
          <?php esc_html_e( 'Conocer más', 'twentytwentyfive-child' ); ?>
          <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        </a>
      </div>
    </div>

    <div class="afx-hero__visual afx-sub__visual" data-afx-tilt>
      <div class="afx-paycard" data-afx-card data-afx-depth="10">
        <div class="afx-paycard__head">
          <h2><?php esc_html_e( 'Pagos', 'twentytwentyfive-child' ); ?></h2>
        </div>
        <ul class="afx-paycard__list">
          <?php foreach ( $afx_rows as $row ) : ?>
            <li class="afx-pay">
              <?php echo afx_property_thumb( $row[3] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              <span class="afx-pay__name"><?php echo esc_html( $row[0] ); ?></span>
              <b class="afx-pay__amount"><?php echo esc_html( $row[1] ); ?></b>
              <span class="afx-chip<?php echo $row[2] ? '' : ' afx-chip--pending'; ?>"><?php echo $row[2] ? esc_html__( 'Pagado', 'twentytwentyfive-child' ) : esc_html__( 'Pendiente', 'twentytwentyfive-child' ); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <a class="afx-paycard__all" href="<?php echo esc_url( af_signup_url() ); ?>"><?php esc_html_e( 'Ver todos', 'twentytwentyfive-child' ); ?> <?php echo afx_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
        <span class="afx-paycard__check" data-afx-depth="22"><?php echo afx_icon( 'check', 24 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
      </div>
    </div>
    </div>
  </section>

  <div class="afx-wrap afx-features-wrap">
    <ul class="afx-features" data-afx>
      <li><span class="afx-features__icon"><?php echo afx_icon( 'hex', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Seguimiento en tiempo real', 'twentytwentyfive-child' ); ?></strong></span></li>
      <li><span class="afx-features__icon"><?php echo afx_icon( 'bell', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Notificaciones automáticas', 'twentytwentyfive-child' ); ?></strong></span></li>
      <li><span class="afx-features__icon"><?php echo afx_icon( 'clock', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Historial completo', 'twentytwentyfive-child' ); ?></strong></span></li>
    </ul>
  </div>
</main>

<?php get_footer(); ?>
