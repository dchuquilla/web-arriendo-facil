<?php
/**
 * Template Name: Quiénes somos
 * Página institucional — rediseño ArriendoFácil.
 *
 * @package Arriendo_Facil
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$afx_img    = get_stylesheet_directory_uri() . '/assets/img/';
$afx_signup = function_exists( 'af_signup_url' ) ? af_signup_url() : home_url( '/registro/' );

$afx_stats = array(
  array( 'n' => '1 panel', 't' => 'para toda tu cartera de propiedades' ),
  array( 'n' => '360°', 't' => 'inquilinos, contratos, cobros y mantenimiento' ),
  array( 'n' => 'IA', 't' => 'como apoyo, siempre con tu criterio' ),
  array( 'n' => 'EC', 't' => 'hecho en Ecuador, para Ecuador' ),
);

$afx_modules = array(
  array( 'home', 'Propiedades y unidades', 'Inmuebles, edificios y unidades organizados con fichas, fotos y estado en tiempo real.', '' ),
  array( 'users', 'Inquilinos y solicitantes', 'Recibe documentos con enlaces seguros y mantén todo el historial de cada persona en un solo lugar.', '' ),
  array( 'file', 'Contratos', 'Genéralos desde plantillas, con apoyo de IA para completarlos, y recibe alertas de vencimiento.', '' ),
  array( 'wallet', 'Cobros y pagos', 'Cargos, pagos registrados, mora y medidores con seguimiento claro de cada arriendo.', '' ),
  array( 'wrench', 'Mantenimiento', 'Incidencias, proveedores verificados, prioridades y costos trazables.', '' ),
  array( 'calendar', 'Calendario y catálogos', 'Vencimientos, avisos y catálogos para compartir por PDF o WhatsApp. Sincroniza con Airbnb y Booking.', '' ),
  array( 'sparkles', 'Asistente con IA', 'Borradores de contratos, estimación de costos y apoyo para evaluar solicitantes. Tú decides.', '' ),
  array( 'file-down', 'Facturación electrónica SRI', 'Si la necesitas, emite tus comprobantes desde el mismo sistema.', 'Bonus' ),
);

$afx_audience = array(
  array( 'user-plus', 'Administradores independientes', 'Gestionas propiedades de varios dueños y necesitas orden, trazabilidad y rendir cuentas sin hojas de cálculo.' ),
  array( 'building', 'Empresas administradoras', 'Un equipo, muchas unidades y edificios: centraliza la operación y reduce errores y tareas repetitivas.' ),
  array( 'key', 'Propietarios con varias propiedades', 'Si administras tus propios inmuebles, tendrás control y visibilidad de cobros, contratos y mantenimiento.' ),
);

$afx_values = array(
  array( '01', 'Claridad', 'Cada cobro, gasto y gestión queda registrado y a la vista.' ),
  array( '02', 'Criterio humano', 'La tecnología automatiza lo repetitivo; las decisiones importantes las tomas tú.' ),
  array( '03', 'Seguridad y privacidad', 'Documentos privados, acceso por roles y cada administrador ve solo su cartera.' ),
);
?>

<main id="main-content" class="afx-main afx-aboutpage" data-afx-page>

  <section class="afx-faqhero afx-abouthero">
    <?php afx_waves(); ?>
    <div class="afx-wrap afx-abouthero__grid">
      <div class="afx-faqhero__copy">
        <p class="afx-tag" data-afx><?php echo afx_icon( 'users', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Quiénes somos', 'twentytwentyfive-child' ); ?></p>
        <h1 class="afx-title afx-title--xl" data-afx><?php esc_html_e( 'Tecnología para quienes', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'administran propiedades', 'twentytwentyfive-child' ); ?></span></h1>
        <p class="afx-sub__lead" data-afx><?php esc_html_e( 'ArriendoFácil es un sistema de gestión de propiedades creado en Ecuador para que los administradores ordenen su operación, tengan el control de su cartera y dediquen su tiempo a crecer.', 'twentytwentyfive-child' ); ?></p>
        <div class="afx-abouthero__cta" data-afx>
          <a class="afx-btn afx-btn--grad afx-btn--lg" href="<?php echo esc_url( $afx_signup ); ?>"><?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?><?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
          <a class="afx-btn afx-btn--soft afx-btn--lg" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Hablar con nosotros', 'twentytwentyfive-child' ); ?></a>
        </div>
      </div>
      <figure class="afx-abouthero__fig" data-afx>
        <img src="<?php echo esc_url( $afx_img . 'edificio-verde.jpg' ); ?>" width="1276" height="670" alt="<?php esc_attr_e( 'Edificio residencial administrado con ArriendoFácil', 'twentytwentyfive-child' ); ?>" fetchpriority="high">
      </figure>
    </div>
  </section>

  <section class="afx-wrap afx-aboutstats" data-afx>
    <ul>
      <?php foreach ( $afx_stats as $afx_s ) : ?>
        <li><b><?php echo esc_html( $afx_s['n'] ); ?></b><span><?php echo esc_html( $afx_s['t'] ); ?></span></li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section class="afx-wrap afx-aboutsec afx-aboutmission">
    <div class="afx-aboutmission__fig" data-afx>
      <img src="<?php echo esc_url( $afx_img . 'stage-sala.jpg' ); ?>" width="1408" height="768" loading="lazy" alt="<?php esc_attr_e( 'Interior de una propiedad en arriendo', 'twentytwentyfive-child' ); ?>">
    </div>
    <div class="afx-aboutmission__copy">
      <p class="afx-tag" data-afx><?php esc_html_e( 'Nuestra misión', 'twentytwentyfive-child' ); ?></p>
      <h2 class="afx-title" data-afx><?php esc_html_e( 'Profesionalizar la', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'administración de arriendos', 'twentytwentyfive-child' ); ?></span></h2>
      <p data-afx><?php esc_html_e( 'Administrar una cartera de inmuebles implica atender inquilinos, hacer seguimiento a contratos, controlar cobros, coordinar reparaciones y rendir cuentas a los propietarios. Hacerlo entre hojas de cálculo y chats es lento y propenso a errores.', 'twentytwentyfive-child' ); ?></p>
      <p data-afx><?php esc_html_e( 'ArriendoFácil reúne todo en un solo lugar, con procesos claros y pensados para la realidad ecuatoriana, para que cada administrador tenga control y transparencia sobre su operación.', 'twentytwentyfive-child' ); ?></p>
    </div>
  </section>

  <section class="afx-aboutband">
    <div class="afx-wrap">
      <div class="afx-aboutsec__head">
        <p class="afx-tag" data-afx><?php esc_html_e( 'Qué hacemos', 'twentytwentyfive-child' ); ?></p>
        <h2 class="afx-title" data-afx><?php esc_html_e( 'Todo lo que necesita un administrador,', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'en un solo lugar', 'twentytwentyfive-child' ); ?></span></h2>
      </div>
      <div class="afx-aboutgrid afx-aboutgrid--4">
        <?php foreach ( $afx_modules as $afx_m ) : ?>
          <article class="afx-aboutcard<?php echo $afx_m[3] ? ' afx-aboutcard--bonus' : ''; ?>" data-afx>
            <span class="afx-aboutcard__ico"><?php echo afx_icon( $afx_m[0], 24 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
            <?php if ( $afx_m[3] ) : ?><span class="afx-aboutcard__badge"><?php echo esc_html( $afx_m[3] ); ?></span><?php endif; ?>
            <h3><?php echo esc_html( $afx_m[1] ); ?></h3>
            <p><?php echo esc_html( $afx_m[2] ); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="afx-wrap afx-aboutsec">
    <div class="afx-aboutsec__head">
      <p class="afx-tag" data-afx><?php esc_html_e( 'A quién ayudamos', 'twentytwentyfive-child' ); ?></p>
      <h2 class="afx-title" data-afx><?php esc_html_e( 'Pensado para', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'quienes administran', 'twentytwentyfive-child' ); ?></span></h2>
    </div>
    <div class="afx-aboutgrid afx-aboutgrid--3">
      <?php foreach ( $afx_audience as $afx_a ) : ?>
        <article class="afx-aboutcard afx-aboutcard--aud" data-afx>
          <span class="afx-aboutcard__ico"><?php echo afx_icon( $afx_a[0], 24 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
          <h3><?php echo esc_html( $afx_a[1] ); ?></h3>
          <p><?php echo esc_html( $afx_a[2] ); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="afx-wrap afx-aboutsec afx-aboutvalues">
    <div class="afx-aboutsec__head">
      <p class="afx-tag" data-afx><?php esc_html_e( 'Cómo trabajamos', 'twentytwentyfive-child' ); ?></p>
      <h2 class="afx-title" data-afx><?php esc_html_e( 'Lo que nos', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'guía', 'twentytwentyfive-child' ); ?></span></h2>
    </div>
    <div class="afx-aboutgrid afx-aboutgrid--3">
      <?php foreach ( $afx_values as $afx_v ) : ?>
        <article class="afx-aboutcard afx-aboutcard--value" data-afx>
          <span class="afx-aboutcard__num"><?php echo esc_html( $afx_v[0] ); ?></span>
          <h3><?php echo esc_html( $afx_v[1] ); ?></h3>
          <p><?php echo esc_html( $afx_v[2] ); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
