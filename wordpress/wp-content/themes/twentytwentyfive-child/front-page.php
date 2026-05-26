<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();

$q = new WP_Query([
  'post_type'      => 'post',
  'posts_per_page' => 3,
  'post_status'    => 'publish',
  'category_name'  => 'propiedades-destacadas',
  'orderby'        => 'date',
  'order'          => 'DESC',
]);

$featured_posts = [];
if ($q->have_posts()) {
  while ($q->have_posts()) { $q->the_post();
    $id = get_the_ID();

    $img = get_the_post_thumbnail_url($id, 'af-card');
    if (!$img) { $img = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg'; }

    $thumb_id  = get_post_thumbnail_id($id);
    $thumb_alt = $thumb_id ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : '';
    $img_alt   = $thumb_alt ? $thumb_alt : get_the_title();

    $tags = get_the_tags($id);
    $tag_names = [];
    if ($tags && !is_wp_error($tags)) {
      foreach ($tags as $t) { $tag_names[] = $t->name; }
    }

    $featured_posts[] = [
      'id'      => $id,
      'title'   => get_the_title(),
      'link'    => get_permalink(),
      'image'   => $img,
      'alt'     => $img_alt,
      'excerpt' => get_the_excerpt(),
      'tags'    => $tag_names,
    ];
  }
  wp_reset_postdata();
}

$q_residencias = new WP_Query([
  'post_type'      => 'residencia',
  'posts_per_page' => 3,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
]);

$residencias = [];
if ($q_residencias->have_posts()) {
  while ($q_residencias->have_posts()) { $q_residencias->the_post();
    $id = get_the_ID();

    $img = get_the_post_thumbnail_url($id, 'af-card');
    if (!$img) { $img = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg'; }

    $thumb_id  = get_post_thumbnail_id($id);
    $thumb_alt = $thumb_id ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : '';
    $img_alt   = $thumb_alt ? $thumb_alt : get_the_title();
    $residencias[] = [
      'id'    => $id,
      'title' => get_the_title(),
      'link'  => get_permalink(),
      'image' => esc_url_raw($img),
      'alt'   => esc_attr($img_alt),
    ];
  }
  wp_reset_postdata();
}

$accommodation_count = wp_count_posts('accommodation');
$total_accommodations = $accommodation_count->publish ?? 0;
?>

<main id="main-content">

  <!-- ========== HERO ========== -->
  <section class="hero" id="inicio">
    <div class="container">
      <div class="hero-grid">
        <div class="hero-content" data-animate>
          <span class="badge"><?php esc_html_e('Encuentra tu lugar perfecto', 'twentytwentyfive-child'); ?></span>
          <h1 class="h1">
            <?php esc_html_e('Arriendos verificados en Quito y Ecuador', 'twentytwentyfive-child'); ?>
          </h1>
          <p class="p">
            <?php esc_html_e('Descubre arriendos de calidad en Ecuador. Propiedades confiables y bien ubicadas. Rápido, seguro y sin complicaciones.', 'twentytwentyfive-child'); ?>
          </p>

          <div class="cta-row">
            <a class="btn btn--primary btn--lg" href="<?php echo esc_url(home_url('/search-results')); ?>">
              <?php esc_html_e('Buscar propiedades', 'twentytwentyfive-child'); ?>
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a class="btn btn--outline btn--lg" href="#como-funciona">
              <?php esc_html_e('¿Cómo funciona?', 'twentytwentyfive-child'); ?>
            </a>
          </div>
        </div>

        <div class="hero-visual" data-animate>
          <div class="hero-card" aria-label="<?php esc_attr_e('Búsqueda de propiedades disponibles', 'twentytwentyfive-child'); ?>">
            <div class="mock-header">
              <span class="badge"><?php esc_html_e('Búsqueda rápida', 'twentytwentyfive-child'); ?></span>
            </div>
            <div class="mock-body">
              <!-- Hero Search Bar -->
              <div class="hero-search-bar">
                <input
                  type="text"
                  id="hero-search-input"
                  class="hero-search-input"
                  placeholder="<?php esc_attr_e('¿Dónde quieres vivir?', 'twentytwentyfive-child'); ?>"
                  autocomplete="off" />
                <ul id="hero-search-suggestions" class="hero-search-suggestions"></ul>
                <button id="hero-search-btn" class="hero-search-btn" aria-label="<?php esc_attr_e('Buscar', 'twentytwentyfive-child'); ?>">
                  <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </button>
              </div>

              <div class="hero-search-divider"></div>

              <div class="stats-grid">
                <div class="stat-item">
                  <div class="stat-number"><?php echo esc_html($total_accommodations); ?>+</div>
                  <div class="stat-label"><?php esc_html_e('Propiedades', 'twentytwentyfive-child'); ?></div>
                </div>
                <div class="stat-item">
                  <div class="stat-number">98%</div>
                  <div class="stat-label"><?php esc_html_e('Ocupación', 'twentytwentyfive-child'); ?></div>
                </div>
                <div class="stat-item">
                  <div class="stat-number">+25%</div>
                  <div class="stat-label"><?php esc_html_e('Rentabilidad', 'twentytwentyfive-child'); ?></div>
                </div>
              </div>
              <p style="margin: var(--space-4) 0 0 0; color: var(--color-text-secondary); font-size: 13px; text-align: center;">
                <?php esc_html_e('Verifica ubicación, comodidades y precios en tiempo real', 'twentytwentyfive-child'); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROPIEDADES DESTACADAS ========== -->
  <section class="section section--soft" id="arrendamiento">
    <div class="container">
      <?php if ($featured_posts) : ?>
        <div class="text-center" data-animate>
          <span class="badge"><?php esc_html_e('Propiedades destacadas', 'twentytwentyfive-child'); ?></span>
          <h2 class="h2"><?php esc_html_e('Hospedajes verificados y listos', 'twentytwentyfive-child'); ?></h2>
          <p class="p mx-auto"><?php esc_html_e('Descubre propiedades de calidad seleccionadas para ti. Ubicación, comodidad y confianza garantizadas.', 'twentytwentyfive-child'); ?></p>
        </div>

        <div class="flip-carousel" data-flip-carousel>
          <div class="flip-carousel__track" data-flip-track>
            <?php foreach ($featured_posts as $i => $post) : ?>
              <div class="flip-card" data-flip-card>
                <div class="flip-card__inner">
                  <div class="flip-card__front">
                    <img
                      src="<?php echo esc_url($post['image']); ?>"
                      alt="<?php echo esc_attr($post['alt']); ?>"
                      width="480" height="320"
                      loading="lazy"
                      decoding="async">
                    <div class="flip-card__overlay">
                      <h3 class="flip-card__title"><?php echo esc_html($post['title']); ?></h3>
                    </div>
                  </div>
                  <div class="flip-card__back">
                    <button class="flip-card__close" aria-label="<?php esc_attr_e('Cerrar', 'twentytwentyfive-child'); ?>" type="button">
                      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                    <div class="flip-card__back-content">
                      <h3><?php echo esc_html($post['title']); ?></h3>
                      <?php if (!empty($post['excerpt'])) : ?>
                        <p class="flip-card__excerpt"><?php echo esc_html($post['excerpt']); ?></p>
                      <?php endif; ?>
                      <?php if (!empty($post['tags'])) : ?>
                        <div class="flip-card__badges">
                          <?php foreach ($post['tags'] as $tag) : ?>
                            <span class="badge badge--feature"><?php echo esc_html($tag); ?></span>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                      <a class="btn btn--primary" href="<?php echo esc_url($post['link']); ?>">
                        <?php esc_html_e('Ver detalles', 'twentytwentyfive-child'); ?>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <button class="flip-carousel__prev" data-flip-prev aria-label="<?php esc_attr_e('Anterior', 'twentytwentyfive-child'); ?>">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>
          <button class="flip-carousel__next" data-flip-next aria-label="<?php esc_attr_e('Siguiente', 'twentytwentyfive-child'); ?>">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>

        <?php if (!empty($residencias)) : ?>
          <div class="featured-strip" data-featured-strip>
            <?php foreach ($residencias as $item) : ?>
              <a class="featured-item" href="<?php echo esc_url($item['link']); ?>" aria-label="<?php echo esc_attr($item['title']); ?>">
                <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" width="480" height="320" loading="lazy" decoding="async">
                <div class="fi-title"><?php echo esc_html($item['title']); ?></div>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php else : ?>
        <div class="showcase showcase--empty" data-home-showcase>
          <div class="showcase-head">
            <strong><?php esc_html_e('Propiedad destacada', 'twentytwentyfive-child'); ?></strong>
          </div>
          <div class="showcase-empty" role="status">
            <?php esc_html_e('Aún no hay propiedades destacadas publicadas.', 'twentytwentyfive-child'); ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>


  <!-- ========== BENEFICIOS ========== -->
  <section class="section section--soft" id="por-que-elegir">
    <div class="container">
      <div class="text-center" data-animate>
        <h2 class="h2"><?php esc_html_e('¿Por qué elegir Arriendo Fácil?', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('Una plataforma confiable, rápida y transparente para encontrar tu próximo hogar.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="benefits-grid">
        <div class="benefit-card" data-animate>
          <div class="benefit-icon-wrapper">
            <span class="benefit-icon" aria-hidden="true">&#x1F6E1;&#xFE0F;</span>
          </div>
          <div class="benefit-content">
            <h3 class="benefit-title"><?php esc_html_e('Plataforma confiable', 'twentytwentyfive-child'); ?></h3>
            <p class="benefit-desc"><?php esc_html_e('Todos nuestros hospedajes son verificados. Seguridad y calidad garantizadas en cada propiedad.', 'twentytwentyfive-child'); ?></p>
          </div>
        </div>
        <div class="benefit-card" data-animate>
          <div class="benefit-icon-wrapper">
            <span class="benefit-icon" aria-hidden="true">&#x26A1;</span>
          </div>
          <div class="benefit-content">
            <h3 class="benefit-title"><?php esc_html_e('Proceso ágil', 'twentytwentyfive-child'); ?></h3>
            <p class="benefit-desc"><?php esc_html_e('Busca, contacta y muda en días. Sin trámites innecesarios, solo lo esencial.', 'twentytwentyfive-child'); ?></p>
          </div>
        </div>
        <div class="benefit-card" data-animate>
          <div class="benefit-icon-wrapper">
            <span class="benefit-icon" aria-hidden="true">&#x1F4DE;</span>
          </div>
          <div class="benefit-content">
            <h3 class="benefit-title"><?php esc_html_e('Soporte siempre disponible', 'twentytwentyfive-child'); ?></h3>
            <p class="benefit-desc"><?php esc_html_e('Estamos aquí 24/7 para resolver tus dudas. Respuestas rápidas, sin esperas.', 'twentytwentyfive-child'); ?></p>
          </div>
        </div>
        <div class="benefit-card" data-animate>
          <div class="benefit-icon-wrapper">
            <span class="benefit-icon" aria-hidden="true">&#x1F4B0;</span>
          </div>
          <div class="benefit-content">
            <h3 class="benefit-title"><?php esc_html_e('Precios claros', 'twentytwentyfive-child'); ?></h3>
            <p class="benefit-desc"><?php esc_html_e('Sin sorpresas. Todos los costos incluidos desde el inicio. Transparencia total.', 'twentytwentyfive-child'); ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CARACTERÍSTICAS PARA RENTERS ========== -->
  <section class="section" id="servicios">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Lo que ofrecemos', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('Diseñado pensando en ti', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('Herramientas y servicios que hacen tu búsqueda más fácil, segura y rápida.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="kv-grid">
        <div class="card" data-animate>
          <div class="card-icon">🔍</div>
          <h3><?php esc_html_e('Búsqueda inteligente', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Filtros por ubicación, presupuesto y tipo de propiedad', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Disponibilidad actualizada en tiempo real', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Fotos de alta calidad y tours virtuales', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Comparar propiedades lado a lado', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>

        <div class="card" data-animate>
          <div class="card-icon">🛡️</div>
          <h3><?php esc_html_e('Propiedades verificadas', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Inspección de seguridad en cada propiedad', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Propietarios y documentación validados', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Historial de inquilinos satisfechos', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Garantía de seguridad en tu nuevo hogar', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>

        <div class="card" data-animate>
          <div class="card-icon">📞</div>
          <h3><?php esc_html_e('Soporte confiable', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Atención 24/7 en dudas y problemas', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Respuestas rápidas a tus preguntas', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Mediación neutral en conflictos', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Asesoría legal en contratación', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CÓMO FUNCIONA ========== -->
  <section class="section" id="como-funciona">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Tres pasos simples', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></h2>
        <p class="p mx-auto"><?php esc_html_e('Encuentra tu hogar perfecto en minutos, sin complicaciones.', 'twentytwentyfive-child'); ?></p>
      </div>

      <div class="steps-container">
        <div class="steps">
          <div class="step" data-animate>
            <div class="step-number">1</div>
            <h4><?php esc_html_e('Busca', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Explora nuestro catálogo con filtros por ubicación, precio, tipo de propiedad y disponibilidad.', 'twentytwentyfive-child'); ?></span>
          </div>
          <div class="step" data-animate>
            <div class="step-number">2</div>
            <h4><?php esc_html_e('Contacta', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Comunícate con nosotros. Resuelve tus dudas y negocia los términos.', 'twentytwentyfive-child'); ?></span>
          </div>
          <div class="step" data-animate>
            <div class="step-number">3</div>
            <h4><?php esc_html_e('Muda', 'twentytwentyfive-child'); ?></h4>
            <span><?php esc_html_e('Confirma los términos, formaliza el contrato y ¡bienvenido a tu nuevo hogar!', 'twentytwentyfive-child'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== RAZONES PARA ELEGIR ARRIENDO FÁCIL ========== -->
  <section class="section section--dark" id="para-renters">
    <div class="container">
      <div class="text-center" data-animate>
        <span class="badge"><?php esc_html_e('Para renters', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2"><?php esc_html_e('Ventajas para arrendatarios en Ecuador', 'twentytwentyfive-child'); ?></h2>
      </div>

      <div class="kv-grid">
        <div class="card" data-animate>
          <div class="card-icon">⚡</div>
          <h3><?php esc_html_e('Búsqueda rápida', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Encuentra hogar en minutos, no semanas', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Notificaciones instantáneas de nuevas propiedades', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card" data-animate>
          <div class="card-icon">🔒</div>
          <h3><?php esc_html_e('Seguridad garantizada', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Todas las propiedades son inspeccionadas', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Propietarios verificados y validados', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Tu información personal protegida', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
        <div class="card" data-animate>
          <div class="card-icon">💰</div>
          <h3><?php esc_html_e('Precios claros', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Sin sorpresas o costos ocultos', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Todos los gastos desglosados desde el inicio', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Comparar precios entre propiedades fácilmente', 'twentytwentyfive-child'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== TESTIMONIOS + CONTACTO ========== -->
  <section class="section" id="contacto">
    <div class="container split-cta">
      <div>
        <span class="badge" data-animate><?php esc_html_e('Testimonios', 'twentytwentyfive-child'); ?></span>
        <h2 class="h2" data-animate><?php esc_html_e('Lo que dicen quienes encontraron su hogar', 'twentytwentyfive-child'); ?></h2>

        <div class="testimonials-mini">
          <div class="quote-mini" data-animate>
            <strong><?php esc_html_e('Alejandra M. — Quito', 'twentytwentyfive-child'); ?></strong>
            <p>"<?php esc_html_e('Encontré mi apartamento en 3 días. Todo fue fácil, seguro y transparente. Recomiendo Arriendo Fácil.', 'twentytwentyfive-child'); ?>"</p>
          </div>
          <div class="quote-mini" data-animate>
            <strong><?php esc_html_e('Diego R. — Guayaquil', 'twentytwentyfive-child'); ?></strong>
            <p>"<?php esc_html_e('La mejor experiencia arrendando. Propietario responsable, proceso rápido y soporte disponible siempre.', 'twentytwentyfive-child'); ?>"</p>
          </div>
          <div class="quote-mini" data-animate>
            <strong><?php esc_html_e('Sofía L. — Cuenca', 'twentytwentyfive-child'); ?></strong>
            <p>"<?php esc_html_e('Sentía que el hogar debe venir con paz mental. Arriendo Fácil me la dio desde el primer día.', 'twentytwentyfive-child'); ?>"</p>
          </div>
        </div>
      </div>

      <div class="contact-card cta-card" data-animate>
        <h2 class="h2"><?php esc_html_e('¿Listo para encontrar tu próximo hogar?', 'twentytwentyfive-child'); ?></h2>
        <p class="p"><?php esc_html_e('Explora cientos de propiedades verificadas. Seguridad, rapidez y transparencia garantizadas.', 'twentytwentyfive-child'); ?></p>

        <a class="btn btn--primary btn--lg" href="<?php echo esc_url(home_url('/propiedades/')); ?>">
          <?php esc_html_e('Buscar propiedades', 'twentytwentyfive-child'); ?>
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ========== PROGRAMA DE RECOMENDACIONES ========== -->
  <section class="section section--referral" id="recomendaciones">
    <div class="container">
      <div class="referral-grid" data-animate>
        <div class="referral-left">
          <span class="referral-badge">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <?php esc_html_e('Sé parte de nuestra comunidad', 'twentytwentyfive-child'); ?>
          </span>

          <h2 class="referral-title">
            <?php echo wp_kses(
              __('¿Conoces una propiedad que debería estar en <span class="text-accent">Arriendo Fácil</span>?', 'twentytwentyfive-child'),
              array('span' => array('class' => array()))
            ); ?>
          </h2>

          <p class="referral-subtitle">
            <?php esc_html_e('Ayúdanos a descubrir los mejores alojamientos y gana recompensas por cada recomendación exitosa.', 'twentytwentyfive-child'); ?>
          </p>

          <div class="referral-features">
            <div class="referral-feature">
              <div class="referral-feature-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
              </div>
              <div>
                <strong><?php esc_html_e('Proceso seguro', 'twentytwentyfive-child'); ?></strong>
                <span><?php esc_html_e('Evaluamos cada propiedad.', 'twentytwentyfive-child'); ?></span>
              </div>
            </div>
            <div class="referral-feature">
              <div class="referral-feature-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              </div>
              <div>
                <strong><?php esc_html_e('Comunidad exclusiva', 'twentytwentyfive-child'); ?></strong>
                <span><?php esc_html_e('Únete a nuestros recomendadores.', 'twentytwentyfive-child'); ?></span>
              </div>
            </div>
          </div>

          <div class="referral-name-form" id="referral-name-form">
            <label for="referral-name" class="referral-name-label"><?php esc_html_e('Tu nombre para el mensaje:', 'twentytwentyfive-child'); ?></label>
            <div class="referral-name-row">
              <input
                type="text"
                id="referral-name"
                class="referral-name-input"
                placeholder="<?php esc_attr_e('Ej: Juan Pérez', 'twentytwentyfive-child'); ?>"
                maxlength="60"
                autocomplete="off"
              >
              <a
                href="#"
                class="referral-btn"
                id="referral-whatsapp-btn"
                aria-label="<?php esc_attr_e('Recomendar propiedad por WhatsApp', 'twentytwentyfive-child'); ?>"
                target="_blank"
                rel="noopener noreferrer">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                <?php esc_html_e('Enviar por WhatsApp', 'twentytwentyfive-child'); ?>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </a>
            </div>
            <p class="referral-name-error" id="referral-name-error" hidden></p>
          </div>

          <div class="referral-social-proof">
            <div class="referral-avatars">
              <div class="referral-avatar">D</div>
              <div class="referral-avatar">M</div>
              <div class="referral-avatar">S</div>
              <div class="referral-avatar">A</div>
            </div>
            <div class="referral-stars">★★★★★</div>
            <span><?php esc_html_e('+50 personas ya están recomendando propiedades', 'twentytwentyfive-child'); ?></span>
          </div>
        </div>

        <div class="referral-right">
          <div class="referral-phone">
            <div class="referral-phone-header">
              <div class="referral-phone-back">‹</div>
              <div class="referral-phone-contact">
                <div class="referral-phone-avatar-circle notranslate" translate="no">AF</div>
                <div>
                  <strong>ArriendoFácil</strong>
                  <span>En línea</span>
                </div>
              </div>
            </div>
            <div class="referral-phone-chat">
              <div class="referral-chat-bubble referral-chat-incoming">
                <p>¡Hola! 👋 Cuéntanos sobre la propiedad que quieres recomendar.</p>
                <span class="referral-chat-time">11:30 a.m.</span>
              </div>
              <div class="referral-chat-bubble referral-chat-outgoing">
                <p>Quiero recomendar una hermosa casa frente al mar.</p>
                <span class="referral-chat-time">11:31 a.m.</span>
              </div>
              <div class="referral-chat-bubble referral-chat-incoming">
                <p>¡Excelente! Envíanos los detalles y fotos, nuestro equipo la revisará.</p>
                <span class="referral-chat-time">11:33 a.m.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
