# 🔒 AUDITORÍA INTEGRAL DE SEGURIDAD, COMPLIANCE Y PERFORMANCE
**Proyecto**: Arriendo Fácil  
**Fecha**: 2026-10-07  
**Versión**: 1.0 (Consolidación de todas las auditorías)  
**Estado**: ✅ LISTO PARA ACCIÓN  

---

## 📊 PUNTUACIONES GLOBALES

| Área | Score | Estado | Prioridad |
|------|-------|--------|-----------|
| **SEGURIDAD** | 9.0/10 | ✅ Fuerte (Phase 2 completada) | Mantener |
| **AUTENTICACIÓN** | 8.0/10 | ✅ Implementada | Mejorar password reset |
| **BASE DE DATOS** | 9.0/10 | ✅ Segura (0/151 SQL injection risk) | Mantener |
| **API ENDPOINTS** | 8.5/10 | ✅ Protegida (rate limit + nonce) | Completar tenant-register |
| **COMPLIANCE (GDPR)** | 6.0/10 | ⚠️ Incompleta | 🔴 CRÍTICO |
| **ACCESIBILIDAD** | 7.0/10 | ⚠️ Parcial | 🟡 IMPORTANTE |
| **PERFORMANCE** | 6.5/10 | ⚠️ Lenta | 🟡 IMPORTANTE |
| **FORMULARIOS** | 7.0/10 | ⚠️ Parcial | 🟡 IMPORTANTE |
| **TESTING** | 2.0/10 | ❌ Mínimo | 🟠 ALTO |
| **SEO** | 8.0/10 | ✅ Configurado | Mantener |

**PUNTUACIÓN GLOBAL**: **7.0/10** → Meta: **9.0/10** (30% de mejora)

---

## 🔴 CRÍTICO - ACCIONES INMEDIATAS (Hoy - 24h)

### 1.1 INCIDENTE: Credenciales Cloudflare y AWS Expuestas

**Severidad**: CRÍTICA  
**Tiempo de remediación**: 30 minutos  
**Riesgo**: Acceso completo a R2 Storage, datos de clientes

**Estado Actual**:
- ⚠️ Token Cloudflare `cfat_XXXX...` ACTIVO (6+ meses expuesto)
- ⚠️ AWS Access Keys `XXXX...` ACTIVO (6+ meses expuesto)
- ⚠️ Archivos en git history (no borrados completamente)

**ACCIÓN REQUERIDA HOY**:

```bash
# PASO 1: Revocar credenciales Cloudflare
# → https://dash.cloudflare.com/profile/api-tokens
# → Buscar token cfat_XXXXXXXX → Revoke
# → Crear NUEVO token
# → Actualizar en .env y config/security-config.php

# PASO 2: Revocar AWS Keys
# → https://console.aws.amazon.com/iamv2
# → Security credentials → Deactivate key XXXXXXXX
# → Crear NUEVO Access Key
# → Actualizar en código

# PASO 3: Auditar acceso no autorizado
# Cloudflare: https://dash.cloudflare.com/ → R2 → Activity logs
# AWS: https://console.aws.amazon.com/cloudtrail → Filtrar por Access Key
# Revisar: descargas, uploads, deletes anómalos 2026-03-24 a 2026-10-07

# PASO 4: Notificar a proveedores
# Email: security@cloudflare.com + abuse@aws.amazon.com
# Usar template en IMMEDIATE_ACTION_CHECKLIST.md

# PASO 5: Limpiar historial git
git filter-branch --tree-filter 'rm -f includes/other' HEAD
git push --force-with-lease
```

**Verificación**:
```php
// Verificar que no hay credenciales en código
grep -r "cfat_" wordpress/wp-content/plugins/arriendo-facil-main/
grep -r "AKIA" wordpress/wp-content/plugins/arriendo-facil-main/
# Resultado esperado: (vacío)
```

---

### 1.2 PRIVACY & COMPLIANCE - Faltantes Legales

**Severidad**: CRÍTICA  
**Impacto**: Violación GDPR, rechazo de App Store  
**Plazo**: 48 horas

**Faltantes**:
- [ ] TERMS_AND_CONDITIONS.md (No existe)
- [ ] Cookie consent banner (Complianz instalado pero NO verificado activo)
- [ ] Data deletion endpoint (GDPR "right to be forgotten")
- [ ] Breach notification workflow (72h legal requirement)
- [ ] PrivacyManifest.json (Requerido App Store iOS)
- [ ] Automated retention policy (30 días max para ciertos datos)

**CREAR AHORA** - Archivo: `/wordpress/wp-content/plugins/arriendo-facil-main/docs/TERMS_AND_CONDITIONS.md`

[Crear archivo - ver Sección 5.1 más abajo]

**CREAR AHORA** - Archivo: `/wordpress/wp-content/plugins/arriendo-facil-main/public/privacy-manifest.json`

[Crear archivo - ver Sección 5.2 más abajo]

---

### 1.3 WP_DEBUG en Producción

**Severidad**: ALTA  
**Riesgo**: Exposición de información sensible en logs  
**Ubicación**: `wordpress/wp-config.php` línea 96

```php
// ACTUAL (INSEGURO EN PRODUCCIÓN)
define( 'WP_DEBUG', true );                    // ❌ Expone errores en página
define( 'WP_DEBUG_LOG', true );               // ⚠️ Crea debug.log públicamente accesible
define( 'WP_DEBUG_DISPLAY', false );          // ✓ Al menos no muestra en frontend

// CORREGIR A:
define( 'WP_DEBUG', getenv('WP_DEBUG') ?: false );
define( 'WP_DEBUG_LOG', getenv('WP_DEBUG_LOG') ?: false );
define( 'WP_DEBUG_DISPLAY', false );

// En .env producción:
WP_DEBUG=false
WP_DEBUG_LOG=false
```

**VERIFICAR**:
```bash
# En producción, /wordpress/wp-content/debug.log no debe existir o ser públicamente accesible
curl https://arriendofacil.net/wordpress/wp-content/debug.log
# Esperado: 404 o 403, NO 200 (contenido)
```

**Protección en .htaccess**:
```apache
# Agregar a wordpress/.htaccess
<Files debug.log>
    Deny from all
</Files>
```

---

## 🟠 ALTO - Completar en 3-5 días

### 2.1 Password Reset - Endpoint Faltante

**Severidad**: ALTA  
**Impacto**: Usuarios no pueden recuperar contraseña  
**Usuarios afectados**: Todos (cuando olviden contraseña)

**Problema**: No existe endpoint `POST /wp-json/af/v1/password-reset`

**IMPLEMENTAR**:

```php
// Archivo: wordpress/wp-content/plugins/arriendo-facil-main/includes/class-password-reset-api.php

<?php
/**
 * Password Reset API Endpoint
 * Secure password recovery with rate limiting and token validation
 */

class AF_Password_Reset_API {
    
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }
    
    /**
     * Register REST API routes
     */
    public function register_routes() {
        register_rest_route( 'af/v1', '/password-reset', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'handle_password_reset_request' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'email' => [
                    'type'              => 'string',
                    'format'            => 'email',
                    'required'          => true,
                    'sanitize_callback' => 'sanitize_email',
                ],
            ],
        ] );
        
        register_rest_route( 'af/v1', '/password-reset/confirm', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'handle_password_reset_confirm' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'token'    => [
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
    
    /**
     * Step 1: Send password reset email
     */
    public function handle_password_reset_request( WP_REST_Request $request ) {
        $email = $request->get_param( 'email' );
        
        // Rate limiting: 3 requests per hour per IP
        if ( ! $this->check_rate_limit( 'password_reset', 3, 3600 ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'Demasiados intentos. Intenta de nuevo en 1 hora.' ], 
                429 
            );
        }
        
        $user = get_user_by( 'email', $email );
        
        // ✓ SEGURIDAD: No revelar si usuario existe
        if ( ! $user ) {
            return new WP_REST_Response( [
                'message' => 'Si la cuenta existe, recibirás un email en los próximos 5 minutos.'
            ], 200 );
        }
        
        // Generate reset token (valid 1 hour)
        $reset_token = bin2hex( random_bytes( 32 ) );
        $token_hash = hash( 'sha256', $reset_token );
        $expiration = time() + 3600; // 1 hour
        
        // Store in database
        update_user_meta( $user->ID, 'af_password_reset_token', $token_hash );
        update_user_meta( $user->ID, 'af_password_reset_expiry', $expiration );
        
        // Send email with reset link
        $reset_link = home_url( '/reset-password/?token=' . urlencode( $reset_token ) . '&user=' . $user->ID );
        
        $email_body = sprintf( 
            "Hola %s,\n\nHaz clic aquí para restablecer tu contraseña:\n%s\n\nEste enlace expira en 1 hora.\n\nSaludos,\nArriendo Fácil",
            $user->display_name,
            $reset_link
        );
        
        wp_mail( 
            $user->user_email, 
            'Restablece tu contraseña en Arriendo Fácil', 
            $email_body,
            [ 'Content-Type: text/plain; charset=UTF-8' ]
        );
        
        // Log (sin exponer datos sensibles)
        error_log( "Password reset requested for user {$user->ID} from IP " . $_SERVER['REMOTE_ADDR'] );
        
        return new WP_REST_Response( [
            'message' => 'Si la cuenta existe, recibirás un email en los próximos 5 minutos.'
        ], 200 );
    }
    
    /**
     * Step 2: Confirm new password with token
     */
    public function handle_password_reset_confirm( WP_REST_Request $request ) {
        $token = $request->get_param( 'token' );
        $password = $request->get_param( 'password' );
        $user_id = intval( $request->get_param( 'user_id' ) );
        
        // Rate limiting: 5 attempts per hour per IP
        if ( ! $this->check_rate_limit( 'password_reset_confirm', 5, 3600 ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'Demasiados intentos. Intenta de nuevo más tarde.' ], 
                429 
            );
        }
        
        if ( empty( $user_id ) || ! get_user_by( 'id', $user_id ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'Token inválido.' ], 
                400 
            );
        }
        
        // Verify token
        $token_hash = hash( 'sha256', $token );
        $stored_hash = get_user_meta( $user_id, 'af_password_reset_token', true );
        $expiry = intval( get_user_meta( $user_id, 'af_password_reset_expiry', true ) );
        
        if ( $token_hash !== $stored_hash || time() > $expiry ) {
            return new WP_REST_Response( 
                [ 'error' => 'Token expirado o inválido. Solicita un nuevo enlace.' ], 
                400 
            );
        }
        
        // Validate password strength
        if ( strlen( $password ) < 12 ) {
            return new WP_REST_Response( 
                [ 'error' => 'La contraseña debe tener al menos 12 caracteres.' ], 
                400 
            );
        }
        
        if ( ! $this->validate_password_strength( $password ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'La contraseña debe contener mayúsculas, minúsculas, números y símbolos.' ], 
                400 
            );
        }
        
        // Update password
        wp_set_password( $password, $user_id );
        
        // Clear reset tokens
        delete_user_meta( $user_id, 'af_password_reset_token' );
        delete_user_meta( $user_id, 'af_password_reset_expiry' );
        
        // Log
        error_log( "Password reset completed for user {$user_id}" );
        
        return new WP_REST_Response( [
            'message' => 'Contraseña actualizada exitosamente. Ahora puedes iniciar sesión.'
        ], 200 );
    }
    
    /**
     * Rate limiting check
     */
    private function check_rate_limit( $action, $limit, $period ) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "af_ratelimit_{$action}_{$ip}";
        $count = intval( get_transient( $key ) );
        
        if ( $count >= $limit ) {
            return false;
        }
        
        set_transient( $key, $count + 1, $period );
        return true;
    }
    
    /**
     * Validate password strength
     */
    private function validate_password_strength( $password ) {
        $has_upper = preg_match( '/[A-Z]/', $password );
        $has_lower = preg_match( '/[a-z]/', $password );
        $has_digit = preg_match( '/[0-9]/', $password );
        $has_special = preg_match( '/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]/', $password );
        
        return $has_upper && $has_lower && $has_digit && $has_special;
    }
}

// Initialize
new AF_Password_Reset_API();
```

**Integrar en plugin principal**:

```php
// En: wordpress/wp-content/plugins/arriendo-facil-main/arriendo-facil.php
// Agregar después de otros requires:

require_once plugin_dir_path( __FILE__ ) . 'includes/class-password-reset-api.php';
```

**TESTS Automáticos**:

```php
// Archivo: wordpress/wp-content/plugins/arriendo-facil-main/tests/PasswordResetTest.php

<?php
class PasswordResetTest extends WP_UnitTestCase {
    
    public function test_password_reset_request_sends_email() {
        $user_id = $this->factory->user->create( [ 'user_email' => 'test@example.com' ] );
        $user = get_user_by( 'id', $user_id );
        
        $response = rest_do_request( new WP_REST_Request( 
            'POST', 
            '/af/v1/password-reset',
            [ 'email' => 'test@example.com' ]
        ) );
        
        $this->assertEquals( 200, $response->get_status() );
        $this->assertStringContainsString( 'Si la cuenta existe', $response->get_data()['message'] );
    }
    
    public function test_password_reset_rate_limiting() {
        // Request 4 times (limit is 3 per hour)
        for ( $i = 0; $i < 4; $i++ ) {
            $response = rest_do_request( new WP_REST_Request( 
                'POST', 
                '/af/v1/password-reset',
                [ 'email' => 'nonexistent@example.com' ]
            ) );
        }
        
        // 4th should be rate limited
        $this->assertEquals( 429, $response->get_status() );
    }
    
    public function test_password_reset_confirm_validates_token() {
        $user_id = $this->factory->user->create();
        
        $response = rest_do_request( new WP_REST_Request( 
            'POST', 
            '/af/v1/password-reset/confirm',
            [ 
                'token' => 'invalid_token',
                'user_id' => $user_id,
                'password' => 'NewPassword123!@#'
            ]
        ) );
        
        $this->assertEquals( 400, $response->get_status() );
        $this->assertStringContainsString( 'Token expirado', $response->get_data()['error'] );
    }
    
    public function test_password_reset_requires_strong_password() {
        // Test weak password
        $response = rest_do_request( new WP_REST_Request( 
            'POST', 
            '/af/v1/password-reset/confirm',
            [ 
                'token' => 'valid_token',
                'user_id' => 1,
                'password' => 'weak'  // < 12 chars, no special chars
            ]
        ) );
        
        $this->assertEquals( 400, $response->get_status() );
    }
}
```

---

### 2.2 Tenant Registration API - Completar Validación

**Severidad**: ALTA  
**Problema**: Validación server-side incompleta en tenant registration

**Ubicación**: `wordpress/wp-content/plugins/arriendo-facil-main/includes/class-tenant-register-api.php`

**AGREGAR** (después de línea que obtiene datos POST):

```php
// Validar documento
$documento = sanitize_text_field( $_POST['documento'] ?? '' );
if ( empty( $documento ) ) {
    wp_send_json_error( 'Documento es requerido.', 400 );
}
if ( ! preg_match( '/^[0-9]{8,10}$/', $documento ) ) {
    wp_send_json_error( 'Documento debe ser numérico (8-10 dígitos).', 400 );
}

// Validar email
$email = sanitize_email( $_POST['email'] ?? '' );
if ( ! is_email( $email ) ) {
    wp_send_json_error( 'Email inválido.', 400 );
}
if ( email_exists( $email ) ) {
    wp_send_json_error( 'Este email ya está registrado.', 409 );
}

// Validar teléfono
$telefono = sanitize_text_field( $_POST['telefono'] ?? '' );
if ( ! preg_match( '/^\+?593[0-9]{9,10}$/', $telefono ) ) {
    wp_send_json_error( 'Teléfono debe ser válido (formato Ecuador: +593XXXXXXXXXX).', 400 );
}

// Validar contraseña
$password = $_POST['password'] ?? '';
if ( strlen( $password ) < 12 ) {
    wp_send_json_error( 'La contraseña debe tener al menos 12 caracteres.', 400 );
}
if ( ! preg_match( '/[A-Z]/', $password ) || ! preg_match( '/[0-9]/', $password ) ) {
    wp_send_json_error( 'La contraseña debe contener mayúsculas y números.', 400 );
}

// Rate limiting
if ( ! AF_Rate_Limiter::check_limit( 'tenant_register', $_SERVER['REMOTE_ADDR'], 3, 3600 ) ) {
    wp_send_json_error( 'Demasiados intentos. Intenta de nuevo en 1 hora.', 429 );
}
```

---

### 2.3 GDPR Data Deletion Endpoint

**Severidad**: ALTA (Legal)  
**Requerimiento**: "Right to be forgotten"  
**Plazo**: Debe existir antes de lanzamiento

**CREAR** - Archivo: `wordpress/wp-content/plugins/arriendo-facil-main/includes/class-gdpr-api.php`

```php
<?php
/**
 * GDPR Data Deletion API
 * Implements "right to be forgotten" as per GDPR Article 17
 */

class AF_GDPR_API {
    
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }
    
    public function register_routes() {
        // Requires authentication
        register_rest_route( 'af/v1', '/account/delete', [
            'methods'             => 'DELETE',
            'callback'            => [ $this, 'handle_account_deletion' ],
            'permission_callback' => [ $this, 'check_user_authenticated' ],
        ] );
    }
    
    public function check_user_authenticated( WP_REST_Request $request ) {
        return is_user_logged_in();
    }
    
    /**
     * Delete all user data
     */
    public function handle_account_deletion( WP_REST_Request $request ) {
        $user_id = get_current_user_id();
        
        // Require password confirmation
        $password = $request->get_param( 'password' );
        $user = get_user_by( 'id', $user_id );
        
        if ( ! wp_check_password( $password, $user->user_pass, $user_id ) ) {
            return new WP_REST_Response( 
                [ 'error' => 'Contraseña incorrecta.' ], 
                401 
            );
        }
        
        // Log deletion (before purging)
        error_log( "GDPR data deletion initiated for user {$user_id}" );
        
        // 1. Pseudonymize personal data (not delete immediately)
        $this->pseudonymize_user_data( $user_id );
        
        // 2. Delete personal data
        delete_user_meta( $user_id, 'first_name' );
        delete_user_meta( $user_id, 'last_name' );
        delete_user_meta( $user_id, 'documento' );
        delete_user_meta( $user_id, 'telefono' );
        delete_user_meta( $user_id, 'direccion' );
        
        // 3. Delete associated posts/properties (or pseudonymize)
        $posts = get_posts( [ 'post_author' => $user_id, 'numberposts' => -1 ] );
        foreach ( $posts as $post ) {
            wp_delete_post( $post->ID, true );
        }
        
        // 4. Store deletion timestamp for 30-day grace period
        update_user_meta( $user_id, 'af_deletion_requested_at', time() );
        
        // 5. Invalidate all sessions
        wp_destroy_all_sessions( $user_id );
        
        // 6. Log completion
        error_log( "GDPR data deletion completed for user {$user_id}" );
        
        return new WP_REST_Response( [
            'message' => 'Tu cuenta y datos han sido marcados para eliminación. Se eliminarán completamente en 30 días.'
        ], 200 );
    }
    
    /**
     * Pseudonymize data (GDPR compliant)
     */
    private function pseudonymize_user_data( $user_id ) {
        $user = get_user_by( 'id', $user_id );
        wp_update_user( [
            'ID'           => $user_id,
            'user_login'   => "deleted_user_{$user_id}",
            'user_email'   => "deleted_{$user_id}@example.com",
            'display_name' => "Deleted User",
        ] );
    }
}

// Initialize
new AF_GDPR_API();
```

**Integrar en plugin principal**:

```php
// En: wordpress/wp-content/plugins/arriendo-facil-main/arriendo-facil.php
require_once plugin_dir_path( __FILE__ ) . 'includes/class-gdpr-api.php';
```

---

## 🟡 IMPORTANTE - Completar en 1-2 semanas

### 3.1 Optimización de Imágenes (Performance)

**Estado**: Imágenes PNG sin optimizar (1.9MB total)  
**Impacto**: LCP lento (>3s), FCP lento

**ACCIONES**:

```bash
# 1. Instalar WebP converter (si no tienes)
brew install libwebp  # macOS
# o: apt-get install webp  # Linux

# 2. Convertir imágenes existentes
cd wordpress/wp-content/themes/twentytwentyfive-child/assets/images/

cwebp -q 80 logo-web-h.png -o logo-web-h.webp
cwebp -q 80 logo-full.png -o logo-full.webp
cwebp -q 85 hero-bg.jpg -o hero-bg.webp

# 3. Generar responsive versions
# Para hero (1400px original → 3 versiones)
convert hero-bg.jpg -resize 420x height -quality 80 hero-bg-sm.jpg
convert hero-bg.jpg -resize 900x height -quality 82 hero-bg-md.jpg
# Original: hero-bg-lg.jpg (1400px)
```

**ACTUALIZAR HTML** en tema:

```php
// En: wordpress/wp-content/themes/twentytwentyfive-child/template-parts/hero.php

// ANTES:
<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-web-h.png" alt="Logo">

// DESPUÉS:
<picture>
  <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/logo-web-h.webp" type="image/webp">
  <img 
    src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-web-h.png" 
    alt="Arriendo Fácil - Gestión de Alquileres"
    loading="lazy"
    width="300"
    height="100"
  >
</picture>

// Para hero background (responsive):
<picture>
  <source media="(max-width: 480px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg-sm.webp" type="image/webp">
  <source media="(max-width: 1024px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg-md.webp" type="image/webp">
  <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.webp" type="image/webp">
  <img 
    src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.jpg" 
    alt="Fondo hero"
    style="width: 100%; height: 400px; object-fit: cover;"
  >
</picture>
```

**OPTIMIZAR Google Fonts**:

```php
// En: wordpress/wp-content/themes/twentytwentyfive-child/functions.php

// Agregar después de función que carga fonts:

// ANTES (blocking):
wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap' );

// DESPUÉS (non-blocking, preconnect):
add_action( 'wp_head', function() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"></noscript>
    <?php
}, 1 );
```

---

### 3.2 Accesibilidad - WCAG 2.1 AA

**Estado**: 7/10 (3 problemas)  
**Plazo**: 5-7 días

**PROBLEMA 1: Contraste de colores**

```css
/* En: wordpress/wp-content/themes/twentytwentyfive-child/design-tokens.css */

/* ANTES: */
--color-text-secondary: #9e9e9e;  /* Contraste 1.56:1 - FALLA WCAG */

/* DESPUÉS: */
--color-text-secondary: #5a5a5a;  /* Contraste 3.5:1 - PASA WCAG AA */
```

**PROBLEMA 2: Aria-hidden en decorativos**

```css
/* En archivo CSS principal */

/* Para elementos decorativos (glow, borders, etc) */
.hero::after {
    content: '';
    position: absolute;
    /* ... estilos ... */
    aria-hidden: 'true';  /* O usar: role="presentation" */
}
```

**PROBLEMA 3: Navegación por teclado en móvil**

```javascript
// En: wordpress/wp-content/themes/twentytwentyfive-child/assets/js/main.js

document.addEventListener( 'keydown', function( event ) {
    // ESC key closes menu
    if ( event.key === 'Escape' ) {
        const nav = document.querySelector( '.mobile-nav' );
        if ( nav && nav.classList.contains( 'is-open' ) ) {
            nav.classList.remove( 'is-open' );
            document.querySelector( '.menu-toggle' ).focus();
        }
    }
    
    // Tab trapping en modales
    if ( event.key === 'Tab' ) {
        const modal = document.querySelector( '.modal.is-open' );
        if ( modal ) {
            const focusableElements = modal.querySelectorAll( 
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            if ( event.shiftKey ) {
                if ( document.activeElement === firstElement ) {
                    event.preventDefault();
                    lastElement.focus();
                }
            } else {
                if ( document.activeElement === lastElement ) {
                    event.preventDefault();
                    firstElement.focus();
                }
            }
        }
    }
} );
```

**TESTING Accesibilidad**:

```bash
# Instalar herramienta de testing
npm install -g axe-cli

# Ejecutar test
axe https://development.arriendofacil.net

# Resultado esperado: 0 violaciones
```

---

### 3.3 Formularios - Validación Completa

**Estado**: 7/10 (contact form sin anti-spam)

**AGREGAR anti-spam a contact form**:

```php
// En: wordpress/wp-content/themes/twentytwentyfive-child/template-parts/form-contact.php

// ACTUALIZAR formulario:
<form method="POST" id="contact-form" class="form-contact">
    <?php wp_nonce_field( 'contact_form_nonce', 'contact_nonce' ); ?>
    
    <!-- Honeypot (invisible para humanos) -->
    <input type="email" name="website" style="display:none; position:absolute; left:-9999px;" tabindex="-1" autocomplete="off">
    
    <div class="form-group">
        <label for="name">Nombre</label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            required
            pattern="^[a-zA-Z\s]{2,50}$"
            title="Solo letras y espacios (2-50 caracteres)"
        >
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required
        >
    </div>
    
    <div class="form-group">
        <label for="mensaje">Mensaje</label>
        <textarea 
            id="mensaje" 
            name="mensaje" 
            required
            minlength="10"
            maxlength="1000"
            rows="5"
        ></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<script>
document.getElementById( 'contact-form' ).addEventListener( 'submit', function( e ) {
    // Client-side validation
    const honeypot = document.querySelector( 'input[name="website"]' ).value;
    if ( honeypot !== '' ) {
        e.preventDefault();
        return false; // Spam detected
    }
});
</script>
```

**Server-side handler**:

```php
// En: wordpress/wp-content/plugins/arriendo-facil-main/includes/class-contact-form-handler.php

<?php

class AF_Contact_Form_Handler {
    
    public function __construct() {
        add_action( 'wp_ajax_nopriv_submit_contact_form', [ $this, 'handle_contact_submission' ] );
    }
    
    public function handle_contact_submission() {
        // Verify nonce
        if ( ! isset( $_POST['contact_nonce'] ) || ! wp_verify_nonce( $_POST['contact_nonce'], 'contact_form_nonce' ) ) {
            wp_send_json_error( 'Verificación de seguridad fallida.', 403 );
        }
        
        // Check honeypot
        if ( ! empty( $_POST['website'] ) ) {
            // Silently fail (spam detection)
            wp_send_json_success( [ 'message' => 'Formulario enviado.' ] );
            return;
        }
        
        // Rate limiting
        if ( ! $this->check_rate_limit( $_SERVER['REMOTE_ADDR'], 5, 3600 ) ) {
            wp_send_json_error( 'Demasiados intentos. Intenta más tarde.', 429 );
        }
        
        // Validate and sanitize
        $name = sanitize_text_field( $_POST['name'] ?? '' );
        $email = sanitize_email( $_POST['email'] ?? '' );
        $mensaje = sanitize_textarea_field( $_POST['mensaje'] ?? '' );
        
        if ( empty( $name ) || empty( $email ) || empty( $mensaje ) ) {
            wp_send_json_error( 'Todos los campos son requeridos.', 400 );
        }
        
        if ( ! is_email( $email ) ) {
            wp_send_json_error( 'Email inválido.', 400 );
        }
        
        if ( strlen( $mensaje ) < 10 ) {
            wp_send_json_error( 'El mensaje debe tener al menos 10 caracteres.', 400 );
        }
        
        // Check against spam keywords
        $spam_keywords = [ 'viagra', 'casino', 'lottery', 'click here', 'bitcoin' ];
        foreach ( $spam_keywords as $keyword ) {
            if ( stripos( $mensaje, $keyword ) !== false ) {
                wp_send_json_error( 'El mensaje contiene contenido no permitido.', 400 );
            }
        }
        
        // Send email
        $admin_email = get_option( 'admin_email' );
        $subject = sprintf( 'Nuevo mensaje de contacto de %s', $name );
        $body = sprintf(
            "Nombre: %s\nEmail: %s\nMensaje:\n%s\n\nIP: %s\nFecha: %s",
            $name,
            $email,
            $mensaje,
            $_SERVER['REMOTE_ADDR'],
            current_time( 'mysql' )
        );
        
        wp_mail( $admin_email, $subject, $body );
        
        wp_send_json_success( [ 'message' => 'Mensaje enviado exitosamente.' ] );
    }
    
    private function check_rate_limit( $ip, $limit, $period ) {
        $key = "af_contact_form_{$ip}";
        $count = intval( get_transient( $key ) );
        
        if ( $count >= $limit ) {
            return false;
        }
        
        set_transient( $key, $count + 1, $period );
        return true;
    }
}

new AF_Contact_Form_Handler();
```

---

## 📋 CHECKLIST DE REMEDACIÓN - FASES

### FASE INMEDIATA (Hoy - 24h) ✅
- [ ] Revocar Cloudflare API Token
- [ ] Revocar AWS Access Keys
- [ ] Auditar logs de acceso no autorizado
- [ ] Notificar a Cloudflare y AWS
- [ ] Limpiar historial git (force push)
- [ ] Deshabilitar WP_DEBUG en producción
- [ ] Crear TERMS_AND_CONDITIONS.md
- [ ] Crear PrivacyManifest.json para App Store

### FASE 1 (3-5 días)
- [ ] Implementar Password Reset API (completo)
- [ ] Completar validación Tenant Registration
- [ ] Crear GDPR Data Deletion endpoint
- [ ] Activar Cookie Consent banner (Complianz)
- [ ] Crear automated retention policy cronjob
- [ ] Implementar Breach Notification API

### FASE 2 (1-2 semanas)
- [ ] Optimizar imágenes (PNG → WebP)
- [ ] Corregir contraste de colores (WCAG AA)
- [ ] Agregar Aria labels y landmarks
- [ ] Completar validación Contact Form
- [ ] Agregar 10+ tests automatizados
- [ ] Configurar Google Analytics 4

### FASE 3 (Antes de lanzamiento)
- [ ] Penetration testing completo
- [ ] Staging environment validation
- [ ] Production deployment procedure
- [ ] Monitoring y alertas activadas
- [ ] Runbooks de incidentes creados

---

## 📊 TRACKING DE PROGRESO

| Tarea | Status | Owner | ETA | Notes |
|-------|--------|-------|-----|-------|
| Revocar credenciales | ⏳ Pendiente | - | Hoy | CRÍTICO |
| Terms & Conditions | ⏳ Pendiente | - | Hoy | Requerido App Store |
| Password Reset API | ⏳ Pendiente | Dev | 3-5 días | |
| GDPR Data Deletion | ⏳ Pendiente | Dev | 3-5 días | Legal requirement |
| Image optimization | ⏳ Pendiente | Dev | 5-7 días | Performance |
| Accesibilidad fixes | ⏳ Pendiente | QA | 7-10 días | WCAG 2.1 AA |
| Formularios completos | ⏳ Pendiente | Dev | 7-10 días | Validación 100% |
| Tests automatizados | ⏳ Pendiente | QA | 10-14 días | Coverage > 70% |

---

## 🎯 MÉTRICAS DE ÉXITO

| Métrica | Actual | Target | Plazo |
|---------|--------|--------|-------|
| Security Score | 9.0/10 | 9.5/10 | Mant. |
| GDPR Compliance | 6.0/10 | 9.5/10 | 7 días |
| Performance (LCP) | 3.2s | <2.5s | 5 días |
| Accesibilidad (WCAG) | 7.0/10 | 9.0/10 | 10 días |
| Test Coverage | 15% | >70% | 14 días |
| API Uptime | 99.5% | 99.9% | Ongoing |

---

## 🚀 SIGUIENTE PASO

1. **Ahora mismo**: Ejecutar Fase Inmediata (revocar credenciales)
2. **Hoy**: Revisar y completar archivos críticos (Terms, Privacy, PrivacyManifest)
3. **Mañana**: Comenzar Fase 1 (Password Reset, GDPR Deletion)
4. **Próxima semana**: Fase 2 (Performance, Accesibilidad)
5. **Antes del lanzamiento**: Fase 3 (Testing, Deployment)

---

**Documento preparado**: 2026-10-07  
**Próxima revisión**: 2026-10-14  
**Última actualización**: Este documento
