<?php
/**
 * Template Name: Solicitar Demo (Registro Administrador)
 * Página pública que conecta el botón "Solicita tu demo" con el flujo de
 * auto-registro del plugin (shortcode [af_property_admin_signup]).
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<style>
  .af-signup-split { display:grid; grid-template-columns:1fr minmax(380px,440px); gap:48px; align-items:start; padding:56px 0 80px; }
  .af-signup-split__brand { position:sticky; top:100px; }
  .af-signup-split__eyebrow { display:inline-block; padding:5px 12px; background:rgba(125,190,82,0.08); color:var(--color-accent-primary,#7dbe52); border-radius:999px; font-size:var(--font-size-xs,12px); font-weight:700; letter-spacing:0.06em; text-transform:uppercase; margin-bottom:18px; }
  .af-signup-split__title { margin:0 0 14px; font-size:var(--font-size-3xl,32px); line-height:1.15; letter-spacing:-0.02em; color:var(--color-text-primary,#1d2d44); }
  .af-signup-split__subtitle { margin:0 0 32px; color:var(--color-text-secondary,#9e9e9e); font-size:var(--font-size-lg,20px); line-height:1.55; max-width:520px; }
  .af-signup-split__steps { list-style:none; margin:0 0 32px; padding:0; display:flex; flex-direction:column; gap:18px; }
  .af-signup-split__steps li { display:flex; align-items:flex-start; gap:14px; font-size:var(--font-size-base,16px); color:var(--color-text-primary,#1d2d44); line-height:1.5; }
  .af-signup-split__steps li strong { color:var(--color-accent-primary,#7dbe52); }
  .af-signup-split__step-num { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; flex:0 0 auto; margin-top:1px; border-radius:50%; background:rgba(125,190,82,0.1); color:var(--color-accent-primary,#7dbe52); font-size:var(--font-size-sm,14px); font-weight:700; }
  .af-signup-split__note { margin:0; font-size:var(--font-size-sm,14px); color:var(--color-text-secondary,#9e9e9e); line-height:1.6; }
  .af-signup-split__card { background:#fff; border-radius:var(--border-radius-xl,20px); box-shadow:0 8px 32px rgba(29,45,68,0.12); padding:36px 32px 32px; }
  .af-signup-split__faq { margin-top:16px; text-align:center; font-size:var(--font-size-sm,14px); }
  .af-signup-split__faq a { color:var(--color-text-secondary,#9e9e9e); text-decoration:none; border-bottom:1px dashed var(--color-border-primary,rgba(29,45,68,0.12)); transition:color 150ms; }
  .af-signup-split__faq a:hover { color:var(--color-accent-primary,#7dbe52); border-color:var(--color-accent-primary,#7dbe52); }
  @media (max-width:860px){
    .af-signup-split { grid-template-columns:1fr; gap:0; padding:32px 0 56px; }
    .af-signup-split__brand { position:static; margin-bottom:28px; }
    .af-signup-split__card { border-radius:var(--border-radius-lg,16px); padding:24px 20px 20px; }
  }
</style>

<main id="main-content" class="section">
  <div class="container container--narrow">

    <div class="af-signup-split">

      <div class="af-signup-split__brand">
        <span class="af-signup-split__eyebrow"><?php esc_html_e( 'Arriendo Fácil', 'twentytwentyfive-child' ); ?></span>
        <h1 class="af-signup-split__title"><?php esc_html_e( 'Crea tu cuenta y comienza a gestionar', 'twentytwentyfive-child' ); ?></h1>
        <p class="af-signup-split__subtitle"><?php esc_html_e( 'Regístrate en un minuto. Recibirás un correo de verificación y luego podrás acceder a tu panel de administración con datos de ejemplo listos para explorar.', 'twentytwentyfive-child' ); ?></p>

        <ol class="af-signup-split__steps">
          <li>
            <span class="af-signup-split__step-num">1</span>
            <span><?php esc_html_e( 'Completa tu nombre, correo y una contraseña segura.', 'twentytwentyfive-child' ); ?></span>
          </li>
          <li>
            <span class="af-signup-split__step-num">2</span>
            <span><?php esc_html_e( '<strong>Verifica tu correo</strong> haciendo clic en el enlace que te enviaremos.', 'twentytwentyfive-child' ); ?></span>
          </li>
          <li>
            <span class="af-signup-split__step-num">3</span>
            <span><?php esc_html_e( 'Entra al sistema interno y prueba cobros, contratos, mantenimiento e inquilinos.', 'twentytwentyfive-child' ); ?></span>
          </li>
        </ol>

        <p class="af-signup-split__note">
          <?php esc_html_e( 'Sin tarjeta. Datos de ejemplo: no se transfiere ningún dato real a tu cuenta hasta que publiques una propiedad.', 'twentytwentyfive-child' ); ?>
        </p>
      </div>

      <div class="af-signup-split__card">
        <?php echo do_shortcode( '[af_property_admin_signup]' ); ?>
      </div>

    </div>

    <p class="af-signup-split__faq">
      <a href="<?php echo esc_url( home_url( '/contacto/#faq' ) ); ?>"><?php esc_html_e( 'Tengo dudas antes de empezar — ver preguntas frecuentes', 'twentytwentyfive-child' ); ?></a>
    </p>

  </div>
</main>

<?php get_footer(); ?>
