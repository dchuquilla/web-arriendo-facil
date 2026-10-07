<?php
/**
 * REST API Security & Rate Limiting
 * 
 * Protects against: Brute-force attacks, parameter tampering, DDoS
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class AF_REST_API_Security {

    /**
     * Register rate limiting callback
     */
    public static function init() {
        add_action( 'rest_api_init', [ __CLASS__, 'add_rate_limiting' ], 1 );
        add_filter( 'rest_authentication_errors', [ __CLASS__, 'check_rate_limit_before_auth' ] );
    }

    /**
     * Check rate limits before authentication runs
     */
    public static function check_rate_limit_before_auth( $errors ) {
        $rate_limit = defined( 'AF_REST_RATE_LIMIT' ) ? AF_REST_RATE_LIMIT : 120;
        
        // Allow 10 requests per minute per IP for unauthenticated users
        if ( ! is_user_logged_in() ) {
            $rate_limit = 10;
        }

        if ( ! AF_Input_Validation::check_rate_limit( 'rest_api', $rate_limit, 60 ) ) {
            return new WP_Error(
                'rest_rate_limit_exceeded',
                __( 'Too many requests. Please try again later.', 'twentytwentyfive-child' ),
                [ 'status' => 429 ]
            );
        }

        return $errors;
    }

    /**
     * Add rate limiting to specific endpoints
     */
    public static function add_rate_limiting() {
        // Add callback to all /af/v1/ endpoints
        add_filter( 'rest_pre_dispatch', [ __CLASS__, 'pre_dispatch_check' ], 1, 3 );
    }

    /**
     * Pre-dispatch security checks
     */
    public static function pre_dispatch_check( $result, $server, $request ) {
        $route = $request->get_route();

        // Check if it's an AF endpoint
        if ( strpos( $route, '/af/v1/' ) !== 0 ) {
            return $result;
        }

        // Verify request method safety
        $method = $request->get_method();
        if ( ! in_array( $method, [ 'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS' ], true ) ) {
            return new WP_Error(
                'rest_method_not_allowed',
                __( 'Method not allowed', 'twentytwentyfive-child' ),
                [ 'status' => 405 ]
            );
        }

        // POST/PUT endpoints require nonce (unless public endpoint)
        $public_endpoints = [
            '/af/v1/accommodations',
            '/af/v1/places/suggestions',
            '/af/v1/password-reset',
            '/af/v1/owner-register',
        ];

        if ( in_array( $method, [ 'POST', 'PUT', 'DELETE' ], true ) ) {
            $is_public = false;
            foreach ( $public_endpoints as $ep ) {
                if ( strpos( $route, $ep ) === 0 ) {
                    $is_public = true;
                    break;
                }
            }

            if ( ! $is_public && ! is_user_logged_in() ) {
                $nonce = $request->get_header( 'X-WP-Nonce' ) ?: $request->get_param( '_nonce' );
                if ( ! $nonce || ! AF_Input_Validation::verify_nonce( $nonce, 'wp_rest' ) ) {
                    return new WP_Error(
                        'rest_nonce_failure',
                        __( 'Nonce verification failed', 'twentytwentyfive-child' ),
                        [ 'status' => 403 ]
                    );
                }
            }
        }

        // Log suspicious requests
        if ( defined( 'AF_LOG_SECURITY_EVENTS' ) && AF_LOG_SECURITY_EVENTS ) {
            $params = $request->get_json_params();
            if ( isset( $params['password'] ) ) {
                unset( $params['password'] ); // Never log passwords
            }
            
            AF_Input_Validation::log_security_event( 'REST_API_REQUEST', [
                'route' => $route,
                'method' => $method,
                'user_id' => get_current_user_id(),
                'ip' => AF_Input_Validation::get_client_ip(),
            ] );
        }

        return $result;
    }

    /**
     * Register a secure REST endpoint with automatic validation
     */
    public static function register_secure_endpoint( $namespace, $route, $args = [] ) {
        $default_args = [
            'permission_callback' => [ __CLASS__, 'check_permission' ],
        ];

        $args = wp_parse_args( $args, $default_args );

        return register_rest_route( $namespace, $route, $args );
    }

    /**
     * Default permission check
     */
    public static function check_permission( $request ) {
        // Override per endpoint by passing custom permission_callback
        return true;
    }

    /**
     * Wrapper for POST handlers (includes rate limiting + validation)
     */
    public static function handle_post( $handler, $rate_limit_action, $rate_limit_max = 5, $rate_limit_window = 3600 ) {
        return function( WP_REST_Request $request ) use ( $handler, $rate_limit_action, $rate_limit_max, $rate_limit_window ) {
            // Rate limit check
            if ( ! AF_Input_Validation::check_rate_limit( $rate_limit_action, $rate_limit_max, $rate_limit_window ) ) {
                return new WP_REST_Response( 
                    [ 'error' => 'Demasiados intentos. Intenta de nuevo más tarde.' ], 
                    429 
                );
            }

            // Call the actual handler
            return call_user_func( $handler, $request );
        };
    }
}

// Initialize
if ( defined( 'ABSPATH' ) && defined( 'AF_SECURITY_HEADERS_ENABLED' ) && AF_SECURITY_HEADERS_ENABLED ) {
    AF_REST_API_Security::init();
}
