<?php
/**
 * Template Name: Política de Cookies
 * Información sobre cookies y tecnologías de rastreo - GDPR/CCPA compliant
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-legal-page">
  <section class="af-legal-hero">
    <div class="container">
      <h1><?php esc_html_e('Política de Cookies', 'twentytwentyfive-child'); ?></h1>
      <p><?php esc_html_e('Última actualización: 8 de octubre de 2026', 'twentytwentyfive-child'); ?></p>
    </div>
  </section>

  <article class="af-legal-content container">
    <div class="af-legal-body">

      <section id="introduccion">
        <h2>1. Introducción</h2>
        <p>Utilizamos cookies y tecnologías similares para almacenar y acceder a información en tu dispositivo. Aceptar estas tecnologías nos permitirá procesar datos como el comportamiento de navegación. No aceptar puede afectar negativamente ciertas funciones del sitio.</p>
        <p>Esta política explica qué son las cookies, cómo las usamos, y tus derechos de control.</p>
      </section>

      <section id="que-son">
        <h2>2. ¿Qué son las Cookies?</h2>
        <p>Las cookies son pequeños archivos de texto almacenados en tu navegador o dispositivo. Se usan para:</p>
        <ul>
          <li>✓ Recordar tu sesión de login</li>
          <li>✓ Guardar preferencias (idioma, tema oscuro)</li>
          <li>✓ Medir uso de la plataforma (estadísticas)</li>
          <li>✓ Personalizar anuncios y contenido</li>
        </ul>
        <p><strong>No son virus:</strong> Las cookies no pueden infectar tu dispositivo, pero pueden rastrear tu actividad.</p>
      </section>

      <section id="tipos-cookies">
        <h2>3. Tipos de Cookies que Usamos</h2>

        <h3>3.1 Cookies Funcionales (NECESARIAS)</h3>
        <table style="width:100%; border-collapse: collapse; margin: var(--space-4) 0;">
          <tr style="background: var(--color-bg-secondary);">
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Cookie</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Propósito</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Duración</th>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>wordpress_logged_in</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Autenticación de usuario</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Sesión</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>wordpress_sec</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Seguridad SSL/HTTPS</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Sesión</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>wordpress_test_cookie</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Verificar soporte de cookies</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Sesión</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>af_user_prefs</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Preferencias (tema, idioma)</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">1 año</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>PHPSESSID</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">ID de sesión del servidor</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Sesión</td>
          </tr>
        </table>
        <p><strong>Estado:</strong> ✓ SIEMPRE ACTIVAS (requeridas para usar la plataforma)</p>

        <h3>3.2 Cookies Analíticas (ESTADÍSTICAS - OPCIONAL)</h3>
        <table style="width:100%; border-collapse: collapse; margin: var(--space-4) 0;">
          <tr style="background: var(--color-bg-secondary);">
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Cookie</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Propósito</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Duración</th>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>_ga</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Google Analytics - ID de usuario</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">2 años</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>_gid</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Google Analytics - ID de sesión</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">24 horas</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>_gat</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Google Analytics - control de tasa</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">1 minuto</td>
          </tr>
        </table>
        <p><strong>Estado:</strong> ☐ OPCIONAL (necesita consentimiento previo)</p>
        <p><strong>Información recopilada:</strong> Páginas visitadas, tiempo en sitio, dispositivo, navegador (ANÓNIMA)</p>

        <h3>3.3 Cookies de Marketing (PUBLICIDAD - OPCIONAL)</h3>
        <table style="width:100%; border-collapse: collapse; margin: var(--space-4) 0;">
          <tr style="background: var(--color-bg-secondary);">
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Cookie</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Propósito</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Proveedor</th>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>fbq</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Facebook Pixel - Retargeting</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Meta / Facebook</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>gclid</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Google Ads - Conversiones</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Google</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><code>li_sugar</code></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">LinkedIn - Retargeting</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">LinkedIn</td>
          </tr>
        </table>
        <p><strong>Estado:</strong> ☐ OPCIONAL (necesita consentimiento previo)</p>
        <p><strong>Información recopilada:</strong> Intereses, páginas visitadas, clicks, conversiones (PERSONALIZADA)</p>
      </section>

      <section id="localStorage">
        <h2>4. Almacenamiento Local (LocalStorage)</h2>
        <p>Además de cookies, usamos localStorage del navegador para:</p>
        <ul>
          <li>✓ Guardar preferencias de usuario</li>
          <li>✓ Caché de datos para mejor rendimiento</li>
          <li>✓ Tokens de sesión (más seguros que cookies)</li>
        </ul>
        <p><strong>Diferencia:</strong> LocalStorage persiste más tiempo que cookies y no se envía automáticamente al servidor.</p>
      </section>

      <section id="control-cookies">
        <h2>5. Cómo Controlar Cookies</h2>

        <h3>5.1 En nuestro sitio</h3>
        <ul>
          <li>1. Verás un banner de consentimiento al entrar</li>
          <li>2. Elige "Aceptar todas" o "Personalizar"</li>
          <li>3. En "Personalizar", selecciona qué cookies aceptas</li>
          <li>4. Tu decisión se guarda en una cookie de consentimiento</li>
          <li>5. Puedes cambiar preferencias en cualquier momento (pie de página)</li>
        </ul>

        <h3>5.2 En tu navegador</h3>
        <ul>
          <li><strong>Chrome:</strong> Configuración → Privacidad → Borrar cookies</li>
          <li><strong>Firefox:</strong> Preferencias → Privacidad → Gestionar datos</li>
          <li><strong>Safari:</strong> Preferencias → Privacidad → Administrar datos</li>
          <li><strong>Edge:</strong> Configuración → Privacidad → Borrar datos de exploración</li>
        </ul>

        <h3>5.3 Do Not Track (DNT)</h3>
        <p>Si activas "Do Not Track" en tu navegador, respetaremos tu preferencia. Sin embargo, algunas cookies funcionales seguirán siendo necesarias.</p>

        <h3>5.4 Herramientas de privacidad</h3>
        <ul>
          <li>Privacy Badger (EFF) - bloqueador de rastreo</li>
          <li>uBlock Origin - bloqueador de anuncios</li>
          <li>Ghostery - visualiza rastreadores</li>
        </ul>
      </section>

      <section id="terceros">
        <h2>6. Cookies de Terceros</h2>
        <p>Permitimos que socios agreguen cookies para:</p>
        <ul>
          <li>Google Analytics - análisis de uso</li>
          <li>Facebook Pixel - seguimiento de conversiones</li>
          <li>LinkedIn Insight - análisis de audiencia</li>
          <li>Cloudflare - seguridad y rendimiento</li>
        </ul>
        <p><strong>Puedes optar por no participar:</strong> Usa <a href="https://optout.aboutads.info/">Digital Advertising Alliance</a> o configuración del navegador.</p>
      </section>

      <section id="cambios">
        <h2>7. Cambios a esta Política</h2>
        <p>Podemos actualizar esta política en cualquier momento. Los cambios significativos serán comunicados por email o banner prominente en el sitio.</p>
      </section>

      <section id="contacto">
        <h2>8. Contacto - Privacidad</h2>
        <ul>
          <li>📧 Email: <a href="mailto:privacy@arriendofacil.net">privacy@arriendofacil.net</a></li>
          <li>📍 Quito, Pichincha, Ecuador</li>
          <li>📋 <a href="<?php echo esc_url(home_url('/politica-de-privacidad/')); ?>">Política de Privacidad completa</a></li>
        </ul>
      </section>

      <p class="af-legal-footer">
        <strong>© 2026 Arriendo Fácil.</strong> Todos los derechos reservados. 
        Última actualización: 8 de octubre de 2026.
      </p>
    </div>
  </article>
</main>

<style>
.af-legal-page {
  background: var(--color-bg-primary);
}

.af-legal-hero {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-8) 0;
  text-align: left;
  margin-bottom: var(--space-8);
  border-bottom: 4px solid rgba(255,255,255,0.2);
}

.af-legal-hero h1 {
  font-size: 2rem;
  margin-bottom: var(--space-1);
  font-weight: 800;
}

.af-legal-hero p {
  opacity: 0.85;
  font-size: 0.95rem;
  margin: 0;
}

.af-legal-content {
  max-width: 900px;
  padding: var(--space-8) 0;
}

.af-legal-body {
  line-height: 1.8;
  color: var(--color-text-primary);
}

.af-legal-body section {
  margin-bottom: var(--space-8);
  padding: var(--space-6);
  background: white;
  border-left: 4px solid var(--color-primary);
  border-radius: var(--radius-md);
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.af-legal-body section:hover {
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: box-shadow 0.2s;
}

.af-legal-body h2 {
  font-size: 1.35rem;
  font-weight: 800;
  margin: 0 0 var(--space-3) 0;
  color: var(--color-primary);
  display: flex;
  align-items: center;
  gap: var(--space-2);
}

.af-legal-body h2::before {
  content: '';
  display: inline-block;
  width: 28px;
  height: 28px;
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  border-radius: 50%;
  text-align: center;
  line-height: 28px;
  font-size: 0.9rem;
  font-weight: bold;
  flex-shrink: 0;
}

.af-legal-body p {
  margin: var(--space-3) 0;
  font-size: 0.95rem;
  line-height: 1.7;
}

.af-legal-body h3 {
  font-size: 1.05rem;
  font-weight: 700;
  margin: var(--space-5) 0 var(--space-3) 0;
  color: var(--color-text-primary);
  border-bottom: 2px solid var(--color-border);
  padding-bottom: var(--space-2);
}

.af-legal-body ul,
.af-legal-body ol {
  margin: var(--space-3) 0 var(--space-3) var(--space-5);
  padding: 0;
}

.af-legal-body li {
  margin-bottom: var(--space-2);
  line-height: 1.7;
  font-size: 0.95rem;
}

.af-legal-body strong {
  color: var(--color-primary);
  font-weight: 700;
}

.af-legal-body table {
  width: 100%;
  border-collapse: collapse;
  margin: var(--space-4) 0;
  background: var(--color-bg-secondary);
  border-radius: var(--radius-md);
  overflow: hidden;
}

.af-legal-body table thead {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
}

.af-legal-body table th {
  padding: var(--space-3);
  text-align: left;
  font-weight: 700;
  font-size: 0.9rem;
}

.af-legal-body table td {
  padding: var(--space-3);
  border-bottom: 1px solid var(--color-border);
  font-size: 0.9rem;
}

.af-legal-body table tr:last-child td {
  border-bottom: none;
}

.af-legal-body code {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: 2px 6px;
  border-radius: 3px;
  font-family: 'Courier New', monospace;
  font-size: 0.85rem;
  font-weight: 600;
}

.af-legal-body a {
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 600;
  border-bottom: 1px dotted var(--color-primary);
}

.af-legal-body a:hover {
  border-bottom-style: solid;
  background: rgba(var(--color-primary-rgb), 0.05);
  padding: 0 2px;
}

.af-legal-footer {
  text-align: center;
  margin-top: var(--space-10);
  padding: var(--space-6);
  background: var(--color-bg-secondary);
  border-radius: var(--radius-md);
  color: var(--color-text-secondary);
  font-size: 0.85rem;
  border: 1px solid var(--color-border);
}

@media (max-width: 768px) {
  .af-legal-hero h1 {
    font-size: 1.5rem;
  }
  
  .af-legal-body section {
    padding: var(--space-4);
  }
  
  .af-legal-body h2 {
    font-size: 1.15rem;
  }
  
  .af-legal-body h3 {
    font-size: 0.95rem;
  }
  
  .af-legal-body table {
    font-size: 0.85rem;
  }
  
  .af-legal-body table th,
  .af-legal-body table td {
    padding: var(--space-2);
  }
}
</style>

<?php get_footer();
