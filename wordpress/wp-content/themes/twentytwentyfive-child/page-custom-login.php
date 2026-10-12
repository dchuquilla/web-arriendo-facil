<?php
/**
 * Template: Custom Login / Password Recovery
 * 
 * Personaliza el formulario de login y recuperación de contraseña
 * con diseño moderno y responsivo.
 */
if ( ! defined('ABSPATH') ) { exit; }

// Determine which form to show
$action = isset($_GET['action']) ? sanitize_key($_GET['action']) : 'login';
$allowed_actions = array('login', 'lostpassword', 'resetpass');

if (!in_array($action, $allowed_actions, true)) {
  $action = 'login';
}

get_header();
?>

<main id="main-content" class="af-login-page">
  <div class="af-login-container">
    <div class="af-login-box">
      <!-- Logo -->
      <div class="af-login-header">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="af-login-logo">
          <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/arriendo-facil-logo-web-sq.png" alt="<?php bloginfo('name'); ?>" width="48" height="48" />
          <span><?php bloginfo('name'); ?></span>
        </a>
      </div>

      <?php if ('login' === $action): ?>
        <!-- Login Form -->
        <div class="af-login-form-wrapper">
          <h1 class="af-login-title"><?php esc_html_e('Inicia sesión', 'twentytwentyfive-child'); ?></h1>
          <p class="af-login-subtitle"><?php esc_html_e('Accede a tu panel de control', 'twentytwentyfive-child'); ?></p>

          <form name="loginform" id="loginform" method="post" action="<?php echo esc_url(wp_login_url()); ?>" novalidate="novalidate">
            <div class="af-form-group">
              <label for="user_login" class="af-form-label">
                <?php esc_html_e('Usuario o correo electrónico', 'twentytwentyfive-child'); ?>
              </label>
              <input type="text" name="log" id="user_login" class="af-form-input" value="" size="20" autocapitalize="off" spellcheck="false" />
            </div>

            <div class="af-form-group">
              <label for="user_pass" class="af-form-label">
                <?php esc_html_e('Contraseña', 'twentytwentyfive-child'); ?>
              </label>
              <input type="password" name="pwd" id="user_pass" class="af-form-input" value="" size="20" />
            </div>

            <div class="af-form-group af-form-group--checkbox">
              <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
              <label for="rememberme" class="af-form-checkbox-label">
                <?php esc_html_e('Recuérdame', 'twentytwentyfive-child'); ?>
              </label>
            </div>

            <button type="submit" name="wp-submit" id="wp-submit" class="btn btn--primary btn--block">
              <?php esc_html_e('Inicia sesión', 'twentytwentyfive-child'); ?>
            </button>

            <?php wp_nonce_field('log-in'); ?>
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr(home_url('/dashboard/')); ?>" />
          </form>

          <div class="af-login-footer">
            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="af-login-link">
              <?php esc_html_e('¿Olvidaste tu contraseña?', 'twentytwentyfive-child'); ?>
            </a>
            <span class="af-login-divider">•</span>
            <a href="<?php echo esc_url(af_signup_url()); ?>" class="af-login-link">
              <?php esc_html_e('Crear cuenta', 'twentytwentyfive-child'); ?>
            </a>
          </div>
        </div>

      <?php elseif ('lostpassword' === $action): ?>
        <!-- Lost Password Form -->
        <div class="af-login-form-wrapper">
          <h1 class="af-login-title"><?php esc_html_e('Recuperar contraseña', 'twentytwentyfive-child'); ?></h1>
          <p class="af-login-subtitle"><?php esc_html_e('Te enviaremos un enlace para establecer una nueva contraseña.', 'twentytwentyfive-child'); ?></p>

          <form method="post" action="<?php echo esc_url(wp_lostpassword_url()); ?>" novalidate="novalidate">
            <div class="af-form-group">
              <label for="user_login" class="af-form-label">
                <?php esc_html_e('Usuario o correo electrónico', 'twentytwentyfive-child'); ?>
              </label>
              <input type="text" name="user_login" id="user_login" class="af-form-input" value="" autocomplete="username" />
              <small class="af-form-help"><?php esc_html_e('Ingresa el correo electrónico asociado a tu cuenta.', 'twentytwentyfive-child'); ?></small>
            </div>

            <button type="submit" name="wp-submit" class="btn btn--primary btn--block">
              <?php esc_html_e('Enviar enlace de recuperación', 'twentytwentyfive-child'); ?>
            </button>

            <?php wp_nonce_field('lostpassword'); ?>
          </form>

          <div class="af-login-footer">
            <a href="<?php echo esc_url(wp_login_url()); ?>" class="af-login-link">
              ← <?php esc_html_e('Volver a iniciar sesión', 'twentytwentyfive-child'); ?>
            </a>
          </div>
        </div>

      <?php endif; ?>
    </div>

    <!-- Right Side: Benefits -->
    <div class="af-login-info">
      <div class="af-login-info-content">
        <h2><?php esc_html_e('Bienvenido a Arriendo Fácil', 'twentytwentyfive-child'); ?></h2>
        <p><?php esc_html_e('Gestiona tus propiedades de forma sencilla y profesional.', 'twentytwentyfive-child'); ?></p>

        <ul class="af-login-benefits">
          <li>
            <span class="af-login-benefit-icon">🏠</span>
            <strong><?php esc_html_e('Panel centralizado', 'twentytwentyfive-child'); ?></strong>
            <small><?php esc_html_e('Todas tus propiedades en un solo lugar', 'twentytwentyfive-child'); ?></small>
          </li>
          <li>
            <span class="af-login-benefit-icon">💰</span>
            <strong><?php esc_html_e('Facturación SRI', 'twentytwentyfive-child'); ?></strong>
            <small><?php esc_html_e('Comprobantes digitales autorizados', 'twentytwentyfive-child'); ?></small>
          </li>
          <li>
            <span class="af-login-benefit-icon">📊</span>
            <strong><?php esc_html_e('Liquidaciones mensuales', 'twentytwentyfive-child'); ?></strong>
            <small><?php esc_html_e('Transparencia total en tus ingresos', 'twentytwentyfive-child'); ?></small>
          </li>
          <li>
            <span class="af-login-benefit-icon">🛠️</span>
            <strong><?php esc_html_e('Mantenimiento integrado', 'twentytwentyfive-child'); ?></strong>
            <small><?php esc_html_e('Gestiona reparaciones sin complicaciones', 'twentytwentyfive-child'); ?></small>
          </li>
        </ul>

        <div class="af-login-contact">
          <p><?php esc_html_e('¿Necesitas ayuda?', 'twentytwentyfive-child'); ?></p>
          <p>
            <a href="mailto:arriendofacilnet@gmail.com">📧 arriendofacilnet@gmail.com</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</main>

<style>
.af-login-page {
  min-height: 100vh;
  background: linear-gradient(135deg, var(--color-bg-secondary) 0%, var(--color-bg-primary) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--space-4);
}

.af-login-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0;
  width: 100%;
  max-width: 1000px;
  background: white;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
  .af-login-container {
    grid-template-columns: 1fr;
  }
}

.af-login-box {
  padding: var(--space-10);
  display: flex;
  flex-direction: column;
}

@media (max-width: 768px) {
  .af-login-box {
    padding: var(--space-8);
  }
}

.af-login-header {
  margin-bottom: var(--space-8);
}

.af-login-logo {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  text-decoration: none;
  color: var(--color-text-primary);
  font-weight: 700;
  font-size: 1.25rem;
}

.af-login-logo img {
  width: 48px;
  height: 48px;
  border-radius: var(--radius-sm);
}

.af-login-title {
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: var(--space-2);
  color: var(--color-text-primary);
}

.af-login-subtitle {
  color: var(--color-text-secondary);
  margin-bottom: var(--space-8);
  font-size: 0.95rem;
}

.af-form-group {
  margin-bottom: var(--space-6);
}

.af-form-group--checkbox {
  display: flex;
  align-items: center;
  gap: var(--space-2);
  margin-bottom: var(--space-6);
}

.af-form-label {
  display: block;
  margin-bottom: var(--space-2);
  font-weight: 600;
  color: var(--color-text-primary);
  font-size: 0.95rem;
}

.af-form-input {
  width: 100%;
  padding: var(--space-3) var(--space-4);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  font-size: 1rem;
  font-family: inherit;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.af-form-input:focus {
  outline: none;
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.1);
}

.af-form-checkbox-label {
  font-weight: normal;
  color: var(--color-text-secondary);
  cursor: pointer;
}

.af-form-help {
  display: block;
  margin-top: var(--space-2);
  color: var(--color-text-secondary);
  font-size: 0.875rem;
}

.btn--block {
  width: 100%;
  margin-bottom: var(--space-6);
}

.af-login-footer {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: var(--space-2);
  text-align: center;
  font-size: 0.9rem;
}

.af-login-link {
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
}

.af-login-link:hover {
  color: var(--color-primary-dark);
  text-decoration: underline;
}

.af-login-divider {
  color: var(--color-text-secondary);
}

/* Right Side Info */
.af-login-info {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: var(--space-10);
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (max-width: 768px) {
  .af-login-info {
    display: none;
  }
}

.af-login-info-content h2 {
  font-size: 2rem;
  margin-bottom: var(--space-3);
  font-weight: 700;
}

.af-login-info-content > p {
  opacity: 0.9;
  margin-bottom: var(--space-8);
  font-size: 1.05rem;
}

.af-login-benefits {
  list-style: none;
  padding: 0;
  margin: 0 0 var(--space-10) 0;
  display: flex;
  flex-direction: column;
  gap: var(--space-6);
}

.af-login-benefits li {
  display: flex;
  gap: var(--space-4);
  align-items: flex-start;
}

.af-login-benefit-icon {
  font-size: 1.5rem;
  flex-shrink: 0;
}

.af-login-benefits strong {
  display: block;
  margin-bottom: var(--space-1);
}

.af-login-benefits small {
  opacity: 0.8;
  font-size: 0.9rem;
}

.af-login-contact {
  background: rgba(255, 255, 255, 0.1);
  padding: var(--space-4);
  border-radius: var(--radius-md);
  text-align: center;
}

.af-login-contact p {
  margin: 0;
  opacity: 0.9;
}

.af-login-contact a {
  color: white;
  text-decoration: none;
  font-weight: 600;
  transition: opacity 0.2s ease;
}

.af-login-contact a:hover {
  opacity: 0.8;
  text-decoration: underline;
}
</style>

<?php get_footer();
