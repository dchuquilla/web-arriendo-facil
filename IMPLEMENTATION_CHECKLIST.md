# CHECKLIST DE IMPLEMENTACIÓN - ACCIONES POR EJECUTAR

**Proyecto**: Arriendo Fácil  
**Fecha Creación**: 2026-10-07  
**Prioridad**: CRÍTICA → ALTA → MEDIA  

---

## ✅ FASE 0: AHORA MISMO (Próximas 24 horas)

### [ ] 0.1 REVOCAR CREDENCIALES COMPROMETIDAS

**Cloudflare API Token**
```bash
# 1. Acceder a: https://dash.cloudflare.com/profile/api-tokens
# 2. Encontrar token: cfat_XXXXXXXX...
# 3. Clic en "..." → "Revoke"
# 4. Confirmar revocación
# 5. Crear NUEVO token:
#    - Clic "Create Token"
#    - Seleccionar "Edit Cloudflare Workers" o "R2 Storage"
#    - Scope: Account
#    - Copiar token
# 6. Guardar en .env:
```
**Archivo**: `.env` (no versionado)
```
CLOUDFLARE_API_TOKEN=cfat_[NUEVO_TOKEN]
R2_ENDPOINT=https://[ACCOUNT_ID].r2.cloudflarestorage.com
R2_BUCKET=arriendo-facil
R2_ACCESS_KEY=[Nuevo Access Key]
R2_SECRET_KEY=[Nuevo Secret Key]
```

**AWS Access Keys**
```bash
# 1. Acceder a: https://console.aws.amazon.com/iamv2/home#/users
# 2. Encontrar usuario con Access Key: AKIA...XXXXXXXX
# 3. Clic "Security credentials"
# 4. Localizar Access Key → Clic "Deactivate" (primero, NO borrar)
# 5. Verificar en aplicación que funciona con nuevo key
# 6. Volver a AWS → Clic "Delete"
# 7. Crear NUEVO Access Key:
#    - Clic "Create access key"
#    - "Application running outside AWS"
#    - Copiar ID y Secret
# 8. Guardar en .env
```

**Verificar limpieza**:
```bash
cd /Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil
grep -r "cfat_" .
grep -r "AKIA" .
grep -r "XXXXXXXXXXXXXXXXXXXX" .
# Esperado: (sin resultados)
```

---

### [ ] 0.2 AUDITAR ACCESO NO AUTORIZADO

**Cloudflare R2 Logs**:
1. Ir a: https://dash.cloudflare.com/
2. R2 → Bucket → Activity logs
3. Filtrar: 2026-03-24 a 2026-10-07
4. Revisar:
   - [ ] ¿IPs desconocidas?
   - [ ] ¿Descargas masivas?
   - [ ] ¿Archivos modificados?
   - [ ] ¿Permisos cambiados?
5. Documentar en: `/memories/session/security-incident-audit.md`

**AWS CloudTrail**:
1. Ir a: https://console.aws.amazon.com/cloudtrail
2. Eventos recientes
3. Filtrar por Access Key: `AKIA...`
4. Revisar:
   - [ ] ListBucket
   - [ ] GetObject (descargas)
   - [ ] PutObject (uploads)
   - [ ] DeleteObject (borrados)
5. Documentar hallazgos

---

### [ ] 0.3 NOTIFICAR A PROVEEDORES

**Cloudflare** → security@cloudflare.com
```
Subject: URGENT - Exposed API Token Notification

Dear Cloudflare Security,

We discovered an API token was accidentally committed to git.

Token: cfat_XXXXXXXX...
Exposure: March 24 - September 30, 2026 (approx. 6 months)
Status: REVOKED October 7, 2026

Request: Please review logs for unauthorized access.
Contact: [Your Name] [Email] [Phone]
```

**AWS** → abuse@aws.amazon.com
```
Subject: URGENT - Exposed AWS Access Keys Notification

Dear AWS Security,

We discovered AWS Access Keys were accidentally committed to git.

Access Key ID: AKIA...XXXXXXXX
Exposure: March 24 - September 30, 2026
Status: DEACTIVATED October 7, 2026

Request: Please review CloudTrail for unauthorized access.
Contact: [Your Name] [Email] [Phone]
```

---

### [ ] 0.4 CORREGIR WP_DEBUG EN wp-config.php

**Archivo**: `wordpress/wp-config.php`

```php
// LÍNEA 96-98 - CAMBIAR DE:
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

// A:
define( 'WP_DEBUG', false );  // Solo true en desarrollo
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
```

**Verificar después**:
```bash
# En servidor de producción:
curl https://arriendofacil.net/wordpress/wp-content/debug.log
# Esperado: 404 Not Found
```

---

### [ ] 0.5 CREAR ARCHIVOS CRÍTICOS

**1. TERMS_AND_CONDITIONS.md**
- ✅ YA CREADO: `wordpress/wp-content/plugins/arriendo-facil-main/docs/TERMS_AND_CONDITIONS.md`
- [ ] Revisar contenido
- [ ] Personalizar con datos legales reales
- [ ] Hacer disponible en página: `/terminos-y-condiciones/`

**2. PRIVACY_MANIFEST.json (Requerido App Store iOS)**
- ✅ YA CREADO: `wordpress/wp-content/plugins/arriendo-facil-main/public/privacy-manifest.json`
- [ ] Verificar en App Store submission
- [ ] Descargar formato completo si es necesario

---

## 🔴 FASE 1: ESTA SEMANA (3-5 días)

### [ ] 1.1 IMPLEMENTAR PASSWORD RESET API

**Archivo a crear**: `wordpress/wp-content/plugins/arriendo-facil-main/includes/class-password-reset-api.php`

✅ **Código listo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 2.1

**Pasos de implementación**:
1. [ ] Copiar código de clase `AF_Password_Reset_API`
2. [ ] Crear archivo `class-password-reset-api.php`
3. [ ] Agregar `require_once` en `arriendo-facil.php`:
```php
require_once plugin_dir_path( __FILE__ ) . 'includes/class-password-reset-api.php';
```
4. [ ] Crear y ejecutar tests (PHPUnit)
5. [ ] Verificar endpoints:
```bash
# Test 1: Request reset
curl -X POST http://development.arriendofacil.net/wp-json/af/v1/password-reset \
  -d '{"email":"test@example.com"}' \
  -H "Content-Type: application/json"

# Esperado: { "message": "Si la cuenta existe..." }

# Test 2: Rate limiting (4ta llamada)
# Esperado: { "error": "Demasiados intentos" } 429
```

---

### [ ] 1.2 COMPLETAR VALIDACIÓN TENANT REGISTRATION

**Archivo**: `wordpress/wp-content/plugins/arriendo-facil-main/includes/class-tenant-register-api.php`

**Agregar validaciones** (después de obtener POST params):
✅ **Código listo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 2.2

**Verificar campos**:
- [ ] Documento (numérico, 8-10 dígitos)
- [ ] Email (válido, no existe)
- [ ] Teléfono (formato Ecuador)
- [ ] Contraseña (12+ chars, mayús, números)
- [ ] Rate limiting (3/hora)

---

### [ ] 1.3 CREAR GDPR DATA DELETION ENDPOINT

**Archivo a crear**: `wordpress/wp-content/plugins/arriendo-facil-main/includes/class-gdpr-api.php`

✅ **Código listo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 2.3

**Pasos**:
1. [ ] Crear archivo con clase `AF_GDPR_API`
2. [ ] Agregar require en `arriendo-facil.php`
3. [ ] Verific endpoint DELETE `/wp-json/af/v1/account/delete`
4. [ ] Test:
```bash
curl -X DELETE http://development.arriendofacil.net/wp-json/af/v1/account/delete \
  -H "Authorization: Bearer [user-token]" \
  -d '{"password":"user_password"}' \
  -H "Content-Type: application/json"
```

---

### [ ] 1.4 ACTIVAR COOKIE CONSENT BANNER

**Plugin**: Complianz GDPR (ya instalado)

**Pasos**:
1. [ ] Admin → Complianz GDPR → Settings
2. [ ] Enable "Cookie Banner"
3. [ ] Configurar:
   - [ ] Banner message (según GDPR)
   - [ ] Accept/Decline buttons
   - [ ] Link a Privacy Policy
4. [ ] Verificar en frontend:
```bash
# Debe aparecer banner en página
curl https://development.arriendofacil.net/ | grep -i cookie
```

---

### [ ] 1.5 CREAR AUTOMATED RETENTION POLICY

**Archivo a crear**: `wordpress/wp-content/plugins/arriendo-facil-main/includes/class-data-retention-policy.php`

```php
<?php
/**
 * Automated Data Retention & Deletion Policy
 * GDPR Compliant - Auto-delete old data after retention period
 */

class AF_Data_Retention_Policy {
    
    const RETENTION_PERIODS = [
        'user_deletion_grace_period' => 30 * DAY_IN_SECONDS,  // 30 days
        'invoice_retention' => 7 * 365 * DAY_IN_SECONDS,     // 7 years (tax requirement)
        'log_retention' => 90 * DAY_IN_SECONDS,              // 90 days
        'temp_files' => 7 * DAY_IN_SECONDS,                 // 7 days
    ];
    
    public function __construct() {
        add_action( 'af_hourly_maintenance', [ $this, 'run_retention_policy' ] );
    }
    
    /**
     * Run retention policy
     */
    public function run_retention_policy() {
        $this->delete_marked_user_data();
        $this->delete_old_logs();
        $this->delete_temp_files();
        $this->purge_old_transients();
    }
    
    /**
     * Delete user data marked for deletion (30-day grace)
     */
    private function delete_marked_user_data() {
        global $wpdb;
        
        $cutoff = time() - self::RETENTION_PERIODS['user_deletion_grace_period'];
        
        $users = $wpdb->get_results( $wpdb->prepare(
            "SELECT ID FROM {$wpdb->users} 
             INNER JOIN {$wpdb->usermeta} 
             ON {$wpdb->users}.ID = {$wpdb->usermeta}.user_id 
             WHERE meta_key = 'af_deletion_requested_at' 
             AND meta_value < %d",
            $cutoff
        ) );
        
        foreach ( $users as $user ) {
            wp_delete_user( $user->ID );
            error_log( "User {$user->ID} permanently deleted per GDPR retention policy" );
        }
    }
    
    /**
     * Delete old logs
     */
    private function delete_old_logs() {
        global $wpdb;
        
        $cutoff = time() - self::RETENTION_PERIODS['log_retention'];
        $table = $wpdb->prefix . 'af_logs';
        
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) ) {
            $wpdb->query( $wpdb->prepare(
                "DELETE FROM {$table} WHERE created_at < %d",
                $cutoff
            ) );
        }
    }
    
    /**
     * Delete temporary files (uploaded contracts pending deletion)
     */
    private function delete_temp_files() {
        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/af-temp/';
        
        if ( ! is_dir( $temp_dir ) ) return;
        
        $cutoff = time() - self::RETENTION_PERIODS['temp_files'];
        $files = glob( $temp_dir . '*' );
        
        foreach ( $files as $file ) {
            if ( filemtime( $file ) < $cutoff ) {
                unlink( $file );
            }
        }
    }
    
    /**
     * Purge old transients
     */
    private function purge_old_transients() {
        global $wpdb;
        
        // WordPress auto-deletes expired transients, but we can force purge old ones
        $wpdb->query( "DELETE FROM {$wpdb->options} 
            WHERE option_name LIKE '%_transient_timeout_af_%' 
            AND option_value < " . time() );
    }
}

new AF_Data_Retention_Policy();
```

**Programar ejecución**:
```php
// En arriendo-facil.php, agregar en init hook:
add_action( 'init', function() {
    if ( ! wp_next_scheduled( 'af_hourly_maintenance' ) ) {
        wp_schedule_event( time(), 'hourly', 'af_hourly_maintenance' );
    }
});
```

---

## 🟡 FASE 2: 1-2 SEMANAS

### [ ] 2.1 OPTIMIZAR IMÁGENES

```bash
# Instalar webp converter si no existe
brew install libwebp

# Convertir imágenes existentes
cd /Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil/wordpress/wp-content/themes/twentytwentyfive-child/assets/images/

# Logo
cwebp -q 80 logo-web-h.png -o logo-web-h.webp
cwebp -q 80 logo-full.png -o logo-full.webp

# Hero background (3 versions)
convert hero-bg.jpg -resize 420x height -quality 80 hero-bg-sm.jpg
convert hero-bg.jpg -resize 900x height -quality 82 hero-bg-md.jpg
cwebp -q 85 hero-bg-sm.jpg -o hero-bg-sm.webp
cwebp -q 85 hero-bg-md.jpg -o hero-bg-md.webp
cwebp -q 85 hero-bg.jpg -o hero-bg.webp
```

**Actualizar HTML** con `<picture>` elements
✅ **Código listo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 3.1

---

### [ ] 2.2 CORREGIR ACCESIBILIDAD

**Contraste de colores**:
```css
/* En design-tokens.css */
--color-text-secondary: #5a5a5a;  /* Was #9e9e9e */
```

**Añadir Aria labels y navegación**:
✅ **Código listo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 3.2

**Testing**:
```bash
npm install -g axe-cli
axe https://development.arriendofacil.net
# Esperado: 0 violations
```

---

### [ ] 2.3 COMPLETAR VALIDACIÓN CONTACT FORM

✅ **Código listo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 3.3

**Pasos**:
1. [ ] Agregar honeypot y validación client-side
2. [ ] Crear handler server-side con rate limiting
3. [ ] Verificar anti-spam
4. [ ] Test manualmente

---

### [ ] 2.4 AGREGAR TESTS AUTOMATIZADOS

**Framework**: PHPUnit (ya configurado)

✅ **Código de ejemplo** - Ver `AUDIT-INTEGRAL-2026-10.md` Sección 2.1 (PasswordResetTest)

**Ejecutar tests**:
```bash
cd /Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil/wordpress/wp-content/plugins/arriendo-facil-main/
phpunit
# Meta: > 70% coverage
```

---

## 📋 VERIFICACIÓN PRE-LANZAMIENTO

### [ ] 3.1 Penetration Testing
- [ ] Ejecutar `validate-security.sh`
- [ ] 0 vulnerabilidades críticas
- [ ] Rate limiting funciona
- [ ] CSRF protection activa

### [ ] 3.2 Performance
- [ ] LCP < 2.5s
- [ ] FCP < 1.8s
- [ ] CLS < 0.1
- [ ] Lighthouse > 90

### [ ] 3.3 Compliance
- [ ] Privacy Policy accesible
- [ ] Terms & Conditions accesible
- [ ] Cookie consent banner activo
- [ ] GDPR data deletion endpoint funciona
- [ ] PrivacyManifest.json presente

### [ ] 3.4 Formularios
- [ ] Login: Funcional, rate limited
- [ ] Registration (owner/tenant): Validado 100%
- [ ] Password reset: Funcional, secure
- [ ] Contact form: Spam-protected
- [ ] Billing forms: PCI compliant

### [ ] 3.5 API
- [ ] Todos endpoints documentados
- [ ] Rate limiting en lugar
- [ ] Headers de seguridad presentes
- [ ] Autenticación verificada
- [ ] Logs seguros

### [ ] 3.6 Accesibilidad
- [ ] WCAG 2.1 AA compliant
- [ ] Teclado navegable
- [ ] Screen reader compatible
- [ ] Mobile responsive

---

## 🚀 DEPLOYMENT

```bash
# 1. Backup completo
wp db export /backups/production-2026-10-07.sql
tar -czf /backups/uploads-2026-10-07.tar.gz wp-content/uploads/

# 2. Deploy Phase 2 changes to staging
git commit -m "Phase 2: Security hardening + compliance"
git push origin staging

# 3. Staging validation
# - Run all tests
# - Verify functionality
# - Performance check

# 4. Deploy to production
git push origin main

# 5. Post-deployment verification
curl https://arriendofacil.net/wp-json/af/v1/health
# Esperado: { "status": "ok" }
```

---

## 📞 CONTACTO SOPORTE

- **Security Issues**: security@arriendofacil.net
- **Legal/Compliance**: legal@arriendofacil.net
- **Support**: support@arriendofacil.net

---

**Documento**: Checklist de Implementación  
**Versión**: 1.0  
**Fecha**: 2026-10-07
