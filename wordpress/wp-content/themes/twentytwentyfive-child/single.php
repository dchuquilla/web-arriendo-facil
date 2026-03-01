<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main class="section">
  <div class="container">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article class="card">
          <h1 class="h2"><?php echo esc_html(get_the_title()); ?></h1>
          <hr class="sep">
          <div class="post-content">
            <?php the_content(); ?>
          </div>
          <?php
          wp_link_pages([
            'before' => '<div class="mt-8">',
            'after'  => '</div>',
          ]);
          ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <p class="p"><?php esc_html_e('No hay contenido aún.', 'twentytwentyfive-child'); ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>