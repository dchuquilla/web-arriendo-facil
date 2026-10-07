<?php
/**
 * Security Headers & Protection Layer
 * 
 * Prevents: XSS, Clickjacking, Unauthorized frame embedding, MIME sniffing
 * Enforces: HSTS, CSP, CORS restrictions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class AF_Security_Headers {

    public static function init() {
        if ( ! defined( 'AF_SECURITY_HEADERS_ENABLED' ) || ! AF_SECURITY_HEADERS_ENABLED ) {
            return;
        }

        add_action( 'send_headers', [ __CLASS__, 'add_security_headers' ], 1 );
        add_action( 'init', [ __CLASS__, 'disable_xmlrpc' ] );
        add_filter( 'wp_headers', [ __CLASS__, 'filter_headers' ] );
    }

    /**
     * Send security headers before any output
     */
    public static function add_security_headers() {
        // HSTS (30 days minimum for compliance)
        header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload', true );

        // XSS Protection (legacy browsers, CSP primary defense)
        header( 'X-Content-Type-Options: nosniff', true );
        header( 'X-Frame-Options: SAMEORIGIN', true );
        header( 'X-XSS-Protection: 1; mode=block', true );

        // Content Security Policy (restrictive, allows inline for wp-admin only)
        $csp = self::build_csp();
        if ( $csp ) {
            header( 'Content-Security-Policy: ' . $csp, true );
        }

        // Referrer Policy (leak minimal data to external sites)
        header( 'Referrer-Policy: strict-origin-when-cross-origin', true );

        // Permissions Policy (disable dangerous features)
        header( 'Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()', true );

        // CORS (prevent unauthorized cross-origin requests)
        header( 'Access-Control-Allow-Origin: ' . esc_attr( get_home_url() ), true );
        header( 'Access-Control-Allow-Credentials: true', true );
        header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS', true );
    }

    /**
     * Build Content-Security-Policy header
     */
    private static function build_csp() {
        $home = esc_attr( get_home_url() );
        $domain = wp_parse_url( $home, PHP_URL_HOST );

        $directives = [
            // Default fallback
            "default-src 'self'",

            // Scripts: self + CDN (adjust CDNs as needed)
            "script-src 'self' 'unsafe-inline' cdnjs.cloudflare.com cdn.jsdelivr.net charts.google.com $domain",

            // Styles: self + inline (needed for WordPress)
            "style-src 'self' 'unsafe-inline' fonts.googleapis.com cdnjs.cloudflare.com $domain",

            // Images: self + data URIs + external (accommodations load from CDN)
            "img-src 'self' data: https: $domain",

            // Fonts: self + Google Fonts
            "font-src 'self' fonts.gstatic.com data:",

            // AJAX/Fetch: self only
            "connect-src 'self' $domain",

            // Frames: none (prevents embedding this site in iframes)
            "frame-ancestors 'none'",

            // Forms: self only
            "form-action 'self'",

            // No plugins (Flash, Java, etc.)
            "object-src 'none'",

            // Report CSP violations (optional: send to logging service)
            // "report-uri /wp-json/af/v1/csp-report",

            // Upgrade insecure requests to HTTPS
            "upgrade-insecure-requests",

            // Block insecure features
            "block-all-mixed-content",
        ];

        /**
         * Allow plugins to add custom CSP directives
         * 
         * @param array $directives Current CSP directives
         * @return array Modified directives
         */
        $directives = apply_filters( 'af_csp_directives', $directives );

        return implode( '; ', array_filter( $directives ) );
    }

    /**
     * Disable XML-RPC (DDoS & brute-force attack vector)
     */
    public static function disable_xmlrpc() {
        add_filter( 'xmlrpc_enabled', '__return_false' );
    }

    /**
     * Filter WordPress headers to add/modify
     */
    public static function filter_headers( $headers ) {
        // Remove WordPress version fingerprinting
        unset( $headers['X-Powered-By'] );

        // Add custom security header
        $headers['X-Arriendo-Facil-Version'] = 'Production';
        $headers['Server'] = 'Protected';

        return $headers;
    }

    /**
     * Disable REST API for non-authenticated users (optional hardening)
     */
    public static function restrict_rest_api( $access ) {
        if ( ! is_user_logged_in() && ! self::is_allowed_rest_endpoint() ) {
            return new WP_Error(
                'rest_authentication_required',
                __( 'REST API requires authentication', 'twentytwentyfive-child' ),
                [ 'status' => 403 ]
            );
        }
        return $access;
    }

    /**
     * Check if current request is an allowed public REST endpoint
     */
    private static function is_allowed_rest_endpoint() {
        $allowed_endpoints = [
            '/af/v1/accommodations',
            '/af/v1/places/suggestions',
            '/af/v1/owner-register',
            '/af/v1/password-reset',
        ];

        $request_path = $_SERVER['REQUEST_URI'] ?? '';
        foreach ( $allowed_endpoints as $endpoint ) {
            if ( strpos( $request_path, $endpoint ) !== false ) {
                return true;
            }
        }
        return false;
    }
}

// Initialize
if ( defined( 'ABSPATH' ) ) {
    AF_Security_Headers::init();
}
