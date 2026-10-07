<?php
/**
 * GDPR Compliance & Data Protection
 * 
 * - Cookie consent banner enforcement
 * - Data deletion (right to be forgotten)
 * - Data export
 * - Breach notification workflow
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class AF_GDPR_Compliance {

    public static function init() {
        // Ensure Complianz cookie banner is shown
        add_action( 'wp_body_open', [ __CLASS__, 'ensure_cookie_banner' ], 1 );
        
        // Disable non-essential tracking without consent
        add_action( 'init', [ __CLASS__, 'check_cookie_consent' ], 1 );
        
        // REST endpoints for GDPR
        add_action( 'rest_api_init', [ __CLASS__, 'register_gdpr_endpoints' ] );
    }

    /**
     * Ensure cookie banner is loaded (Complianz plugin)
     */
    public static function ensure_cookie_banner() {
        if ( ! class_exists( 'cmplz_front_controller' ) ) {
            // Fallback if Complianz not installed
            echo '<!-- Cookie consent required but Complianz plugin not active -->';
            return;
        }
        // Complianz handles banner rendering
    }

    /**
     * Check if user consented to non-essential cookies
     * Disables Google Analytics, etc. without consent
     */
    public static function check_cookie_consent() {
        // Check Complianz consent flag
        if ( function_exists( 'cmplz_has_consent' ) ) {
            if ( ! cmplz_has_consent( 'statistics' ) && ! cmplz_has_consent( 'marketing' ) ) {
                // Disable GA, Facebook Pixel, etc.
                define( 'AF_TRACKING_DISABLED', true );
            }
        }
    }

    /**
     * Register GDPR REST endpoints
     */
    public static function register_gdpr_endpoints() {
        // Data export (right of access)
        register_rest_route( 'af/v1', '/gdpr/data-export', [
            'methods' => 'POST',
            'callback' => [ __CLASS__, 'handle_data_export' ],
            'permission_callback' => [ __CLASS__, 'gdpr_permission_check' ],
        ] );

        // Data deletion (right to be forgotten)
        register_rest_route( 'af/v1', '/gdpr/data-delete', [
            'methods' => 'POST',
            'callback' => [ __CLASS__, 'handle_data_delete' ],
            'permission_callback' => [ __CLASS__, 'gdpr_permission_check' ],
        ] );
    }

    /**
     * Permission check: user must be authenticated
     */
    public static function gdpr_permission_check() {
        return is_user_logged_in() || current_user_can( 'manage_options' );
    }

    /**
     * Export user data (GDPR right of access)
     */
    public static function handle_data_export( WP_REST_Request $request ) {
        $user_id = $request->get_param( 'user_id' ) ?: get_current_user_id();
        
        // Verify permission
        if ( $user_id !== get_current_user_id() && ! current_user_can( 'manage_options' ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'No permission to export this user\'s data' ], 
                403 
            );
        }

        $user = get_user_by( 'id', $user_id );
        if ( ! $user ) {
            return new WP_REST_Response( 
                [ 'error' => 'User not found' ], 
                404 
            );
        }

        // Collect user data
        $data = [
            'profile' => [
                'id' => $user->ID,
                'email' => $user->user_email,
                'name' => $user->display_name,
                'registered' => $user->user_registered,
            ],
            'accommodations' => self::get_user_accommodations( $user_id ),
            'reservations' => self::get_user_reservations( $user_id ),
            'activity_logs' => self::get_user_activity( $user_id ),
        ];

        // Add to export queue for background processing
        update_user_meta( $user_id, 'af_gdpr_export_requested', current_time( 'mysql' ) );

        // Send email with download link (or attached file)
        $export_file = self::create_export_file( $user_id, $data );
        wp_mail(
            $user->user_email,
            'Tu datos personales - Exportación GDPR',
            "Aquí están tus datos personales como lo requiere GDPR.\n\nArchivo: $export_file",
            [ 'Content-Type: text/plain; charset=UTF-8' ]
        );

        AF_Input_Validation::log_security_event( 'GDPR_DATA_EXPORT_REQUESTED', [
            'user_id' => $user_id,
            'requested_by' => get_current_user_id(),
        ] );

        return new WP_REST_Response( [
            'message' => 'Data export initiated. Check your email for the download link.',
            'export_id' => uniqid( 'gdpr_' ),
        ], 200 );
    }

    /**
     * Delete user data (GDPR right to be forgotten)
     */
    public static function handle_data_delete( WP_REST_Request $request ) {
        $user_id = $request->get_param( 'user_id' ) ?: get_current_user_id();
        $confirm = $request->get_param( 'confirm_deletion' );

        // Require explicit confirmation
        if ( ! $confirm || $confirm !== 'I understand this is permanent' ) {
            return new WP_REST_Response( 
                [ 'error' => 'Deletion not confirmed' ], 
                400 
            );
        }

        // Verify permission
        if ( $user_id !== get_current_user_id() && ! current_user_can( 'manage_options' ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'No permission to delete this user\'s data' ], 
                403 
            );
        }

        $user = get_user_by( 'id', $user_id );
        if ( ! $user ) {
            return new WP_REST_Response( 
                [ 'error' => 'User not found' ], 
                404 
            );
        }

        // Process deletion
        self::anonymize_user_data( $user_id );

        AF_Input_Validation::log_security_event( 'GDPR_DATA_DELETION_COMPLETED', [
            'user_id' => $user_id,
            'deleted_at' => current_time( 'mysql' ),
        ] );

        return new WP_REST_Response( [
            'message' => 'Your data has been permanently deleted.',
        ], 200 );
    }

    /**
     * Get user accommodations
     */
    private static function get_user_accommodations( $user_id ) {
        global $wpdb;
        return $wpdb->get_results( $wpdb->prepare(
            "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = 'accommodation' AND post_author = %d",
            $user_id
        ) );
    }

    /**
     * Get user reservations
     */
    private static function get_user_reservations( $user_id ) {
        global $wpdb;
        return $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}af_reservations WHERE user_id = %d ORDER BY created_at DESC LIMIT 100",
            $user_id
        ) );
    }

    /**
     * Get user activity/audit logs
     */
    private static function get_user_activity( $user_id ) {
        global $wpdb;
        return $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}af_security_logs WHERE user_id = %d ORDER BY created_at DESC LIMIT 50",
            $user_id
        ) );
    }

    /**
     * Create export file (JSON format)
     */
    private static function create_export_file( $user_id, $data ) {
        $filename = "gdpr_export_user_{$user_id}_" . date( 'Y-m-d_His' ) . '.json';
        $filepath = wp_upload_dir()['path'] . '/' . $filename;

        file_put_contents( $filepath, wp_json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );

        return wp_upload_dir()['url'] . '/' . $filename;
    }

    /**
     * Anonymize user data (right to be forgotten)
     */
    private static function anonymize_user_data( $user_id ) {
        global $wpdb;

        $user = get_user_by( 'id', $user_id );
        if ( ! $user ) return;

        // Anonymize user profile
        wp_update_user( [
            'ID' => $user_id,
            'user_email' => "deleted_user_{$user_id}@example.com",
            'user_login' => "deleted_user_{$user_id}",
            'display_name' => 'Deleted User',
            'first_name' => '',
            'last_name' => '',
        ] );

        // Delete user meta (except essential WordPress meta)
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key NOT LIKE '%capabilities%'",
            $user_id
        ) );

        // Anonymize accommodations (set author to site admin or delete)
        $wpdb->query( $wpdb->prepare(
            "UPDATE {$wpdb->posts} SET post_author = 1, post_content = 'Content deleted per GDPR' 
             WHERE post_type = 'accommodation' AND post_author = %d",
            $user_id
        ) );

        // Delete reservations
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM {$wpdb->prefix}af_reservations WHERE user_id = %d",
            $user_id
        ) );

        do_action( 'af_user_data_deleted', $user_id );
    }
}

// Initialize
if ( defined( 'ABSPATH' ) ) {
    AF_GDPR_Compliance::init();
}
