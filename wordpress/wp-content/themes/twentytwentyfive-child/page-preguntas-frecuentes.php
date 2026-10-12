<?php
/**
 * Template: Preguntas Frecuentes
 * Diseño moderno con navegación lateral y acordeones mejorados
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-faq-page">
  <!-- Hero Section -->
  <section class="af-faq-hero">
    <div class="container">
      <div class="af-faq-hero-content">
        <h1><?php esc_html_e('Preguntas Frecuentes', 'twentytwentyfive-child'); ?></h1>
        <p><?php esc_html_e('Encuentra respuestas rápidas y claras sobre cómo usar Arriendo Fácil', 'twentytwentyfive-child'); ?></p>
      </div>
    </div>
  </section>

  <!-- Content Section -->
  <section class="af-faq-content">
    <div class="container">
      <div class="af-faq-layout">
        <!-- Sidebar Navigation -->
        <aside class="af-faq-sidebar">
          <nav class="af-faq-nav" id="faqNav">
            <ul class="af-faq-nav-list">
              <li><a href="#faq-plataforma" class="af-faq-nav-link active" data-section="plataforma">
                <svg class="af-faq-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="17" x2="22" y2="17"/></svg>
                <span><?php esc_html_e('Plataforma', 'twentytwentyfive-child'); ?></span>
              </a></li>
              <li><a href="#faq-cuenta" class="af-faq-nav-link" data-section="cuenta">
                <svg class="af-faq-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><?php esc_html_e('Tu Cuenta', 'twentytwentyfive-child'); ?></span>
              </a></li>
              <li><a href="#faq-facturacion" class="af-faq-nav-link" data-section="facturacion">
                <svg class="af-faq-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                <span><?php esc_html_e('Facturación SRI', 'twentytwentyfive-child'); ?></span>
              </a></li>
              <li><a href="#faq-pagos" class="af-faq-nav-link" data-section="pagos">
                <svg class="af-faq-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 11h-4v2h4v-2z"/><line x1="2" y1="11" x2="22" y2="11"/></svg>
                <span><?php esc_html_e('Pagos', 'twentytwentyfive-child'); ?></span>
              </a></li>
              <li><a href="#faq-soporte" class="af-faq-nav-link" data-section="soporte">
                <svg class="af-faq-nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span><?php esc_html_e('Soporte', 'twentytwentyfive-child'); ?></span>
              </a></li>
            </ul>
          </nav>
        </aside>

        <!-- Main Content -->
        <div class="af-faq-main">
          <!-- Plataforma -->
          <section id="faq-plataforma" class="af-faq-section">
            <h2 class="af-faq-section-title">
              <svg class="af-faq-section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="17" x2="22" y2="17"/></svg>
              <?php esc_html_e('Plataforma', 'twentytwentyfive-child'); ?>
            </h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Qué es Arriendo Fácil?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Arriendo Fácil es un software de gestión de propiedades (PMS) diseñado para gestores inmobiliarios en Ecuador. Automatiza facturación SRI, control de pagos, mantenimiento y liquidaciones en un solo panel.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo empiezo?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Crea una cuenta en nuestro formulario de registro, verifica tu correo y comienza a cargar tus propiedades. Te guiaremos paso a paso.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Hay costo para usar la plataforma?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Los precios dependen del número de propiedades y servicios que contrates. Puedes ver nuestros planes o contactarnos para un presupuesto personalizado.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Está segura mi información?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Encriptación HTTPS, GDPR y CCPA compliant. Tus datos están 100% seguros y confidenciales.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Tu Cuenta -->
          <section id="faq-cuenta" class="af-faq-section">
            <h2 class="af-faq-section-title">
              <svg class="af-faq-section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              <?php esc_html_e('Tu Cuenta', 'twentytwentyfive-child'); ?>
            </h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Olvidé mi contraseña?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Haz clic en "¿Olvidaste tu contraseña?" en el formulario de login. Te enviaremos un enlace para que puedas restablecerla en minutos.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cuántas propiedades puedo registrar?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Puedes registrar tantas propiedades como necesites. El número de propiedades activas dependerá de tu plan contratado.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cambiar plan?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Puedes actualizar o bajar tu plan en cualquier momento desde tu panel de control. El cambio se reflejará en el próximo ciclo de facturación.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Facturación SRI -->
          <section id="faq-facturacion" class="af-faq-section">
            <h2 class="af-faq-section-title">
              <svg class="af-faq-section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
              <?php esc_html_e('Facturación SRI', 'twentytwentyfive-child'); ?>
            </h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Son válidas ante SRI?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí, completamente. Todas nuestras facturas están firmadas electrónicamente y autorizadas ante el SRI. Son legalmente válidas y reconocidas por el estado ecuatoriano.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Quién autoriza las facturas?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Tú controlas el proceso. Nosotros generamos la factura, pero tú decides autorizar con un clic. Nada se emite sin tu revisión y aprobación explícita.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Conceptos por propiedad?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Puedes personalizar completamente los conceptos por propiedad: canon mensual, administración, alícuotas, servicios adicionales y más. Cada propiedad puede tener su estructura única.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Pagos y Morosidad -->
          <section id="faq-pagos" class="af-faq-section">
            <h2 class="af-faq-section-title">
              <svg class="af-faq-section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 11h-4v2h4v-2z"/><line x1="2" y1="11" x2="22" y2="11"/></svg>
              <?php esc_html_e('Pagos y Morosidad', 'twentytwentyfive-child'); ?>
            </h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo registrar pagos?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Puedes registrar pagos de dos formas: manualmente en el sistema o integrado con tu banco. El sistema detecta automáticamente los atrasos desde el primer día del mes.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Si el inquilino no paga?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('El sistema lo marca automáticamente como moroso. Puedes enviar recordatorios, registrar intereses moratorios y generar reportes de morosidad para facilitar tus gestiones de cobro.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo se calcula la liquidación?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Cada mes el sistema genera tu liquidación automáticamente: ingresos por canon y servicios, menos costos de mantenimiento y administración, igual a tu pago neto. 100% auditable línea por línea.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- Soporte -->
          <section id="faq-soporte" class="af-faq-section">
            <h2 class="af-faq-section-title">
              <svg class="af-faq-section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <?php esc_html_e('Soporte', 'twentytwentyfive-child'); ?>
            </h2>
            <div class="af-faq-list">
              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Cómo me comunico con soporte?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Puedes contactarnos por correo (arriendofacilnet@gmail.com), WhatsApp o a través del formulario de contacto en nuestra web. Nuestro equipo responde en menos de 24 horas.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>

              <details class="af-faq-item">
                <summary class="af-faq-question">
                  <span><?php esc_html_e('¿Ofrecen capacitación?', 'twentytwentyfive-child'); ?></span>
                  <svg class="af-faq-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8l4 4 4-4"/></svg>
                </summary>
                <div class="af-faq-answer">
                  <p><?php esc_html_e('Sí. Incluimos videos tutoriales, guías escritas y sesiones de capacitación en vivo para nuevos usuarios. Contáctanos para agendar una sesión de capacitación personalizada.', 'twentytwentyfive-child'); ?></p>
                </div>
              </details>
            </div>
          </section>

          <!-- CTA -->
          <section class="af-faq-cta">
            <div class="af-faq-cta-content">
              <h2><?php esc_html_e('¿Aún tienes dudas?', 'twentytwentyfive-child'); ?></h2>
              <p><?php esc_html_e('Nuestro equipo está disponible para ayudarte. Contacta con nosotros ahora.', 'twentytwentyfive-child'); ?></p>
              <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary btn--lg">
                <?php esc_html_e('Contactar soporte', 'twentytwentyfive-child'); ?>
              </a>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
/* ===== Variables & Base ===== */
:root {
  --faq-section-gradient-1: linear-gradient(135deg, #7bb6e8 0%, #5a9fd4 100%);
  --faq-section-gradient-2: linear-gradient(135deg, #a8d5ba 0%, #7fb8a4 100%);
  --faq-section-gradient-3: linear-gradient(135deg, #f8c471 0%, #f0a850 100%);
  --faq-section-gradient-4: linear-gradient(135deg, #f49393 0%, #e26b6b 100%);
  --faq-section-gradient-5: linear-gradient(135deg, #b19cd9 0%, #9370b8 100%);
}

.af-faq-page {
  background: var(--color-bg-primary);
}

/* ===== Hero Section ===== */
.af-faq-hero {
  background: linear-gradient(135deg, #7dbe52 0%, #5a9537 100%);
  color: white;
  padding: 1.5rem 0;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.af-faq-hero::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  border-radius: 50%;
}

.af-faq-hero-content {
  max-width: 700px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}

.af-faq-hero h1 {
  font-size: clamp(1.5rem, 3.5vw, 2.2rem);
  font-weight: 800;
  margin-bottom: 0.25rem;
  letter-spacing: -0.02em;
}

.af-faq-hero p {
  font-size: 0.9rem;
  opacity: 0.95;
  line-height: 1.4;
  font-weight: 400;
}

/* ===== Content Layout ===== */
.af-faq-content {
  padding: 2rem 0;
}

.af-faq-layout {
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 2rem;
}

@media (max-width: 1024px) {
  .af-faq-layout {
    grid-template-columns: 200px 1fr;
    gap: 1.5rem;
  }
}

@media (max-width: 768px) {
  .af-faq-layout {
    grid-template-columns: 1fr;
    gap: 0;
  }
}

/* ===== Sidebar Navigation ===== */
.af-faq-sidebar {
  position: sticky;
  top: 1rem;
  height: fit-content;
}

.af-faq-nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
  background: white;
  border: 1px solid var(--color-border);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.af-faq-nav-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0.85rem;
  color: var(--color-text-secondary);
  text-decoration: none;
  font-weight: 500;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  border-left: 3px solid transparent;
  position: relative;
}

.af-faq-nav-link:hover {
  color: var(--color-primary);
  background: var(--color-bg-secondary);
  padding-left: calc(0.85rem + 4px);
  border-left-color: var(--color-primary);
}

.af-faq-nav-link.active {
  color: white;
  background: var(--color-primary);
  border-left-color: white;
  padding-left: calc(0.85rem + 4px);
}

.af-faq-nav-icon {
  flex-shrink: 0;
  width: 18px;
  height: 18px;
  opacity: 0.8;
}

.af-faq-nav-link.active .af-faq-nav-icon {
  opacity: 1;
}

@media (max-width: 768px) {
  .af-faq-sidebar {
    position: static;
  }

  .af-faq-nav-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0;
  }

  .af-faq-nav-link {
    flex-direction: column;
    text-align: center;
    padding: 1rem 0.75rem;
    gap: 0.5rem;
    font-size: 0.85rem;
  }
}
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
  background: linear-gradient(135deg, #7dbe52 0%, #5a9537 100%);
  color: white;
  padding: 2.5rem 0;
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
  margin: 0 0 0.5rem 0;
}

.af-faq-hero p {
  font-size: 1.1rem;
  opacity: 0.95;
  line-height: 1.6;
  margin: 0;
}

@media (max-width: 768px) {
  .af-faq-hero {
    padding: var(--space-4) 0;
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
  padding: 2rem 0;
}

.af-faq-layout {
  display: grid;
  grid-template-columns: 250px 1fr;
  gap: var(--space-6);
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

/* ===== Main Content Area ===== */
.af-faq-main {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

/* ===== Sections ===== */
.af-faq-section {
  margin-bottom: 1rem;
}

.af-faq-section:last-of-type {
  margin-bottom: 1rem;
}

.af-faq-section-title {
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: var(--color-text-primary);
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid var(--color-border);
}

.af-faq-section-icon {
  color: var(--color-primary);
  flex-shrink: 0;
  width: 22px;
  height: 22px;
}

/* ===== FAQ Lists ===== */
.af-faq-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.af-faq-item {
  background: white;
  border: 1px solid var(--color-border);
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.af-faq-item:hover {
  border-color: var(--color-primary);
  box-shadow: 0 3px 10px rgba(0,0,0,0.06);
}

.af-faq-question {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding: 1rem;
  cursor: pointer;
  user-select: none;
  font-weight: 600;
  color: var(--color-text-primary);
  background: white;
  transition: all 0.2s ease;
  font-size: 0.95rem;
  line-height: 1.3;
}

.af-faq-question:hover {
  background: var(--color-bg-secondary);
  color: var(--color-primary);
}

.af-faq-question span {
  text-align: left;
}

.af-faq-icon {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
  transition: transform 0.3s ease;
  color: var(--color-primary);
  stroke-width: 2.5;
}

.af-faq-item[open] .af-faq-question {
  background: var(--color-bg-secondary);
  color: var(--color-primary);
  border-bottom: 1px solid var(--color-border);
}

.af-faq-item[open] .af-faq-icon {
  transform: rotate(180deg);
}

.af-faq-answer {
  padding: 0 1rem 1rem 1rem;
  color: var(--color-text-secondary);
  line-height: 1.6;
  font-size: 0.93rem;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-0.5rem);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.af-faq-answer p {
  margin: 0;
}

.af-faq-answer p + p {
  margin-top: 0.75rem;
}

.af-faq-answer a {
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 600;
  transition: opacity 0.2s;
}

.af-faq-answer a:hover {
  opacity: 0.8;
  text-decoration: underline;
}

/* ===== CTA Section ===== */
.af-faq-cta {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  border-radius: 14px;
  padding: 2rem 1.75rem;
  text-align: center;
  margin-top: 1.5rem;
  position: relative;
  overflow: hidden;
}

.af-faq-cta::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.af-faq-cta-content {
  position: relative;
  z-index: 1;
}

.af-faq-cta h2 {
  font-size: 1.6rem;
  font-weight: 800;
  margin-bottom: 0.4rem;
  letter-spacing: -0.01em;
}

.af-faq-cta p {
  font-size: 1rem;
  opacity: 0.95;
  margin-bottom: 1.2rem;
  line-height: 1.5;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
  .af-faq-layout {
    grid-template-columns: 1fr;
  }

  .af-faq-sidebar {
    margin-bottom: 1.5rem;
  }

  .af-faq-nav-list {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
  }

  .af-faq-nav-link {
    flex-direction: column;
    text-align: center;
    gap: 0.4rem;
    padding: 0.75rem 0.6rem;
    border-left: none;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.8rem;
  }

  .af-faq-nav-link:hover,
  .af-faq-nav-link.active {
    border-left: none;
    border-bottom: 2px solid var(--color-primary);
    padding-left: 0.6rem;
  }

  .af-faq-section-title {
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
    gap: 0.6rem;
  }

  .af-faq-section-icon {
    width: 20px;
    height: 20px;
  }

  .af-faq-question {
    padding: 0.85rem;
    font-size: 0.9rem;
  }

  .af-faq-answer {
    padding: 0 0.85rem 0.85rem 0.85rem;
    font-size: 0.9rem;
  }

  .af-faq-cta {
    padding: 1.5rem 1.25rem;
  }

  .af-faq-cta h2 {
    font-size: 1.3rem;
  }

  .af-faq-cta p {
    font-size: 0.95rem;
  }
}

@media (max-width: 480px) {
  .af-faq-hero h1 {
    font-size: 1.5rem;
  }

  .af-faq-hero p {
    font-size: 0.9rem;
  }

  .af-faq-section-title {
    font-size: 1.1rem;
  }

  .af-faq-nav-list {
    grid-template-columns: 1fr;
  }

  .af-faq-question {
    padding: 0.75rem;
    font-size: 0.85rem;
  }
}
</style>

<script>
// Navigation active state
document.querySelectorAll('.af-faq-nav-link').forEach(link => {
  link.addEventListener('click', function() {
    document.querySelectorAll('.af-faq-nav-link').forEach(l => l.classList.remove('active'));
    this.classList.add('active');
  });
});

// Intersection observer for nav highlighting
const sections = document.querySelectorAll('.af-faq-section');
const navLinks = document.querySelectorAll('.af-faq-nav-link');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + entry.target.id) {
          link.classList.add('active');
        }
      });
    }
  });
}, { threshold: 0.3 });

sections.forEach(section => observer.observe(section));

// Accordion behavior - close other items when one opens
document.querySelectorAll('.af-faq-item').forEach(item => {
  item.addEventListener('toggle', function() {
    if (this.open) {
      document.querySelectorAll('.af-faq-item').forEach(other => {
        if (other !== this && other.open) {
          other.open = false;
        }
      });
    }
  });
});

// Smooth scroll behavior
document.querySelectorAll('.af-faq-nav-link').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
</script>

<?php get_footer();
