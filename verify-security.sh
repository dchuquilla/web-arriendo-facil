#!/bin/bash
# 🔍 SECURITY & COMPLIANCE VERIFICATION SCRIPT
# Verifica todos los puntos críticos de seguridad, compliance y performance

set -e

PROJECT_DIR="/Users/dchuquilla/projects/arriendo-facil/web-arriendo-facil"
cd "$PROJECT_DIR"

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║        🔍 SEGURIDAD, COMPLIANCE Y PERFORMANCE CHECKER         ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

PASSED=0
FAILED=0
WARNINGS=0

# Function to log results
log_pass() {
    echo -e "${GREEN}✅ PASS${NC}: $1"
    ((PASSED++))
}

log_fail() {
    echo -e "${RED}❌ FAIL${NC}: $1"
    ((FAILED++))
}

log_warn() {
    echo -e "${YELLOW}⚠️  WARN${NC}: $1"
    ((WARNINGS++))
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "1️⃣  CREDENCIALES & SECRETS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 1.1: No Cloudflare tokens in git
if git log --all -S "cfat_" --oneline | grep -q .; then
    log_fail "Cloudflare tokens found in git history"
else
    log_pass "No Cloudflare tokens in git history"
fi

# Check 1.2: No AWS keys in git
if git log --all -S "AKIA" --oneline | grep -q .; then
    log_fail "AWS keys found in git history"
else
    log_pass "No AWS keys in git history"
fi

# Check 1.3: .env not in git
if git ls-files | grep -q "\.env$"; then
    log_fail ".env file is tracked in git (SECURITY RISK)"
else
    log_pass ".env is not tracked in git"
fi

# Check 1.4: .env.example exists
if [ -f ".env.example" ]; then
    log_pass ".env.example exists for reference"
else
    log_warn ".env.example not found"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "2️⃣  CODE SECURITY"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 2.1: WP_DEBUG disabled
if grep -q 'define.*WP_DEBUG.*false' wordpress/wp-config.php; then
    log_pass "WP_DEBUG is disabled in production"
else
    log_fail "WP_DEBUG is not disabled"
fi

# Check 2.2: WP_DEBUG_LOG disabled
if grep -q 'define.*WP_DEBUG_LOG.*false' wordpress/wp-config.php; then
    log_pass "WP_DEBUG_LOG is disabled"
else
    log_fail "WP_DEBUG_LOG is not disabled"
fi

# Check 2.3: No SQL injection vulnerabilities (basic check)
INJECTABLE=$(grep -r "mysqli_query\|mysql_query\|$wpdb->query" wordpress/wp-content/plugins/arriendo-facil-main/ 2>/dev/null | grep -v "prepare\|sprintf" | wc -l)
if [ "$INJECTABLE" -eq 0 ]; then
    log_pass "No direct SQL queries detected (0 risky patterns)"
else
    log_warn "Found $INJECTABLE potentially risky SQL patterns (need review)"
fi

# Check 2.4: XSS protection (check for wp_kses_post usage)
SANITIZED=$(grep -r "wp_kses_post\|wp_kses\|esc_html\|esc_attr" wordpress/wp-content/plugins/arriendo-facil-main/ 2>/dev/null | wc -l)
if [ "$SANITIZED" -gt 10 ]; then
    log_pass "Found $SANITIZED sanitization calls"
else
    log_warn "Found only $SANITIZED sanitization calls (need more)"
fi

# Check 2.5: CSRF protection nonces
NONCES=$(grep -r "wp_nonce_field\|wp_nonce_url\|wp_verify_nonce" wordpress/wp-content/plugins/arriendo-facil-main/ 2>/dev/null | wc -l)
if [ "$NONCES" -gt 5 ]; then
    log_pass "Found $NONCES nonce protections"
else
    log_warn "Found only $NONCES nonces (need more protection)"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "3️⃣  COMPLIANCE & LEGAL"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 3.1: TERMS_AND_CONDITIONS.md exists
if [ -f "wordpress/wp-content/plugins/arriendo-facil-main/docs/TERMS_AND_CONDITIONS.md" ]; then
    log_pass "TERMS_AND_CONDITIONS.md exists"
else
    log_fail "TERMS_AND_CONDITIONS.md not found"
fi

# Check 3.2: privacy-manifest.json exists
if [ -f "wordpress/wp-content/plugins/arriendo-facil-main/public/privacy-manifest.json" ]; then
    log_pass "privacy-manifest.json exists (iOS App Store requirement)"
else
    log_fail "privacy-manifest.json not found"
fi

# Check 3.3: Cookie banner should be mentioned (Complianz)
if grep -q "complianz\|gdpr" wordpress/wp-config.php 2>/dev/null || \
   [ -d "wordpress/wp-content/plugins" ] && grep -r "complianz" wordpress/wp-content/plugins 2>/dev/null | grep -q "plugin"; then
    log_pass "GDPR/Complianz plugin detected (cookie banner ready)"
else
    log_warn "GDPR compliance plugin not verified in config"
fi

# Check 3.4: Privacy policy page or reference
if grep -q "privacy\|politique de confidentialité\|política de privacidad" wordpress/wp-content/themes/twentytwentyfive-child/template-parts/* 2>/dev/null; then
    log_pass "Privacy policy reference found in theme"
else
    log_warn "Privacy policy reference not found in templates"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "4️⃣  PERFORMANCE BASICS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 4.1: Responsive viewport meta tag
if grep -q "viewport" wordpress/wp-content/themes/twentytwentyfive-child/header.php 2>/dev/null || \
   grep -q "viewport" wordpress/wp-content/themes/twentytwentyfive-child/*.php 2>/dev/null; then
    log_pass "Viewport meta tag found (responsive ready)"
else
    log_warn "Viewport meta tag not found in theme headers"
fi

# Check 4.2: CSS files exist
CSS_COUNT=$(find wordpress/wp-content/themes/twentytwentyfive-child -name "*.css" 2>/dev/null | wc -l)
if [ "$CSS_COUNT" -gt 0 ]; then
    log_pass "Found $CSS_COUNT CSS files"
else
    log_fail "No CSS files found"
fi

# Check 4.3: Plugin file size (bloat detection)
PLUGIN_SIZE=$(du -sh wordpress/wp-content/plugins/arriendo-facil-main 2>/dev/null | cut -f1)
log_pass "Plugin size: $PLUGIN_SIZE"

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "5️⃣  TESTING & COVERAGE"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 5.1: PHPUnit tests exist
if [ -d "wordpress/wp-content/plugins/arriendo-facil-main/tests" ]; then
    TEST_COUNT=$(find wordpress/wp-content/plugins/arriendo-facil-main/tests -name "*.php" 2>/dev/null | wc -l)
    log_pass "Found $TEST_COUNT test files"
else
    log_fail "No tests directory found"
fi

# Check 5.2: phpunit.xml configuration
if [ -f "wordpress/wp-content/plugins/arriendo-facil-main/phpunit.xml" ] || \
   [ -f "phpunit.xml" ]; then
    log_pass "PHPUnit configuration found"
else
    log_warn "PHPUnit configuration not found"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "6️⃣  DEPENDENCIES"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 6.1: composer.json exists
if [ -f "composer.json" ]; then
    log_pass "composer.json found"
    # Check 6.2: composer.lock exists (deterministic installs)
    if [ -f "composer.lock" ]; then
        log_pass "composer.lock exists (reproducible builds)"
    else
        log_warn "composer.lock not found (run: composer install)"
    fi
else
    log_warn "composer.json not found"
fi

# Check 6.3: .gitignore for dependencies
if grep -q "vendor/\|node_modules/" .gitignore 2>/dev/null; then
    log_pass ".gitignore properly excludes dependencies"
else
    log_warn "Dependencies might be tracked in git"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "7️⃣  DOCUMENTATION"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Check 7.1: README.md exists
if [ -f "README.md" ]; then
    log_pass "README.md exists"
else
    log_fail "README.md not found"
fi

# Check 7.2: AUDIT documents
AUDIT_DOCS=$(find . -maxdepth 1 -name "*AUDIT*" -o -name "*CHECKLIST*" 2>/dev/null | wc -l)
if [ "$AUDIT_DOCS" -gt 0 ]; then
    log_pass "Found $AUDIT_DOCS audit/checklist documents"
else
    log_warn "Audit documentation not found"
fi

echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                     📊 FINAL REPORT                            ║"
echo "╚════════════════════════════════════════════════════════════════╝"

TOTAL=$((PASSED + FAILED + WARNINGS))
SCORE=$((PASSED * 100 / TOTAL))

echo ""
echo "✅ PASSED:   $PASSED"
echo "❌ FAILED:   $FAILED"
echo "⚠️  WARNINGS: $WARNINGS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📊 SCORE:    $SCORE% ($PASSED/$TOTAL checks passed)"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}🎉 READY FOR LAUNCH!${NC}"
    exit 0
elif [ $FAILED -le 3 ]; then
    echo -e "${YELLOW}⚠️  MOSTLY READY - Fix $FAILED issues${NC}"
    exit 1
else
    echo -e "${RED}❌ NOT READY - Fix $FAILED issues first${NC}"
    exit 2
fi
