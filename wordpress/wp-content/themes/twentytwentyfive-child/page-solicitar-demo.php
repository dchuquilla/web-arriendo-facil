<?php
/**
 * Template Name: Solicitar Demo (Registro Administrador)
 * Página pública que conecta el botón "Solicita tu demo" con el flujo de
 * auto-registro del plugin (shortcode [af_property_admin_signup]).
 *
 * Layout: panel de marca (izquierda) + tarjeta de formulario (derecha),
 * en un contenedor amplio para aprovechar el ancho de pantalla.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<main id="main-content" class="af-demo-page">
  <div class="af-demo-shell">

    <div class="af-demo-grid">

      <!-- ── Panel de marca ─────────────────────────────────────── -->
      <aside class="af-demo-intro">
        <div class="af-demo-intro__block af-demo-intro__block--top">
          <span class="af-demo-eyebrow"><?php esc_html_e( 'Demo guiada · sin costo', 'twentytwentyfive-child' ); ?></span>
          <h1 class="af-demo-title"><?php esc_html_e( 'Crea tu cuenta y comienza a gestionar', 'twentytwentyfive-child' ); ?></h1>
          <p class="af-demo-lead"><?php esc_html_e( 'Regístrate en un minuto, verifica tu correo y entra a un panel con datos de ejemplo listos para explorar. No se solicita tarjeta de crédito.', 'twentytwentyfive-child' ); ?></p>
        </div>

        <ol class="af-demo-steps">
          <li>
            <span class="af-demo-steps__num" aria-hidden="true">1</span>
            <span class="af-demo-steps__txt">
              <strong><?php esc_html_e( 'Completa el formulario', 'twentytwentyfive-child' ); ?></strong>
              <span class="af-demo-steps__desc"><?php esc_html_e( 'Empresa, contacto e identificación.', 'twentytwentyfive-child' ); ?></span>
            </span>
          </li>
          <li>
            <span class="af-demo-steps__num" aria-hidden="true">2</span>
            <span class="af-demo-steps__txt">
              <strong><?php esc_html_e( 'Verifica tu correo', 'twentytwentyfive-child' ); ?></strong>
              <span class="af-demo-steps__desc"><?php esc_html_e( 'Haz clic en el enlace que te enviamos.', 'twentytwentyfive-child' ); ?></span>
            </span>
          </li>
          <li>
            <span class="af-demo-steps__num" aria-hidden="true">3</span>
            <span class="af-demo-steps__txt">
              <strong><?php esc_html_e( 'Explora el panel', 'twentytwentyfive-child' ); ?></strong>
              <span class="af-demo-steps__desc"><?php esc_html_e( 'Entra con datos de ejemplo ya cargados.', 'twentytwentyfive-child' ); ?></span>
            </span>
          </li>
        </ol>

        <div class="af-demo-intro__block">
          <span class="af-demo-includes__title"><?php esc_html_e( 'Tu demo incluye', 'twentytwentyfive-child' ); ?></span>
          <ul class="af-demo-includes">
            <li>
              <span class="af-demo-includes__name"><?php esc_html_e( 'Cobros y alícuotas', 'twentytwentyfive-child' ); ?></span>
              <span class="af-demo-includes__desc"><?php esc_html_e( 'Emite cobros y revisa pagos pendientes.', 'twentytwentyfive-child' ); ?></span>
            </li>
            <li>
              <span class="af-demo-includes__name"><?php esc_html_e( 'Contratos y documentos', 'twentytwentyfive-child' ); ?></span>
              <span class="af-demo-includes__desc"><?php esc_html_e( 'Guarda contratos e identificaciones firmadas.', 'twentytwentyfive-child' ); ?></span>
            </li>
            <li>
              <span class="af-demo-includes__name"><?php esc_html_e( 'Mantenimiento', 'twentytwentyfive-child' ); ?></span>
              <span class="af-demo-includes__desc"><?php esc_html_e( 'Registra solicitudes y da seguimiento a su resolución.', 'twentytwentyfive-child' ); ?></span>
            </li>
            <li>
              <span class="af-demo-includes__name"><?php esc_html_e( 'Inquilinos', 'twentytwentyfive-child' ); ?></span>
              <span class="af-demo-includes__desc"><?php esc_html_e( 'Historial de inquilinos, avisos y comunicación.', 'twentytwentyfive-child' ); ?></span>
            </li>
          </ul>
        </div>

        <div class="af-demo-note">
          <span class="af-demo-note__icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          </span>
          <p class="af-demo-note__txt">
            <strong><?php esc_html_e( 'Sin compromiso.', 'twentytwentyfive-child' ); ?></strong>
            <?php esc_html_e( 'Te acompañamos por chat y correo durante toda la prueba, sin pagos ni renovaciones automáticas.', 'twentytwentyfive-child' ); ?>
          </p>
        </div>

        <div class="af-demo-intro__foot">
          <div class="af-demo-stats">
            <div class="af-demo-stats__item">
              <b>+2.500</b>
              <span><?php esc_html_e( 'propiedades activas', 'twentytwentyfive-child' ); ?></span>
            </div>
            <div class="af-demo-stats__item">
              <b>99,7%</b>
              <span><?php esc_html_e( 'tasa de recaudo', 'twentytwentyfive-child' ); ?></span>
            </div>
            <div class="af-demo-stats__item">
              <b>&lt; 5 min</b>
              <span><?php esc_html_e( 'liquidación mensual', 'twentytwentyfive-child' ); ?></span>
            </div>
          </div>
          <p class="af-demo-help">
            <?php esc_html_e( '¿Tienes dudas? Escríbenos y te acompañamos.', 'twentytwentyfive-child' ); ?>
            <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Habla con nosotros', 'twentytwentyfive-child' ); ?> &rarr;</a>
          </p>

          <p class="af-demo-help af-demo-help--faq">
            <a href="<?php echo esc_url( home_url( '/contacto/#faq' ) ); ?>"><?php esc_html_e( 'Tengo dudas antes de empezar — ver preguntas frecuentes', 'twentytwentyfive-child' ); ?></a>
          </p>
        </div>
      </aside>

      <!-- ── Tarjeta de formulario ──────────────────────────────── -->
      <div class="af-demo-card">
        <?php echo do_shortcode( '[af_property_admin_signup]' ); ?>
      </div>

    </div>

  </div>
</main>

<?php get_footer(); ?>
