<?php
/**
 * Template Name: Completar perfil de arriendo
 *
 * Public legal onboarding page accessed via secure token link.
 * Expects ?selector=...&token=... in the URL.
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-guest-profile-page">
  <div class="af-guest-profile-container">
    <section class="af-guest-profile-card">
      <h1><?php esc_html_e('Completar perfil legal de arriendo', 'twentytwentyfive-child'); ?></h1>
      <p class="af-guest-profile-lead">
        <?php esc_html_e('Este formulario se habilita con un enlace seguro con token. Primero validamos tu enlace y luego puedes enviar tu información legal.', 'twentytwentyfive-child'); ?>
      </p>

      <p id="af-guest-profile-context" class="af-guest-profile-context"></p>
      <p id="af-guest-profile-loading" class="af-guest-profile-loading" hidden>
        <?php esc_html_e('Validando enlace seguro...', 'twentytwentyfive-child'); ?>
      </p>
      <p id="af-guest-profile-status" class="af-guest-profile-status" hidden></p>

      <form id="af-guest-profile-form" class="af-guest-profile-form" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="selector" value="">
        <input type="hidden" name="token" value="">

        <div class="af-guest-profile-grid">
          <div class="af-guest-profile-field">
            <label for="af-gp-rental-start-date"><?php esc_html_e('Fecha inicio arriendo', 'twentytwentyfive-child'); ?> *</label>
            <input type="date" id="af-gp-rental-start-date" name="rental_start_date" required>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-name"><?php esc_html_e('Nombre completo (nombres y apellidos)', 'twentytwentyfive-child'); ?> *</label>
            <input type="text" id="af-gp-name" name="name" required
              pattern="^[A-Za-zÀ-ÿÑñ]{2,}(?:\s+[A-Za-zÀ-ÿÑñ]{2,}){1,}$"
              minlength="5" maxlength="80" autocomplete="name"
              title="<?php esc_attr_e('Ingresa nombres y apellidos completos, solo letras (mínimo 2 palabras).', 'twentytwentyfive-child'); ?>">
            <small class="af-guest-profile-hint"><?php esc_html_e('Solo letras. Mínimo nombre y apellido.', 'twentytwentyfive-child'); ?></small>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-phone"><?php esc_html_e('Teléfono (10 dígitos)', 'twentytwentyfive-child'); ?></label>
            <input type="tel" id="af-gp-phone" name="phone" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" required>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-id-number"><?php esc_html_e('Cédula (10 dígitos)', 'twentytwentyfive-child'); ?></label>
            <input type="text" id="af-gp-id-number" name="id_number" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" required>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-personas"><?php esc_html_e('Personas que vivirán en la propiedad', 'twentytwentyfive-child'); ?></label>
            <input type="number" id="af-gp-personas" name="personas_viviran" min="1" max="20" inputmode="numeric">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-rental-years"><?php esc_html_e('Años de arriendo', 'twentytwentyfive-child'); ?> *</label>
            <input type="number" id="af-gp-rental-years" name="rental_years" min="1" max="20" value="1" inputmode="numeric" required>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-doc-cedula"><?php esc_html_e('PDF cédula/papeleta', 'twentytwentyfive-child'); ?></label>
            <input type="file" id="af-gp-doc-cedula" name="guest_cedula_papeleta_pdf" accept="application/pdf">
          </div>

          <div class="af-guest-profile-field is-full">
            <label for="af-gp-doc-banco"><?php esc_html_e('PDF certificado bancario', 'twentytwentyfive-child'); ?></label>
            <input type="file" id="af-gp-doc-banco" name="guest_certificado_bancario_pdf" accept="application/pdf">
          </div>
        </div>

        <p class="af-guest-profile-note">
          <?php esc_html_e('Guardado temporal activo en este navegador para evitar pérdida de datos.', 'twentytwentyfive-child'); ?>
        </p>

        <div class="af-guest-profile-actions">
          <button id="af-guest-profile-submit" type="submit" class="btn btn--primary btn--lg">
            <?php esc_html_e('Enviar perfil legal', 'twentytwentyfive-child'); ?>
          </button>
        </div>
      </form>
    </section>
  </div>
</main>

<?php get_footer(); ?>
