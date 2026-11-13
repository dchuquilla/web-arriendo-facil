<?php
/**
 * Portada — rediseño ArriendoFácil (Figma aprobado).
 * Hero + pills y una sección fija (pin + scrub) con ¿Cómo funciona?, FAQ y Planes sobre fondos que cambian con el scroll.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_img  = get_stylesheet_directory_uri() . '/assets/img/';
$afx_ph   = array( 'center 20%', 'center 52%', 'center 85%' );
$afx_bars = array(
  array( 'Ene', 38 ),
  array( 'Feb', 62 ),
  array( 'Mar', 82 ),
  array( 'Abr', 76 ),
  array( 'May', 100 ),
  array( 'Jun', 88 ),
);
$afx_due  = array(
  array( 'Edificio Los Álamos', '15 Jun' ),
  array( 'Suite Horizonte', '22 Jun' ),
  array( 'Departamento Norte', '25 Jun' ),
);
$afx_nav_items = array(
  array( 'Inicio', 'home' ),
  array( 'Propiedades', 'building' ),
  array( 'Pagos', 'file' ),
  array( 'Contratos', 'file' ),
  array( 'Facturación SRI', 'file' ),
  array( 'Mantenimiento', 'file' ),
  array( 'Reportes', 'file' ),
);
$afx_faq  = array(
  array(
    __( '¿Cómo funciona ArriendoFácil?', 'twentytwentyfive-child' ),
    __( 'Creas tu cuenta, registras tus inmuebles y gestionas contratos, pagos, facturación electrónica del SRI y mantenimiento desde un solo panel.', 'twentytwentyfive-child' ),
  ),
  array(
    __( '¿Es seguro mis datos?', 'twentytwentyfive-child' ),
    __( 'Sí. Protegemos tu información con conexiones cifradas y controles de acceso, y la tratamos conforme a nuestra política de privacidad.', 'twentytwentyfive-child' ),
  ),
  array(
    __( '¿Puedo cancelar mi cuenta?', 'twentytwentyfive-child' ),
    __( 'Sí, puedes cancelar cuando quieras. Nuestros planes son flexibles y no tienen costos ocultos.', 'twentytwentyfive-child' ),
  ),
  array(
    __( '¿Ofrecen soporte técnico?', 'twentytwentyfive-child' ),
    __( 'Sí. El plan Básico incluye soporte por email y el plan Profesional, soporte prioritario. También puedes escribirnos desde la página de contacto.', 'twentytwentyfive-child' ),
  ),
);

$afx_logged = is_user_logged_in();
$afx_targets = afx_login_targets();
$afx_steps = array(
  array(
    'n'     => 1,
    'icon'  => 'user-plus',
    'title' => __( 'Crea tu cuenta', 'twentytwentyfive-child' ),
    'text'  => __( 'Regístrate en segundos y configura tu perfil.', 'twentytwentyfive-child' ),
    'url'   => af_signup_url(),
    'label' => __( 'Crear mi cuenta gratis', 'twentytwentyfive-child' ),
  ),
  array(
    'n'          => 2,
    'icon'       => 'home',
    'title'      => __( 'Añade tus propiedades', 'twentytwentyfive-child' ),
    'text'       => __( 'Registra tus inmuebles de manera simple.', 'twentytwentyfive-child' ),
    'url'        => $afx_targets['property'],
    'label'      => __( 'Ir a Registrar inmueble', 'twentytwentyfive-child' ),
    'login'      => afx_login_url_for( 'property' ),
    'auth_title' => __( 'Inicia sesión para registrar tu inmueble', 'twentytwentyfive-child' ),
    'auth_text'  => __( 'Esta sección es solo para usuarios registrados. Inicia sesión o crea tu cuenta gratis y te llevaremos directo a Registrar inmueble.', 'twentytwentyfive-child' ),
  ),
  array(
    'n'          => 3,
    'icon'       => 'growth',
    'title'      => __( 'Gestiona sin complicaciones', 'twentytwentyfive-child' ),
    'text'       => __( 'Controla pagos, contratos y mucho más.', 'twentytwentyfive-child' ),
    'url'        => $afx_targets['panel'],
    'label'      => __( 'Ir a mi Panel', 'twentytwentyfive-child' ),
    'login'      => afx_login_url_for( 'panel' ),
    'auth_title' => __( 'Inicia sesión para ver tu panel', 'twentytwentyfive-child' ),
    'auth_text'  => __( 'Tu panel de gestión es solo para usuarios registrados. Inicia sesión o crea tu cuenta gratis y te llevaremos directo al Panel.', 'twentytwentyfive-child' ),
  ),
);
?>

<main id="main-content" class="afx-main afx-home">

  <!-- ========== HERO ========== -->
  <section class="afx-panel afx-panel--hero" id="inicio">
    <div class="afx-panel__inner">
      <div class="afx-hero">
        <div class="afx-hero__bg" style="background-image:url('<?php echo esc_url( $afx_img . 'hero-familia.jpg' ); ?>')" role="img" aria-label="<?php esc_attr_e( 'Familia revisando la gestión de su hogar', 'twentytwentyfive-child' ); ?>"></div>
        <div class="afx-hero__tint" aria-hidden="true"></div>
        <svg class="afx-hero__wave" viewBox="0 0 1440 520" preserveAspectRatio="none" aria-hidden="true" focusable="false">
          <path class="afx-wave afx-wave--sage" d="M0 520C300 505 640 420 1000 250 1180 165 1330 110 1440 90V520Z" opacity=".55"/>
          <path class="afx-wave afx-wave--green" d="M520 520C800 470 1100 360 1440 210V520Z"/>
        </svg>

        <div class="afx-hero__grid">
          <div class="afx-hero__copy">
            <p class="afx-hero__tag" data-afx><?php echo afx_icon( 'bolt', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Gestión inmobiliaria inteligente', 'twentytwentyfive-child' ); ?></p>
            <h1 class="afx-hero__title" data-afx>
              <?php esc_html_e( 'Tus propiedades.', 'twentytwentyfive-child' ); ?>
              <span><?php esc_html_e( 'Todo bajo control.', 'twentytwentyfive-child' ); ?></span>
            </h1>
            <p class="afx-hero__lead" data-afx><?php esc_html_e( 'Gestiona tus arriendos y haz crecer tu patrimonio con ArriendoFácil.', 'twentytwentyfive-child' ); ?></p>
            <div class="afx-hero__cta" data-afx>
              <a class="afx-btn afx-btn--light afx-btn--lg" href="<?php echo esc_url( af_signup_url() ); ?>">
                <?php esc_html_e( 'Empieza gratis', 'twentytwentyfive-child' ); ?>
                <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              </a>
              <a class="afx-hero__demo" href="https://youtu.be/D7zJZFqUdzQ" target="_blank" rel="noopener" data-afx-video="D7zJZFqUdzQ" data-afx-video-title="<?php echo esc_attr( __( 'Demo de ArriendoFácil', 'twentytwentyfive-child' ) ); ?>" aria-haspopup="dialog">
                <span class="afx-hero__demo-icon"><?php echo afx_icon( 'play', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                <?php esc_html_e( 'Ver demo', 'twentytwentyfive-child' ); ?>
              </a>
            </div>
          </div>

          <div class="afx-hero__visual" data-afx data-afx-tilt>
            <div class="afx-dash" data-afx-depth="14" role="img" aria-label="<?php esc_attr_e( 'Vista previa del panel Resumen General de ArriendoFácil', 'twentytwentyfive-child' ); ?>">
              <div class="afx-dash__bar" aria-hidden="true"><i></i><i></i><i></i></div>
              <aside class="afx-dash__side" aria-hidden="true">
                <?php echo afx_icon( 'home', 34 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                <ul>
                  <?php foreach ( $afx_nav_items as $item ) : ?>
                    <li><?php echo afx_icon( $item[1], 11 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $item[0] ); ?></li>
                  <?php endforeach; ?>
                </ul>
              </aside>
              <div class="afx-dash__main" aria-hidden="true">
                <h2 class="afx-dash__title"><?php esc_html_e( 'Resumen General', 'twentytwentyfive-child' ); ?></h2>
                <dl class="afx-dash__stats">
                  <div><dt><?php esc_html_e( 'Ingresos del mes', 'twentytwentyfive-child' ); ?></dt><dd>$<span data-count="12480">12.480</span></dd></div>
                  <div><dt><?php esc_html_e( 'Propiedades', 'twentytwentyfive-child' ); ?></dt><dd><span data-count="48">48</span></dd></div>
                  <div><dt><?php esc_html_e( 'Pagos al día', 'twentytwentyfive-child' ); ?></dt><dd><span data-count="92">92</span>%</dd></div>
                </dl>
                <div class="afx-dash__lower">
                  <div class="afx-dash__chart">
                    <h3><?php esc_html_e( 'Cobros de los últimos 6 meses', 'twentytwentyfive-child' ); ?></h3>
                    <div class="afx-bars">
                      <?php foreach ( $afx_bars as $bar ) : ?>
                        <div class="afx-bars__col<?php echo 'May' === $bar[0] ? ' is-peak' : ''; ?>">
                          <?php if ( 'May' === $bar[0] ) : ?><em>$12.480</em><?php endif; ?>
                          <span class="afx-bar" style="height:<?php echo (int) $bar[1]; ?>%"></span>
                          <small><?php echo esc_html( $bar[0] ); ?></small>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <div class="afx-dash__due">
                    <h3><?php esc_html_e( 'Próximos vencimientos', 'twentytwentyfive-child' ); ?></h3>
                    <ul>
                      <?php foreach ( $afx_due as $i => $row ) : ?>
                        <li><?php echo afx_property_thumb( $afx_ph[ $i ] ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $row[0] ); ?></span><b><?php echo esc_html( $row[1] ); ?></b></li>
                      <?php endforeach; ?>
                    </ul>
                    <a href="#" tabindex="-1"><?php esc_html_e( 'Ver todo', 'twentytwentyfive-child' ); ?> →</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="afx-toast" data-afx-depth="30">
              <?php echo afx_icon( 'check', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              <div><strong><?php esc_html_e( 'Inmueble registrado', 'twentytwentyfive-child' ); ?></strong><span><?php esc_html_e( 'Hace 2 min', 'twentytwentyfive-child' ); ?></span></div>
            </div>
          </div>
        </div>
      </div>

      <ul class="afx-pills">
        <li class="afx-pill-li" data-afx><button class="afx-pill" type="button" data-afx-video="oGrAxVxsBZE" data-afx-video-title="<?php echo esc_attr( __( 'Contratos digitales', 'twentytwentyfive-child' ) ); ?>" aria-haspopup="dialog"><span class="afx-pill__icon"><?php echo afx_icon( 'hex', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Contratos digitales', 'twentytwentyfive-child' ); ?></strong><small><?php esc_html_e( 'Ahorra tiempo', 'twentytwentyfive-child' ); ?></small></span><span class="afx-pill__play" aria-hidden="true"><?php echo afx_icon( 'play', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button></li>
        <li class="afx-pill-li" data-afx><button class="afx-pill" type="button" data-afx-video="Mgp0gHp-aFo" data-afx-video-title="<?php echo esc_attr( __( 'Control de pagos', 'twentytwentyfive-child' ) ); ?>" aria-haspopup="dialog"><span class="afx-pill__icon"><?php echo afx_icon( 'hex', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Control de pagos', 'twentytwentyfive-child' ); ?></strong><small><?php esc_html_e( 'Seguimiento en tiempo real', 'twentytwentyfive-child' ); ?></small></span><span class="afx-pill__play" aria-hidden="true"><?php echo afx_icon( 'play', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button></li>
        <li class="afx-pill-li" data-afx><button class="afx-pill" type="button" data-afx-video="zm1JFhZMlVw" data-afx-video-title="<?php echo esc_attr( __( 'Mantenimiento', 'twentytwentyfive-child' ) ); ?>" aria-haspopup="dialog"><span class="afx-pill__icon"><?php echo afx_icon( 'wrench', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><span><strong><?php esc_html_e( 'Mantenimiento', 'twentytwentyfive-child' ); ?></strong><small><?php esc_html_e( 'Organiza tus reparaciones', 'twentytwentyfive-child' ); ?></small></span><span class="afx-pill__play" aria-hidden="true"><?php echo afx_icon( 'play', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button></li>
      </ul>
    </div>
  </section>

  <!-- ========== SECCIÓN FIJA: ¿CÓMO FUNCIONA? → FAQ → PLANES ========== -->
  <div class="afx-story" data-afx-story>

    <!-- 1 · ¿Cómo funciona? -->
    <section class="afx-stage" id="como-funciona" data-afx-stage data-title="<?php esc_attr_e( '¿Cómo funciona?', 'twentytwentyfive-child' ); ?>">
      <div class="afx-stage__media" aria-hidden="true">
        <img class="afx-stage__bg" src="<?php echo esc_url( $afx_img . 'stage-terraza.jpg' ); ?>" alt="" width="1408" height="768" decoding="async" style="object-position:70% 50%">
        <span class="afx-stage__tint"></span>
      </div>
      <div class="afx-wrap afx-stage__grid">
        <div class="afx-stage__intro" data-afx-stagec>
          <p class="afx-tag afx-tag--dark"><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( '¿Cómo funciona?', 'twentytwentyfive-child' ); ?></p>
          <h2 class="afx-title"><?php esc_html_e( 'Empieza en', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( '3 simples pasos', 'twentytwentyfive-child' ); ?></span></h2>
          <a class="afx-btn afx-btn--light" href="<?php echo esc_url( af_signup_url() ); ?>">
            <?php esc_html_e( 'Conoce más', 'twentytwentyfive-child' ); ?>
            <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
          </a>
        </div>

        <div class="afx-stage__card afx-stage__card--steps" data-afx-stagec>
          <ol class="afx-steps">
            <?php foreach ( $afx_steps as $i => $step ) : ?>
              <?php if ( $i ) : ?>
                <li class="afx-step__sep" aria-hidden="true"><?php echo afx_icon( 'chevron-r', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></li>
              <?php endif; ?>
              <li class="afx-step">
                <span class="afx-step__n"><?php echo (int) $step['n']; ?></span>
                <?php if ( 1 === $step['n'] || $afx_logged ) : ?>
                  <a class="afx-step__icon" href="<?php echo esc_url( $step['url'] ); ?>" aria-label="<?php echo esc_attr( $step['label'] ); ?>">
                    <?php echo afx_icon( $step['icon'], 40 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                  </a>
                <?php else : ?>
                  <button class="afx-step__icon" type="button" aria-haspopup="dialog" aria-label="<?php echo esc_attr( $step['label'] ); ?>"
                    data-afx-auth
                    data-afx-auth-title="<?php echo esc_attr( $step['auth_title'] ); ?>"
                    data-afx-auth-text="<?php echo esc_attr( $step['auth_text'] ); ?>"
                    data-afx-auth-login="<?php echo esc_url( $step['login'] ); ?>"
                    data-afx-auth-signup="<?php echo esc_url( af_signup_url() ); ?>">
                    <?php echo afx_icon( $step['icon'], 40 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                  </button>
                <?php endif; ?>
                <h3><?php echo esc_html( $step['title'] ); ?></h3>
                <p><?php echo esc_html( $step['text'] ); ?></p>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </section>

    <!-- 2 · Planes -->
    <section class="afx-stage" id="planes" data-afx-stage data-title="<?php esc_attr_e( 'Planes y precios', 'twentytwentyfive-child' ); ?>">
      <div class="afx-stage__media" aria-hidden="true">
        <img class="afx-stage__bg" src="<?php echo esc_url( $afx_img . 'stage-sala.jpg' ); ?>" alt="" width="1408" height="768" loading="lazy" decoding="async" style="object-position:55% 50%">
        <span class="afx-stage__tint"></span>
      </div>
      <div class="afx-wrap afx-stage__grid afx-stage__grid--plans">
        <div class="afx-stage__intro" data-afx-stagec>
          <p class="afx-tag afx-tag--dark"><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Planes y precios', 'twentytwentyfive-child' ); ?></p>
          <h2 class="afx-title"><?php esc_html_e( 'Elige el', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'plan ideal', 'twentytwentyfive-child' ); ?></span> <?php esc_html_e( 'para ti', 'twentytwentyfive-child' ); ?></h2>
          <p class="afx-stage__lead"><?php esc_html_e( 'Escala tu negocio con planes flexibles y sin costos ocultos.', 'twentytwentyfive-child' ); ?></p>
        </div>

        <div class="afx-stage__card afx-stage__card--plans" data-afx-stagec>
          <article class="afx-plan">
            <h3><?php esc_html_e( 'Plan Free', 'twentytwentyfive-child' ); ?></h3>
            <p class="afx-plan__desc"><?php esc_html_e( 'Para empezar a probar', 'twentytwentyfive-child' ); ?></p>
            <p class="afx-plan__price"><b>$0</b> <span><?php esc_html_e( '/mes', 'twentytwentyfive-child' ); ?></span></p>
            <ul>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Hasta 4 propiedades', 'twentytwentyfive-child' ); ?></li>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Funciones limitadas', 'twentytwentyfive-child' ); ?></li>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Ideal para probar la plataforma', 'twentytwentyfive-child' ); ?></li>
            </ul>
            <a class="afx-btn afx-btn--soft afx-btn--block" href="<?php echo esc_url( af_signup_url() ); ?>"><?php esc_html_e( 'Comenzar ahora', 'twentytwentyfive-child' ); ?></a>
          </article>

          <article class="afx-plan afx-plan--flip" data-afx-flip>
            <div class="afx-plan__inner">
              <div class="afx-plan__face afx-plan__face--front">
                <h3><?php esc_html_e( 'Plan Básico', 'twentytwentyfive-child' ); ?></h3>
                <p class="afx-plan__desc"><?php esc_html_e( 'Para administrar con orden', 'twentytwentyfive-child' ); ?></p>
                <p class="afx-plan__price"><b>$10</b> <span><?php esc_html_e( '/mes', 'twentytwentyfive-child' ); ?></span></p>
                <ul>
                  <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Hasta 15 propiedades', 'twentytwentyfive-child' ); ?></li>
                  <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Todas las funciones principales', 'twentytwentyfive-child' ); ?></li>
                  <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Soporte por email', 'twentytwentyfive-child' ); ?></li>
                </ul>
                <button type="button" class="afx-plan__flip" data-afx-flip-btn aria-expanded="false"><?php echo afx_icon( 'refresh', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Ver qué incluye', 'twentytwentyfive-child' ); ?></button>
                <a class="afx-btn afx-btn--soft afx-btn--block" href="<?php echo esc_url( af_signup_url() ); ?>"><?php esc_html_e( 'Comenzar ahora', 'twentytwentyfive-child' ); ?></a>
              </div>
              <div class="afx-plan__face afx-plan__face--back" aria-hidden="true">
                <h3><?php esc_html_e( 'Qué incluye el Plan Básico', 'twentytwentyfive-child' ); ?></h3>
                <ul>
                  <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Mantenimiento: sección limitada según el número de propiedades', 'twentytwentyfive-child' ); ?></span></li>
                  <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Contratos: limitados según el número de propiedades', 'twentytwentyfive-child' ); ?></span></li>
                  <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Inquilinos: limitados según el número de propiedades', 'twentytwentyfive-child' ); ?></span></li>
                  <li class="is-no"><?php echo afx_icon( 'x', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'No incluye catálogo', 'twentytwentyfive-child' ); ?></span></li>
                  <li class="is-no"><?php echo afx_icon( 'x', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'No incluye facturación', 'twentytwentyfive-child' ); ?></span></li>
                </ul>
                <button type="button" class="afx-plan__flip" data-afx-flip-btn aria-expanded="true" tabindex="-1"><?php echo afx_icon( 'refresh', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Volver', 'twentytwentyfive-child' ); ?></button>
                <a class="afx-btn afx-btn--soft afx-btn--block" href="<?php echo esc_url( af_signup_url() ); ?>" tabindex="-1"><?php esc_html_e( 'Comenzar ahora', 'twentytwentyfive-child' ); ?></a>
              </div>
            </div>
          </article>

          <article class="afx-plan afx-plan--pro">
            <span class="afx-plan__crown"><?php echo afx_icon( 'crown', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="afx-sr"><?php esc_html_e( 'Recomendado', 'twentytwentyfive-child' ); ?></span></span>
            <h3><?php esc_html_e( 'Plan Profesional', 'twentytwentyfive-child' ); ?></h3>
            <p class="afx-plan__desc"><?php esc_html_e( 'Para crecer sin límites', 'twentytwentyfive-child' ); ?></p>
            <p class="afx-plan__price"><b>$20</b> <span><?php esc_html_e( '/mes', 'twentytwentyfive-child' ); ?></span></p>
            <ul>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Propiedades ilimitadas', 'twentytwentyfive-child' ); ?></li>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Soporte con chatbot', 'twentytwentyfive-child' ); ?></li>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Catálogo de propiedades', 'twentytwentyfive-child' ); ?></li>
              <li><?php echo afx_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Facturación electrónica', 'twentytwentyfive-child' ); ?></li>
            </ul>
            <a class="afx-btn afx-btn--dark afx-btn--block" href="<?php echo esc_url( af_signup_url() ); ?>"><?php esc_html_e( 'Comenzar ahora', 'twentytwentyfive-child' ); ?></a>
          </article>
        </div>
      </div>
    </section>


    <!-- 3 · FAQ -->
    <section class="afx-stage" id="faq" data-afx-stage data-title="<?php esc_attr_e( 'Preguntas frecuentes', 'twentytwentyfive-child' ); ?>">
      <div class="afx-stage__media" aria-hidden="true">
        <img class="afx-stage__bg" src="<?php echo esc_url( $afx_img . 'stage-edificio.jpg' ); ?>" alt="" width="1408" height="768" loading="lazy" decoding="async" style="object-position:60% 50%">
        <span class="afx-stage__tint"></span>
      </div>
      <div class="afx-wrap afx-stage__grid">
        <div class="afx-stage__intro" data-afx-stagec>
          <p class="afx-tag afx-tag--dark"><?php echo afx_icon( 'bolt', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Preguntas frecuentes', 'twentytwentyfive-child' ); ?></p>
          <h2 class="afx-title"><?php esc_html_e( 'Resuelve tus', 'twentytwentyfive-child' ); ?> <span><?php esc_html_e( 'dudas', 'twentytwentyfive-child' ); ?></span></h2>
          <a class="afx-btn afx-btn--light" href="<?php echo esc_url( home_url( '/preguntas-frecuentes/' ) ); ?>">
            <?php esc_html_e( 'Ver todas las preguntas', 'twentytwentyfive-child' ); ?>
            <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
          </a>
        </div>

        <div class="afx-stage__card afx-stage__card--faq" data-afx-stagec>
          <div class="afx-acc">
            <?php foreach ( $afx_faq as $i => $qa ) : ?>
              <div class="afx-acc__item">
                <h3>
                  <button class="afx-acc__btn" type="button" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="afx-faq-<?php echo (int) $i; ?>" id="afx-faq-btn-<?php echo (int) $i; ?>">
                    <span><?php echo esc_html( $qa[0] ); ?></span>
                    <?php echo afx_icon( 'plus', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                  </button>
                </h3>
                <div class="afx-acc__panel" id="afx-faq-<?php echo (int) $i; ?>" role="region" aria-labelledby="afx-faq-btn-<?php echo (int) $i; ?>">
                  <p><?php echo esc_html( $qa[1] ); ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

  </div>
</main>

<?php get_footer(); ?>
