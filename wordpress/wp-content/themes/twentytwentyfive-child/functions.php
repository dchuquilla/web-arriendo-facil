<?php
/**
 * Theme functions for Mi Tema Child - Hospedajes
 */

if ( ! defined('ABSPATH') ) { exit; }

define('AF_THEME_VERSION', '2.0.4');

function twentytwentyfive_child_asset_version( $relative_path ) {
  $absolute_path = get_stylesheet_directory() . '/' . ltrim( $relative_path, '/' );
  return file_exists( $absolute_path ) ? (string) filemtime( $absolute_path ) : AF_THEME_VERSION;
}

function twentytwentyfive_child_should_load_reservation_modal() {
  return is_page( 'propiedades' ) || is_page( 'search-results' ) || is_singular( 'accommodation' );
}

function twentytwentyfive_child_validate_property_type($value) {
  $allowed = ['apartment', 'house', 'room', 'studio'];
  return in_array($value, $allowed, true) ? $value : '';
}

/**
 * Enqueue parent + child styles and child scripts.
 */
function twentytwentyfive_child_enqueue_assets() {
  $parent_style_handle = 'parent-style';
  $child_style_ver = twentytwentyfive_child_asset_version( 'style.css' );
  $tokens_style_ver = twentytwentyfive_child_asset_version( 'design-tokens.css' );

  // Parent style (si el padre lo expone por style.css)
  wp_enqueue_style(
    $parent_style_handle,
    get_template_directory_uri() . '/style.css',
    array(),
    wp_get_theme(get_template())->get('Version')
  );

  // Child style (con cache busting basado en modificación del archivo)
  // Usar versión minificada en production, original en desarrollo
  $style_file = defined('WP_DEBUG') && WP_DEBUG ? 'style.css' : 'style.min.css';
  wp_enqueue_style(
    'twentytwentyfive-child-style',
    get_stylesheet_directory_uri() . '/' . $style_file,
    array($parent_style_handle, 'twentytwentyfive-child-tokens'),
    $child_style_ver
  );

  // Design tokens (loaded separately to avoid @import blocking chain)
  wp_enqueue_style(
    'twentytwentyfive-child-tokens',
    get_stylesheet_directory_uri() . '/design-tokens.css',
    array($parent_style_handle),
    $tokens_style_ver
  );

  // Lightbox para bloques de galería (load only when singular content is likely to need it).
  if ( is_singular() ) {
    wp_enqueue_script(
      'twentytwentyfive-child-gallery-lightbox',
      get_stylesheet_directory_uri() . '/assets/js/gallery-lightbox.js',
      array(),
      wp_get_theme()->get('Version'),
      true
    );
  }

  // Form normalize styles + JS (global – applies to all pages with data-normalize inputs)
  wp_enqueue_style(
    'twentytwentyfive-child-form-normalize',
    get_stylesheet_directory_uri() . '/assets/css/form-normalize.css',
    array( 'twentytwentyfive-child-style' ),
    twentytwentyfive_child_asset_version( 'assets/css/form-normalize.css' )
  );

  wp_enqueue_script(
    'twentytwentyfive-child-input-normalizer',
    get_stylesheet_directory_uri() . '/assets/js/input-normalizer.js',
    array(),
    twentytwentyfive_child_asset_version( 'assets/js/input-normalizer.js' ),
    true
  );

  // Search bar (global)
  wp_enqueue_script(
    'twentytwentyfive-child-search-bar',
    get_stylesheet_directory_uri() . '/assets/js/search-bar.js',
    array(),
    AF_THEME_VERSION,
    true
  );

  wp_enqueue_script(
    'twentytwentyfive-child-theme-ui',
    get_stylesheet_directory_uri() . '/assets/js/theme-ui.js',
    array(),
    AF_THEME_VERSION,
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
    AF_THEME_VERSION,
    true
  );

  // Quick reservation modal (only where reserve triggers exist).
  if ( twentytwentyfive_child_should_load_reservation_modal() ) {
    $occupied_style_deps = array( 'twentytwentyfive-child-style' );

    // Occupied-state overlay/badge styles are registered by the plugin.
    if ( wp_style_is( 'af-occupied-badge-style', 'registered' ) ) {
      wp_enqueue_style( 'af-occupied-badge-style' );
      $occupied_style_deps[] = 'af-occupied-badge-style';
    }

    wp_enqueue_style(
      'twentytwentyfive-child-occupied-ui',
      get_stylesheet_directory_uri() . '/assets/css/occupied-ui.css',
      $occupied_style_deps,
      twentytwentyfive_child_asset_version( 'assets/css/occupied-ui.css' )
    );

    wp_enqueue_style(
      'twentytwentyfive-child-reservation-modal',
      get_stylesheet_directory_uri() . '/assets/css/reservation-modal.css',
      array( 'twentytwentyfive-child-style' ),
      twentytwentyfive_child_asset_version( 'assets/css/reservation-modal.css' )
    );

    wp_enqueue_script(
      'twentytwentyfive-child-reservation-intent',
      get_stylesheet_directory_uri() . '/assets/js/reservation-intent.js',
      array(),
      AF_THEME_VERSION,
      true
    );

    wp_localize_script( 'twentytwentyfive-child-reservation-intent', 'afReservationIntent', array(
      'ajaxUrl' => admin_url( 'admin-ajax.php' ),
      'nonce'   => wp_create_nonce( 'af_guest_frontend_nonce' ),
      'i18n'    => array(
        'title'    => __( 'Reserva tu visita', 'twentytwentyfive-child' ),
        'subtitle' => __( 'Comparte tus datos para continuar.', 'twentytwentyfive-child' ),
        'required' => __( 'Nombre y correo son obligatorios.', 'twentytwentyfive-child' ),
        'sending'  => __( 'Enviando...', 'twentytwentyfive-child' ),
        'submit'   => __( 'Confirmar reserva', 'twentytwentyfive-child' ),
        'success'  => __( 'Solicitud registrada correctamente.', 'twentytwentyfive-child' ),
        'conflict' => __( 'El horario ya no está disponible. Elige otro o envía una solicitud sin horario.', 'twentytwentyfive-child' ),
        'occupiedBlocked' => __( 'Esta acomodación está ocupada. No se pueden enviar solicitudes en este momento.', 'twentytwentyfive-child' ),
        'network'  => __( 'Error de red. Intenta nuevamente.', 'twentytwentyfive-child' ),
        'error'    => __( 'No se pudo registrar tu reserva.', 'twentytwentyfive-child' ),
      ),
    ) );
  }

  // JS para el carrusel solo en homepage
  if ( is_front_page() ) {
    wp_enqueue_script(
      'twentytwentyfive-child-home',
      get_stylesheet_directory_uri() . '/assets/js/home.js',
      array(),
      AF_THEME_VERSION,
      true
    );

    wp_enqueue_script(
      'twentytwentyfive-child-hero-search',
      get_stylesheet_directory_uri() . '/assets/js/hero-search.js',
      array(),
      twentytwentyfive_child_asset_version( 'assets/js/hero-search.js' ),
      true
    );

    wp_enqueue_script(
      'twentytwentyfive-child-referral',
      get_stylesheet_directory_uri() . '/assets/js/referral.js',
      array(),
      AF_THEME_VERSION,
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
      AF_THEME_VERSION,
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

    if ( is_page('search-results') ) {
      wp_enqueue_style(
        'leaflet-markercluster-css',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.css',
        array('leaflet-css'),
        '1.5.3'
      );

      wp_enqueue_style(
        'leaflet-markercluster-default-css',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.Default.css',
        array('leaflet-markercluster-css'),
        '1.5.3'
      );

      wp_enqueue_script(
        'leaflet-markercluster-js',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.min.js',
        array('leaflet-js'),
        '1.5.3',
        true
      );
    }

    wp_enqueue_style(
      'twentytwentyfive-child-search-results',
      get_stylesheet_directory_uri() . '/assets/css/search-results.css',
      array( 'twentytwentyfive-child-style' ),
      AF_THEME_VERSION
    );

    wp_enqueue_script(
      'twentytwentyfive-child-search-results',
      get_stylesheet_directory_uri() . '/assets/js/search-results-interactive.js',
      is_page('search-results') ? array( 'leaflet-js', 'leaflet-markercluster-js' ) : array( 'leaflet-js' ),
      twentytwentyfive_child_asset_version( 'assets/js/search-results-interactive.js' ),
      true
    );

    wp_localize_script(
      'twentytwentyfive-child-search-results',
      'afSearchResultsI18n',
      array(
        'viewDetails' => __( 'Ver detalles', 'twentytwentyfive-child' ),
        'reserve' => __( 'Reservar', 'twentytwentyfive-child' ),
        'occupiedUnavailable' => __( 'NO DISPONIBLE - OCUPADA', 'twentytwentyfive-child' ),
      )
    );
  }

  // Owner registration wizard
  if ( is_page( 'registro-propietario' ) ) {
    wp_enqueue_script(
      'twentytwentyfive-child-owner-registration',
      get_stylesheet_directory_uri() . '/assets/js/owner-registration.js',
      array(),
      AF_THEME_VERSION,
      true
    );

    wp_localize_script('twentytwentyfive-child-owner-registration', 'afOwnerRegister', array(
      'endpoint'  => esc_url_raw( rest_url( 'af/v1/owner-register' ) ),
      'nonce'     => wp_create_nonce( 'af_owner_register' ),
      'restNonce' => wp_create_nonce( 'wp_rest' ),
    ));
  }

  // Legal onboarding page (public, accessed via secure token link)
  if ( is_page( 'completar-perfil-arriendo' ) ) {
    $legal_onboarding_js_path = get_stylesheet_directory() . '/assets/js/legal-onboarding.js';
    $legal_onboarding_js_ver  = file_exists( $legal_onboarding_js_path ) ? (string) filemtime( $legal_onboarding_js_path ) : AF_THEME_VERSION;

    wp_enqueue_style(
      'twentytwentyfive-child-legal-onboarding',
      get_stylesheet_directory_uri() . '/assets/css/legal-onboarding.css',
      array( 'twentytwentyfive-child-style' ),
      AF_THEME_VERSION
    );

    wp_enqueue_script(
      'twentytwentyfive-child-legal-onboarding',
      get_stylesheet_directory_uri() . '/assets/js/legal-onboarding.js',
      array(),
      $legal_onboarding_js_ver,
      true
    );

    wp_localize_script( 'twentytwentyfive-child-legal-onboarding', 'afGuestProfile', array(
      'ajaxUrl' => admin_url( 'admin-ajax.php' ),
      'i18n'    => array(
        'sending'           => __( 'Enviando...', 'twentytwentyfive-child' ),
        'sendingStep1'      => __( 'Enviando datos...', 'twentytwentyfive-child' ),
        'sendingStep2'      => __( 'Estamos generando tu contrato, esto puede tardar unos minutos.', 'twentytwentyfive-child' ),
        'submit'            => __( 'Enviar perfil legal', 'twentytwentyfive-child' ),
        'cancel'            => __( 'Cancelar envio', 'twentytwentyfive-child' ),
        'validatingLink'    => __( 'Validando enlace seguro...', 'twentytwentyfive-child' ),
        'timeout'           => __( 'La solicitud tardo demasiado, intentalo nuevamente.', 'twentytwentyfive-child' ),
        'manualCancel'      => __( 'Cancelaste el envio. Puedes revisar tus datos y volver a intentarlo.', 'twentytwentyfive-child' ),
        'networkError'      => __( 'Error de red al enviar el perfil legal.', 'twentytwentyfive-child' ),
        'error400'          => __( 'Revisa los datos ingresados e intenta nuevamente.', 'twentytwentyfive-child' ),
        'error403'          => __( 'Tu sesion expiro, recarga la pagina.', 'twentytwentyfive-child' ),
        'error413'          => __( 'Los archivos son demasiado grandes. Reduce su tamano e intenta nuevamente.', 'twentytwentyfive-child' ),
        'error500'          => __( 'Tuvimos un problema en el servidor. Intentalo nuevamente.', 'twentytwentyfive-child' ),
        'errorGeneric'      => __( 'No se pudo completar la solicitud en este momento.', 'twentytwentyfive-child' ),
        'success'           => __( 'Perfil legal enviado correctamente.', 'twentytwentyfive-child' ),
        'contractGenerated' => __( 'Contrato generado correctamente.', 'twentytwentyfive-child' ),
      ),
    ) );
  }
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_assets', 20);

/**
 * Adds defer/async attributes to non-critical scripts.
 */
function twentytwentyfive_child_optimize_script_loading( $tag, $handle, $src ) {
  $defer_handles = array(
    'twentytwentyfive-child-search-bar',
    'twentytwentyfive-child-theme-ui',
    'twentytwentyfive-child-nav-prefetch',
    'twentytwentyfive-child-cookie-wall',
    'twentytwentyfive-child-home',
    'twentytwentyfive-child-referral',
    'twentytwentyfive-child-propiedades',
    'twentytwentyfive-child-owner-registration',
    'twentytwentyfive-child-gallery-lightbox',
    'twentytwentyfive-child-single-carousel',
    'af-chatbot-frontend',
  );

  $async_handles = array(
    'twentytwentyfive-child-sw-register',
  );

  if ( in_array( $handle, $defer_handles, true ) ) {
    return '<script src="' . esc_url( $src ) . '" defer></script>' . "\n";
  }

  if ( in_array( $handle, $async_handles, true ) ) {
    return '<script src="' . esc_url( $src ) . '" async></script>' . "\n";
  }

  return $tag;
}
add_filter( 'script_loader_tag', 'twentytwentyfive_child_optimize_script_loading', 10, 3 );

/**
 * Print the global quick-reservation modal once per request.
 * Kept in the footer so all triggers across the site can open it.
 */
function twentytwentyfive_child_print_reservation_modal() {
  static $printed = false;
  if ( $printed || ! twentytwentyfive_child_should_load_reservation_modal() ) {
    return;
  }
  $printed = true;
  ?>
  <div id="af-reservation-modal" class="af-reservation-modal" aria-hidden="true">
    <div class="af-reservation-modal__backdrop" data-af-reserve-close></div>
    <div class="af-reservation-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="af-reservation-modal-title" aria-describedby="af-reservation-modal-subtitle">
      <button type="button" class="af-reservation-modal__close" data-af-reserve-close aria-label="<?php esc_attr_e( 'Cerrar', 'twentytwentyfive-child' ); ?>">&times;</button>
      <div class="af-reservation-modal__header">
        <p class="af-reservation-modal__eyebrow"><?php esc_html_e( 'Paso 1 de 2', 'twentytwentyfive-child' ); ?></p>
        <h2 id="af-reservation-modal-title"><?php esc_html_e( 'Reserva tu visita', 'twentytwentyfive-child' ); ?></h2>
        <p id="af-reservation-modal-accommodation" class="af-reservation-modal__accommodation"><?php esc_html_e( 'Alojamiento: -', 'twentytwentyfive-child' ); ?></p>
        <p id="af-reservation-modal-subtitle" class="af-reservation-modal__subtitle"><?php esc_html_e( 'Completa solo los datos esenciales.', 'twentytwentyfive-child' ); ?></p>
      </div>

      <form id="af-reservation-form" class="af-reservation-modal__form" novalidate>
        <input type="hidden" id="af-reservation-accommodation-id" name="accommodation_id" value="">
        <input type="hidden" id="af-reservation-slot-id" name="slot_id" value="">

        <div class="af-reservation-modal__field">
          <label for="af-res-guest-name"><?php esc_html_e( 'Nombre', 'twentytwentyfive-child' ); ?> *</label>
          <input type="text" id="af-res-guest-name" name="guest_name" required autocomplete="name"
            data-normalize="name">
        </div>
        <div class="af-reservation-modal__field">
          <label for="af-res-guest-email"><?php esc_html_e( 'Correo', 'twentytwentyfive-child' ); ?> *</label>
          <input type="email" id="af-res-guest-email" name="guest_email" required autocomplete="email"
            data-normalize="email">
        </div>
        <div class="af-reservation-modal__field">
          <label for="af-res-guest-phone"><?php esc_html_e( 'Teléfono (recomendado)', 'twentytwentyfive-child' ); ?></label>
          <input type="tel" id="af-res-guest-phone" name="guest_phone" inputmode="tel" autocomplete="tel">
        </div>

        <details class="af-reservation-modal__optional">
          <summary><?php esc_html_e( '¿No tienes horario? Agrega preferencia', 'twentytwentyfive-child' ); ?></summary>
          <div class="af-reservation-modal__optional-grid">
            <div class="af-reservation-modal__field">
              <label for="af-res-preferred-date"><?php esc_html_e( 'Fecha preferida', 'twentytwentyfive-child' ); ?></label>
              <input type="date" id="af-res-preferred-date" name="preferred_date">
            </div>
            <div class="af-reservation-modal__field">
              <label for="af-res-preferred-time"><?php esc_html_e( 'Hora preferida', 'twentytwentyfive-child' ); ?></label>
              <input type="time" id="af-res-preferred-time" name="preferred_time">
            </div>
          </div>
        </details>

        <p id="af-reservation-status" class="af-reservation-status" hidden></p>

        <button id="af-reservation-submit" type="submit" class="btn btn--primary btn--full">
          <?php esc_html_e( 'Confirmar reserva', 'twentytwentyfive-child' ); ?>
        </button>

        <p class="af-reservation-modal__footnote">
          <?php esc_html_e( 'Tu información se usa solo para coordinar la visita y el onboarding legal posterior.', 'twentytwentyfive-child' ); ?>
        </p>
      </form>
    </div>
  </div>
  <?php
}
add_action( 'wp_footer', 'twentytwentyfive_child_print_reservation_modal', 40 );

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

  if (!$post) {
    return [];
  }

  // Primero: leer galería desde meta _af_gallery (backend wizard)
  $gallery_ids = get_post_meta($post_id, '_af_gallery', true);
  if (is_array($gallery_ids) && !empty($gallery_ids)) {
    foreach ($gallery_ids as $attachment_id) {
      $attachment_id = absint($attachment_id);
      if (!$attachment_id) {
        continue;
      }

      $full_url  = wp_get_attachment_image_src($attachment_id, 'af-banner');
      $thumb_url = wp_get_attachment_image_src($attachment_id, 'af-thumbnail');

      if ($full_url && $thumb_url) {
        $images[] = [
          'id'        => $attachment_id,
          'url'       => $full_url[0],
          'url_small' => $thumb_url[0],
          'alt'       => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
        ];
      }
    }

    if (!empty($images)) {
      return $images;
    }
  }

  if (!$post->post_content) {
    // Continuar al fallback de attachments abajo
    $post->post_content = '';
  }

  // Segundo: intentar extraer imágenes de bloque de galería WP
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
    twentytwentyfive_child_asset_version( 'assets/js/single.js' ),
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
 * Rental workflow on single pages is intentionally disabled.
 * All booking/queue process now runs through the chatbot flow only.
 */

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
 * Add native lazy-loading to images (except LCP candidates)
 */
function twentytwentyfive_child_add_lazy_loading( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
  // Skip if already has loading attribute
  if ( strpos( $html, 'loading=' ) !== false ) {
    return $html;
  }

  // Don't lazy-load if this is LCP candidate (first featured image on single page)
  if ( is_singular( 'accommodation' ) && $post_id === get_the_ID() && $post_thumbnail_id ) {
    if ( get_post_thumbnail_id( get_the_ID() ) === $post_thumbnail_id ) {
      return $html;
    }
  }

  // Add loading="lazy"
  $html = str_replace( '<img ', '<img loading="lazy" ', $html );
  return $html;
}
add_filter( 'wp_get_attachment_image', 'twentytwentyfive_child_add_lazy_loading', 10, 5 );

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
 * Agregar cache headers optimizados para mejor rendimiento
 */
function twentytwentyfive_child_add_cache_headers() {
  if (is_user_logged_in()) {
    return;
  }

  if (is_front_page()) {
    header('Cache-Control: public, max-age=86400, s-maxage=86400, stale-while-revalidate=259200');
  } elseif (is_page('search-results')) {
    header('Cache-Control: public, max-age=300, s-maxage=300, stale-while-revalidate=600');
  } elseif (is_page('propiedades')) {
    header('Cache-Control: public, max-age=300, s-maxage=300, stale-while-revalidate=600');
  } elseif (is_singular('accommodation')) {
    header('Cache-Control: public, max-age=86400, s-maxage=86400, stale-while-revalidate=259200');
  } else {
    header('Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=86400');
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
  if ( is_admin() || is_search() || is_404() ) {
    return;
  }

  $site_name = 'Arriendo Fácil';
  $site_url  = home_url('/');
  $logo_url  = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-web-sq.png';

  if ( is_front_page() ) {
    $title       = 'Arriendo Fácil — Hospedajes verificados para ti';
    $description = 'Encuentra arriendos verificados en Quito y Ecuador. Apartamentos, casas y habitaciones con propietarios validados. Proceso rápido, precios claros y soporte 24/7.';
    $canonical   = $site_url;
  } elseif ( is_page('propiedades') ) {
    $title       = 'Propiedades en arriendo en Quito — Arriendo Fácil';
    $description = 'Explora propiedades verificadas en arriendo en Quito y Ecuador. Filtra por ubicación, precio y tipo. Todas inspeccionadas y con propietarios validados.';
    $canonical   = home_url('/propiedades/');
  } elseif ( is_page('contacto') ) {
    $title       = 'Contacto — Arriendo Fácil | Soporte 24/7 en Ecuador';
    $description = 'Contáctanos para resolver tus dudas sobre arriendo en Ecuador. Atención por email y respuesta en menos de 24 horas.';
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
          'email'            => 'arriendofacilnet@gmail.com',
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
    'email'    => 'arriendofacilnet@gmail.com',
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
  echo "- Email: arriendofacilnet@gmail.com\n";
  echo "- Ubicación: Quito, Pichincha, Ecuador\n";
  exit;
}
add_action( 'template_redirect', 'af_llms_txt_template_redirect' );