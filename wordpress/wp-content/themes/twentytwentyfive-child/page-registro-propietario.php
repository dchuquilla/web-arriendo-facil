<?php
/**
 * Template Name: Registro Propietario
 * Page template for owner registration wizard.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$nonce = wp_create_nonce( 'af_owner_register' );
?>

<main id="main-content" class="af-register-page">
  <section class="section">
    <div class="container container--narrow">
      <div class="af-wizard" data-nonce="<?php echo esc_attr( $nonce ); ?>">

        <!-- Progress Bar -->
        <div class="af-wizard__progress" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="5">
          <div class="af-wizard__progress-bar" style="width: 20%;"></div>
          <div class="af-wizard__steps">
            <span class="af-wizard__step is-active" data-step="1">1</span>
            <span class="af-wizard__step" data-step="2">2</span>
            <span class="af-wizard__step" data-step="3">3</span>
            <span class="af-wizard__step" data-step="4">4</span>
            <span class="af-wizard__step" data-step="5">5</span>
          </div>
        </div>

        <!-- Step 1: Datos Personales -->
        <div class="af-wizard__panel is-active" data-panel="1">
          <h2><?php esc_html_e( 'Datos Personales', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Ingresa tu información básica para crear tu cuenta de propietario.', 'twentytwentyfive-child' ); ?></p>

          <div class="af-form-grid">
            <div class="af-form-group">
              <label for="af-id-type"><?php esc_html_e( 'Tipo de Documento', 'twentytwentyfive-child' ); ?> *</label>
              <select id="af-id-type" name="id_type" required>
                <option value=""><?php esc_html_e( 'Seleccionar...', 'twentytwentyfive-child' ); ?></option>
                <option value="cedula"><?php esc_html_e( 'Cédula', 'twentytwentyfive-child' ); ?></option>
                <option value="ruc"><?php esc_html_e( 'RUC', 'twentytwentyfive-child' ); ?></option>
                <option value="pasaporte"><?php esc_html_e( 'Pasaporte', 'twentytwentyfive-child' ); ?></option>
              </select>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group">
              <label for="af-id-number"><?php esc_html_e( 'Número de Documento', 'twentytwentyfive-child' ); ?> *</label>
              <input type="text" id="af-id-number" name="id_number" maxlength="13" autocomplete="off" required
                placeholder="<?php esc_attr_e( 'Ej: 1712345678', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-fullname"><?php esc_html_e( 'Nombre Completo', 'twentytwentyfive-child' ); ?> *</label>
              <input type="text" id="af-fullname" name="fullname" maxlength="120" autocomplete="name" required
                placeholder="<?php esc_attr_e( 'Nombres y Apellidos', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group">
              <label for="af-email"><?php esc_html_e( 'Correo Electrónico', 'twentytwentyfive-child' ); ?> *</label>
              <input type="email" id="af-email" name="email" maxlength="100" autocomplete="email" required
                placeholder="<?php esc_attr_e( 'correo@ejemplo.com', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group">
              <label for="af-phone"><?php esc_html_e( 'Teléfono', 'twentytwentyfive-child' ); ?> *</label>
              <input type="tel" id="af-phone" name="phone" maxlength="15" autocomplete="tel" required
                placeholder="<?php esc_attr_e( '0991234567', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>
          </div>
        </div>

        <!-- Step 2: Información Adicional -->
        <div class="af-wizard__panel" data-panel="2">
          <h2><?php esc_html_e( 'Información Adicional', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Cuéntanos más sobre tu propiedad y tus necesidades.', 'twentytwentyfive-child' ); ?></p>

          <div class="af-form-grid">
            <div class="af-form-group af-form-group--full">
              <label for="af-property-type-reg"><?php esc_html_e( 'Tipo de Propiedad a Registrar', 'twentytwentyfive-child' ); ?></label>
              <select id="af-property-type-reg" name="property_type_interest">
                <option value=""><?php esc_html_e( 'Seleccionar...', 'twentytwentyfive-child' ); ?></option>
                <option value="apartment"><?php esc_html_e( 'Apartamento', 'twentytwentyfive-child' ); ?></option>
                <option value="house"><?php esc_html_e( 'Casa', 'twentytwentyfive-child' ); ?></option>
                <option value="office"><?php esc_html_e( 'Oficina', 'twentytwentyfive-child' ); ?></option>
                <option value="room"><?php esc_html_e( 'Habitación', 'twentytwentyfive-child' ); ?></option>
                <option value="commercial"><?php esc_html_e( 'Comercial', 'twentytwentyfive-child' ); ?></option>
              </select>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-message"><?php esc_html_e( 'Observaciones / Mensaje', 'twentytwentyfive-child' ); ?></label>
              <textarea id="af-message" name="message" rows="4" maxlength="1000"
                placeholder="<?php esc_attr_e( 'Describe brevemente tu propiedad o requerimientos especiales...', 'twentytwentyfive-child' ); ?>"></textarea>
              <span class="af-form-error" hidden></span>
            </div>
          </div>
        </div>

        <!-- Step 3: Representante Legal (Opcional) -->
        <div class="af-wizard__panel" data-panel="3">
          <h2><?php esc_html_e( 'Representante Legal', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Si tienes un representante legal, ingresa sus datos aquí. Este paso es opcional.', 'twentytwentyfive-child' ); ?></p>

          <div class="af-form-grid">
            <div class="af-form-group af-form-group--full">
              <label for="af-legal-name"><?php esc_html_e( 'Nombre del Representante', 'twentytwentyfive-child' ); ?></label>
              <input type="text" id="af-legal-name" name="legal_agent_name" maxlength="120"
                placeholder="<?php esc_attr_e( 'Nombre completo del representante legal', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group">
              <label for="af-legal-phone"><?php esc_html_e( 'Teléfono del Representante', 'twentytwentyfive-child' ); ?></label>
              <input type="tel" id="af-legal-phone" name="legal_agent_phone" maxlength="15"
                placeholder="<?php esc_attr_e( '0991234567', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group">
              <label for="af-legal-email"><?php esc_html_e( 'Email del Representante', 'twentytwentyfive-child' ); ?></label>
              <input type="email" id="af-legal-email" name="legal_agent_email" maxlength="100"
                placeholder="<?php esc_attr_e( 'correo@ejemplo.com', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-legal-pdf"><?php esc_html_e( 'Poder Notarial (PDF)', 'twentytwentyfive-child' ); ?></label>
              <div class="af-file-upload">
                <input type="file" id="af-legal-pdf" name="legal_agent_pdf" accept=".pdf">
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un PDF o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Máximo 5MB. Solo archivos PDF.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>
          </div>
        </div>

        <!-- Step 4: Documentos -->
        <div class="af-wizard__panel" data-panel="4">
          <h2><?php esc_html_e( 'Documentos', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Sube los documentos necesarios para verificar tu identidad.', 'twentytwentyfive-child' ); ?></p>

          <div class="af-form-grid">
            <div class="af-form-group af-form-group--full">
              <label for="af-doc-cedula"><?php esc_html_e( 'Cédula / Documento de Identidad (PDF)', 'twentytwentyfive-child' ); ?> *</label>
              <div class="af-file-upload">
                <input type="file" id="af-doc-cedula" name="doc_cedula" accept=".pdf" required>
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un PDF o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Máximo 5MB. Solo archivos PDF.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-doc-ruc"><?php esc_html_e( 'RUC (PDF) — Solo si aplica', 'twentytwentyfive-child' ); ?></label>
              <div class="af-file-upload">
                <input type="file" id="af-doc-ruc" name="doc_ruc" accept=".pdf">
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un PDF o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Máximo 5MB. Solo archivos PDF.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label class="af-checkbox-label">
                <input type="checkbox" id="af-terms" name="terms" required>
                <span><?php printf(
                  esc_html__( 'Acepto los %1$sTérminos y Condiciones%2$s y la %3$sPolítica de Privacidad%4$s', 'twentytwentyfive-child' ),
                  '<a href="/terminos" target="_blank">', '</a>',
                  '<a href="/privacidad" target="_blank">', '</a>'
                ); ?></span>
              </label>
              <span class="af-form-error" hidden></span>
            </div>
          </div>
        </div>

        <!-- Step 5: Confirmación -->
        <div class="af-wizard__panel" data-panel="5">
          <h2><?php esc_html_e( 'Confirmación', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Revisa tus datos antes de enviar el formulario.', 'twentytwentyfive-child' ); ?></p>

          <div class="af-wizard__summary" id="af-wizard-summary"></div>

          <div class="af-wizard__disclaimer">
            <p><?php esc_html_e( 'Al enviar este formulario, nuestro equipo revisará tu solicitud y te contactará en un plazo de 24-48 horas.', 'twentytwentyfive-child' ); ?></p>
          </div>
        </div>

        <!-- Navigation -->
        <div class="af-wizard__nav">
          <button type="button" class="btn btn--outline af-wizard__prev" disabled>
            <?php esc_html_e( 'Anterior', 'twentytwentyfive-child' ); ?>
          </button>
          <button type="button" class="btn btn--primary af-wizard__next">
            <?php esc_html_e( 'Siguiente', 'twentytwentyfive-child' ); ?>
          </button>
          <button type="button" class="btn btn--primary af-wizard__submit" hidden>
            <?php esc_html_e( 'Enviar Solicitud', 'twentytwentyfive-child' ); ?>
          </button>
        </div>

        <!-- Success/Error messages -->
        <div class="af-wizard__feedback" id="af-wizard-feedback" hidden></div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
