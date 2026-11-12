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
<p>El Servicio lo presta <strong>Arriendo Fácil</strong> («ArriendoFácil», «nosotros»), con domicilio en Quito, Pichincha, República del Ecuador. Puede escribirnos a <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a>.</p>
<p>Al crear una cuenta, marcar la casilla de aceptación, o usar el Servicio, declara que leyó estos Términos y la <a href="/politica-de-privacidad/">Política de privacidad</a> y que los acepta. Si no está de acuerdo, no use el Servicio.</p>
<div class="afx-callout"><p><strong>Si usa el Servicio en nombre de una empresa</strong> declara tener facultades para obligarla. En ese caso, «usted» se refiere a la empresa y a la persona que la representa.</p></div>
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
<li>Brindarle apoyo con funciones de inteligencia artificial (sección 8).</li>
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
<p>Debe ser mayor de 18 años, tener capacidad legal para contratar y proporcionar información veraz, completa y actualizada. Podemos pedirle verificar su correo electrónico y completar la verificación de identidad (cédula o RUC, y los documentos que se indiquen en su perfil).</p>
<h3>Roles</h3>
<ul>
<li><strong>Administrador de propiedades:</strong> la persona o empresa que contrata el Servicio y gestiona su cartera. Es nuestro cliente y quien responde por sus datos y decisiones (sección 5).</li>
<li><strong>Inquilinos y solicitantes:</strong> personas que acceden a un portal o a un enlace de registro enviado por su administrador (sección 6).</li>
<li><strong>Propietarios y contactos, proveedores de mantenimiento y otros terceros:</strong> personas registradas por un administrador para operar sus inmuebles.</li>
</ul>
<h3>Sus credenciales</h3>
<p>Es responsable de la actividad realizada con su cuenta. Utilice una contraseña única y robusta, no la comparta y avísenos de inmediato si sospecha un acceso no autorizado. Cada administrador ve únicamente su propia cartera. Los enlaces de registro o de calificación que enviamos son personales, tienen vencimiento y no deben reenviarse.</p>
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
<li><strong>Cambios de plan:</strong> puede subir o bajar de plan. Si baja a un plan con menos límites, deberá ajustar su cartera para respetarlos; no eliminaremos sus datos por ese motivo.</li>
<li><strong>Cambios de precio:</strong> le avisaremos por correo con al menos 30 días de anticipación. Puede cancelar antes de que el cambio aplique.</li>
<li><strong>Reembolsos:</strong> en planes de pago, no reembolsamos periodos ya iniciados, salvo cobro duplicado o erróneo, fraude comprobado o falla grave del Servicio imputable a nosotros. Esto no limita los derechos irrenunciables que la Ley Orgánica de Defensa del Consumidor reconoce a los consumidores.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'administrador',
    'icon'  => 'key',
    'title' => 'Sus responsabilidades como administrador',
    'nav'   => 'Responsabilidades',
    'html'  => <<<'HTML'
<p>Al gestionar inmuebles e información de terceros en ArriendoFácil, se compromete a:</p>
<ol>
<li><strong>Tener legitimidad.</strong> Ser propietario del inmueble o contar con mandato, poder o autorización suficiente para administrarlo y celebrar contratos sobre él.</li>
<li><strong>Cumplir la ley.</strong> Respetar la Ley de Inquilinato y demás normas aplicables a arrendamientos, así como las normas tributarias, de consumo y de no discriminación.</li>
<li><strong>Responder por sus contratos.</strong> Los contratos de arrendamiento y sus condiciones son exclusivamente entre usted, el propietario y el inquilino. Usted decide a quién arrienda, a qué precio y bajo qué condiciones.</li>
<li><strong>Cuidar los datos personales de terceros.</strong> Respecto de los datos de inquilinos, solicitantes, propietarios y proveedores que carga o recolecta con el Servicio, <strong>usted es el responsable del tratamiento</strong> y nosotros actuamos como su encargado (ver <a href="/politica-de-privacidad/">Política de privacidad</a>). Debe contar con una base legal para tratarlos, informarles de forma clara el uso de sus datos y atender sus solicitudes de derechos.</li>
<li><strong>Enviar los enlaces de registro solo a personas con una relación legítima con usted</strong> y pedir únicamente los datos y documentos necesarios.</li>
<li><strong>Mantener su información al día</strong> y conservar sus propios respaldos de los documentos importantes.</li>
</ol>
HTML,
  ),

  array(
    'id'    => 'inquilinos',
    'icon'  => 'user-plus',
    'title' => 'Inquilinos y personas invitadas',
    'nav'   => 'Inquilinos',
    'html'  => <<<'HTML'
<p>Si recibe un enlace o acceso a un portal de ArriendoFácil, lo hace su administrador o arrendador. Allí puede registrar sus datos, subir los documentos que se le soliciten, consultar sus cargos y pagos, solicitar mantenimiento y calificar la experiencia.</p>
<ul>
<li>Proporcione información veraz y documentos auténticos. Presentar documentos falsos puede tener consecuencias legales.</li>
<li>ArriendoFácil <strong>no es su arrendador ni su administrador</strong>. Las reclamaciones sobre el contrato, el precio, el depósito de garantía o el estado del inmueble debe dirigirlas a quien administra la propiedad.</li>
<li>Sus datos son tratados por su administrador como responsable. Puede ejercer sus derechos ante él o escribiéndonos; le ayudaremos a canalizar su solicitud (ver <a href="/politica-de-privacidad/#derechos">Sus derechos</a>).</li>
<li>Las calificaciones que deje deben ser veraces, respetuosas y basarse en hechos.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'contratos',
    'icon'  => 'scale',
    'title' => 'Contratos y documentos generados',
    'nav'   => 'Contratos',
    'html'  => <<<'HTML'
<p>ArriendoFácil le permite generar contratos y otros documentos a partir de sus propias plantillas, de modelos base o con ayuda de inteligencia artificial.</p>
<div class="afx-callout afx-callout--warn"><p><strong>Todo documento generado es un borrador.</strong> Antes de firmarlo debe revisarlo completo y, si tiene dudas, consultar a un abogado. Su contenido, validez y efectos son de su exclusiva responsabilidad; ArriendoFácil no ofrece asesoría legal ni garantiza que un documento sea adecuado para un caso concreto.</p></div>
<p>La validez de firmas y mensajes de datos se rige por la Ley de Comercio Electrónico, Firmas Electrónicas y Mensajes de Datos y sus reglamentos. Los contratos y documentos que sube o genera se almacenan de forma privada y solo son accesibles por quienes tengan permiso en su cuenta.</p>
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
<li><strong>No discrimine.</strong> No use estas funciones para excluir personas por motivos protegidos por la ley (por ejemplo origen, género, discapacidad, religión o condición social).</li>
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
<p>El Servicio <strong>registra y organiza</strong> cargos, pagos, mora y recordatorios. <strong>No procesa pagos ni administra dinero.</strong> Los cobros se realizan directamente entre quienes intervienen en el arriendo, por los medios que ellos acuerden. Los avisos y recordatorios automáticos son una ayuda: es responsable de configurarlos correctamente y de verificar los saldos con sus propios soportes.</p>
<h3>Facturación electrónica (complemento)</h3>
<p>Si el plan lo incluye, puede emitir comprobantes electrónicos conforme a la normativa del Servicio de Rentas Internas (SRI). Cabe precisar que:</p>
<ul>
<li><strong>Usted es el emisor</strong> y responsable tributario de cada comprobante, de la veracidad de sus datos y de la configuración fiscal.</li>
<li>Usted carga su propia firma electrónica (certificado .p12), que se guarda cifrada y se usa solo para firmar sus comprobantes.</li>
<li>La autorización de cada comprobante la otorga el SRI. No respondemos por rechazos, demoras o caídas de sus servicios.</li>
<li>Por obligación tributaria, los comprobantes electrónicos y sus registros <strong>se conservan aunque cierre su cuenta</strong> (ver sección 14 y la Política de privacidad).</li>
<li>No somos asesores tributarios. Consulte a su contador ante cualquier duda.</li>
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
<p>Puede conectar calendarios de plataformas como Airbnb o Booking.com (por ejemplo mediante enlaces iCal). Las credenciales que registre se guardan cifradas. La sincronización puede tener retrasos o fallar por causas ajenas a nosotros; <strong>verifique su disponibilidad</strong> antes de confirmar reservas. Las condiciones de cada plataforma las acepta directamente con ella.</p>
<h3>Proveedores de mantenimiento y servicios</h3>
<p>Los proveedores son profesionales independientes. Aunque nuestro equipo pueda revisar su identidad y fotografía, esa revisión es informativa y <strong>no es una garantía</strong> de calidad, idoneidad ni de cumplimiento. La contratación y el pago del servicio se acuerdan directamente con el proveedor.</p>
<h3>Mensajería y catálogos</h3>
<p>Algunas funciones generan enlaces para compartir catálogos de propiedades o iniciar conversaciones (por ejemplo por WhatsApp). Usted decide con quién los comparte y es responsable del contenido que publique.</p>
<h3>Calificaciones</h3>
<p>Las calificaciones entre administradores e inquilinos deben ser veraces y respetuosas. Podemos retirar contenido ofensivo, falso, discriminatorio o que infrinja derechos de terceros.</p>
HTML,
  ),

  array(
    'id'    => 'contenido',
    'icon'  => 'lock',
    'title' => 'Su contenido y propiedad intelectual',
    'nav'   => 'Contenido y PI',
    'html'  => <<<'HTML'
<p><strong>Sus datos son suyos.</strong> Usted conserva la titularidad de la información, documentos y archivos que carga. Nos otorga una licencia limitada, no exclusiva y revocable para almacenarlos, procesarlos y mostrarlos con el único fin de prestarle el Servicio.</p>
<p>El software, el diseño, las marcas, los textos y demás elementos de ArriendoFácil son nuestros o de nuestros licenciantes y están protegidos por la normativa de propiedad intelectual. Se le otorga un derecho personal, limitado y no transferible para usar el Servicio mientras tenga una cuenta activa. No puede copiarlo, revenderlo, descompilarlo ni extraer datos de forma masiva o automatizada.</p>
<p>Si considera que algún contenido vulnera sus derechos, escríbanos con la información necesaria para identificarlo y revisarlo.</p>
HTML,
  ),

  array(
    'id'    => 'uso',
    'icon'  => 'alert',
    'title' => 'Uso prohibido y suspensión',
    'nav'   => 'Uso prohibido',
    'html'  => <<<'HTML'
<p>No puede usar el Servicio para:</p>
<ul>
<li>Actividades ilícitas, fraudulentas o que vulneren derechos de terceros, incluido el tratamiento de datos personales sin base legal.</li>
<li>Suplantar identidades, subir documentos falsos o registrar inmuebles que no puede administrar.</li>
<li>Interferir con la seguridad o el funcionamiento del Servicio, probar vulnerabilidades sin autorización, o eludir límites de uso y de planes.</li>
<li>Enviar comunicaciones no solicitadas, acosar o discriminar.</li>
</ul>
<p>Si detectamos un incumplimiento, podemos limitar funciones o suspender la cuenta, avisándole cuando sea posible y salvo que exista urgencia por seguridad u obligación legal. Cuando proceda, daremos la oportunidad de corregir la situación.</p>
HTML,
  ),

  array(
    'id'    => 'disponibilidad',
    'icon'  => 'refresh',
    'title' => 'Disponibilidad, soporte y respaldos',
    'nav'   => 'Disponibilidad',
    'html'  => <<<'HTML'
<p>Trabajamos para que el Servicio esté disponible de forma continua, pero puede haber interrupciones por mantenimiento, fallas de terceros (hosting, conectividad, SRI, plataformas externas) o causas de fuerza mayor. Procuramos avisar con anticipación los mantenimientos programados.</p>
<p>Los canales y la prioridad de soporte dependen del plan (por ejemplo, el plan Profesional incluye soporte con chatbot, según lo publicado en <a href="/#planes">Planes</a>). Mantenemos copias de seguridad de la plataforma, pero le recomendamos conservar sus propios respaldos de los documentos críticos.</p>
HTML,
  ),

  array(
    'id'    => 'baja',
    'icon'  => 'trash',
    'title' => 'Baja de cuenta y terminación',
    'nav'   => 'Baja de cuenta',
    'html'  => <<<'HTML'
<p>Puede dar de baja su cuenta de administrador en cualquier momento desde su perfil, confirmando la acción. Al hacerlo:</p>
<ol>
<li>La cuenta se <strong>desactiva</strong> y deja de poder iniciar sesión.</li>
<li>Nuestro equipo revisa la solicitud y puede reactivar la cuenta o <strong>eliminar definitivamente sus datos</strong>.</li>
<li>Se conservan, por obligación legal, los comprobantes electrónicos del SRI y sus registros durante el plazo tributario, y la información mínima necesaria para defender derechos o cumplir órdenes de autoridad.</li>
</ol>
<p>Antes de cerrar su cuenta, descargue o solicite la copia de la información que necesite. También podemos dar por terminado el acceso por incumplimiento de estos Términos (sección 12) o cuando cesemos el Servicio, con aviso previo razonable.</p>
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
<li>No somos responsables por las decisiones que tome, por el incumplimiento de inquilinos, propietarios o proveedores, por impagos, vacancia, pérdida de ingresos, ni por daños indirectos o consecuenciales.</li>
<li>Nuestra responsabilidad total frente a usted por cualquier reclamo relacionado con el Servicio se limita al monto que haya pagado a ArriendoFácil en los 12 meses anteriores al hecho.</li>
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
<p>Podemos actualizar estos Términos por cambios legales, técnicos o del Servicio. Publicaremos la nueva versión con su fecha y, si el cambio es relevante, le avisaremos por correo con al menos <strong>30 días de anticipación</strong>. Si no está de acuerdo, puede cerrar su cuenta antes de que entren en vigor; si continúa usando el Servicio después, entenderemos que los acepta.</p>
HTML,
  ),

  array(
    'id'    => 'ley',
    'icon'  => 'scale',
    'title' => 'Ley aplicable y solución de controversias',
    'nav'   => 'Ley aplicable',
    'html'  => <<<'HTML'
<p>Estos Términos se rigen por las leyes de la República del Ecuador. Si surge una controversia, primero intentaremos resolverla de manera amistosa: escríbanos describiendo el caso y buscaremos una solución en un plazo de 15 días hábiles.</p>
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
<p>Si alguna cláusula resulta inválida, el resto seguirá vigente. No podrá ceder su cuenta sin nuestro consentimiento; nosotros podremos ceder el Servicio a una sociedad que continúe la operación, con aviso a los usuarios. Las notificaciones se harán al correo registrado en su cuenta y a las que nos envíe a la dirección de contacto.</p>
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
    'lead'     => 'Las reglas claras para usar ArriendoFácil: qué ofrecemos, qué esperamos de usted y cómo nos hacemos cargo de lo que nos corresponde.',
    'meta'     => array( 'Versión 3.0', 'Vigente desde el 12 de noviembre de 2026', 'Aplica en Ecuador' ),
    'summary'  => array(
      'ArriendoFácil es <strong>un sistema de gestión para administradores de propiedades</strong>; no es inmobiliaria, banco ni asesor legal.',
      '<strong>Sus datos son suyos.</strong> Nosotros los tratamos solo para prestarle el servicio; usted es responsable de los datos de sus inquilinos.',
      '<strong>No procesamos pagos.</strong> Registramos y controlamos cobros; el dinero se mueve directamente entre las partes.',
      'Los contratos y textos con <strong>IA son borradores</strong> que debe revisar; ninguna decisión sobre personas la toma solo la IA.',
      'La facturación electrónica del SRI es un complemento: <strong>el emisor y responsable tributario es usted</strong>.',
      'Puede darse de baja cuando lo desee; solo conservamos lo que la ley nos obliga (p. ej. comprobantes del SRI).',
    ),
    'sections' => $afx_sections,
  )
);

get_footer();
