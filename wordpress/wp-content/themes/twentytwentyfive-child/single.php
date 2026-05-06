<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content">
  <?php if (have_posts()) { while (have_posts()) { the_post(); ?>

  <!-- ========== PROPERTY HERO / GALLERY ========== -->
  <section class="property-detail-hero">
    <div class="container">
      <a href="<?php echo esc_url(home_url('/propiedades/')); ?>" class="back-link">
        ← <?php esc_html_e('Volver a propiedades', 'twentytwentyfive-child'); ?>
      </a>
    </div>

    <div class="property-gallery">
      <?php
        $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if (!$img) {
          $img = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg';
        }
      ?>
      <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" class="gallery-main" loading="lazy">
    </div>
  </section>

  <!-- ========== PROPERTY DETAILS ========== -->
  <section class="section section--single-detail">
    <div class="container">
      <div class="property-detail-grid property-detail-grid--single">
        <!-- Main Info -->
        <div class="property-main">
          <!-- Title & Price -->
          <div class="property-header">
            <div>
              <h1 class="h1"><?php the_title(); ?></h1>
              <p class="property-location">
                📍 <?php esc_html_e('Ubicación en la ciudad', 'twentytwentyfive-child'); ?>
              </p>
            </div>
            <div class="property-header-price">
              <span class="price-label"><?php esc_html_e('Precio por noche', 'twentytwentyfive-child'); ?></span>
              <span class="price-value">$1,200</span>
            </div>
          </div>

          <!-- Badges & Tags -->
          <div class="property-tags">
            <span class="badge badge--feature"><?php esc_html_e('Verificado', 'twentytwentyfive-child'); ?></span>
            <span class="tag">📶 WiFi</span>
            <span class="tag">🏠 Amigable con mascotas</span>
            <span class="tag">🍳 Cocina completa</span>
          </div>

          <!-- Description -->
          <div class="property-section">
            <h2 class="h3"><?php esc_html_e('Sobre esta propiedad', 'twentytwentyfive-child'); ?></h2>
            <div class="property-description">
              <?php the_content(); ?>
            </div>
          </div>

          <!-- Primary Actions & Info -->
          <div class="property-priority-cards">
            <div class="card cta-card">
              <h3><?php esc_html_e('¿Interesado?', 'twentytwentyfive-child'); ?></h3>
              <p class="small"><?php esc_html_e('Contáctate directamente con el propietario para más detalles.', 'twentytwentyfive-child'); ?></p>
              <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary btn--block">
                <?php esc_html_e('Contactar propietario', 'twentytwentyfive-child'); ?>
              </a>
            </div>

            <div class="card info-card">
              <h4><?php esc_html_e('Información importante', 'twentytwentyfive-child'); ?></h4>
              <ul class="small">
                <li><?php esc_html_e('Disponible desde: Enero 2025', 'twentytwentyfive-child'); ?></li>
                <li><?php esc_html_e('Contrato: 6 meses mínimo', 'twentytwentyfive-child'); ?></li>
                <li><?php esc_html_e('Depósito: 2 meses de renta', 'twentytwentyfive-child'); ?></li>
                <li><?php esc_html_e('Mascotas: Permitidas', 'twentytwentyfive-child'); ?></li>
              </ul>
            </div>
          </div>

          <!-- Features Grid -->
          <div class="property-section">
            <h2 class="h3"><?php esc_html_e('Características', 'twentytwentyfive-child'); ?></h2>
            <div class="features-grid">
              <div class="feature-item">
                <span class="feature-icon">🛏️</span>
                <div>
                  <h4><?php esc_html_e('Habitaciones', 'twentytwentyfive-child'); ?></h4>
                  <p>2</p>
                </div>
              </div>
              <div class="feature-item">
                <span class="feature-icon">🚿</span>
                <div>
                  <h4><?php esc_html_e('Baños', 'twentytwentyfive-child'); ?></h4>
                  <p>1</p>
                </div>
              </div>
              <div class="feature-item">
                <span class="feature-icon">📐</span>
                <div>
                  <h4><?php esc_html_e('Tamaño', 'twentytwentyfive-child'); ?></h4>
                  <p>80 m²</p>
                </div>
              </div>
              <div class="feature-item">
                <span class="feature-icon">🌳</span>
                <div>
                  <h4><?php esc_html_e('Zona', 'twentytwentyfive-child'); ?></h4>
                  <p><?php esc_html_e('Residencial', 'twentytwentyfive-child'); ?></p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="property-secondary-full">
        <!-- Amenities -->
        <div class="property-section property-section--amenities">
          <h2 class="h3"><?php esc_html_e('Servicios e instalaciones', 'twentytwentyfive-child'); ?></h2>
          <div class="amenities-grid">
            <div class="amenity">✓ <?php esc_html_e('Aire acondicionado', 'twentytwentyfive-child'); ?></div>
            <div class="amenity">✓ <?php esc_html_e('Calefacción', 'twentytwentyfive-child'); ?></div>
            <div class="amenity">✓ <?php esc_html_e('Lavadora', 'twentytwentyfive-child'); ?></div>
            <div class="amenity">✓ <?php esc_html_e('Garaje', 'twentytwentyfive-child'); ?></div>
            <div class="amenity">✓ <?php esc_html_e('Piscina', 'twentytwentyfive-child'); ?></div>
            <div class="amenity">✓ <?php esc_html_e('Área de juegos', 'twentytwentyfive-child'); ?></div>
          </div>
        </div>

        <!-- Safety Info -->
        <div class="property-section safety-section">
          <h2 class="h3">🛡️ <?php esc_html_e('Seguridad de la propiedad', 'twentytwentyfive-child'); ?></h2>
          <p><?php esc_html_e('Esta propiedad ha sido verificada por nuestro equipo. Inspección de seguridad completada. Propietario validado.', 'twentytwentyfive-child'); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== SIMILAR PROPERTIES ========== -->
  <section class="section section--soft section--single-related">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('Propiedades similares', 'twentytwentyfive-child'); ?></h2>
      <div class="properties-grid">
        <?php
          $related = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'exclude'        => get_the_ID(),
            'category_name'  => 'propiedades-destacadas',
            'no_found_rows'  => true,
            'ignore_sticky_posts' => true,
            'update_post_term_cache' => false,
          ]);

          if ($related->have_posts()) {
            while ($related->have_posts()) { $related->the_post();
              $id = get_the_ID();
              $img = get_the_post_thumbnail_url($id, 'large');
              if (!$img) {
                $img = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg';
              }
        ?>
          <a href="<?php echo esc_url(get_permalink()); ?>" class="property-card" data-animate>
            <div class="property-image">
              <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
              <span class="property-badge"><?php esc_html_e('Verificado', 'twentytwentyfive-child'); ?></span>
            </div>
            <div class="property-info">
              <h3 class="property-title"><?php the_title(); ?></h3>
              <p class="property-location">📍 Ubicación</p>
              <div class="property-meta">
                <div class="property-price">
                  <span class="price-label"><?php esc_html_e('Desde', 'twentytwentyfive-child'); ?></span>
                  <span class="price-value">$950<span class="price-period">/mes</span></span>
                </div>
              </div>
            </div>
          </a>
        <?php
            }
            wp_reset_postdata();
          }
        ?>
      </div>
    </div>
  </section>

  <!-- ========== FINAL CTA ========== -->
  <section class="section section--single-final-cta" id="single-final-cta">
    <div class="container text-center">
      <h2 class="h2"><?php esc_html_e('¿Listo para dar el próximo paso?', 'twentytwentyfive-child'); ?></h2>
      <p class="p mx-auto"><?php esc_html_e('Nuestro equipo está aquí para ayudarte con cualquier pregunta sobre esta propiedad o para encontrar otras opciones.', 'twentytwentyfive-child'); ?></p>
      <div class="single-cta-actions">
        <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary btn--lg">
          <?php esc_html_e('Contactar soporte', 'twentytwentyfive-child'); ?>
        </a>
        <a href="<?php echo esc_url(home_url('/propiedades/')); ?>" class="btn btn--outline btn--lg">
          <?php esc_html_e('Ver más propiedades', 'twentytwentyfive-child'); ?>
        </a>
      </div>
    </div>
  </section>

  <?php } } // end while/if have_posts ?>

</main>

<?php get_footer(); ?>