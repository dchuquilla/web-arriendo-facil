<?php
/**
 * Template Name: Quiénes somos
 * Página institucional: qué es Arriendo Fácil y a quién ayuda.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pillars = array(
	array(
		'icon'  => '🧾',
		'title' => __( 'Facturación electrónica', 'twentytwentyfive-child' ),
		'text'  => __( 'Comprobantes válidos ante el SRI, emitidos con un clic.', 'twentytwentyfive-child' ),
	),
	array(
		'icon'  => '💳',
		'title' => __( 'Control de pagos', 'twentytwentyfive-child' ),
		'text'  => __( 'Seguimiento de cargos mensuales, pagos de servicios y alertas de mora.', 'twentytwentyfive-child' ),
	),
	array(
		'icon'  => '⚖️',
		'title' => __( 'Contratos', 'twentytwentyfive-child' ),
		'text'  => __( 'Generados desde plantilla, con notarización y alertas de vencimiento.', 'twentytwentyfive-child' ),
	),
	array(
		'icon'  => '🛠️',
		'title' => __( 'Mantenimiento', 'twentytwentyfive-child' ),
		'text'  => __( 'Incidencias con proveedores, prioridades y costos trazables.', 'twentytwentyfive-child' ),
	),
);

$values = array(
	array(
		'num'   => '01',
		'title' => __( 'Claridad', 'twentytwentyfive-child' ),
		'text'  => __( 'Cada cobro, gasto y liquidación queda registrado y a la vista.', 'twentytwentyfive-child' ),
	),
	array(
		'num'   => '02',
		'title' => __( 'Criterio humano', 'twentytwentyfive-child' ),
		'text'  => __( 'La tecnología automatiza lo repetitivo; las decisiones importantes las toma el administrador.', 'twentytwentyfive-child' ),
	),
	array(
		'num'   => '03',
		'title' => __( 'Seguridad', 'twentytwentyfive-child' ),
		'text'  => __( 'Documentos privados, acceso por roles y cada administrador ve solo su cartera.', 'twentytwentyfive-child' ),
	),
);
?>

<main id="main-content" class="af-about">

	<section class="af-about-hero">
		<div class="container">
			<span class="pms-eyebrow pms-eyebrow--light"><?php esc_html_e( 'Quiénes somos', 'twentytwentyfive-child' ); ?></span>
			<h1><?php esc_html_e( 'Tecnología para quienes administran propiedades', 'twentytwentyfive-child' ); ?></h1>
			<p><?php esc_html_e( 'Somos un sistema de gestión creado en Ecuador para que los gestores de propiedades ordenen su operación y dediquen su tiempo a crecer.', 'twentytwentyfive-child' ); ?></p>
		</div>
	</section>

	<div class="container">
		<ul class="af-about-facts">
			<li><b><?php esc_html_e( '1 panel', 'twentytwentyfive-child' ); ?></b><span><?php esc_html_e( 'para toda tu cartera', 'twentytwentyfive-child' ); ?></span></li>
			<li><b>SRI</b><span><?php esc_html_e( 'facturación electrónica integrada', 'twentytwentyfive-child' ); ?></span></li>
			<li><b>EC</b><span><?php esc_html_e( 'hecho para Ecuador', 'twentytwentyfive-child' ); ?></span></li>
		</ul>
	</div>

	<section class="af-about-section">
		<div class="container af-about-split">
			<div>
				<span class="pms-eyebrow"><?php esc_html_e( 'Nuestra misión', 'twentytwentyfive-child' ); ?></span>
				<h2 class="h2"><?php esc_html_e( 'Profesionalizar la administración de arriendos', 'twentytwentyfive-child' ); ?></h2>
			</div>
			<div class="af-about-text">
				<p><?php esc_html_e( 'Administrar una cartera de inmuebles implica cobrar, facturar, dar seguimiento a contratos, atender incidencias y rendir cuentas a los propietarios. Hacerlo en hojas de cálculo y chats es lento y propenso a errores.', 'twentytwentyfive-child' ); ?></p>
				<p><?php esc_html_e( 'Arriendo Fácil reúne todo en un solo panel, con procesos claros y adaptados a la normativa ecuatoriana, para que cada gestor tenga control y transparencia sobre su operación.', 'twentytwentyfive-child' ); ?></p>
			</div>
		</div>
	</section>

	<section class="af-about-section af-about-section--muted">
		<div class="container">
			<div class="af-about-head">
				<span class="pms-eyebrow"><?php esc_html_e( 'Qué ofrecemos', 'twentytwentyfive-child' ); ?></span>
				<h2 class="h2"><?php esc_html_e( 'Todo lo que necesita un gestor, en un solo lugar', 'twentytwentyfive-child' ); ?></h2>
			</div>
			<div class="af-about-grid af-about-grid--4">
				<?php foreach ( $pillars as $item ) : ?>
					<article class="af-about-card">
						<span class="af-about-card__icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></span>
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="af-about-section">
		<div class="container">
			<div class="af-about-head">
				<span class="pms-eyebrow"><?php esc_html_e( 'Cómo trabajamos', 'twentytwentyfive-child' ); ?></span>
				<h2 class="h2"><?php esc_html_e( 'Lo que nos guía', 'twentytwentyfive-child' ); ?></h2>
			</div>
			<div class="af-about-grid af-about-grid--3">
				<?php foreach ( $values as $item ) : ?>
					<article class="af-about-card af-about-card--value">
						<span class="af-about-card__num"><?php echo esc_html( $item['num'] ); ?></span>
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="pms-cta">
		<div class="container">
			<div class="pms-cta__content">
				<span class="pms-eyebrow pms-eyebrow--light"><?php esc_html_e( 'Crea tu cuenta en minutos', 'twentytwentyfive-child' ); ?></span>
				<h2><?php esc_html_e( '¿Listo para gestionar tus propiedades con menos esfuerzo?', 'twentytwentyfive-child' ); ?></h2>
				<div class="pms-cta__buttons">
					<a href="<?php echo esc_url( af_signup_url() ); ?>" class="btn btn--primary btn--lg">
						<?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>" class="pms-cta__link">
						<?php esc_html_e( 'Hablar con nosotros →', 'twentytwentyfive-child' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
