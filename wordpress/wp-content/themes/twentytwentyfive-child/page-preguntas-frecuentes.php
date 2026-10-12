<?php
/**
 * Template: Preguntas Frecuentes
 * Diseño compacto 2 columnas, sin sidebar
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-faq-page">
  <section class="af-faq-hero">
    <div class="container">
      <h1><?php esc_html_e('Preguntas Frecuentes', 'twentytwentyfive-child'); ?></h1>
      <p><?php esc_html_e('Encuentra respuestas rápidas sobre cómo usar Arriendo Fácil', 'twentytwentyfive-child'); ?></p>
    </div>
  </section>

  <section class="af-faq-section">
    <div class="container">
      <div class="af-faq-grid">
        <!-- Columna 1 -->
        <div class="af-faq-column">
          <h2 class="af-faq-subtitle"><?php esc_html_e('Plataforma', 'twentytwentyfive-child'); ?></h2>
          <div class="af-faq-list">
            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Qué es Arriendo Fácil?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Software de gestión de propiedades. Automatiza facturación SRI, pagos, mantenimiento y liquidaciones.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Cómo empiezo?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Crea cuenta, verifica correo y carga propiedades. Te guiaremos paso a paso.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Hay costo?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Sí. Precios según propiedades y servicios. Contacta para presupuesto.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Está segura mi información?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Sí. Encriptación HTTPS, GDPR y CCPA compliant. 100% confidencial.', 'twentytwentyfive-child'); ?></p>
            </details>
          </div>

          <h2 class="af-faq-subtitle"><?php esc_html_e('Facturación SRI', 'twentytwentyfive-child'); ?></h2>
          <div class="af-faq-list">
            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Son válidas ante SRI?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Sí. Firmadas electrónicamente y autorizadas ante SRI. Legalmente válidas.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Quién autoriza?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Tú, con un clic. Nada se emite sin tu revisión.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Conceptos por propiedad?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Sí. Canon, administración, alícuotas y servicios personalizados.', 'twentytwentyfive-child'); ?></p>
            </details>
          </div>
        </div>

        <!-- Columna 2 -->
        <div class="af-faq-column">
          <h2 class="af-faq-subtitle"><?php esc_html_e('Tu Cuenta', 'twentytwentyfive-child'); ?></h2>
          <div class="af-faq-list">
            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Olvidé contraseña?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Haz clic "¿Olvidaste?". Recibirás enlace para restablecerla.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Cuántas propiedades?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Tantas como necesites. Límite según tu plan.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Cambiar plan?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Sí. Actualiza o baja tu plan en cualquier momento desde el panel.', 'twentytwentyfive-child'); ?></p>
            </details>
          </div>

          <h2 class="af-faq-subtitle"><?php esc_html_e('Pagos y Morosidad', 'twentytwentyfive-child'); ?></h2>
          <div class="af-faq-list">
            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Cómo registrar pagos?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Manual o integrado con banco. Detecta atrasos automáticamente.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Si inquilino no paga?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Se marca como moroso. Envía recordatorios y genera reportes.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Liquidación?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Automática mensual: ingresos menos costos. 100% auditable.', 'twentytwentyfive-child'); ?></p>
            </details>

            <details class="af-faq-item">
              <summary><?php esc_html_e('¿Contacto?', 'twentytwentyfive-child'); ?></summary>
              <p><?php esc_html_e('Email: arriendofacilnet@gmail.com | <a href="' . esc_url(home_url('/contacto/')) . '">Contacto</a> | Respuesta en 24h.', 'twentytwentyfive-child'); ?></p>
            </details>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="af-faq-cta">
    <div class="container">
      <h2><?php esc_html_e('¿No encontraste tu respuesta?', 'twentytwentyfive-child'); ?></h2>
      <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary">
        <?php esc_html_e('Contactar soporte', 'twentytwentyfive-child'); ?>
      </a>
    </div>
  </section>
</main>

<style>
.af-faq-page {
  background: var(--color-bg-primary);
}

.af-faq-hero {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-8) 0;
  text-align: center;
  margin-bottom: var(--space-10);
}

.af-faq-hero h1 {
  font-size: 2rem;
  margin-bottom: var(--space-2);
  font-weight: 700;
}

.af-faq-hero p {
  font-size: 1rem;
  opacity: 0.95;
}

.af-faq-section {
  padding: var(--space-8) 0;
}

.af-faq-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-10);
}

@media (max-width: 768px) {
  .af-faq-grid {
    grid-template-columns: 1fr;
    gap: var(--space-6);
  }
}

.af-faq-column {
  display: flex;
  flex-direction: column;
  gap: var(--space-8);
}

.af-faq-subtitle {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--color-primary);
  margin: var(--space-6) 0 var(--space-4) 0;
  padding-bottom: var(--space-3);
  border-bottom: 2px solid var(--color-border);
}

.af-faq-list {
  display: flex;
  flex-direction: column;
  gap: var(--space-2);
}

.af-faq-item {
  background: white;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  overflow: hidden;
}

.af-faq-item summary {
  padding: var(--space-4);
  cursor: pointer;
  font-weight: 600;
  color: var(--color-text-primary);
  user-select: none;
  transition: background 0.2s;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.af-faq-item summary:hover {
  background: var(--color-bg-secondary);
}

.af-faq-item summary::after {
  content: '▼';
  font-size: 0.8rem;
  margin-left: var(--space-3);
  transition: transform 0.3s;
  flex-shrink: 0;
}

.af-faq-item[open] summary {
  background: var(--color-bg-secondary);
  color: var(--color-primary);
}

.af-faq-item[open] summary::after {
  transform: rotate(180deg);
}

.af-faq-item p {
  padding: 0 var(--space-4) var(--space-4) var(--space-4);
  margin: 0;
  color: var(--color-text-secondary);
  line-height: 1.6;
  font-size: 0.95rem;
}

.af-faq-item a {
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 500;
}

.af-faq-item a:hover {
  text-decoration: underline;
}

.af-faq-cta {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-10) 0;
  text-align: center;
  margin-top: var(--space-10);
}

.af-faq-cta h2 {
  font-size: 1.5rem;
  margin-bottom: var(--space-6);
  font-weight: 700;
}

@media (max-width: 768px) {
  .af-faq-hero h1 {
    font-size: 1.5rem;
  }
  
  .af-faq-cta h2 {
    font-size: 1.25rem;
  }
}
</style>
            <h2 class="af-faq-section-title"><?php esc_html_e('Plataforma', 'twentytwentyfive-child'); ?></h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Qué es Arriendo Fácil?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Arriendo Fácil es un software de gestión de propiedades (PMS) diseñado para gestores inmobiliarios en Ecuador. Automatiza facturación SRI, control de pagos, mantenimiento y liquidaciones en un solo panel.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo empiezo?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Crea una cuenta en nuestro formulario de registro, verifica tu correo y comienza a cargar tus propiedades. Te guiaremos paso a paso.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Hay costo para usar la plataforma?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Los precios dependen del número de propiedades y servicios que contrates. Puedes ver nuestros planes o contactarnos para un presupuesto personalizado.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Tu Cuenta -->
          <section id="faq-cuenta" class="af-faq-section">
            <h2 class="af-faq-section-title"><?php esc_html_e('Tu cuenta', 'twentytwentyfive-child'); ?></h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Olvidé mi contraseña. Qué hago?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Haz clic en "¿Olvidaste tu contraseña?" en el formulario de login. Te enviaremos un enlace para que puedas restablecerla.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cuántas propiedades puedo registrar?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Puedes registrar tantas propiedades como necesites. El número de propiedades activas dependerá de tu plan contratado.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Mi información está segura?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Utilizamos encriptación HTTPS, autenticación segura y conformidad con GDPR y CCPA. Tus datos son 100% confidenciales.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Servicios -->
          <section id="faq-servicios" class="af-faq-section">
            <h2 class="af-faq-section-title"><?php esc_html_e('Servicios', 'twentytwentyfive-child'); ?></h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo funciona la facturación electrónica?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Nosotros emitimos y autorizamos tus facturas electrónicas ante el SRI usando tu firma digital. Cada mes calculamos canon, alícuotas y servicios automáticamente.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo se registran los pagos?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Puedes registrar pagos manualmente o integrarnos con tu banco. El sistema detecta automáticamente atrasos desde el día 1 del mes.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Qué pasa si el inquilino no paga?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('El sistema lo marca como moroso automáticamente. Puedes enviar recordatorios, registrar intereses y generar reportes de morosidad para tus cobros.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo se calcula la liquidación?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Cada mes el sistema genera tu liquidación automática: ingresos por canon, menos costos de mantenimiento y administración, iguales a tu pago neto. Auditable línea por línea.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Soporte -->
          <section id="faq-soporte" class="af-faq-section">
            <h2 class="af-faq-section-title"><?php esc_html_e('Soporte', 'twentytwentyfive-child'); ?></h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo me comunico con soporte?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Puedes contactarnos por correo en arriendofacilnet@gmail.com, WhatsApp o a través del formulario de contacto en nuestra web. Respondemos en menos de 24 horas.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Ofrecen capacitación?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"><path stroke="currentColor" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Incluimos videos tutoriales, guías escritas y sesiones de capacitación en vivo para nuevos usuarios. Contáctanos para agendar una sesión.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Still have questions? -->
          <div class="af-faq-cta">
            <h2><?php esc_html_e('¿Aún tienes dudas?', 'twentytwentyfive-child'); ?></h2>
            <p><?php esc_html_e('Nuestro equipo está disponible para ayudarte.', 'twentytwentyfive-child'); ?></p>
            <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary btn--lg">
              <?php esc_html_e('Contactar soporte', 'twentytwentyfive-child'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
.af-faq-page {
  background: var(--color-bg-primary);
}

/* Hero Section */
.af-faq-hero {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-12) 0;
  text-align: center;
}

.af-faq-hero-content {
  max-width: 600px;
  margin: 0 auto;
}

.af-faq-hero .af-eyebrow {
  color: rgba(255, 255, 255, 0.8);
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0.05em;
  display: block;
  margin-bottom: var(--space-2);
}

.af-faq-hero h1 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: var(--space-4);
}

.af-faq-hero p {
  font-size: 1.1rem;
  opacity: 0.95;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .af-faq-hero {
    padding: var(--space-10) 0;
  }
  
  .af-faq-hero h1 {
    font-size: 2rem;
  }
  
  .af-faq-hero p {
    font-size: 1rem;
  }
}

/* Content Layout */
.af-faq-content {
  padding: var(--space-12) 0;
}

.af-faq-layout {
  display: grid;
  grid-template-columns: 250px 1fr;
  gap: var(--space-8);
}

@media (max-width: 1024px) {
  .af-faq-layout {
    grid-template-columns: 200px 1fr;
    gap: var(--space-6);
  }
}

@media (max-width: 768px) {
  .af-faq-layout {
    grid-template-columns: 1fr;
    gap: 0;
  }
}

/* Sidebar Navigation */
.af-faq-nav {
  position: sticky;
  top: 20px;
  height: fit-content;
}

.af-faq-nav-toggle {
  display: none;
  width: 100%;
  padding: var(--space-4);
  background: var(--color-bg-secondary);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  font-weight: 600;
  cursor: pointer;
  align-items: center;
  justify-content: space-between;
}

@media (max-width: 768px) {
  .af-faq-nav-toggle {
    display: flex;
  }
}

.af-faq-nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

@media (max-width: 768px) {
  .af-faq-nav-list {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    border-top: none;
    border-radius: 0 0 var(--radius-md) var(--radius-md);
    overflow: hidden;
    z-index: 10;
  }
  
  .af-faq-nav-toggle[aria-expanded="true"] + .af-faq-nav-list {
    display: block;
  }
}

.af-faq-nav-link {
  display: block;
  padding: var(--space-4);
  color: var(--color-text-secondary);
  text-decoration: none;
  font-size: 0.95rem;
  border-left: 3px solid transparent;
  transition: all 0.2s ease;
}

.af-faq-nav-link:hover,
.af-faq-nav-link.active {
  color: var(--color-primary);
  background: var(--color-bg-secondary);
  border-left-color: var(--color-primary);
  padding-left: calc(var(--space-4) + 4px);
}

/* Accordion */
.af-faq-section {
  margin-bottom: var(--space-10);
}

.af-faq-section:last-child {
  margin-bottom: var(--space-12);
}

.af-faq-section-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: var(--space-6);
  color: var(--color-text-primary);
  padding-bottom: var(--space-4);
  border-bottom: 2px solid var(--color-border);
}

.af-faq-list {
  display: flex;
  flex-direction: column;
  gap: var(--space-4);
}

.af-faq-item {
  background: white;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  overflow: hidden;
}

.af-faq-question {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: var(--space-5);
  cursor: pointer;
  font-weight: 600;
  color: var(--color-text-primary);
  user-select: none;
  transition: background 0.2s ease;
}

.af-faq-question:hover {
  background: var(--color-bg-secondary);
}

.af-faq-icon {
  flex-shrink: 0;
  transition: transform 0.3s ease;
  margin-left: var(--space-3);
}

.af-faq-item[open] .af-faq-question {
  background: var(--color-bg-secondary);
  color: var(--color-primary);
}

.af-faq-item[open] .af-faq-icon {
  transform: rotate(180deg);
}

.af-faq-answer {
  padding: 0 var(--space-5) var(--space-5) var(--space-5);
  color: var(--color-text-secondary);
  line-height: 1.7;
}

.af-faq-answer p {
  margin: 0;
}

.af-faq-answer p + p {
  margin-top: var(--space-4);
}

.af-faq-answer ul,
.af-faq-answer ol {
  margin: var(--space-4) 0;
  padding-left: var(--space-6);
}

.af-faq-answer li {
  margin-bottom: var(--space-2);
}

/* CTA Section */
.af-faq-cta {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  border-radius: var(--radius-lg);
  padding: var(--space-10);
  text-align: center;
  margin-top: var(--space-12);
}

.af-faq-cta h2 {
  font-size: 2rem;
  margin-bottom: var(--space-2);
}

.af-faq-cta p {
  font-size: 1.1rem;
  opacity: 0.95;
  margin-bottom: var(--space-6);
}

.af-faq-cta .btn {
  margin: 0 auto;
}

@media (max-width: 768px) {
  .af-faq-cta {
    padding: var(--space-8);
  }
  
  .af-faq-cta h2 {
    font-size: 1.5rem;
  }
}
</style>

<script>
// Cerrar otros acordeones cuando uno se abre
document.querySelectorAll('.af-faq-item').forEach(item => {
  item.addEventListener('toggle', function() {
    if (this.open) {
      document.querySelectorAll('.af-faq-item').forEach(other => {
        if (other !== this) other.open = false;
      });
    }
  });
});
</script>

<?php get_footer();
