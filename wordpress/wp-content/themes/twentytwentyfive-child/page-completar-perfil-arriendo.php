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
            <label for="af-gp-rental-years"><?php esc_html_e('Años de arriendo', 'twentytwentyfive-child'); ?> *</label>
            <input type="number" id="af-gp-rental-years" name="rental_years" min="1" max="20" required>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-name"><?php esc_html_e('Nombre', 'twentytwentyfive-child'); ?></label>
            <input type="text" id="af-gp-name" name="name">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-phone"><?php esc_html_e('Teléfono (10 dígitos)', 'twentytwentyfive-child'); ?></label>
            <input type="tel" id="af-gp-phone" name="phone" inputmode="numeric" pattern="[0-9]{10}" maxlength="10">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-id-number"><?php esc_html_e('Cédula (10 dígitos)', 'twentytwentyfive-child'); ?></label>
            <input type="text" id="af-gp-id-number" name="id_number" inputmode="numeric" pattern="[0-9]{10}" maxlength="10">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-mascotas"><?php esc_html_e('Mascotas', 'twentytwentyfive-child'); ?></label>
            <input type="text" id="af-gp-mascotas" name="mascotas" placeholder="Ej: 1 perro pequeño">
          </div>

          <div class="af-guest-profile-field is-full">
            <label for="af-gp-personas"><?php esc_html_e('Personas que vivirán', 'twentytwentyfive-child'); ?></label>
            <textarea id="af-gp-personas" name="personas_viviran"></textarea>
          </div>

          <div class="af-guest-profile-field is-full">
            <label for="af-gp-guarantee"><?php esc_html_e('Garantía / respaldo', 'twentytwentyfive-child'); ?></label>
            <textarea id="af-gp-guarantee" name="guarantee_text"></textarea>
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-ref1-name"><?php esc_html_e('Referencia 1 - Nombre', 'twentytwentyfive-child'); ?></label>
            <input type="text" id="af-gp-ref1-name" name="reference_1_name">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-ref1-phone"><?php esc_html_e('Referencia 1 - Teléfono', 'twentytwentyfive-child'); ?></label>
            <input type="tel" id="af-gp-ref1-phone" name="reference_1_phone" inputmode="numeric" pattern="[0-9]{10}" maxlength="10">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-ref2-name"><?php esc_html_e('Referencia 2 - Nombre', 'twentytwentyfive-child'); ?></label>
            <input type="text" id="af-gp-ref2-name" name="reference_2_name">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-ref2-phone"><?php esc_html_e('Referencia 2 - Teléfono', 'twentytwentyfive-child'); ?></label>
            <input type="tel" id="af-gp-ref2-phone" name="reference_2_phone" inputmode="numeric" pattern="[0-9]{10}" maxlength="10">
          </div>

          <div class="af-guest-profile-field">
            <label for="af-gp-doc-garantia"><?php esc_html_e('PDF garantía/alícuota', 'twentytwentyfive-child'); ?></label>
            <input type="file" id="af-gp-doc-garantia" name="guest_garantia_alicuota_pdf" accept="application/pdf">
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
