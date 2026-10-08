<?php if ( ! defined('ABSPATH') ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> data-theme="light" style="color-scheme: light only;">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light only">
  <meta name="supported-color-schemes" content="light only">
  <meta name="darkreader-lock">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"></noscript>

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

<header class="site-header" role="banner" id="site-header">
  <div class="container header-inner">
    <!-- Logo/Brand -->
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Arriendo Fácil - Inicio', 'twentytwentyfive-child'); ?>">
      <img class="brand-logo-img" src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/arriendo-facil-logo-web-sq.png" alt="" width="40" height="40" />
      <span class="brand-word">Arriendo<em>Fácil</em></span>
    </a>

    <!-- Hamburger Menu Toggle (mobile only) -->
    <button class="nav-toggle" id="nav-toggle" aria-label="<?php esc_attr_e('Abrir menú', 'twentytwentyfive-child'); ?>" aria-expanded="false" aria-controls="main-nav">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- Main Navigation -->
    <nav class="nav" id="main-nav" aria-label="<?php esc_attr_e('Navegación principal', 'twentytwentyfive-child'); ?>">
      <ul class="nav-menu">
        <li><a href="#servicios" class="nav-link"><?php esc_html_e('Servicios', 'twentytwentyfive-child'); ?></a></li>
        <li><a href="#como-funciona" class="nav-link"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></a></li>
        <li><a href="#contacto" class="nav-link"><?php esc_html_e('Contacto', 'twentytwentyfive-child'); ?></a></li>
      </ul>

<!-- CTA Button in Nav -->
      <a href="<?php echo esc_url( af_signup_url() ); ?>" class="btn btn--primary nav-cta">
        <?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?>
      </a>
    </nav>
  </div>
</header>