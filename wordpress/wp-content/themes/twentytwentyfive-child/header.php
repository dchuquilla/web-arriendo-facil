<?php if ( ! defined('ABSPATH') ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon.svg" />
  <link rel="shortcut icon" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/apple-touch-icon.png" />
  <link rel="manifest" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/site.webmanifest" />

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner" id="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/images/arriendo-facil-logo-web-sq.png" alt="" width="60px">
      <span><?php bloginfo('name'); ?></span>
    </a>

    <button class="nav-toggle" type="button" aria-label="<?php esc_attr_e('Menú', 'twentytwentyfive-child'); ?>" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav class="nav" aria-label="<?php esc_attr_e('Navegación principal', 'twentytwentyfive-child'); ?>">
      <?php
        if ( has_nav_menu('primary') ) {
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'items_wrap' => '%3$s',
            'depth' => 1,
            'fallback_cb' => false
          ));
        } else {
          $links = array(
            array('Inicio', home_url('/')),
            array('Servicios', '#servicios'),
            array('Propiedades', '#arrendamiento'),
            array('Cómo funciona', '#como-funciona'),
          );
          foreach ($links as $l){
            echo '<a href="' . esc_url($l[1]) . '">' . esc_html($l[0]) . '</a>';
          }
        }
      ?>
      <a class="btn btn--primary" href="#contacto">
        <?php esc_html_e('Agenda asesoría', 'twentytwentyfive-child'); ?>
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </nav>
  </div>
</header>

<script>
// Header scroll effect & mobile nav
(function() {
  const header = document.getElementById('site-header');
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.nav');

  // Scroll effect
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 50);
  });

  // Mobile nav toggle
  toggle?.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', isOpen);
  });

  // Close nav on link click
  nav?.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('is-open');
      toggle?.setAttribute('aria-expanded', 'false');
    });
  });
})();
</script>