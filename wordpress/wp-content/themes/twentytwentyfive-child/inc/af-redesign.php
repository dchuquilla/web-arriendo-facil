<?php
/**
 * Rediseño ArriendoFácil (Figma aprobado): iconos, assets, body class y páginas.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Devuelve un SVG inline (trazo) del set de iconos del rediseño.
 */
function afx_icon( $name, $size = 20, $class = '' ) {
  static $paths = null;

  if ( null === $paths ) {
    $paths = array(
      'arrow'      => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
      'bolt'       => '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
      'home'       => '<path d="M3 9.5 12 2l9 7.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
      'user-plus'  => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/>',
      'growth'     => '<path d="M4 21V12"/><path d="M9 21v-6"/><path d="M14 21v-9"/><path d="M19 21V9"/><path d="m3 8 5-5 4 3 8-5"/><path d="M15 1h5v5"/>',
      'hex'        => '<path d="M12 2.5 20 7v10l-8 4.5L4 17V7z"/><circle cx="12" cy="12" r="3"/>',
      'wrench'     => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94z"/>',
      'file'       => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/>',
      'file-down'  => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/>',
      'bell'       => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
      'clock'      => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
      'mail'       => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
      'pin'        => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
      'check'      => '<path d="M20 6 9 17l-5-5"/>',
      'plus'       => '<path d="M12 5v14"/><path d="M5 12h14"/>',
      'play'       => '<path d="M7 4.5v15l12-7.5z"/>',
      'crown'      => '<path d="m2 6 4.5 5L12 4l5.5 7L22 6l-2 13H4z"/>',
      'rocket'     => '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>',
      'chevron'    => '<path d="m6 9 6 6 6-6"/>',
      'chevron-r'  => '<path d="m9 18 6-6-6-6"/>',
      'building'   => '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>',
    );
  }

  if ( ! isset( $paths[ $name ] ) ) {
    return '';
  }

  return sprintf(
    '<svg class="afx-icon%s" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>',
    $class ? ' ' . esc_attr( $class ) : '',
    (int) $size,
    (int) $size,
    $paths[ $name ] // phpcs:ignore WordPress.Security.EscapeOutput -- constantes internas.
  );
}

/**
 * Ondas decorativas (verde / salvia / azul mar) de las cabeceras del diseño.
 */
function afx_waves( $variant = 'sub' ) {
  $class = 'afx-waves afx-waves--' . sanitize_html_class( $variant );
  ?>
  <svg class="<?php echo esc_attr( $class ); ?>" viewBox="0 0 1440 600" preserveAspectRatio="none" aria-hidden="true" focusable="false">
    <path class="afx-wave afx-wave--mist" d="M0 590C380 560 880 360 1440 30V600H0Z"/>
    <path class="afx-wave afx-wave--sage" d="M260 600C640 530 1020 390 1440 150V600Z"/>
    <path class="afx-wave afx-wave--navy" d="M600 600C930 545 1190 430 1440 270V600Z"/>
    <path class="afx-wave afx-wave--green" d="M820 600C1080 575 1270 515 1440 440V600Z"/>
  </svg>
  <?php
}

/**
 * Lista de miniaturas del diseño (las tres propiedades de ejemplo).
 */
function afx_property_thumb( $position = 'center' ) {
  return sprintf(
    '<span class="afx-thumb" style="background-image:url(%s);background-position:%s" aria-hidden="true"></span>',
    esc_url( get_stylesheet_directory_uri() . '/assets/img/edificio-verde.jpg' ),
    esc_attr( $position )
  );
}

add_filter(
  'body_class',
  static function ( $classes ) {
    $classes[] = 'afx-body';
    return $classes;
  }
);

/**
 * Estilos y scripts del rediseño (GSAP + Observer locales, sin CDN).
 */
function afx_enqueue_redesign_assets() {
  $dir = get_stylesheet_directory_uri();

  wp_enqueue_style(
    'afx-redesign',
    $dir . '/assets/css/redesign.css',
    array( 'twentytwentyfive-child-style', 'twentytwentyfive-child-tokens', 'twentytwentyfive-child-form-normalize' ),
    twentytwentyfive_child_asset_version( 'assets/css/redesign.css' )
  );

  wp_register_script( 'afx-gsap', $dir . '/assets/vendor/gsap.min.js', array(), '3.15.1', true );
  wp_register_script( 'afx-gsap-observer', $dir . '/assets/vendor/Observer.min.js', array( 'afx-gsap' ), '3.15.1', true );
  wp_register_script( 'afx-gsap-scrolltrigger', $dir . '/assets/vendor/ScrollTrigger.min.js', array( 'afx-gsap' ), '3.15.1', true );

  wp_enqueue_script(
    'afx-redesign',
    $dir . '/assets/js/redesign.js',
    array( 'afx-gsap', 'afx-gsap-observer', 'afx-gsap-scrolltrigger' ),
    twentytwentyfive_child_asset_version( 'assets/js/redesign.js' ),
    true
  );
}
add_action( 'wp_enqueue_scripts', 'afx_enqueue_redesign_assets', 30 );

// Sin la barra negra de WordPress ("Howdy, …") en el sitio público.
add_filter( 'show_admin_bar', '__return_false', 100 );

/**
 * Marca temprano la decisión pendiente de cookies: mientras no exista una elección
 * (aceptar, rechazar o personalizar) el sitio queda a la espera del banner.
 */
function afx_cookie_gate_flag() {
  echo "<script>if(!/(?:^|;\\s*)cmplz_banner-status=dismissed/.test(document.cookie)){document.documentElement.classList.add('afx-gated');}</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
}
add_action( 'wp_head', 'afx_cookie_gate_flag', 1 );

/**
 * Crea (y publica) las páginas nuevas del diseño; cada una usa su plantilla por slug.
 */
function afx_ensure_redesign_pages() {
  $pages = array(
    'facturacion-electronica' => __( 'Facturación Electrónica', 'twentytwentyfive-child' ),
    'pagos-y-cobros'          => __( 'Pagos y Cobros', 'twentytwentyfive-child' ),
  );

  foreach ( $pages as $slug => $title ) {
    $page = get_page_by_path( $slug );

    if ( $page instanceof WP_Post ) {
      if ( 'publish' !== $page->post_status ) {
        wp_update_post( array( 'ID' => $page->ID, 'post_status' => 'publish' ) );
      }
      continue;
    }

    wp_insert_post(
      array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'post_title'     => $title,
        'post_name'      => $slug,
        'post_content'   => '',
        'comment_status' => 'closed',
      )
    );
  }
}
add_action( 'init', 'afx_ensure_redesign_pages' );

/**
 * Las páginas ya podían existir con otra plantilla asignada en el editor
 * (p. ej. "Detalle de servicio"); se fuerza la plantilla del rediseño por slug.
 */
function afx_force_redesign_templates( $template ) {
  $map = array(
    'facturacion-electronica' => 'page-facturacion-electronica.php',
    'pagos-y-cobros'          => 'page-pagos-y-cobros.php',
    'preguntas-frecuentes'    => 'page-preguntas-frecuentes.php',
  );

  foreach ( $map as $slug => $file ) {
    if ( is_page( $slug ) ) {
      $forced = locate_template( $file );
      if ( $forced ) {
        return $forced;
      }
    }
  }

  return $template;
}
add_filter( 'template_include', 'afx_force_redesign_templates', 99 );


/**
 * Destinos internos permitidos tras iniciar sesión desde los pasos de "Cómo funciona".
 */
function afx_login_targets() {
  return array(
    'property' => admin_url( 'admin.php?page=af-accommodation-form' ),
    'panel'    => admin_url( 'admin.php?page=arriendo-facil' ),
  );
}

/**
 * URL de inicio de sesión que, al autenticarse, lleva directo al destino pedido.
 */
function afx_login_url_for( $target ) {
  $targets = afx_login_targets();
  $login   = function_exists( 'af_custom_login_base_url' ) ? af_custom_login_base_url() : wp_login_url();

  if ( ! isset( $targets[ $target ] ) ) {
    return $login;
  }

  return add_query_arg( 'redirect_to', rawurlencode( $targets[ $target ] ), $login );
}

/**
 * El plugin envía siempre a los administradores de propiedades al Panel.
 * Se respeta el destino solicitado solo si es uno de los destinos internos conocidos
 * y antes del filtro de onboarding (prioridad 20), que sigue mandando a verificar identidad.
 */
function afx_honor_requested_login_target( $redirect_to, $requested_redirect_to, $user ) {
  if ( ! $user instanceof WP_User || empty( $requested_redirect_to ) ) {
    return $redirect_to;
  }

  $requested = wp_validate_redirect( $requested_redirect_to, '' );
  if ( '' === $requested || ! in_array( $requested, afx_login_targets(), true ) ) {
    return $redirect_to;
  }

  if ( ! user_can( $user, 'read' ) ) {
    return $redirect_to;
  }

  return $requested;
}
add_filter( 'login_redirect', 'afx_honor_requested_login_target', 15, 3 );

/**
 * Complianz no incluye traducción al español para el texto de las categorías del banner.
 */
function afx_complianz_es_banner( $settings ) {
  $map = array(
    'Always active' => 'Siempre activas',
    'Functional'    => 'Funcionales',
    'Preferences'   => 'Preferencias',
    'Statistics'    => 'Estadísticas',
  );

  foreach ( array( 'category_functional', 'category_preferences', 'category_statistics' ) as $key ) {
    if ( isset( $settings[ $key ] ) && is_string( $settings[ $key ] ) && isset( $map[ $settings[ $key ] ] ) ) {
      $settings[ $key ] = $map[ $settings[ $key ] ];
    }
  }

  return $settings;
}
add_filter( 'cmplz_cookiebanner_settings_html', 'afx_complianz_es_banner' );

function afx_complianz_es_always_active( $translation, $text, $domain ) {
  return ( 'complianz-gdpr' === $domain && 'Always active' === $text ) ? 'Siempre activas' : $translation;
}
add_filter( 'gettext', 'afx_complianz_es_always_active', 10, 3 );
