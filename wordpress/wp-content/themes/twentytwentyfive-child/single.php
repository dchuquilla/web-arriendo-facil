<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content">
  <?php if (have_posts()) { while (have_posts()) { the_post(); ?>

  <?php
    $thumb_id = twentytwentyfive_child_get_property_thumbnail_id(get_the_ID());
    $main_img = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'af-banner') : '';
  ?>

  <!-- ========== PROPERTY HERO / GALLERY ========== -->
  <section class="property-detail-hero">
    <div class="container">
      <a href="<?php echo esc_url(home_url('/propiedades/')); ?>" class="back-link">
        ← <?php esc_html_e('Volver a propiedades', 'twentytwentyfive-child'); ?>
      </a>
    </div>

    <?php
      $post_id = get_the_ID();
      $gallery_images = twentytwentyfive_child_get_accommodation_gallery_images($post_id);
      $has_gallery = !empty($gallery_images);
    ?>

    <?php if ($has_gallery) : ?>
      <!-- Carousel with blur background -->
      <div id="single-property-carousel" class="property-gallery property-carousel" data-carousel-container>
        <!-- Blur background -->
        <div class="carousel-blur-bg" style="--image-url: url('<?php echo esc_attr($gallery_images[0]['url_small']); ?>')"></div>

        <!-- Main carousel slides -->
        <div class="carousel-main-wrapper">
          <div class="carousel-inner">
            <?php foreach ($gallery_images as $index => $image) : ?>
              <div class="carousel-slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-carousel-slide="<?php echo esc_attr($index); ?>">
                <img
                  src="<?php echo esc_url($image['url']); ?>"
                  alt="<?php echo esc_attr($image['alt'] ? $image['alt'] : get_the_title()); ?>"
                  class="carousel-image"
                  loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                >
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Navigation buttons -->
          <button class="carousel-nav carousel-nav--prev" data-carousel-prev aria-label="<?php esc_attr_e('Imagen anterior', 'twentytwentyfive-child'); ?>">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <button class="carousel-nav carousel-nav--next" data-carousel-next aria-label="<?php esc_attr_e('Siguiente imagen', 'twentytwentyfive-child'); ?>">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>

        <!-- Dots/indicators -->
        <div class="carousel-dots" data-carousel-dots aria-label="<?php esc_attr_e('Indicadores de imagen', 'twentytwentyfive-child'); ?>">
          <?php foreach ($gallery_images as $index => $image) : ?>
            <button
              class="dot-btn <?php echo $index === 0 ? 'is-active' : ''; ?>"
              data-carousel-dot="<?php echo esc_attr($index); ?>"
              aria-label="<?php echo esc_attr(sprintf(__('Imagen %d', 'twentytwentyfive-child'), $index + 1)); ?>"
              aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
            ></button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php elseif ($main_img) : ?>
      <!-- Single image (no carousel if < 2 images) -->
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
            $monthly_rent_raw = (string) get_post_meta($post_id, '_af_monthly_rent', true);
            $status_raw = (string) get_post_meta($post_id, '_af_status', true);
            $is_occupied = '1' === (string) get_post_meta($post_id, '_af_is_occupied', true);
            $amenities = get_post_meta($post_id, '_af_amenities', true);
            if (!is_array($amenities)) {
              $amenities = [];
            }
          ?>
          <?php if ($is_occupied) : ?>
            <div class="af-occupied-alert" role="alert" aria-live="polite">
              <?php esc_html_e('Esta acomodación está ocupada', 'twentytwentyfive-child'); ?>
            </div>
          <?php endif; ?>
          <!-- Title & Price -->
          <div class="property-header">
            <div>
              <h1 class="h1"><?php the_title(); ?></h1>
              <p class="property-location">
                📍 <?php echo $address ? esc_html($address) : esc_html_e('Ubicación no especificada', 'twentytwentyfive-child'); ?>
              </p>
              <div class="af-reserve-actions">
                <?php if ($is_occupied) : ?>
                  <button
                    type="button"
                    class="btn btn--primary"
                    disabled
                    aria-disabled="true"
                  >
                    <?php esc_html_e('NO DISPONIBLE - OCUPADA', 'twentytwentyfive-child'); ?>
                  </button>
                <?php else : ?>
                  <button
                    type="button"
                    class="btn btn--primary"
                    data-af-reserve-trigger
                    data-af-accommodation-id="<?php echo esc_attr((string) $post_id); ?>"
                    data-af-accommodation-title="<?php echo esc_attr(get_the_title()); ?>"
                    data-af-is-occupied="0"
                  >
                    <?php esc_html_e('Reservar', 'twentytwentyfive-child'); ?>
                  </button>
                <?php endif; ?>
              </div>
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

          <!-- Tab Navigation -->
          <?php
            $latitude = floatval(get_post_meta($post_id, '_af_latitude', true));
            $longitude = floatval(get_post_meta($post_id, '_af_longitude', true));
            $bedrooms = (int) get_post_meta($post_id, '_af_bedrooms', true);
            $bathrooms = (int) get_post_meta($post_id, '_af_bathrooms', true);
            $square_meters = floatval(get_post_meta($post_id, '_af_square_meters', true));
            $property_type = (string) get_post_meta($post_id, '_af_property_type', true);
            $open_map_url = '';
            if ($latitude && $longitude) {
              $open_map_url = sprintf(
                'https://www.google.com/maps/search/?api=1&query=%s',
                rawurlencode($latitude . ',' . $longitude)
              );
            }
          ?>
          <div class="property-tabs" role="tablist" aria-label="<?php esc_attr_e('Información de la propiedad', 'twentytwentyfive-child'); ?>">
            <button class="property-tab is-active" role="tab" aria-selected="true" aria-controls="tab-detalles" id="tab-btn-detalles" data-tab="detalles" type="button">
              <?php esc_html_e('Detalles', 'twentytwentyfive-child'); ?>
            </button>
            <button class="property-tab" role="tab" aria-selected="false" aria-controls="tab-caracteristicas" id="tab-btn-caracteristicas" data-tab="caracteristicas" type="button">
              <?php esc_html_e('Características', 'twentytwentyfive-child'); ?>
            </button>
            <button class="property-tab" role="tab" aria-selected="false" aria-controls="tab-ubicacion" id="tab-btn-ubicacion" data-tab="ubicacion" type="button">
              <?php esc_html_e('Ubicación', 'twentytwentyfive-child'); ?>
            </button>
            <span class="property-tab__indicator" aria-hidden="true"></span>
          </div>

          <!-- Tab Panels -->
          <div class="property-tab-panels">
            <!-- Tab 1: Detalles -->
            <div class="property-tab-panel is-active" role="tabpanel" id="tab-detalles" aria-labelledby="tab-btn-detalles">
              <div class="property-section">
                <h2 class="h3"><?php esc_html_e('Sobre esta propiedad', 'twentytwentyfive-child'); ?></h2>
                <div class="property-description">
                  <?php
                    $content = get_the_content();
                    $content = preg_replace('/<!-- wp:gallery.*?<!-- \/wp:gallery -->/s', '', $content);
                    $content = preg_replace(
                      '/<section[^>]*class=["\'][^"\']*af-accommodation-details[^"\']*["\'][^>]*>.*?<\/section>/is',
                      '',
                      (string) $content
                    );
                    $content = (string) apply_filters('the_content', $content);
                    $content = preg_replace(
                      '/<section[^>]*class=["\'][^"\']*af-accommodation-details[^"\']*["\'][^>]*>.*?<\/section>/is',
                      '',
                      $content
                    );
                    echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  ?>
                </div>
              </div>

              <?php
                $status_key = sanitize_key($status_raw);
                $status_labels = [
                  'available' => __('Disponible', 'twentytwentyfive-child'),
                  'reserved' => __('Reservado', 'twentytwentyfive-child'),
                  'rented' => __('Arrendado', 'twentytwentyfive-child'),
                  'private' => __('Privado', 'twentytwentyfive-child'),
                  'inactive' => __('Inactivo', 'twentytwentyfive-child'),
                  'maintenance' => __('En mantenimiento', 'twentytwentyfive-child'),
                  'draft' => __('Borrador', 'twentytwentyfive-child'),
                  'pending' => __('Pendiente', 'twentytwentyfive-child'),
                ];
                $display_status = $is_occupied
                  ? __('Ocupada', 'twentytwentyfive-child')
                  : ($status_labels[$status_key] ?? $status_raw);

                $details = [];
                if ('' !== trim($address)) {
                  $details[] = '<li><strong>' . esc_html__('Direccion:', 'twentytwentyfive-child') . '</strong> ' . esc_html($address) . '</li>';
                }
                if ($bedrooms > 0) {
                  $details[] = '<li><strong>' . esc_html__('Dormitorios:', 'twentytwentyfive-child') . '</strong> ' . esc_html((string) $bedrooms) . '</li>';
                }
                if ($bathrooms > 0) {
                  $details[] = '<li><strong>' . esc_html__('Banos:', 'twentytwentyfive-child') . '</strong> ' . esc_html((string) $bathrooms) . '</li>';
                }

                $monthly_rent_trimmed = trim($monthly_rent_raw);
                $monthly_rent_normalized = str_replace(',', '.', (string) preg_replace('/[^0-9,.-]/', '', $monthly_rent_trimmed));
                $show_monthly_rent = '' !== $monthly_rent_trimmed;

                if ('' !== $monthly_rent_normalized && is_numeric($monthly_rent_normalized) && (float) $monthly_rent_normalized <= 0) {
                  $show_monthly_rent = false;
                }

                if ($show_monthly_rent) {
                  $monthly_rent_display = $monthly_rent_trimmed;
                  if ('' !== $monthly_rent_normalized && is_numeric($monthly_rent_normalized)) {
                    $monthly_rent_display = '$' . number_format_i18n((float) $monthly_rent_normalized, 0);
                  }
                  $details[] = '<li><strong>' . esc_html__('Renta mensual:', 'twentytwentyfive-child') . '</strong> ' . esc_html($monthly_rent_display) . '</li>';
                }

                if ($is_occupied || '' !== trim($status_raw)) {
                  $details[] = '<li><strong>' . esc_html__('Estado:', 'twentytwentyfive-child') . '</strong> ' . esc_html($display_status) . '</li>';
                }
              ?>

              <?php if (!empty($details)) : ?>
                <div class="property-section" style="margin-top: var(--space-6);">
                  <h3 class="h3"><?php esc_html_e('Informacion del alojamiento', 'twentytwentyfive-child'); ?></h3>
                  <ul class="property-info-list">
                    <?php echo implode('', $details); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                  </ul>
                </div>
              <?php endif; ?>

              <!-- Stats Bar -->
              <div class="property-stats-bar">
                <?php if ($bedrooms > 0) : ?>
                  <div class="property-stat-chip"><span class="stat-icon">🛏️</span> <?php echo esc_html($bedrooms); ?> <?php esc_html_e('Habitaciones', 'twentytwentyfive-child'); ?></div>
                <?php endif; ?>
                <?php if ($bathrooms > 0) : ?>
                  <div class="property-stat-chip"><span class="stat-icon">🚿</span> <?php echo esc_html($bathrooms); ?> <?php esc_html_e('Baños', 'twentytwentyfive-child'); ?></div>
                <?php endif; ?>
                <?php if ($square_meters > 0) : ?>
                  <div class="property-stat-chip"><span class="stat-icon">📐</span> <?php echo esc_html(number_format_i18n($square_meters, 0)); ?> m²</div>
                <?php endif; ?>
                <?php if ($property_type) : ?>
                  <div class="property-stat-chip"><span class="stat-icon">🏠</span> <?php echo esc_html(ucfirst($property_type)); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <!-- Tab 2: Características -->
            <div class="property-tab-panel" role="tabpanel" id="tab-caracteristicas" aria-labelledby="tab-btn-caracteristicas" hidden>
              <?php if (!empty($amenities)) : ?>
                <div class="property-section">
                  <h3 class="h3"><?php esc_html_e('Servicios e instalaciones', 'twentytwentyfive-child'); ?></h3>
                  <div class="amenities-grid">
                    <?php foreach ($amenities as $amenity) : ?>
                      <div class="amenity">✓ <?php echo esc_html($amenity); ?></div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>

              <div class="property-section" style="margin-top: var(--space-6);">
                <h3 class="h3"><?php esc_html_e('Información importante', 'twentytwentyfive-child'); ?></h3>
                <div class="property-info-list">
                  <div class="property-info-item">
                    <span class="property-info-icon">📅</span>
                    <div>
                      <strong><?php esc_html_e('Disponibilidad', 'twentytwentyfive-child'); ?></strong>
                      <span><?php esc_html_e('Disponible ahora', 'twentytwentyfive-child'); ?></span>
                    </div>
                  </div>
                  <div class="property-info-item">
                    <span class="property-info-icon">📝</span>
                    <div>
                      <strong><?php esc_html_e('Contrato', 'twentytwentyfive-child'); ?></strong>
                      <span><?php esc_html_e('1 año mínimo', 'twentytwentyfive-child'); ?></span>
                    </div>
                  </div>
                  <div class="property-info-item">
                    <span class="property-info-icon">💰</span>
                    <div>
                      <strong><?php esc_html_e('Depósito', 'twentytwentyfive-child'); ?></strong>
                      <span><?php esc_html_e('2 meses de renta', 'twentytwentyfive-child'); ?></span>
                    </div>
                  </div>
                  <div class="property-info-item">
                    <span class="property-info-icon">🐾</span>
                    <div>
                      <strong><?php esc_html_e('Mascotas', 'twentytwentyfive-child'); ?></strong>
                       <span><?php echo in_array('pet-friendly', $amenities, true) ? esc_html__('Permitidas', 'twentytwentyfive-child') : esc_html__('No permitidas', 'twentytwentyfive-child'); ?></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="property-section" style="margin-top: var(--space-6);">
                <h3 class="h3">🛡️ <?php esc_html_e('Seguridad', 'twentytwentyfive-child'); ?></h3>
                <p class="property-security-note"><?php esc_html_e('Esta propiedad ha sido verificada por nuestro equipo. Inspección completada. Propietario validado.', 'twentytwentyfive-child'); ?></p>
              </div>
            </div>

            <!-- Tab 3: Ubicación -->
            <div class="property-tab-panel" role="tabpanel" id="tab-ubicacion" aria-labelledby="tab-btn-ubicacion" hidden>
              <?php if ($latitude && $longitude) : ?>
                <div id="property-map" class="property-map"
                     data-lat="<?php echo esc_attr($latitude); ?>"
                     data-lng="<?php echo esc_attr($longitude); ?>">
                </div>
                <?php if ($address) : ?>
                  <p class="property-map-address">📍 <?php echo esc_html($address); ?></p>
                <?php endif; ?>
                <?php if ($open_map_url) : ?>
                  <div class="property-map-actions">
                    <a href="<?php echo esc_url($open_map_url); ?>" class="property-map-open-link" target="_blank" rel="noopener noreferrer">
                      <?php esc_html_e('Abrir ubicacion en otra pestaña', 'twentytwentyfive-child'); ?>
                    </a>
                  </div>
                <?php endif; ?>
              <?php else : ?>
                <div class="property-map-empty">
                  <p><?php esc_html_e('Ubicación no disponible para esta propiedad.', 'twentytwentyfive-child'); ?></p>
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>

      <!-- Amenities removed - now inside tabs -->
    </div>
  </section>

  <!-- ========== SIMILAR PROPERTIES ========== -->
  <section class="section section--soft section--single-related">
    <div class="container">
      <h2 class="h2"><?php esc_html_e('Propiedades similares', 'twentytwentyfive-child'); ?></h2>
      <p class="p text-secondary"><?php esc_html_e('Opciones relacionadas para comparar y tomar una mejor decision', 'twentytwentyfive-child'); ?></p>
      <div class="properties-grid">
        <?php
          $max_related = wp_is_mobile() ? 4 : 6;
          $current_id = get_the_ID();
          $current_city = (string) get_post_meta($current_id, '_af_city', true);
          $current_location = (string) get_post_meta($current_id, '_af_location_text', true);

          $base_meta_query = [
            'relation' => 'AND',
            [
              'relation' => 'OR',
              [
                'key' => '_af_status',
                'compare' => 'NOT EXISTS',
              ],
              [
                'key' => '_af_status',
                'value' => ['inactive', 'maintenance'],
                'compare' => 'NOT IN',
              ],
            ],
            [
              'relation' => 'OR',
              [
                'key' => '_af_commercial_visibility',
                'compare' => 'NOT EXISTS',
              ],
              [
                'key' => '_af_commercial_visibility',
                'value' => 'private',
                'compare' => '!=',
              ],
            ],
            [
              'relation' => 'OR',
              [
                'key' => '_af_is_occupied',
                'compare' => 'NOT EXISTS',
              ],
              [
                'key' => '_af_is_occupied',
                'value' => '1',
                'compare' => '!=',
              ],
            ],
          ];

          $primary_meta_query = $base_meta_query;

          if ($property_type !== '') {
            $primary_meta_query[] = [
              'key' => '_af_property_type',
              'value' => $property_type,
              'compare' => '=',
            ];
          }

          if ($current_city !== '') {
            $primary_meta_query[] = [
              'key' => '_af_city',
              'value' => $current_city,
              'compare' => '=',
            ];
          } elseif ($current_location !== '') {
            $primary_meta_query[] = [
              'key' => '_af_location_text',
              'value' => $current_location,
              'compare' => 'LIKE',
            ];
          }

          if ($monthly_rent > 0) {
            $min_similar_rent = max(0, $monthly_rent * 0.75);
            $max_similar_rent = $monthly_rent * 1.25;
            $primary_meta_query[] = [
              'key' => '_af_monthly_rent',
              'value' => $min_similar_rent,
              'type' => 'NUMERIC',
              'compare' => '>=',
            ];
            $primary_meta_query[] = [
              'key' => '_af_monthly_rent',
              'value' => $max_similar_rent,
              'type' => 'NUMERIC',
              'compare' => '<=',
            ];
          }

          $related_ids = [];

          $primary_related = new WP_Query([
            'post_type' => 'accommodation',
            'post_status' => 'publish',
            'posts_per_page' => $max_related,
            'post__not_in' => [$current_id],
            'meta_query' => $primary_meta_query,
            'orderby' => 'date',
            'order' => 'DESC',
            'fields' => 'ids',
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
          ]);

          if (!empty($primary_related->posts)) {
            $related_ids = $primary_related->posts;
          }

          if (count($related_ids) < $max_related) {
            $fallback_meta_query = $base_meta_query;

            if ($property_type !== '') {
              $fallback_meta_query[] = [
                'key' => '_af_property_type',
                'value' => $property_type,
                'compare' => '=',
              ];
            }

            $fallback_related = new WP_Query([
              'post_type' => 'accommodation',
              'post_status' => 'publish',
              'posts_per_page' => $max_related - count($related_ids),
              'post__not_in' => array_merge([$current_id], $related_ids),
              'meta_query' => $fallback_meta_query,
              'orderby' => 'date',
              'order' => 'DESC',
              'fields' => 'ids',
              'no_found_rows' => true,
              'ignore_sticky_posts' => true,
              'update_post_meta_cache' => false,
              'update_post_term_cache' => false,
            ]);

            if (!empty($fallback_related->posts)) {
              $related_ids = array_merge($related_ids, $fallback_related->posts);
            }
          }

          if (!empty($related_ids)) {
            foreach ($related_ids as $id) {
              $permalink = get_permalink($id);
              if (!$permalink) {
                continue;
              }

              $is_related_occupied = '1' === (string) get_post_meta($id, '_af_is_occupied', true);

              $thumb_id = twentytwentyfive_child_get_property_thumbnail_id($id);
              $img = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'af-card') : '';
              if (!$img) {
                $img = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg';
              }

              $related_location = (string) get_post_meta($id, '_af_location_text', true);
              if ($related_location === '') {
                $related_location = (string) get_post_meta($id, '_af_address', true);
              }

              $related_rent = floatval(get_post_meta($id, '_af_monthly_rent', true));
              $price_display = $related_rent > 0 ? '$' . number_format_i18n($related_rent, 0) : esc_html__('Consultar', 'twentytwentyfive-child');
              $related_title = get_the_title($id);
        ?>
          <a href="<?php echo esc_url($permalink); ?>" class="property-card<?php echo $is_related_occupied ? ' af-featured-accommodation--occupied af-occupied-accommodation--occupied' : ''; ?>" data-animate>
            <div class="property-image">
              <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($related_title); ?>" loading="lazy">
              <?php if ($is_related_occupied) : ?>
                <div class="af-occupied-overlay">
                  <span class="af-occupied-badge"><?php esc_html_e('Ocupada', 'twentytwentyfive-child'); ?></span>
                </div>
              <?php endif; ?>
              <span class="property-badge"><?php esc_html_e('Verificado', 'twentytwentyfive-child'); ?></span>
            </div>
            <div class="property-info">
              <h3 class="property-title"><?php echo esc_html($related_title); ?></h3>
              <p class="property-location">📍 <?php echo $related_location ? esc_html($related_location) : esc_html__('Ubicación no especificada', 'twentytwentyfive-child'); ?></p>
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
          }
        ?>
      </div>
      <div class="section-actions" style="margin-top: var(--space-6); text-align: center;">
        <a href="<?php echo esc_url(home_url('/propiedades/')); ?>" class="btn btn--outline">
          <?php esc_html_e('Ver todas las acomodaciones', 'twentytwentyfive-child'); ?>
        </a>
      </div>
    </div>
  </section>

  <?php } } // end while/if have_posts ?>

</main>

<?php get_footer(); ?>