<?php
/**
 * Página 404 - Arriendo Fácil
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$td    = 'twentytwentyfive-child';
$links = array(
  array( 'home',   __( 'Inicio', $td ),               __( 'Vuelve a la portada', $td ),            home_url( '/' ) ),
  array( 'wallet', __( 'Pagos y cobros', $td ),       __( 'Seguimiento de tus pagos', $td ),       home_url( '/pagos-y-cobros/' ) ),
  array( 'crown',  __( 'Planes', $td ),               __( 'Free, Básico y Profesional', $td ),     home_url( '/#planes' ) ),
  array( 'mail',   __( 'Contacto', $td ),             __( 'Escríbenos, te ayudamos', $td ),        home_url( '/contacto/' ) ),
);
?>

<main id="main-content" class="afx-main afx-404">
  <?php echo afx_waves( 'soft' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
  <div class="afx-wrap afx-404__grid">

    <div class="afx-404__copy">
      <span class="afx-tag" data-afx-404-in><?php echo afx_icon( 'alert', 16 ); // phpcs:ignore ?> <?php esc_html_e( 'Error 404', $td ); ?></span>
      <h1 class="afx-title afx-title--xl" data-afx-404-in>
        <?php esc_html_e( 'Este lugar', $td ); ?>
        <span><?php esc_html_e( 'ya no está disponible', $td ); ?></span>
      </h1>
      <p class="afx-404__lead" data-afx-404-in><?php esc_html_e( 'La página que buscas no existe, cambió de dirección o fue retirada. Vuelve al inicio o ve directo a una de estas secciones.', $td ); ?></p>

      <div class="afx-404__cta" data-afx-404-in>
        <a class="afx-btn afx-btn--grad afx-btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <?php echo afx_icon( 'home', 20 ); // phpcs:ignore ?>
          <?php esc_html_e( 'Volver al inicio', $td ); ?>
        </a>
        <a class="afx-btn afx-btn--soft afx-btn--lg" href="<?php echo esc_url( af_custom_login_base_url() ); ?>">
          <?php esc_html_e( 'Iniciar sesión', $td ); ?>
        </a>
      </div>

      <ul class="afx-404__links">
        <?php foreach ( $links as $l ) : ?>
          <li data-afx-404-in>
            <a href="<?php echo esc_url( $l[3] ); ?>">
              <span class="afx-404__link-icon"><?php echo afx_icon( $l[0], 20 ); // phpcs:ignore ?></span>
              <span><strong><?php echo esc_html( $l[1] ); ?></strong><?php echo esc_html( $l[2] ); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="afx-404__visual" data-afx-404-scene aria-hidden="true">
      <svg class="afx-404__svg" viewBox="0 0 520 380" focusable="false">
        <defs>
          <linearGradient id="afx404Glow" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#e3b64d"/>
            <stop offset="1" stop-color="#bddb98"/>
          </linearGradient>
        </defs>
        <ellipse class="afx-404__ground" cx="260" cy="338" rx="235" ry="16"/>

        <text class="afx-404__digit" data-d="1" x="82" y="318" text-anchor="middle">4</text>
        <text class="afx-404__digit" data-d="2" x="438" y="318" text-anchor="middle">4</text>

        <g class="afx-404__house" data-house>
          <polygon class="afx-404__roof" points="158,152 260,66 362,152"/>
          <rect class="afx-404__body" x="178" y="150" width="164" height="164" rx="6"/>
          <rect class="afx-404__window" x="194" y="172" width="30" height="30" rx="4"/>
          <rect class="afx-404__window" x="296" y="172" width="30" height="30" rx="4"/>
          <path class="afx-404__inside" d="M232 314V242a28 28 0 0 1 56 0v72Z"/>
          <path class="afx-404__glow" d="M240 314v-70a20 20 0 0 1 40 0v70Z"/>
          <g class="afx-404__door" data-door>
            <path class="afx-404__door-panel" d="M232 314V242a28 28 0 0 1 56 0v72Z"/>
            <circle class="afx-404__knob" cx="276" cy="276" r="4"/>
            <circle class="afx-404__keyhole" cx="260" cy="256" r="6"/>
            <path class="afx-404__keyhole" d="M257 258h6l2 16h-10Z"/>
          </g>
        </g>

        <g class="afx-404__sign" data-sign>
          <path class="afx-404__bracket" d="M338 196h66"/>
          <path class="afx-404__rope" d="M356 196v24M394 196v24"/>
          <rect class="afx-404__board" x="338" y="220" width="76" height="44" rx="8"/>
          <text class="afx-404__board-text" x="376" y="238" text-anchor="middle">SE</text>
          <text class="afx-404__board-text afx-404__board-text--b" x="376" y="254" text-anchor="middle">ARRIENDA</text>
        </g>
      </svg>
    </div>

  </div>
</main>

<?php get_footer(); ?>
