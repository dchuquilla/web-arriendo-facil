<?php
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main class="section">
  <div class="container">
    <h1 class="h2"><?php esc_html_e('Blog', 'twentytwentyfive-child'); ?></h1>
    <hr class="sep">

    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article class="card" style="margin-bottom:12px;">
          <h2 style="margin:0 0 8px;">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </h2>
          <p class="p"><?php echo esc_html(get_the_excerpt()); ?></p>
        </article>
      <?php endwhile; ?>

      <div class="section" style="padding: 20px 0;">
        <?php the_posts_pagination(); ?>
      </div>
    <?php else : ?>
      <p class="p"><?php esc_html_e('No hay contenido aún.', 'twentytwentyfive-child'); ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>