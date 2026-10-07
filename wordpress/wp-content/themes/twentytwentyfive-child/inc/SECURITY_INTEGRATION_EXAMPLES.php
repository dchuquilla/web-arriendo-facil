<?php
/**
 * SECURITY INTEGRATION GUIDE
 * 
 * Copy this file to see example implementations of the security layer.
 * DO NOT use this in production - it's an educational template.
 */

// ============================================================================
// EXAMPLE 1: Secure REST API Endpoint with Input Validation
// ============================================================================

/**
 * Register a secure endpoint for owner registration
 */
function af_register_owner_api_example() {
    register_rest_route( 'af/v1', '/owner-register-example', [
        'methods'             => 'POST',
        'callback'            => 'af_handle_owner_register_example',
        'permission_callback' => '__return_true', // Public endpoint
        'args'                => [
            'email'    => [
                'type'              => 'string',
                'format'            => 'email',
                'required'          => true,
                'sanitize_callback' => 'sanitize_email',
            ],
            'phone'    => [
                'type'     => 'string',
                'required' => true,
            ],
            'password' => [
                'type'     => 'string',
                'required' => true,
                'minlength' => 12,
            ],
        ],
    ] );
}
add_action( 'rest_api_init', 'af_register_owner_api_example' );

/**
 * Handler with full security validation
 */
function af_handle_owner_register_example( WP_REST_Request $request ) {
    
    // 1. RATE LIMITING - Prevent brute force
    if ( ! AF_Input_Validation::check_rate_limit( 'owner_register', 3, 3600 ) ) {
        return new WP_REST_Response( 
            [ 'error' => 'Demasiados intentos. Intenta de nuevo en 1 hora.' ], 
            429 
        );
    }
    
    // 2. INPUT VALIDATION - Sanitize & validate all inputs
    $email = AF_Input_Validation::validate_email( $request->get_param( 'email' ) );
    if ( ! $email ) {
        return new WP_REST_Response( 
            [ 'error' => 'Email inválido' ], 
            400 
        );
    }
    
    $phone = AF_Input_Validation::validate_phone( $request->get_param( 'phone' ) );
    if ( ! $phone ) {
        return new WP_REST_Response( 
            [ 'error' => 'Teléfono inválido (use formato E.164: +593XXXXXXXXX)' ], 
            400 
        );
    }
    
    $password = $request->get_param( 'password' );
    if ( ! AF_Input_Validation::validate_password( $password ) ) {
        return new WP_REST_Response( 
            [ 'error' => 'Contraseña debe tener 12+ caracteres, incluir mayúscula, minúscula, número y símbolo' ], 
            400 
        );
    }
    
    // 3. IDEMPOTENCY - Check if user already exists
    if ( email_exists( $email ) ) {
        return new WP_REST_Response( 
            [ 'error' => 'Este correo ya está registrado' ], 
            409 
        );
    }
    
    // 4. CREATE USER - Safely create account
    $user_id = wp_create_user( 
        sanitize_user( explode( '@', $email )[0] ), 
        $password, 
        $email 
    );
    
    if ( is_wp_error( $user_id ) ) {
        return new WP_REST_Response( 
            [ 'error' => $user_id->get_error_message() ], 
            500 
        );
    }
    
    // 5. LOGGING - Audit trail
    AF_Input_Validation::log_security_event( 'OWNER_REGISTERED', [
        'user_id' => $user_id,
        'email' => $email,
        'phone' => $phone,
    ] );
    
    // 6. RESPONSE - No sensitive data leaked
    return new WP_REST_Response( [
        'success' => true,
        'user_id' => $user_id,
        'message' => 'Cuenta creada. Revisa tu email para activarla.',
    ], 201 );
}

// ============================================================================
// EXAMPLE 2: Secure Endpoint with Rate Limiting Wrapper
// ============================================================================

/**
 * Alternative: Use wrapper for automatic rate limiting
 */
function af_register_password_reset_api_example() {
    register_rest_route( 'af/v1', '/password-reset-example', [
        'methods'             => 'POST',
        'callback'            => AF_REST_API_Security::handle_post(
            'af_handle_password_reset_request',  // Handler function
            'password_reset',                     // Rate limit action
            3,                                    // Max 3 attempts
            3600                                  // Per 1 hour
        ),
        'permission_callback' => '__return_true',
    ] );
}
add_action( 'rest_api_init', 'af_register_password_reset_api_example' );

function af_handle_password_reset_request( WP_REST_Request $request ) {
    $email = AF_Input_Validation::validate_email( $request->get_param( 'email' ) );
    
    if ( ! $email ) {
        return new WP_REST_Response( [ 'error' => 'Email inválido' ], 400 );
    }
    
    // ✓ Rate limit already checked by wrapper
    // ✓ Email already validated
    
    $user = get_user_by( 'email', $email );
    if ( ! $user ) {
        // ✓ SECURITY: Don't reveal if user exists
        return new WP_REST_Response( [
            'message' => 'Si la cuenta existe, recibirás un email en 5 minutos.'
        ], 200 );
    }
    
    // Generate token
    $token = bin2hex( random_bytes( 32 ) );
    update_user_meta( $user->ID, 'af_password_reset_token', hash( 'sha256', $token ) );
    update_user_meta( $user->ID, 'af_password_reset_expiry', time() + 3600 );
    
    // Send email
    wp_mail( $user->user_email, 'Reset tu contraseña', 
        "Link: " . home_url( '/reset?token=' . $token ) );
    
    AF_Input_Validation::log_security_event( 'PASSWORD_RESET_REQUESTED', [
        'user_id' => $user->ID,
    ] );
    
    return new WP_REST_Response( [
        'message' => 'Si la cuenta existe, recibirás un email en 5 minutos.'
    ], 200 );
}

// ============================================================================
// EXAMPLE 3: Authenticated Endpoint (Admin Only)
// ============================================================================

/**
 * Secure endpoint for authenticated users only
 */
function af_register_admin_api_example() {
    register_rest_route( 'af/v1', '/admin/accommodations', [
        'methods'             => 'GET',
        'callback'            => 'af_handle_get_accommodations',
        'permission_callback' => function() {
            return is_user_logged_in() && current_user_can( 'manage_options' );
        },
        'args'                => [
            'page'     => [ 'type' => 'integer', 'default' => 1 ],
            'per_page' => [ 'type' => 'integer', 'default' => 20 ],
            'search'   => [ 'type' => 'string' ],
        ],
    ] );
}
add_action( 'rest_api_init', 'af_register_admin_api_example' );

function af_handle_get_accommodations( WP_REST_Request $request ) {
    global $wpdb;
    
    // Validate pagination
    $page = max( 1, (int) $request->get_param( 'page' ) );
    $per_page = min( 100, max( 1, (int) $request->get_param( 'per_page' ) ) );
    $offset = ( $page - 1 ) * $per_page;
    
    // Sanitize search (prevent SQL injection)
    $search = '';
    $search_param = $request->get_param( 'search' );
    if ( $search_param ) {
        $search = AF_Input_Validation::sanitize_search( $search_param, 100 );
    }
    
    // Safe database query (using prepared statements)
    if ( $search ) {
        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT ID, post_title, post_content FROM {$wpdb->posts}
             WHERE post_type = 'accommodation' 
             AND post_status = 'publish'
             AND post_title LIKE %s
             ORDER BY post_date DESC
             LIMIT %d OFFSET %d",
            '%' . $wpdb->esc_like( $search ) . '%',
            $per_page,
            $offset
        ) );
    } else {
        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT ID, post_title, post_content FROM {$wpdb->posts}
             WHERE post_type = 'accommodation' 
             AND post_status = 'publish'
             ORDER BY post_date DESC
             LIMIT %d OFFSET %d",
            $per_page,
            $offset
        ) );
    }
    
    // Log access
    AF_Input_Validation::log_security_event( 'ACCOMMODATIONS_LISTED', [
        'user_id' => get_current_user_id(),
        'count' => count( $results ),
        'search' => $search ? 'yes' : 'no',
    ] );
    
    return new WP_REST_Response( [
        'data' => $results,
        'pagination' => [
            'page' => $page,
            'per_page' => $per_page,
            'total' => $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'accommodation' AND post_status = 'publish'" ),
        ],
    ], 200 );
}

// ============================================================================
// EXAMPLE 4: Handling GDPR Data Export Request
// ============================================================================

/**
 * GDPR endpoint is already implemented in AF_GDPR_Compliance class
 * But here's how to add a custom data export endpoint:
 */

function af_register_gdpr_custom_export() {
    register_rest_route( 'af/v1', '/gdpr/export-accommodations', [
        'methods'             => 'POST',
        'callback'            => 'af_handle_accommodation_export',
        'permission_callback' => function() {
            // User must be authenticated
            if ( ! is_user_logged_in() ) {
                return false;
            }
            // Verify GDPR request (nonce)
            $nonce = $_SERVER['HTTP_X_WP_NONCE'] ?? '';
            return AF_Input_Validation::verify_nonce( $nonce, 'wp_rest' );
        },
    ] );
}
add_action( 'rest_api_init', 'af_register_gdpr_custom_export' );

function af_handle_accommodation_export( WP_REST_Request $request ) {
    global $wpdb;
    
    $user_id = get_current_user_id();
    
    // Get user's accommodations
    $accommodations = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM {$wpdb->posts} 
         WHERE post_type = 'accommodation' 
         AND post_author = %d",
        $user_id
    ) );
    
    // Prepare export data (only non-sensitive fields)
    $export_data = [];
    foreach ( $accommodations as $acc ) {
        $export_data[] = [
            'id' => $acc->ID,
            'title' => $acc->post_title,
            'created' => $acc->post_date,
            'status' => $acc->post_status,
        ];
    }
    
    // Generate file
    $filename = "export_accommodations_" . date( 'Y-m-d' ) . ".json";
    $file_content = wp_json_encode( $export_data, JSON_PRETTY_PRINT );
    
    AF_Input_Validation::log_security_event( 'GDPR_CUSTOM_EXPORT', [
        'user_id' => $user_id,
        'accommodations_count' => count( $accommodations ),
    ] );
    
    // Send download
    header( 'Content-Type: application/json' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    header( 'Content-Length: ' . strlen( $file_content ) );
    header( 'Cache-Control: no-cache, no-store, must-revalidate' );
    header( 'Pragma: no-cache' );
    header( 'Expires: 0' );
    
    echo $file_content;
    wp_die();
}

// ============================================================================
// EXAMPLE 5: Input Validation Utilities
// ============================================================================

/**
 * Common validation patterns you'll use:
 */
function af_validation_examples() {
    
    // Email
    $email = AF_Input_Validation::validate_email( $_POST['email'] ?? '' );
    // Returns: false or valid email string
    
    // Phone
    $phone = AF_Input_Validation::validate_phone( $_POST['phone'] ?? '' );
    // Returns: false or formatted E.164 phone
    
    // Password
    $password = $_POST['password'] ?? '';
    if ( ! AF_Input_Validation::validate_password( $password ) ) {
        wp_die( 'Password must be 12+ chars with upper, lower, number, symbol' );
    }
    
    // Property type (whitelist)
    $type = AF_Input_Validation::validate_property_type( $_POST['type'] ?? '' );
    if ( ! $type ) {
        wp_die( 'Invalid property type' );
    }
    
    // Coordinates
    $coords = AF_Input_Validation::validate_coordinates( 
        $_POST['lat'] ?? 0, 
        $_POST['lng'] ?? 0 
    );
    if ( ! $coords ) {
        wp_die( 'Invalid coordinates' );
    }
    // Now use $coords['lat'] and $coords['lng']
    
    // Price
    $price = AF_Input_Validation::validate_price( $_POST['monthly_rent'] ?? 0 );
    if ( $price === false ) {
        wp_die( 'Invalid price' );
    }
    
    // URL
    $website = AF_Input_Validation::validate_url( $_POST['website'] ?? '' );
    if ( ! $website ) {
        wp_die( 'Invalid URL' );
    }
    
    // Search (sanitize for WHERE clause)
    $search = AF_Input_Validation::sanitize_search( $_GET['q'] ?? '', 255 );
    // Safe to use in: LIKE '%$search%'
    
    // Client IP (handles Cloudflare)
    $ip = AF_Input_Validation::get_client_ip();
    // Returns: Valid IP string or 0.0.0.0
    
    // Nonce verification
    if ( ! AF_Input_Validation::verify_nonce( $_POST['_nonce'], 'my_action' ) ) {
        wp_die( 'Security check failed' );
    }
}

// ============================================================================
// TESTING EXAMPLES
// ============================================================================

/**
 * Test rate limiting
 */
function af_test_rate_limiting() {
    // This should pass first 3 times, fail on 4th within 1 hour
    for ( $i = 1; $i <= 5; $i++ ) {
        $allowed = AF_Input_Validation::check_rate_limit( 'test_action', 3, 3600 );
        echo "Attempt $i: " . ( $allowed ? 'PASS' : 'FAIL' ) . "\n";
    }
}

/**
 * Test validation
 */
function af_test_validation() {
    $test_email = 'user@example.com';
    echo "Email valid: " . ( AF_Input_Validation::validate_email( $test_email ) ? 'YES' : 'NO' ) . "\n";
    
    $test_phone = '+593987654321';
    echo "Phone valid: " . ( AF_Input_Validation::validate_phone( $test_phone ) ? 'YES' : 'NO' ) . "\n";
    
    $test_password = 'SecureP@ss123!';
    echo "Password strong: " . ( AF_Input_Validation::validate_password( $test_password ) ? 'YES' : 'NO' ) . "\n";
}
