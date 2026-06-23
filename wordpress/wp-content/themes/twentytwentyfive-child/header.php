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

<a href="#main-content" class="skip-to-content">
  <?php esc_html_e('Ir al contenido principal', 'twentytwentyfive-child'); ?>
</a>

<header class="site-header" role="banner" id="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/favicon/favicon-96x96.png" alt="Arriendo Fácil" width="60" height="60" decoding="async" fetchpriority="high">
      <span><?php bloginfo('name'); ?></span>
    </a>

    <div class="search-bar-wrapper">
      <input
        type="text"
        id="search-bar-input"
        class="search-bar-input"
        placeholder="<?php esc_attr_e('Busca por ubicación...', 'twentytwentyfive-child'); ?>"
        autocomplete="off" />
      <ul id="search-suggestions" class="search-suggestions"></ul>
      <button id="search-bar-btn" class="search-bar-btn" aria-label="<?php esc_attr_e('Buscar', 'twentytwentyfive-child'); ?>">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </button>
    </div>

    <button class="nav-toggle" aria-label="<?php esc_attr_e('Menú', 'twentytwentyfive-child'); ?>" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav class="nav" aria-label="<?php esc_attr_e('Navegación principal', 'twentytwentyfive-child'); ?>">
      <?php
        if ( has_nav_menu('primary') ) {
          wp_nav_menu(array(
            'menu_class' => 'main-menu',
            'theme_location' => 'primary',
            'container' => false,
            'depth' => 1,
            'fallback_cb' => false
          ));
        } else {
          // Simplified fallback navigation (4 items: Logo handled separately, + 3 nav items + CTA)
          $nav_links = array(
            array('Cómo funciona', '#como-funciona'),
            array('Contacto', '#contacto'),
          );
          foreach ($nav_links as $link) {
            echo '<a href="' . esc_url($link[1]) . '">' . esc_html($link[0]) . '</a>';
          }
        }
      ?>
      <div class="nav-ctas">
        <?php if ( ! is_page('registro-propietario') ) : ?>
        <a class="btn btn--outline nav-btn-owner" href="<?php echo esc_url(home_url('/registro-propietario/')); ?>">
          <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
          <?php esc_html_e('Registrarme como propietario', 'twentytwentyfive-child'); ?>
        </a>
        <?php endif; ?>
        <a class="btn btn--primary" href="<?php echo esc_url(home_url('/propiedades/')); ?>">
          <?php esc_html_e('Buscar propiedades', 'twentytwentyfive-child'); ?>
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </nav>
  </div>
</header>