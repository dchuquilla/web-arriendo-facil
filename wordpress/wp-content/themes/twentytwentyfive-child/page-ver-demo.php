<?php
/**
 * Template Name: Vista previa del panel (demo)
 * Página estática que replica el dashboard interno de Arriendo Fácil
 * (modo lectura, datos de ejemplo). Invita a crear una cuenta para
 * gestionar propiedades reales.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$signup_url = function_exists( 'af_demo_signup_url' ) ? af_demo_signup_url() : home_url( '/solicitar-demo/' );

/**
 * Iconos SVG (subset de la librería del plugin) para que la demo sea
 * autosuficiente en el front-end (los helpers de admin no están cargados).
 *
 * @param string $name Nombre del icono.
 * @param int    $size Tamaño en píxeles.
 * @return string Markup SVG o cadena vacía.
 */
$af_icon = function ( $name = '', $size = 18 ) {
	static $icons = array(
		'building-2'  => '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>',
		'layout-grid'  => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
		'home'         => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
		'wrench'       => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
		'file-text'    => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
		'log-out'      => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
		'log-in'       => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/>',
		'user-plus'    => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/>',
		'clock'        => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'sparkles'     => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
		'bot'          => '<path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/>',
		'trending-up'  => '<path d="M22 7l-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/>',
		'users'        => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'credit-card'  => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
		'circle-alert' => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/>',
		'calendar'     => '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
		'star'         => '<path d="M12 2l3 6.5 7 .9-5.1 4.7 1.3 7L12 17.8 5.8 21l1.3-7L2 9.4l7-.9L12 2z"/>',
		'receipt'      => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/>',
		'globe'        => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
		'user'         => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
		'bell'         => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg class="af-icon af-icon--%1$s" xmlns="http://www.w3.org/2000/svg" width="%2$d" height="%2$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%3$s</svg>',
		sanitize_key( $name ),
		absint( $size ),
		$icons[ $name ]
	);
};

/** Inicial del nombre para los avatares de las filas. */
$af_initial = function ( $af_name = '' ) {
	$af_name   = trim( (string) $af_name );
	$af_letter = function_exists( 'mb_substr' ) ? mb_substr( $af_name, 0, 1, 'UTF-8' ) : substr( $af_name, 0, 1 );
	return function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $af_letter, 'UTF-8' ) : strtoupper( $af_letter );
};

/** Datos de ejemplo (modo demo, sin leer la base de datos). */
$demo_overview = array(
	'collected'   => 4320.00,
	'charged'     => 5180.00,
	'collection_rate' => 83,
	'period'      => '2026-09',
	'balance'     => 860.00,
	'overdue'     => 410.00,
	'overdue_count' => 2,
	'expiring'    => 3,
);

$demo_chips = array(
	array( 'icon' => 'building-2', 'value' => '12', 'unit' => '',       'label' => 'Alojamientos', 'meta' => '9 activos' ),
	array( 'icon' => 'file-text',   'value' => '14', 'unit' => '',       'label' => 'Contratos',    'meta' => '1 borrador', 'tone' => 'is-warn' ),
	array( 'icon' => 'wrench',      'value' => '4',  'unit' => '',       'label' => 'Mantenimiento','meta' => 'Acción requerida', 'tone' => 'is-warn' ),
	array( 'icon' => 'star',        'value' => '4,8', 'unit' => '/ 5',   'label' => 'Valoraciones', 'meta' => '63 reseñas · 94% positivas' ),
	array( 'icon' => 'users',       'value' => '27', 'unit' => '',       'label' => 'Inquilinos',   'meta' => '2 con documentos pendientes' ),
);

$demo_semaforo = array(
	'cobrado'   => array( 'valor' => '$4.320,00', 'meta' => '38 cargos' ),
	'pendiente' => array( 'valor' => '$860,00',   'meta' => '7 cargos' ),
	'atrasado'  => array( 'valor' => '$410,00',   'meta' => '2 cargos' ),
);

$demo_top_mora = array(
	array( 'name' => 'Mónica Reyes', 'property' => 'Edificio Alameda · Depto 402', 'pill' => 'af-pill--warning', 'pill_text' => '28 días de mora', 'amount' => '$210,00' ),
	array( 'name' => 'Carlos Bermeo', 'property' => 'Quicentro · Loft 12', 'pill' => 'af-pill--danger', 'pill_text' => '66 días de mora', 'amount' => '$200,00' ),
);

$demo_checkins = array(
	array( 'name' => 'Daniela Páez', 'property' => 'Edificio Alameda · Depto 510', 'pill' => 'af-pill--info', 'pill_text' => '18/09/2026' ),
	array( 'name' => 'Jorge Sandoval', 'property' => 'Quicentro · Depto 801', 'pill' => 'af-pill--info', 'pill_text' => '22/09/2026' ),
);

$demo_checkouts = array(
	array( 'name' => 'Andrea Molina', 'property' => 'La Floresta · Casa 3', 'pill' => 'af-pill--warning', 'pill_text' => '20/09/2026' ),
	array( 'name' => 'Pablo Granda', 'property' => 'Cumbayá · Suite 7', 'pill' => 'af-pill--warning', 'pill_text' => '25/09/2026' ),
);

$demo_visits = array(
	array( 'name' => 'María José Andrade', 'property' => 'Edificio Alameda · Depto 502', 'pill' => 'af-pill--info', 'pill_text' => '19/09/2026 10:30' ),
	array( 'name' => 'Esteban Cevallos', 'property' => 'Quicentro · Loft 14', 'pill' => 'af-pill--info', 'pill_text' => '21/09/2026 16:00' ),
);

$demo_buckets = array( '30' => '1', '60' => '1', '90' => '1' );
$demo_bucket_tones = array( '30' => 'danger', '60' => 'warning', '90' => 'neutral' );

$demo_schedule = array(
	array( 'name' => 'Mónica Reyes',   'property' => 'Edificio Alameda · Depto 402', 'pill' => 'af-pill--danger',  'pill_text' => 'Vence en 21 días', 'amount' => '07/10/2026' ),
	array( 'name' => 'Jorge Sandoval', 'property' => 'Quicentro · Depto 801',        'pill' => 'af-pill--warning', 'pill_text' => 'Vence en 48 días', 'amount' => '03/11/2026' ),
	array( 'name' => 'Pablo Granda',   'property' => 'Cumbayá · Suite 7',            'pill' => 'af-pill--neutral', 'pill_text' => 'Vence en 82 días', 'amount' => '07/12/2026' ),
);

$demo_recent_leases = array(
	array( 'name' => 'Daniela Páez',   'property' => 'Edificio Alameda · Depto 510', 'pill' => 'af-pill--success', 'pill_text' => 'Activo',  'date' => '07/10/2027' ),
	array( 'name' => 'Jorge Sandoval', 'property' => 'Quicentro · Depto 801',        'pill' => 'af-pill--success', 'pill_text' => 'Activo',  'date' => '03/11/2027' ),
	array( 'name' => 'Andrea Molina',  'property' => 'La Floresta · Casa 3',          'pill' => 'af-pill--neutral', 'pill_text' => 'Borrador', 'date' => '20/09/2026' ),
	array( 'name' => 'Pablo Granda',   'property' => 'Cumbayá · Suite 7',            'pill' => 'af-pill--success', 'pill_text' => 'Activo',  'date' => '07/12/2027' ),
);

$demo_quick = array(
	array( 'icon' => 'home',      'title' => '+ Nuevo alojamiento',   'meta' => 'Publicar una propiedad en la plataforma.' ),
	array( 'icon' => 'file-text', 'title' => 'Gestionar contratos',   'meta' => 'Ver, activar y facturar contratos vigentes.' ),
	array( 'icon' => 'sparkles',  'title' => 'Solicitudes de limpieza','meta' => 'Asigna, programa y da seguimiento.' ),
	array( 'icon' => 'receipt',   'title' => 'Facturación electrónica','meta' => 'Emitir y firmar comprobantes SRI del período.' ),
	array( 'icon' => 'globe',     'title' => 'Sincronización OTA',    'meta' => 'Airbnb y Booking en tiempo real.' ),
	array( 'icon' => 'bot',       'title' => 'Ajustes de IA',         'meta' => 'Modelos y credenciales para automatización.' ),
);

$demo_tasks = array(
	array( 'count' => '2', 'icon' => 'credit-card', 'label' => 'cargos vencidos por cobrar' ),
	array( 'count' => '2', 'icon' => 'user',        'label' => 'inquilinos con documentos por verificar' ),
	array( 'count' => '3', 'icon' => 'file-text',   'label' => 'contratos por vencer en 60 días' ),
	array( 'count' => '1', 'icon' => 'file-text',   'label' => 'contrato en borrador por revisar' ),
	array( 'count' => '1', 'icon' => 'wrench',      'label' => 'incidencia crítica de mantenimiento' ),
);

$demo_recent_reviews = array(
	array( 'name' => 'María José Andrade', 'property' => 'Edificio Alameda · Depto 502', 'stars' => 5, 'comment' => 'Excelente cumplimiento de pago y muy buen cuidado del inmueble.' ),
	array( 'name' => 'Esteban Cevallos',   'property' => 'Quicentro · Loft 14',          'stars' => 4, 'comment' => 'Buena convivencia, pagos puntuales la mayoría de los meses.' ),
	array( 'name' => 'Mónica Reyes',       'property' => 'Edificio Alameda · Depto 402', 'stars' => 3, 'comment' => 'Retrasos frecuentes en el pago del canon, se recomienda seguimiento.' ),
);
?>

<main id="main-content" class="section af-demo-preview-body">
	<div class="af-demo-wrap">

		<div class="af-demo-ribbon" role="banner">
			<div class="af-demo-ribbon__text">
				<strong>Vista previa del panel — datos de demostración</strong>
				<span>Así se ve Arriendo Fácil al administrar tus arriendos: cobranza, contratos y mantenimiento en un solo lugar.</span>
			</div>
			<a class="af-demo-ribbon__cta" href="<?php echo esc_url( $signup_url ); ?>">
				<?php esc_html_e( 'Crea tu cuenta y comienza a gestionar', 'arriendo-facil' ); ?>
			</a>
		</div>

		<div class="wrap af-shell af-dashboard">

			<header class="af-page-header">
				<div class="af-page-header__title">
					<span class="af-page-header__eyebrow"><?php esc_html_e( 'Miércoles, 16 de septiembre', 'arriendo-facil' ); ?></span>
					<h1><?php esc_html_e( 'Panel de administración', 'arriendo-facil' ); ?></h1>
					<p class="af-page-header__subtitle">
						<?php esc_html_e( 'Cobranza, mora y vencimientos de la operación en un vistazo. Todo listo para que lo hagas tuyo.', 'arriendo-facil' ); ?>
					</p>
				</div>
				<div class="af-page-header__actions">
					<a href="<?php echo esc_url( $signup_url ); ?>" class="button af-btn af-btn--primary">
						<span class="af-btn__icon" aria-hidden="true">
							<svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
						</span>
						<?php esc_html_e( 'Nuevo alojamiento', 'arriendo-facil' ); ?>
					</a>
					<a href="<?php echo esc_url( $signup_url ); ?>" class="button af-btn af-btn--ghost">
						<?php esc_html_e( 'Ver contratos', 'arriendo-facil' ); ?>
					</a>
				</div>
			</header>

			<div class="af-overview">

				<section class="af-overview-hero" aria-labelledby="af-demo-overview-collected-title">
					<div class="af-overview-hero__main">
						<span class="af-overview-hero__eyebrow" id="af-demo-overview-collected-title"><?php esc_html_e( 'Cobrado este mes', 'arriendo-facil' ); ?></span>
						<span class="af-overview-hero__value">$<?php echo esc_html( number_format_i18n( $demo_overview['collected'], 2 ) ); ?></span>
						<span class="af-overview-hero__meta">
							<?php printf( /* translators: %s: total facturado */ esc_html__( 'de $%s facturados', 'arriendo-facil' ), esc_html( number_format_i18n( $demo_overview['charged'], 2 ) ) ); ?>
						</span>
						<div class="af-overview-hero__bar" role="img" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: tasa de cobro */ __( 'Tasa de cobro: %d%%', 'arriendo-facil' ), (int) $demo_overview['collection_rate'] ) ); ?>">
							<span style="width: <?php echo esc_attr( (float) $demo_overview['collection_rate'] ); ?>%"></span>
						</div>
						<div class="af-overview-hero__actions">
							<a class="af-overview-hero__cta" href="<?php echo esc_url( $signup_url ); ?>">
								<?php esc_html_e( 'Ver cobranza', 'arriendo-facil' ); ?> <span aria-hidden="true">&rarr;</span>
							</a>
						</div>
					</div>
					<div class="af-overview-hero__side">
						<span class="af-overview-hero__rate"><?php echo esc_html( (int) $demo_overview['collection_rate'] ); ?>%</span>
						<span class="af-overview-hero__rate-label"><?php esc_html_e( 'de cobro del periodo', 'arriendo-facil' ); ?></span>
						<span class="af-pill af-pill--hero"><?php echo esc_html( $demo_overview['period'] ); ?></span>
					</div>
				</section>

				<div class="af-overview-stats">
					<article class="af-overview-stat">
						<span class="af-overview-stat__icon" aria-hidden="true"><?php echo $af_icon( 'credit-card', 18 ); ?></span>
						<span class="af-overview-stat__body">
							<span class="af-overview-stat__label"><?php esc_html_e( 'Por cobrar', 'arriendo-facil' ); ?></span>
							<span class="af-overview-stat__value">$<?php echo esc_html( number_format_i18n( $demo_overview['balance'], 2 ) ); ?></span>
							<span class="af-overview-stat__hint"><?php esc_html_e( 'Saldo del periodo actual', 'arriendo-facil' ); ?></span>
						</span>
					</article>

					<article class="af-overview-stat is-danger">
						<span class="af-overview-stat__icon" aria-hidden="true"><?php echo $af_icon( 'circle-alert', 18 ); ?></span>
						<span class="af-overview-stat__body">
							<span class="af-overview-stat__label"><?php esc_html_e( 'En mora', 'arriendo-facil' ); ?></span>
							<span class="af-overview-stat__value">$<?php echo esc_html( number_format_i18n( $demo_overview['overdue'], 2 ) ); ?></span>
							<span class="af-overview-stat__hint">
								<?php printf( /* translators: %d: cargos vencidos */ esc_html__( '%d cargos vencidos', 'arriendo-facil' ), (int) $demo_overview['overdue_count'] ); ?>
							</span>
						</span>
						<a class="af-overview-stat__link af-demo-btn" href="<?php echo esc_url( $signup_url ); ?>"><?php esc_html_e( 'Gestionar', 'arriendo-facil' ); ?></a>
					</article>

					<article class="af-overview-stat is-warn">
						<span class="af-overview-stat__icon" aria-hidden="true"><?php echo $af_icon( 'calendar', 18 ); ?></span>
						<span class="af-overview-stat__body">
							<span class="af-overview-stat__label"><?php esc_html_e( 'Contratos por vencer', 'arriendo-facil' ); ?></span>
							<span class="af-overview-stat__value"><?php echo esc_html( number_format_i18n( (int) $demo_overview['expiring'] ) ); ?></span>
							<span class="af-overview-stat__hint"><?php esc_html_e( 'En los próximos 60 días', 'arriendo-facil' ); ?></span>
						</span>
						<a class="af-overview-stat__link af-demo-btn" href="<?php echo esc_url( $signup_url ); ?>"><?php esc_html_e( 'Ver contratos', 'arriendo-facil' ); ?></a>
					</article>
				</div>

				<div class="af-overview-chips">
					<?php foreach ( $demo_chips as $chip ) : ?>
						<a class="af-overview-chip<?php echo ! empty( $chip['tone'] ) ? ' ' . esc_attr( $chip['tone'] ) : ''; ?>" href="<?php echo esc_url( $signup_url ); ?>">
							<span class="af-overview-chip__icon" aria-hidden="true"><?php echo $af_icon( $chip['icon'], 18 ); ?></span>
							<span class="af-overview-chip__value">
								<?php echo esc_html( $chip['value'] ); ?>
								<?php if ( ! empty( $chip['unit'] ) ) : ?><small class="af-overview-chip__unit"><?php echo esc_html( $chip['unit'] ); ?></small><?php endif; ?>
							</span>
							<span class="af-overview-chip__label"><?php echo esc_html( $chip['label'] ); ?></span>
							<span class="af-overview-chip__meta"><?php echo esc_html( $chip['meta'] ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>

			</div>

			<div class="af-split af-charts-row">
				<section class="af-section" aria-labelledby="af-demo-chart-occupancy-title">
					<header class="af-section__header">
						<div class="af-section__head">
							<span class="af-section__icon af-section__icon--slate" aria-hidden="true"><?php echo $af_icon( 'building-2', 18 ); ?></span>
							<div>
								<h2 class="af-section__title" id="af-demo-chart-occupancy-title"><?php esc_html_e( 'Resumen de ocupación', 'arriendo-facil' ); ?></h2>
								<p class="af-section__subtitle"><?php esc_html_e( 'Disponibles, ocupadas y en mantenimiento.', 'arriendo-facil' ); ?></p>
							</div>
						</div>
					</header>
					<div class="af-chart-canvas af-chart-canvas--donut">
						<canvas id="af-demo-chart-occupancy" role="img" aria-label="<?php esc_attr_e( 'Gráfico de ocupación de propiedades (demo)', 'arriendo-facil' ); ?>"></canvas>
					</div>
				</section>

				<section class="af-section" aria-labelledby="af-demo-chart-revenue-title">
					<header class="af-section__header">
						<div class="af-section__head">
							<span class="af-section__icon" aria-hidden="true"><?php echo $af_icon( 'trending-up', 18 ); ?></span>
							<div>
								<h2 class="af-section__title" id="af-demo-chart-revenue-title"><?php esc_html_e( 'Ingresos por arriendos', 'arriendo-facil' ); ?></h2>
								<p class="af-section__subtitle"><?php esc_html_e( 'Cobrado en los últimos 6 meses.', 'arriendo-facil' ); ?></p>
							</div>
						</div>
					</header>
					<div class="af-chart-canvas">
						<canvas id="af-demo-chart-revenue" role="img" aria-label="<?php esc_attr_e( 'Gráfico de ingresos por arriendos (demo)', 'arriendo-facil' ); ?>"></canvas>
					</div>
				</section>
			</div>

			<script>
			( function() {
				if ( typeof Chart === 'undefined' ) {
					return;
				}
				var occupancyEl = document.getElementById( 'af-demo-chart-occupancy' );
				if ( occupancyEl ) {
					new Chart( occupancyEl, {
						type: 'doughnut',
						data: {
							labels: [ '<?php echo esc_js( __( 'Disponibles', 'arriendo-facil' ) ); ?>', '<?php echo esc_js( __( 'Ocupadas', 'arriendo-facil' ) ); ?>', '<?php echo esc_js( __( 'Mantenimiento', 'arriendo-facil' ) ); ?>' ],
							datasets: [ { data: [ 4, 8, 0 ], backgroundColor: [ '#CBD5E1', '#00A884', '#F59E0B' ], borderWidth: 0 } ]
						},
						options: { responsive: true, maintainAspectRatio: false, cutout: '68%', plugins: { legend: { position: 'bottom' } } }
					} );
				}
				var revenueEl = document.getElementById( 'af-demo-chart-revenue' );
				if ( revenueEl ) {
					new Chart( revenueEl, {
						type: 'line',
						data: {
							labels: [ 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep' ],
							datasets: [ {
								label: '<?php echo esc_js( __( 'Cobrado', 'arriendo-facil' ) ); ?>',
								data: [ 3120, 3340, 3980, 3760, 4510, 4320 ],
								borderColor: '#00A884',
								backgroundColor: 'rgba(0,168,132,0.12)',
								fill: true,
								tension: 0.35,
								pointRadius: 3
							} ]
						},
						options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
					} );
				}
			} )();
			</script>

			<section class="af-section" aria-labelledby="af-demo-recent-leases">
				<header class="af-section__header">
					<div class="af-section__head">
						<span class="af-section__icon" aria-hidden="true"><?php echo $af_icon( 'file-text', 18 ); ?></span>
						<div>
							<h2 class="af-section__title" id="af-demo-recent-leases"><?php esc_html_e( 'Contratos recientes', 'arriendo-facil' ); ?></h2>
							<p class="af-section__subtitle"><?php esc_html_e( 'Las últimas altas de contrato.', 'arriendo-facil' ); ?></p>
						</div>
					</div>
					<button type="button" class="af-kpi__link af-demo-btn" data-af-demo-open><?php esc_html_e( 'Ver todos', 'arriendo-facil' ); ?></button>
				</header>
				<div class="af-semaforo__table" role="table" aria-label="<?php esc_attr_e( 'Contratos recientes', 'arriendo-facil' ); ?>">
					<?php foreach ( $demo_recent_leases as $row ) : ?>
						<button type="button" class="af-semaforo__row af-semaforo__row--with-avatar af-demo-btn" data-af-demo-open>
							<span class="af-semaforo__avatar" aria-hidden="true"><?php echo esc_html( $af_initial( $row['name'] ) ); ?></span>
							<span class="af-semaforo__tenant">
								<strong><?php echo esc_html( $row['name'] ); ?></strong>
								<small><?php echo esc_html( $row['property'] ); ?></small>
							</span>
							<span class="af-pill <?php echo esc_attr( $row['pill'] ); ?>"><?php echo esc_html( $row['pill_text'] ); ?></span>
							<span class="af-semaforo__amount"><?php echo esc_html( $row['date'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="af-section af-semaforo" aria-labelledby="af-demo-semaforo-title">
				<header class="af-section__header">
					<div class="af-section__head">
						<span class="af-section__icon af-section__icon--amber" aria-hidden="true"><?php echo $af_icon( 'credit-card', 18 ); ?></span>
						<div>
							<h2 class="af-section__title" id="af-demo-semaforo-title"><?php esc_html_e( 'Semáforo de cobros', 'arriendo-facil' ); ?></h2>
							<p class="af-section__subtitle">
								<?php printf( /* translators: %s: periodo */ esc_html__( 'Estado de los cargos de %s en tiempo real.', 'arriendo-facil' ), esc_html( $demo_overview['period'] ) ); ?>
							</p>
						</div>
					</div>
					<button type="button" class="af-kpi__link af-demo-btn" data-af-demo-open><?php esc_html_e( 'Ver control de pagos', 'arriendo-facil' ); ?></button>
				</header>

				<div class="af-semaforo__lights" role="list">
					<article class="af-semaforo__light af-semaforo__light--success" role="listitem">
						<span class="af-semaforo__dot" aria-hidden="true"></span>
						<div>
							<span class="af-semaforo__label"><?php esc_html_e( 'Cobrado', 'arriendo-facil' ); ?></span>
							<span class="af-semaforo__value"><?php echo esc_html( $demo_semaforo['cobrado']['valor'] ); ?></span>
							<span class="af-semaforo__meta"><?php echo esc_html( $demo_semaforo['cobrado']['meta'] ); ?></span>
						</div>
					</article>
					<article class="af-semaforo__light af-semaforo__light--warning" role="listitem">
						<span class="af-semaforo__dot" aria-hidden="true"></span>
						<div>
							<span class="af-semaforo__label"><?php esc_html_e( 'Pendiente', 'arriendo-facil' ); ?></span>
							<span class="af-semaforo__value"><?php echo esc_html( $demo_semaforo['pendiente']['valor'] ); ?></span>
							<span class="af-semaforo__meta"><?php echo esc_html( $demo_semaforo['pendiente']['meta'] ); ?></span>
						</div>
					</article>
					<article class="af-semaforo__light af-semaforo__light--danger is-pulsing" role="listitem">
						<span class="af-semaforo__dot" aria-hidden="true"></span>
						<div>
							<span class="af-semaforo__label"><?php esc_html_e( 'Atrasado', 'arriendo-facil' ); ?></span>
							<span class="af-semaforo__value"><?php echo esc_html( $demo_semaforo['atrasado']['valor'] ); ?></span>
							<span class="af-semaforo__meta"><?php echo esc_html( $demo_semaforo['atrasado']['meta'] ); ?></span>
						</div>
					</article>
				</div>

				<div class="af-semaforo__table" role="table" aria-label="<?php esc_attr_e( 'Inquilinos con mayor mora', 'arriendo-facil' ); ?>">
					<?php foreach ( $demo_top_mora as $mora_row ) : ?>
						<button type="button" class="af-semaforo__row af-semaforo__row--with-avatar af-demo-btn" data-af-demo-open>
							<span class="af-semaforo__avatar" aria-hidden="true"><?php echo esc_html( $af_initial( $mora_row['name'] ) ); ?></span>
							<span class="af-semaforo__tenant">
								<strong><?php echo esc_html( $mora_row['name'] ); ?></strong>
								<small><?php echo esc_html( $mora_row['property'] ); ?></small>
							</span>
							<span class="af-pill <?php echo esc_attr( $mora_row['pill'] ); ?>"><?php echo esc_html( $mora_row['pill_text'] ); ?></span>
							<span class="af-semaforo__amount"><?php echo esc_html( $mora_row['amount'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="af-section" aria-labelledby="af-demo-calendar-title">
				<header class="af-section__header">
					<div class="af-section__head">
						<span class="af-section__icon af-section__icon--rose" aria-hidden="true"><?php echo $af_icon( 'calendar', 18 ); ?></span>
						<div>
							<h2 class="af-section__title" id="af-demo-calendar-title"><?php esc_html_e( 'Alertas operativas de calendario', 'arriendo-facil' ); ?></h2>
							<p class="af-section__subtitle"><?php esc_html_e( 'Visitas, check-in y check-out dentro del rango seleccionado.', 'arriendo-facil' ); ?></p>
						</div>
					</div>
				</header>

				<div class="af-calendar-cols">
					<article class="af-calendar-col af-calendar-col--in">
						<header class="af-calendar-col__head">
							<span class="af-calendar-col__icon" aria-hidden="true"><?php echo $af_icon( 'log-in', 18 ); ?></span>
							<div class="af-calendar-col__title">
								<h3><?php esc_html_e( 'Próximos check-in (mudanza)', 'arriendo-facil' ); ?></h3>
								<span class="af-calendar-col__count"><?php printf( /* translators: %d: count */ esc_html__( '%d programados', 'arriendo-facil' ), count( $demo_checkins ) ); ?></span>
							</div>
						</header>
						<div class="af-semaforo__table" role="table" aria-label="<?php esc_attr_e( 'Próximos check-in', 'arriendo-facil' ); ?>">
							<?php foreach ( $demo_checkins as $row ) : ?>
								<button type="button" class="af-semaforo__row af-demo-btn" data-af-demo-open>
									<span class="af-semaforo__tenant">
										<strong><?php echo esc_html( $row['name'] ); ?></strong>
										<small><?php echo esc_html( $row['property'] ); ?></small>
									</span>
									<span class="af-pill <?php echo esc_attr( $row['pill'] ); ?>"><?php echo esc_html( $row['pill_text'] ); ?></span>
								</button>
							<?php endforeach; ?>
						</div>
					</article>

					<article class="af-calendar-col af-calendar-col--out">
						<header class="af-calendar-col__head">
							<span class="af-calendar-col__icon" aria-hidden="true"><?php echo $af_icon( 'log-out', 18 ); ?></span>
							<div class="af-calendar-col__title">
								<h3><?php esc_html_e( 'Próximos check-out (salida)', 'arriendo-facil' ); ?></h3>
								<span class="af-calendar-col__count"><?php printf( /* translators: %d: count */ esc_html__( '%d programados', 'arriendo-facil' ), count( $demo_checkouts ) ); ?></span>
							</div>
						</header>
						<div class="af-semaforo__table" role="table" aria-label="<?php esc_attr_e( 'Próximos check-out', 'arriendo-facil' ); ?>">
							<?php foreach ( $demo_checkouts as $row ) : ?>
								<button type="button" class="af-semaforo__row af-demo-btn" data-af-demo-open>
									<span class="af-semaforo__tenant">
										<strong><?php echo esc_html( $row['name'] ); ?></strong>
										<small><?php echo esc_html( $row['property'] ); ?></small>
									</span>
									<span class="af-pill <?php echo esc_attr( $row['pill'] ); ?>"><?php echo esc_html( $row['pill_text'] ); ?></span>
								</button>
							<?php endforeach; ?>
						</div>
					</article>

					<article class="af-calendar-col af-calendar-col--visit">
						<header class="af-calendar-col__head">
							<span class="af-calendar-col__icon" aria-hidden="true"><?php echo $af_icon( 'user-plus', 18 ); ?></span>
							<div class="af-calendar-col__title">
								<h3><?php esc_html_e( 'Visitas agendadas', 'arriendo-facil' ); ?></h3>
								<span class="af-calendar-col__count"><?php printf( /* translators: %d: count */ esc_html__( '%d agendadas', 'arriendo-facil' ), count( $demo_visits ) ); ?></span>
							</div>
						</header>
						<div class="af-semaforo__table" role="table" aria-label="<?php esc_attr_e( 'Visitas agendadas', 'arriendo-facil' ); ?>">
							<?php foreach ( $demo_visits as $row ) : ?>
								<button type="button" class="af-semaforo__row af-demo-btn" data-af-demo-open>
									<span class="af-semaforo__tenant">
										<strong><?php echo esc_html( $row['name'] ); ?></strong>
										<small><?php echo esc_html( $row['property'] ); ?></small>
									</span>
									<span class="af-pill <?php echo esc_attr( $row['pill'] ); ?>"><?php echo esc_html( $row['pill_text'] ); ?></span>
								</button>
							<?php endforeach; ?>
						</div>
					</article>
				</div>
			</section>

			<section class="af-section af-schedule" aria-labelledby="af-demo-schedule-title">
				<header class="af-section__header">
					<div class="af-section__head">
						<span class="af-section__icon" aria-hidden="true"><?php echo $af_icon( 'clock', 18 ); ?></span>
						<div>
							<h2 class="af-section__title" id="af-demo-schedule-title"><?php esc_html_e( 'Contratos por vencer — 30/60/90', 'arriendo-facil' ); ?></h2>
							<p class="af-section__subtitle"><?php esc_html_e( 'Cronograma de próximas salidas para anticipar renovaciones y liquidar garantías.', 'arriendo-facil' ); ?></p>
						</div>
					</div>
					<button type="button" class="af-kpi__link af-demo-btn" data-af-demo-open><?php esc_html_e( 'Ver próximas salidas', 'arriendo-facil' ); ?></button>
				</header>

				<div class="af-schedule__buckets" role="list">
					<?php
					$af_buckets = array(
						30 => array( 'tone' => 'danger',  'icon' => 'circle-alert', 'label' => 'Decisión inmediata' ),
						60 => array( 'tone' => 'warning', 'icon' => 'clock',        'label' => 'Iniciar renovación' ),
						90 => array( 'tone' => 'neutral', 'icon' => 'calendar',     'label' => 'Planificación' ),
					);
					foreach ( $af_buckets as $af_bucket_key => $af_bucket_data ) :
						?>
						<article class="af-schedule__bucket af-schedule__bucket--<?php echo esc_attr( $af_bucket_data['tone'] ); ?>" role="listitem">
							<span class="af-schedule__icon" aria-hidden="true"><?php echo $af_icon( $af_bucket_data['icon'], 18 ); ?></span>
							<span class="af-schedule__days"><?php printf( /* translators: %s: días */ esc_html__( '≤ %s días', 'arriendo-facil' ), esc_html( (string) $af_bucket_key ) ); ?></span>
							<span class="af-schedule__count"><?php echo esc_html( $demo_buckets[ (string) $af_bucket_key ] ); ?></span>
							<span class="af-schedule__label"><?php echo esc_html( $af_bucket_data['label'] ); ?></span>
						</article>
					<?php endforeach; ?>
				</div>

				<div class="af-schedule__list" role="table" aria-label="<?php esc_attr_e( 'Próximos vencimientos', 'arriendo-facil' ); ?>">
					<?php foreach ( $demo_schedule as $row ) : ?>
						<button type="button" class="af-semaforo__row af-semaforo__row--with-avatar af-demo-btn" data-af-demo-open>
							<span class="af-semaforo__avatar" aria-hidden="true"><?php echo esc_html( $af_initial( $row['name'] ) ); ?></span>
							<span class="af-semaforo__tenant">
								<strong><?php echo esc_html( $row['property'] ); ?></strong>
								<small><?php echo esc_html( $row['name'] ); ?></small>
							</span>
							<span class="af-pill <?php echo esc_attr( $row['pill'] ); ?>"><?php echo esc_html( $row['pill_text'] ); ?></span>
							<span class="af-semaforo__amount"><?php echo esc_html( $row['amount'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</section>

			<div class="af-split">

				<section class="af-section" aria-labelledby="af-demo-focus">
					<header class="af-section__header">
						<div class="af-section__head">
							<span class="af-section__icon af-section__icon--slate" aria-hidden="true"><?php echo $af_icon( 'layout-grid', 18 ); ?></span>
							<div>
								<h2 class="af-section__title" id="af-demo-focus"><?php esc_html_e( 'Accesos rápidos', 'arriendo-facil' ); ?></h2>
								<p class="af-section__subtitle">
									<?php esc_html_e( 'Las acciones que más usas para operar la plataforma.', 'arriendo-facil' ); ?>
								</p>
							</div>
						</div>
					</header>

					<div class="af-property-grid">
						<?php foreach ( $demo_quick as $card ) : ?>
							<button type="button" class="af-property-card af-demo-btn" data-af-demo-open>
								<div class="af-property-card__media af-property-card__media--icon" aria-hidden="true"><?php echo $af_icon( $card['icon'], 24 ); ?></div>
								<div class="af-property-card__body">
									<h3 class="af-property-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
									<p class="af-property-card__meta"><?php echo esc_html( $card['meta'] ); ?></p>
								</div>
							</button>
						<?php endforeach; ?>
					</div>
				</section>

				<div class="af-aside-stack">
				<aside class="af-section" aria-labelledby="af-demo-tasks">
					<header class="af-section__header">
						<div class="af-section__head">
							<span class="af-section__icon af-section__icon--rose" aria-hidden="true"><?php echo $af_icon( 'bell', 18 ); ?></span>
							<div>
								<h2 class="af-section__title" id="af-demo-tasks"><?php esc_html_e( 'Requiere tu atención', 'arriendo-facil' ); ?></h2>
								<p class="af-section__subtitle"><?php esc_html_e( 'Prioridad del día. Toca para resolver.', 'arriendo-facil' ); ?></p>
							</div>
						</div>
					</header>

					<ul class="af-tasklist">
						<?php foreach ( $demo_tasks as $task ) : ?>
							<li>
								<button type="button" class="af-tasklist__item af-demo-btn" data-af-demo-open>
									<span class="af-tasklist__icon" aria-hidden="true"><?php echo $af_icon( $task['icon'], 18 ); ?></span>
									<span class="af-tasklist__badge"><?php echo esc_html( $task['count'] ); ?></span>
									<span class="af-tasklist__label"><?php echo esc_html( $task['label'] ); ?></span>
									<span class="af-tasklist__arrow" aria-hidden="true">→</span>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				</aside>

				<aside class="af-section" aria-labelledby="af-demo-reviews">
					<header class="af-section__header">
						<div class="af-section__head">
							<span class="af-section__icon af-section__icon--amber" aria-hidden="true"><?php echo $af_icon( 'star', 18 ); ?></span>
							<div>
								<h2 class="af-section__title" id="af-demo-reviews"><?php esc_html_e( 'Reviews recientes', 'arriendo-facil' ); ?></h2>
								<p class="af-section__subtitle"><?php esc_html_e( 'Últimas calificaciones registradas a inquilinos.', 'arriendo-facil' ); ?></p>
							</div>
						</div>
						<button type="button" class="af-kpi__link af-demo-btn" data-af-demo-open><?php esc_html_e( 'Ver todas', 'arriendo-facil' ); ?></button>
					</header>
					<ul class="af-review-list">
						<?php foreach ( $demo_recent_reviews as $review ) : ?>
							<li class="af-review-list__item">
								<div class="af-review-list__body">
									<span class="af-review-list__avatar" aria-hidden="true"><?php echo esc_html( $af_initial( $review['name'] ) ); ?></span>
									<div class="af-review-list__content">
										<div class="af-review-list__head">
											<strong><?php echo esc_html( $review['name'] ); ?></strong>
											<span class="af-review-list__stars" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: estrellas */ __( '%d de 5 estrellas', 'arriendo-facil' ), (int) $review['stars'] ) ); ?>">
												<?php echo esc_html( str_repeat( '★', (int) $review['stars'] ) . str_repeat( '☆', 5 - (int) $review['stars'] ) ); ?>
											</span>
										</div>
										<p class="af-review-list__meta"><?php echo esc_html( $review['property'] ); ?></p>
										<p class="af-review-list__comment"><?php echo esc_html( $review['comment'] ); ?></p>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</aside>
				</div>

			</div>

		</div>

	</div>
</main>

<div class="af-demo-modal" id="af-demo-modal" role="dialog" aria-modal="true" aria-labelledby="af-demo-modal-title" aria-hidden="true" data-af-demo-delay="4000">
	<div class="af-demo-modal__backdrop" data-af-demo-close></div>
	<div class="af-demo-modal__dialog">
		<button type="button" class="af-demo-modal__close" data-af-demo-close aria-label="<?php esc_attr_e( 'Cerrar', 'arriendo-facil' ); ?>">&times;</button>
		<div class="af-demo-modal__art" aria-hidden="true">
			<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M3 11l9-8 9 8v10a1 1 0 01-1 1h-5v-6H10v6H4a1 1 0 01-1-1V11z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
				<circle cx="12" cy="12" r="2.6" stroke="currentColor" stroke-width="1.6"/>
			</svg>
		</div>
		<div class="af-demo-modal__body">
			<p class="af-demo-modal__eyebrow"><?php esc_html_e( 'Vista previa', 'arriendo-facil' ); ?></p>
			<h2 class="af-demo-modal__title" id="af-demo-modal-title">
				<?php esc_html_e( '¿Deseas comenzar a ocuparlo?', 'arriendo-facil' ); ?>
			</h2>
			<p class="af-demo-modal__subtitle">
				<?php esc_html_e( 'Crea tu cuenta y comienza a gestionar tus propiedades: cobros, contratos, mantenimiento e inquilinos desde un solo panel.', 'arriendo-facil' ); ?>
			</p>
			<div class="af-demo-modal__actions">
				<a class="af-demo-modal__primary" href="<?php echo esc_url( $signup_url ); ?>">
					<?php esc_html_e( 'Crear mi cuenta', 'arriendo-facil' ); ?>
				</a>
				<button type="button" class="af-demo-modal__ghost" data-af-demo-close>
					<?php esc_html_e( 'Seguir explorando', 'arriendo-facil' ); ?>
				</button>
			</div>
			<p class="af-demo-modal__fineprint">
				<?php esc_html_e( 'Sin tarjeta. Datos de ejemplo: no se guarda nada de esta vista.', 'arriendo-facil' ); ?>
			</p>
		</div>
	</div>
</div>

<?php
get_footer();