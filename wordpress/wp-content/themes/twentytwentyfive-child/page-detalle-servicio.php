<?php
/**
 * Template Name: Detalle de servicio
 * Página dedicada de cada tarjeta "Toca para ver más": información completa
 * y detallada de qué hace el sistema y cómo se hace, con video explicativo.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current    = get_post();
$slug       = $current ? $current->post_name : '';
$service    = af_service_config( $slug );
$services   = af_services_config();

if ( ! $service ) {
	$first = reset( $services );
	$service = $first;
	$slug   = $service['slug'];
}

$demo_url  = isset( $service['cta'] ) ? $service['cta'] : af_signup_url();
$back_href = home_url( '/#servicios' );
$pages     = array_values( $services );
$index     = array_search( $slug, array_column( $pages, 'slug' ), true );
$next      = isset( $pages[ (int) $index + 1 ] ) ? $pages[ (int) $index + 1 ] : $pages[0];
$prev      = isset( $pages[ (int) $index - 1 ] ) ? $pages[ (int) $index - 1 ] : $pages[ count( $pages ) - 1 ];
$accent    = $service['accent'];
?>

<main id="main-content" class="af-detail af-detail--<?php echo esc_attr( $accent ); ?>">

	<!-- ========== HERO ========== -->
	<section class="af-detail-hero">
		<div class="container">
			<a class="af-detail-back" href="<?php echo esc_url( $back_href ); ?>">
				<span aria-hidden="true">←</span>
				<?php esc_html_e( 'Volver a servicios', 'twentytwentyfive-child' ); ?>
			</a>

			<div class="af-detail-hero__grid">
				<div class="af-detail-hero__content">
					<span class="af-detail-eyebrow"><?php echo esc_html( $service['eyebrow'] ); ?></span>
					<h1><?php echo esc_html( $service['title'] ); ?></h1>
					<p><?php echo esc_html( $service['tagline'] ); ?></p>
					<div class="af-detail-hero__actions">
						<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $demo_url ); ?>">
							<?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?>
						</a>
						<a class="af-detail-hero__secondary" href="#af-detalle-como">
							<?php esc_html_e( 'Ver el paso a paso ↓', 'twentytwentyfive-child' ); ?>
						</a>
					</div>
				</div>
				<div class="af-detail-hero__art" aria-hidden="true">
					<span class="af-detail-hero__tile"><?php echo esc_html( $service['icon'] ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- ========== VIDEO ========== -->
	<section class="af-detail-section af-detail-video-section" aria-label="<?php esc_attr_e( 'Video explicativo', 'twentytwentyfive-child' ); ?>">
		<div class="container">
			<div class="af-detail-video-frame">
				<?php echo af_service_video_html( $service ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>

	<!-- ========== METRICAS ========== -->
	<section class="af-detail-stats-section" aria-label="<?php esc_attr_e( 'Cifras del servicio', 'twentytwentyfive-child' ); ?>">
		<div class="container">
			<div class="af-detail-stats">
				<?php foreach ( $service['datos'] as $dato ) : ?>
					<div class="af-detail-stat">
						<span class="af-detail-stat__value"><?php echo esc_html( $dato['value'] ); ?></span>
						<span class="af-detail-stat__label"><?php echo esc_html( $dato['label'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ========== CONTENIDO DETALLADO ========== -->
	<div class="container">
		<div class="af-detail-grid af-detail-grid--top">

			<section class="af-detail-block af-detail-block--que" aria-labelledby="af-detalle-que">
				<span class="af-detail-block__tag"><?php esc_html_e( '01', 'twentytwentyfive-child' ); ?></span>
				<h2 id="af-detalle-que"><?php echo esc_html( $service['que']['title'] ); ?></h2>
				<p class="af-detail-block__intro"><?php echo esc_html( $service['que']['intro'] ); ?></p>
				<ul class="af-detail-check">
					<?php foreach ( $service['que']['items'] as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</section>

			<section class="af-detail-block af-detail-block--beneficios" aria-labelledby="af-detalle-beneficios">
				<span class="af-detail-block__tag"><?php esc_html_e( '02', 'twentytwentyfive-child' ); ?></span>
				<h2 id="af-detalle-beneficios"><?php esc_html_e( 'Lo que ganas', 'twentytwentyfive-child' ); ?></h2>
				<p class="af-detail-block__intro"><?php esc_html_e( 'Resultados concretos desde el primer mes:', 'twentytwentyfive-child' ); ?></p>
				<ul class="af-detail-benefits">
					<?php foreach ( $service['beneficios'] as $beneficio ) : ?>
						<li><?php echo esc_html( $beneficio ); ?></li>
					<?php endforeach; ?>
				</ul>
			</section>

		</div>

		<section class="af-detail-block af-detail-block--como" id="af-detalle-como" aria-labelledby="af-detalle-como-title">
			<span class="af-detail-block__tag"><?php esc_html_e( '03', 'twentytwentyfive-child' ); ?></span>
			<h2 id="af-detalle-como-title"><?php echo esc_html( $service['como']['title'] ); ?></h2>
			<ol class="af-detail-steps">
				<?php foreach ( $service['como']['steps'] as $i => $step ) : ?>
					<li>
						<span class="af-detail-steps__num"><?php echo esc_html( (string) ( $i + 1 ) ); ?></span>
						<div class="af-detail-steps__body">
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['text'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</section>

		<?php if ( ! empty( $service['faq'] ) ) : ?>
		<section class="af-detail-block af-detail-faq" aria-labelledby="af-detalle-faq">
			<span class="af-detail-block__tag"><?php esc_html_e( '04', 'twentytwentyfive-child' ); ?></span>
			<h2 id="af-detalle-faq"><?php esc_html_e( 'Preguntas frecuentes', 'twentytwentyfive-child' ); ?></h2>
			<div class="af-detail-faq__list">
				<?php foreach ( $service['faq'] as $item ) : ?>
					<details class="af-detail-faq__item">
						<summary><?php echo esc_html( $item['q'] ); ?></summary>
						<p><?php echo esc_html( $item['a'] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>
	</div>

	<!-- ========== OTROS SERVICIOS ========== -->
	<section class="af-detail-section af-detail-more" aria-labelledby="af-detalle-mas-servicios">
		<div class="container">
			<span class="af-detail-eyebrow"><?php esc_html_e( 'Más servicios', 'twentytwentyfive-child' ); ?></span>
			<h2 id="af-detalle-mas-servicios"><?php esc_html_e( 'Explora todo lo que hacemos por ti', 'twentytwentyfive-child' ); ?></h2>

			<div class="af-detail-more__list">
				<?php $more_i = 1; foreach ( array_values( $services ) as $srv ) : ?>
					<?php if ( $srv['slug'] === $slug ) : continue; endif; ?>
					<a class="af-detail-more__row af-detail-more__row--<?php echo esc_attr( $srv['accent'] ); ?>" href="<?php echo esc_url( af_service_detail_url( $srv['slug'] ) ); ?>">
						<span class="af-detail-more__icon"><?php echo esc_html( $srv['icon'] ); ?></span>
						<span class="af-detail-more__body">
							<span class="af-detail-more__meta"><?php echo esc_html( str_pad( (string) $more_i, 2, '0', STR_PAD_LEFT ) ); ?></span>
							<strong><?php echo esc_html( $srv['title'] ); ?></strong>
							<small><?php echo esc_html( $srv['card_desc'] ); ?></small>
						</span>
						<span class="af-detail-more__arrow" aria-hidden="true">→</span>
					</a>
					<?php $more_i++; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ========== CTA ========== -->
	<section class="af-detail-cta">
		<div class="container">
			<div class="af-detail-cta__inner">
				<span class="af-detail-eyebrow af-detail-eyebrow--light"><?php esc_html_e( 'Crea tu cuenta en minutos', 'twentytwentyfive-child' ); ?></span>
				<h2><?php esc_html_e( '¿Listo para gestionar tus propiedades con menos esfuerzo?', 'twentytwentyfive-child' ); ?></h2>
				<p><?php esc_html_e( 'Regístrate y descubre cómo Arriendo Fácil simplifica tu gestión.', 'twentytwentyfive-child' ); ?></p>
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $demo_url ); ?>">
					<?php esc_html_e( 'Crear mi cuenta', 'twentytwentyfive-child' ); ?>
				</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>