# SECURITY DEPLOYMENT CHECKLIST

**Environment**: [ ] Development [ ] Staging [ ] Production  
**Date**: ________  
**Deployed By**: ________  
**Verified By**: ________  

---

## PRE-DEPLOYMENT (Before pushing to production)

### Database & Credentials
- [ ] Create `.env` file from `.env.example`
- [ ] Set all required variables in `.env`
- [ ] Create MySQL user `af_user` with limited privileges (NOT root)
- [ ] Test database connection with new credentials
- [ ] Verify `DB_PASSWORD` is strong (12+ chars, mixed case + numbers + symbols)
- [ ] Verify `.env` is in `.gitignore` (not committed)
- [ ] Remove any hardcoded credentials from files
- [ ] Rotate AWS Access Keys if exposed in audit
- [ ] Rotate Cloudflare API Token if exposed

### Environment & Configuration
- [ ] Set `WP_DEBUG=false` in `.env`
- [ ] Set `WP_DEBUG_LOG=false` in `.env`
- [ ] Set `DISALLOW_FILE_MODS=true` in `.env`
- [ ] Verify `FORCE_SSL_ADMIN=true` in wp-config.php
- [ ] Verify `FORCE_SSL_LOGIN=true` in wp-config.php
- [ ] Verify `XMLRPC_ENABLED=false` in wp-config.php
- [ ] Test that wp-config.php loads `.env` correctly

### Code Review
- [ ] All security classes load in functions.php (af-security-headers, af-input-validation, etc.)
- [ ] No hardcoded secrets in any PHP files
- [ ] No test/debug code left in production
- [ ] All API endpoints have input validation
- [ ] All POST endpoints have rate limiting
- [ ] Nonce verification on authenticated endpoints
- [ ] All database queries use prepared statements

### Assets & Files
- [ ] `PRIVACY_POLICY.md` reviewed and customized
- [ ] `TERMS_AND_CONDITIONS.md` reviewed and customized
- [ ] `.htaccess` updated with security rules
- [ ] Confirm uploads directory is write-able but PHP not executable
- [ ] Verify `/wordpress/wp-config.php` is not publicly accessible

---

## DEPLOYMENT (During deployment)

### Files to Deploy
- [ ] `wordpress/wp-config.php` (updated with env loading)
- [ ] `wordpress/wp-config-env.php` (new)
- [ ] `.env` (with production values — NOT in version control)
- [ ] `.env.example` (template only)
- [ ] `.gitignore` (updated)
- [ ] `wordpress/.htaccess` (updated with security rules)
- [ ] `wordpress/wp-content/themes/twentytwentyfive-child/inc/af-security-headers.php`
- [ ] `wordpress/wp-content/themes/twentytwentyfive-child/inc/af-input-validation.php`
- [ ] `wordpress/wp-content/themes/twentytwentyfive-child/inc/af-rest-security.php`
- [ ] `wordpress/wp-content/themes/twentytwentyfive-child/inc/af-gdpr-compliance.php`
- [ ] `wordpress/wp-content/themes/twentytwentyfive-child/functions.php` (updated with requires)
- [ ] `PRIVACY_POLICY.md`
- [ ] `TERMS_AND_CONDITIONS.md`

### Database Migrations
- [ ] Create `wp_af_rate_limits` table: Run activation hook or manual SQL
- [ ] Create `wp_af_security_logs` table: Run activation hook or manual SQL
- [ ] Verify tables created: `SHOW TABLES LIKE 'wp_af_%'`

### Deployment Verification
- [ ] SSH into production server
- [ ] Verify `.env` file exists and is not world-readable: `ls -la .env` → `-rw-r-----`
- [ ] Verify `wp-config-env.php` loads: `php -l wordpress/wp-config-env.php`
- [ ] Clear any caches: Cloudflare, Redis, WP Super Cache
- [ ] Restart PHP-FPM / FastCGI

---

## POST-DEPLOYMENT (1-2 hours after going live)

### Security Headers Verification
```bash
# Check HSTS header
curl -I https://yourdomain.com | grep -i "Strict-Transport"
# Expected: Strict-Transport-Security: max-age=31536000...

# Check CSP header
curl -I https://yourdomain.com | grep -i "Content-Security"
# Expected: Content-Security-Policy: default-src...

# Check X-Frame-Options
curl -I https://yourdomain.com | grep -i "X-Frame"
# Expected: X-Frame-Options: SAMEORIGIN

# Check HTTPS redirect
curl -I http://yourdomain.com
# Expected: Status 301 or 302 to https://
```

### Database Connectivity
- [ ] Test with `wp-cli db check`
- [ ] Verify no connection errors in logs
- [ ] Confirm `DB_USER` has correct privileges
- [ ] Test SELECT, INSERT, UPDATE, DELETE operations

### API Endpoints
- [ ] Test public endpoint: `curl https://yourdomain.com/wp-json/af/v1/accommodations`
- [ ] Verify returns 200 with data (not 403/404)
- [ ] Test authenticated endpoint (requires nonce + auth)
- [ ] Verify unauthenticated POST returns 403

### Rate Limiting
- [ ] Test rate limit on password-reset:
```bash
for i in {1..5}; do 
  curl -X POST https://yourdomain.com/wp-json/af/v1/password-reset \
    -d '{"email":"test@example.com"}'
  echo "Request $i"
done
# Expected: 200 OK for first 3, then 429 Too Many Requests
```

### Input Validation
- [ ] Test invalid email: `/wp-json/af/v1/password-reset?email=invalid` → 400 Bad Request
- [ ] Test invalid phone: `/wp-json/af/v1/accommodations?phone=123` → 400
- [ ] Test SQL injection attempt: `/wp-json/af/v1/accommodations?search='; DROP TABLE` → sanitized/403
- [ ] Test XSS attempt: `/wp-json/af/v1/accommodations?search=<script>` → sanitized

### File Access Protection
```bash
# These should all return 403 or 404:
curl https://yourdomain.com/wp-config.php
curl https://yourdomain.com/.env
curl https://yourdomain.com/wordpress/wp-config.php
curl https://yourdomain.com/.git/config
curl https://yourdomain.com/debug.log
curl https://yourdomain.com/xmlrpc.php
```

### GDPR Endpoints
- [ ] Test data export (authenticated user): 
```bash
curl -X POST https://yourdomain.com/wp-json/af/v1/gdpr/data-export \
  -H "Authorization: Bearer $TOKEN" \
  -H "X-WP-Nonce: $NONCE"
# Expected: 200 + JSON file info
```

- [ ] Test data deletion (authenticated user + confirmation):
```bash
curl -X POST https://yourdomain.com/wp-json/af/v1/gdpr/data-delete \
  -H "Authorization: Bearer $TOKEN" \
  -d '{"confirm_deletion":"I understand this is permanent"}' \
  -H "X-WP-Nonce: $NONCE"
# Expected: 200 + confirmation message
```

### Cookie Security
- [ ] Check browser cookies are HttpOnly: F12 → Application → Cookies
- [ ] Verify auth cookies have Secure flag (HTTPS only)
- [ ] Verify cookie SameSite=Lax
- [ ] No sensitive data in cookie values

### Error Handling & Logs
- [ ] Verify debug.log is not publicly accessible
- [ ] Confirm error messages don't expose paths/versions
- [ ] Check WP_DEBUG_LOG is disabled in production
- [ ] Verify security events are being logged

### SSL/TLS Certificate
- [ ] Test SSL validity: `openssl s_client -connect yourdomain.com:443`
- [ ] Verify certificate chain is complete
- [ ] Check certificate expiration is 90+ days away
- [ ] Confirm TLS 1.2+ only (no SSL 3.0 or TLS 1.0)

---

## 24-HOUR MONITORING (After deployment)

### Logs & Events
- [ ] Check PHP error logs for warnings/errors
- [ ] Review WP security logs table for anomalies
- [ ] Check rate limit table for spikes
- [ ] Verify no 400/401/403/500 errors (investigate any)

### Performance
- [ ] Confirm page load times are normal (< 2s)
- [ ] Check database query time (< 100ms average)
- [ ] Verify API response times (< 500ms)
- [ ] Confirm GZIP compression is working: `curl -I` → `Content-Encoding: gzip`

### User Functionality
- [ ] Test owner registration flow end-to-end
- [ ] Test password reset flow (email delivery)
- [ ] Test property listing and search
- [ ] Test user login/logout
- [ ] Test mobile responsiveness

### Security Events
- [ ] Search security logs for `password_reset_requested`
- [ ] Search security logs for `rate_limit_exceeded`
- [ ] Check for any `blocked_*` events
- [ ] Verify logging is working

---

## WEEKLY SECURITY CHECKS (First month)

- [ ] Review security event logs for patterns
- [ ] Check for repeated rate limit hits (possible attack)
- [ ] Verify no 400-level errors on public endpoints
- [ ] Confirm backups are happening and testable
- [ ] Test backup restoration process
- [ ] Review AWS CloudTrail for unauthorized access attempts
- [ ] Review Cloudflare analytics for DDoS patterns
- [ ] Verify SSL certificate hasn't been revoked

---

## MONTHLY SECURITY CHECKS

- [ ] Run `wp plugin verify-checksums --all`
- [ ] Check for WordPress core updates
- [ ] Check for plugin updates
- [ ] Review and clean security logs (archive old)
- [ ] Rotate API tokens if policy requires
- [ ] Audit user permissions (remove unnecessary)
- [ ] Test GDPR data export/delete flows
- [ ] Review file permissions (ensure correct)

---

## INCIDENT RESPONSE

### If Security Alert Triggered

**Immediate Actions** (< 1 hour):
1. [ ] Identify the incident type
2. [ ] Check logs: `tail -f /var/log/php-fpm.log`
3. [ ] Check security events table
4. [ ] Isolate affected system if needed
5. [ ] Contact security@arriendofacil.com

**Investigation** (< 24 hours):
1. [ ] Gather logs (start time, affected users, actions)
2. [ ] Determine if data was compromised
3. [ ] Identify root cause
4. [ ] Document timeline

**Remediation** (< 48 hours):
1. [ ] Patch vulnerability
2. [ ] Rotate credentials if needed
3. [ ] Notify affected users if required
4. [ ] Update monitoring/alerts

---

## ROLLBACK PLAN

If critical issue after deployment:

```bash
# 1. Stop immediate bleeding
systemctl stop php-fpm
systemctl stop nginx

# 2. Restore from last known-good backup
mysqldump [backup].sql | mysql arriendo_facil

# 3. Revert code to previous commit
git checkout HEAD~1

# 4. Restart services
systemctl start php-fpm
systemctl start nginx

# 5. Verify service
curl https://yourdomain.com/

# 6. Post-incident
- Contact team immediately
- Document what went wrong
- Schedule post-mortem (24-48 hours later)
```

---

## SIGN-OFF

By signing below, you verify that all checks have been completed and the deployment is production-safe.

**Deployed by**: ___________________ **Date**: ________  
**Verified by**: ___________________ **Date**: ________  
**Approved by**: ___________________ **Date**: ________  

**Notes**:
```
[Document any issues found, resolutions, or deviations from checklist]


```

---

**EMERGENCY CONTACTS**

- Security: security@arriendofacil.com
- DevOps: devops@arriendofacil.com
- CTO: cto@arriendofacil.com
- Support: support@arriendofacil.com

**Last Updated**: 2026-10-07  
**Version**: 1.0.0
