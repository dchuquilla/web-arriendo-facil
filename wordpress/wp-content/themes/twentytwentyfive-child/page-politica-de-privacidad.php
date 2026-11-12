<?php
/**
 * Template Name: Política de Privacidad
 * Política de privacidad y protección de datos personales — rediseño ArriendoFácil.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_sections = array(

  array(
    'id'    => 'quienes',
    'icon'  => 'users',
    'title' => 'Quiénes somos y cuál es nuestro rol',
    'nav'   => 'Quiénes somos',
    'html'  => <<<'HTML'
<p>Esta Política explica cómo <strong>Arriendo Fácil</strong> («ArriendoFácil», «nosotros»), con domicilio en Quito, Ecuador, trata datos personales en el sitio arriendofacil.net y en el sistema de gestión de propiedades, de acuerdo con la <strong>Ley Orgánica de Protección de Datos Personales (LOPDP)</strong> y su Reglamento.</p>
<p>Nuestro rol depende de quién eres:</p>
<div class="afx-tablewrap"><table>
<thead><tr><th>Datos de…</th><th>Nuestro rol</th></tr></thead>
<tbody>
<tr><td>Administradores de propiedades (titulares de una cuenta) y visitantes del sitio web</td><td><strong>Responsable del tratamiento.</strong> Decidimos para qué y cómo usamos estos datos.</td></tr>
<tr><td>Inquilinos, solicitantes, propietarios y proveedores que un administrador registra o invita a registrarse</td><td><strong>Encargado del tratamiento.</strong> Tratamos los datos por cuenta y según las instrucciones del administrador, que es quien decide por qué los recolecta y responde frente a esas personas.</td></tr>
</tbody></table></div>
<div class="afx-callout"><p><strong>¿Eres inquilino o solicitante?</strong> Tu administrador es quien te pidió los datos y quien decide sobre ellos. Puedes ejercer tus derechos ante él o escribirnos a <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a> y te ayudamos a canalizar tu solicitud.</p></div>
HTML,
  ),

  array(
    'id'    => 'datos',
    'icon'  => 'database',
    'title' => 'Qué datos tratamos',
    'nav'   => 'Datos que tratamos',
    'html'  => <<<'HTML'
<div class="afx-tablewrap"><table>
<thead><tr><th>Categoría</th><th>Ejemplos</th><th>Origen</th></tr></thead>
<tbody>
<tr><td>Cuenta y perfil del administrador</td><td>Nombre, correo electrónico, teléfono, cédula o RUC, contraseña (almacenada cifrada con hash), plan contratado, datos de verificación de identidad.</td><td>Tú, al registrarte</td></tr>
<tr><td>Inquilinos y solicitantes</td><td>Nombre, cédula o pasaporte, nacionalidad, ciudad de nacimiento, teléfono, correo, fechas y precio de arriendo deseados.</td><td>El administrador o la propia persona, mediante enlaces seguros</td></tr>
<tr><td>Documentos</td><td>Copia de cédula y papeleta de votación, certificado laboral, certificado bancario, garantías, contratos generados.</td><td>El administrador o el inquilino</td></tr>
<tr><td>Propiedades y operación</td><td>Direcciones, edificios, cobros, pagos registrados, mora, lecturas de medidores, mantenimientos, calendario, reseñas.</td><td>El administrador</td></tr>
<tr><td>Proveedores de servicios</td><td>Nombre, teléfono, especialidad, identidad y foto verificadas por nuestro equipo.</td><td>El proveedor o el administrador</td></tr>
<tr><td>Facturación electrónica (opcional)</td><td>Datos del emisor y receptor, comprobantes, certificado de firma (.p12) y su clave, cifrados.</td><td>El administrador</td></tr>
<tr><td>Comunicaciones</td><td>Mensajes del formulario de contacto, solicitudes de soporte, preferencias de correo.</td><td>Tú</td></tr>
<tr><td>Técnicos</td><td>Dirección IP, tipo de navegador, páginas vistas, registros de seguridad, preferencias de cookies.</td><td>Generados al usar el sitio</td></tr>
</tbody></table></div>
<p>Los certificados laborales y bancarios y los documentos de identidad reciben protección reforzada (almacenamiento privado, acceso restringido por rol). <strong>No buscamos datos sensibles</strong> (salud, origen étnico, religión, opiniones políticas, biometría con fines de identificación) y pedimos a los administradores no cargarlos. Si los recibimos por error, los eliminaremos.</p>
HTML,
  ),

  array(
    'id'    => 'finalidades',
    'icon'  => 'scale',
    'title' => 'Para qué usamos los datos y con qué base legal',
    'nav'   => 'Finalidades',
    'html'  => <<<'HTML'
<div class="afx-tablewrap"><table>
<thead><tr><th>Finalidad</th><th>Base legal</th></tr></thead>
<tbody>
<tr><td>Crear y gestionar tu cuenta, prestarte el Servicio y brindarte soporte</td><td>Ejecución del contrato</td></tr>
<tr><td>Verificar identidad y prevenir fraude, suplantación y abuso</td><td>Interés legítimo y cumplimiento de obligaciones legales</td></tr>
<tr><td>Enviar correos transaccionales (verificación, avisos de cuenta, cobros y recordatorios que configuras)</td><td>Ejecución del contrato</td></tr>
<tr><td>Enviar notificaciones y novedades del producto</td><td>Interés legítimo; puedes darte de baja en un clic</td></tr>
<tr><td>Funciones de inteligencia artificial que tú activas (sección 4)</td><td>Ejecución del contrato y, cuando corresponda, consentimiento</td></tr>
<tr><td>Emitir comprobantes electrónicos y conservar registros tributarios</td><td>Cumplimiento de obligaciones legales</td></tr>
<tr><td>Seguridad, mejora y continuidad del Servicio, estadísticas agregadas</td><td>Interés legítimo</td></tr>
<tr><td>Cookies no esenciales (si las hubiera)</td><td>Tu consentimiento</td></tr>
<tr><td>Atender requerimientos de autoridades y defender derechos</td><td>Obligación legal e interés legítimo</td></tr>
</tbody></table></div>
<p>No usamos tus datos para fines distintos e incompatibles con estos, ni elaboramos perfiles publicitarios. <strong>No vendemos datos personales.</strong></p>
HTML,
  ),

  array(
    'id'    => 'ia-datos',
    'icon'  => 'sparkles',
    'title' => 'Inteligencia artificial y decisiones automatizadas',
    'nav'   => 'Inteligencia artificial',
    'html'  => <<<'HTML'
<p>ArriendoFácil ofrece funciones de apoyo con inteligencia artificial, por ejemplo: redactar o completar el borrador de un contrato, mapear campos de plantillas, estimar costos y <strong>calcular una puntuación orientativa de un solicitante</strong> a partir de los datos que el administrador registró.</p>
<ul>
<li><strong>Proveedor:</strong> estas funciones usan la API de Anthropic (modelos Claude). Para generar el resultado enviamos únicamente los datos necesarios de la solicitud.</li>
<li><strong>Solo cuando se solicita:</strong> las funciones se ejecutan cuando el administrador las activa (o se encolan por su acción), no sobre toda tu información de forma continua.</li>
<li><strong>Son una ayuda, no una decisión.</strong> Los resultados son borradores y orientaciones. <strong>Ninguna decisión sobre una persona (aprobar o rechazar un arriendo, por ejemplo) se toma únicamente por medios automatizados</strong>; la toma el administrador, que debe revisarla.</li>
<li><strong>Tus derechos:</strong> puedes pedir información sobre la lógica aplicada, solicitar la revisión humana de una decisión que te afecte y oponerte a que se te evalúe de este modo (sección 9).</li>
</ul>
<div class="afx-callout afx-callout--warn"><p>Los administradores no deben usar estas funciones para discriminar por motivos prohibidos por la ley (origen, nacionalidad, género, religión, discapacidad, entre otros).</p></div>
HTML,
  ),

  array(
    'id'    => 'terceros',
    'icon'  => 'globe',
    'title' => 'Con quién compartimos datos',
    'nav'   => 'Terceros',
    'html'  => <<<'HTML'
<p>Compartimos datos solo cuando es necesario para prestar el Servicio o cuando la ley lo exige:</p>
<div class="afx-tablewrap"><table>
<thead><tr><th>Destinatario</th><th>Para qué</th></tr></thead>
<tbody>
<tr><td>Cloudflare</td><td>Seguridad, red de entrega, almacenamiento privado de archivos (contratos y documentos) y analítica web sin cookies.</td></tr>
<tr><td>Anthropic</td><td>Procesar las solicitudes de inteligencia artificial (sección 4).</td></tr>
<tr><td>Servicio de Rentas Internas (SRI)</td><td>Solo si usas la facturación electrónica: envío y autorización de comprobantes.</td></tr>
<tr><td>Airbnb, Booking.com y similares</td><td>Solo si activas la sincronización de calendarios (iCal); las credenciales se guardan cifradas.</td></tr>
<tr><td>Proveedor de correo electrónico</td><td>Envío de correos transaccionales y notificaciones.</td></tr>
<tr><td>YouTube (modo privacidad mejorada)</td><td>Solo si pulsas reproducir un video; antes no se carga contenido de YouTube.</td></tr>
<tr><td>WhatsApp</td><td>Solo cuando tú o el administrador abren un enlace de contacto; la conversación ocurre en WhatsApp, bajo sus propias condiciones.</td></tr>
<tr><td>Autoridades</td><td>Cuando exista una orden o requerimiento legal válido.</td></tr>
</tbody></table></div>
<p>Los administradores y su equipo acceden a los datos de su propia cartera y a nada más; el acceso está separado por cuenta y por rol. Nuestro personal accede solo cuando es necesario (soporte, verificación, seguridad) y bajo deber de confidencialidad.</p>
HTML,
  ),

  array(
    'id'    => 'transferencias',
    'icon'  => 'globe',
    'title' => 'Transferencias internacionales',
    'nav'   => 'Transferencias',
    'html'  => <<<'HTML'
<p>Algunos de nuestros proveedores (por ejemplo Cloudflare y Anthropic) pueden tratar datos en servidores fuera del Ecuador, incluido Estados Unidos. Cuando esto ocurre, lo hacemos con proveedores que ofrecen garantías adecuadas —como cláusulas contractuales y medidas de seguridad equivalentes— conforme a la LOPDP. Puedes pedirnos información sobre estas garantías escribiéndonos.</p>
HTML,
  ),

  array(
    'id'    => 'conservacion',
    'icon'  => 'calendar',
    'title' => 'Cuánto tiempo conservamos los datos',
    'nav'   => 'Conservación',
    'html'  => <<<'HTML'
<div class="afx-tablewrap"><table>
<thead><tr><th>Dato</th><th>Plazo</th></tr></thead>
<tbody>
<tr><td>Cuenta activa y datos de operación</td><td>Mientras la cuenta esté activa.</td></tr>
<tr><td>Cuenta desactivada</td><td>Se mantiene desactivada por un periodo razonable para permitir su recuperación; luego se elimina definitivamente, salvo lo que la ley nos obligue a conservar.</td></tr>
<tr><td>Comprobantes electrónicos del SRI y sus registros</td><td>El plazo que exija la normativa tributaria (hasta 7 años).</td></tr>
<tr><td>Mensajes de contacto y soporte</td><td>El tiempo necesario para atenderlos y para acreditar la atención dada.</td></tr>
<tr><td>Registros de seguridad</td><td>El tiempo estrictamente necesario para proteger el Servicio.</td></tr>
<tr><td>Enlaces y tokens de acceso</td><td>Caducan automáticamente (los de un solo uso se invalidan tras usarse).</td></tr>
</tbody></table></div>
<p>Al vencer los plazos, eliminamos o anonimizamos los datos de forma segura.</p>
HTML,
  ),

  array(
    'id'    => 'seguridad',
    'icon'  => 'lock',
    'title' => 'Cómo protegemos tus datos',
    'nav'   => 'Seguridad',
    'html'  => <<<'HTML'
<ul>
<li>Conexiones cifradas (HTTPS) en todo el sitio.</li>
<li>Almacenamiento <strong>privado</strong> de contratos y documentos de identidad, sin enlaces públicos.</li>
<li>Credenciales sensibles (certificados de firma, claves de integraciones) <strong>cifradas</strong> en reposo con algoritmos modernos.</li>
<li>Acceso por roles: cada administrador ve solo su cartera.</li>
<li>Protección contra abuso: límites de intentos, verificación anti-bots, tokens firmados y con caducidad.</li>
<li>Registros de auditoría de operaciones sensibles, como la emisión de comprobantes.</li>
</ul>
<p>Ningún sistema es 100 % invulnerable. Si ocurre una vulneración que afecte tus datos, lo notificaremos a la autoridad y a los titulares afectados en los plazos y en la forma que establece la ley. Tú también debes cuidar tu contraseña y no compartirla.</p>
HTML,
  ),

  array(
    'id'    => 'derechos',
    'icon'  => 'key',
    'title' => 'Tus derechos',
    'nav'   => 'Tus derechos',
    'html'  => <<<'HTML'
<p>La LOPDP te reconoce los siguientes derechos sobre tus datos personales:</p>
<ul>
<li><strong>Acceso:</strong> saber qué datos tuyos tratamos y cómo.</li>
<li><strong>Rectificación y actualización:</strong> corregir datos inexactos o incompletos.</li>
<li><strong>Eliminación:</strong> pedir que borremos tus datos cuando proceda.</li>
<li><strong>Oposición:</strong> oponerte al tratamiento basado en interés legítimo o con fines de mercadeo.</li>
<li><strong>Portabilidad:</strong> recibir tus datos en un formato estructurado y de uso común.</li>
<li><strong>Suspensión:</strong> pedir que limitemos el tratamiento en los casos previstos.</li>
<li><strong>No ser objeto de decisiones basadas únicamente en tratamiento automatizado</strong> que te afecten significativamente, y pedir revisión humana.</li>
<li><strong>Retirar tu consentimiento</strong> en cualquier momento, sin efectos retroactivos.</li>
</ul>
<h3>Cómo ejercerlos</h3>
<p>Escríbenos a <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a> indicando tu nombre, el derecho que deseas ejercer y una forma de verificar tu identidad. <strong>Respondemos en un máximo de 15 días</strong> desde que recibimos la solicitud completa. Si tus datos fueron cargados por un administrador, podemos remitirle tu solicitud, ya que él decide sobre ellos.</p>
<p>Si consideras que tus derechos no fueron atendidos, puedes presentar un reclamo ante la <strong>Superintendencia de Protección de Datos Personales (SPDP)</strong> del Ecuador.</p>
<div class="afx-callout afx-callout--key"><p>Si eres administrador, puedes desactivar tu cuenta desde tu panel (escribiendo «ELIMINAR» para confirmar). Ten en cuenta que debemos conservar ciertos registros que la ley exige, como los comprobantes electrónicos del SRI.</p></div>
HTML,
  ),

  array(
    'id'    => 'correos',
    'icon'  => 'info',
    'title' => 'Correos electrónicos y comunicaciones',
    'nav'   => 'Correos',
    'html'  => <<<'HTML'
<p>Enviamos dos tipos de correos:</p>
<ul>
<li><strong>Transaccionales</strong> (verificación de correo, restablecer contraseña, avisos de seguridad y de cuenta, correos que tu administrador configura): son necesarios para el Servicio y no se pueden desactivar mientras uses el Servicio.</li>
<li><strong>Notificaciones y novedades:</strong> puedes darte de baja con un solo clic desde el enlace al pie del correo, sin iniciar sesión.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'menores',
    'icon'  => 'shield',
    'title' => 'Menores de edad',
    'nav'   => 'Menores',
    'html'  => <<<'HTML'
<p>El Servicio no está dirigido a menores de 18 años y no recolectamos conscientemente sus datos. Si un administrador debe registrar datos de un menor (por ejemplo, un ocupante), debe contar con la autorización de sus representantes legales. Si descubrimos datos de un menor cargados sin autorización, los eliminaremos.</p>
HTML,
  ),

  array(
    'id'    => 'cookies',
    'icon'  => 'cookie',
    'title' => 'Cookies y tecnologías similares',
    'nav'   => 'Cookies',
    'html'  => <<<'HTML'
<p>Usamos solo las cookies necesarias para que el sitio funcione y para recordar tus decisiones. <strong>Hoy no usamos cookies publicitarias ni píxeles de seguimiento de terceros.</strong> Puedes aceptar, rechazar o personalizar tus preferencias en cualquier momento. Todos los detalles están en la <a href="/cookie-policy-eu/">Política de cookies</a>.</p>
HTML,
  ),

  array(
    'id'    => 'cambios',
    'icon'  => 'refresh',
    'title' => 'Cambios a esta Política',
    'nav'   => 'Cambios',
    'html'  => <<<'HTML'
<p>Podemos actualizar esta Política para reflejar cambios en el Servicio o en la ley. Publicaremos la versión vigente con su fecha y, si el cambio es importante, te lo avisaremos por correo o dentro del sistema con anticipación razonable. Si no estás de acuerdo con un cambio, puedes dejar de usar el Servicio y solicitar la eliminación de tu cuenta.</p>
HTML,
  ),

  array(
    'id'    => 'contacto',
    'icon'  => 'info',
    'title' => 'Contacto',
    'nav'   => 'Contacto',
    'html'  => <<<'HTML'
<p>Para cualquier consulta sobre privacidad o para ejercer tus derechos, escríbenos a <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a>. También puedes usar el <a href="/contacto/">formulario de contacto</a>.</p>
<p><strong>Autoridad de control:</strong> Superintendencia de Protección de Datos Personales (SPDP), Ecuador.</p>
HTML,
  ),

);

get_template_part(
  'template-parts/afx-legal',
  null,
  array(
    'slug'     => 'politica-de-privacidad',
    'tag'      => 'Documentos legales',
    'title'    => 'Política de',
    'accent'   => 'privacidad',
    'lead'     => 'Qué datos tratamos, para qué, con quién los compartimos y cómo puedes ejercer tus derechos. En lenguaje claro y conforme a la LOPDP del Ecuador.',
    'meta'     => array( 'Versión 3.0', 'Vigente desde el 12 de noviembre de 2026', 'LOPDP · Ecuador' ),
    'summary'  => array(
      '<strong>No vendemos tus datos</strong> ni los usamos para publicidad de terceros.',
      'Con los datos de tus inquilinos actuamos <strong>por tu cuenta</strong>: tú decides, nosotros los protegemos.',
      'La <strong>IA es una ayuda</strong>: ninguna decisión sobre una persona se toma solo de forma automática.',
      'Contratos y documentos se guardan en <strong>almacenamiento privado</strong> y las credenciales sensibles, cifradas.',
      'Puedes <strong>ejercer tus derechos</strong> (acceso, rectificación, eliminación y más) y te respondemos en máximo 15 días.',
      'Puedes reclamar ante la <strong>Superintendencia de Protección de Datos Personales</strong>.',
    ),
    'sections' => $afx_sections,
  )
);

get_footer();
