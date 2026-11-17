<?php
/**
 * Template Name: Registro de Administrador
 * Página pública de registro: conecta los botones "Crear mi cuenta" con el flujo de
 * auto-registro del plugin (shortcode [af_property_admin_signup]).
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$td = 'twentytwentyfive-child';
?>

<main id="main-content" class="afx-main afx-reg">
  <?php echo afx_waves( 'soft' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
  <div class="afx-wrap afx-reg__grid">

    <aside class="afx-reg__intro" data-afx-reg-intro>
      <span class="afx-tag"><?php echo afx_icon( 'building', 16 ); // phpcs:ignore ?> <?php esc_html_e( 'Para administradores de propiedades', $td ); ?></span>
      <h1 class="afx-title afx-reg__title">
        <?php esc_html_e( 'Crea tu cuenta y', $td ); ?>
        <span><?php esc_html_e( 'empieza a gestionar', $td ); ?></span>
      </h1>
      <p class="afx-reg__lead"><?php esc_html_e( 'Inmuebles, contratos, inquilinos, mantenimiento y pagos en un solo panel. Empiezas con el plan Free, sin tarjeta y sin compromiso.', $td ); ?></p>

      <ol class="afx-reg__steps">
        <li data-afx-reg-item>
          <span class="afx-reg__step-num" aria-hidden="true">1</span>
          <span><strong><?php esc_html_e( 'Completa el formulario', $td ); ?></strong><?php esc_html_e( 'Datos de tu empresa o gestión e identificación.', $td ); ?></span>
        </li>
        <li data-afx-reg-item>
          <span class="afx-reg__step-num" aria-hidden="true">2</span>
          <span><strong><?php esc_html_e( 'Verifica tu correo', $td ); ?></strong><?php esc_html_e( 'Confirma el enlace que te enviaremos (vigente 24 horas).', $td ); ?></span>
        </li>
        <li data-afx-reg-item>
          <span class="afx-reg__step-num" aria-hidden="true">3</span>
          <span><strong><?php esc_html_e( 'Entra a tu panel', $td ); ?></strong><?php esc_html_e( 'Registra tus inmuebles y administra tu cartera.', $td ); ?></span>
        </li>
      </ol>

      <ul class="afx-reg__perks">
        <li data-afx-reg-item><?php echo afx_icon( 'home', 18 ); // phpcs:ignore ?><span><?php esc_html_e( 'Gestión de inmuebles, contratos e inquilinos', $td ); ?></span></li>
        <li data-afx-reg-item><?php echo afx_icon( 'wrench', 18 ); // phpcs:ignore ?><span><?php esc_html_e( 'Mantenimiento con proveedores y costos', $td ); ?></span></li>
        <li data-afx-reg-item><?php echo afx_icon( 'wallet', 18 ); // phpcs:ignore ?><span><?php esc_html_e( 'Control de pagos y, como complemento, facturación electrónica SRI', $td ); ?></span></li>
        <li data-afx-reg-item><?php echo afx_icon( 'shield', 18 ); // phpcs:ignore ?><span><?php esc_html_e( 'Teléfono e identificación cifrados en nuestros sistemas', $td ); ?></span></li>
      </ul>

      <p class="afx-reg__help">
        <?php esc_html_e( '¿Tienes dudas antes de empezar?', $td ); ?>
        <a href="<?php echo esc_url( home_url( '/preguntas-frecuentes/' ) ); ?>"><?php esc_html_e( 'Preguntas frecuentes', $td ); ?></a>
        <span aria-hidden="true">·</span>
        <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contáctanos', $td ); ?></a>
      </p>
    </aside>

    <div class="afx-reg__card" data-afx-reg-card>
      <?php echo do_shortcode( '[af_property_admin_signup]' ); ?>
    </div>

  </div>
</main>

<?php get_footer(); ?>
