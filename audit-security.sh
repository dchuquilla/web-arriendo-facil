#!/bin/bash

# 🔍 ARRIENDO FÁCIL - SECURITY AUDIT SCRIPT
# Ejecutar: bash audit-security.sh
# Propósito: Validar que los fixes de seguridad se implementaron correctamente

set -e

THEME_PATH="wordpress/wp-content/themes/twentytwentyfive-child"
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}╔════════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║          🔍 ARRIENDO FÁCIL - SECURITY AUDIT SCRIPT              ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════════╝${NC}"
echo ""

# Contador de problemas
PROBLEMS=0

# ============================================================================
# FIX #1: Validación property_type
# ============================================================================

echo -e "${YELLOW}[CHECK #1]${NC} Validación property_type whitelist..."

if grep -q "twentytwentyfive_child_validate_property_type" "$THEME_PATH/functions.php"; then
  echo -e "${GREEN}✓ PASS${NC}: Función helper found"
else
  echo -e "${RED}✗ FAIL${NC}: Helper function missing"
  echo "  → Agregar: twentytwentyfive_child_validate_property_type()"
  PROBLEMS=$((PROBLEMS + 1))
fi

if grep -q "in_array(\$property_type, \['apartment', 'house', 'room', 'studio'\]" "$THEME_PATH/functions.php"; then
  echo -e "${GREEN}✓ PASS${NC}: Whitelist validation found"
else
  echo -e "${RED}✗ FAIL${NC}: Whitelist validation missing"
  PROBLEMS=$((PROBLEMS + 1))
fi

echo ""

# ============================================================================
# FIX #2: Google Places API endpoint
# ============================================================================

echo -e "${YELLOW}[CHECK #2]${NC} Google Places API backend endpoint..."

if grep -q "register_rest_route.*places/suggestions" "$THEME_PATH/functions.php"; then
  echo -e "${GREEN}✓ PASS${NC}: REST endpoint registered"
else
  echo -e "${RED}✗ FAIL${NC}: REST endpoint not found"
  echo "  → Crear: /wp-json/af/v1/places/suggestions"
  PROBLEMS=$((PROBLEMS + 1))
fi

if grep -q "fetch('/wp-json/af/v1/places" "$THEME_PATH/assets/js/search-bar.js"; then
  echo -e "${GREEN}✓ PASS${NC}: Frontend uses backend API"
else
  echo -e "${RED}✗ FAIL${NC}: Frontend not using backend API"
  PROBLEMS=$((PROBLEMS + 1))
fi

echo ""

# ============================================================================
# FIX #3: innerHTML replaced with createElement
# ============================================================================

echo -e "${YELLOW}[CHECK #3]${NC} XSS prevention (createElement vs innerHTML)..."

if grep -q "document.createElement('li')" "$THEME_PATH/assets/js/search-bar.js"; then
  echo -e "${GREEN}✓ PASS${NC}: createElement found"
else
  echo -e "${RED}✗ FAIL${NC}: innerHTML still in use (renderSuggestions)"
  PROBLEMS=$((PROBLEMS + 1))
fi

if grep -q "textContent = sug.label" "$THEME_PATH/assets/js/search-bar.js"; then
  echo -e "${GREEN}✓ PASS${NC}: textContent for safe escaping"
else
  echo -e "${YELLOW}⚠ WARNING${NC}: Check if using textContent instead of innerHTML"
  PROBLEMS=$((PROBLEMS + 1))
fi

echo ""

# ============================================================================
# FIX #4: SRI Hashes on CDN
# ============================================================================

echo -e "${YELLOW}[CHECK #4]${NC} Subresource Integrity (SRI) on CDN resources..."

if grep -q 'integrity=' "$THEME_PATH/functions.php"; then
  echo -e "${GREEN}✓ PASS${NC}: SRI integrity attributes found"
else
  echo -e "${RED}✗ FAIL${NC}: No SRI hashes found"
  echo "  → Agregar integrity= y crossorigin= attributes"
  PROBLEMS=$((PROBLEMS + 1))
fi

echo ""

# ============================================================================
# FIX #5: filemtime() to constant
# ============================================================================

echo -e "${YELLOW}[CHECK #5]${NC} Cache busting strategy (filemtime vs constant)..."

FILEMTIME_COUNT=$(grep -c "filemtime(" "$THEME_PATH/functions.php" || echo "0")
if [ "$FILEMTIME_COUNT" -eq 0 ]; then
  echo -e "${GREEN}✓ PASS${NC}: No filemtime() calls found"
else
  echo -e "${YELLOW}⚠ WARNING${NC}: Found $FILEMTIME_COUNT filemtime() calls"
  echo "  → Reemplazar con constante: AF_THEME_VERSION"
  PROBLEMS=$((PROBLEMS + 1))
fi

if grep -q "define('AF_THEME_VERSION'" "$THEME_PATH/functions.php"; then
  echo -e "${GREEN}✓ PASS${NC}: AF_THEME_VERSION constant defined"
else
  echo -e "${RED}✗ FAIL${NC}: AF_THEME_VERSION constant missing"
  PROBLEMS=$((PROBLEMS + 1))
fi

echo ""

# ============================================================================
# FIX #6: sessionStorage instead of window global
# ============================================================================

echo -e "${YELLOW}[CHECK #6]${NC} Secure session storage (sessionStorage vs window)..."

if grep -q "window.searchLocation" "$THEME_PATH/assets/js/search-results-interactive.js"; then
  echo -e "${RED}✗ FAIL${NC}: window.searchLocation still exists (XSS risk)"
  PROBLEMS=$((PROBLEMS + 1))
else
  echo -e "${GREEN}✓ PASS${NC}: window.searchLocation removed"
fi

if grep -q "sessionStorage.setItem.*searchLocation" "$THEME_PATH/assets/js/search-results-interactive.js"; then
  echo -e "${GREEN}✓ PASS${NC}: Using sessionStorage for location data"
else
  echo -e "${YELLOW}⚠ WARNING${NC}: sessionStorage implementation not found"
  PROBLEMS=$((PROBLEMS + 1))
fi

echo ""

# ============================================================================
# BONUS CHECKS
# ============================================================================

echo -e "${YELLOW}[BONUS]${NC} Additional security checks..."

# Check for dangerous functions
DANGEROUS=$(grep -r "eval(" "$THEME_PATH/assets/js/" 2>/dev/null || echo "")
if [ -z "$DANGEROUS" ]; then
  echo -e "${GREEN}✓ PASS${NC}: No eval() calls found"
else
  echo -e "${RED}✗ FAIL${NC}: eval() detected - security risk"
  PROBLEMS=$((PROBLEMS + 1))
fi

# Check for proper escaping in PHP
if grep -q "esc_html\|esc_attr\|esc_url" "$THEME_PATH/single.php"; then
  echo -e "${GREEN}✓ PASS${NC}: PHP output escaping found"
else
  echo -e "${YELLOW}⚠ WARNING${NC}: Limited escaping found in templates"
fi

# Check for NONCE in forms
if grep -q "wp_nonce_field" "$THEME_PATH/page-propiedades.php"; then
  echo -e "${GREEN}✓ PASS${NC}: NONCE fields found in forms"
else
  echo -e "${YELLOW}⚠ INFO${NC}: No NONCE needed for GET forms (but validate inputs)"
fi

echo ""

# ============================================================================
# SUMMARY
# ============================================================================

echo -e "${BLUE}════════════════════════════════════════════════════════════════${NC}"

if [ $PROBLEMS -eq 0 ]; then
  echo -e "${GREEN}✓ ALL CHECKS PASSED!${NC}"
  echo -e "${GREEN}Tema listo para producción${NC}"
  exit 0
else
  echo -e "${RED}✗ FOUND $PROBLEMS ISSUES${NC}"
  echo -e "${YELLOW}Revisar FIXES_IMPLEMENTATION_PLAN.md para detalles${NC}"
  exit 1
fi
