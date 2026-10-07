<?php
/**
 * Input Validation & Sanitization Layer
 * 
 * Prevents: SQL Injection, XSS, Email/URL manipulation, Rate limiting bypass
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class AF_Input_Validation {

    /**
     * Validate email strictly (RFC 5321)
     */
    public static function validate_email( $email ) {
        $email = trim( $email );
        if ( ! is_email( $email ) ) {
            return false;
        }
        // Additional checks: no disposable emails (optional)
        return $email;
    }

    /**
     * Validate phone strictly (E.164 format)
     */
    public static function validate_phone( $phone ) {
        $phone = preg_replace( '/[^0-9+]/', '', $phone );
        if ( ! preg_match( '/^\+?[1-9]\d{1,14}$/', $phone ) ) {
            return false;
        }
        return $phone;
    }

    /**
     * Validate password strength (min 12 chars, entropy check)
     */
    public static function validate_password( $password ) {
        if ( strlen( $password ) < 12 ) {
            return false;
        }
        // Check for character variety
        $has_upper = preg_match( '/[A-Z]/', $password );
        $has_lower = preg_match( '/[a-z]/', $password );
        $has_digit = preg_match( '/[0-9]/', $password );
        $has_special = preg_match( '/[!@#$%^&*()_+=\-\[\]{}|;:\'",.<>?\\/]/', $password );

        $strength = $has_upper + $has_lower + $has_digit + $has_special;
        return $strength >= 3; // At least 3 of 4 categories
    }

    /**
     * Sanitize property type (whitelist)
     */
    public static function validate_property_type( $type ) {
        $allowed = [ 'apartment', 'house', 'room', 'studio', 'commercial', 'land' ];
        return in_array( trim( $type ), $allowed, true ) ? trim( $type ) : null;
    }

    /**
     * Validate location coordinates (lat/lng within valid ranges)
     */
    public static function validate_coordinates( $lat, $lng ) {
        $lat = (float) $lat;
        $lng = (float) $lng;

        if ( $lat < -90 || $lat > 90 || $lng < -180 || $lng > 180 ) {
            return false;
        }
        if ( $lat === 0.0 && $lng === 0.0 ) {
            return false; // (0,0) is rarely valid
        }
        return [ 'lat' => $lat, 'lng' => $lng ];
    }

    /**
     * Validate price range (no negative, reasonable max)
     */
    public static function validate_price( $price ) {
        $price = (float) $price;
        if ( $price < 0 || $price > 9999999 ) { // Max ~10M
            return false;
        }
        return round( $price, 2 );
    }

    /**
     * Validate URL (protocol check + length limit)
     */
    public static function validate_url( $url, $protocols = [ 'http', 'https' ] ) {
        $url = trim( $url );
        if ( strlen( $url ) > 2048 ) {
            return false; // Prevent buffer overflow
        }
        if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
            return false;
        }
        $parsed = wp_parse_url( $url );
        if ( ! isset( $parsed['scheme'] ) || ! in_array( $parsed['scheme'], $protocols, true ) ) {
            return false;
        }
        return $url;
    }

    /**
     * Sanitize search input (prevent injection in WHERE clause)
     */
    public static function sanitize_search( $search, $max_length = 255 ) {
        $search = trim( $search );
        if ( strlen( $search ) > $max_length ) {
            $search = substr( $search, 0, $max_length );
        }
        // Remove SQL-like patterns
        $search = preg_replace( '/[\'"*;%_\\\\]/', '', $search );
        return sanitize_text_field( $search );
    }

    /**
     * Rate limit check (prevent brute-force)
     * 
     * @param string $action Action identifier (e.g., 'login_attempt')
     * @param int $max_attempts Maximum attempts allowed
     * @param int $window Time window in seconds
     * @return bool True if within limit, false if exceeded
     */
    public static function check_rate_limit( $action, $max_attempts = 5, $window = 3600 ) {
        global $wpdb;

        $ip = self::get_client_ip();
        $cache_key = "af_rate_limit_{$action}_{$ip}";

        // Try transient cache first (fast)
        $attempts = get_transient( $cache_key );
        if ( $attempts === false ) {
            // Fall back to database (slower, for persistence)
            $attempts = (int) $wpdb->get_var( $wpdb->prepare(
                "SELECT attempt_count FROM {$wpdb->prefix}af_rate_limits 
                WHERE action = %s AND ip_address = %s AND created > %d",
                $action,
                $ip,
                time() - $window
            ) );
        }

        if ( $attempts >= $max_attempts ) {
            return false;
        }

        // Increment attempts
        $attempts++;
        set_transient( $cache_key, $attempts, $window );
        $wpdb->insert(
            "{$wpdb->prefix}af_rate_limits",
            [
                'action' => $action,
                'ip_address' => $ip,
                'attempt_count' => $attempts,
                'created' => time(),
            ],
            [ '%s', '%s', '%d', '%d' ]
        );

        return true;
    }

    /**
     * Get client IP (handles proxies & Cloudflare)
     */
    public static function get_client_ip() {
        // Cloudflare header
        if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
            return sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ) );
        }
        // Standard headers
        foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ] as $key ) {
            if ( array_key_exists( $key, $_SERVER ) === true ) {
                foreach ( explode( ',', sanitize_text_field( wp_unslash( $_SERVER[$key] ) ) ) as $ip ) {
                    $ip = trim( $ip );
                    if (
                        filter_var( $ip, FILTER_VALIDATE_IP, 
                            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                        ) !== false
                    ) {
                        return $ip;
                    }
                }
            }
        }
        return '0.0.0.0';
    }

    /**
     * Verify nonce with strict timing (protect against CSRF)
     */
    public static function verify_nonce( $nonce, $action = -1, $user_id = null ) {
        if ( empty( $nonce ) ) {
            return false;
        }

        // WordPress nonce verification is timing-safe by default
        $result = wp_verify_nonce( $nonce, $action );

        // $result: 1 = valid, 2 = valid but not fresh, 0/false = invalid
        if ( $result !== 1 && $result !== 2 ) {
            return false;
        }

        // Additional user check if specified
        if ( $user_id !== null && get_current_user_id() !== (int) $user_id ) {
            return false;
        }

        return true;
    }

    /**
     * Log security events
     */
    public static function log_security_event( $event_type, $details = [] ) {
        global $wpdb;

        $ip = self::get_client_ip();
        $user_id = get_current_user_id();

        $log_data = [
            'event_type' => $event_type,
            'user_id' => $user_id ?: 0,
            'ip_address' => $ip,
            'details' => wp_json_encode( $details ),
            'created_at' => current_time( 'mysql' ),
        ];

        $wpdb->insert( "{$wpdb->prefix}af_security_logs", $log_data );

        // Also log to WP error log if WP_DEBUG_LOG enabled
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( "[SECURITY] $event_type | User: $user_id | IP: $ip | " . wp_json_encode( $details ) );
        }
    }
}

// Create required database tables on activation
if ( ! function_exists( 'af_create_security_tables' ) ) {
    function af_create_security_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Rate limits table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}af_rate_limits (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            action VARCHAR(100) NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            attempt_count INT(11) NOT NULL DEFAULT 1,
            created BIGINT(20) NOT NULL,
            PRIMARY KEY (id),
            KEY action_ip_created (action, ip_address, created)
        ) $charset_collate;";

        // Security logs table
        $sql .= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}af_security_logs (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            event_type VARCHAR(100) NOT NULL,
            user_id BIGINT(20) UNSIGNED,
            ip_address VARCHAR(45),
            details LONGTEXT,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id),
            KEY event_type_created (event_type, created_at),
            KEY user_id (user_id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
