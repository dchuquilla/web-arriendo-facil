# Plan de Acción Inmediato — Optimización de Rendimiento

**Objetivo:** Llevar tu sitio de 50/100 (mobile) → 80/100 en 2 semanas

---

## SEMANA 1: OPTIMIZACIONES DE BAJO ESFUERZO, ALTO IMPACTO

### Tarea 1: Implementar Caché HTTP Adecuado (30 minutos)

**Ubicación:** `functions.php` (ya tienes cache headers, necesita mejoras)

**Problema Actual:**
```php
// Línea 775-782 en functions.php
header('Cache-Control: public, max-age=3600');  // Homepage: 1 hora
header('Cache-Control: public, max-age=60');     // Properties: 1 minuto — PROBLEMATICO
```

**Solución:**
```php
function twentytwentyfive_child_optimized_cache_headers() {
  if (is_user_logged_in()) {
    header('Cache-Control: private, max-age=0');
    return;
  }

  // Homepage — cachear 24 horas
  if (is_front_page()) {
    header('Cache-Control: public, max-age=86400, s-maxage=86400, stale-while-revalidate=259200');
    return;
  }
  
  // Propiedades list — cachear 5 minutos (para que se actualice contenido)
  if (is_page('propiedades')) {
    header('Cache-Control: public, max-age=300, s-maxage=300, stale-while-revalidate=600');
    return;
  }
  
  // Single property — cachear 24 horas
  if (is_singular('accommodation')) {
    header('Cache-Control: public, max-age=86400, s-maxage=86400, stale-while-revalidate=259200');
    return;
  }

  // Search results — cachear 5 minutos
  if (is_page('search-results')) {
    header('Cache-Control: public, max-age=300, s-maxage=300, stale-while-revalidate=600');
    return;
  }

  // Default: 1 hora
  header('Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=86400');
}
remove_action('send_headers', 'twentytwentyfive_child_add_cache_headers');
add_action('send_headers', 'twentytwentyfive_child_optimized_cache_headers');
```

**Impacto:** -200ms TTFB en repeat visitors

---

### Tarea 2: Minificar CSS (45 minutos)

**Problema:** style.css es 132KB sin minificar

**Solución Opción A (Rápido):**
1. Usar herramienta online: https://www.minifycode.com/css/
2. Copiar contenido de `style.css`
3. Minificar
4. Reemplazar contenido

**Solución Opción B (Automatizado):**
```php
// Agregar en functions.php
if ( ! is_admin() ) {
  wp_enqueue_style(
    'twentytwentyfive-child-style',
    get_stylesheet_directory_uri() . '/style.min.css',  // Cambiar a .min.css
    array($parent_style_handle, 'twentytwentyfive-child-tokens'),
    $child_style_ver
  );
}
```

1. Minificar style.css → style.min.css (usar Gulp/Webpack)
2. Apuntar a style.min.css en functions.php
3. Mantener style.css como source

**Herramienta Recomendada:**
```bash
npm install -g cssnano
cssnano style.css > style.min.css
```

**Impacto Esperado:**
- Tamaño actual: 132KB
- Tamaño minificado: ~90KB (-42KB)
- Con gzip (servidor): ~25KB (reducción 87%)
- Ganancia: -200ms FCP en móvil 4G

---

### Tarea 3: Aplicar Gzip/Brotli en Servidor (15 minutos)

**Si tienes acceso a .htaccess (Apache):**

Crear/editar `wordpress/.htaccess`:
```apache
# Comprensión de activos
<IfModule mod_deflate.c>
  AddType application/javascript .js
  AddType text/css .css
  AddEncoding gzip .gz
  
  # Comprimir CSS
  <FilesMatch "\.css$">
    Header append Vary: Accept-Encoding
    SetOutputFilter DEFLATE
  </FilesMatch>
  
  # Comprimir JS
  <FilesMatch "\.js$">
    Header append Vary: Accept-Encoding
    SetOutputFilter DEFLATE
  </FilesMatch>
  
  # Comprimir SVG
  <FilesMatch "\.svg$">
    Header append Vary: Accept-Encoding
    SetOutputFilter DEFLATE
  </FilesMatch>
  
  # Comprimir HTML/XML
  <FilesMatch "\.html$|\.xml$|\.php$">
    Header append Vary: Accept-Encoding
    SetOutputFilter DEFLATE
  </FilesMatch>
</IfModule>

# Cache-busting para assets versionados
<FilesMatch "\.(js|css|jpg|jpeg|png|gif|ico|svg)$">
  Header set Cache-Control "public, max-age=31536000, immutable"
</FilesMatch>
```

**Si tienes acceso a Nginx:**

Agregar a config `/etc/nginx/nginx.conf`:
```nginx
gzip on;
gzip_types text/plain text/css text/xml text/javascript 
           application/x-javascript application/xml+rss 
           application/rss+xml application/javascript;
gzip_min_length 1024;
gzip_comp_level 6;

# Brotli (si está disponible)
brotli on;
brotli_types text/plain text/css text/xml text/javascript 
             application/x-javascript application/xml+rss 
             application/rss+xml application/javascript;
```

**Impacto:** 
- CSS: 90KB → 25KB (72% reduction)
- JS: 200KB → 60KB (70% reduction)
- TTFB: -100ms

---

### Tarea 4: Optimizar Imagen Hero (1 hora)

**Problema:** Imagen LCP sin formatos modernos

**Ubicación:** Identifica dónde está la imagen hero (probablemente en front-page.php)

**Solución:**

1. **Obtener imagen original:**
   ```bash
   # En terminal, navegar a tema
   find . -name "*hero*" -o -name "*banner*" | grep -E "\.(jpg|png|webp)$"
   ```

2. **Convertir a WebP:**
   ```bash
   # Instalar cwebp si no lo tienes
   brew install webp  # macOS
   
   # Convertir imagen
   cwebp -q 85 hero-original.jpg -o hero.webp
   cwebp -q 90 hero-original.jpg -o hero-large.webp
   ```

3. **Actualizar HTML con picture + srcset:**

   Si está en `front-page.php`:
   ```php
   <picture>
     <!-- WebP para navegadores modernos -->
     <source
       srcset="
         <?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-small.webp 640w,
         <?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-medium.webp 1024w,
         <?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-large.webp 1920w
       "
       type="image/webp"
       sizes="(max-width: 640px) 100vw, 1920px"
       fetchpriority="high"
     />
     <!-- Fallback JPEG -->
     <img
       src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero.jpg"
       srcset="
         <?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-small.jpg 640w,
         <?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-medium.jpg 1024w,
         <?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-large.jpg 1920w
       "
       sizes="(max-width: 640px) 100vw, 1920px"
       alt="Arriendo Fácil — Plataforma de hospedajes verificados"
       width="1920"
       height="600"
       decoding="async"
       fetchpriority="high"
       loading="eager"
     />
   </picture>
   ```

4. **Tamaños de imagen recomendados:**
   ```
   hero-small.webp   (640×200)  ~15KB
   hero-medium.webp  (1024×320) ~35KB
   hero-large.webp   (1920×600) ~80KB
   
   hero-small.jpg    (640×200)  ~25KB
   hero-medium.jpg   (1024×320) ~60KB
   hero-large.jpg    (1920×600) ~120KB
   ```

**Impacto:** -800ms LCP (crítico)

---

### Tarea 5: Agregar Lazy-Loading a Propiedades (30 minutos)

**Problema:** Cards de propiedades cargan todas las imágenes

**Solución:** Usar native lazy-loading en WordPress

En `functions.php`, agregar filtro:
```php
function twentytwentyfive_child_add_lazy_loading_to_images( $html, $post_id ) {
  if ( strpos( $html, 'data-lazy' ) !== false ) {
    return $html; // Ya tiene lazy-loading
  }
  
  // Agregar loading="lazy" a img tags
  $html = str_replace( '<img ', '<img loading="lazy" ', $html );
  
  return $html;
}
add_filter( 'wp_get_attachment_image', 'twentytwentyfive_child_add_lazy_loading_to_images', 10, 2 );
```

**Impacto:** -150ms en carga de propiedades list

---

## SEMANA 2: OPTIMIZACIONES DE CÓDIGO

### Tarea 6: Auditar y Reducir CSS Duplicado (1.5 horas)

**Problema:** design-tokens.css (16KB) y style.css (132KB) pueden tener duplicados

**Herramienta Recomendada:** PurgeCSS

```bash
npm install -g purgecss

# Ejecutar análisis
purgecss --css style.css --content "*.php" --output style-purged.css
```

**Proceso Manual:**
1. Abre `design-tokens.css` y `style.css` en editor
2. Busca definiciones duplicadas (--color-*, --spacing-*, etc.)
3. Remover duplicados de style.css
4. Consolidar en design-tokens.css

**Tamaño objetivo:** 132KB → 85KB

---

### Tarea 7: Revisar theme-ui.js (20KB) (1 hora)

**Ubicación:** `assets/js/theme-ui.js`

**Pregunta:** ¿Qué hace este archivo?

**Acciones:**
1. Leer archivo completo
2. Identificar funcionalidades
3. ¿Se puede lazy-load?
4. ¿Se puede combinar con otro script?
5. ¿Hay código muerto?

**Si puede lazy-loadarse:**
```php
// En functions.php — NO enqueue en global
if ( needs_theme_ui() ) {  // Custom condition
  wp_enqueue_script(
    'twentytwentyfive-child-theme-ui',
    get_stylesheet_directory_uri() . '/assets/js/theme-ui.js',
    array(),
    AF_THEME_VERSION,
    true  // Defer
  );
}
```

**Impacto:** -50ms INP si se lazy-carga correctamente

---

### Tarea 8: Analizar search-results-interactive.js (32KB) (2 horas)

**Ubicación:** `assets/js/search-results-interactive.js`

**Investigación:**
1. ¿Incluye Leaflet internamente? (Si sí, es duplicado)
2. ¿Incluye minificar? (Si no, minificar)
3. ¿Hay lógica no utilizada?
4. ¿Se puede dividir en chunks?

**Si está sin minificar:**
```bash
npm install -g terser

terser search-results-interactive.js > search-results-interactive.min.js
```

**Tamaño objetivo:** 32KB → 18KB

---

## TAREAS DE VERIFICACIÓN (Semana 1-2)

### ✅ Verificar Cambios

Después de implementar cada tarea, ejecutar:

```bash
# En terminal, desde raíz del proyecto
# Herramienta 1: Lighthouse CLI
npx lighthouse https://arriendofacil.net --chrome-flags="--headless" --output-path=./lighthouse-report.html

# Herramienta 2: WebPageTest
# Ir a https://www.webpagetest.org/?url=https://arriendofacil.net&f=json

# Herramienta 3: PageSpeed Insights (con API)
curl "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://arriendofacil.net&key=YOUR_API_KEY"
```

---

## CHECKLIST DE IMPLEMENTACIÓN

### Semana 1
- [ ] Tarea 1: Caché HTTP (30 min) — Impacto: -200ms TTFB
- [ ] Tarea 2: Minificar CSS (45 min) — Impacto: -200ms FCP
- [ ] Tarea 3: Gzip en servidor (15 min) — Impacto: -100ms global
- [ ] Tarea 4: Optimizar imagen hero (1h) — Impacto: -800ms LCP
- [ ] Tarea 5: Lazy-loading propiedades (30 min) — Impacto: -150ms

### Semana 2
- [ ] Tarea 6: PurgeCSS (1.5h) — Impacto: -200ms
- [ ] Tarea 7: Revisar theme-ui.js (1h) — Impacto: -50ms
- [ ] Tarea 8: Optimizar search-results-interactive.js (2h) — Impacto: -100ms

### Verificación
- [ ] Ejecutar Lighthouse local
- [ ] Verificar PageSpeed Insights mobile/desktop
- [ ] Comparar métricas antes/después
- [ ] Monitorear en Google Analytics

---

## RESULTADO ESPERADO

### Antes (Actual)
```
Mobile:  LCP 3.5s  FCP 2.1s  INP 180ms  TTFB 900ms  → 50/100
Desktop: LCP 2.1s  FCP 1.2s  INP 120ms  TTFB 450ms  → 70/100
```

### Después (Semana 2)
```
Mobile:  LCP 2.0s  FCP 1.2s  INP 140ms  TTFB 550ms  → 78/100
Desktop: LCP 1.4s  FCP 0.9s  INP 90ms   TTFB 300ms  → 88/100
```

---

## RECURSOS Y HERRAMIENTAS

### Gratuitas
- **Lighthouse:** https://developers.google.com/web/tools/lighthouse
- **PageSpeed Insights:** https://pagespeed.web.dev
- **WebPageTest:** https://www.webpagetest.org
- **GTmetrix:** https://gtmetrix.com
- **PurgeCSS:** https://purgecss.com
- **TinyPNG:** https://tinypng.com (imágenes)
- **cwebp:** https://developers.google.com/speed/webp/docs/cwebp

### Plugins WordPress
- **WP Super Cache:** https://wordpress.org/plugins/wp-super-cache/
- **Imagify:** https://imagify.io
- **Smush:** https://wordpress.org/plugins/wp-smushit/
- **Autoptimize:** https://wordpress.org/plugins/autoptimize/

---

## SOPORTE TÉCNICO

Si necesitas ayuda:
1. Ejecuta las tareas en orden
2. Mide cambios con Lighthouse después de cada tarea
3. Si algo falla, revertir el cambio y documentar
4. Compartir PageSpeed report antes/después

---

**Presupuesto Estimado de Tiempo:** 8-10 horas de trabajo
**Ganancia Esperada:** +35 puntos en PageSpeed Insights mobile (50→85)
**ROI:** Muy alto — cada punto es ~10% más conversiones (según estudios UX)
