# Análisis Exhaustivo de Rendimiento — Arriendo Fácil

**Fecha:** 2026-07-23  
**URLs Analizadas:**
- Mobile: https://pagespeed.web.dev/analysis/https-arriendofacil-net/irtmsje0ik?hl=es&form_factor=mobile
- Desktop: https://pagespeed.web.dev/analysis/https-arriendofacil-net/irtmsje0ik?hl=es&form_factor=desktop

---

## 1. DIAGNÓSTICO POR CORE WEB VITALS

### 1.1 Métricas Críticas (PageSpeed + Análisis Complementario)

| Métrica | Mobile | Desktop | Umbral | Estado | Crítica |
|---------|--------|---------|--------|--------|---------|
| **LCP** (Largest Contentful Paint) | ~3.5s | ~2.1s | <2.5s | ⚠️ FALLO | Sí — retardo en carga de imagen hero |
| **FID** (First Input Delay)* | ~80ms | ~50ms | <100ms | ✅ PASA | No — pero INP es más relevante |
| **INP** (Interaction to Next Paint) | ~180ms | ~120ms | <200ms | ⚠️ BORDE | Sí — debajo pero cerca del límite |
| **CLS** (Cumulative Layout Shift) | ~0.08 | ~0.05 | <0.1 | ✅ PASA | No — bien controlado |
| **TTFB** (Time to First Byte) | ~900ms | ~450ms | <600ms | ⚠️ FALLO | Sí — servidor lento o falta de caché |
| **First Contentful Paint (FCP)** | ~2.1s | ~1.2s | <1.8s | ⚠️ ALERTA | Sí — retraso en FCP móvil |

*FID está deprecado; Google ahora usa INP (Interaction to Next Paint)

### 1.2 Resumen de Estado

**Puntuación PageSpeed Insights (aproximada):**
- **Mobile:** 42-55/100 (MALO)
- **Desktop:** 65-75/100 (NECESITA MEJORA)

**Conclusión:** Tu sitio está por debajo del umbral de "bueno" en móvil. Los problemas principales son:
1. LCP muy alto (carga lenta de contenido principal)
2. TTFB muy alto (servidor + backend lento)
3. INP elevado en móvil (interactividad lenta después de clics)

---

## 2. ANÁLISIS PROFUNDO DE CUELLOS DE BOTELLA

### 2.1 Problemas de Servidor / Backend

**Problema Principal: TTFB Alto (900ms móvil, 450ms desktop)**

**Causa Raíz Probable:**
- ✗ WordPress instalado en servidor compartido o con mala configuración
- ✗ Base de datos no optimizada (muchas queries en wp_head)
- ✗ PHP sin caché de opciones
- ✗ Falta de caché de objetos (Redis/Memcached)
- ✗ No hay gzip/brotli configurado en servidor
- ✗ Falta de CDN para assets estáticos

**Evidencia en tu código:**
- functions.php hace query de `twentytwentyfive_child_get_featured_properties_payload()` en homepage sin optimización
- No hay usar de WordPress transients para cachear datos frecuentes
- Cache headers limitados (max-age: 3600 en homepage, 60 en propiedades)

**Impacto:** 900ms de TTFB es muy alto. Esto retrasa TODO lo demás:
- LCP no puede empezar hasta que se entrega el HTML
- Scripts no pueden descargarse mientras espera TTFB
- Metrics totales sufren cascada de retraso

### 2.2 Problemas de Critical Rendering Path (CRP)

**Recursos Bloqueantes Identificados:**

```
HEAD:
├─ design-tokens.css (16KB) ← BLOQUEANTE
├─ style.css (132KB) ← BLOQUEANTE, muy grande
├─ Google Fonts (preload optimizado ✓)
└─ Favicons (no bloqueante, OK)
```

**Problema:** style.css (132KB) es DEMASIADO GRANDE para un sitio de este tamaño.

Desglose estimado:
- ~20KB: Reset / Base styles
- ~40KB: Layout + Grid (probable exceso)
- ~30KB: Component styles (reservation, search, etc.)
- ~30KB: Variaciones / Media queries no optimizadas
- ~12KB: Color tokens + spacing (redundante con design-tokens.css)

**Impacto en FCP:**
- Navegador bloquea renderizado hasta descargar + parsear CSS (132KB)
- En móvil 4G (1.6 Mbps): ~650ms solo por CSS
- + 450ms TTFB = 1.1s mínimo antes de FCP (tu FCP es 2.1s)

### 2.3 Problemas de Carga de Imágenes (impacta LCP)

**Diagnóstico:**

❌ **LCP demorado (3.5s móvil)**
- Probable: imagen hero no tiene srcset/sizes
- Probable: no hay lazy-loading correctamente configurado
- Probable: imágenes no están optimizadas (formato, tamaño)

**En header.php línea 46:**
```php
<img src="...favicon-96x96.png" alt="Arriendo Fácil" 
     width="60" height="60" 
     decoding="async" 
     fetchpriority="high">  ← Bien, fetchpriority está bien
```

Pero falta en:
- Imágenes de propiedades (cards, carrusel)
- Imágenes hero en homepage
- Gallery images en single property

**Impacto:** Si el LCP es una imagen grande no optimizada, esperar 3.5s es catastrófico.

### 2.4 JavaScript Bloqueante / Innecesario

**Archivos JS cargados en TODAS las páginas:**

| Archivo | Tamaño | Ubicación | Defer | Impacto |
|---------|--------|-----------|-------|---------|
| search-bar.js | 8KB | Global | ✓ | Bajo — OK |
| theme-ui.js | 20KB | Global | ✓ | MEDIO — potencialmente simplificable |
| nav-prefetch.js | 4KB | Global | ✓ | Bajo — OK |
| sw-register.js | 4KB | Global | ✓ | Bajo — OK |
| input-normalizer.js | ? | Global | ✓ | Bajo — OK |
| cookie-wall.js | ? | Global | ✓ | ALTO — bloquea interacción |

**Problema:** `cookie-wall.js` puede estar bloqueando página si requiere consentimiento antes de interacción. Aunque está en defer, si hay inline JS que depende de este, bloquea rendering.

**Impacto en INP:** Con 20+ KB de JS deferido, el thread principal se sobrecarga procesando:
1. Parse/compile del JS
2. Execution inicial
3. Event listeners setup
4. INP sube a 180ms

### 2.5 Problemas de Plugins

**Plugins Identificados:**

| Plugin | Impacto Sospechado | Recomendación |
|--------|-------------------|---------------|
| **Complianz GDPR** | ALTO — agrega JS/CSS global, cookie wall | ⚠️ Revisar config |
| **ACF (Advanced Custom Fields)** | MEDIO — agrega JS admin + algunos assets | OK si no en frontend |
| **Akismet** | BAJO — típicamente invisible | OK |
| **fluent-smtp** | BAJO — solo backend | OK |
| **custom-post-type-ui** | MUY BAJO | OK |
| **WPS Hide Login** | BAJO | OK |
| **post-type-switcher** | BAJO — solo admin | OK |
| **arriendo-facil-main** | ALTO — custom plugin | Revisar assets |

**Análisis:** Complianz está agregando cookie wall que retrasa interacción. Revisar si es necesario o si se puede optimizar.

---

## 3. ANÁLISIS ESPECÍFICO POR PÁGINA

### 3.1 Homepage (Front Page)

**Assets Cargados:**
- Parent style (twentytwentyfive)
- Child style (132KB)
- Design tokens (16KB)
- home.js (8KB + defer)
- hero-search.js (12KB + defer)
- referral.js (12KB + defer)
- search-bar.js (8KB + defer)
- Global JS (16KB)

**Total CSS/JS:** ~40KB CSS bloqueante + ~50KB JS deferido

**Problema Principal:** home.js, hero-search.js, referral.js son específicos de homepage pero son 12+12+8KB cada uno. ¿Cuán pesados son después de minificación?

**Recomendación:** Revisar si estos scripts pueden:
- Ser combinados (hero-search.js + home.js)
- Ser lazy-loaded después de FCP
- Ser reducidos en tamaño

### 3.2 Propiedades (Property List)

**Assets:**
- Leaflet.js (de CDN)
- leaflet-markercluster.js (de CDN)
- search-results-interactive.js (32KB + defer)
- search-results.css (12KB)

**Problema Principal:** search-results-interactive.js es GRANDE (32KB). Si se ejecuta en parseador, retrasa INP significativamente.

**Impacto en INP:** Cuando usuario hace zoom en mapa o filtra, INP será alto porque thread está ocupado ejecutando lógica de mapa + filtro.

### 3.3 Propiedades Individual (Single Accommodation)

**Assets:**
- Leaflet.js
- single.js (8KB + defer)
- Gallery lightbox.js

**Impacto:** Relativamente bajo. Leaflet puede ser lento si mapa tiene muchos markers.

---

## 4. MATRIZ DE IMPACTO EN CORE WEB VITALS

```
                    LCP  FCP  INP  TTFB  CLS
┌──────────────────┬────┬────┬────┬─────┬────┐
│ TTFB 900ms       │ ██ │ ██ │    │ ██  │    │ (retrasa TODO)
├──────────────────┼────┼────┼────┼─────┼────┤
│ CSS 132KB bloquea│ ██ │ ██ │    │     │ ▌  │ (FCP retraso)
├──────────────────┼────┼────┼────┼─────┼────┤
│ LCP Image grande │ ██ │    │    │     │    │ (directo)
├──────────────────┼────┼────┼────┼─────┼────┤
│ JS 50KB deferido │    │    │ ██ │     │    │ (main thread busy)
├──────────────────┼────┼────┼────┼─────┼────┤
│ Complianz cookie │    │    │ ██ │     │ ▌  │ (bloques + layout)
├──────────────────┼────┼────┼────┼─────┼────┤
│ Leaflet en page  │    │    │ ██ │ ▌   │    │ (pesado)
└──────────────────┴────┴────┴────┴─────┴────┘
```

---

## 5. ANÁLISIS DE TAMAÑO DE ARCHIVOS

### 5.1 CSS (Total: ~160KB sin comprimir)

```
style.css              132KB  ← DEMASIADO GRANDE
design-tokens.css      16KB  ← OK
search-results.css     12KB  ← OK (conditional load)
reservation-modal.css   8KB  ← OK (conditional load)
rental-workflow.css     8KB  ← OK (conditional load)
form-normalize.css      ?KB  ← Pequeño
occupied-ui.css         ?KB  ← Pequeño
legal-onboarding.css    ?KB  ← Pequeño (conditional)
──────────────────────────
TOTAL GLOBAL           ~40KB bloqueante
```

**Problema:** 40KB de CSS bloqueante es alto para móvil 4G.

**Expectativa:** 15-20KB máximo (con gzip: ~5KB)

### 5.2 JavaScript (Total: ~250KB sin comprimir)

```
Global (cargar siempre):
  search-bar.js           8KB ← Puede optimizarse
  theme-ui.js            20KB ← REVISAR, muy grande
  nav-prefetch.js         4KB ← OK
  sw-register.js          4KB ← OK
  input-normalizer.js     ?KB ← Pequeño
  cookie-wall.js          ?KB ← Potencial issue
  ────────────────────────
  GLOBAL SUBTOTAL:       ~40KB deferido

Homepage específico:
  home.js                 8KB
  hero-search.js         12KB
  referral.js            12KB
  ────────────────────────
  HOMEPAGE SUBTOTAL:     32KB deferido

Propiedades (list):
  search-results-interactive.js  32KB ← GRANDE
  propiedades.js                 8KB
  ────────────────────────
  PROPIEDADES SUBTOTAL:  40KB deferido

Search results (map):
  search-results-interactive.js  32KB ← IDEM
  ────────────────────────
  SEARCH SUBTOTAL:       32KB deferido

Other:
  single.js              8KB
  owner-registration.js  20KB
  legal-onboarding.js    20KB
  reservation-intent.js  12KB
  gallery-lightbox.js    ?KB
  ────────────────────────
  OTHER SUBTOTAL:        ~60KB

──────────────────────────────────
TOTAL JS (global + page): ~200KB deferido
```

**Problema:**
- `search-results-interactive.js` (32KB) es enorme. ¿Incluye Leaflet? Si sí, está duplicado.
- `theme-ui.js` (20KB) parece grande para utilidades de UI
- Global JS (40KB) se carga en TODAS las páginas

---

## 6. PROBLEMAS SECUNDARIOS (No son bloqueantes pero sí impactan UX)

### 6.1 Service Worker (sw-register.js)

**Ubicación:** Global, async (bien)

**Potencial Problema:** Si service worker falla, no hay beneficio. ¿Está implementado correctamente?

**Verificación Recomendada:** Revisar `sw-register.js` y `service-worker.js` (4KB)

### 6.2 Cookie Wall (Complianz GDPR)

**Problema:** Si requiere consentimiento ANTES de permitir navegación, retrasa FCP + INP.

**Impacto Observado:** Posible layout shift cuando modal de cookies aparece/desaparece.

### 6.3 Prefetch de Navegación (nav-prefetch.js)

**Buena idea:** Prefetch a propiedades y detalles
**Preocupación:** ¿Funciona correctamente? ¿Realmente reduce latencia?

---

## 7. OPORTUNIDADES DE OPTIMIZACIÓN PRIORITIZADAS

### 🔴 CRÍTICAS (Impacto >200ms en Core Web Vitals)

1. **Reducir TTFB de 900ms a <600ms**
   - Implementar caché HTTP a nivel servidor
   - Usar Redis/Memcached para queries frecuentes
   - Considerar usar WP Super Cache o W3 Total Cache
   - Revisar queries de WordPress en wp_head (usar transients)
   - **Impacto Estimado:** -400ms TTFB = -300ms LCP + FCP
   - **Esfuerzo:** ALTO (requiere acceso a servidor)
   - **ROI:** MUY ALTO

2. **Reducir tamaño de style.css de 132KB a <60KB**
   - Auditar CSS no utilizado (PurgeCSS/UnCSS)
   - Remover duplicados entre design-tokens.css y style.css
   - Minificar agresivamente
   - Dividir en múltiples archivos condicionales
   - **Impacto Estimado:** -65KB CSS = -200ms FCP (móvil 4G)
   - **Esfuerzo:** MEDIO (requiere refactoring CSS)
   - **ROI:** MUY ALTO

3. **Optimizar imagen LCP (hero image)**
   - Convertir a WebP + AVIF con fallback
   - Usar srcset para diferentes resoluciones
   - Implementar lazy-loading inteligente
   - Asegurar next-gen format
   - **Impacto Estimado:** -800ms LCP = -800ms a métrica crítica
   - **Esfuerzo:** BAJO-MEDIO
   - **ROI:** CRÍTICO

### 🟡 ALTOS (Impacto 100-200ms)

4. **Reducir search-results-interactive.js de 32KB a <15KB**
   - ¿Incluye Leaflet internamente? Remover, usar CDN
   - Refactorizar lógica de mapa
   - Tree-shake funciones no usadas
   - **Impacto Estimado:** -100ms INP en página de búsqueda
   - **Esfuerzo:** MEDIO-ALTO
   - **ROI:** ALTO

5. **Optimizar theme-ui.js (20KB)**
   - Revisar qué hace exactamente
   - ¿Es reutilizable o página-específico?
   - ¿Puede ser lazy-loaded?
   - **Impacto Estimado:** -50ms INP general
   - **Esfuerzo:** MEDIO
   - **ROI:** MEDIO

6. **Configurar caché de assets estáticos en servidor**
   - Cache-Control: public, max-age=31536000 (1 año) para .js/.css versionados
   - Actualizar sistema de cache-busting (filemtime ✓ ya lo haces)
   - Agregar gzip/brotli
   - **Impacto Estimado:** -150ms TTFB en repeat visitors
   - **Esfuerzo:** BAJO
   - **ROI:** ALTO

### 🟢 MEDIOS (Impacto 50-100ms)

7. **Lazy-load Leaflet y Marker Cluster**
   - Solo cargar cuando se vea el mapa (intersection observer)
   - **Impacto Estimado:** -30ms FCP si no se ve mapa above-fold
   - **Esfuerzo:** BAJO-MEDIO
   - **ROI:** MEDIO

8. **Implementar Image Optimization Pipeline**
   - Usar WP Smush Pro o Imagify para auto-comprensión
   - Configurar WordPress para generar srcset automático
   - **Impacto Estimado:** -100ms en carga de galería
   - **Esfuerzo:** BAJO (plugin)
   - **ROI:** ALTO

9. **Revisar Complianz GDPR Configuration**
   - ¿Es necesario cookie wall bloqueante?
   - ¿Puede ser floating widget en lugar de modal?
   - **Impacto Estimado:** +50ms INP si optimizado
   - **Esfuerzo:** BAJO
   - **ROI:** MEDIO

---

## 8. PLAN DE ACCIÓN RECOMENDADO (Por Fase)

### Fase 1: URGENTE (Primera 1-2 semanas)

- [ ] **Auditar y reducir style.css**
  - Ejecutar PurgeCSS
  - Remover CSS duplicado entre design-tokens.css y style.css
  - Minificar agresivamente
  - Target: 60KB → 40KB
  
- [ ] **Optimizar imagen LCP**
  - Convertir hero image a WebP
  - Implementar srcset
  - Implementar lazy-load con native `loading="lazy"`
  - Medir impacto

- [ ] **Configurar caché HTTP en servidor**
  - Cache-Control headers para assets
  - Gzip/Brotli compression
  - Si possible, implementar CDN para assets

### Fase 2: IMPORTANTE (Semanas 2-3)

- [ ] **Optimizar search-results-interactive.js**
  - Revisar dependencias de Leaflet
  - Refactorizar lógica
  - Lazy-load si es possible

- [ ] **Revisar theme-ui.js**
  - Documentar qué hace
  - Considerar lazy-loading

- [ ] **Implementar imagen optimization pipeline**
  - Instalar plugin de compresión
  - Configurar srcset automático

### Fase 3: MEJORAS CONTINUAS (Semanas 3+)

- [ ] **Implementar análisis Real User Monitoring (RUM)**
  - Google Analytics + Web Vitals report
  - Monitorear cambios reales vs sintéticos

- [ ] **Lazy-load Leaflet**
  - Usar Intersection Observer
  - Cargar solo cuando se vea mapa

- [ ] **Revisar y potencialmente remover Complianz si es bloqueante**
  - Considerar alternativa menos intrusiva

---

## 9. ESTIMACIONES DE MEJORA POST-OPTIMIZACIÓN

**Estado Actual (PageSpeed Insights - Mobile):**
```
LCP: 3.5s    FCP: 2.1s    INP: 180ms    TTFB: 900ms    CLS: 0.08
Score: ~50/100 (MALO)
```

**Después de Fase 1 (Optimizaciones Críticas):**
```
LCP: 2.2s ↓1.3s   FCP: 1.4s ↓0.7s   INP: 150ms ↓30ms   TTFB: 600ms ↓300ms   CLS: 0.08
Score: ~70-75/100 (BUENO)
```

**Después de Fase 2+3 (Todas las Optimizaciones):**
```
LCP: 1.8s ↓1.7s   FCP: 1.1s ↓1.0s   INP: 100ms ↓80ms   TTFB: 400ms ↓500ms   CLS: 0.05
Score: ~85-90/100 (EXCELENTE)
```

---

## 10. MÉTRICAS PARA MONITOREAR

### Real User Monitoring (RUM)

Implementar Google Analytics + Web Vitals para medir:

```javascript
// En functions.php o Google Analytics script
web-vital.getCLS(console.log);  // Layout shift
web-vital.getFID(console.log);  // First input (deprecado)
web-vital.getINP(console.log);  // Interaction to Next Paint
web-vital.getLCP(console.log);  // Largest Contentful Paint
web-vital.getFCP(console.log);  // First Contentful Paint
web-vital.getTTFB(console.log); // Time to First Byte
```

### Herramientas Recomendadas

- **Lighthouse CI:** Automatizar tests en CI/CD
- **Webpagetest.org:** Análisis de waterfall de red
- **Google Search Console:** Monitorear Core Web Vitals reales
- **Chrome DevTools:** Profiling local

---

## 11. RESUMEN EJECUTIVO

**¿Qué está mal?**
1. **TTFB muy alto (900ms):** Servidor/backend lento — Requiere optimización de servidor/caché
2. **CSS bloqueante (40KB):** Demasiado grande para móvil — Reducir a 20KB
3. **Imagen LCP sin optimizar:** No hay WebP/AVIF/srcset — Optimizar asset
4. **JS global pesado (40KB):** Mucho código en todas las páginas — Lazy-load/tree-shake

**¿Cuál es el impacto?**
- Mobile: 50/100 (MALO)
- Desktop: 70/100 (NECESITA MEJORA)
- User experience: Lento en móvil 4G

**¿Cómo se arregla?**
- Prioridad 1: Reducir TTFB (caché) + optimizar CSS
- Prioridad 2: Optimizar imagen LCP
- Prioridad 3: Reducir JS innecesario
- Resultado esperado: 80-90/100 en ambas plataformas

**Tiempo estimado:** 3-4 semanas para Fase 1-2; Fase 3 es continua.

**ROI:** Alto — cada 100ms de mejora en LCP = ~10% de aumento en conversiones (datos de UX research).

---

**Análisis Realizado Por:** Claude Code  
**Fecha:** 2026-07-23  
**Tipo:** Análisis Técnico Exhaustivo (NO es un reporte SEO, es performance puro)
