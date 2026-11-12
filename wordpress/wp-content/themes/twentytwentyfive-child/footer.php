<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// La portada incrusta el footer dentro de su último panel (efecto fullpage).
if ( empty( $GLOBALS['afx_footer_rendered'] ) ) {
  get_template_part( 'template-parts/afx-footer' );
}

wp_footer();
?>
</body>
</html>
