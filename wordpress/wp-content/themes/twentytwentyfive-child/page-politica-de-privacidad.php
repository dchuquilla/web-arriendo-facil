<?php
/**
 * Template Name: Política de Privacidad
 * Página legal con cumplimiento GDPR, CCPA y Ecuador 2026
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-legal-page">
  <section class="af-legal-hero">
    <div class="container">
      <h1><?php esc_html_e('Política de Privacidad', 'twentytwentyfive-child'); ?></h1>
      <p><?php esc_html_e('Última actualización: 12 de octubre de 2026 | Versión 2.0', 'twentytwentyfive-child'); ?></p>
    </div>
  </section>

  <article class="af-legal-content container">
    <div class="af-legal-body">

      <section id="introduccion">
        <h2>1. Introducción</h2>
        <p>Arriendo Fácil ("nosotros", "nuestro", "la Plataforma") es una plataforma de gestión de propiedades en alquiler operada desde Quito, Ecuador. Estamos comprometidos con la protección de tus datos personales y tu privacidad, en cumplimiento con:</p>
        <ul>
          <li>Reglamento General de Protección de Datos (GDPR) - UE</li>
          <li>California Consumer Privacy Act (CCPA) - USA</li>
          <li>Leyes de Protección de Datos Personales - Ecuador</li>
        </ul>
      </section>

      <section id="datos-recopilamos">
        <h2>2. Datos que Recopilamos</h2>
        
        <h3>2.1 De Propietarios</h3>
        <ul>
          <li>Nombre completo, email, teléfono verificado</li>
          <li>Cédula de identidad o RUC (para verificación legal)</li>
          <li>Dirección de domicilio (principal y de propiedades)</li>
          <li>Datos de facturación del plan Premium (nombre, RUC o cédula, correo). Los datos de tarjeta los procesa directamente el proveedor de pagos; Arriendo Fácil no almacena el número completo ni el código de seguridad</li>
          <li>Firma digital y contraseña SRI (encriptados)</li>
          <li>Historial de transacciones y pagos</li>
          <li>Documentos de propiedad (título, factura de compra)</li>
        </ul>

        <h3>2.2 De Inquilinos</h3>
        <ul>
          <li>Nombre, email, teléfono</li>
          <li>Cédula de identidad verificada</li>
          <li>Domicilio actual y anterior</li>
          <li>Información laboral (empresa, cargo, ingresos estimados)</li>
          <li>Historial de pagos y mora</li>
          <li>Datos de emergencia (pariente, contacto)</li>
          <li>Score de pago (basado en historial)</li>
        </ul>

        <h3>2.3 Datos Técnicos (Automáticos)</h3>
        <ul>
          <li>Dirección IP (detectada a través de Cloudflare)</li>
          <li>Tipo de dispositivo y navegador</li>
          <li>Sistema operativo y versión</li>
          <li>Cookies y localStorage</li>
          <li>Hora de acceso y duración de sesión</li>
          <li>Ubicación aproximada (geolocalización por IP, no GPS)</li>
          <li>Páginas visitadas y acciones (clicks, formularios)</li>
        </ul>
      </section>

      <section id="base-legal">
        <h2>3. Base Legal para el Procesamiento</h2>
        <table style="width:100%; border-collapse: collapse; margin: var(--space-4) 0;">
          <tr style="background: var(--color-bg-secondary);">
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Base Legal</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Descripción</th>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><strong>Contrato</strong></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Necesario para ejecutar acuerdos de alquiler y servicios</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><strong>Consentimiento</strong></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Para marketing, estadísticas, cookies opcionales</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><strong>Obligación Legal</strong></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Cumplimiento fiscal SRI, antilavado AML, prevención de fraude</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);"><strong>Interés Legítimo</strong></td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Seguridad de plataforma, detección de abuso, mejora de servicio</td>
          </tr>
        </table>
      </section>

      <section id="uso-datos">
        <h2>4. Uso de Datos</h2>
        <h3>Usamos tus datos para:</h3>
        <ul>
          <li>Facilitar contratos, el seguimiento de pagos y el cobro de suscripciones Premium</li>
          <li>Generar facturas electrónicas ante SRI</li>
          <li>Comunicaciones relacionadas con tu cuenta</li>
          <li>Cumplimiento legal y regulatorio (impuestos, antilavado)</li>
          <li>Prevención de fraude y abuso de plataforma</li>
          <li>Análisis agregados nunca identificables (estadísticas)</li>
          <li>Mejora de funcionalidad y experiencia del usuario</li>
          <li>Soporte técnico y atención al cliente</li>
        </ul>

        <h3>NO usamos datos para:</h3>
        <ul>
          <li>Venta a terceros sin consentimiento explícito</li>
          <li>Vigilancia discriminatoria o perfilado ilegal</li>
          <li>Decisiones automatizadas que afecten derechos legales</li>
          <li>Allá del propósito original sin consentimiento nuevo</li>
          <li>Marketing a inquilinos sin consentimiento previo</li>
        </ul>
      </section>

      <section id="retencion">
        <h2>5. Almacenamiento y Retención de Datos</h2>
        <table style="width:100%; border-collapse: collapse; margin: var(--space-4) 0;">
          <tr style="background: var(--color-bg-secondary);">
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Tipo de Dato</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Duración</th>
            <th style="padding: var(--space-3); text-align: left; border: 1px solid var(--color-border);">Motivo</th>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Datos de contrato activo</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Vigencia + 7 años</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Cumplimiento fiscal SRI</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Datos de cobro de suscripción (sin datos completos de tarjeta)</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">7 años después cierre</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Auditoría fiscal y cumplimiento</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Cookies funcionales</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Hasta 2 años</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Preferencias del usuario</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Cookies analíticas</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">90 días</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Métricas de navegación</td>
          </tr>
          <tr>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Logs de seguridad</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">90 días</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Detección de amenazas</td>
          </tr>
          <tr style="background: var(--color-bg-secondary);">
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Datos borrados (copia seguridad)</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">30 días</td>
            <td style="padding: var(--space-3); border: 1px solid var(--color-border);">Recuperación ante errores</td>
          </tr>
        </table>
        <p><strong>Destrucción:</strong> Los datos se destruyen de forma irreversible (eliminación criptográfica, no solo eliminación lógica).</p>
      </section>

      <section id="derechos-gdpr">
        <h2>6. Tus Derechos de Privacidad (GDPR/CCPA)</h2>
        
        <h3>6.1 Derecho de Acceso</h3>
        <p>Puedes solicitar una copia completa de tus datos personales en formato legible (CSV, PDF). Responderemos en máximo 30 días.</p>

        <h3>6.2 Derecho a la Rectificación</h3>
        <p>Puedes solicitar que corrijamos datos inexactos o incompletos.</p>

        <h3>6.3 Derecho al Olvido ("Right to be Forgotten")</h3>
        <p>Puedes solicitar la eliminación de tus datos, excepto donde hay obligación legal (7 años de retención fiscal).</p>

        <h3>6.4 Derecho a la Portabilidad</h3>
        <p>Puedes solicitar tus datos en formato estructurado para transferencia a otro servicio.</p>

        <h3>6.5 Derecho a Oponerme al Procesamiento</h3>
        <p>Puedes oponer al procesamiento para fines de marketing o análisis.</p>

        <h3>6.6 Cómo Ejercer Derechos</h3>
        <p>Envía solicitud a: <a href="mailto:privacy@arriendofacil.net">privacy@arriendofacil.net</a> con copia de tu cédula.</p>
      </section>

      <section id="cookies">
        <h2>7. Cookies y Rastreo</h2>
        
        <h3>Tipos de Cookies:</h3>
        <ul>
          <li><strong>Funcionales:</strong> Autenticación, sesión, preferencias (NECESARIAS)</li>
          <li><strong>Analíticas:</strong> Google Analytics para medir uso (OPCIONAL)</li>
          <li><strong>Marketing:</strong> Retargeting y publicidad personalizada (OPCIONAL)</li>
        </ul>

        <h3>Opt-out:</h3>
        <ul>
          <li>Rechaza cookies en el banner de consentimiento</li>
          <li>Configura tu navegador para bloquear cookies terceras</li>
          <li>Usa Do Not Track en tu navegador</li>
        </ul>
      </section>

      <section id="seguridad">
        <h2>8. Seguridad de Datos</h2>
        <ul>
          <li>Encriptación HTTPS en todas las conexiones</li>
          <li>Contraseñas encriptadas con bcrypt/Argon2</li>
          <li>Autenticación de dos factores (2FA) disponible</li>
          <li>Firewalls y detección de intrusos (WAF Cloudflare)</li>
          <li>Backups diarios encriptados</li>
          <li>Acceso limitado por roles (principio de menor privilegio)</li>
          <li>Auditorías de seguridad anuales</li>
          <li>Política de notificación de brechas en 72 horas</li>
        </ul>
      </section>

      <section id="transferencias">
        <h2>9. Transferencias Internacionales</h2>
        <p>Tus datos se almacenan en servidores en Ecuador y a través de Cloudflare (USA/UE). Estas transferencias cumplen con:</p>
        <ul>
          <li>Decisiones de Adecuación (Adequacy Decisions)</li>
          <li>Cláusulas Contractuales Estándar (SCC)</li>
          <li>Cumplimiento GDPR Art. 45-49</li>
        </ul>
      </section>

      <section id="terceros">
        <h2>10. Compartición con Terceros</h2>
        <p>Compartimos datos solo con:</p>
        <ul>
          <li>SRI (autoridades fiscales) - facturación legal</li>
          <li>Proveedores de pagos - procesamiento seguro de los cobros con tarjeta del plan Premium</li>
          <li>Cloudflare - almacenamiento y CDN</li>
          <li>Google Analytics - estadísticas agregadas (anónimas)</li>
          <li>Autoridades legales - cuando se requiera por ley</li>
        </ul>
        <p><strong>NO compartimos sin consentimiento:</strong> Datos con fines de marketing o venta a terceros.</p>
      </section>

      <section id="menores">
        <h2>11. Protección de Menores</h2>
        <p>Este servicio no está dirigido a personas menores de 18 años. No recopilamos datos de menores deliberadamente. Si descubrimos que hemos recopilado datos de un menor, los eliminaremos inmediatamente.</p>
      </section>

      <section id="cambios">
        <h2>12. Cambios a esta Política</h2>
        <p>Podemos actualizar esta política en cualquier momento. Cambios materiales serán notificados por email con 15 días de anticipación. El continuar usando el servicio constituye aceptación.</p>
      </section>

      <section id="contacto">
        <h2>13. Contacto - Oficial de Privacidad</h2>
        <ul>
          <li><strong>Email:</strong> <a href="mailto:privacy@arriendofacil.net">privacy@arriendofacil.net</a></li>
          <li><strong>Dirección:</strong> Quito, Pichincha, Ecuador</li>
          <li><strong>Teléfono:</strong> A través de plataforma</li>
        </ul>
        <p><strong>Autoridad de Protección de Datos (Ecuador):</strong> Superintendencia de Telecomunicaciones (SUPERTEL)</p>
      </section>

      <p class="af-legal-footer">
        <strong>© 2026 Arriendo Fácil Soluciones Inmobiliarias.</strong> Todos los derechos reservados. 
        Última actualización: 12 de octubre de 2026 | Versión 2.0
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
  padding: var(--space-5) 0 var(--space-4) 0;
  text-align: left;
  margin-bottom: var(--space-3);
  border-bottom: 4px solid rgba(255,255,255,0.2);
}

.af-legal-hero h1 {
  font-size: 2rem;
  margin-bottom: 0.25rem;
  font-weight: 800;
}

.af-legal-hero p {
  opacity: 0.85;
  font-size: 0.9rem;
  margin: 0;
}

.af-legal-content {
  max-width: 900px;
  padding: 0;
}

.af-legal-body {
  line-height: 1.6;
  color: var(--color-text-primary);
}

.af-legal-body section {
  margin-bottom: var(--space-5);
  padding: var(--space-4) var(--space-5);
  background: white;
  border-left: 4px solid var(--color-primary);
  border-radius: var(--radius-md);
  box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}

.af-legal-body section:hover {
  box-shadow: 0 2px 6px rgba(0,0,0,0.07);
  transition: box-shadow 0.2s;
}

.af-legal-body h2 {
  font-size: 1.25rem;
  font-weight: 800;
  margin: 0 0 var(--space-2) 0;
  color: var(--color-primary);
  display: flex;
  align-items: center;
  gap: var(--space-1);
}

.af-legal-body h2::before {
  content: '';
  display: inline-block;
  width: 24px;
  height: 24px;
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  border-radius: 50%;
  text-align: center;
  line-height: 24px;
  font-size: 0.85rem;
  font-weight: bold;
  flex-shrink: 0;
}

.af-legal-body p {
  margin: var(--space-2) 0;
  font-size: 0.92rem;
  line-height: 1.6;
}

.af-legal-body h3 {
  font-size: 0.95rem;
  font-weight: 700;
  margin: var(--space-3) 0 var(--space-1) 0;
  color: var(--color-text-primary);
  border-bottom: 1px solid var(--color-border);
  padding-bottom: var(--space-1);
}

.af-legal-body ul,
.af-legal-body ol {
  margin: var(--space-2) 0 var(--space-2) var(--space-4);
  padding: 0;
}

.af-legal-body li {
  margin-bottom: var(--space-1);
  line-height: 1.6;
  font-size: 0.92rem;
}

.af-legal-body strong {
  color: var(--color-primary);
  font-weight: 700;
}

.af-legal-body table {
  width: 100%;
  border-collapse: collapse;
  margin: var(--space-3) 0;
  background: var(--color-bg-secondary);
  border-radius: var(--radius-md);
  overflow: hidden;
  font-size: 0.9rem;
}

.af-legal-body table thead {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
}

.af-legal-body table th {
  padding: var(--space-2);
  text-align: left;
  font-weight: 700;
  font-size: 0.85rem;
}

.af-legal-body table td {
  padding: var(--space-2);
  border-bottom: 1px solid var(--color-border);
  font-size: 0.88rem;
}

.af-legal-body table tr:last-child td {
  border-bottom: none;
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
  margin-top: var(--space-8);
  padding: var(--space-4);
  background: var(--color-bg-secondary);
  border-radius: var(--radius-md);
  color: var(--color-text-secondary);
  font-size: 0.82rem;
  border: 1px solid var(--color-border);
  line-height: 1.5;
}

@media (max-width: 768px) {
  .af-legal-hero h1 {
    font-size: 1.5rem;
  }
  
  .af-legal-body section {
    padding: var(--space-3) var(--space-3);
  }
  
  .af-legal-body h2 {
    font-size: 1.1rem;
  }
  
  .af-legal-body h3 {
    font-size: 0.9rem;
  }
  
  .af-legal-body p {
    font-size: 0.9rem;
  }
  
  .af-legal-body table {
    font-size: 0.8rem;
  }
  
  .af-legal-body table th,
  .af-legal-body table td {
    padding: var(--space-1);
  }
}
</style>

<?php get_footer();
