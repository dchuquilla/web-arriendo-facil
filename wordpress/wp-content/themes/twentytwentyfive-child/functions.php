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
    array($parent_style_handle, 'twentytwentyfive-child-tokens'),
    filemtime( get_stylesheet_directory() . '/style.css' )
  );

  // Design tokens (loaded separately to avoid @import blocking chain)
  wp_enqueue_style(
    'twentytwentyfive-child-tokens',
    get_stylesheet_directory_uri() . '/design-tokens.css',
    array($parent_style_handle),
    filemtime( get_stylesheet_directory() . '/design-tokens.css' )
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
    true
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
  if ( is_page( 'registro-propietario' ) ) {
    wp_enqueue_script(
      'twentytwentyfive-child-owner-registration',
      get_stylesheet_directory_uri() . '/assets/js/owner-registration.js',
      array(),
      filemtime( get_stylesheet_directory() . '/assets/js/owner-registration.js' ),
      true
    );

    wp_localize_script('twentytwentyfive-child-owner-registration', 'afOwnerRegister', array(
      'endpoint'  => esc_url_raw( rest_url( 'af/v1/owner-register' ) ),
      'nonce'     => wp_create_nonce( 'af_owner_register' ),
      'restNonce' => wp_create_nonce( 'wp_rest' ),
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
          $full_url = wp_get_attachment_image_src($attachment_id, 'af-banner');
          $thumb_url = wp_get_attachment_image_src($attachment_id, 'af-thumbnail');

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
      $full_url = wp_get_attachment_image_src($attachment->ID, 'af-banner');
      $thumb_url = wp_get_attachment_image_src($attachment->ID, 'af-thumbnail');

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
  add_image_size( 'af-card', 480, 320, true );
  add_image_size( 'af-banner', 900, 400, true );
  add_image_size( 'af-thumbnail', 240, 160, true );
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
add_action('send_headers', 'twentytwentyfive_child_add_cache_headers');

/**
 * Translate Complianz cookie policy strings to Spanish.
 */
function twentytwentyfive_child_complianz_translations( $translated, $text, $domain ) {
  if ( $domain !== 'complianz-gdpr' ) {
    return $translated;
  }

  static $translations = null;
  if ( $translations === null ) {
    $translations = array(
      'Introduction' => 'Introducción',
      'What are cookies?' => '¿Qué son las cookies?',
      'What are scripts?' => '¿Qué son los scripts?',
      'What is a web beacon?' => '¿Qué es un web beacon?',
      'Cookies' => 'Cookies',
      'Technical or functional cookies' => 'Cookies técnicas o funcionales',
      'Statistics cookies' => 'Cookies de estadísticas',
      'Advertising cookies' => 'Cookies de publicidad',
      'Marketing/Tracking cookies' => 'Cookies de marketing/seguimiento',
      'Social media' => 'Redes sociales',
      'Placed cookies' => 'Cookies implementadas',
      'Consent' => 'Consentimiento',
      'Manage your consent settings' => 'Gestionar tu configuración de consentimiento',
      'Vendors' => 'Proveedores',
      'Enabling/disabling and deleting cookies' => 'Activar/desactivar y eliminar cookies',
      'Your rights with respect to personal data' => 'Tus derechos respecto a datos personales',
      'Contact details' => 'Datos de contacto',
      'This Cookie Policy was last updated on %s and applies to citizens and legal permanent residents of the European Economic Area and Switzerland.' => 'Esta Política de Cookies fue actualizada por última vez el %s y aplica a ciudadanos y residentes legales permanentes del Espacio Económico Europeo y Suiza.',
      'Our website, %s (hereinafter: "the website") uses cookies and other related technologies (for convenience all technologies are referred to as "cookies"). Cookies are also placed by third parties we have engaged. In the document below we inform you about the use of cookies on our website.' => 'Nuestro sitio web, %s (en adelante: "el sitio web") utiliza cookies y otras tecnologías relacionadas (por conveniencia, todas las tecnologías se denominan "cookies"). Las cookies también son colocadas por terceros que hemos contratado. En el siguiente documento te informamos sobre el uso de cookies en nuestro sitio web.',
      'A cookie is a small simple file that is sent along with pages of this website and stored by your browser on the hard drive of your computer or another device. The information stored therein may be returned to our servers or to the servers of the relevant third parties during a subsequent visit.' => 'Una cookie es un pequeño archivo de texto que se envía junto con las páginas de este sitio web y que tu navegador almacena en el disco duro de tu computadora u otro dispositivo. La información almacenada puede ser devuelta a nuestros servidores o a los servidores de terceros relevantes durante una visita posterior.',
      'A script is a piece of program code that is used to make our website function properly and interactively. This code is executed on our server or on your device.' => 'Un script es un fragmento de código de programa que se utiliza para que nuestro sitio web funcione correctamente y de manera interactiva. Este código se ejecuta en nuestro servidor o en tu dispositivo.',
      'A web beacon (or a pixel tag) is a small, invisible piece of text or image on a website that is used to monitor traffic on a website. In order to do this, various data about you is stored using web beacons.' => 'Un web beacon (o etiqueta de píxel) es un pequeño fragmento de texto o imagen invisible en un sitio web que se utiliza para monitorear el tráfico. Para lograr esto, se almacenan diversos datos sobre ti mediante web beacons.',
      'Some cookies ensure that certain parts of the website work properly and that your user preferences remain known. By placing functional cookies, we make it easier for you to visit our website. This way, you do not need to repeatedly enter the same information when visiting our website and, for example, the items remain in your shopping cart until you have paid. We may place these cookies without your consent.' => 'Algunas cookies aseguran que ciertas partes del sitio web funcionen correctamente y que tus preferencias se mantengan. Al colocar cookies funcionales, facilitamos tu visita a nuestro sitio web. De esta manera, no necesitas ingresar repetidamente la misma información. Podemos colocar estas cookies sin tu consentimiento.',
      'We use statistics cookies to optimize the website experience for our users. With these statistics cookies we get insights in the usage of our website.' => 'Utilizamos cookies de estadísticas para optimizar la experiencia del sitio web para nuestros usuarios. Con estas cookies obtenemos información sobre el uso de nuestro sitio web.',
      'We ask your permission to place statistics cookies.' => 'Te pedimos tu permiso para colocar cookies de estadísticas.',
      'Because statistics are being tracked anonymously, no permission is asked to place statistics cookies.' => 'Dado que las estadísticas se rastrean de forma anónima, no se solicita permiso para colocar cookies de estadísticas.',
      'Marketing/Tracking cookies are cookies or any other form of local storage, used to create user profiles to display advertising or to track the user on this website or across several websites for similar marketing purposes.' => 'Las cookies de marketing/seguimiento son cookies o cualquier otra forma de almacenamiento local, utilizadas para crear perfiles de usuario con el fin de mostrar publicidad o rastrear al usuario en este sitio web o en varios sitios web con propósitos de marketing similares.',
      'Because these cookies are marked as tracking cookies, we ask your permission to place these.' => 'Dado que estas cookies están marcadas como cookies de seguimiento, te pedimos tu permiso para colocarlas.',
      'On our website, we have included content to promote web pages (e.g. "like", "pin") or share (e.g. "tweet") on social networks. This content is embedded with code derived from third parties and places cookies. This content might store and process certain information for personalized advertising.' => 'En nuestro sitio web, hemos incluido contenido para promover páginas web (ej. "me gusta", "pin") o compartir (ej. "tweet") en redes sociales. Este contenido está incrustado con código de terceros y coloca cookies. Este contenido puede almacenar y procesar cierta información para publicidad personalizada.',
      'You can use your internet browser to automatically or manually delete cookies. You can also specify that certain cookies may not be placed. Another option is to change the settings of your internet browser so that you receive a message each time a cookie is placed. For more information about these options, please refer to the instructions in the Help section of your browser.' => 'Puedes usar tu navegador de internet para eliminar cookies automática o manualmente. También puedes especificar que ciertas cookies no se coloquen. Otra opción es cambiar la configuración de tu navegador para recibir un mensaje cada vez que se coloque una cookie. Para más información sobre estas opciones, consulta las instrucciones en la sección de Ayuda de tu navegador.',
      'Please note that our website may not work properly if all cookies are disabled. If you do delete the cookies in your browser, they will be placed again after your consent when you visit our website again.' => 'Ten en cuenta que nuestro sitio web puede no funcionar correctamente si se desactivan todas las cookies. Si eliminas las cookies en tu navegador, se volverán a colocar después de tu consentimiento cuando visites nuestro sitio web nuevamente.',
      'You have the following rights with respect to your personal data:' => 'Tienes los siguientes derechos respecto a tus datos personales:',
      'You have the right to know why your personal data is needed, what will happen to it, and how long it will be retained for.' => 'Tienes derecho a saber por qué se necesitan tus datos personales, qué sucederá con ellos y por cuánto tiempo se conservarán.',
      'Right of access: You have the right to access your personal data that is known to us.' => 'Derecho de acceso: Tienes derecho a acceder a tus datos personales que tenemos.',
      'Right to rectification: you have the right to supplement, correct, have deleted or blocked your personal data whenever you wish.' => 'Derecho de rectificación: Tienes derecho a complementar, corregir, eliminar o bloquear tus datos personales cuando lo desees.',
      'If you give us your consent to process your data, you have the right to revoke that consent and to have your personal data deleted.' => 'Si nos das tu consentimiento para procesar tus datos, tienes derecho a revocar ese consentimiento y a que tus datos personales sean eliminados.',
      'Right to transfer your data: you have the right to request all your personal data from the controller and transfer it in its entirety to another controller.' => 'Derecho a la portabilidad de datos: Tienes derecho a solicitar todos tus datos personales al responsable del tratamiento y transferirlos en su totalidad a otro responsable.',
      'Right to object: you may object to the processing of your data. We comply with this, unless there are justified grounds for processing.' => 'Derecho de oposición: Puedes oponerte al procesamiento de tus datos. Cumpliremos con esto, a menos que existan motivos justificados para el procesamiento.',
      'To exercise these rights, please contact us. Please refer to the contact details at the bottom of this Cookie Policy. If you have a complaint about how we handle your data, we would like to hear from you, but you also have the right to submit a complaint to the supervisory authority (the Data Protection Authority).' => 'Para ejercer estos derechos, por favor contáctanos. Consulta los datos de contacto al final de esta Política de Cookies. Si tienes una queja sobre cómo manejamos tus datos, nos gustaría saberlo, pero también tienes derecho a presentar una queja ante la autoridad de supervisión (la Autoridad de Protección de Datos).',
      'Functional' => 'Funcional',
      'Marketing' => 'Marketing',
      'Statistics' => 'Estadísticas',
      'Preferences' => 'Preferencias',
      'Purpose pending investigation' => 'Propósito pendiente de investigación',
      'Consent to service' => 'Consentimiento al servicio',
    );
  }

  if ( isset( $translations[ $text ] ) ) {
    return $translations[ $text ];
  }

  return $translated;
}
add_filter( 'gettext', 'twentytwentyfive_child_complianz_translations', 10, 3 );
add_filter( 'gettext_with_context', function( $translated, $text, $context, $domain ) {
  return twentytwentyfive_child_complianz_translations( $translated, $text, $domain );
}, 10, 4 );

// ============================================================
// SEO MODULE — Meta tags, Schema JSON-LD, Sitemap, Local SEO
// ============================================================

/**
 * Force Spanish language attribute regardless of WP settings.
 */
add_filter( 'language_attributes', function( $output ) {
  return str_replace( 'lang="en-US"', 'lang="es-EC"', $output );
});

/**
 * Remove WordPress version meta tag for security.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Add SEO meta tags: title, description, canonical, Open Graph.
 */
function af_seo_meta_tags() {
  $site_name = 'Arriendo Fácil';
  $site_url  = home_url('/');
  $logo_url  = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-web-sq.png';

  if ( is_front_page() ) {
    $title       = 'Arriendo Fácil — Arriendos verificados en Quito y Ecuador';
    $description = 'Encuentra arriendos verificados en Quito y Ecuador. Apartamentos, casas y habitaciones con propietarios validados. Proceso rápido, precios claros y soporte 24/7.';
    $canonical   = $site_url;
  } elseif ( is_page('propiedades') ) {
    $title       = 'Propiedades en arriendo en Quito — Arriendo Fácil';
    $description = 'Explora propiedades verificadas en arriendo en Quito y Ecuador. Filtra por ubicación, precio y tipo. Todas inspeccionadas y con propietarios validados.';
    $canonical   = home_url('/propiedades/');
  } elseif ( is_page('contacto') ) {
    $title       = 'Contacto — Arriendo Fácil | Soporte 24/7 en Ecuador';
    $description = 'Contáctanos para resolver tus dudas sobre arriendo en Ecuador. Atención por WhatsApp, email y teléfono. Respuesta en menos de 24 horas.';
    $canonical   = home_url('/contacto/');
  } elseif ( is_page('search-results') ) {
    $title       = 'Buscar propiedades en arriendo — Arriendo Fácil';
    $description = 'Busca propiedades en arriendo por ubicación con mapa interactivo. Filtra por precio, tipo de propiedad y amenities en Quito y Ecuador.';
    $canonical   = home_url('/search-results/');
  } elseif ( is_page('registro-propietario') ) {
    $title       = 'Registrar propiedad — Arriendo Fácil para Propietarios';
    $description = 'Registra tu propiedad en Arriendo Fácil. Gestión profesional de arriendos en Ecuador con verificación, soporte legal y máxima ocupación.';
    $canonical   = home_url('/registro-propietario/');
  } elseif ( is_singular('accommodation') ) {
    $title       = get_the_title() . ' — Arriendo en ' . get_post_meta(get_the_ID(), '_af_address', true);
    $description = wp_trim_words( get_the_excerpt() ?: get_the_content(), 25, '...' );
    $description = $description ?: 'Propiedad verificada en arriendo en Ecuador. Ver detalles, fotos, ubicación y precio.';
    $canonical   = get_permalink();
  } else {
    $title       = get_the_title() . ' — Arriendo Fácil';
    $description = 'Arriendo Fácil: plataforma de arriendos verificados en Ecuador.';
    $canonical   = get_permalink() ?: $site_url;
  }

  $og_image = $logo_url;
  if ( is_singular() && has_post_thumbnail() ) {
    $og_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
  }

  echo "\n<!-- Arriendo Fácil SEO -->\n";
  echo '<title>' . esc_html($title) . "</title>\n";
  echo '<meta name="description" content="' . esc_attr($description) . "\">\n";
  echo '<link rel="canonical" href="' . esc_url($canonical) . "\">\n";
  echo '<meta property="og:type" content="website">' . "\n";
  echo '<meta property="og:title" content="' . esc_attr($title) . "\">\n";
  echo '<meta property="og:description" content="' . esc_attr($description) . "\">\n";
  echo '<meta property="og:url" content="' . esc_url($canonical) . "\">\n";
  echo '<meta property="og:image" content="' . esc_url($og_image) . "\">\n";
  echo '<meta property="og:site_name" content="' . esc_attr($site_name) . "\">\n";
  echo '<meta property="og:locale" content="es_EC">' . "\n";
  echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
  echo '<meta name="twitter:title" content="' . esc_attr($title) . "\">\n";
  echo '<meta name="twitter:description" content="' . esc_attr($description) . "\">\n";
  echo '<meta name="twitter:image" content="' . esc_url($og_image) . "\">\n";
  echo '<meta name="geo.region" content="EC-P">' . "\n";
  echo '<meta name="geo.placename" content="Quito">' . "\n";
  echo "<!-- /Arriendo Fácil SEO -->\n";
}
add_action( 'wp_head', 'af_seo_meta_tags', 1 );

/**
 * Remove default WP title tag since we handle it ourselves.
 */
remove_theme_support( 'title-tag' );
add_action( 'after_setup_theme', function() {
  remove_theme_support( 'title-tag' );
}, 99 );

/**
 * JSON-LD Schema: Organization + WebSite + SearchAction (sitewide).
 */
function af_schema_organization() {
  $schema = array(
    '@context' => 'https://schema.org',
    '@graph'   => array(
      array(
        '@type'       => 'Organization',
        '@id'         => home_url('/#organization'),
        'name'        => 'Arriendo Fácil',
        'url'         => home_url('/'),
        'logo'        => array(
          '@type'      => 'ImageObject',
          'url'        => get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-web-sq.png',
          'width'      => 512,
          'height'     => 512,
        ),
        'contactPoint' => array(
          '@type'            => 'ContactPoint',
          'telephone'        => '+593-99-123-4567',
          'contactType'      => 'customer service',
          'availableLanguage' => 'Spanish',
          'areaServed'       => 'EC',
        ),
        'sameAs' => array(
          'https://www.facebook.com/profile.php?id=61590015435478',
          'https://www.instagram.com/arriendofacilnet/',
        ),
        'address' => array(
          '@type'           => 'PostalAddress',
          'addressLocality' => 'Quito',
          'addressRegion'   => 'Pichincha',
          'addressCountry'  => 'EC',
        ),
      ),
      array(
        '@type'          => 'WebSite',
        '@id'            => home_url('/#website'),
        'name'           => 'Arriendo Fácil',
        'url'            => home_url('/'),
        'publisher'      => array( '@id' => home_url('/#organization') ),
        'inLanguage'     => 'es',
        'potentialAction' => array(
          '@type'       => 'SearchAction',
          'target'      => array(
            '@type'        => 'EntryPoint',
            'urlTemplate'  => home_url('/propiedades/?location={search_term_string}'),
          ),
          'query-input' => 'required name=search_term_string',
        ),
      ),
    ),
  );

  echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
}
add_action( 'wp_head', 'af_schema_organization', 2 );

/**
 * JSON-LD Schema: RealEstateAgent (homepage and contact page).
 */
function af_schema_local_business() {
  if ( ! is_front_page() && ! is_page('contacto') ) {
    return;
  }

  $schema = array(
    '@context' => 'https://schema.org',
    '@type'    => 'RealEstateAgent',
    '@id'      => home_url('/#business'),
    'name'     => 'Arriendo Fácil',
    'url'      => home_url('/'),
    'image'    => get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-web-sq.png',
    'telephone' => '+593-99-123-4567',
    'email'    => 'contacto@arriendofacil.com',
    'address'  => array(
      '@type'           => 'PostalAddress',
      'addressLocality' => 'Quito',
      'addressRegion'   => 'Pichincha',
      'addressCountry'  => 'EC',
    ),
    'geo' => array(
      '@type'     => 'GeoCoordinates',
      'latitude'  => -0.18065,
      'longitude' => -78.46784,
    ),
    'areaServed' => array(
      array( '@type' => 'City', 'name' => 'Quito' ),
      array( '@type' => 'City', 'name' => 'Guayaquil' ),
      array( '@type' => 'City', 'name' => 'Cuenca' ),
    ),
    'openingHoursSpecification' => array(
      '@type'     => 'OpeningHoursSpecification',
      'dayOfWeek' => array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
      'opens'     => '00:00',
      'closes'    => '23:59',
    ),
    'priceRange'     => '$$',
    'currenciesAccepted' => 'USD',
    'paymentAccepted'    => 'Cash, Credit Card, Bank Transfer',
  );

  echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
}
add_action( 'wp_head', 'af_schema_local_business', 3 );

/**
 * JSON-LD Schema: RealEstateListing for individual property pages.
 */
function af_schema_property_listing() {
  if ( ! is_singular('accommodation') ) {
    return;
  }

  $post_id       = get_the_ID();
  $title         = get_the_title();
  $description   = wp_trim_words( get_the_content(), 50, '...' );
  $address       = get_post_meta($post_id, '_af_address', true);
  $monthly_rent  = floatval(get_post_meta($post_id, '_af_monthly_rent', true));
  $latitude      = floatval(get_post_meta($post_id, '_af_latitude', true));
  $longitude     = floatval(get_post_meta($post_id, '_af_longitude', true));
  $bedrooms      = (int) get_post_meta($post_id, '_af_bedrooms', true);
  $bathrooms     = (int) get_post_meta($post_id, '_af_bathrooms', true);
  $square_meters = floatval(get_post_meta($post_id, '_af_square_meters', true));
  $property_type = get_post_meta($post_id, '_af_property_type', true);
  $amenities     = get_post_meta($post_id, '_af_amenities', true);

  $thumb_id = get_post_thumbnail_id($post_id);
  $image    = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : '';

  $type_map = array(
    'apartamento' => 'Apartment',
    'casa'        => 'SingleFamilyResidence',
    'habitacion'  => 'Room',
    'estudio'     => 'Apartment',
  );
  $schema_type = isset($type_map[$property_type]) ? $type_map[$property_type] : 'Accommodation';

  $schema = array(
    '@context'    => 'https://schema.org',
    '@type'       => array('RealEstateListing', $schema_type),
    '@id'         => get_permalink() . '#listing',
    'name'        => $title,
    'description' => $description,
    'url'         => get_permalink(),
    'datePosted'  => get_the_date('c'),
  );

  if ( $image ) {
    $schema['image'] = $image;
  }

  if ( $address ) {
    $schema['address'] = array(
      '@type'           => 'PostalAddress',
      'streetAddress'   => $address,
      'addressLocality' => 'Quito',
      'addressRegion'   => 'Pichincha',
      'addressCountry'  => 'EC',
    );
  }

  if ( $latitude && $longitude ) {
    $schema['geo'] = array(
      '@type'     => 'GeoCoordinates',
      'latitude'  => $latitude,
      'longitude' => $longitude,
    );
  }

  if ( $monthly_rent > 0 ) {
    $schema['offers'] = array(
      '@type'         => 'Offer',
      'price'         => $monthly_rent,
      'priceCurrency' => 'USD',
      'availability'  => 'https://schema.org/InStock',
      'priceValidUntil' => date('Y-12-31'),
    );
  }

  if ( $bedrooms > 0 ) {
    $schema['numberOfBedrooms'] = $bedrooms;
  }
  if ( $bathrooms > 0 ) {
    $schema['numberOfBathroomsTotal'] = $bathrooms;
  }
  if ( $square_meters > 0 ) {
    $schema['floorSize'] = array(
      '@type'    => 'QuantitativeValue',
      'value'    => $square_meters,
      'unitCode' => 'MTK',
    );
  }
  if ( is_array($amenities) && ! empty($amenities) ) {
    $schema['amenityFeature'] = array_map(function($a) {
      return array( '@type' => 'LocationFeatureSpecification', 'name' => $a, 'value' => true );
    }, $amenities);
  }

  echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
}
add_action( 'wp_head', 'af_schema_property_listing', 4 );

/**
 * JSON-LD Schema: BreadcrumbList for inner pages.
 */
function af_schema_breadcrumbs() {
  if ( is_front_page() ) {
    return;
  }

  $items = array(
    array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => home_url('/') ),
  );

  if ( is_page('propiedades') ) {
    $items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Propiedades' );
  } elseif ( is_page('contacto') ) {
    $items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Contacto' );
  } elseif ( is_singular('accommodation') ) {
    $items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Propiedades', 'item' => home_url('/propiedades/') );
    $items[] = array( '@type' => 'ListItem', 'position' => 3, 'name' => get_the_title() );
  } else {
    $items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => get_the_title() );
  }

  $schema = array(
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => $items,
  );

  echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
}
add_action( 'wp_head', 'af_schema_breadcrumbs', 5 );

/**
 * Register custom XML sitemap provider for accommodations.
 */
function af_register_sitemap_provider() {
  $provider = new AF_Accommodation_Sitemap_Provider();
  wp_register_sitemap_provider( 'af-accommodations', $provider );
}
add_action( 'init', 'af_register_sitemap_provider' );

class AF_Accommodation_Sitemap_Provider extends WP_Sitemaps_Provider {
  public function __construct() {
    $this->name        = 'af-accommodations';
    $this->object_type = 'accommodation';
  }

  public function get_url_list( $page_num, $object_subtype = '' ) {
    $args = array(
      'post_type'      => 'accommodation',
      'post_status'    => 'publish',
      'posts_per_page' => 2000,
      'paged'          => $page_num,
      'orderby'        => 'modified',
      'order'          => 'DESC',
      'fields'         => 'ids',
    );

    $query = new WP_Query($args);
    $urls  = array();

    foreach ( $query->posts as $post_id ) {
      $urls[] = array(
        'loc'     => get_permalink($post_id),
        'lastmod' => get_post_modified_time('Y-m-d\TH:i:sP', true, $post_id),
      );
    }

    return $urls;
  }

  public function get_max_num_pages( $object_subtype = '' ) {
    $count = wp_count_posts('accommodation');
    $total = $count->publish ?? 0;
    return (int) ceil( $total / 2000 );
  }
}

/**
 * Add static pages to the WordPress sitemap with higher priority.
 */
function af_sitemap_add_static_pages( $url_list, $post_type, $page_num ) {
  if ( $post_type !== 'page' || $page_num !== 1 ) {
    return $url_list;
  }

  $priority_pages = array('propiedades', 'contacto', 'search-results', 'registro-propietario');
  foreach ( $priority_pages as $slug ) {
    $page = get_page_by_path($slug);
    if ( $page ) {
      $url_list[] = array(
        'loc'     => get_permalink($page->ID),
        'lastmod' => get_post_modified_time('Y-m-d\TH:i:sP', true, $page->ID),
      );
    }
  }

  return $url_list;
}
add_filter( 'wp_sitemaps_posts_url_list', 'af_sitemap_add_static_pages', 10, 3 );

/**
 * Serve robots.txt with AI crawler rules.
 */
function af_custom_robots_txt( $output, $public ) {
  $output  = "User-agent: *\n";
  $output .= "Disallow: /wp-admin/\n";
  $output .= "Allow: /wp-admin/admin-ajax.php\n\n";

  $output .= "# AI Search Crawlers — Allow\n";
  $output .= "User-agent: GPTBot\nAllow: /\n\n";
  $output .= "User-agent: OAI-SearchBot\nAllow: /\n\n";
  $output .= "User-agent: ClaudeBot\nAllow: /\n\n";
  $output .= "User-agent: PerplexityBot\nAllow: /\n\n";
  $output .= "User-agent: Google-Extended\nAllow: /\n\n";

  $output .= "# Training Crawlers — Block\n";
  $output .= "User-agent: CCBot\nDisallow: /\n\n";
  $output .= "User-agent: anthropic-ai\nDisallow: /\n\n";

  $output .= "Sitemap: " . home_url('/wp-sitemap.xml') . "\n";

  return $output;
}
add_filter( 'robots_txt', 'af_custom_robots_txt', 10, 2 );

/**
 * Serve llms.txt at /llms.txt for AI engines.
 */
function af_serve_llms_txt() {
  add_rewrite_rule( '^llms\.txt$', 'index.php?af_llms_txt=1', 'top' );
}
add_action( 'init', 'af_serve_llms_txt' );

function af_llms_txt_query_var( $vars ) {
  $vars[] = 'af_llms_txt';
  return $vars;
}
add_filter( 'query_vars', 'af_llms_txt_query_var' );

function af_llms_txt_template_redirect() {
  if ( ! get_query_var('af_llms_txt') ) {
    return;
  }

  header( 'Content-Type: text/plain; charset=utf-8' );
  header( 'Cache-Control: public, max-age=86400' );

  echo "# Arriendo Fácil\n\n";
  echo "> Arriendo Fácil es una plataforma de arrendamiento verificado en Ecuador, con sede en Quito.\n";
  echo "> Conecta arrendatarios con propiedades residenciales verificadas en ciudades ecuatorianas.\n";
  echo "> Fundada para simplificar el proceso de arrendamiento con seguridad, transparencia y soporte 24/7.\n\n";
  echo "## Páginas principales\n\n";
  echo "- [Inicio](" . home_url('/') . "): Descripción general del servicio de arriendo verificado\n";
  echo "- [Propiedades](" . home_url('/propiedades/') . "): Catálogo de propiedades disponibles en arriendo\n";
  echo "- [Búsqueda con mapa](" . home_url('/search-results/') . "): Búsqueda por ubicación con mapa interactivo\n";
  echo "- [Contacto](" . home_url('/contacto/') . "): Información de contacto y soporte al cliente\n";
  echo "- [Registro de propietario](" . home_url('/registro-propietario/') . "): Registro para propietarios\n\n";
  echo "## Servicios\n\n";
  echo "- Búsqueda y filtrado de propiedades por ubicación, precio y tipo en Ecuador\n";
  echo "- Verificación de propiedades e inspección de seguridad\n";
  echo "- Gestión de contratos de arrendamiento\n";
  echo "- Soporte al arrendatario y mediación en conflictos\n";
  echo "- Asesoría legal en contratación de arriendo\n\n";
  echo "## Contacto\n\n";
  echo "- Email: contacto@arriendofacil.com\n";
  echo "- Teléfono: +593 99 123 4567\n";
  echo "- Ubicación: Quito, Pichincha, Ecuador\n";
  exit;
}
add_action( 'template_redirect', 'af_llms_txt_template_redirect' );