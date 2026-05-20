# Prompt: Implementar Endpoint REST para Registro de Propietarios

## Contexto
Se necesita un endpoint REST que reciba el formulario de registro de propietarios desde el frontend (wizard de 5 pasos). El frontend ya está implementado y envía un `POST` con `FormData` (incluye archivos PDF) a `/wp-json/af/v1/owner-register`.

## Endpoint a Crear

**Ruta:** `POST /wp-json/af/v1/owner-register`  
**Permission:** `__return_true` (público, sin autenticación requerida)  
**Content-Type:** `multipart/form-data`

## Parámetros del Request

### Campos de texto:
| Campo | Tipo | Requerido | Validación |
|-------|------|-----------|------------|
| `nonce` | string | Sí | `wp_verify_nonce($nonce, 'af_owner_register')` |
| `id_type` | string | Sí | Enum: `cedula`, `ruc`, `pasaporte` |
| `id_number` | string | Sí | Validar según tipo (ver abajo) |
| `fullname` | string | Sí | 2-120 chars, solo letras/espacios/acentos |
| `email` | string | Sí | `is_email()` + no duplicado en DB |
| `phone` | string | Sí | Formato: `09XXXXXXXX` o `0XXXXXXXXX` |
| `property_type_interest` | string | No | Enum: `apartment`, `house`, `office`, `room`, `commercial` |
| `message` | string | No | Max 1000 chars, `sanitize_textarea_field()` |
| `legal_agent_name` | string | No | Max 120 chars |
| `legal_agent_phone` | string | No | Formato teléfono válido |
| `legal_agent_email` | string | No | `is_email()` si proporcionado |

### Archivos:
| Campo | Requerido | Validación |
|-------|-----------|------------|
| `doc_cedula` | Sí | PDF, max 5MB, verificar magic bytes |
| `doc_ruc` | No | PDF, max 5MB, verificar magic bytes |
| `legal_agent_pdf` | No | PDF, max 5MB, verificar magic bytes |

## Validaciones Server-Side

### Cédula Ecuatoriana (10 dígitos):
```php
function validate_cedula($cedula) {
    if (strlen($cedula) !== 10 || !ctype_digit($cedula)) return false;
    $province = (int) substr($cedula, 0, 2);
    if ($province < 1 || $province > 24) return false;
    if ((int) $cedula[2] > 5) return false;
    
    $coefficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    $total = 0;
    for ($i = 0; $i < 9; $i++) {
        $digit = (int) $cedula[$i] * $coefficients[$i];
        if ($digit > 9) $digit -= 9;
        $total += $digit;
    }
    $check = (10 - ($total % 10)) % 10;
    return $check === (int) $cedula[9];
}
```

### RUC (13 dígitos):
```php
function validate_ruc($ruc) {
    if (strlen($ruc) !== 13 || !ctype_digit($ruc)) return false;
    if (substr($ruc, -3) !== '001') return false;
    $third = (int) $ruc[2];
    if ($third <= 5) return validate_cedula(substr($ruc, 0, 10));
    return true; // Tipo 6 (público) y 9 (jurídico) solo verificar formato
}
```

### Verificación de PDF (magic bytes):
```php
function is_valid_pdf($file_path) {
    $handle = fopen($file_path, 'rb');
    if (!$handle) return false;
    $header = fread($handle, 5);
    fclose($handle);
    return $header === '%PDF-';
}
```

## Rate Limiting

Implementar rate limiting por IP: máximo 3 registros por hora.

```php
function check_rate_limit() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'af_reg_limit_' . md5($ip);
    $attempts = (int) get_transient($transient_key);
    
    if ($attempts >= 3) {
        return false; // Bloqueado
    }
    
    set_transient($transient_key, $attempts + 1, HOUR_IN_SECONDS);
    return true;
}
```

## Upload de Archivos

- Directorio destino: `wp-content/uploads/af-private/owners/{user_id}/`
- Crear con `wp_mkdir_p()` si no existe
- Renombrar archivos: `{tipo}_{timestamp}_{random}.pdf` (ej: `cedula_1716220800_a3f2.pdf`)
- Añadir `.htaccess` al directorio `af-private/` con `Deny from all`
- Verificar MIME type con `wp_check_filetype()` además de magic bytes

## Flujo del Handler

1. Verificar nonce → 403 si falla
2. Verificar rate limit → 429 si excede
3. Validar campos requeridos → 400 con errores específicos
4. Validar formatos (cédula/RUC/email/teléfono) → 400
5. Verificar email no duplicado en `wp_af_owner_contacts` → 409
6. Subir archivos PDF de forma segura → 500 si falla
7. Crear usuario WP con `wp_insert_user()`:
   - `user_login` = email
   - `user_email` = email
   - `display_name` = fullname
   - `role` = 'af_owner'
8. Insertar en `wp_af_owner_contacts`:
   - `id_type` = id_type
   - `id_number` = id_number (encriptado si es posible)
   - `email` = email
   - `wp_user_id` = nuevo user ID
   - `subject` = fullname
   - `message` = message
   - `status` = 'pending'
   - `legal_agent_name`, `legal_agent_phone`, `legal_agent_email`
   - Paths de los PDFs en user meta
9. Enviar email de confirmación al owner
10. Enviar notificación al admin
11. Retornar `{ success: true, message: "..." }`

## Response Format

### Éxito (201):
```json
{
  "success": true,
  "message": "Tu solicitud ha sido registrada exitosamente. Te contactaremos en 24-48 horas."
}
```

### Error de validación (400):
```json
{
  "success": false,
  "message": "Error en los datos enviados.",
  "errors": {
    "id_number": "Cédula ecuatoriana inválida.",
    "email": "Este correo ya está registrado."
  }
}
```

### Rate limited (429):
```json
{
  "success": false,
  "message": "Has excedido el número máximo de intentos. Intenta en una hora."
}
```

## Seguridad (OWASP Top 10)

1. **Injection**: Usar `$wpdb->prepare()` para todas las queries
2. **Broken Auth**: Nonce verification, rate limiting
3. **XSS**: `sanitize_text_field()`, `sanitize_email()` en todos los inputs
4. **IDOR**: No exponer IDs en responses
5. **Security Misconfiguration**: PDFs fuera de acceso público, `.htaccess` deny
6. **Sensitive Data**: No loguear datos personales, HTTPS enforced
7. **CSRF**: Nonce WP
8. **File Upload**: Verificar MIME + magic bytes + tamaño + renombrar
9. **Logging**: `error_log()` solo con IP y timestamp en fallos
10. **SSRF**: N/A

## Archivo Sugerido

`plugins/arriendo-facil-main/includes/class-owner-registration-api.php`

Instanciar en el plugin principal:
```php
require_once plugin_dir_path(__FILE__) . 'includes/class-owner-registration-api.php';
new Arriendo_Facil_Owner_Registration_API();
```
