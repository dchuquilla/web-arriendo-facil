<?php
/**
 * Template Name: Registro Propietario
 * Page template for owner registration wizard.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>

<main id="main-content" class="af-register-page">
  <section class="section">
    <div class="container container--narrow">
      <div class="af-wizard">

        <!-- Progress Bar -->
        <div class="af-wizard__progress" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4">
          <div class="af-wizard__progress-bar" style="width: 25%;"></div>
          <div class="af-wizard__steps">
            <span class="af-wizard__step is-active" data-step="1">1</span>
            <span class="af-wizard__step" data-step="2">2</span>
            <span class="af-wizard__step" data-step="3">3</span>
            <span class="af-wizard__step" data-step="4">4</span>
          </div>
        </div>

        <!-- Step 1: Datos del Propietario -->
        <div class="af-wizard__panel is-active" data-panel="1">
          <h2><?php esc_html_e( 'Datos del Propietario', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Ingresa tu información para crear tu cuenta de propietario.', 'twentytwentyfive-child' ); ?></p>

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
              <label for="af-client-name"><?php esc_html_e( 'Nombre del Cliente', 'twentytwentyfive-child' ); ?> *</label>
              <input type="text" id="af-client-name" name="client_name" maxlength="120" autocomplete="name" required
                placeholder="<?php esc_attr_e( 'Nombres y Apellidos', 'twentytwentyfive-child' ); ?>">
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-email"><?php esc_html_e( 'Email del Propietario', 'twentytwentyfive-child' ); ?> *</label>
              <input type="email" id="af-email" name="email" maxlength="100" autocomplete="email" required
                placeholder="<?php esc_attr_e( 'correo@ejemplo.com', 'twentytwentyfive-child' ); ?>">
              <p class="af-form-help"><?php esc_html_e( 'Las instrucciones de activación se enviarán únicamente a este correo.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>
          </div>
        </div>

        <!-- Step 2: Representante Legal (Condicional) -->
        <div class="af-wizard__panel" data-panel="2">
          <h2><?php esc_html_e( 'Representante Legal', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( '¿El propietario cuenta con un representante legal?', 'twentytwentyfive-child' ); ?></p>

          <div class="af-form-grid">
            <div class="af-form-group af-form-group--full">
              <label><?php esc_html_e( '¿Tiene Representante Legal?', 'twentytwentyfive-child' ); ?></label>
              <div class="af-radio-group">
                <label class="af-radio-label">
                  <input type="radio" name="has_legal_agent" value="no" checked>
                  <span><?php esc_html_e( 'No', 'twentytwentyfive-child' ); ?></span>
                </label>
                <label class="af-radio-label">
                  <input type="radio" name="has_legal_agent" value="yes">
                  <span><?php esc_html_e( 'Sí', 'twentytwentyfive-child' ); ?></span>
                </label>
              </div>
            </div>

            <div class="af-legal-fields" id="af-legal-fields" hidden>
              <div class="af-form-grid">
                <div class="af-form-group af-form-group--full">
                  <label for="af-legal-name"><?php esc_html_e( 'Nombre del Representante', 'twentytwentyfive-child' ); ?></label>
                  <input type="text" id="af-legal-name" name="legal_agent_name" maxlength="120"
                    placeholder="<?php esc_attr_e( 'Nombre completo del representante legal', 'twentytwentyfive-child' ); ?>">
                  <span class="af-form-error" hidden></span>
                </div>

                <div class="af-form-group">
                  <label for="af-legal-id-type"><?php esc_html_e( 'Tipo de Documento', 'twentytwentyfive-child' ); ?></label>
                  <select id="af-legal-id-type" name="legal_agent_id_type">
                    <option value="cedula"><?php esc_html_e( 'Cédula', 'twentytwentyfive-child' ); ?></option>
                    <option value="ruc"><?php esc_html_e( 'RUC', 'twentytwentyfive-child' ); ?></option>
                    <option value="pasaporte"><?php esc_html_e( 'Pasaporte', 'twentytwentyfive-child' ); ?></option>
                  </select>
                  <span class="af-form-error" hidden></span>
                </div>

                <div class="af-form-group">
                  <label for="af-legal-id-number"><?php esc_html_e( 'Número de Documento', 'twentytwentyfive-child' ); ?></label>
                  <input type="text" id="af-legal-id-number" name="legal_agent_id_number" maxlength="13"
                    placeholder="<?php esc_attr_e( 'Ej: 1712345678', 'twentytwentyfive-child' ); ?>">
                  <span class="af-form-error" hidden></span>
                </div>

                <div class="af-form-group">
                  <label for="af-legal-phone"><?php esc_html_e( 'Teléfono', 'twentytwentyfive-child' ); ?></label>
                  <input type="tel" id="af-legal-phone" name="legal_agent_phone" maxlength="15"
                    placeholder="<?php esc_attr_e( '0991234567', 'twentytwentyfive-child' ); ?>">
                  <span class="af-form-error" hidden></span>
                </div>

                <div class="af-form-group">
                  <label for="af-legal-email"><?php esc_html_e( 'Email', 'twentytwentyfive-child' ); ?></label>
                  <input type="email" id="af-legal-email" name="legal_agent_email" maxlength="100"
                    placeholder="<?php esc_attr_e( 'correo@ejemplo.com', 'twentytwentyfive-child' ); ?>">
                  <span class="af-form-error" hidden></span>
                </div>
              </div>
              <p class="af-form-help af-form-help--note"><?php esc_html_e( 'No se envía correo de activación al representante legal.', 'twentytwentyfive-child' ); ?></p>
            </div>
          </div>
        </div>

        <!-- Step 3: Observaciones y Documentos -->
        <div class="af-wizard__panel" data-panel="3">
          <h2><?php esc_html_e( 'Observaciones y Documentos', 'twentytwentyfive-child' ); ?></h2>
          <p class="af-wizard__subtitle"><?php esc_html_e( 'Agrega observaciones y sube los documentos necesarios.', 'twentytwentyfive-child' ); ?></p>

          <div class="af-form-grid">
            <div class="af-form-group af-form-group--full">
              <label for="af-observations"><?php esc_html_e( 'Observaciones', 'twentytwentyfive-child' ); ?> *</label>
              <textarea id="af-observations" name="observations" rows="4" maxlength="1000" required
                placeholder="<?php esc_attr_e( 'Describe brevemente tu propiedad o requerimientos especiales...', 'twentytwentyfive-child' ); ?>"></textarea>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-doc-servicios"><?php esc_html_e( 'Servicios básicos del lugar (PDF)', 'twentytwentyfive-child' ); ?></label>
              <div class="af-file-upload">
                <input type="file" id="af-doc-servicios" name="doc_servicios_basicos" accept=".pdf">
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un PDF o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Máximo 5MB. Solo archivos PDF.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-doc-identidad"><?php esc_html_e( 'Documentos de identidad del propietario — cédula y papeleta de votación (PDF)', 'twentytwentyfive-child' ); ?></label>
              <div class="af-file-upload">
                <input type="file" id="af-doc-identidad" name="doc_identidad" accept=".pdf">
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un PDF o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Máximo 5MB. Solo archivos PDF.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-doc-contratos"><?php esc_html_e( 'Contratos de arrendamientos suscritos (PDF)', 'twentytwentyfive-child' ); ?></label>
              <div class="af-file-upload">
                <input type="file" id="af-doc-contratos" name="doc_contratos" accept=".pdf">
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un PDF o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Máximo 5MB. Solo archivos PDF.', 'twentytwentyfive-child' ); ?></p>
              <span class="af-form-error" hidden></span>
            </div>

            <div class="af-form-group af-form-group--full">
              <label for="af-doc-contrato-ejemplo"><?php esc_html_e( 'Ejemplo de contrato (Word .docx)', 'twentytwentyfive-child' ); ?></label>
              <div class="af-file-upload">
                <input type="file" id="af-doc-contrato-ejemplo" name="doc_contrato_ejemplo" accept=".docx,.doc">
                <span class="af-file-upload__label"><?php esc_html_e( 'Arrastra un archivo Word o haz clic para seleccionar', 'twentytwentyfive-child' ); ?></span>
                <span class="af-file-upload__name"></span>
              </div>
              <p class="af-form-help"><?php esc_html_e( 'Campo opcional. Puedes subir la plantilla del owner con su estructura y campos propios.', 'twentytwentyfive-child' ); ?></p>
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

        <!-- Step 4: Confirmación -->
        <div class="af-wizard__panel" data-panel="4">
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
          <button type="button" class="btn btn--primary af-wizard__submit" style="display:none">
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
