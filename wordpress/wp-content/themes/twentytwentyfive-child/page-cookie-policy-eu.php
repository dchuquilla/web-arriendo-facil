<?php
/**
 * Template Name: Política de Cookies
 * Política de cookies — rediseño ArriendoFácil.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$afx_sections = array(

  array(
    'id'    => 'que-son',
    'icon'  => 'cookie',
    'title' => 'Qué son las cookies',
    'nav'   => 'Qué son',
    'html'  => <<<'HTML'
<p>Las cookies son pequeños archivos que un sitio web guarda en tu navegador. Sirven para que el sitio funcione, recuerde tus preferencias o mida su uso. Esta política también cubre tecnologías similares, como el almacenamiento local del navegador (<code>localStorage</code> y <code>sessionStorage</code>).</p>
<p>Esta política complementa nuestra <a href="/politica-de-privacidad/">Política de privacidad</a> y se rige por la LOPDP del Ecuador y, para visitantes de la Unión Europea y el EEE, por el RGPD y la Directiva ePrivacy.</p>
HTML,
  ),

  array(
    'id'    => 'consentimiento',
    'icon'  => 'check',
    'title' => 'Cómo gestionamos tu consentimiento',
    'nav'   => 'Consentimiento',
    'html'  => <<<'HTML'
<p>La primera vez que entras al sitio te mostramos un aviso con tres opciones de igual importancia:</p>
<ul>
<li><strong>Aceptar todas</strong> las categorías.</li>
<li><strong>Solo las necesarias</strong> (rechazar todo lo opcional).</li>
<li><strong>Personalizar</strong>, para elegir categoría por categoría.</li>
</ul>
<p>Antes de que elijas, <strong>no se instala ninguna cookie</strong> ni se cargan servicios de terceros que no sean estrictamente necesarios. Tu decisión se guarda por hasta 12 meses y puedes cambiarla cuando quieras (sección 6). Rechazar no limita el uso del Servicio.</p>
HTML,
  ),

  array(
    'id'    => 'tabla',
    'icon'  => 'database',
    'title' => 'Cookies que usamos',
    'nav'   => 'Cookies que usamos',
    'html'  => <<<'HTML'
<div class="afx-tablewrap"><table>
<thead><tr><th>Cookie</th><th>Categoría</th><th>Finalidad</th><th>Duración</th></tr></thead>
<tbody>
<tr><td><code>cmplz_banner-status</code></td><td>Necesaria</td><td>Recuerda que ya respondiste al aviso de cookies.</td><td>12 meses</td></tr>
<tr><td><code>cmplz_policy_id</code></td><td>Necesaria</td><td>Versión de la política a la que respondiste.</td><td>12 meses</td></tr>
<tr><td><code>cmplz_consented_services</code></td><td>Necesaria</td><td>Servicios para los que diste consentimiento.</td><td>12 meses</td></tr>
<tr><td><code>cmplz_functional</code>, <code>cmplz_preferences</code>, <code>cmplz_statistics</code>, <code>cmplz_marketing</code></td><td>Necesaria</td><td>Guardan tu elección en cada categoría.</td><td>12 meses</td></tr>
<tr><td><code>wordpress_logged_in_*</code>, <code>wordpress_sec_*</code></td><td>Necesaria</td><td>Mantienen tu sesión iniciada de forma segura. Solo si inicias sesión.</td><td>Sesión o hasta 14 días con «Recordarme»</td></tr>
<tr><td><code>wp-settings-*</code>, <code>wp-settings-time-*</code></td><td>Necesaria</td><td>Preferencias de interfaz de tu usuario. Solo si inicias sesión.</td><td>12 meses</td></tr>
<tr><td><code>wordpress_test_cookie</code></td><td>Necesaria</td><td>Comprueba que tu navegador acepta cookies al iniciar sesión.</td><td>Sesión</td></tr>
<tr><td><code>__cf_bm</code></td><td>Necesaria (seguridad)</td><td>Cloudflare la puede usar para distinguir tráfico legítimo de bots.</td><td>30 minutos</td></tr>
</tbody></table></div>
<p>Dentro del panel de gestión también usamos <code>localStorage</code> y <code>sessionStorage</code> para recordar ajustes de interfaz (por ejemplo, el menú lateral colapsado o filtros del calendario). Estos datos permanecen en tu dispositivo y no se envían a terceros.</p>
<div class="afx-callout afx-callout--key"><p><strong>Hoy no usamos</strong> cookies de publicidad, píxeles de seguimiento (como Meta Pixel) ni Google Analytics. Si esto cambiara, actualizaremos esta política y volveremos a pedir tu consentimiento antes de activarlos.</p></div>
HTML,
  ),

  array(
    'id'    => 'terceros',
    'icon'  => 'globe',
    'title' => 'Servicios de terceros',
    'nav'   => 'Terceros',
    'html'  => <<<'HTML'
<ul>
<li><strong>YouTube (youtube-nocookie.com):</strong> los videos de demostración se cargan <strong>solo cuando pulsas reproducir</strong>, en modo de privacidad mejorada. Antes de ese clic no se contacta a YouTube. Al reproducir, Google puede tratar datos según su propia política.</li>
<li><strong>Cloudflare:</strong> proveedor de seguridad y red de entrega del sitio. Su analítica web <strong>no usa cookies</strong> y mide el tráfico de forma agregada (páginas vistas y rendimiento), sin identificarte entre sitios.</li>
<li><strong>Tipografías:</strong> las fuentes se sirven desde nuestro propio servidor; no se descargan de servidores de terceros.</li>
<li><strong>WhatsApp:</strong> los botones de contacto son enlaces simples. No se carga ningún código de WhatsApp hasta que haces clic.</li>
</ul>
HTML,
  ),

  array(
    'id'    => 'categorias',
    'icon'  => 'eye',
    'title' => 'Categorías de cookies',
    'nav'   => 'Categorías',
    'html'  => <<<'HTML'
<div class="afx-tablewrap"><table>
<thead><tr><th>Categoría</th><th>¿Se puede desactivar?</th><th>Uso actual</th></tr></thead>
<tbody>
<tr><td><strong>Funcionales / necesarias</strong></td><td>No; sin ellas el sitio no funciona.</td><td>Sesión, seguridad y registro de tu elección.</td></tr>
<tr><td><strong>Preferencias</strong></td><td>Sí</td><td>Sin cookies de este tipo en uso.</td></tr>
<tr><td><strong>Estadísticas</strong></td><td>Sí</td><td>Sin cookies en uso (la analítica de Cloudflare no usa cookies).</td></tr>
<tr><td><strong>Marketing</strong></td><td>Sí</td><td>Sin cookies en uso.</td></tr>
</tbody></table></div>
HTML,
  ),

  array(
    'id'    => 'cambiar',
    'icon'  => 'refresh',
    'title' => 'Cómo cambiar o retirar tu consentimiento',
    'nav'   => 'Cambiar mi elección',
    'html'  => <<<'HTML'
<ul>
<li><strong>Desde el sitio:</strong> usa el botón flotante «Utilizamos cookies» (abajo a la derecha) para reabrir el panel y cambiar tu elección en cualquier momento.</li>
<li><strong>Desde tu navegador:</strong> puedes bloquear o borrar cookies en la configuración de Chrome, Firefox, Safari o Edge. Si bloqueas las necesarias, partes del sitio (como iniciar sesión) pueden dejar de funcionar.</li>
</ul>
<p>Retirar tu consentimiento no afecta la validez del tratamiento realizado antes de retirarlo.</p>
HTML,
  ),

  array(
    'id'    => 'ue',
    'icon'  => 'scale',
    'title' => 'Visitantes de la Unión Europea y el EEE',
    'nav'   => 'UE / EEE',
    'html'  => <<<'HTML'
<p>Si accedes desde la Unión Europea o el Espacio Económico Europeo, solo instalamos cookies no esenciales con tu consentimiento previo, libre, informado e inequívoco, en línea con el RGPD y la Directiva ePrivacy. Puedes ejercer los derechos descritos en nuestra <a href="/politica-de-privacidad/#derechos">Política de privacidad</a> y reclamar ante la autoridad de protección de datos de tu país.</p>
HTML,
  ),

  array(
    'id'    => 'cambios',
    'icon'  => 'info',
    'title' => 'Cambios y contacto',
    'nav'   => 'Cambios y contacto',
    'html'  => <<<'HTML'
<p>Actualizaremos esta política si cambian las cookies que usamos o la normativa, y volveremos a pedir tu consentimiento cuando corresponda. Para dudas, escríbenos a <a href="mailto:arriendofacilnet@gmail.com">arriendofacilnet@gmail.com</a>.</p>
HTML,
  ),

);

get_template_part(
  'template-parts/afx-legal',
  null,
  array(
    'slug'     => 'cookie-policy-eu',
    'tag'      => 'Documentos legales',
    'title'    => 'Política de',
    'accent'   => 'cookies',
    'lead'     => 'Qué cookies usamos, para qué sirven y cómo puedes aceptarlas, rechazarlas o cambiarlas cuando quieras.',
    'meta'     => array( 'Versión 3.0', 'Vigente desde el 12 de noviembre de 2026', 'LOPDP · RGPD' ),
    'summary'  => array(
      'Antes de que elijas, <strong>no instalamos cookies opcionales</strong>.',
      'Puedes <strong>aceptar, rechazar o personalizar</strong>, con la misma facilidad.',
      '<strong>No usamos</strong> cookies de publicidad ni píxeles de seguimiento.',
      'Los videos de YouTube se cargan <strong>solo si pulsas reproducir</strong>.',
      'Puedes <strong>cambiar tu elección</strong> en cualquier momento desde el botón flotante.',
    ),
    'sections' => $afx_sections,
  )
);

get_footer();
