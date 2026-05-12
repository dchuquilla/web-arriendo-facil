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

    $img = get_the_post_thumbnail_url($id, 'large');
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

    $img = get_the_post_thumbnail_url($id, 'large');
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
            <?php esc_html_e('Hospedajes verificados para ti', 'twentytwentyfive-child'); ?>
          </h1>
          <p class="p">
            <?php esc_html_e('Descubre hospedajes de calidad, confiables y bien ubicados. Rápido, seguro y sin complicaciones.', 'twentytwentyfive-child'); ?>
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

        <div class="showcase" data-home-showcase>
          <div class="showcase-head">
            <strong><?php esc_html_e('Propiedad destacada', 'twentytwentyfive-child'); ?></strong>

            <div class="carousel-controls">
              <button class="icon-btn" type="button" data-carousel-prev aria-label="<?php esc_attr_e('Anterior', 'twentytwentyfive-child'); ?>">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
              </button>
              <button class="icon-btn" type="button" data-carousel-next aria-label="<?php esc_attr_e('Siguiente', 'twentytwentyfive-child'); ?>">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
              </button>
            </div>
          </div>

          <div class="carousel-wrapper">
            <div class="carousel-inner">
              <?php foreach ($featured_posts as $i => $post) : ?>
                <div class="carousel-slide <?php echo $i === 0 ? 'is-active' : ''; ?>" data-carousel-slide="<?php echo esc_attr($i); ?>">
                  <div class="showcase-body">
                    <div class="showcase-media">
                      <a href="<?php echo esc_url($post['link']); ?>" data-property-link>
                        <img
                          src="<?php echo esc_url($post['image']); ?>"
                          alt="<?php echo esc_attr($post['alt']); ?>"
                          data-property-image
                          loading="lazy"
                          decoding="async"
                        >
                      </a>
                    </div>

                    <div class="showcase-info">
                      <h3 data-property-title><?php echo esc_html($post['title']); ?></h3>

                      <p
                        class="p showcase-meta"
                        data-property-excerpt
                        <?php if (empty($post['excerpt'])) : ?>style="display:none;"<?php endif; ?>
                      ><?php echo esc_html($post['excerpt']); ?></p>

                      <div class="badges" data-property-badges>
                        <?php foreach (($post['tags'] ?? []) as $tag) : ?>
                          <?php if ($tag === 'Áreas comunales') : ?>
                            <?php $residencia_link = get_field('residencia', $post['id']); ?>
                            <?php if ($residencia_link) : ?>
                              <a href="<?php echo esc_url($residencia_link); ?>" class="badge badge--feature">
                                <?php echo esc_html($tag); ?>
                              </a>
                            <?php else : ?>
                              <span class="badge badge--feature"><?php echo esc_html($tag); ?></span>
                            <?php endif; ?>
                          <?php else : ?>
                            <span class="badge badge--feature"><?php echo esc_html($tag); ?></span>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </div>

                      <div class="showcase-actions">
                        <a class="btn btn--primary" href="<?php echo esc_url($post['link']); ?>"><?php esc_html_e('Ver detalles completos', 'twentytwentyfive-child'); ?></a>
                        <a class="btn btn--outline" href="#contacto"><?php esc_html_e('Contactar propietario', 'twentytwentyfive-child'); ?></a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="dots" data-carousel-dots aria-label="<?php esc_attr_e('Navegación del carrusel', 'twentytwentyfive-child'); ?>">
              <?php foreach ($featured_posts as $i => $post) : ?>
                <button
                  class="dot-btn <?php echo $i === 0 ? 'is-active' : ''; ?>"
                  data-carousel-dot="<?php echo esc_attr($i); ?>"
                  aria-label="<?php echo esc_attr(sprintf(__('Imagen %d', 'twentytwentyfive-child'), $i + 1)); ?>"
                  aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                  type="button"
                ></button>
              <?php endforeach; ?>
            </div>

            <?php if (!empty($residencias)) : ?>
              <div class="featured-strip" data-featured-strip>
                <?php foreach ($residencias as $item) : ?>
                  <a class="featured-item" href="<?php echo esc_url($item['link']); ?>" aria-label="<?php echo esc_attr($item['title']); ?>">
                    <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                    <div class="fi-title"><?php echo esc_html($item['title']); ?></div>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
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
          <div class="benefit-icon">🛡️</div>
          <h3 class="h3"><?php esc_html_e('Plataforma confiable', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('Todos nuestros hospedajes son verificados. Seguridad y calidad garantizadas en cada propiedad.', 'twentytwentyfive-child'); ?></p>
        </div>
        <div class="benefit-card" data-animate>
          <div class="benefit-icon">⚡</div>
          <h3 class="h3"><?php esc_html_e('Proceso ágil', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('Busca, contacta y muda en días. Sin trámites innecesarios, solo lo esencial.', 'twentytwentyfive-child'); ?></p>
        </div>
        <div class="benefit-card" data-animate>
          <div class="benefit-icon">📞</div>
          <h3 class="h3"><?php esc_html_e('Soporte siempre disponible', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('Estamos aquí 24/7 para resolver tus dudas. Respuestas rápidas, sin esperas.', 'twentytwentyfive-child'); ?></p>
        </div>
        <div class="benefit-card" data-animate>
          <div class="benefit-icon">💰</div>
          <h3 class="h3"><?php esc_html_e('Precios claros', 'twentytwentyfive-child'); ?></h3>
          <p class="p" style="margin:0;"><?php esc_html_e('Sin sorpresas. Todos los costos incluidos desde el inicio. Transparencia total.', 'twentytwentyfive-child'); ?></p>
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
            <span><?php esc_html_e('Comunícate directamente con el propietario. Resuelve tus dudas y negocia los términos.', 'twentytwentyfive-child'); ?></span>
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
        <h2 class="h2"><?php esc_html_e('¿Por qué elegir Arriendo Fácil?', 'twentytwentyfive-child'); ?></h2>
      </div>

      <div class="kv-grid">
        <div class="card" data-animate>
          <div class="card-icon">⚡</div>
          <h3><?php esc_html_e('Búsqueda rápida', 'twentytwentyfive-child'); ?></h3>
          <ul class="ul">
            <li><?php esc_html_e('Encuentra hogar en minutos, no semanas', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Notificaciones instantáneas de nuevas propiedades', 'twentytwentyfive-child'); ?></li>
            <li><?php esc_html_e('Contacta directamente con propietarios', 'twentytwentyfive-child'); ?></li>
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

</main>

<?php get_footer(); ?>
