<?php
/**
 * Deploy refresh: makes a theme uploaded as ZIP take effect immediately.
 *
 * - Invalidates OPcache for every theme file when the theme is installed/updated.
 * - Fallback: detects changed theme files (by mtime) on any request and invalidates them.
 * - Bumps the Cache-Control used for HTML so CDNs/browsers don't keep old markup for long.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function af_theme_invalidate_opcache() {
  if ( ! function_exists( 'opcache_invalidate' ) ) {
    return;
  }

  $dir = get_stylesheet_directory();
  if ( ! is_dir( $dir ) ) {
    return;
  }

  $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ) );
  foreach ( $files as $file ) {
    if ( $file->isFile() && 'php' === strtolower( $file->getExtension() ) ) {
      @opcache_invalidate( $file->getPathname(), true );
    }
  }
}

// Theme installed / updated from the admin (ZIP upload).
add_action( 'upgrader_process_complete', function ( $upgrader, $options ) {
  if ( isset( $options['type'] ) && 'theme' === $options['type'] ) {
    af_theme_invalidate_opcache();
    delete_option( 'af_theme_deploy_signature' );
  }
}, 10, 2 );

// Fallback for deploys that bypass the upgrader (FTP, Git, file manager).
add_action( 'init', function () {
  $dir   = get_stylesheet_directory();
  $files = array( 'functions.php', 'header.php', 'footer.php', 'style.css', 'style.min.css', 'page-custom-login.php' );
  $sig   = '';
  foreach ( $files as $name ) {
    $sig .= (int) @filemtime( $dir . '/' . $name ) . ':';
  }
  $sig = md5( $sig . AF_THEME_VERSION );

  if ( get_option( 'af_theme_deploy_signature' ) !== $sig ) {
    af_theme_invalidate_opcache();
    update_option( 'af_theme_deploy_signature', $sig, true );
  }
}, 1 );
