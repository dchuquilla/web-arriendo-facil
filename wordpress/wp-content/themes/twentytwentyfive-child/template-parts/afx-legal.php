<?php
/**
 * Plantilla compartida de documentos legales (términos, privacidad, cookies).
 *
 * Args esperados (get_template_part 3er parámetro):
 *  - slug     string  Slug de la página actual (para marcarla en "Otros documentos").
 *  - tag      string  Etiqueta sobre el título.
 *  - title    string  Parte normal del título.
 *  - accent   string  Parte resaltada del título.
 *  - lead     string  Bajada.
 *  - meta     array   Chips de la cabecera (texto).
 *  - summary  array   Puntos del "En resumen" (HTML permitido: strong, a).
 *  - sections array   Cada una: id, icon, title, html.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$afx_args = wp_parse_args(
  isset( $args ) ? $args : array(),
  array(
    'slug'     => '',
    'tag'      => '',
    'title'    => '',
    'accent'   => '',
    'lead'     => '',
    'meta'     => array(),
    'summary'  => array(),
    'sections' => array(),
  )
);

$afx_allowed = array(
  'p'          => array( 'class' => true ),
  'ul'         => array( 'class' => true ),
  'ol'         => array( 'class' => true ),
  'li'         => array(),
  'strong'     => array(),
  'em'         => array(),
  'br'         => array(),
  'a'          => array( 'href' => true, 'target' => true, 'rel' => true ),
  'h3'         => array(),
  'div'        => array( 'class' => true ),
  'table'      => array( 'class' => true ),
  'thead'      => array(),
  'tbody'      => array(),
  'tr'         => array(),
  'th'         => array( 'scope' => true ),
  'td'         => array( 'data-label' => true ),
  'code'       => array(),
);

$afx_docs = array(
  'terminos-y-condiciones' => array( 'icon' => 'scale', 'title' => 'Términos y condiciones', 'text' => 'Reglas de uso del servicio.' ),
  'politica-de-privacidad' => array( 'icon' => 'shield', 'title' => 'Política de privacidad', 'text' => 'Cómo tratamos sus datos.' ),
  'cookie-policy-eu'       => array( 'icon' => 'cookie', 'title' => 'Política de cookies', 'text' => 'Qué cookies usamos y por qué.' ),
);
?>

<main id="main-content" class="afx-main afx-faqpage afx-legalpage" data-afx-page>
  <section class="afx-faqhero">
    <?php afx_waves(); ?>
    <div class="afx-wrap afx-faqhero__copy">
      <p class="afx-tag" data-afx><?php echo afx_icon( 'shield', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $afx_args['tag'] ); ?></p>
      <h1 class="afx-title afx-title--xl" data-afx><?php echo esc_html( $afx_args['title'] ); ?> <span><?php echo esc_html( $afx_args['accent'] ); ?></span></h1>
      <p class="afx-sub__lead" data-afx><?php echo esc_html( $afx_args['lead'] ); ?></p>
      <?php if ( $afx_args['meta'] ) : ?>
        <ul class="afx-legalmeta" data-afx>
          <?php foreach ( $afx_args['meta'] as $afx_m ) : ?>
            <li><?php echo esc_html( $afx_m ); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </section>

  <section class="afx-wrap afx-faqbody">
    <aside class="afx-faqnav afx-faqnav--legal" data-afx>
      <nav aria-label="<?php esc_attr_e( 'Contenido del documento', 'twentytwentyfive-child' ); ?>">
        <ul>
          <?php foreach ( $afx_args['sections'] as $afx_i => $afx_s ) : ?>
            <li><a class="afx-faqnav__link<?php echo 0 === $afx_i ? ' is-active' : ''; ?>" href="#<?php echo esc_attr( $afx_s['id'] ); ?>" data-no-loader="true"><span class="afx-faqnav__num"><?php echo (int) ( $afx_i + 1 ); ?></span><span><?php echo esc_html( $afx_s['nav'] ?? $afx_s['title'] ); ?></span></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
    </aside>

    <div class="afx-faqlist">
      <?php if ( $afx_args['summary'] ) : ?>
        <aside class="afx-legalsum" data-afx>
          <h2 class="afx-legalsum__title"><?php echo afx_icon( 'sparkles', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'En resumen', 'twentytwentyfive-child' ); ?></h2>
          <ul>
            <?php foreach ( $afx_args['summary'] as $afx_p ) : ?>
              <li><?php echo afx_icon( 'check', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo wp_kses( $afx_p, $afx_allowed ); ?></span></li>
            <?php endforeach; ?>
          </ul>
          <p class="afx-legalsum__note"><?php esc_html_e( 'Este resumen es solo una guía de lectura. Lo que vale es el texto completo de cada cláusula.', 'twentytwentyfive-child' ); ?></p>
        </aside>
      <?php endif; ?>

      <?php foreach ( $afx_args['sections'] as $afx_i => $afx_s ) : ?>
        <section class="afx-faqsec afx-legalsec" id="<?php echo esc_attr( $afx_s['id'] ); ?>" data-afx>
          <h2 class="afx-faqsec__title">
            <span class="afx-faqsec__icon"><?php echo afx_icon( $afx_s['icon'], 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
            <span><small class="afx-legalsec__n"><?php printf( esc_html__( 'Sección %d', 'twentytwentyfive-child' ), (int) ( $afx_i + 1 ) ); ?></small><?php echo esc_html( $afx_s['title'] ); ?></span>
          </h2>
          <div class="afx-legal__body"><?php echo wp_kses( $afx_s['html'], $afx_allowed ); ?></div>
        </section>
      <?php endforeach; ?>

      <aside class="afx-legaldocs" data-afx aria-labelledby="afx-legaldocs-t">
        <h2 id="afx-legaldocs-t"><?php esc_html_e( 'Otros documentos legales', 'twentytwentyfive-child' ); ?></h2>
        <div class="afx-legaldocs__grid">
          <?php foreach ( $afx_docs as $afx_slug => $afx_d ) : if ( $afx_slug === $afx_args['slug'] ) { continue; } ?>
            <a class="afx-legaldocs__card" href="<?php echo esc_url( home_url( '/' . $afx_slug . '/' ) ); ?>">
              <span class="afx-faqsec__icon"><?php echo afx_icon( $afx_d['icon'], 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
              <span><strong><?php echo esc_html( $afx_d['title'] ); ?></strong><small><?php echo esc_html( $afx_d['text'] ); ?></small></span>
              <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </a>
          <?php endforeach; ?>
        </div>
      </aside>

      <aside class="afx-faqhelp" data-afx>
        <span class="afx-faqhelp__icon"><?php echo afx_icon( 'mail', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <div>
          <h2><?php esc_html_e( '¿Tiene preguntas sobre este documento?', 'twentytwentyfive-child' ); ?></h2>
          <p><?php esc_html_e( 'Escríbanos y le responderemos en un plazo máximo de 15 días hábiles.', 'twentytwentyfive-child' ); ?></p>
        </div>
        <a class="afx-btn afx-btn--dark" href="mailto:arriendofacilnet@gmail.com">
          <?php esc_html_e( 'Escribir al equipo', 'twentytwentyfive-child' ); ?>
          <?php echo afx_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        </a>
      </aside>
    </div>
  </section>
</main>
