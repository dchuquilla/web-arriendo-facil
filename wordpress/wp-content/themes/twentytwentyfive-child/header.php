<?php if ( ! defined('ABSPATH') ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> data-theme="light" style="color-scheme: light only;">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light only">
  <meta name="supported-color-schemes" content="light only">
  <meta name="darkreader-lock">
  <link rel="preload" as="font" type="font/woff2" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/fonts/inter-latin.woff2" crossorigin>

  <link rel="icon" type="image/png" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon.svg" />
  <link rel="shortcut icon" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/apple-touch-icon.png" />
  <link rel="manifest" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/site.webmanifest" />

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="af-loading-screen" class="af-loading-screen" hidden aria-hidden="true">
  <div class="af-loading-screen__card" role="status" aria-live="polite" aria-atomic="true">
    <span class="af-loading-screen__icon" aria-hidden="true">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 9.5L12 2l9 7.5" />
        <path d="M5 10v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10" />
        <path d="M9 22v-6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6" />
      </svg>
    </span>
    <p class="af-loading-screen__text"><?php esc_html_e('Cargando...', 'twentytwentyfive-child'); ?></p>
  </div>
</div>

<a href="#main-content" class="skip-to-content">
  <?php esc_html_e('Ir al contenido principal', 'twentytwentyfive-child'); ?>
</a>

<?php
$afx_is_home   = is_front_page();
$afx_in_feat   = is_page( array( 'facturacion-electronica', 'pagos-y-cobros' ) );
$afx_home      = home_url( '/' );
?>
<header class="afx-header" role="banner" id="site-header">
  <div class="afx-header__inner">
    <a class="afx-brand" href="<?php echo esc_url( $afx_home ); ?>" aria-label="<?php esc_attr_e( 'ArriendoFácil - Inicio', 'twentytwentyfive-child' ); ?>">
      <?php echo afx_icon( 'home', 38, 'afx-brand__mark' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
      <span class="afx-brand__word">Arriendo<b>Fácil</b></span>
    </a>

    <button class="afx-burger" id="afx-burger" type="button" aria-label="<?php esc_attr_e( 'Abrir menú', 'twentytwentyfive-child' ); ?>" aria-expanded="false" aria-controls="afx-nav">
      <span></span><span></span><span></span>
    </button>

    <nav class="afx-nav" id="afx-nav" aria-label="<?php esc_attr_e( 'Navegación principal', 'twentytwentyfive-child' ); ?>">
      <ul class="afx-nav__list">
        <li><a class="afx-nav__link<?php echo $afx_is_home ? ' is-active' : ''; ?>" href="<?php echo esc_url( $afx_home ); ?>" data-afx-go="inicio" <?php echo $afx_is_home ? 'aria-current="page"' : ''; ?>><?php esc_html_e( 'Inicio', 'twentytwentyfive-child' ); ?></a></li>
        <li class="afx-nav__item afx-nav__item--has-menu">
          <button class="afx-nav__link afx-nav__link--menu<?php echo $afx_in_feat ? ' is-active' : ''; ?>" type="button" aria-expanded="false" aria-controls="afx-submenu">
            <?php esc_html_e( 'Funcionalidades', 'twentytwentyfive-child' ); ?>
            <?php echo afx_icon( 'chevron', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
          </button>
          <ul class="afx-submenu" id="afx-submenu">
            <li><a href="<?php echo esc_url( home_url( '/pagos-y-cobros/' ) ); ?>"><?php echo afx_icon( 'bell', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Pagos y cobros', 'twentytwentyfive-child' ); ?></a></li>
            <li><a href="<?php echo esc_url( home_url( '/facturacion-electronica/' ) ); ?>"><?php echo afx_icon( 'file', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Facturación electrónica', 'twentytwentyfive-child' ); ?></a></li>
          </ul>
        </li>
        <li><a class="afx-nav__link" href="<?php echo esc_url( $afx_home . '#planes' ); ?>" data-afx-go="planes"><?php esc_html_e( 'Planes', 'twentytwentyfive-child' ); ?></a></li>
        <li><a class="afx-nav__link" href="<?php echo esc_url( $afx_home . '#faq' ); ?>" data-afx-go="faq"><?php esc_html_e( 'FAQ', 'twentytwentyfive-child' ); ?></a></li>
        <li><a class="afx-nav__link<?php echo is_page( 'contacto' ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'twentytwentyfive-child' ); ?></a></li>
      </ul>

      <div class="afx-nav__actions">
        <a class="afx-nav__login" href="<?php echo esc_url( af_custom_login_base_url() ); ?>"><?php esc_html_e( 'Iniciar sesión', 'twentytwentyfive-child' ); ?></a>
        <a class="afx-btn afx-btn--grad" href="<?php echo esc_url( af_signup_url() ); ?>">
          <?php esc_html_e( 'Crear cuenta', 'twentytwentyfive-child' ); ?>
          <?php echo afx_icon( 'arrow', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        </a>
      </div>
    </nav>
  </div>
</header>