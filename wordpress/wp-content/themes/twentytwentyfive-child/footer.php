<?php if ( ! defined('ABSPATH') ) { exit; } ?>

<footer class="site-footer" role="contentinfo">
  <div class="container footer-grid">
    <div>
      <div class="brand" style="margin-bottom:10px;">
        <span class="logo-box">LOGO</span>
        <strong><?php bloginfo('name'); ?></strong>
      </div>
      <p class="small">
        <?php echo esc_html(get_bloginfo('description')); ?>
      </p>
      <p class="small">
        <?php esc_html_e('Gestión integral de hospedajes: arriendo, limpieza, mantenimiento e IA para predicción de costos y documentación.', 'twentytwentyfive-child'); ?>
      </p>
    </div>

    <div class="footer-links">
      <a href="#servicios"><?php esc_html_e('Servicios', 'twentytwentyfive-child'); ?></a>
      <a href="#como-funciona"><?php esc_html_e('Cómo funciona', 'twentytwentyfive-child'); ?></a>
      <a href="#arrendamiento"><?php esc_html_e('Arrendamiento', 'twentytwentyfive-child'); ?></a>
      <a href="#contacto"><?php esc_html_e('Contacto', 'twentytwentyfive-child'); ?></a>
    </div>
  </div>

  <div class="container" style="margin-top:18px;">
    <p class="small">© <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Todos los derechos reservados.', 'twentytwentyfive-child'); ?></p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>