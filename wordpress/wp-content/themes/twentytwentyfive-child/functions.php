<?php
/**
 * Theme functions for Mi Tema Child - Hospedajes
 */

if ( ! defined('ABSPATH') ) { exit; }

/**
 * Enqueue parent + child styles and child scripts.
 */
function twentytwentyfive_child_enqueue_assets() {
  $parent_style_handle = 'parent-style';

  // Parent style (si el padre lo expone por style.css)
  wp_enqueue_style(
    $parent_style_handle,
    get_template_directory_uri() . '/style.css',
    array(),
    wp_get_theme(get_template())->get('Version')
  );

  // Child style
  wp_enqueue_style(
    'twentytwentyfive-child-style',
    get_stylesheet_uri(),
    array($parent_style_handle),
    wp_get_theme()->get('Version')
  );

  // JS para el carrusel solo en homepage
  if ( is_front_page() ) {
    wp_enqueue_script(
      'twentytwentyfive-child-home',
      get_stylesheet_directory_uri() . '/assets/js/home.js',
      array(),
      wp_get_theme()->get('Version'),
      true
    );

    // Data para el carrusel (propiedades destacadas)
    $properties = twentytwentyfive_child_get_featured_properties_payload();
    wp_localize_script('twentytwentyfive-child-home', 'twentytwentyfive_HOME', array(
      'properties' => $properties,
    ));
  }
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_assets', 20);

/**
 * Obtiene propiedades destacadas desde Posts (categoría: propiedades-destacadas)
 * Ajusta esto a CPT/ACF si tu proyecto lo requiere.
 */
function twentytwentyfive_child_get_featured_properties_payload() {
  $payload = array();

  $q = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'ignore_sticky_posts' => true,
    'category_name'  => 'propiedades-destacadas',
  ));

  if ( $q->have_posts() ) {
    while ( $q->have_posts() ) {
      $q->the_post();

      $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
      if ( ! $img ) {
        $img = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
      }

      // Campos opcionales por meta (si luego quieres mapearlos desde ACF)
      $location = get_post_meta(get_the_ID(), 'property_location', true);
      $price    = get_post_meta(get_the_ID(), 'property_price_per_night', true);

      $payload[] = array(
        'id'       => get_the_ID(),
        'title'    => get_the_title(),
        'permalink'=> get_permalink(),
        'image'    => esc_url_raw($img),
        'location' => $location ? $location : 'Ubicación por definir',
        'price'    => $price ? $price : '$xx por noche',
        'badges'   => array('Limpieza incluida', 'Mantenimiento 24/7', 'Gestión completa'),
      );
    }
    wp_reset_postdata();
  }

  // Fallback si no hay posts en la categoría
  if ( empty($payload) ) {
    $placeholder = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
    for ($i=1; $i<=3; $i++){
      $payload[] = array(
        'id' => 0,
        'title' => 'Propiedad Destacada #' . $i,
        'permalink' => '#',
        'image' => esc_url_raw($placeholder),
        'location' => 'Quito / Guayaquil',
        'price' => '$xx por noche',
        'badges' => array('Limpieza incluida', 'Mantenimiento 24/7', 'Gestión completa'),
      );
    }
  }

  return $payload;
}

/**
 * Menú principal (si el tema padre no lo registra o quieres controlarlo).
 */
function twentytwentyfive_child_register_menus() {
  register_nav_menus(array(
    'primary' => __('Menú principal', 'twentytwentyfive-child'),
  ));
}
add_action('after_setup_theme', 'twentytwentyfive_child_register_menus', 5);