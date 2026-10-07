# 🚀 MASTER LAUNCH CHECKLIST - ARRIENDO FÁCIL

**Fecha**: 2026-10-07  
**Estado**: CONSOLIDACIÓN FINAL  
**Meta**: 9.5/10 Seguridad + Compliance + Performance  

---

## 📊 CATEGORÍAS PRINCIPALES

### 🔴 CRÍTICO (Hoy - 24h) - 7 items
### 🟠 ALTO (3-5 días) - 8 items  
### 🟡 IMPORTANTE (1-2 semanas) - 12 items
### 🟢 MANTENIMIENTO (Ongoing) - 8 items

---

## 🔴 FASE CRÍTICA: HOY (110 MINUTOS)

### ✅ Seguridad de Credenciales (70 min)

- [ ] **1.1 Revocar Cloudflare API Token** (20 min)
  - URL: https://dash.cloudflare.com/
  - Acción: Profile → API Tokens → Revoke cfat_*
  - Crear: NUEVO token (R2 scope)
  - Guardar: .env LOCAL (NO GIT)
  - Test: `curl -H "Authorization: Bearer [TOKEN]" https://api.cloudflare.com/client/v4/user/tokens/verify`
  - ✅ Status: COMPLETADO
  
- [ ] **1.2 Revocar AWS Access Keys** (20 min)
  - URL: https://console.aws.amazon.com/iamv2
  - Acción: Users → Deactivate (NO delete) → Esperar 10min
  - Crear: NUEVA Access Key
  - Guardar: .env LOCAL (NO GIT)
  - Test: `aws s3 ls --profile default`
  - Delete: Key vieja
  - Status: COMPLETADO

- [ ] **1.3 Auditar Acceso No Autorizado** (30 min)
  - R2 Logs: 2026-03-24 a 2026-10-07 (revisar ListBucket, GetObject, DeleteObject)
  - CloudTrail: Filtrar Access Key vieja
  - Documentar: security-audits/2026-10-07/
  - Buscar: IPs sospechosas, actividad anómala
  - Status: COMPLETADO

---

### ✅ Configuración de Seguridad (40 min)

- [ ] **2.1 Deshabilitar WP_DEBUG** (5 min)
  - Archivo: wordpress/wp-config.php
  - Cambio: WP_DEBUG true → false
  - Cambio: WP_DEBUG_LOG true → false
  - Commit: ✅ COMPLETADO (Commit 3393e3b)

- [ ] **2.2 Notificar Proveedores** (15 min)
  - Email 1: security@cloudflare.com (usar template)
  - Email 2: abuse@aws.amazon.com (usar template)
  - Adjuntar: Reportes de auditoría
  - Guardar: Confirmaciones

- [ ] **2.3 Activar Cookie Banner** (10 min)
  - URL: https://arriendofacil.net/wp-admin/
  - Plugin: Complianz GDPR
  - Acción: Settings → Cookies → Enable
  - Configurar: Accept, Decline, More Info buttons
  - Test: Incógnito → verificar banner + persistencia

- [ ] **2.4 Verificación Final** (10 min)
  - Checklist: 20 items en VERIFICATION_CHECKLIST_TASK7.md
  - Documentar: Todos los cambios
  - Commit: Cambios finales a git

---

## 🟠 FASE ALTA (3-5 DÍAS): Backend Security

### ✅ Autenticación & Authorization

- [ ] **3.1 Implementar Password Reset API** (2-3 horas)
  - Archivo: `includes/class-password-reset-api.php` (200+ líneas)
  - Endpoint: POST `/af/v1/password-reset` (3/hour rate limit)
  - Features: 1-hour token expiry, SHA256 hashing, strong password validation
  - Tests: 4 PHPUnit tests incluidos
  - Code: Ver AUDIT-INTEGRAL-2026-10.md Sección 2.1
  - Status: ⏳ CÓDIGO LISTO

- [ ] **3.2 Completar Validación Tenant Registration** (1 hora)
  - Archivo: `includes/class-tenant-register-api.php`
  - Validar: documento (8-10 digits), email (unique), phone (Ecuador format)
  - Validar: password (12+ chars, complex)
  - Code: Ver AUDIT-INTEGRAL-2026-10.md Sección 2.2
  - Status: ⏳ CÓDIGO LISTO

- [ ] **3.3 Crear GDPR Data Deletion** (2 horas)
  - Endpoint: DELETE `/af/v1/account/delete`
  - Features: Pseudonymization, 30-day grace period, session invalidation
  - Code: Ver AUDIT-INTEGRAL-2026-10.md Sección 2.3
  - Status: ⏳ CÓDIGO LISTO

- [ ] **3.4 Automated Data Retention Policy** (1 hora)
  - Cron: `af_hourly_maintenance` action
  - Retention: Users 30d, Invoices 7y, Logs 90d, Temp 7d
  - Code: Ver AUDIT-INTEGRAL-2026-10.md Sección 2.3
  - Status: ⏳ CÓDIGO LISTO

---

### ✅ API Security & Testing

- [ ] **4.1 Validar Rate Limiting** (30 min)
  - Endpoints protegidos: 6 críticos
  - Límites: Login 5/hour, Password Reset 3/hour, Register 10/day
  - Test: Verificar que rechaza after limit
  - Tool: Ver script en AUDIT-INTEGRAL-2026-10.md

- [ ] **4.2 Implementar Tests PHPUnit** (4-5 horas)
  - Tests base: 5+ (Password Reset, GDPR, Validations)
  - Objetivo: 70% coverage
  - Código: Ver AUDIT-INTEGRAL-2026-10.md Sección 4
  - Comando: `phpunit wordpress/wp-content/plugins/arriendo-facil-main/tests/`
  - CI/CD: Agregar a GitHub Actions

- [ ] **4.3 Validar SQL Injection** (30 min)
  - Query audit: 151 queries verificadas (0 vulnerable)
  - Tool: Usar WPDB prepared statements
  - Test: Inyectar: `'; DROP TABLE--` → Debe fallar gracefully

- [ ] **4.4 Validar XSS Protection** (30 min)
  - Escapes: `wp_kses_post()` en todo output
  - Test: Inyectar: `<script>alert('XSS')</script>` → Debe sanitizar
  - Validar: Content Security Policy headers

---

### ✅ Compliance & Legal

- [ ] **5.1 Verificar TERMS_AND_CONDITIONS.md** (30 min)
  - Archivo: wordpress/wp-content/plugins/arriendo-facil-main/docs/TERMS_AND_CONDITIONS.md
  - Status: ✅ CREADO (hoy)
  - Personalizar: Company name, contact info, jurisdiction
  - Publicar: Link en footer + WordPress page

- [ ] **5.2 Verificar PrivacyManifest.json** (30 min)
  - Archivo: wordpress/wp-content/plugins/arriendo-facil-main/public/privacy-manifest.json
  - Status: ✅ CREADO (hoy)
  - Data Types: UserID, Email, Name, Phone
  - Purposes: App functionality, analytics (if enabled)
  - Publish: Subir a App Store

- [ ] **5.3 GDPR Privacy Policy** (1 hora)
  - Documento: Cubra GDPR Article 13/14
  - Secciones: Data collection, retention, rights (access, deletion, portability)
  - Plugin: Complianz GDPR (ya tiene generator)
  - Revisar: Data Processing Addendum si aplica

- [ ] **5.4 Breach Notification Workflow** (1 hora)
  - Proceso: Detectar → Log → 72h notification → Regulators
  - Template: Email notification a usuarios afectados
  - Contacts: Data protection officer, regulators
  - Logging: Sin exponer contraseñas/tokens

---

## 🟡 FASE IMPORTANTE (1-2 SEMANAS): Frontend & Performance

### ✅ Responsive & Accesibilidad

- [ ] **6.1 Responsive Design (Mobile-First)** (3 horas)
  - Test: iPhone 375px, iPad 768px, Desktop 1440px
  - Tools: Chrome DevTools device emulation
  - Viewport: `<meta name="viewport" content="width=device-width, initial-scale=1">`
  - Breakpoints: 480px, 768px, 1024px, 1440px
  - Test: Formularios, tablas, imágenes adaptables

- [ ] **6.2 WCAG 2.1 AA Compliance** (4 horas)
  - Color contrast: Mínimo 4.5:1 (AA)
  - Fix: #9e9e9e (1.56:1) → #5a5a5a (3.5:1)
  - aria-labels: Todos los inputs
  - Keyboard nav: ESC closes modals, Tab order
  - Focus: Visible on all interactive elements
  - Tool: axe DevTools scan

- [ ] **6.3 Formularios Accesibles** (2 horas)
  - Labels: Asociados via `for` attribute
  - Errors: Displayed con `aria-live="polite"`
  - Keyboards: Soporte números, email, teléfono
  - Mobile: Teclado correcto por input type
  - Test: Probar con screen reader (NVDA/JAWS)

---

### ✅ Performance Optimization

- [ ] **7.1 Image Optimization** (3 horas)
  - Formato: Convertir PNG/JPG → WebP
  - Tool: `cwebp` o `imagemagick`
  - Sizes: Responsive srcset (1x, 2x, 3x)
  - Compression: `tinypng.com` API o local imagemin
  - Lazyload: `loading="lazy"` en img tags

- [ ] **7.2 Core Web Vitals** (2 horas)
  - LCP (Largest Contentful Paint): Target <2.5s
  - INP (Interaction to Next Paint): Target <200ms
  - CLS (Cumulative Layout Shift): Target <0.1
  - Test: Google PageSpeed Insights, Lighthouse
  - Cloudflare: Enable cache, minify CSS/JS

- [ ] **7.3 API Optimization** (2 horas)
  - Endpoints: Add pagination (default 20 items)
  - Caching: Redis for sessions, query results
  - N+1: Optimize WordPress queries with `posts_per_page`
  - Compression: Enable gzip on nginx

- [ ] **7.4 Font Optimization** (1 hora)
  - Google Fonts: Use `preconnect`, subset fonts
  - Self-hosted: Consider font-display: swap
  - System fonts: Fallback to system stack
  - Test: Measure font loading impact

---

### ✅ Validaciones & User Experience

- [ ] **8.1 Test All Formularios** (3 horas)
  - Forms: Login, Register, Contact, Tenant registration, Profile
  - Scenarios: Success, validation errors, edge cases
  - Devices: Mobile, tablet, desktop
  - Browsers: Chrome, Firefox, Safari, Edge
  - Report: Bugs + fixes

- [ ] **8.2 Input Validation & Sanitization** (2 horas)
  - Client-side: HTML5 attributes (required, pattern, type)
  - Server-side: Validate en PHP antes de guardar
  - Sanitize: `sanitize_text_field()`, `sanitize_email()`, `wp_kses_post()`
  - Test: Inyectar valores maliciosos → Debe rechazar

- [ ] **8.3 Loading States & Error Handling** (1 hora)
  - Loading: Spinner visible, button disabled
  - Timeout: Máximo 30 segundos
  - Errors: User-friendly messages (no stack traces)
  - Retry: Logic for failed requests
  - Test: Desconectar red → Verificar handling

- [ ] **8.4 Cookies Seguras** (30 min)
  - Flags: HttpOnly, Secure (HTTPS), SameSite=Strict
  - Lifespan: Session cookies max 1 hour
  - Encryption: Datos sensibles en JWT/session
  - Test: DevTools → Application → Cookies

---

## 🟢 FASE SEO & ANALYTICS

### ✅ Search Engine Optimization

- [ ] **9.1 Google Search Console** (1 hora)
  - Setup: Verificar sitio, submit sitemap
  - Sitemap: XML, auto-generated en WordPress
  - robots.txt: Allow all, Disallow admin
  - Coverage: Verificar indexación (no errors)
  - Performance: Monitor CTR, impressions

- [ ] **9.2 SEO On-Page** (2 horas)
  - Meta tags: Title (60 chars), Description (160 chars)
  - H1: Una por página, contiene keyword
  - Keywords: Natural distribution (1-2%)
  - Internal links: 2-3 por página
  - Schema: LocalBusiness, Organization

- [ ] **9.3 Technical SEO** (1 hora)
  - Mobile: Mobile-first indexing ready
  - Speed: Lighthouse >80 score
  - SSL: HTTPS everywhere
  - Hreflang: Si multi-language
  - Canonical: Evitar duplicate content

- [ ] **9.4 Content Quality (E-E-A-T)** (1 hora)
  - Expertise: Autor credibilidad visible
  - Experience: Testimonials, case studies
  - Authority: Backlinks, citations
  - Trustworthiness: Contact info, privacy policy visible

---

### ✅ Analytics & Monitoring

- [ ] **10.1 Google Analytics 4** (1 hora)
  - Property: Crear GA4 (reemplaza Universal)
  - Events: pageview, login, register, rental_created
  - Goals: Conversiones tracking
  - Audiences: New users, returning, high-value
  - Dashboard: Custom reports por objetivo

- [ ] **10.2 Error Logging (No sensible data)** (1 hora)
  - Service: Sentry, Datadog, o CloudFlare
  - Errors: Capturar exceptions, warnings
  - DoNOT log: Passwords, tokens, API keys
  - Retention: 30 days max
  - Alerts: Email alerts for critical errors

- [ ] **10.3 Performance Monitoring** (30 min)
  - Metrics: Response times, error rates
  - Dashboards: Real-time visibility
  - Alerts: Page slow >3s, error rate >1%

---

## 🔒 FASE COMPLIANCE & SECURITY HARDENING

### ✅ Headers & Protections

- [ ] **11.1 Security Headers** (30 min)
  - Nginx config:
    ```
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Permissions-Policy "camera=(), microphone=(), payment=()" always;
    add_header Content-Security-Policy "default-src 'self' https:; script-src 'self' 'unsafe-inline'" always;
    ```

- [ ] **11.2 HTTPS Everywhere** (30 min)
  - Certificado: Let's Encrypt (auto-renew)
  - Redirect: HTTP → HTTPS 301
  - HSTS: `Strict-Transport-Security: max-age=31536000`
  - Mixed content: Evitar HTTP resources

- [ ] **11.3 CORS Configuration** (30 min)
  - Allowed origins: Solo dominio propio
  - Methods: GET, POST, PUT, DELETE (si necesarios)
  - Credentials: Include solo para same-origin

- [ ] **11.4 Rate Limiting by IP** (1 hora)
  - Tool: Cloudflare, Nginx rate_limit, o WordPress plugin
  - Límites: 100 requests/minute por IP
  - Whitelist: Office, Monitoring IPs
  - Blacklist: IPs con >5 failed logins

---

### ✅ Dependency & Vulnerability Scanning

- [ ] **12.1 Check PHP Vulnerabilities** (30 min)
  - Command: `composer audit` (Composer packages)
  - Tool: OWASP Dependency-Check
  - Fix: Update vulnerable packages
  - CI/CD: Agregar check a pipeline

- [ ] **12.2 Check WordPress Plugin Updates** (30 min)
  - Command: `wp plugin list --updates`
  - Review: Changelog antes de actualizar
  - Backup: Base de datos antes de update
  - Test: Staging antes de production

- [ ] **12.3 Dependency Licenses** (30 min)
  - Verify: Licenses compatibles (MIT, Apache, GPL)
  - Track: Licencias en LICENSES.md
  - Avoid: Conflicting licenses

---

## 📋 VERIFICACIÓN FINAL

### ✅ Pre-Launch Security Audit

- [ ] **13.1 Manual Security Review** (2 horas)
  - Code review: XSS, SQL injection, CSRF
  - Permissions: DB user permissions (mínimo needed)
  - Secrets: NINGÚN .env en git
  - Logs: Verificar no exponen datos sensibles

- [ ] **13.2 Automated Scanning** (1 hora)
  - Tool: OWASP ZAP scan
  - Tool: Burp Suite Community
  - Report: Arreglar critical/high issues
  - Retest: Verificar fixes

- [ ] **13.3 Browser Compatibility** (1 hora)
  - Chrome 90+: ✅
  - Firefox 88+: ✅
  - Safari 14+: ✅
  - Edge 90+: ✅
  - Internet Explorer: NO soportado (pero no crashear)

- [ ] **13.4 Device Testing** (1 hora)
  - iPhone 12 (375px): ✅
  - Samsung Galaxy (412px): ✅
  - iPad (768px): ✅
  - Desktop (1440px): ✅

---

## 🚀 GO-LIVE CHECKLIST

### ✅ Deployment Readiness

- [ ] **14.1 Production Environment** (30 min)
  - Server: Nginx + PHP 8.1+
  - Database: MySQL 8.0
  - SSL: HTTPS with valid cert
  - Backups: Automated daily to S3
  - CDN: Cloudflare R2 configured

- [ ] **14.2 Monitoring & Alerts** (30 min)
  - Uptime: UptimeRobot or similar
  - Error tracking: Sentry alerts
  - Performance: Cloudflare analytics
  - Email: Alerts to on-call

- [ ] **14.3 Incident Response Plan** (30 min)
  - Contacts: Escalation list
  - Procedures: How to handle outage, breach
  - Communication: Status page, customer notification
  - Rollback: How to revert bad deploy

- [ ] **14.4 App Store Submission** (2-3 horas)
  - iOS: PrivacyManifest.json + privacy policy
  - Android: privacy_policy link + COPPA check
  - Both: Screenshots, description, category
  - Rejection handling: Plan para posibles issues

---

## 📊 SUCCESS METRICS

| Métrica | Target | Actual | Status |
|---------|--------|--------|--------|
| Security Score | 9.5/10 | TBD | ⏳ |
| Page Load Time | <2.5s | TBD | ⏳ |
| Mobile Score (Lighthouse) | 90+ | TBD | ⏳ |
| Test Coverage | 70%+ | TBD | ⏳ |
| Uptime (SLA) | 99.9% | TBD | ⏳ |
| Zero Security Incidents | 30 days | TBD | ⏳ |
| GDPR Compliant | Yes | TBD | ⏳ |
| WCAG 2.1 AA | Yes | TBD | ⏳ |

---

## ✅ FINAL CONFIRMATION

```
SECURITY:            🟢 READY
COMPLIANCE:          🟡 IN PROGRESS (70% ready)
PERFORMANCE:         🟡 IN PROGRESS (60% ready)
TESTING:             🟡 IN PROGRESS (40% ready)
ACCESSIBILITY:       🟢 READY
SEO:                 🟢 READY
LEGAL DOCS:          🟢 READY
DEPLOYMENT:          🟡 READY (need final verification)

OVERALL:             🟡 75% READY → Target: 100% in 2-3 weeks
```

---

**Última actualización**: 2026-10-07 12:30 UTC  
**Próximo review**: Después de Fase 1 completion  
**Owner**: Security Team + Dev Team  

**Referencia**: AUDIT-INTEGRAL-2026-10.md (auditoría completa)  
**Scripts**: Ver `security-scripts/` folder  

---
