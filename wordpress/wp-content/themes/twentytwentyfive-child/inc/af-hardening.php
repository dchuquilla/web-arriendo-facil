<?php
/**
 * Endurecimiento ligero: evita filtrar nombres de usuario y la versión de PHP.
 * Solo afecta a visitantes sin sesión; el panel y la API del sistema interno no se tocan.
 *
 * @package Arriendo_Facil
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bloquea la enumeración de usuarios por /?author=N y /author/slug/.
 */
add_action(
	'template_redirect',
	static function () {
		if ( is_user_logged_in() ) {
			return;
		}
		if ( isset( $_GET['author'] ) || is_author() ) { // phpcs:ignore WordPress.Security.NonceVerification
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	},
	1
);

/**
 * Oculta los endpoints públicos que listan usuarios (solo para visitantes sin sesión).
 */
add_filter(
	'rest_endpoints',
	static function ( $endpoints ) {
		if ( is_user_logged_in() ) {
			return $endpoints;
		}
		foreach ( array_keys( $endpoints ) as $route ) {
			if ( 0 === strpos( $route, '/wp/v2/users' ) ) {
				unset( $endpoints[ $route ] );
			}
		}
		return $endpoints;
	}
);

/**
 * Quita los usuarios del sitemap de WordPress.
 */
add_filter(
	'wp_sitemaps_add_provider',
	static function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);

/**
 * No anunciar la versión de PHP.
 */
add_action(
	'send_headers',
	static function () {
		header_remove( 'X-Powered-By' );
	},
	99
);
