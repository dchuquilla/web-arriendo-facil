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
      <div class="property-detail-grid property-detail-grid--single property-detail-grid--with-sidebar">
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

          <!-- Tab Navigation -->
          <?php
            $latitude = floatval(get_post_meta($post_id, '_af_latitude', true));
            $longitude = floatval(get_post_meta($post_id, '_af_longitude', true));
            $bedrooms = (int) get_post_meta($post_id, '_af_bedrooms', true);
            $bathrooms = (int) get_post_meta($post_id, '_af_bathrooms', true);
            $square_meters = floatval(get_post_meta($post_id, '_af_square_meters', true));
            $property_type = (string) get_post_meta($post_id, '_af_property_type', true);
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
                    echo apply_filters('the_content', $content);
                  ?>
                </div>
              </div>

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
                      <span><?php echo in_array('pet-friendly', $amenities) ? esc_html_e('Permitidas', 'twentytwentyfive-child') : esc_html_e('No permitidas', 'twentytwentyfive-child'); ?></span>
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
              <?php else : ?>
                <div class="property-map-empty">
                  <p><?php esc_html_e('Ubicación no disponible para esta propiedad.', 'twentytwentyfive-child'); ?></p>
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>

        <!-- ========== BOOKING SIDEBAR ========== -->
        <aside class="property-booking-sidebar" aria-label="<?php esc_attr_e('Reservar visita o unirse a lista de espera', 'twentytwentyfive-child'); ?>">

          <?php
            $avail_accommodation_id = get_the_ID();
            $af_commercial_status   = (string) get_post_meta( $avail_accommodation_id, '_af_commercial_status', true );
            $af_is_status_public    = in_array( $af_commercial_status, [ 'available', '', 'published' ], true );
          ?>

          <!-- Status Badge -->
          <div id="af-booking-status-badge" class="af-booking-badge
            <?php
              switch ( $af_commercial_status ) {
                case 'rented':    echo 'af-booking-badge--rented';    break;
                case 'reserved':  echo 'af-booking-badge--reserved';  break;
                case 'private':   echo 'af-booking-badge--private';   break;
                default:          echo 'af-booking-badge--available'; break;
              }
            ?>
          ">
            <?php
              switch ( $af_commercial_status ) {
                case 'rented':    esc_html_e( 'Actualmente rentado', 'twentytwentyfive-child' );  break;
                case 'reserved':  esc_html_e( 'Reservado — con abono', 'twentytwentyfive-child' ); break;
                case 'private':   esc_html_e( 'No disponible', 'twentytwentyfive-child' );         break;
                default:          esc_html_e( 'Disponible', 'twentytwentyfive-child' );            break;
              }
            ?>
          </div>

          <!-- Loading state -->
          <div id="af-booking-loading" class="af-booking-section" hidden>
            <span class="af-booking-spinner" aria-label="<?php esc_attr_e('Verificando disponibilidad…', 'twentytwentyfive-child'); ?>"></span>
            <p><?php esc_html_e('Verificando disponibilidad…', 'twentytwentyfive-child'); ?></p>
          </div>

          <!-- Visit Slots (shown when available & slots exist) -->
          <div id="af-booking-slots-section" class="af-booking-section" hidden>
            <h3 class="af-booking-heading"><?php esc_html_e('Agendar visita', 'twentytwentyfive-child'); ?></h3>
            <p class="af-booking-hint"><?php esc_html_e('Elige un horario disponible para conocer la propiedad.', 'twentytwentyfive-child'); ?></p>
            <div id="af-booking-slots-list" class="af-slots-list" role="list"></div>

            <!-- Slot booking form (hidden until slot selected) -->
            <form id="af-visit-form" class="af-booking-form" hidden novalidate>
              <input type="hidden" id="af-visit-slot-id" name="slot_id" value="">
              <div id="af-visit-slot-label" class="af-selected-slot-label"></div>

              <div class="af-form-row">
                <label for="af-visit-name"><?php esc_html_e('Nombre completo', 'twentytwentyfive-child'); ?> *</label>
                <input type="text" id="af-visit-name" name="guest_name" required minlength="3" maxlength="100"
                       placeholder="<?php esc_attr_e('Tu nombre', 'twentytwentyfive-child'); ?>">
              </div>
              <div class="af-form-row">
                <label for="af-visit-email"><?php esc_html_e('Correo electrónico', 'twentytwentyfive-child'); ?> *</label>
                <input type="email" id="af-visit-email" name="guest_email" required maxlength="150"
                       placeholder="<?php esc_attr_e('correo@ejemplo.com', 'twentytwentyfive-child'); ?>">
              </div>
              <div class="af-form-row">
                <label for="af-visit-phone"><?php esc_html_e('Teléfono (opcional)', 'twentytwentyfive-child'); ?></label>
                <input type="tel" id="af-visit-phone" name="guest_phone" maxlength="15"
                       placeholder="<?php esc_attr_e('10 dígitos', 'twentytwentyfive-child'); ?>">
              </div>
              <div class="af-form-row">
                <label for="af-visit-notes"><?php esc_html_e('Notas (opcional)', 'twentytwentyfive-child'); ?></label>
                <textarea id="af-visit-notes" name="notes" rows="2" maxlength="300"
                          placeholder="<?php esc_attr_e('Preguntas o comentarios…', 'twentytwentyfive-child'); ?>"></textarea>
              </div>
              <div id="af-visit-feedback" class="af-booking-feedback" role="alert" aria-live="polite"></div>
              <button type="submit" id="af-visit-submit" class="btn btn--primary btn--full">
                <?php esc_html_e('Confirmar visita', 'twentytwentyfive-child'); ?>
              </button>
              <button type="button" id="af-visit-cancel" class="btn btn--ghost btn--full" style="margin-top:.5rem">
                <?php esc_html_e('Cancelar', 'twentytwentyfive-child'); ?>
              </button>
            </form>
          </div>

          <!-- Interest Queue (shown when not available OR no slots left) -->
          <div id="af-booking-queue-section" class="af-booking-section" hidden>
            <h3 class="af-booking-heading"><?php esc_html_e('Unirse a lista de espera', 'twentytwentyfive-child'); ?></h3>
            <p class="af-booking-hint"><?php esc_html_e('Te avisamos cuando esta propiedad quede disponible.', 'twentytwentyfive-child'); ?></p>
            <form id="af-queue-form" class="af-booking-form" novalidate>
              <div class="af-form-row">
                <label for="af-queue-name"><?php esc_html_e('Nombre completo', 'twentytwentyfive-child'); ?> *</label>
                <input type="text" id="af-queue-name" name="name" required minlength="3" maxlength="100"
                       placeholder="<?php esc_attr_e('Tu nombre', 'twentytwentyfive-child'); ?>">
              </div>
              <div class="af-form-row">
                <label for="af-queue-email"><?php esc_html_e('Correo electrónico', 'twentytwentyfive-child'); ?> *</label>
                <input type="email" id="af-queue-email" name="email" required maxlength="150"
                       placeholder="<?php esc_attr_e('correo@ejemplo.com', 'twentytwentyfive-child'); ?>">
              </div>
              <div class="af-form-row">
                <label for="af-queue-phone"><?php esc_html_e('Teléfono (opcional)', 'twentytwentyfive-child'); ?></label>
                <input type="tel" id="af-queue-phone" name="phone" maxlength="15"
                       placeholder="<?php esc_attr_e('10 dígitos', 'twentytwentyfive-child'); ?>">
              </div>
              <div class="af-form-row">
                <label for="af-queue-message"><?php esc_html_e('Mensaje (opcional)', 'twentytwentyfive-child'); ?></label>
                <textarea id="af-queue-message" name="message" rows="2" maxlength="300"
                          placeholder="<?php esc_attr_e('¿Por qué te interesa esta propiedad?', 'twentytwentyfive-child'); ?>"></textarea>
              </div>
              <div id="af-queue-feedback" class="af-booking-feedback" role="alert" aria-live="polite"></div>
              <button type="submit" id="af-queue-submit" class="btn btn--primary btn--full">
                <?php esc_html_e('Unirme a lista de espera', 'twentytwentyfive-child'); ?>
              </button>
            </form>
          </div>

          <!-- Error state -->
          <div id="af-booking-error" class="af-booking-section af-booking-feedback--error" hidden role="alert"></div>

        </aside>
        <!-- /BOOKING SIDEBAR -->

      <!-- Amenities removed - now inside tabs -->
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

  <?php } } // end while/if have_posts ?>

</main>

<?php get_footer(); ?>