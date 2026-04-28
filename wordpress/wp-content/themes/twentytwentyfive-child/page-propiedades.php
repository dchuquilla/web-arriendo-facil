<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content">
  <!-- ========== HERO / SEARCH ========== -->
  <section class="properties-hero">
    <div class="container">
      <div class="properties-hero-content" data-animate>
        <h1 class="h1"><?php esc_html_e('Encuentra tu próximo hogar', 'twentytwentyfive-child'); ?></h1>
        <p class="p"><?php esc_html_e('Explora cientos de propiedades verificadas en tu ciudad.', 'twentytwentyfive-child'); ?></p>

        <!-- Search Form -->
        <form class="search-form" method="get" action="">
          <div class="search-inputs">
            <div class="form-group">
              <label for="location"><?php esc_html_e('Ubicación', 'twentytwentyfive-child'); ?></label>
              <input
                type="text"
                id="location"
                name="location"
                placeholder="<?php esc_attr_e('Ciudad o barrio', 'twentytwentyfive-child'); ?>"
                value="<?php echo isset($_GET['location']) ? esc_attr($_GET['location']) : ''; ?>"
              >
            </div>

            <div class="form-group">
              <label for="price-min"><?php esc_html_e('Presupuesto mín.', 'twentytwentyfive-child'); ?></label>
              <input
                type="number"
                id="price-min"
                name="price_min"
                placeholder="<?php esc_attr_e('$0', 'twentytwentyfive-child'); ?>"
                value="<?php echo isset($_GET['price_min']) ? esc_attr($_GET['price_min']) : ''; ?>"
              >
            </div>

            <div class="form-group">
              <label for="price-max"><?php esc_html_e('Presupuesto máx.', 'twentytwentyfive-child'); ?></label>
              <input
                type="number"
                id="price-max"
                name="price_max"
                placeholder="<?php esc_attr_e('$5000', 'twentytwentyfive-child'); ?>"
                value="<?php echo isset($_GET['price_max']) ? esc_attr($_GET['price_max']) : ''; ?>"
              >
            </div>

            <div class="form-group">
              <label for="property-type"><?php esc_html_e('Tipo de propiedad', 'twentytwentyfive-child'); ?></label>
              <select id="property-type" name="property_type">
                <option value=""><?php esc_html_e('Todos', 'twentytwentyfive-child'); ?></option>
                <option value="apartment" <?php selected($_GET['property_type'] ?? '', 'apartment'); ?>>
                  <?php esc_html_e('Apartamento', 'twentytwentyfive-child'); ?>
                </option>
                <option value="house" <?php selected($_GET['property_type'] ?? '', 'house'); ?>>
                  <?php esc_html_e('Casa', 'twentytwentyfive-child'); ?>
                </option>
                <option value="room" <?php selected($_GET['property_type'] ?? '', 'room'); ?>>
                  <?php esc_html_e('Habitación', 'twentytwentyfive-child'); ?>
                </option>
              </select>
            </div>

            <button type="submit" class="btn btn--primary">
              <?php esc_html_e('Buscar', 'twentytwentyfive-child'); ?>
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- ========== PROPERTIES GRID ========== -->
  <section class="section">
    <div class="container">
      <div class="properties-header">
        <div>
          <h2 class="h2"><?php esc_html_e('Propiedades disponibles', 'twentytwentyfive-child'); ?></h2>
          <p class="p text-secondary"><?php esc_html_e('Mostrando propiedades verificadas y listas para ocupar', 'twentytwentyfive-child'); ?></p>
        </div>

        <div class="sort-controls">
          <label for="sort"><?php esc_html_e('Ordenar por:', 'twentytwentyfive-child'); ?></label>
          <select id="sort" name="sort" class="sort-select">
            <option value="newest"><?php esc_html_e('Más recientes', 'twentytwentyfive-child'); ?></option>
            <option value="price-asc"><?php esc_html_e('Precio: menor a mayor', 'twentytwentyfive-child'); ?></option>
            <option value="price-desc"><?php esc_html_e('Precio: mayor a menor', 'twentytwentyfive-child'); ?></option>
          </select>
        </div>
      </div>

      <!-- Properties Grid -->
      <div class="properties-grid">
        <?php
          // Query featured properties for now (placeholder)
          $q = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 12,
            'post_status'    => 'publish',
            'category_name'  => 'propiedades-destacadas',
            'orderby'        => 'date',
            'order'          => 'DESC',
          ]);

          if ($q->have_posts()) {
            while ($q->have_posts()) { $q->the_post();
              $id = get_the_ID();
              $img = get_the_post_thumbnail_url($id, 'large');
              if (!$img) {
                $img = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-full-placeholder.jpg';
              }

              $thumb_id  = get_post_thumbnail_id($id);
              $thumb_alt = $thumb_id ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : '';
              $img_alt   = $thumb_alt ? $thumb_alt : get_the_title();
        ?>
          <a href="<?php echo esc_url(get_permalink()); ?>" class="property-card" data-animate>
            <div class="property-image">
              <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy">
              <span class="property-badge"><?php esc_html_e('Verificado', 'twentytwentyfive-child'); ?></span>
            </div>
            <div class="property-info">
              <h3 class="property-title"><?php the_title(); ?></h3>
              <p class="property-location">📍 <?php esc_html_e('Ubicación', 'twentytwentyfive-child'); ?></p>
              <div class="property-meta">
                <div class="property-price">
                  <span class="price-label"><?php esc_html_e('Desde', 'twentytwentyfive-child'); ?></span>
                  <span class="price-value">$1,200<span class="price-period">/mes</span></span>
                </div>
                <button type="button" class="btn btn--small btn--outline">
                  <?php esc_html_e('Ver detalles', 'twentytwentyfive-child'); ?>
                </button>
              </div>
            </div>
          </a>
        <?php
            }
            wp_reset_postdata();
          } else {
            echo '<div class="no-properties"><p>' . esc_html_e('No hay propiedades disponibles en este momento.', 'twentytwentyfive-child') . '</p></div>';
          }
        ?>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <?php
          // Simple pagination placeholder
          echo '<span class="page-info">' . esc_html_e('Página 1 de 5', 'twentytwentyfive-child') . '</span>';
        ?>
      </div>
    </div>
  </section>

  <!-- ========== CTA ========== -->
  <section class="section section--soft">
    <div class="container text-center">
      <h2 class="h2"><?php esc_html_e('¿No encontraste lo que buscas?', 'twentytwentyfive-child'); ?></h2>
      <p class="p mx-auto"><?php esc_html_e('Nuestro equipo puede ayudarte a encontrar la propiedad ideal. Contáctanos hoy.', 'twentytwentyfive-child'); ?></p>
      <a href="<?php echo esc_url(home_url('/contacto')); ?>" class="btn btn--primary btn--lg" style="margin-top: 24px;">
        <?php esc_html_e('Contactar soporte', 'twentytwentyfive-child'); ?>
      </a>
    </div>
  </section>

</main>

<?php get_footer(); ?>
