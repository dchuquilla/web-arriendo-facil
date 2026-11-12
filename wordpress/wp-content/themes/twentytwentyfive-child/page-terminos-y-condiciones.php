<?php
/**
 * Template Name: Términos y Condiciones
 * Términos y condiciones de uso — rediseño ArriendoFácil.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_sections = array(

  array(
    'id'    => 'aceptacion',
    'icon'  => 'file',
    'title' => 'Aceptación y quiénes somos',
    'nav'   => 'Aceptación',
    'html'  => <<<'HTML'
<p>Estos Términos y Condiciones (los «Términos») regulan el acceso y uso de ArriendoFácil (el «Servicio»): el sitio web arriendofacil.net, el panel de gestión y los portales y enlaces que ponemos a disposición de administradores de propiedades, inquilinos y otras personas invitadas.</p>
<p>El Servicio lo presta <strong>Arriendo Fácil</strong> («ArriendoFácil», «nosotros»), con domicilio en Quito, Pichincha, República del Ecuador. Puedes escribirnos a <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a>.</p>
<p>Al crear una cuenta, marcar la casilla de aceptación, o usar el Servicio, declaras que leíste estos Términos y la <a href="/politica-de-privacidad/">Política de privacidad</a> y que los aceptas. Si no estás de acuerdo, no uses el Servicio.</p>
<div class="afx-callout"><p><strong>Si usas el Servicio en nombre de una empresa</strong> declaras tener facultades para obligarla. En ese caso, «tú» se refiere a la empresa y a la persona que la representa.</p></div>
HTML,
  ),

  array(
    'id'    => 'servicio',
    'icon'  => 'building',
    'title' => 'Qué es ArriendoFácil (y qué no es)',
    'nav'   => 'El Servicio',
    'html'  => <<<'HTML'
<p>ArriendoFácil es un <strong>sistema de gestión de propiedades en arriendo</strong> pensado para quienes administran inmuebles: administradores independientes, empresas administradoras y propietarios con varias propiedades. Permite, según el plan contratado:</p>
<ul>
<li>Registrar y organizar inmuebles, edificios y unidades.</li>
<li>Gestionar inquilinos y solicitantes, y recibir sus documentos mediante enlaces seguros.</li>
<li>Generar y administrar contratos de arrendamiento a partir de plantillas.</li>
<li>Llevar el control de cobros, pagos, mora, lecturas de medidores y alertas.</li>
<li>Coordinar mantenimiento y reparaciones con proveedores.</li>
<li>Usar calendario, avisos, reportes y catálogos de propiedades para compartir.</li>
<li>Sincronizar disponibilidad con plataformas como Airbnb y Booking.com.</li>
<li>Emitir comprobantes electrónicos del SRI (funcionalidad complementaria).</li>
<li>Apoyarte con funciones de inteligencia artificial (sección 8).</li>
</ul>
<div class="afx-callout afx-callout--warn"><p><strong>ArriendoFácil es una herramienta tecnológica.</strong> No somos inmobiliaria ni corredor, no intermediamos arrendamientos, no somos parte de los contratos entre administradores, propietarios e inquilinos, no somos un banco ni una pasarela de pagos (no recibimos, custodiamos ni transferimos dinero), no somos asesores legales, tributarios o contables, y no garantizamos el pago de ningún arriendo.</p></div>
HTML,
  ),

  array(
    'id'    => 'cuentas',
    'icon'  => 'users',
    'title' => 'Cuentas, roles y verificación',
    'nav'   => 'Cuentas y roles',
    'html'  => <<<'HTML'
<h3>Quién puede usar el Servicio</h3>
<p>Debes ser mayor de 18 años, tener capacidad legal para contratar y proporcionar información veraz, completa y actualizada. Podemos pedirte verificar tu correo electrónico y completar la verificación de identidad (cédula o RUC, y los documentos que se indiquen en tu perfil).</p>
<h3>Roles</h3>
<ul>
<li><strong>Administrador de propiedades:</strong> la persona o empresa que contrata el Servicio y gestiona su cartera. Es nuestro cliente y quien responde por sus datos y decisiones (sección 5).</li>
<li><strong>Inquilinos y solicitantes:</strong> personas que acceden a un portal o a un enlace de registro enviado por su administrador (sección 6).</li>
<li><strong>Propietarios y contactos, proveedores de mantenimiento y otros terceros:</strong> personas registradas por un administrador para operar sus inmuebles.</li>
</ul>
<h3>Tus credenciales</h3>
<p>Eres responsable de la actividad realizada con tu cuenta. Usa una contraseña única y robusta, no la compartas y avísanos de inmediato si sospechas un acceso no autorizado. Cada administrador ve únicamente su propia cartera. Los enlaces de registro o de calificación que enviamos son personales, tienen vencimiento y no deben reenviarse.</p>
HTML,
  ),

  array(
    'id'    => 'planes',
    'icon'  => 'wallet',
    'title' => 'Planes, precios y pagos',
    'nav'   => 'Planes y pagos',
    'html'  => <<<'HTML'
<p>ArriendoFácil se ofrece en distintos planes (por ejemplo <strong>Free</strong>, <strong>Básico</strong> y <strong>Profesional</strong>). Las funciones, los límites (como el número de propiedades), el tipo de soporte y los precios de cada plan son los publicados en la sección <a href="/#planes">Planes</a> al momento de contratar. El plan Free es gratuito y tiene funciones y número de propiedades limitados.</p>
<ul>
<li><strong>Precios e impuestos:</strong> los precios se expresan en dólares de los Estados Unidos de América; se informará si incluyen o no IVA u otros impuestos.</li>
<li><strong>Cambios de plan:</strong> puedes subir o bajar de plan. Si bajas a un plan con menos límites, deberás ajustar tu cartera para respetarlos; no eliminaremos tus datos por ese motivo.</li>
<li><strong>Cambios de precio:</strong> te avisaremos por correo con al menos 30 días de anticipación. Puedes cancelar antes de que el cambio aplique.</li>
<li><strong>Reembolsos:</strong> en planes de pago, no reembolsamos periodos ya iniciados, salvo cobro duplicado o erróneo, fraude comprobado o falla grave del Servicio imputable a nosotros. Esto no limita los derechos irrenunciables que la Ley Orgánica de Defensa del Consumidor reconoce a los consumidores.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'administrador',
    'icon'  => 'key',
    'title' => 'Tus responsabilidades como administrador',
    'nav'   => 'Responsabilidades',
    'html'  => <<<'HTML'
<p>Al gestionar inmuebles e información de terceros en ArriendoFácil, te comprometes a:</p>
<ol>
<li><strong>Tener legitimidad.</strong> Ser propietario del inmueble o contar con mandato, poder o autorización suficiente para administrarlo y celebrar contratos sobre él.</li>
<li><strong>Cumplir la ley.</strong> Respetar la Ley de Inquilinato y demás normas aplicables a arrendamientos, así como las normas tributarias, de consumo y de no discriminación.</li>
<li><strong>Responder por tus contratos.</strong> Los contratos de arrendamiento y sus condiciones son exclusivamente entre tú, el propietario y el inquilino. Tú decides a quién arriendas, a qué precio y bajo qué condiciones.</li>
<li><strong>Cuidar los datos personales de terceros.</strong> Respecto de los datos de inquilinos, solicitantes, propietarios y proveedores que cargas o recolectas con el Servicio, <strong>tú eres el responsable del tratamiento</strong> y nosotros actuamos como tu encargado (ver <a href="/politica-de-privacidad/">Política de privacidad</a>). Debes contar con una base legal para tratarlos, informarles de forma clara el uso de sus datos y atender sus solicitudes de derechos.</li>
<li><strong>Enviar los enlaces de registro solo a personas con una relación legítima contigo</strong> y pedir únicamente los datos y documentos necesarios.</li>
<li><strong>Mantener tu información al día</strong> y conservar tus propios respaldos de los documentos importantes.</li>
</ol>
HTML,
  ),

  array(
    'id'    => 'inquilinos',
    'icon'  => 'user-plus',
    'title' => 'Inquilinos y personas invitadas',
    'nav'   => 'Inquilinos',
    'html'  => <<<'HTML'
<p>Si recibes un enlace o acceso a un portal de ArriendoFácil, lo hace tu administrador o arrendador. Allí puedes registrar tus datos, subir los documentos que se te soliciten, consultar tus cargos y pagos, solicitar mantenimiento y calificar la experiencia.</p>
<ul>
<li>Proporciona información veraz y documentos auténticos. Presentar documentos falsos puede tener consecuencias legales.</li>
<li>ArriendoFácil <strong>no es tu arrendador ni tu administrador</strong>. Las reclamaciones sobre el contrato, el precio, el depósito de garantía o el estado del inmueble debes dirigirlas a quien administra la propiedad.</li>
<li>Tus datos son tratados por tu administrador como responsable. Puedes ejercer tus derechos ante él o escribiéndonos; te ayudaremos a canalizar tu solicitud (ver <a href="/politica-de-privacidad/#derechos">Tus derechos</a>).</li>
<li>Las calificaciones que dejes deben ser veraces, respetuosas y basarse en hechos.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'contratos',
    'icon'  => 'scale',
    'title' => 'Contratos y documentos generados',
    'nav'   => 'Contratos',
    'html'  => <<<'HTML'
<p>ArriendoFácil te permite generar contratos y otros documentos a partir de tus propias plantillas, de modelos base o con ayuda de inteligencia artificial.</p>
<div class="afx-callout afx-callout--warn"><p><strong>Todo documento generado es un borrador.</strong> Antes de firmarlo debes revisarlo completo y, si tienes dudas, consultar a un abogado. Su contenido, validez y efectos son de tu exclusiva responsabilidad; ArriendoFácil no ofrece asesoría legal ni garantiza que un documento sea adecuado para un caso concreto.</p></div>
<p>La validez de firmas y mensajes de datos se rige por la Ley de Comercio Electrónico, Firmas Electrónicas y Mensajes de Datos y sus reglamentos. Los contratos y documentos que subes o generas se almacenan de forma privada y solo son accesibles por quienes tengan permiso en tu cuenta.</p>
HTML,
  ),

  array(
    'id'    => 'ia',
    'icon'  => 'sparkles',
    'title' => 'Funciones de inteligencia artificial',
    'nav'   => 'Inteligencia artificial',
    'html'  => <<<'HTML'
<p>El panel incluye herramientas de apoyo basadas en inteligencia artificial: estimar una renta de referencia, redactar o completar contratos a partir de una plantilla, interpretar campos de plantillas y generar una <strong>valoración orientativa</strong> de un solicitante o inquilino.</p>
<ul>
<li><strong>Se usan solo cuando alguien las solicita</strong> desde el panel. Para procesarlas enviamos a un proveedor externo de IA (Anthropic, con servidores fuera de Ecuador) únicamente los datos necesarios para esa tarea.</li>
<li><strong>Son ayudas, no decisiones.</strong> Los resultados pueden contener errores. La decisión de arrendar o no a una persona, el precio y el contenido de un contrato corresponden siempre a una persona, nunca únicamente a un resultado automático.</li>
<li><strong>No discrimines.</strong> No uses estas funciones para excluir personas por motivos protegidos por la ley (por ejemplo origen, género, discapacidad, religión o condición social).</li>
<li>Quien sea evaluado puede solicitar al administrador la revisión humana de cualquier decisión (ver <a href="/politica-de-privacidad/#ia-datos">Política de privacidad</a>).</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'cobros',
    'icon'  => 'clock',
    'title' => 'Cobros, pagos y facturación del SRI',
    'nav'   => 'Cobros y SRI',
    'html'  => <<<'HTML'
<h3>Control de pagos</h3>
<p>El Servicio <strong>registra y organiza</strong> cargos, pagos, mora y recordatorios. <strong>No procesa pagos ni administra dinero.</strong> Los cobros se realizan directamente entre quienes intervienen en el arriendo, por los medios que ellos acuerden. Los avisos y recordatorios automáticos son una ayuda: eres responsable de configurarlos correctamente y de verificar los saldos con tus propios soportes.</p>
<h3>Facturación electrónica (complemento)</h3>
<p>Si el plan lo incluye, puedes emitir comprobantes electrónicos conforme a la normativa del Servicio de Rentas Internas (SRI). Debes saber que:</p>
<ul>
<li><strong>Tú eres el emisor</strong> y responsable tributario de cada comprobante, de la veracidad de sus datos y de la configuración fiscal.</li>
<li>Cargas tu propia firma electrónica (certificado .p12), que se guarda cifrada y se usa solo para firmar tus comprobantes.</li>
<li>La autorización de cada comprobante la otorga el SRI. No respondemos por rechazos, demoras o caídas de sus servicios.</li>
<li>Por obligación tributaria, los comprobantes electrónicos y sus registros <strong>se conservan aunque cierres tu cuenta</strong> (ver sección 14 y la Política de privacidad).</li>
<li>No somos asesores tributarios. Consulta a tu contador ante cualquier duda.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'terceros',
    'icon'  => 'globe',
    'title' => 'Integraciones, proveedores y calificaciones',
    'nav'   => 'Terceros',
    'html'  => <<<'HTML'
<h3>Plataformas externas</h3>
<p>Puedes conectar calendarios de plataformas como Airbnb o Booking.com (por ejemplo mediante enlaces iCal). Las credenciales que registres se guardan cifradas. La sincronización puede tener retrasos o fallar por causas ajenas a nosotros; <strong>verifica tu disponibilidad</strong> antes de confirmar reservas. Las condiciones de cada plataforma las aceptas directamente con ella.</p>
<h3>Proveedores de mantenimiento y servicios</h3>
<p>Los proveedores son profesionales independientes. Aunque nuestro equipo pueda revisar su identidad y fotografía, esa revisión es informativa y <strong>no es una garantía</strong> de calidad, idoneidad ni de cumplimiento. La contratación y el pago del servicio se acuerdan directamente con el proveedor.</p>
<h3>Mensajería y catálogos</h3>
<p>Algunas funciones generan enlaces para compartir catálogos de propiedades o iniciar conversaciones (por ejemplo por WhatsApp). Tú decides con quién los compartes y eres responsable del contenido que publiques.</p>
<h3>Calificaciones</h3>
<p>Las calificaciones entre administradores e inquilinos deben ser veraces y respetuosas. Podemos retirar contenido ofensivo, falso, discriminatorio o que infrinja derechos de terceros.</p>
HTML,
  ),

  array(
    'id'    => 'contenido',
    'icon'  => 'lock',
    'title' => 'Tu contenido y propiedad intelectual',
    'nav'   => 'Contenido y PI',
    'html'  => <<<'HTML'
<p><strong>Tus datos son tuyos.</strong> Conservas la titularidad de la información, documentos y archivos que cargas. Nos otorgas una licencia limitada, no exclusiva y revocable para almacenarlos, procesarlos y mostrarlos con el único fin de prestarte el Servicio.</p>
<p>El software, el diseño, las marcas, los textos y demás elementos de ArriendoFácil son nuestros o de nuestros licenciantes y están protegidos por la normativa de propiedad intelectual. Se te otorga un derecho personal, limitado y no transferible para usar el Servicio mientras tengas una cuenta activa. No puedes copiarlo, revenderlo, descompilarlo ni extraer datos de forma masiva o automatizada.</p>
<p>Si crees que algún contenido vulnera tus derechos, escríbenos con la información necesaria para identificarlo y revisarlo.</p>
HTML,
  ),

  array(
    'id'    => 'uso',
    'icon'  => 'alert',
    'title' => 'Uso prohibido y suspensión',
    'nav'   => 'Uso prohibido',
    'html'  => <<<'HTML'
<p>No puedes usar el Servicio para:</p>
<ul>
<li>Actividades ilícitas, fraudulentas o que vulneren derechos de terceros, incluido el tratamiento de datos personales sin base legal.</li>
<li>Suplantar identidades, subir documentos falsos o registrar inmuebles que no puedes administrar.</li>
<li>Interferir con la seguridad o el funcionamiento del Servicio, probar vulnerabilidades sin autorización, o eludir límites de uso y de planes.</li>
<li>Enviar comunicaciones no solicitadas, acosar o discriminar.</li>
</ul>
<p>Si detectamos un incumplimiento, podemos limitar funciones o suspender la cuenta, avisándote cuando sea posible y salvo que exista urgencia por seguridad u obligación legal. Cuando proceda, daremos la oportunidad de corregir la situación.</p>
HTML,
  ),

  array(
    'id'    => 'disponibilidad',
    'icon'  => 'refresh',
    'title' => 'Disponibilidad, soporte y respaldos',
    'nav'   => 'Disponibilidad',
    'html'  => <<<'HTML'
<p>Trabajamos para que el Servicio esté disponible de forma continua, pero puede haber interrupciones por mantenimiento, fallas de terceros (hosting, conectividad, SRI, plataformas externas) o causas de fuerza mayor. Procuramos avisar con anticipación los mantenimientos programados.</p>
<p>Los canales y la prioridad de soporte dependen del plan (por ejemplo, el plan Profesional incluye soporte con chatbot, según lo publicado en <a href="/#planes">Planes</a>). Mantenemos copias de seguridad de la plataforma, pero te recomendamos conservar tus propios respaldos de los documentos críticos.</p>
HTML,
  ),

  array(
    'id'    => 'baja',
    'icon'  => 'trash',
    'title' => 'Baja de cuenta y terminación',
    'nav'   => 'Baja de cuenta',
    'html'  => <<<'HTML'
<p>Puedes dar de baja tu cuenta de administrador en cualquier momento desde tu perfil, confirmando la acción. Al hacerlo:</p>
<ol>
<li>La cuenta se <strong>desactiva</strong> y deja de poder iniciar sesión.</li>
<li>Nuestro equipo revisa la solicitud y puede reactivar la cuenta o <strong>eliminar definitivamente sus datos</strong>.</li>
<li>Se conservan, por obligación legal, los comprobantes electrónicos del SRI y sus registros durante el plazo tributario, y la información mínima necesaria para defender derechos o cumplir órdenes de autoridad.</li>
</ol>
<p>Antes de cerrar tu cuenta, descarga o solicita la copia de la información que necesites. También podemos dar por terminado el acceso por incumplimiento de estos Términos (sección 12) o cuando cesemos el Servicio, con aviso previo razonable.</p>
HTML,
  ),

  array(
    'id'    => 'responsabilidad',
    'icon'  => 'shield',
    'title' => 'Garantías y limitación de responsabilidad',
    'nav'   => 'Responsabilidad',
    'html'  => <<<'HTML'
<p>El Servicio se presta «tal como está» y según su disponibilidad. Dentro de lo que permite la ley:</p>
<ul>
<li>No garantizamos que el Servicio esté libre de errores ni que sirva para un fin particular.</li>
<li>No somos responsables por las decisiones que tomes, por el incumplimiento de inquilinos, propietarios o proveedores, por impagos, vacancia, pérdida de ingresos, ni por daños indirectos o consecuenciales.</li>
<li>Nuestra responsabilidad total frente a ti por cualquier reclamo relacionado con el Servicio se limita al monto que hayas pagado a ArriendoFácil en los 12 meses anteriores al hecho.</li>
</ul>
<div class="afx-callout"><p>Nada en estos Términos excluye ni limita la responsabilidad que no pueda excluirse por ley, incluida la derivada de dolo o culpa grave, ni los derechos irrenunciables de las personas consumidoras.</p></div>
HTML,
  ),

  array(
    'id'    => 'cambios',
    'icon'  => 'bell',
    'title' => 'Cambios a estos Términos',
    'nav'   => 'Cambios',
    'html'  => <<<'HTML'
<p>Podemos actualizar estos Términos por cambios legales, técnicos o del Servicio. Publicaremos la nueva versión con su fecha y, si el cambio es relevante, te avisaremos por correo con al menos <strong>30 días de anticipación</strong>. Si no estás de acuerdo, puedes cerrar tu cuenta antes de que entren en vigor; si continúas usando el Servicio después, entenderemos que los aceptas.</p>
HTML,
  ),

  array(
    'id'    => 'ley',
    'icon'  => 'scale',
    'title' => 'Ley aplicable y solución de controversias',
    'nav'   => 'Ley aplicable',
    'html'  => <<<'HTML'
<p>Estos Términos se rigen por las leyes de la República del Ecuador. Si surge una controversia, primero intentaremos resolverla de manera amistosa: escríbenos describiendo el caso y buscaremos una solución en un plazo de 15 días hábiles.</p>
<p>Si no se logra un acuerdo, las partes podrán acudir a mediación conforme a la Ley de Arbitraje y Mediación (por ejemplo, en un centro de mediación de Quito) o a los jueces competentes de la ciudad de Quito, sin perjuicio del derecho de las personas consumidoras a acudir ante la autoridad o juez de su domicilio.</p>
HTML,
  ),

  array(
    'id'    => 'contacto',
    'icon'  => 'mail',
    'title' => 'Datos, cookies y contacto',
    'nav'   => 'Contacto',
    'html'  => <<<'HTML'
<p>El tratamiento de datos personales se explica en la <a href="/politica-de-privacidad/">Política de privacidad</a> y el uso de cookies en la <a href="/cookie-policy-eu/">Política de cookies</a>; ambas forman parte de estos Términos.</p>
<p>Si alguna cláusula resulta inválida, el resto seguirá vigente. No podrás ceder tu cuenta sin nuestro consentimiento; nosotros podremos ceder el Servicio a una sociedad que continúe la operación, con aviso a los usuarios. Las notificaciones se harán al correo registrado en tu cuenta y a las que nos envíes a la dirección de contacto.</p>
<ul>
<li><strong>Titular del Servicio:</strong> Arriendo Fácil — Quito, Pichincha, Ecuador</li>
<li><strong>Correo de contacto, legal y privacidad:</strong> <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a></li>
</ul>
HTML,
  ),
);

get_template_part(
  'template-parts/afx-legal',
  null,
  array(
    'slug'     => 'terminos-y-condiciones',
    'tag'      => 'Documentos legales',
    'title'    => 'Términos y',
    'accent'   => 'condiciones',
    'lead'     => 'Las reglas claras para usar ArriendoFácil: qué ofrecemos, qué esperamos de ti y cómo nos hacemos cargo de lo que nos corresponde.',
    'meta'     => array( 'Versión 3.0', 'Vigente desde el 12 de noviembre de 2026', 'Aplica en Ecuador' ),
    'summary'  => array(
      'ArriendoFácil es <strong>un sistema de gestión para administradores de propiedades</strong>; no es inmobiliaria, banco ni asesor legal.',
      '<strong>Tus datos son tuyos.</strong> Nosotros los tratamos solo para prestarte el servicio; tú eres responsable de los datos de tus inquilinos.',
      '<strong>No procesamos pagos.</strong> Registramos y controlamos cobros; el dinero se mueve directamente entre las partes.',
      'Los contratos y textos con <strong>IA son borradores</strong> que debes revisar; ninguna decisión sobre personas la toma solo la IA.',
      'La facturación electrónica del SRI es un complemento: <strong>el emisor y responsable tributario eres tú</strong>.',
      'Puedes darte de baja cuando quieras; solo conservamos lo que la ley nos obliga (p. ej. comprobantes del SRI).',
    ),
    'sections' => $afx_sections,
  )
);

get_footer();
