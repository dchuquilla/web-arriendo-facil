<?php
/**
 * Contacto — rediseño ArriendoFácil. Mantiene el handler af_contact (functions.php).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_status  = isset( $_GET['contacto'] ) ? sanitize_key( wp_unslash( $_GET['contacto'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
$afx_notices = array(
  'ok'      => array( 'success', __( '¡Gracias! Recibimos tu mensaje y te responderemos en menos de 24 horas hábiles.', 'twentytwentyfive-child' ) ),
  'invalid' => array( 'error', __( 'Revisa que todos los campos estén completos y que el correo sea válido.', 'twentytwentyfive-child' ) ),
  'error'   => array( 'error', __( 'No pudimos enviar tu mensaje. Inténtalo de nuevo o escríbenos a arriendofacilnet@gmail.com.', 'twentytwentyfive-child' ) ),
);
?>

<main id="main-content" class="afx-main afx-sub afx-sub--contact" data-afx-page>
  <?php afx_waves(); ?>

  <div class="afx-wrap afx-sub__grid">
    <div class="afx-sub__copy">
      <p class="afx-tag" data-afx><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Contáctanos', 'twentytwentyfive-child' ); ?></p>
      <h1 class="afx-title afx-title--xl" data-afx><?php esc_html_e( 'Estamos aquí', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'para ayudarte', 'twentytwentyfive-child' ); ?></span></h1>
      <p class="afx-sub__lead" data-afx><?php esc_html_e( '¿Tienes alguna pregunta? Escríbenos y te responderemos lo antes posible.', 'twentytwentyfive-child' ); ?></p>

      <div class="afx-contact-info" data-afx>
        <figure class="afx-contact-info__photo">
          <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/edificio-verde.jpg' ); ?>" alt="<?php esc_attr_e( 'Edificio residencial con fachada verde', 'twentytwentyfive-child' ); ?>" loading="lazy" decoding="async" width="280" height="280">
        </figure>
        <ul>
          <li>
            <span class="afx-features__icon"><?php echo afx_icon( 'mail', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
            <span><strong><?php esc_html_e( 'Correo electrónico', 'twentytwentyfive-child' ); ?></strong><a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a></span>
          </li>
          <li>
            <span class="afx-features__icon"><?php echo afx_icon( 'clock', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
            <span><strong><?php esc_html_e( 'Tiempo de respuesta', 'twentytwentyfive-child' ); ?></strong><em><?php esc_html_e( 'Menos de 24 horas hábiles', 'twentytwentyfive-child' ); ?></em></span>
          </li>
          <li>
            <span class="afx-features__icon"><?php echo afx_icon( 'pin', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
            <span><strong>Quito, Ecuador</strong></span>
          </li>
        </ul>
      </div>
    </div>

    <div class="afx-sub__visual afx-sub__visual--form" data-afx-tilt>
      <div class="afx-formcard" data-afx-card data-afx-depth="8">
        <h2><?php esc_html_e( 'Envíanos un mensaje', 'twentytwentyfive-child' ); ?></h2>

        <?php if ( isset( $afx_notices[ $afx_status ] ) ) : ?>
          <p class="afx-notice afx-notice--<?php echo esc_attr( $afx_notices[ $afx_status ][0] ); ?>" role="status"><?php echo esc_html( $afx_notices[ $afx_status ][1] ); ?></p>
        <?php endif; ?>

        <form class="afx-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
          <input type="hidden" name="action" value="af_contact">
          <input type="hidden" name="subject" value="demo">
          <?php wp_nonce_field( 'af_contact_form', 'af_contact_nonce' ); ?>
          <div class="afx-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

          <label class="afx-sr" for="afx-name"><?php esc_html_e( 'Nombre completo', 'twentytwentyfive-child' ); ?></label>
          <input id="afx-name" type="text" name="name" required autocomplete="name" placeholder="<?php esc_attr_e( 'Nombre completo', 'twentytwentyfive-child' ); ?>">

          <label class="afx-sr" for="afx-email"><?php esc_html_e( 'Correo electrónico', 'twentytwentyfive-child' ); ?></label>
          <input id="afx-email" type="email" name="email" required autocomplete="email" placeholder="<?php esc_attr_e( 'Correo electrónico', 'twentytwentyfive-child' ); ?>">

          <label class="afx-sr" for="afx-message"><?php esc_html_e( 'Tu mensaje', 'twentytwentyfive-child' ); ?></label>
          <textarea id="afx-message" name="message" required rows="4" placeholder="<?php esc_attr_e( 'Tu mensaje...', 'twentytwentyfive-child' ); ?>"></textarea>

          <button class="afx-btn afx-btn--dark afx-btn--lg afx-btn--block" type="submit">
            <?php esc_html_e( 'Enviar mensaje', 'twentytwentyfive-child' ); ?>
            <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
          </button>
        </form>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
