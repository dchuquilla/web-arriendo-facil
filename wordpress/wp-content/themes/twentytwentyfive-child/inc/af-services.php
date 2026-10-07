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
		'facturacion-electronica' => array(
			'slug'        => 'facturacion-electronica',
			'title'       => 'Facturación electrónica',
			'eyebrow'     => 'Cumplimiento SRI',
			'card_title'  => 'Facturación electrónica',
			'card_desc'   => 'Comprobantes válidos ante el SRI, emitidos sin errores.',
			'tagline'     => 'Emitimos tus facturas electrónicas con firma digital y las autorizamos ante el SRI, para que siempre estés al día.',
			'icon'        => '🧾',
			'accent'      => 'green',
			'video_label' => 'Video: cómo funciona la facturación electrónica',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Todo el ciclo de facturación, desde el cargo hasta el comprobante autorizado:',
				'items' => array(
					'Calcula el canon, la administración, las alícuotas y los servicios de cada mes.',
					'Emite comprobantes electrónicos firmados con tu certificado (.p12/.pfx).',
					'Los envía al SRI y registra su autorización, anulación o pendiente.',
					'Entrega la factura al inquilino y la archiva con su historial.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Configuras una sola vez',
						'text'  => 'Cargas tu usuario SRI y tu firma electrónica de forma segura.',
					),
					array(
						'title' => 'Se genera el cargo',
						'text'  => 'Cada mes se calculan canon, alícuotas y servicios por consumo.',
					),
					array(
						'title' => 'Emites con un clic',
						'text'  => 'El administrador revisa y autoriza la emisión del comprobante.',
					),
					array(
						'title' => 'Queda todo archivado',
						'text'  => 'Historial de emitidas, anuladas y pendientes, con filtros y búsqueda.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => 'SRI', 'label' => 'Comprobantes autorizados' ),
				array( 'value' => '1 clic', 'label' => 'Para emitir cada factura' ),
				array( 'value' => '0', 'label' => 'Errores de cálculo' ),
			),
			'beneficios'  => array(
				'Factura electrónica válida ante el SRI en cada cobro.',
				'Canon, administración, alícuotas y servicios en un solo comprobante.',
				'Historial completo de emitidas, anuladas y pendientes.',
			),
			'faq'         => array(
				array(
					'q' => '¿Las facturas son válidas para el SRI?',
					'a' => 'Sí. Cada comprobante se firma electrónicamente y se autoriza ante el SRI.',
				),
				array(
					'q' => '¿Quién autoriza la emisión?',
					'a' => 'El administrador, con un clic explícito. Nada se emite sin su revisión.',
				),
				array(
					'q' => '¿Puedo configurar conceptos distintos por propiedad?',
					'a' => 'Sí. Defines canon, administración, alícuotas y servicios por propiedad.',
				),
			),
			'cta'         => $demo_url,
		),
		'mantenimiento'       => array(
			'slug'        => 'mantenimiento',
			'title'       => 'Mantenimiento',
			'eyebrow'     => 'Propiedad cuidada',
			'card_title'  => 'Mantenimiento',
			'card_desc'   => 'Incidencias atendidas y registradas, con costos claros.',
			'tagline'     => 'Coordinamos cada reparación con proveedores de confianza y dejamos el costo registrado para tu liquidación.',
			'icon'        => '🛠️',
			'accent'      => 'amber',
			'video_label' => 'Video: cómo gestionamos el mantenimiento',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Cada incidencia queda atendida y documentada de principio a fin:',
				'items' => array(
					'Registra qué está dañado, dónde y con qué prioridad (alta, media o baja).',
					'Asigna un proveedor de confianza (plomero, albañil, carpintero…) y agenda la visita.',
					'Controla el estado: pendiente, en proceso, completado o cancelado.',
					'Descuenta el costo en tu liquidación o en la garantía, según corresponda.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Se reporta la incidencia',
						'text'  => 'Queda registrado qué se dañó, dónde y qué tan urgente es.',
					),
					array(
						'title' => 'Asignamos proveedor',
						'text'  => 'Elegimos del catálogo al oficio adecuado y pactamos la fecha de visita.',
					),
					array(
						'title' => 'Se repara y se da seguimiento',
						'text'  => 'El estado se actualiza hasta completar el trabajo.',
					),
					array(
						'title' => 'Costo en tu liquidación',
						'text'  => 'El gasto aparece detallado en tu reporte mensual.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '3', 'label' => 'Niveles de prioridad' ),
				array( 'value' => '1', 'label' => 'Catálogo de proveedores' ),
				array( 'value' => '100%', 'label' => 'Costos registrados' ),
			),
			'beneficios'  => array(
				'Incidencias priorizadas y atendidas sin que tú intervengas.',
				'Proveedores de confianza con tarifas y contacto a la mano.',
				'Costos trazables, descontados en liquidación o garantía.',
			),
			'faq'         => array(
				array(
					'q' => '¿Quién paga las reparaciones?',
					'a' => 'El costo queda registrado y se descuenta en tu liquidación o en la garantía del inquilino, según el caso.',
				),
				array(
					'q' => '¿Puedo ver el avance de una reparación?',
					'a' => 'Sí. Cada solicitud muestra su estado, proveedor y fecha pactada.',
				),
				array(
					'q' => '¿Qué tipos de incidencias se gestionan?',
					'a' => 'Plomería, electricidad, albañilería, carpintería, limpieza y cualquier oficio de tu catálogo.',
				),
			),
			'cta'         => $demo_url,
		),
		'reportes-mensuales'  => array(
			'slug'        => 'reportes-mensuales',
			'title'       => 'Reportes mensuales',
			'eyebrow'     => 'Transparencia total',
			'card_title'  => 'Transparencia total',
			'card_desc'   => 'Panel con cobros, ocupación y alertas de tu operación en un vistazo.',
			'tagline'     => 'Un Panel de control con el semáforo de cobros, la ocupación y los vencimientos de tus propiedades, más la liquidación que recibes cada mes.',
			'icon'        => '📊',
			'accent'      => 'blue',
			'video_label' => 'Video: cómo se ven tus reportes mensuales',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'El Panel concentra toda tu operación en una sola pantalla:',
				'items' => array(
					'Semáforo de cobros: cobrado, pendiente y atrasado, con los días de mora.',
					'Resumen de propiedades, contratos e inquilinos, con gráficos de ocupación e ingresos.',
					'Alertas de calendario y contratos por vencer a 30, 60 y 90 días.',
					'Resumen de mantenimientos por prioridad y liquidación mensual al propietario.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Cada movimiento se registra',
						'text'  => 'Cargos, pagos, mantenimientos y contratos alimentan el Panel automáticamente.',
					),
					array(
						'title' => 'El Panel lo consolida',
						'text'  => 'Semáforo de cobros, ocupación y alertas por propiedad o edificio.',
					),
					array(
						'title' => 'Filtras lo que necesitas',
						'text'  => 'Por rango de fechas, edificio o propiedad.',
					),
					array(
						'title' => 'Recibes tu liquidación',
						'text'  => 'Cada mes, lo cobrado, lo gastado y lo que te corresponde.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '3', 'label' => 'Estados de cobro: cobrado, pendiente, atrasado' ),
				array( 'value' => '30/60/90', 'label' => 'Días de aviso de vencimientos' ),
				array( 'value' => '1 vez', 'label' => 'Liquidación al mes' ),
			),
			'beneficios'  => array(
				'Cobrado vs pendiente vs atrasado en un vistazo.',
				'Gráficos de ocupación e ingresos por arriendos.',
				'Liquidación mensual con cobros, gastos y saldo a tu favor.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué veo en el Panel?',
					'a' => 'Semáforo de cobros, ocupación, ingresos, contratos por vencer, alertas de calendario y mantenimientos por prioridad.',
				),
				array(
					'q' => '¿Puedo filtrar por propiedad o por fechas?',
					'a' => 'Sí. El Panel se filtra por rango de fechas, edificio y propiedad.',
				),
				array(
					'q' => '¿Qué incluye la liquidación mensual?',
					'a' => 'Lo cobrado, los gastos de mantenimiento descontados y el saldo que te corresponde, en un documento imprimible.',
				),
			),
			'cta'         => $demo_url,
		),
		'contratos-en-regla'  => array(
			'slug'        => 'contratos-en-regla',
			'title'       => 'Contratos en regla',
			'eyebrow'     => 'Cobertura legal',
			'card_title'  => 'Contratos en regla',
			'card_desc'   => 'Contratos generados, notarizados y con vencimientos controlados.',
			'tagline'     => 'Generamos el contrato desde plantilla, seguimos su notarización y te avisamos antes de cada vencimiento.',
			'icon'        => '⚖️',
			'accent'      => 'violet',
			'video_label' => 'Video: tu respaldo legal con Arriendo Fácil',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'La sección Contratos cubre todo el ciclo del arriendo:',
				'items' => array(
					'Crea el contrato vinculando inmueble e inquilino, con fechas, canon, alícuota y día de pago.',
					'Genera el documento desde una plantilla y lo archiva en el expediente.',
					'Registra el estado: activo o terminado, y notarización pendiente, en proceso o notarizado.',
					'Avisa los contratos por vencer a 30, 60 y 90 días y liquida la garantía al salir.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Se crea el contrato',
						'text'  => 'Inmueble, inquilino, fechas, canon, alícuota y día de pago.',
					),
					array(
						'title' => 'Se genera el documento',
						'text'  => 'A partir de la plantilla, listo para firma y notarización.',
					),
					array(
						'title' => 'Seguimos el estado legal',
						'text'  => 'Pendiente, en proceso o notarizado, visible en la ficha del inquilino.',
					),
					array(
						'title' => 'Control de vencimiento y salida',
						'text'  => 'Alertas anticipadas y liquidación de garantía al check-out.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '30/60/90', 'label' => 'Días de aviso antes del vencimiento' ),
				array( 'value' => '3', 'label' => 'Estados de notarización' ),
				array( 'value' => '1', 'label' => 'Expediente digital por inquilino' ),
			),
			'beneficios'  => array(
				'Contrato generado desde plantilla, sin redactar desde cero.',
				'Estado de notarización siempre visible.',
				'Alertas de vencimiento y garantía liquidada al salir el inquilino.',
			),
			'faq'         => array(
				array(
					'q' => '¿Cómo se genera el contrato?',
					'a' => 'Desde una plantilla, con los datos del inmueble y del inquilino ya cargados.',
				),
				array(
					'q' => '¿Cómo sé cuándo vence un contrato?',
					'a' => 'El sistema calcula las fechas y avisa a 30, 60 y 90 días antes.',
				),
				array(
					'q' => '¿Qué pasa con la garantía al terminar?',
					'a' => 'Se liquida en la salida, descontando daños y consumos pendientes.',
				),
			),
			'cta'         => $demo_url,
		),
		'servicios-por-consumo' => array(
			'slug'        => 'servicios-por-consumo',
			'title'       => 'Servicios por consumo real',
			'eyebrow'     => 'Medidores exactos',
			'card_title'  => 'Servicios por consumo real',
			'card_desc'   => 'Agua, luz y gas por medidor, cobrados junto al canon.',
			'tagline'     => 'En Pagos de servicios registramos la lectura de cada medidor y generamos el cargo de lo que realmente consume cada unidad.',
			'icon'        => '💧',
			'accent'      => 'teal',
			'video_label' => 'Video: facturación de servicios por consumo',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'La sección Pagos de servicios convierte cada lectura en un cargo:',
				'items' => array(
					'Registra la lectura de cada medidor (agua, luz, gas) por propiedad.',
					'Calcula el consumo del período y su costo exacto por unidad.',
					'Genera el cargo automáticamente, sumado al canon y la alícuota.',
					'Permite programar, registrar el pago y emitir el cobro del servicio.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Se registra la lectura',
						'text'  => 'Ingresas la lectura del período de cada medidor.',
					),
					array(
						'title' => 'El sistema calcula',
						'text'  => 'Consumo y costo por unidad, sin aproximaciones.',
					),
					array(
						'title' => 'Se genera el cargo',
						'text'  => 'El servicio se suma al canon y la alícuota del inquilino.',
					),
					array(
						'title' => 'Se registra el pago',
						'text'  => 'Queda constancia del pago y del saldo pendiente.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '0', 'label' => 'Errores de prorrateo' ),
				array( 'value' => '1', 'label' => 'Lectura por medidor y período' ),
				array( 'value' => '3+', 'label' => 'Servicios por medidor' ),
			),
			'beneficios'  => array(
				'Cada unidad paga exactamente lo que consume.',
				'Lecturas registradas por medidor y período.',
				'Servicio, canon y alícuota en un mismo estado de cuenta.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué medidores puedo registrar?',
					'a' => 'Agua, luz, gas y los servicios que definas por unidad o por edificio.',
				),
				array(
					'q' => '¿Qué pasa si falta una lectura?',
					'a' => 'Se registra cuando esté disponible y el cargo se calcula con esa lectura.',
				),
				array(
					'q' => '¿Se cobra por unidad o por edificio?',
					'a' => 'Por unidad, con el consumo real de cada medidor.',
				),
			),
			'cta'         => $demo_url,
		),
		'control-de-mora'     => array(
			'slug'        => 'control-de-mora',
			'title'       => 'Control de pagos',
			'eyebrow'     => 'Alertas tempranas',
			'card_title'  => 'Control de pagos',
			'card_desc'   => 'Cobros del mes, semáforo de pagos y días de mora.',
			'tagline'     => 'En Cobranza de inmuebles ves cada cargo del mes, registras los pagos y detectamos los atrasos desde el primer día.',
			'icon'        => '⏰',
			'accent'      => 'amber',
			'video_label' => 'Video: alertas tempranas de cobro y pagos',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'La sección Cobranza de inmuebles centraliza lo que se debe y lo que se pagó:',
				'items' => array(
					'Emite cada mes el cargo de canon y alícuota de forma automática.',
					'Registra cada pago con monto, fecha y referencia.',
					'Marca los cargos vencidos como atrasados cada día y cuenta los días de mora.',
					'Muestra el semáforo: cobrado, pendiente y atrasado.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Se emite el cargo',
						'text'  => 'Canon, alícuota y servicios quedan cargados en la fecha pactada.',
					),
					array(
						'title' => 'Se registra el pago',
						'text'  => 'Monto, fecha y referencia quedan asentados en la cobranza.',
					),
					array(
						'title' => 'Detectamos el atraso',
						'text'  => 'Cada día se marcan los cargos vencidos y se cuentan los días de mora.',
					),
					array(
						'title' => 'Actúas con el semáforo',
						'text'  => 'Los top en mora quedan a la vista para dar seguimiento.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => 'Diario', 'label' => 'Revisión de cargos vencidos' ),
				array( 'value' => '3', 'label' => 'Estados: cobrado, pendiente, atrasado' ),
				array( 'value' => 'Día 1', 'label' => 'Se detecta el atraso' ),
			),
			'beneficios'  => array(
				'Cargo mensual de canon y alícuota emitido sin intervención.',
				'Semáforo y días de mora siempre actualizados.',
				'Cada pago registrado con monto, fecha y referencia.',
			),
			'faq'         => array(
				array(
					'q' => '¿Cuándo se marca un pago como atrasado?',
					'a' => 'Un proceso diario marca como atrasado todo cargo vencido y empieza a contar los días de mora.',
				),
				array(
					'q' => '¿Qué datos se registran de un pago?',
					'a' => 'Monto, fecha y referencia, ligados al cargo del inquilino.',
				),
				array(
					'q' => '¿Cómo afecta la puntualidad al inquilino?',
					'a' => 'El historial de pagos alimenta su score de pago real en su ficha.',
				),
			),
			'cta'         => $demo_url,
		),
		'inquilinos-evaluados' => array(
			'slug'        => 'inquilinos-evaluados',
			'title'       => 'Inquilinos evaluados',
			'eyebrow'     => 'Decisión con respaldo',
			'card_title'  => 'Inquilinos evaluados',
			'card_desc'   => 'Ficha del inquilino, documentos verificados y score de pago.',
			'tagline'     => 'En Inquilinos centralizamos sus datos y verificamos sus documentos, para que firmes solo con personas validadas.',
			'icon'        => '🔍',
			'accent'      => 'rose',
			'video_label' => 'Video: cómo evaluamos a tus inquilinos',
			'que'         => array(
				'title' => '¿Qué hace el sistema?',
				'intro' => 'Cada inquilino tiene una ficha con su perfil y su documentación:',
				'items' => array(
					'Recibe sus datos y documentos (cédula, certificado laboral y bancario) mediante un enlace seguro.',
					'Valida la identidad con el dígito verificador y cotejo del documento.',
					'El administrador aprueba o rechaza cada documento tras revisarlo.',
					'Muestra su historial de contratos, puntualidad de pago y calificaciones.',
				),
			),
			'como'        => array(
				'title' => 'Cómo se hace',
				'steps' => array(
					array(
						'title' => 'Se envía el enlace',
						'text'  => 'El inquilino completa sus datos y sube sus documentos.',
					),
					array(
						'title' => 'Validamos identidad',
						'text'  => 'Verificación automática de la cédula como apoyo a la revisión.',
					),
					array(
						'title' => 'Revisión humana',
						'text'  => 'El administrador aprueba o rechaza cada documento.',
					),
					array(
						'title' => 'Ficha completa',
						'text'  => 'Documentos, contratos, score de pago y reseñas en un solo lugar.',
					),
				),
			),
			'datos'       => array(
				array( 'value' => '3', 'label' => 'Documentos requeridos' ),
				array( 'value' => '1', 'label' => 'Ficha única por inquilino' ),
				array( 'value' => 'Manual', 'label' => 'Aprobación final del administrador' ),
			),
			'beneficios'  => array(
				'Documentos guardados de forma privada y segura.',
				'Verificación de identidad con criterio humano.',
				'Score de pago real basado en su historial.',
			),
			'faq'         => array(
				array(
					'q' => '¿Qué documentos se verifican?',
					'a' => 'Cédula, certificado laboral y certificado bancario, subidos por el inquilino mediante un enlace seguro.',
				),
				array(
					'q' => '¿La verificación es automática?',
					'a' => 'La validación de la cédula es una señal de apoyo; la decisión de aprobar o rechazar es siempre del administrador.',
				),
				array(
					'q' => '¿Dónde se guardan los documentos?',
					'a' => 'En almacenamiento privado, accesible solo para quien administra la propiedad.',
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
		$services = wp_array_slice_assoc( $services, array( 'facturacion-electronica', 'reportes-mensuales', 'contratos-en-regla' ) );
	} elseif ( 'auto' === $which ) {
		$services = wp_array_slice_assoc( $services, array( 'mantenimiento', 'servicios-por-consumo', 'control-de-mora', 'inquilinos-evaluados' ) );
	}
	return $services;
}