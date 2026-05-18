<?php if ( ! defined('ABSPATH') ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> data-theme="light" style="color-scheme: light only;">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light only">
  <meta name="supported-color-schemes" content="light only">
  <meta name="darkreader-lock">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon.svg" />
  <link rel="shortcut icon" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/apple-touch-icon.png" />
  <link rel="manifest" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/favicon/site.webmanifest" />

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="skip-to-content">
  <?php esc_html_e('Ir al contenido principal', 'twentytwentyfive-child'); ?>
</a>

<header class="site-header" role="banner" id="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/images/arriendo-facil-logo-web-sq.png" alt="" width="60px">
      <span><?php bloginfo('name'); ?></span>
    </a>

    <div class="search-bar-wrapper">
      <input
        type="text"
        id="search-bar-input"
        class="search-bar-input"
        placeholder="<?php esc_attr_e('Search by location...', 'twentytwentyfive-child'); ?>"
        autocomplete="off" />
      <ul id="search-suggestions" class="search-suggestions"></ul>
      <button id="search-bar-btn" class="search-bar-btn" aria-label="<?php esc_attr_e('Search', 'twentytwentyfive-child'); ?>">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </button>
      <button id="search-bar-gps" class="search-bar-gps" aria-label="<?php esc_attr_e('Use my location', 'twentytwentyfive-child'); ?>">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="1"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24"/></svg>
      </button>
    </div>

    <button class="nav-toggle" aria-label="<?php esc_attr_e('Menú', 'twentytwentyfive-child'); ?>" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav class="nav" aria-label="<?php esc_attr_e('Navegación principal', 'twentytwentyfive-child'); ?>">
      <?php
        if ( has_nav_menu('primary') ) {
          wp_nav_menu(array(
            'menu_class' => 'main-menu',
            'theme_location' => 'primary',
            'container' => false,
            'depth' => 1,
            'fallback_cb' => false
          ));
        } else {
          // Simplified fallback navigation (4 items: Logo handled separately, + 3 nav items + CTA)
          $nav_links = array(
            array('Cómo funciona', '#como-funciona'),
            array('Contacto', '#contacto'),
          );
          foreach ($nav_links as $link) {
            echo '<a href="' . esc_url($link[1]) . '">' . esc_html($link[0]) . '</a>';
          }
        }
      ?>
      <a class="btn btn--primary" href="<?php echo esc_url(home_url('/propiedades/')); ?>">
        <?php esc_html_e('Buscar propiedades', 'twentytwentyfive-child'); ?>
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </nav>
  </div>
</header>

<script>
// Header scroll effect & mobile nav
(function() {
  const header = document.getElementById('site-header');
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.nav');

  const getDirectMenuLink = (li) => {
    const first = li?.firstElementChild;
    if (first && first.tagName === 'A') return first;
    return li?.querySelector?.('a') || null;
  };

  const closeAllSubmenus = () => {
    nav?.querySelectorAll('.menu-item.is-submenu-open').forEach(li => {
      li.classList.remove('is-submenu-open');
      const link = getDirectMenuLink(li);
      link?.setAttribute('aria-expanded', 'false');
    });
  };

  // Scroll effect
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 50);
  });

  // Mobile nav toggle
  toggle?.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', isOpen);
    toggle.classList.toggle('is-active', isOpen);

    if (!isOpen) {
      closeAllSubmenus();
    }
  });

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    if (nav?.classList.contains('is-open') && !nav.contains(e.target) && !toggle.contains(e.target)) {
      nav.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.classList.remove('is-active');
      closeAllSubmenus();
    }
  });

  // Prevent clicks inside nav from closing
  nav?.addEventListener('click', (e) => {
    e.stopPropagation();
  });

  // Submenu toggle behavior (click-to-open)
  nav?.querySelectorAll('.menu-item-has-children > a').forEach(link => {
    link.setAttribute('aria-haspopup', 'true');
    link.setAttribute('aria-expanded', 'false');

    link.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        link.click();
      }
    });
  });

  // Handle link clicks (delegate)
  nav?.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link || !nav.contains(link)) return;

    const parentLi = link.parentElement;
    const submenu = link.nextElementSibling;
    const isSubmenuToggle = parentLi?.classList?.contains('menu-item-has-children') && submenu?.classList?.contains('sub-menu');

    if (isSubmenuToggle) {
      e.preventDefault();

      const willOpen = !parentLi.classList.contains('is-submenu-open');

      // Close siblings at the same level
      const siblings = parentLi.parentElement ? Array.from(parentLi.parentElement.children) : [];
      siblings.forEach(li => {
        if (li !== parentLi && li.classList?.contains('menu-item') && li.classList.contains('is-submenu-open')) {
          li.classList.remove('is-submenu-open');
          getDirectMenuLink(li)?.setAttribute('aria-expanded', 'false');
        }
      });

      parentLi.classList.toggle('is-submenu-open', willOpen);
      link.setAttribute('aria-expanded', String(willOpen));
      return;
    }

    // Regular link: close mobile menu
    nav.classList.remove('is-open');
    toggle?.setAttribute('aria-expanded', 'false');
    toggle?.classList.remove('is-active');
    closeAllSubmenus();
  });
})();
</script>