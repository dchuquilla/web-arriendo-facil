<?php
/**
 * Servicios de Arriendo Fácil — config + helpers.
 *
 * Cada servicio alimenta una tarjeta de la landing y una página de detalle
 * dedicada ("Toca para ver más") con información completa, pasos y video.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configuración central de los servicios.
 * El slug de cada uno coincide con la URL de su página de detalle.
 */
function af_services_config() {
	$demo_url = function_exists( 'af_demo_preview_url' ) ? af_demo_preview_url() : home_url( '/ver-demo/' );

	return array(
		'cobros-automaticos'  => array(
			'slug'        => 'cobros-automaticos',
			'title'       => 'Cobros automáticos',
			'eyebrow'     => 'Recaudo sin fricción',
			'card_title'  => 'Nada de perseguir pagos',
			'card_desc'   => 'Canon, servicios y alícuotas cobrados solos cada mes.',
			'tagline'     => 'Facturamos, cobramos y te transferimos el saldo limpio cada mes. Tú nunca vuelves a perseguir un pago.',
			'icon'        => '💳',
			'accent'      => 'green',
			'video_label' => 'Video: cómo funcionan los cobros automáticos',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Todo el ciclo de recaudo opera solo, desde la factura hasta la transferencia:',
				'items' => array(
					'Genera la factura del canon, administración y alícuotas automáticamente en la fecha pactada.',
					'Emite comprobantes electrónicos válidos ante el SRI, sin errores de cálculo.',
					'Deja que tus inquilinos paguen por transferencia, PSE o código QR.',
					'Concilia cada pago y te envía el dinero a tu cuenta.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Configuras una sola vez',
						'text'  => 'Cargas el canon, los conceptos y la fecha de cobro de cada propiedad.',
					),
					array(
						'title' => 'El sistema factura solo',
						'text'  => 'En la fecha pactada se emite y envía la factura al inquilino.',
					),
					array(
						'title' => 'El inquilino paga cómo quiera',
						'text'  => 'Transferencia, PSE o código QR: tú no gestionas ni persigues.',
					),
					array(
						'title' => 'Recibes tu saldo',
						'text'  => 'El pago se concilia y el dinero llega a tu cuenta con el reporte.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '99.7%', 'label' => 'Tasa de recaudo' ),
				array( 'value' => '+2,500', 'label' => 'Cargos emitidos al mes' ),
				array( 'value' => '1 día', 'label' => 'De factura a saldo liquidado' ),
			),
			'beneficios'  => array(
				'Factura electrónica SRI en cada cobro, sin errores de cálculo.',
				'Canon, administración, alícuotas y servicios en un solo cargo.',
				'Tu saldo llega transferido con su reporte, sin perseguir a nadie.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué pasa si el inquilino no paga a la fecha?',
					'a' => 'Se activa el flujo de mora: recordatorios automáticos y escalamiento progresivo. Tú siempre decides cuándo intervenir.',
				),
				array(
					'q' => '¿Las facturas son válidas para el SRI?',
					'a' => 'Sí. Cada cobro emite un comprobante electrónico firmado y válido ante el SRI.',
				),
				array(
					'q' => '¿Puedo configurar fechas y conceptos distintos por propiedad?',
					'a' => 'Sí. Defines canon, administración, alícuotas y servicios, cada uno con su propia fecha de cobro.',
				),
			),
			'cta'         => $demo_url,
		),
		'reportes-mensuales'  => array(
			'slug'        => 'reportes-mensuales',
			'title'       => 'Reportes mensuales',
			'eyebrow'     => 'Transparencia total',
			'card_title'  => 'Transparencia total',
			'card_desc'   => 'Reportes claros en tiempo real de lo que cobras y descuentas.',
			'tagline'     => 'Ves exactamente lo que se cobra, se descuenta y se liquida, antes de que el dinero toque tu cuenta.',
			'icon'        => '📊',
			'accent'      => 'blue',
			'video_label' => 'Video: cómo se ven tus reportes mensuales',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Cada movimiento queda documentado y visible en tiempo real:',
				'items' => array(
					'Consolida lo cobrado, lo pendiente y los descuentos por inquilino y propiedad.',
					'Muestra cuánto recibirás antes de cada transferencia, sin sorpresas.',
					'Archiva el historial completo de cada movimiento.',
					'Te entrega un reporte claro y detallado al cierre de cada mes.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Cada cargo se registra solo',
						'text'  => 'Facturas, pagos y descuentos se registran automáticamente.',
					),
					array(
						'title' => 'El sistema agrupa la operación',
						'text'  => 'Cobra, pendiente y mora se consolidan por unidad.',
					),
					array(
						'title' => 'Revisas antes del pago',
						'text'  => 'Sabes a cuánto asciende tu saldo antes de que te lo transfieran.',
					),
					array(
						'title' => 'Recibes el reporte mensual',
						'text'  => 'Detalle claro y puntual junto con tu liquidación.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '100%', 'label' => 'Movimientos conciliados' ),
				array( 'value' => '1 vez', 'label' => 'Reporte al mes, sin excepciones' ),
				array( 'value' => '0', 'label' => 'Sorpresas al recibir tu saldo' ),
			),
			'beneficios'  => array(
				'Cobrado vs pendiente en un vistazo, por inquilino y por propiedad.',
				'Saldo neto visible antes de cada transferencia.',
				'Historial completo archivado y consultable de cualquier mes.',
			),
			'faq'         => array(
				array(
					'q' => '¿Puedo ver meses anteriores?',
					'a' => 'Sí. Todo el historial queda archivado y es consultable cuando quieras.',
				),
				array(
					'q' => '¿Qué incluye el reporte?',
					'a' => 'Cada cargo, descuento y pago, desglosado por unidad e inquilino.',
				),
				array(
					'q' => '¿Recibo reporte aunque no haya movimiento en el mes?',
					'a' => 'Sí. Cada mes recibes tu reporte junto con la liquidación, puntual y detallado.',
				),
			),
			'cta'         => $demo_url,
		),
		'contratos-en-regla'  => array(
			'slug'        => 'contratos-en-regla',
			'title'       => 'Contratos en regla',
			'eyebrow'     => 'Cobertura legal',
			'card_title'  => 'Contratos en regla',
			'card_desc'   => 'Documentos legales guardados y al día sin mover un dedo.',
			'tagline'     => 'Contratos archivados, vencimientos controlados y cumplimiento normativo automático.',
			'icon'        => '⚖️',
			'accent'      => 'violet',
			'video_label' => 'Video: tu respaldo legal con Arriendo Fácil',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Tu propiedad siempre operada dentro del marco legal:',
				'items' => array(
					'Archiva contratos y documentos legales en un solo lugar accesible.',
					'Controla vencimientos y te avisa con anticipación (30/60/90 días).',
					'Genera actas y documentos de soporte automáticamente.',
					'Aplica cumplimiento normativo sin que hagas nada.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Cargas tu contrato',
						'text'  => 'Subes el contrato y los datos de la propiedad.',
					),
					array(
						'title' => 'El sistema extrae lo importante',
						'text'  => 'Fechas, montos y cláusulas quedan registrados.',
					),
					array(
						'title' => 'Recibes alertas',
						'text'  => 'Te avisamos antes de cada vencimiento o renovación.',
					),
					array(
						'title' => 'Todo archivado y en regla',
						'text'  => 'Documentación siempre accesible y cumplimiento asegurado.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '60 días', 'label' => 'De anticipación para el vencimiento' ),
				array( 'value' => '1 lugar', 'label' => 'Central para tus documentos legales' ),
				array( 'value' => '0', 'label' => 'Vencimientos olvidados' ),
			),
			'beneficios'  => array(
				'Alertas de vencimiento con hasta 60 días de anticipación.',
				'Actas y documentos de soporte generados automáticamente.',
				'Cumplimiento normativo aplicado solo, sin que hagas nada.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué documentos puedo archivar?',
					'a' => 'Contratos, actas, garantías y cualquier respaldo legal de la propiedad.',
				),
				array(
					'q' => '¿Cómo sabe el sistema cuándo vence un contrato?',
					'a' => 'Lee las fechas de cada contrato y programa alertas automáticas de renovación.',
				),
				array(
					'q' => '¿Los inquilinos ven los contratos?',
					'a' => 'Compartes únicamente la documentación que tú decidas mostrarles.',
				),
			),
			'cta'         => $demo_url,
		),
		'servicios-por-consumo' => array(
			'slug'        => 'servicios-por-consumo',
			'title'       => 'Servicios por consumo real',
			'eyebrow'     => 'Medidores exactos',
			'card_title'  => 'Servicios por consumo real',
			'card_desc'   => 'Agua, luz y gas medidos y facturados sin errores.',
			'tagline'     => 'Registramos las lecturas de cada medidor y cada unidad paga solo lo que consume.',
			'icon'        => '💧',
			'accent'      => 'teal',
			'video_label' => 'Video: facturación de servicios por consumo',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Los servicios básicos dejan de ser un dolor de cabeza:',
				'items' => array(
					'Registra las lecturas de cada medidor, sin errores de cálculo.',
					'Prorratea el consumo exacto por unidad.',
					'Factura agua, luz y gas por separado.',
					'Cobra los servicios junto con el canon en la misma fecha.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Registras la lectura inicial',
						'text'  => 'Cada medidor queda configurado con su punto de partida.',
					),
					array(
						'title' => 'Actualizas lecturas',
						'text'  => 'Ingresas o sincronizas la lectura del período.',
					),
					array(
						'title' => 'El sistema calcula',
						'text'  => 'Consumo y costo por unidad, sin aproximaciones.',
					),
					array(
						'title' => 'Se factura y cobra solo',
						'text'  => 'Los servicios se suman al canon y se cobran en la fecha exacta.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '0', 'label' => 'Errores de prorrateo' ),
				array( 'value' => '1', 'label' => 'Lectura por medidor y período' ),
				array( 'value' => '3+', 'label' => 'Servicios en una sola factura' ),
			),
			'beneficios'  => array(
				'Cada unidad paga exactamente lo que consume.',
				'Lecturas registradas, auditables y recalculables.',
				'Servicios y canon se cobran juntos en la misma fecha.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué medidores puedo registrar?',
					'a' => 'Agua, luz, gas y los servicios que definas por unidad o por edificio.',
				),
				array(
					'q' => '¿Qué pasa si no llega una lectura a tiempo?',
					'a' => 'Puedes estimarla por unidad y se ajusta automáticamente en el período siguiente.',
				),
				array(
					'q' => '¿Se cobra por unidad o por edificio?',
					'a' => 'Por unidad, con prorrateo exacto del consumo real de cada una.',
				),
			),
			'cta'         => $demo_url,
		),
		'control-de-mora'     => array(
			'slug'        => 'control-de-mora',
			'title'       => 'Control de pagos',
			'eyebrow'     => 'Alertas tempranas',
			'card_title'  => 'Control de pagos',
			'card_desc'   => 'Alertas tempranas de cobro y retraso en pagos.',
			'tagline'     => 'Recibes alertas tempranas de cobro y de retraso en pagos, con recordatorios automáticos, para actuar antes de que el atraso escale.',
			'icon'        => '⏰',
			'accent'      => 'amber',
			'video_label' => 'Video: alertas tempranas de cobro y pagos',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Alertas tempranas de cobro y retraso en pagos, antes de que el atraso escale:',
				'items' => array(
					'Detecta el vencimiento el primer día y te avisa al instante.',
					'Envía recordatorios automáticos de cobro por WhatsApp y correo.',
					'Escala las alertas de forma gradual hasta que el pago se regulariza.',
					'Te advierte del riesgo de atraso a tiempo, para que decidas informado.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Se detecta el cargo por pagar',
						'text'  => 'El sistema identifica el cargo vencido al primer día.',
					),
					array(
						'title' => 'Alerta temprana de cobro',
						'text'  => 'Recibes el aviso y el inquilino un recordatorio amable por WhatsApp.',
					),
					array(
						'title' => 'Escala la alerta',
						'text'  => 'Avisos progresivos hasta que el pago se regulariza.',
					),
					array(
						'title' => 'Tú decides informado',
						'text'  => 'Alertas de riesgo antes de que el retraso en pagos escale.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => 'Día 1', 'label' => 'Se detecta el cargo vencido' ),
				array( 'value' => 'Auto', 'label' => 'Alertas y recordatorios graduales' ),
				array( 'value' => 'Antes', 'label' => 'Señales tempranas para actuar a tiempo' ),
			),
			'beneficios'  => array(
				'Alertas tempranas que no dañan la relación con tu inquilino.',
				'Escalamiento progresivo y configurable por propiedad.',
				'Menos retrasos en pagos y reportes de riesgo para decidir informado.',
			),
			'faq'         => array(
				array(
					'q' => '¿En qué canal se envían los recordatorios?',
					'a' => 'Por correo y mensajería, configurable. Tú eliges el canal y la frecuencia.',
				),
				array(
					'q' => '¿Qué pasa si el inquilino sigue sin pagar?',
					'a' => 'El flujo escala de forma gradual y recibes alertas tempranas de riesgo antes de que el atraso crezca.',
				),
				array(
					'q' => '¿Puedo desactivar los recordatorios?',
					'a' => 'Sí, por propiedad o por inquilino, y reactivarlos cuando quieras.',
				),
			),
			'cta'         => $demo_url,
		),
		'inquilinos-evaluados' => array(
			'slug'        => 'inquilinos-evaluados',
			'title'       => 'Inquilinos evaluados',
			'eyebrow'     => 'Decisión con respaldo',
			'card_title'  => 'Inquilinos evaluados',
			'card_desc'   => 'Historial de pago, referencias y scores simples.',
			'tagline'     => 'Revisamos historial y referencias de cada candidato para que firmes solo con inquilinos confiables.',
			'icon'        => '🔍',
			'accent'      => 'rose',
			'video_label' => 'Video: cómo evaluamos a tus inquilinos',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Cada candidato queda evaluado antes de firmar:',
				'items' => array(
					'Revisa el historial de pago del candidato.',
					'Valida referencias personales y laborales.',
					'Arma un score de riesgo simple de entender.',
					'Recomienda aprobar o rechazar, con el expediente completo.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'El candidato se registra',
						'text'  => 'Completa su información y autoriza la revisión.',
					),
					array(
						'title' => 'Revisamos historial y referencias',
						'text'  => 'Pago, referencias y comportamiento quedan validados.',
					),
					array(
						'title' => 'Obtenés el score',
						'text'  => 'Una calificación clara del riesgo de cada candidato.',
					),
					array(
						'title' => 'Firmas rápido y seguro',
						'text'  => 'Decides con toda la información, sin adivinar.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '1 score', 'label' => 'De riesgo, simple de entender' ),
				array( 'value' => '100%', 'label' => 'Historial de pago verificado' ),
				array( 'value' => 'Firme', 'label' => 'Con expediente completo' ),
			),
			'beneficios'  => array(
				'Decides con datos, no con corazonadas.',
				'Expediente completo de cada candidato.',
				'Recomendación de aprobar o rechazar, documentada.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué revisa la evaluación?',
					'a' => 'Historial de pago, referencias y validación de identidad del candidato.',
				),
				array(
					'q' => '¿El score cambia con el tiempo?',
					'a' => 'Sí. Se actualiza según el comportamiento de pago del inquilino.',
				),
				array(
					'q' => '¿Qué hago si un candidato no aprueba?',
					'a' => 'Lo rechazas con un expediente documentado y sin ambigüedades.',
				),
			),
			'cta'         => $demo_url,
		),
	);
}

/**
 * URL canónica de la página de detalle de un servicio.
 */
function af_service_detail_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . $slug . '/' );
}

/**
 * Devuelve la configuración de un servicio según su slug (o null).
 */
function af_service_config( $slug ) {
	$services = af_services_config();
	return isset( $services[ $slug ] ) ? $services[ $slug ] : null;
}

/**
 * ID de video (YouTube) configurable por servicio.
 * Se puede definir por opción (af_video_COBROIT...) o filtrando "af_service_video_id".
 */
function af_service_video_id( $slug ) {
	$option = get_option( 'af_service_video_' . $slug, '' );
	return (string) apply_filters( 'af_service_video_id', $option, $slug );
}

/**
 * HTML del video explicativo. Si no hay ID configurado muestra un placeholder.
 */
function af_service_video_html( $svc ) {
	$video_id = af_service_video_id( $svc['slug'] );
	$label    = isset( $svc['video_label'] ) ? $svc['video_label'] : ( $svc['title'] . ' — video explicativo' );
	$icon     = isset( $svc['icon'] ) ? $svc['icon'] : '▶';

	$markup = '<div class="af-video af-video--' . esc_attr( $svc['accent'] ) . '">';

	if ( $video_id ) {
		$markup .= '<iframe class="af-video__embed" src="https://www.youtube-nocookie.com/embed/' . esc_attr( $video_id ) . '" title="' . esc_attr( $label ) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>';
	} else {
		$markup .= '<div class="af-video__placeholder" role="img" aria-label="' . esc_attr( $label ) . '">';
		$markup .= '<span class="af-video__icon" aria-hidden="true">' . esc_html( $icon ) . '</span>';
		$markup .= '<span class="af-video__play" aria-hidden="true"><span></span></span>';
		$markup .= '<span class="af-video__text">' . esc_html( $label ) . '</span>';
		$markup .= '<span class="af-video__note">Configura el ID del video en <code>af_service_video_' . esc_html( $svc['slug'] ) . '</code></span>';
		$markup .= '</div>';
	}

	$markup .= '</div>';

	return $markup;
}

/**
 * Lista de servicios (con selector para el color de la tarjeta).
 */
function af_service_cards( $which = 'all' ) {
	$services = af_services_config();
	if ( 'why' === $which ) {
		$services = wp_array_slice_assoc( $services, array( 'cobros-automaticos', 'reportes-mensuales', 'contratos-en-regla' ) );
	} elseif ( 'auto' === $which ) {
		$services = wp_array_slice_assoc( $services, array( 'cobros-automaticos', 'servicios-por-consumo', 'control-de-mora', 'inquilinos-evaluados' ) );
	}
	return $services;
}