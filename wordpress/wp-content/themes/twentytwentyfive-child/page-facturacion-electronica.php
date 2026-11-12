<?php
/**
 * Facturación Electrónica — rediseño ArriendoFácil.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>

<?php $afx_img = get_stylesheet_directory_uri() . '/assets/img/'; ?>
<main id="main-content" class="afx-main afx-subhero afx-subhero--invoice" data-afx-page>
  <section class="afx-hero afx-hero--sub">
    <div class="afx-hero__bg" style="background-image:url('<?php echo esc_url( $afx_img . 'hero-arco.jpg' ); ?>')" role="img" aria-label="<?php esc_attr_e( 'Arquitectura residencial minimalista con arcos', 'twentytwentyfive-child' ); ?>"></div>
    <div class="afx-hero__tint" aria-hidden="true"></div>
    <svg class="afx-hero__wave" viewBox="0 0 1440 520" preserveAspectRatio="none" aria-hidden="true" focusable="false">
      <path class="afx-wave afx-wave--sage" d="M0 520C300 505 640 420 1000 250 1180 165 1330 110 1440 90V520Z" opacity=".55"/>
      <path class="afx-wave afx-wave--green" d="M520 520C800 470 1100 360 1440 210V520Z"/>
    </svg>

    <div class="afx-hero__grid">
      <div class="afx-hero__copy">
      <p class="afx-hero__tag" data-afx><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Facturación Electrónica', 'twentytwentyfive-child' ); ?></p>
      <h1 class="afx-hero__title" data-afx><?php esc_html_e( 'Cumple con el SRI', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'de forma automática', 'twentytwentyfive-child' ); ?></span></h1>
      <p class="afx-hero__lead" data-afx><?php esc_html_e( 'Genera y gestiona tus facturas electrónicas de manera rápida y segura.', 'twentytwentyfive-child' ); ?></p>
      <div class="afx-hero__cta" data-afx>
        <a class="afx-btn afx-btn--light afx-btn--lg" href="<?php echo esc_url( af_signup_url() ); ?>">
          <?php esc_html_e( 'Conocer más', 'twentytwentyfive-child' ); ?>
          <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        </a>
      </div>
    </div>

    <div class="afx-hero__visual afx-sub__visual" data-afx-tilt>
      <div class="afx-invoice" data-afx-card data-afx-depth="10">
        <div class="afx-invoice__sheet">
          <header>
            <h2><?php esc_html_e( 'FACTURA', 'twentytwentyfive-child' ); ?></h2>
            <span class="afx-invoice__sri">SRI</span>
          </header>
          <p class="afx-invoice__label"><?php esc_html_e( 'DATOS DEL EMISOR', 'twentytwentyfive-child' ); ?></p>
          <p class="afx-invoice__issuer">RUC: 1790012345001<br>ArriendoFácil<br>Quito, Ecuador</p>
          <p class="afx-invoice__no"><?php esc_html_e( 'FACTURA No.', 'twentytwentyfive-child' ); ?> 001-001-000124</p>
          <table>
            <thead><tr><th><?php esc_html_e( 'Descripción', 'twentytwentyfive-child' ); ?></th><th><?php esc_html_e( 'Cant.', 'twentytwentyfive-child' ); ?></th><th><?php esc_html_e( 'Total', 'twentytwentyfive-child' ); ?></th></tr></thead>
            <tbody>
              <tr><td><?php esc_html_e( 'Arriendo mensual', 'twentytwentyfive-child' ); ?></td><td>1</td><td>$850.00</td></tr>
              <tr><td colspan="2"><?php esc_html_e( 'Subtotal', 'twentytwentyfive-child' ); ?></td><td>$850.00</td></tr>
              <tr><td colspan="2">IVA</td><td>$0.00</td></tr>
              <tr class="is-total"><td colspan="2">TOTAL</td><td>$850.00</td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="afx-badge afx-badge--done" data-afx-depth="26">
        <span class="afx-badge__icon"><?php echo afx_icon( 'check', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <strong><?php esc_html_e( 'Factura emitida', 'twentytwentyfive-child' ); ?></strong><span><?php esc_html_e( 'con éxito', 'twentytwentyfive-child' ); ?></span>
      </div>
    </div>
    </div>
  </section>

  <div class="afx-wrap afx-features-wrap">
    <ul class="afx-features" data-afx>
      <li><span class="afx-features__icon"><?php echo afx_icon( 'file', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Facturación automática', 'twentytwentyfive-child' ); ?></strong><small><?php esc_html_e( 'Cumple con la normativa', 'twentytwentyfive-child' ); ?></small></span></li>
      <li><span class="afx-features__icon"><?php echo afx_icon( 'growth', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Reportes detallados', 'twentytwentyfive-child' ); ?></strong><small><?php esc_html_e( 'Controla tus ingresos', 'twentytwentyfive-child' ); ?></small></span></li>
      <li><span class="afx-features__icon"><?php echo afx_icon( 'file-down', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Descarga en PDF', 'twentytwentyfive-child' ); ?></strong><small><?php esc_html_e( 'Listo para imprimir', 'twentytwentyfive-child' ); ?></small></span></li>
    </ul>
  </div>
</main>

<?php get_footer(); ?>
