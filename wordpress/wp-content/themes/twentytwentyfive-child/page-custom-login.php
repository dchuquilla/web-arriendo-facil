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

// Already logged in: go straight to the panel.
if (is_user_logged_in() && 'login' === $action) {
  wp_safe_redirect(admin_url());
  exit;
}

$redirect_to = isset($_GET['redirect_to']) ? wp_validate_redirect(rawurldecode(wp_unslash($_GET['redirect_to'])), '') : '';

$notice = null;
if (isset($_GET['login']) && 'failed' === $_GET['login']) {
  $notice = array('type' => 'error', 'text' => __('Usuario o contraseña incorrectos. Inténtalo de nuevo.', 'twentytwentyfive-child'));
} elseif (isset($_GET['login']) && 'locked' === $_GET['login']) {
  $notice = array('type' => 'error', 'text' => __('Demasiados intentos fallidos. Espera 15 minutos e inténtalo de nuevo.', 'twentytwentyfive-child'));
} elseif (isset($_GET['loggedout'])) {
  $notice = array('type' => 'success', 'text' => __('Cerraste sesión correctamente.', 'twentytwentyfive-child'));
} elseif (isset($_GET['checkemail']) && 'confirm' === $_GET['checkemail']) {
  $notice = array('type' => 'success', 'text' => __('Revisa tu correo: te enviamos el enlace de recuperación.', 'twentytwentyfive-child'));
}

get_header();

$logo = get_stylesheet_directory_uri() . '/assets/images/arriendo-facil-logo-web-sq.png';
?>

<main id="main-content" class="afl" data-afl>
  <div class="afl__bg" aria-hidden="true">
    <span class="afl__blob afl__blob--1"></span>
    <span class="afl__blob afl__blob--2"></span>
    <span class="afl__blob afl__blob--3"></span>
  </div>

  <div class="afl__shell">
    <section class="afl__card" aria-labelledby="afl-title">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="afl__brand" aria-label="<?php esc_attr_e('Ir al inicio', 'twentytwentyfive-child'); ?>">
        <img src="<?php echo esc_url($logo); ?>" alt="" width="44" height="44" decoding="async" />
        <span>Arriendo<em>Fácil</em></span>
      </a>

      <?php if ($notice): ?>
        <div class="afl__notice afl__notice--<?php echo esc_attr($notice['type']); ?>" role="<?php echo 'error' === $notice['type'] ? 'alert' : 'status'; ?>">
          <?php echo esc_html($notice['text']); ?>
        </div>
      <?php endif; ?>

      <?php if ('lostpassword' === $action): ?>
        <h1 id="afl-title" class="afl__title"><?php esc_html_e('Recupera tu contraseña', 'twentytwentyfive-child'); ?></h1>
        <p class="afl__subtitle"><?php esc_html_e('Te enviaremos un enlace para crear una nueva.', 'twentytwentyfive-child'); ?></p>

        <form class="afl__form" method="post" action="<?php echo esc_url(network_site_url('wp-login.php?action=lostpassword', 'login_post')); ?>" novalidate data-afl-form>
          <div class="afl__field">
            <input type="text" name="user_login" id="user_login" class="afl__input" placeholder=" " autocomplete="username" required maxlength="100" />
            <label for="user_login" class="afl__label"><?php esc_html_e('Usuario o correo electrónico', 'twentytwentyfive-child'); ?></label>
            <p class="afl__error" data-error aria-live="polite"></p>
          </div>

          <button type="submit" name="wp-submit" class="afl__btn" data-submit>
            <span class="afl__btn-text"><?php esc_html_e('Enviar enlace', 'twentytwentyfive-child'); ?></span>
            <span class="afl__spinner" aria-hidden="true"></span>
          </button>
        </form>

        <p class="afl__alt">
          <a href="<?php echo esc_url(af_custom_login_base_url()); ?>" class="afl__link">← <?php esc_html_e('Volver a iniciar sesión', 'twentytwentyfive-child'); ?></a>
        </p>

      <?php else: ?>
        <h1 id="afl-title" class="afl__title"><?php esc_html_e('Bienvenido de vuelta', 'twentytwentyfive-child'); ?></h1>
        <p class="afl__subtitle"><?php esc_html_e('Accede a tu panel y gestiona tus propiedades.', 'twentytwentyfive-child'); ?></p>

        <form class="afl__form" id="loginform" name="loginform" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" novalidate data-afl-form>
          <div class="afl__field">
            <input type="text" name="log" id="user_login" class="afl__input" placeholder=" " autocomplete="username" autocapitalize="off" spellcheck="false" required maxlength="100" />
            <label for="user_login" class="afl__label"><?php esc_html_e('Usuario o correo electrónico', 'twentytwentyfive-child'); ?></label>
            <p class="afl__error" data-error aria-live="polite"></p>
          </div>

          <div class="afl__field">
            <input type="password" name="pwd" id="user_pass" class="afl__input afl__input--pass" placeholder=" " autocomplete="current-password" required maxlength="255" />
            <label for="user_pass" class="afl__label"><?php esc_html_e('Contraseña', 'twentytwentyfive-child'); ?></label>
            <button type="button" class="afl__eye" data-toggle-pass aria-label="<?php esc_attr_e('Mostrar contraseña', 'twentytwentyfive-child'); ?>" aria-pressed="false">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/><path class="afl__eye-slash" d="M3 3l18 18"/></svg>
            </button>
            <p class="afl__caps" data-caps hidden><?php esc_html_e('Bloq Mayús está activado', 'twentytwentyfive-child'); ?></p>
            <p class="afl__error" data-error aria-live="polite"></p>
          </div>

          <div class="afl__row">
            <label class="afl__check">
              <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
              <span class="afl__box" aria-hidden="true"></span>
              <?php esc_html_e('Recuérdame', 'twentytwentyfive-child'); ?>
            </label>
            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="afl__link"><?php esc_html_e('¿Olvidaste tu contraseña?', 'twentytwentyfive-child'); ?></a>
          </div>

          <input type="hidden" name="af_custom_login" value="1" />
          <?php if ('' !== $redirect_to): ?>
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
          <?php endif; ?>

          <button type="submit" name="wp-submit" id="wp-submit" class="afl__btn" data-submit>
            <span class="afl__btn-text"><?php esc_html_e('Iniciar sesión', 'twentytwentyfive-child'); ?></span>
            <span class="afl__spinner" aria-hidden="true"></span>
          </button>
        </form>

        <p class="afl__alt">
          <?php esc_html_e('¿Aún no tienes cuenta?', 'twentytwentyfive-child'); ?>
          <a href="<?php echo esc_url(af_signup_url()); ?>" class="afl__link afl__link--strong"><?php esc_html_e('Crear mi cuenta', 'twentytwentyfive-child'); ?></a>
        </p>
      <?php endif; ?>
    </section>

    <aside class="afl__panel" aria-label="<?php esc_attr_e('Beneficios de Arriendo Fácil', 'twentytwentyfive-child'); ?>" data-tilt>
      <div class="afl__panel-inner">
        <span class="afl__pill"><?php esc_html_e('Gestión de arriendos', 'twentytwentyfive-child'); ?></span>
        <h2><?php esc_html_e('Tus propiedades, en un solo lugar', 'twentytwentyfive-child'); ?></h2>

        <ul class="afl__features" data-features>
          <li class="is-active">
            <span class="afl__ico" aria-hidden="true">🏠</span>
            <div><strong><?php esc_html_e('Panel centralizado', 'twentytwentyfive-child'); ?></strong><small><?php esc_html_e('Todas tus propiedades y contratos al día', 'twentytwentyfive-child'); ?></small></div>
          </li>
          <li>
            <span class="afl__ico" aria-hidden="true">🧾</span>
            <div><strong><?php esc_html_e('Facturación SRI', 'twentytwentyfive-child'); ?></strong><small><?php esc_html_e('Comprobantes digitales autorizados', 'twentytwentyfive-child'); ?></small></div>
          </li>
          <li>
            <span class="afl__ico" aria-hidden="true">📊</span>
            <div><strong><?php esc_html_e('Liquidaciones mensuales', 'twentytwentyfive-child'); ?></strong><small><?php esc_html_e('Transparencia total en tus ingresos', 'twentytwentyfive-child'); ?></small></div>
          </li>
          <li>
            <span class="afl__ico" aria-hidden="true">🛠️</span>
            <div><strong><?php esc_html_e('Mantenimiento integrado', 'twentytwentyfive-child'); ?></strong><small><?php esc_html_e('Gestiona reparaciones sin complicaciones', 'twentytwentyfive-child'); ?></small></div>
          </li>
        </ul>

        <a class="afl__help" href="mailto:arriendofacilnet@gmail.com">
          <?php esc_html_e('¿Necesitas ayuda?', 'twentytwentyfive-child'); ?> <span>arriendofacilnet@gmail.com</span>
        </a>
      </div>
    </aside>
  </div>
</main>

<?php get_footer();
