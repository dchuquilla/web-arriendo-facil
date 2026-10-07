# 🚀 PLAN DE EJECUCIÓN - FASE INMEDIATA

**Proyecto**: Arriendo Fácil  
**Fase**: INMEDIATA (Hoy - 24 horas)  
**Fecha Inicio**: 2026-10-07 12:03 UTC  
**Deadline**: 2026-10-08 12:00 UTC  
**Duración Estimada**: 4-6 horas  

---

## 📋 CHECKLIST DE EJECUCIÓN INMEDIATA

### ✅ TAREA 1: Revocar Credenciales Cloudflare (20 min)

**Prioridad**: 🔴 CRÍTICA  
**Complejidad**: Bajo  
**Riesgo**: Bajo  

**Pasos**:
1. [ ] Acceder a https://dash.cloudflare.com/
2. [ ] Ir a: Profile (esquina arriba derecha) → API Tokens
3. [ ] Buscar token: `cfat_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX`
4. [ ] Clic en token → Actions → "Roll" o "Revoke"
5. [ ] Seleccionar "Revoke" → Confirmar
6. [ ] **Crear NUEVO token**:
   - [ ] Clic en "+ Create Token"
   - [ ] Buscar template "Edit Cloudflare Workers" o "R2 Tokens"
   - [ ] Seleccionar permisos:
     - [ ] R2 → Edit
     - [ ] R2 → Read
   - [ ] Account Scope (o específico a arriendo-facil)
   - [ ] Copiar nuevo token (formato: `cfat_...`)
   
7. [ ] **Guardar en .env local** (NUNCA en git):
```bash
# .env (local, NO commitear)
CLOUDFLARE_API_TOKEN=cfat_[NUEVO_TOKEN_AQUI]
R2_ENDPOINT=https://[ACCOUNT_ID].r2.cloudflarestorage.com
R2_BUCKET=arriendo-facil
R2_REGION=auto
```

8. [ ] **Actualizar en config (si aplica)**:
```php
// wordpress/wp-content/plugins/arriendo-facil-main/config/security-config.php
// Línea con: define('CLOUDFLARE_API_TOKEN', ...);
// Cambiar a: define('CLOUDFLARE_API_TOKEN', getenv('CLOUDFLARE_API_TOKEN') ?: '' );
```

9. [ ] **Verificar funcionamiento**:
```bash
# Test conexión a R2
curl -H "Authorization: Bearer [NUEVO_TOKEN]" \
  https://api.cloudflare.com/client/v4/user/tokens/verify
# Esperado: { "result": { "status": "active" } }
```

10. [ ] **Confirmación**:
```bash
echo "✅ Cloudflare token revocado y renovado"
```

---

### ✅ TAREA 2: Revocar Credenciales AWS (20 min)

**Prioridad**: 🔴 CRÍTICA  
**Complejidad**: Bajo  
**Riesgo**: Bajo  

**Pasos**:
1. [ ] Acceder a https://console.aws.amazon.com/iamv2/
2. [ ] Menú izquierdo → "Users"
3. [ ] Encontrar usuario que tiene la Access Key: `AKIAIOSFODNN7EXAMPLE...`
4. [ ] Clic en usuario → Pestaña "Security credentials"
5. [ ] Buscar la Access Key antigua
6. [ ] **Primero: DEACTIVATE (NO DELETE YET)**
   - [ ] Clic en el ID de la key
   - [ ] "Deactivate" → Confirmar
   - [ ] Esperar 5-10 minutos
   
7. [ ] **Verificar que la aplicación sigue funcionando con tokens viejos** (si es 2FA/roles, puede ya estar sin acceso)

8. [ ] **Crear NUEVA Access Key**:
   - [ ] Clic "+ Create access key"
   - [ ] Seleccionar: "Application running outside AWS"
   - [ ] Copiar Access Key ID y Secret Access Key (SOLO AHORA, no se puede ver después)
   - [ ] Guardar en .env local (NUNCA en git)

9. [ ] **Guardar en .env local**:
```bash
# .env (local, NO commitear)
AWS_ACCESS_KEY_ID=[NUEVA_ACCESS_KEY]
AWS_SECRET_ACCESS_KEY=[NUEVO_SECRET_KEY]
AWS_REGION=us-east-1
AWS_S3_BUCKET=arriendo-facil
```

10. [ ] **Actualizar en aplicación**:
```php
// wordpress/wp-content/plugins/arriendo-facil-main/config/security-config.php
// Cambiar todos los define de AWS a getenv()
define('AWS_ACCESS_KEY_ID', getenv('AWS_ACCESS_KEY_ID') ?: '');
```

11. [ ] **Verificar funcionamiento**:
```bash
# Test conexión a AWS S3 con nueva key
aws s3 ls --profile default
# Esperado: Listing de buckets
```

12. [ ] **Volver a AWS y ELIMINAR la key antigua**:
   - [ ] Clic en key deactivada
   - [ ] "Delete" → Confirmar
   
13. [ ] **Confirmación**:
```bash
echo "✅ AWS keys revocadas y renovadas"
```

---

### ✅ TAREA 3: Auditar Acceso No Autorizado (30 min)

**Prioridad**: 🔴 CRÍTICA  
**Complejidad**: Medio  
**Riesgo**: Bajo  

**PARTE 1: Cloudflare R2 Logs**

1. [ ] Acceder a https://dash.cloudflare.com/
2. [ ] R2 → Seleccionar bucket "arriendo-facil"
3. [ ] Pestaña "Logs" (si está disponible)
4. [ ] Filtrar por fecha: 2026-03-24 a 2026-10-07
5. [ ] Revisar:
   - [ ] **ListBucket**: ¿Cuántos? ¿De dónde?
   - [ ] **GetObject**: ¿Qué archivos? ¿Cuántas descargas?
   - [ ] **PutObject**: ¿Se crearon/modificaron archivos?
   - [ ] **DeleteObject**: ¿Se borraron archivos?
   - [ ] **IPs únicas**: ¿Están todas desde tu oficina/IP?
   - [ ] **User agents**: ¿Están todos identificados?

6. [ ] **Documentar hallazgos**:
```bash
cat > /tmp/r2-audit.txt << 'EOF'
Período: 2026-03-24 a 2026-10-07
Auditor: [Tu nombre]
Fecha auditoría: 2026-10-07

Listados (ListBucket):    [# o "ninguno"]
Descargas (GetObject):    [# o "ninguno"]
Uploads (PutObject):      [# o "ninguno"]
Borrados (DeleteObject):  [# o "ninguno"]
IPs únicas:              [Listar]
Acceso sospechoso:       [ ] Sí [ ] No

Conclusión:
□ Sin actividad sospechosa
□ Actividad moderada de lectura (normal para backup/restore)
□ Actividad sospechosa detectada ⚠️
EOF
cat /tmp/r2-audit.txt
```

**PARTE 2: AWS CloudTrail**

1. [ ] Acceder a https://console.aws.amazon.com/cloudtrail
2. [ ] Event history (lado izquierdo)
3. [ ] Filtrar por:
   - [ ] Access Key: `AKIAIOSFODNN7EXAMPLE...`
   - [ ] Rango de fecha: 2026-03-24 a 2026-10-07
   
4. [ ] Revisar eventos:
   - [ ] **s3:ListBucket**: ¿Frecuencia?
   - [ ] **s3:GetObject**: ¿Qué se descargó?
   - [ ] **s3:PutObject**: ¿Qué se subió?
   - [ ] **s3:DeleteObject**: ¿Qué se borró?
   - [ ] Source IPs: ¿Todas conocidas?
   - [ ] User Agent: ¿Aplicaciones conocidas?

5. [ ] **Documentar**:
```bash
cat > /tmp/cloudtrail-audit.txt << 'EOF'
AWS CloudTrail Audit Report
Access Key: AKIA...EXAMPLE
Período: 2026-03-24 a 2026-10-07

Total eventos:           [#]
s3:GetObject:           [#]
s3:ListBucket:          [#]
s3:PutObject:           [#]
s3:DeleteObject:        [#]

Datos sensibles accedidos:
□ Contratos de inquilinos
□ Información de propiedades
□ Datos financieros
□ Otros: [especificar]

Riesgo evaluado:
[ ] Bajo - Solo lecturas, datos no sensibles
[ ] Medio - Múltiples operaciones, revisar datos
[ ] Alto - Borrados o modificaciones detectadas ⚠️

Acción recomendada: [especificar]
EOF
cat /tmp/cloudtrail-audit.txt
```

6. [ ] **Guardar reportes**:
```bash
# Guardar en directorio de audit
mkdir -p /Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil/security-audits/2026-10-07/
cp /tmp/r2-audit.txt /Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil/security-audits/2026-10-07/
cp /tmp/cloudtrail-audit.txt /Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil/security-audits/2026-10-07/
```

---

### ✅ TAREA 4: Notificar a Proveedores (15 min)

**Prioridad**: 🔴 CRÍTICA  
**Complejidad**: Bajo  
**Riesgo**: Bajo  

**Email 1: Cloudflare Security**

Para: security@cloudflare.com

```
Subject: URGENT - Exposed API Token Notification - cfat_XXXXXXXX...

Dear Cloudflare Security Team,

We discovered an API token was accidentally exposed in our public GitHub repository.

DETAILS:
Token Format:          cfat_* (Cloudflare API Token)
Exposure Duration:     March 24, 2026 - October 7, 2026 (6+ months)
Discovery Date:        October 7, 2026, 12:00 UTC
Action Taken:          Revoked at [HH:MM UTC] on October 7, 2026
Permissions:           R2 Storage, possibly Account-level

REMEDIATION COMPLETED:
✅ Token revoked
✅ New token generated
✅ GitHub history cleaned (filter-branch)
✅ Access logs reviewed (see audit report attached)

REQUEST:
Please review Cloudflare access logs for the exposure period and advise if any 
unauthorized access was detected.

AUDIT FINDINGS:
[Paste findings from /tmp/r2-audit.txt]

CONTACT:
Name:    [Tu nombre]
Email:   [Tu email]
Phone:   [Tu teléfono]
Company: [Tu company]

Regards,
Arriendo Fácil Security Team
```

- [ ] Enviar email
- [ ] Guardar confirmación de recepción
- [ ] Anotar fecha/hora de respuesta esperada (24-48h)

**Email 2: AWS Security**

Para: abuse@aws.amazon.com

```
Subject: URGENT - Exposed AWS Access Keys Notification

Dear AWS Security Team,

We discovered AWS Access Keys were accidentally exposed in our public GitHub repository.

DETAILS:
Access Key ID:         AKIAIOSFODNN7EXAMPLE (redacted)
Secret Key Pattern:    SHA256-like format
Exposure Duration:     March 24, 2026 - October 7, 2026 (6+ months)
Discovery Date:        October 7, 2026, 12:00 UTC
Action Taken:          Deactivated → Deleted
Permissions:           S3, Cloudflare R2 (likely account-level)

REMEDIATION COMPLETED:
✅ Access Key deactivated (October 7, 2026 12:20 UTC)
✅ Access Key deleted (after verification of new key)
✅ New Access Key generated
✅ GitHub history cleaned
✅ CloudTrail logs reviewed

AUDIT FINDINGS:
[Paste findings from /tmp/cloudtrail-audit.txt]

REQUEST:
Please review CloudTrail logs for suspicious activity during the exposure period.
Particularly check for:
- Unauthorized S3 bucket access
- Data exfiltration attempts
- Resource modifications
- Cross-account access attempts

CONTACT:
Name:    [Tu nombre]
Email:   [Tu email]
Phone:   [Tu teléfono]

Regards,
Arriendo Fácil Security Team
```

- [ ] Enviar email
- [ ] Guardar confirmación
- [ ] Seguimiento en 48h

---

### ✅ TAREA 5: Deshabilitar WP_DEBUG en Producción (5 min)

**Prioridad**: 🔴 CRÍTICA  
**Complejidad**: Muy bajo  
**Riesgo**: Muy bajo  

**Ubicación**: `wordpress/wp-config.php` líneas 96-98

1. [ ] Abrir archivo:
```bash
nano wordpress/wp-config.php
```

2. [ ] Encontrar (línea ~96):
```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

3. [ ] Cambiar a:
```php
// Development
if ( defined( 'WP_ENV' ) && 'development' === WP_ENV ) {
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
} else {
    // Production
    define( 'WP_DEBUG', false );
    define( 'WP_DEBUG_LOG', false );
}
define( 'WP_DEBUG_DISPLAY', false );
```

4. [ ] O más simple (si no usas WP_ENV):
```php
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
```

5. [ ] Guardar y verificar:
```bash
# Test en producción
curl https://arriendofacil.net/wordpress/wp-content/debug.log
# Esperado: 404 Not Found o 403 Forbidden (NO 200)
```

6. [ ] Commit:
```bash
git add wordpress/wp-config.php
git commit -m "security: Disable WP_DEBUG in production"
git push origin main
```

---

### ✅ TAREA 6: Activar Cookie Consent Banner (10 min)

**Prioridad**: 🔴 CRÍTICA  
**Complejidad**: Bajo  
**Riesgo**: Bajo  

**Plugin**: Complianz GDPR (ya instalado)

1. [ ] Admin panel: https://arriendofacil.net/wp-admin/
2. [ ] Menú izquierdo → Complianz
3. [ ] Settings → Cookies
4. [ ] **Configurar Banner**:
   - [ ] Enable Cookie Banner: ✅ YES
   - [ ] Banner Position: "Bottom" (recomendado)
   - [ ] Banner Text: "Utilizamos cookies para mejorar tu experiencia. Más info: [Política de Privacidad]"
   - [ ] Accept Button: "Aceptar" o "Accept All"
   - [ ] Decline Button: "Rechazar" o "Decline"
   - [ ] More Info Button: "Más info"
   - [ ] Link to Privacy Policy: [URL a /privacy-policy/]

5. [ ] Verificar en frontend (anónimo):
```bash
# En navegador anónimo (incógnito), ir a:
https://arriendofacil.net

# Debe aparecer banner en parte inferior
# Con botones de Aceptar/Rechazar
```

6. [ ] Test de funcionalidad:
   - [ ] Clic "Aceptar" → Cookies guardadas, banner desaparece
   - [ ] Recarga página → Banner no aparece (cookie persiste)
   - [ ] Limpiar cookies → Banner reaparece
   - [ ] Clic "Más info" → Abre Privacy Policy

---

### ✅ TAREA 7: Verificación Final (10 min)

**Prioridad**: 🟡 IMPORTANTE  
**Complejidad**: Bajo  
**Riesgo**: Muy bajo  

**Checklist de Verificación**:
```bash
# 1. Credenciales revocadas
[ ] Cloudflare token revocado y renovado
[ ] AWS keys revocados y renovados

# 2. Acceso auditado
[ ] Logs de R2 revisados (sin actividad sospechosa)
[ ] CloudTrail revisado (sin actividad sospechosa)

# 3. Historial limpiado
[ ] Git history limpiado y pushed a GitHub
[ ] Backup .git.backup/ disponible

# 4. Configuración segura
[ ] WP_DEBUG deshabilitado en producción
[ ] Cookie banner activado
[ ] Debug log protegido (.htaccess)

# 5. Documentación
[ ] GIT_CLEANUP_REPORT.md creado
[ ] Audits guardados en security-audits/
[ ] Notificaciones enviadas a proveedores

# 6. Equipo notificado
[ ] DevOps notificado
[ ] Team Slack/Email enviado
[ ] Documentación compartida

# Estado:
[ ] LISTO PARA FASE 1
```

---

## 🎯 RESUMEN DE ESTA FASE

| Tarea | Tiempo | Status |
|-------|--------|--------|
| 1. Revocar Cloudflare | 20 min | ⏳ |
| 2. Revocar AWS | 20 min | ⏳ |
| 3. Auditar acceso | 30 min | ⏳ |
| 4. Notificar proveedores | 15 min | ⏳ |
| 5. Deshabilitar WP_DEBUG | 5 min | ⏳ |
| 6. Activar cookie banner | 10 min | ⏳ |
| 7. Verificación final | 10 min | ⏳ |
| **TOTAL** | **110 min (1h50m)** | ⏳ |

---

## 📞 SOPORTE DURANTE ESTA FASE

Si necesitas ayuda:
1. Revisa: `QUICK_REFERENCE.md`
2. Más detalles: `AUDIT-INTEGRAL-2026-10.md` Sección 1
3. Contacta: security@arriendofacil.net

---

## ✅ DESPUÉS DE COMPLETAR

Una vez terminada esta fase:
1. [ ] Crear archivo: `PHASE_IMMEDIATE_COMPLETE.md` con fecha/hora
2. [ ] Notificar al equipo en Slack
3. [ ] Prepararse para FASE 1 (3-5 días):
   - [ ] Password Reset API
   - [ ] GDPR Data Deletion
   - [ ] Validaciones completas
   - [ ] Tests automatizados

---

**Plan creado**: 2026-10-07 12:03 UTC  
**Deadline**: 2026-10-08 12:00 UTC  
**Estado**: 🟡 LISTO PARA COMENZAR  

**Siguiente paso**: Ejecutar Tarea 1 (Revocar Cloudflare)
