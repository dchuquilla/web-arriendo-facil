<?php if ( ! defined('ABSPATH') ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
  <div class="container header-inner">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="logo-box">LOGO</span>
      <span><?php bloginfo('name'); ?></span>
    </a>

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
          // Fallback wireframe links
          $links = array(
            array('Inicio', home_url('/')),
            array('Servicios', '#servicios'),
            array('Cómo funciona', '#como-funciona'),
            array('Precios', '#precios'),
            array('Blog', home_url('/blog/')),
          );
          foreach ($links as $l){
            echo '<a href="' . esc_url($l[1]) . '">' . esc_html($l[0]) . '</a>';
          }
        }
      ?>
      <a class="btn btn--primary" href="#contacto"><?php esc_html_e('Agenda una asesoría', 'twentytwentyfive-child'); ?></a>
    </nav>
  </div>
</header>