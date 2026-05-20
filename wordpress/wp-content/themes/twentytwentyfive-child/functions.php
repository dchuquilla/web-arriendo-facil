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

  // Child style (con cache busting basado en modificación del archivo)
  wp_enqueue_style(
    'twentytwentyfive-child-style',
    get_stylesheet_uri(),
    array($parent_style_handle),
    filemtime( get_stylesheet_directory() . '/style.css' )
  );

  // Lightbox para bloques de galería (site-wide; no-op si no hay galerías)
  wp_enqueue_script(
    'twentytwentyfive-child-gallery-lightbox',
    get_stylesheet_directory_uri() . '/assets/js/gallery-lightbox.js',
    array(),
    wp_get_theme()->get('Version'),
    true
  );

  // Search bar (global)
  wp_enqueue_script(
    'twentytwentyfive-child-search-bar',
    get_stylesheet_directory_uri() . '/assets/js/search-bar.js',
    array(),
    filemtime( get_stylesheet_directory() . '/assets/js/search-bar.js' ),
    true
  );

  // Warm likely next pages (property detail and properties list) to improve perceived navigation speed.
  wp_enqueue_script(
    'twentytwentyfive-child-nav-prefetch',
    get_stylesheet_directory_uri() . '/assets/js/nav-prefetch.js',
    array(),
    '1.0.0',
    true
  );

  // Service worker for offline support and page caching
  wp_enqueue_script(
    'twentytwentyfive-child-sw-register',
    get_stylesheet_directory_uri() . '/assets/js/sw-register.js',
    array(),
    '1.0.0',
    true
  );

  // Cookie wall enforcement (blocks page until cookies accepted)
  wp_enqueue_script(
    'twentytwentyfive-child-cookie-wall',
    get_stylesheet_directory_uri() . '/assets/js/cookie-wall.js',
    array(),
    filemtime( get_stylesheet_directory() . '/assets/js/cookie-wall.js' ),
    false
  );

  // JS para el carrusel solo en homepage
  if ( is_front_page() ) {
    wp_enqueue_script(
      'twentytwentyfive-child-home',
      get_stylesheet_directory_uri() . '/assets/js/home.js',
      array(),
      filemtime( get_stylesheet_directory() . '/assets/js/home.js' ),
      true
    );

    wp_enqueue_script(
      'twentytwentyfive-child-hero-search',
      get_stylesheet_directory_uri() . '/assets/js/hero-search.js',
      array(),
      filemtime( get_stylesheet_directory() . '/assets/js/hero-search.js' ),
      true
    );

    wp_enqueue_script(
      'twentytwentyfive-child-referral',
      get_stylesheet_directory_uri() . '/assets/js/referral.js',
      array(),
      filemtime( get_stylesheet_directory() . '/assets/js/referral.js' ),
      true
    );

    wp_localize_script('twentytwentyfive-child-referral', 'afReferral', array(
      'whatsapp' => get_option( 'af_whatsapp_number', '' ),
    ));

    // Data para el carrusel (propiedades destacadas)
    $properties = twentytwentyfive_child_get_featured_properties_payload();
    wp_localize_script('twentytwentyfive-child-home', 'twentytwentyfive_HOME', array(
      'properties' => $properties,
    ));
  }

  // Real-time polling for properties page
  if ( is_page('propiedades') ) {
    wp_enqueue_script(
      'twentytwentyfive-child-propiedades',
      get_stylesheet_directory_uri() . '/assets/js/propiedades.js',
      array(),
      filemtime( get_stylesheet_directory() . '/assets/js/propiedades.js' ),
      true
    );

    wp_localize_script('twentytwentyfive-child-propiedades', 'afPropiedades', array(
      'apiUrl'      => esc_url_raw( rest_url( 'af/v1/accommodations/search' ) ),
      'placeholder' => get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg',
      'filters'     => array(
        'location'      => isset( $_GET['location'] ) ? sanitize_text_field( wp_unslash( $_GET['location'] ) ) : '',
        'price_min'     => isset( $_GET['price_min'] ) ? sanitize_text_field( wp_unslash( $_GET['price_min'] ) ) : '',
        'price_max'     => isset( $_GET['price_max'] ) ? sanitize_text_field( wp_unslash( $_GET['price_max'] ) ) : '',
        'property_type' => isset( $_GET['property_type'] ) ? sanitize_text_field( wp_unslash( $_GET['property_type'] ) ) : '',
        'sort'          => isset( $_GET['sort'] ) ? sanitize_text_field( wp_unslash( $_GET['sort'] ) ) : 'newest',
      ),
    ));
  }

  // Leaflet.js y estilos para página de búsqueda
  if ( is_page('search-results') || is_singular('accommodation') ) {
    wp_enqueue_style(
      'leaflet-css',
      'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css',
      array(),
      '1.9.4'
    );

    wp_enqueue_script(
      'leaflet-js',
      'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js',
      array(),
      '1.9.4',
      true
    );

    wp_enqueue_style(
      'twentytwentyfive-child-search-results',
      get_stylesheet_directory_uri() . '/assets/css/search-results.css',
      array( 'twentytwentyfive-child-style' ),
      filemtime( get_stylesheet_directory() . '/assets/css/search-results.css' )
    );

    wp_enqueue_script(
      'twentytwentyfive-child-search-results',
      get_stylesheet_directory_uri() . '/assets/js/search-results-interactive.js',
      array( 'leaflet-js' ),
      filemtime( get_stylesheet_directory() . '/assets/js/search-results-interactive.js' ),
      true
    );
  }

  // Owner registration wizard
  if ( is_page_template( 'page-registro-propietario.php' ) ) {
    wp_enqueue_script(
      'twentytwentyfive-child-owner-registration',
      get_stylesheet_directory_uri() . '/assets/js/owner-registration.js',
      array(),
      filemtime( get_stylesheet_directory() . '/assets/js/owner-registration.js' ),
      true
    );

    wp_localize_script('twentytwentyfive-child-owner-registration', 'afOwnerReg', array(
      'apiUrl' => esc_url_raw( rest_url( 'af/v1/owner-register' ) ),
    ));
  }
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_assets', 20);

/**
 * Obtiene propiedades destacadas desde Posts (categoría: propiedades-destacadas)
 * Ajusta esto a CPT/ACF si tu proyecto lo requiere.
 */
function twentytwentyfive_child_get_featured_properties_payload() {
  $cache_key = 'af_featured_properties';
  $payload = wp_cache_get($cache_key);

  if ($payload !== false) {
    return $payload;
  }

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

      $img = get_the_post_thumbnail_url(get_the_ID(), 'af-card');
      if ( ! $img ) {
        $gallery = twentytwentyfive_child_get_accommodation_gallery_images(get_the_ID());
        if ( ! empty($gallery) && ! empty($gallery[0]['id']) ) {
          $img = wp_get_attachment_image_url($gallery[0]['id'], 'af-card');
        }
      }
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

  wp_cache_set($cache_key, $payload, '', 3600);

  return $payload;
}

/**
 * Obtiene imágenes del post para carousel desde galería WP o attachments.
 * Retorna array de imágenes con URLs full y comprimidas para blur.
 */
function twentytwentyfive_child_get_accommodation_gallery_images($post_id) {
  if (!$post_id) {
    return [];
  }

  $images = [];
  $post = get_post($post_id);

  if (!$post || !$post->post_content) {
    return [];
  }

  // Primero intentar extraer imágenes de bloque de galería WP
  if (has_block('gallery', $post)) {
    $pattern = '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*(?:data-id=[\'"]([^\'"]+)[\'"])?/';
    if (preg_match_all($pattern, $post->post_content, $matches)) {
      foreach ($matches[1] as $index => $src) {
        $attachment_id = $matches[2][$index] ?? 0;

        // Intentar obtener datos del attachment si existe
        if ($attachment_id && is_numeric($attachment_id)) {
          $full_url = wp_get_attachment_image_src($attachment_id, 'large');
          $thumb_url = wp_get_attachment_image_src($attachment_id, 'thumbnail');

          if ($full_url && $thumb_url) {
            $images[] = [
              'id'        => $attachment_id,
              'url'       => $full_url[0],
              'url_small' => $thumb_url[0],
              'alt'       => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
            ];
          }
        } else {
          // Si no tenemos ID, usar la URL directa
          if (!empty($src)) {
            $images[] = [
              'id'        => 0,
              'url'       => $src,
              'url_small' => $src, // Fallback
              'alt'       => '',
            ];
          }
        }
      }
    }

    if (!empty($images)) {
      return $images;
    }
  }

  // Fallback: obtener todos los attachments del post
  $attachments = get_posts([
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_parent'    => $post_id,
    'posts_per_page' => -1,
    'orderby'        => 'menu_order ID',
    'order'          => 'ASC',
  ]);

  if (!empty($attachments)) {
    foreach ($attachments as $attachment) {
      $full_url = wp_get_attachment_image_src($attachment->ID, 'large');
      $thumb_url = wp_get_attachment_image_src($attachment->ID, 'thumbnail');

      if ($full_url && $thumb_url) {
        $images[] = [
          'id'        => $attachment->ID,
          'url'       => $full_url[0],
          'url_small' => $thumb_url[0],
          'alt'       => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
        ];
      }
    }
  }

  return $images;
}

/**
 * Enqueue carousel script only on single accommodation pages.
 */
function twentytwentyfive_child_enqueue_single_carousel() {
  if (!is_singular('accommodation')) {
    return;
  }

  wp_enqueue_script(
    'twentytwentyfive-child-single-carousel',
    get_stylesheet_directory_uri() . '/assets/js/single.js',
    [],
    filemtime(get_stylesheet_directory() . '/assets/js/single.js'),
    true
  );

  $post_id = get_the_ID();
  $gallery_images = twentytwentyfive_child_get_accommodation_gallery_images($post_id);

  wp_localize_script(
    'twentytwentyfive-child-single-carousel',
    'singleCarouselData',
    [
      'images' => $gallery_images,
    ]
  );
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_single_carousel', 15);

/**
 * Menú principal (si el tema padre no lo registra o quieres controlarlo).
 */
function twentytwentyfive_child_register_menus() {
  register_nav_menus(array(
    'primary' => __('Menú principal', 'twentytwentyfive-child'),
  ));
}
add_action('after_setup_theme', 'twentytwentyfive_child_register_menus', 5);

/**
 * Register custom image sizes for property cards and banners.
 */
function twentytwentyfive_child_register_image_sizes() {
  add_image_size( 'af-card', 600, 400, true );
  add_image_size( 'af-banner', 1200, 500, true );
  add_image_size( 'af-thumbnail', 300, 200, true );
}
add_action( 'after_setup_theme', 'twentytwentyfive_child_register_image_sizes' );

/**
 * Auto-assign first gallery image as featured image when saving an accommodation.
 */
function twentytwentyfive_child_auto_featured_image( $post_id ) {
  if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
    return;
  }
  if ( has_post_thumbnail( $post_id ) ) {
    return;
  }

  $gallery_images = twentytwentyfive_child_get_accommodation_gallery_images( $post_id );
  if ( ! empty( $gallery_images ) && ! empty( $gallery_images[0]['id'] ) ) {
    set_post_thumbnail( $post_id, $gallery_images[0]['id'] );
  }
}
add_action( 'save_post_accommodation', 'twentytwentyfive_child_auto_featured_image', 20 );

/**
 * Get featured image ID with gallery fallback for templates.
 */
function twentytwentyfive_child_get_property_thumbnail_id( $post_id ) {
  $thumb_id = get_post_thumbnail_id( $post_id );
  if ( $thumb_id ) {
    return $thumb_id;
  }

  $gallery = twentytwentyfive_child_get_accommodation_gallery_images( $post_id );
  if ( ! empty( $gallery ) && ! empty( $gallery[0]['id'] ) ) {
    return (int) $gallery[0]['id'];
  }

  return 0;
}

/**
 * Remove 'Residencias' menu item from navigation
 */
function twentytwentyfive_child_remove_residencias_menu_item( $items, $args ) {
  if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
    foreach ( $items as $key => $item ) {
      if ( stripos( $item->title, 'residencia' ) !== false ) {
        unset( $items[ $key ] );
      }
    }
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', 'twentytwentyfive_child_remove_residencias_menu_item', 10, 2 );

/**
 * Agregar cache headers para mejor rendimiento
 */
function twentytwentyfive_child_add_cache_headers() {
  if (is_user_logged_in()) {
    return;
  }

  if (is_front_page() || is_page('search-results')) {
    header('Cache-Control: public, max-age=3600');
  } elseif (is_page('propiedades')) {
    header('Cache-Control: public, max-age=60');
  } elseif (is_singular('accommodation')) {
    header('Cache-Control: public, max-age=7200');
  } else {
    header('Cache-Control: public, max-age=1800');
  }
}
add_action('wp_head', 'twentytwentyfive_child_add_cache_headers');