<?php
/**
 * Template Name: Registro Inquilino
 * Public page for tenant account signup.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" class="af-tenant-register-page">
	<section class="section section--soft">
		<div class="container container--narrow">
			<div class="text-center" style="margin-bottom:18px;">
				<span class="badge"><?php esc_html_e( 'Cuenta de inquilino', 'twentytwentyfive-child' ); ?></span>
				<h1 class="h2" style="margin-top:10px;"><?php esc_html_e( 'Empieza tu proceso de arriendo', 'twentytwentyfive-child' ); ?></h1>
				<p class="p" style="max-width:680px;margin:8px auto 0;"><?php esc_html_e( 'Crea tu cuenta para gestionar visitas, reservas y documentos de arriendo desde un solo lugar.', 'twentytwentyfive-child' ); ?></p>
			</div>

			<?php
			echo do_shortcode( '[af_tenant_signup]' );
			?>
		</div>
	</section>
</main>

<?php
get_footer();
