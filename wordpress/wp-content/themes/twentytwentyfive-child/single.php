<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content">
  <?php if (have_posts()) { while (have_posts()) { the_post(); ?>

  <?php $main_img = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>

  <!-- ========== PROPERTY HERO / GALLERY ========== -->
  <section class="property-detail-hero">
    <div class="container">
      <a href="<?php echo esc_url(home_url('/propiedades/')); ?>" class="back-link">
        ← <?php esc_html_e('Volver a propiedades', 'twentytwentyfive-child'); ?>
      </a>
    </div>

    <?php if ($main_img) : ?>
      <div class="property-gallery">
        <img src="<?php echo esc_url($main_img); ?>" alt="<?php the_title_attribute(); ?>" class="gallery-main" loading="lazy">
      </div>
    <?php endif; ?>
  </section>

  <!-- ========== PROPERTY DETAILS ========== -->
  <section class="section section--single-detail<?php echo $main_img ? '' : ' section--single-detail-no-hero'; ?>">
    <div class="container">
      <div class="property-detail-grid property-detail-grid--single">
        <!-- Main Info -->
        <div class="property-main">
          <?php
            $post_id = get_the_ID();
            $address = (string) get_post_meta($post_id, '_af_address', true);
            $monthly_rent = floatval(get_post_meta($post_id, '_af_monthly_rent', true));
            $amenities = get_post_meta($post_id, '_af_amenities', true);
            if (!is_array($amenities)) {
              $amenities = [];
            }
          ?>
          <!-- Title & Price -->
          <div class="property-header">
            <div>
              <h1 class="h1"><?php the_title(); ?></h1>
              <p class="property-location">
                📍 <?php echo $address ? esc_html($address) : esc_html_e('Ubicación no especificada', 'twentytwentyfive-child'); ?>
              </p>
            </div>
            <div class="property-header-price">
              <span class="price-label"><?php esc_html_e('Precio mensual', 'twentytwentyfive-child'); ?></span>
              <span class="price-value">
                <?php echo $monthly_rent > 0 ? '$' . esc_html(number_format_i18n($monthly_rent, 0)) : esc_html_e('Consultar', 'twentytwentyfive-child'); ?>
              </span>
            </div>
          </div>

          <!-- Badges & Tags -->
          <div class="property-tags">
            <span class="badge badge--feature"><?php esc_html_e('Verificado', 'twentytwentyfive-child'); ?></span>
            <?php foreach ($amenities as $amenity) : ?>
              <span class="tag">✓ <?php echo esc_html($amenity); ?></span>
            <?php endforeach; ?>
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
              <?php
                $bedrooms = (int) get_post_meta($post_id, '_af_bedrooms', true);
                $bathrooms = (int) get_post_meta($post_id, '_af_bathrooms', true);
                $square_meters = floatval(get_post_meta($post_id, '_af_square_meters', true));
                $property_type = (string) get_post_meta($post_id, '_af_property_type', true);
              ?>
              <?php if ($bedrooms > 0) : ?>
                <div class="feature-item">
                  <span class="feature-icon">🛏️</span>
                  <div>
                    <h4><?php esc_html_e('Habitaciones', 'twentytwentyfive-child'); ?></h4>
                    <p><?php echo esc_html($bedrooms); ?></p>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($bathrooms > 0) : ?>
                <div class="feature-item">
                  <span class="feature-icon">🚿</span>
                  <div>
                    <h4><?php esc_html_e('Baños', 'twentytwentyfive-child'); ?></h4>
                    <p><?php echo esc_html($bathrooms); ?></p>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($square_meters > 0) : ?>
                <div class="feature-item">
                  <span class="feature-icon">📐</span>
                  <div>
                    <h4><?php esc_html_e('Tamaño', 'twentytwentyfive-child'); ?></h4>
                    <p><?php echo esc_html(number_format_i18n($square_meters, 0)); ?> m²</p>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($property_type) : ?>
                <div class="feature-item">
                  <span class="feature-icon">🌳</span>
                  <div>
                    <h4><?php esc_html_e('Tipo de propiedad', 'twentytwentyfive-child'); ?></h4>
                    <p><?php echo esc_html($property_type); ?></p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>

      <div class="property-secondary-full">
        <!-- Amenities -->
        <?php if (!empty($amenities)) : ?>
          <div class="property-section property-section--amenities">
            <h2 class="h3"><?php esc_html_e('Servicios e instalaciones', 'twentytwentyfive-child'); ?></h2>
            <div class="amenities-grid">
              <?php foreach ($amenities as $amenity) : ?>
                <div class="amenity">✓ <?php echo esc_html($amenity); ?></div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

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
              $related_location = (string) get_post_meta($id, '_af_location_text', true);
              $related_rent = floatval(get_post_meta($id, '_af_monthly_rent', true));
              $price_display = $related_rent > 0 ? '$' . number_format_i18n($related_rent, 0) : esc_html__('Consultar', 'twentytwentyfive-child');
        ?>
          <a href="<?php echo esc_url(get_permalink()); ?>" class="property-card" data-animate>
            <div class="property-image">
              <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
              <span class="property-badge"><?php esc_html_e('Verificado', 'twentytwentyfive-child'); ?></span>
            </div>
            <div class="property-info">
              <h3 class="property-title"><?php the_title(); ?></h3>
              <p class="property-location">📍 <?php echo $related_location ? esc_html($related_location) : esc_html_e('Ubicación no especificada', 'twentytwentyfive-child'); ?></p>
              <div class="property-meta">
                <div class="property-price">
                  <span class="price-label"><?php esc_html_e('Desde', 'twentytwentyfive-child'); ?></span>
                  <span class="price-value"><?php echo esc_html($price_display); ?><span class="price-period">/mes</span></span>
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