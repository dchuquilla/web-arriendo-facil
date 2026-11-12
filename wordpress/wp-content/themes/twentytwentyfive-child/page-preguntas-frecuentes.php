<?php
/**
 * Preguntas frecuentes — rediseño ArriendoFácil (Figma aprobado).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_faq_sections = array(
  'plataforma' => array(
    'title' => __( 'Plataforma', 'twentytwentyfive-child' ),
    'icon'  => 'building',
    'items' => array(
      array( __( '¿Qué es Arriendo Fácil?', 'twentytwentyfive-child' ), __( 'Arriendo Fácil es un software de gestión de propiedades (PMS) diseñado para gestores inmobiliarios en Ecuador. Automatiza facturación SRI, control de pagos, mantenimiento y liquidaciones en un solo panel.', 'twentytwentyfive-child' ) ),
      array( __( '¿Cómo empiezo?', 'twentytwentyfive-child' ), __( 'Crea una cuenta en nuestro formulario de registro, verifica tu correo y comienza a cargar tus propiedades. Te guiaremos paso a paso.', 'twentytwentyfive-child' ) ),
      array( __( '¿Hay costo para usar la plataforma?', 'twentytwentyfive-child' ), __( 'Hay un plan Free, gratuito, con funciones y número de propiedades limitados y sin facturación electrónica. El plan Premium desbloquea todas las funciones sin límites y se paga con tarjeta en la plataforma, en ciclo mensual o anual.', 'twentytwentyfive-child' ) ),
      array( __( '¿Está segura mi información?', 'twentytwentyfive-child' ), __( 'Sí. Encriptación HTTPS, GDPR y CCPA compliant. Tus datos están 100% seguros y confidenciales.', 'twentytwentyfive-child' ) ),
    ),
  ),
  'cuenta' => array(
    'title' => __( 'Tu Cuenta', 'twentytwentyfive-child' ),
    'icon'  => 'user-plus',
    'items' => array(
      array( __( '¿Olvidé mi contraseña?', 'twentytwentyfive-child' ), __( 'Haz clic en "¿Olvidaste tu contraseña?" en el formulario de login. Te enviaremos un enlace para que puedas restablecerla en minutos.', 'twentytwentyfive-child' ) ),
      array( __( '¿Cuántas propiedades puedo registrar?', 'twentytwentyfive-child' ), __( 'El plan Free tiene un número limitado de propiedades. Con el plan Premium puedes registrar propiedades sin límite.', 'twentytwentyfive-child' ) ),
      array( __( '¿Cambiar plan?', 'twentytwentyfive-child' ), __( 'Sí. Puedes pasar a Premium en cualquier momento y cancelar la renovación cuando quieras. Conservas el acceso Premium hasta el fin del ciclo pagado y luego tu cuenta vuelve al plan Free sin perder tus datos.', 'twentytwentyfive-child' ) ),
    ),
  ),
  'facturacion' => array(
    'title' => __( 'Facturación SRI', 'twentytwentyfive-child' ),
    'icon'  => 'file',
    'items' => array(
      array( __( '¿Son válidas ante SRI?', 'twentytwentyfive-child' ), __( 'Sí, completamente. Todas nuestras facturas están firmadas electrónicamente y autorizadas ante el SRI. Son legalmente válidas y reconocidas por el estado ecuatoriano.', 'twentytwentyfive-child' ) ),
      array( __( '¿Quién autoriza las facturas?', 'twentytwentyfive-child' ), __( 'Tú controlas el proceso. Nosotros generamos la factura, pero tú decides autorizar con un clic. Nada se emite sin tu revisión y aprobación explícita.', 'twentytwentyfive-child' ) ),
      array( __( '¿Conceptos por propiedad?', 'twentytwentyfive-child' ), __( 'Sí. Puedes personalizar completamente los conceptos por propiedad: canon mensual, administración, alícuotas, servicios adicionales y más. Cada propiedad puede tener su estructura única.', 'twentytwentyfive-child' ) ),
    ),
  ),
  'pagos' => array(
    'title' => __( 'Pagos y Morosidad', 'twentytwentyfive-child' ),
    'icon'  => 'bell',
    'items' => array(
      array( __( '¿Cómo registrar pagos?', 'twentytwentyfive-child' ), __( 'Registras cada pago manualmente en el sistema, indicando si fue transferencia, efectivo, depósito, cheque u otro, y puedes registrar abonos parciales. El sistema no se conecta con bancos. Un cargo se marca como atrasado automáticamente cuando pasa su fecha de vencimiento sin estar pagado.', 'twentytwentyfive-child' ) ),
      array( __( '¿Si el inquilino no paga?', 'twentytwentyfive-child' ), __( 'El cargo se marca automáticamente como atrasado al pasar su fecha de vencimiento y el inquilino aparece en la mora del Panel. Puedes enviarle avisos con confirmación de lectura para gestionar el cobro.', 'twentytwentyfive-child' ) ),
      array( __( '¿Cómo se calcula la liquidación?', 'twentytwentyfive-child' ), __( 'Cada mes el sistema genera tu liquidación automáticamente: ingresos por canon y servicios, menos costos de mantenimiento y administración, igual a tu pago neto. 100% auditable línea por línea.', 'twentytwentyfive-child' ) ),
    ),
  ),
  'soporte' => array(
    'title' => __( 'Soporte', 'twentytwentyfive-child' ),
    'icon'  => 'mail',
    'items' => array(
      array( __( '¿Cómo me comunico con soporte?', 'twentytwentyfive-child' ), __( 'Puedes contactarnos por correo (arriendofacilnet@gmail.com), WhatsApp o a través del formulario de contacto en nuestra web. Nuestro equipo responde en menos de 24 horas.', 'twentytwentyfive-child' ) ),
      array( __( '¿Ofrecen capacitación?', 'twentytwentyfive-child' ), __( 'Sí. Incluimos videos tutoriales, guías escritas y sesiones de capacitación en vivo para nuevos usuarios. Contáctanos para agendar una sesión de capacitación personalizada.', 'twentytwentyfive-child' ) ),
    ),
  ),
);
?>

<main id="main-content" class="afx-main afx-faqpage" data-afx-page>
  <section class="afx-faqhero">
    <?php afx_waves(); ?>
    <div class="afx-wrap afx-faqhero__copy">
      <p class="afx-tag" data-afx><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Preguntas frecuentes', 'twentytwentyfive-child' ); ?></p>
      <h1 class="afx-title afx-title--xl" data-afx><?php esc_html_e( 'Resuelve', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'tus dudas', 'twentytwentyfive-child' ); ?></span></h1>
      <p class="afx-sub__lead" data-afx><?php esc_html_e( 'Encuentra respuestas rápidas y claras sobre cómo usar ArriendoFácil.', 'twentytwentyfive-child' ); ?></p>
    </div>
  </section>

  <section class="afx-wrap afx-faqbody">
    <aside class="afx-faqnav" data-afx>
      <nav aria-label="<?php esc_attr_e( 'Categorías de preguntas', 'twentytwentyfive-child' ); ?>">
        <ul>
          <?php $afx_first = true; foreach ( $afx_faq_sections as $afx_id => $afx_sec ) : ?>
            <li><a class="afx-faqnav__link<?php echo $afx_first ? ' is-active' : ''; ?>" href="#faq-<?php echo esc_attr( $afx_id ); ?>" data-no-loader="true"><?php echo afx_icon( $afx_sec['icon'], 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $afx_sec['title'] ); ?></span></a></li>
            <?php $afx_first = false; endforeach; ?>
        </ul>
      </nav>
    </aside>

    <div class="afx-faqlist">
      <?php $afx_n = 0; foreach ( $afx_faq_sections as $afx_id => $afx_sec ) : ?>
        <section class="afx-faqsec" id="faq-<?php echo esc_attr( $afx_id ); ?>" data-afx>
          <h2 class="afx-faqsec__title"><span class="afx-faqsec__icon"><?php echo afx_icon( $afx_sec['icon'], 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><?php echo esc_html( $afx_sec['title'] ); ?></h2>
          <div class="afx-acc">
            <?php foreach ( $afx_sec['items'] as $afx_qa ) : $afx_n++; ?>
              <div class="afx-acc__item">
                <h3>
                  <button class="afx-acc__btn" type="button" aria-expanded="false" aria-controls="afx-q-<?php echo (int) $afx_n; ?>" id="afx-q-btn-<?php echo (int) $afx_n; ?>">
                    <span><?php echo esc_html( $afx_qa[0] ); ?></span>
                    <?php echo afx_icon( 'plus', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                  </button>
                </h3>
                <div class="afx-acc__panel" id="afx-q-<?php echo (int) $afx_n; ?>" role="region" aria-labelledby="afx-q-btn-<?php echo (int) $afx_n; ?>">
                  <p><?php echo esc_html( $afx_qa[1] ); ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>
      <aside class="afx-faqhelp" data-afx>
        <span class="afx-faqhelp__icon"><?php echo afx_icon( 'mail', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <div>
          <h2><?php esc_html_e( '¿Aún tienes dudas?', 'twentytwentyfive-child' ); ?></h2>
          <p><?php esc_html_e( 'Nuestro equipo está disponible para ayudarte.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <a class="afx-btn afx-btn--dark" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
          <?php esc_html_e( 'Contactar soporte', 'twentytwentyfive-child' ); ?>
          <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        </a>
      </aside>
    </div>
  </section>

</main>

<?php get_footer(); ?>
