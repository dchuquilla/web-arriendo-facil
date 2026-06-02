# Reporte de rendimiento y optimizacion movil

Fecha: 2026-06-02

## Alcance

Se analizo el tema activo del sitio WordPress en:

- `wordpress/wp-content/themes/twentytwentyfive-child/functions.php`
- `wordpress/wp-content/themes/twentytwentyfive-child/header.php`
- `wordpress/wp-content/themes/twentytwentyfive-child/footer.php`
- `wordpress/wp-content/themes/twentytwentyfive-child/assets/js/nav-prefetch.js`
- `wordpress/wp-content/themes/twentytwentyfive-child/assets/js/sw-register.js`
- `wordpress/wp-content/themes/twentytwentyfive-child/assets/js/service-worker.js`
- `wordpress/wp-content/themes/twentytwentyfive-child/assets/js/propiedades.js`
- `wordpress/wp-content/themes/twentytwentyfive-child/assets/js/search-results-interactive.js`

La revision se enfoco en los puntos que mas afectan la experiencia movil: peticiones duplicadas, trabajo global innecesario, bloqueo del hilo principal, cache riesgoso y logica que puede degradar bateria, CPU o red.

## Hallazgos principales

### 1. Prefetch agresivo en navegacion global

Problema:

- El script global de prefetch reaccionaba a `mouseover`, `touchstart` y `mousedown`.
- En dispositivos tactiles esto podia disparar trafico antes del click real.
- En algunos flujos el usuario terminaba generando una peticion de precarga y luego otra navegacion real al mismo recurso.

Impacto estimado:

- Gama baja: alto
- Gama media: medio-alto
- Gama alta: medio

Riesgo funcional:

- Aumento de uso de datos en movil.
- Mas contencion de red en conexiones inestables.
- Sensacion de lentitud cuando compite con peticiones realmente utiles.

### 2. Service worker con cache HTML demasiado amplio

Problema:

- El service worker hacia cache de navegacion HTML y actualizacion en background.
- Eso puede duplicar trafico en cada navegacion cacheada.
- Tambien puede servir HTML obsoleto en un sitio dinamico como WordPress.

Impacto estimado:

- Gama baja: alto
- Gama media: alto
- Gama alta: medio

Riesgo funcional:

- Contenido stale.
- Inconsistencias entre estado real del sistema y lo que ve el usuario.
- Doble carga silenciosa de red por navegacion.

### 3. Polling repetitivo en pagina de propiedades

Problema:

- La pagina `propiedades` mantenia un `setInterval` para consultar novedades.
- Aunque estaba moderado, seguia siendo una consulta recurrente y permanente.
- En movil esto castiga bateria y red, incluso si el usuario no necesita datos en tiempo real.

Impacto estimado:

- Gama baja: alto
- Gama media: medio-alto
- Gama alta: medio

Riesgo funcional:

- Consumo innecesario de API.
- Mayor competencia con imagenes, mapas y solicitudes del usuario.

### 4. Logica global inline en header y footer

Problema:

- El tema ejecutaba JavaScript inline en cada render del `header` y `footer`.
- Ese codigo no era cacheable por el navegador como archivo estatico.
- El efecto de scroll del header no estaba amortiguado.

Impacto estimado:

- Gama baja: medio-alto
- Gama media: medio
- Gama alta: bajo-medio

Riesgo funcional:

- Mas trabajo de parseo y ejecucion por pagina.
- Mayor jank durante scroll.

### 5. Riesgos todavia presentes, no implementados en este corte

Pendientes detectados:

- Fuente externa de Google Fonts cargada desde `header.php`.
- La pagina de resultados ejecuta una carga principal y una carga secundaria de marcadores de fondo; no es un bug, pero todavia tiene costo de red.
- Integraciones externas de geocoding y Overpass API dependen de red publica y pueden penalizar moviles lentos.
- No se ejecuto Lighthouse real ni profiling de CPU porque no se conto con una URL navegable desde este flujo de trabajo.

## Mejoras implementadas

### A. Externalizacion del JavaScript global del tema

Cambios:

- Se creo `assets/js/theme-ui.js`.
- Se movio la logica inline de `header.php` y `footer.php` a un archivo estatico cacheable.
- Se agrego carga diferida desde `functions.php`.
- El efecto de scroll del header ahora usa `requestAnimationFrame` y listener pasivo.

Impacto esperado:

- Menor trabajo repetitivo por pagina.
- Mejor suavidad de scroll en movil.
- Mejor cache del navegador entre paginas.

Nivel de impacto:

- Alto a nivel de mantenibilidad.
- Medio en performance percibida.

### B. Reduccion del prefetch invasivo

Cambios:

- Se desactivo prefetch en dispositivos sin hover fino, evitando la ruta agresiva en tactil.
- Se elimino el disparo por `touchstart` y `mousedown`.
- Se agrego espera breve de hover para no precargar enlaces accidentales.
- Se filtran misma pagina, anclas, login, admin, descargas y `_blank`.
- Se usa `link rel="prefetch"` como mecanismo preferido.

Impacto esperado:

- Menos peticiones redundantes en movil.
- Menor consumo de datos.
- Menos competencia de red con la navegacion real.

Nivel de impacto:

- Alto en gama baja.
- Medio-alto en gama media.
- Medio en gama alta.

### C. Endurecimiento del service worker

Cambios:

- Se limito el registro a contexto seguro o localhost.
- Se difirio el registro hacia tiempo ocioso.
- Se elimino la intercepcion de navegaciones HTML y peticiones a `wp-json`.
- El cache quedo restringido a assets estaticos.

Impacto esperado:

- Menor riesgo de respuestas HTML obsoletas.
- Menos fetch ocultos en background.
- Menor daño colateral sobre la logica del sistema.

Nivel de impacto:

- Alto en estabilidad.
- Alto en control de peticiones duplicadas.

### D. Reduccion del polling continuo en `propiedades`

Cambios:

- Se reemplazo el comportamiento repetitivo por una sola verificacion diferida.
- Se evita polling cuando la pestaña esta oculta.
- Se desactiva en conexiones lentas o con `saveData`.
- Se limpia correctamente el `AbortController` al terminar.

Impacto esperado:

- Menor uso sostenido de CPU, bateria y red.
- Menor presion sobre el endpoint de busqueda.
- Mejor estabilidad en sesiones largas de movil.

Nivel de impacto:

- Alto en gama baja.
- Medio-alto en gama media.
- Medio en gama alta.

## Plan concreto por dispositivo movil

### Objetivo para gama baja

Prioridad maxima:

1. Mantener cero polling continuo salvo casos criticos.
2. Evitar cualquier precarga agresiva en tactil.
3. Reducir terceros y fuentes externas.
4. Comprimir y normalizar imagenes hero, listados y cards.
5. Cachear solo assets estaticos, nunca HTML dinamico del negocio.

Resultado esperado:

- Menor consumo de bateria.
- Menos bloqueos de scroll.
- Mejor tiempo hasta interaccion util en 3G/4G inestable.

### Objetivo para gama media

Prioridad:

1. Mantener scripts globales diferidos y cacheables.
2. Debounce y cache de consultas auxiliares del buscador y mapa.
3. Lazy loading real de imagenes fuera de viewport.
4. Reducir consultas duplicadas entre lista, mapa y marcadores de fondo.

Resultado esperado:

- Navegacion mas consistente.
- Menor jank en pantallas de resultados.

### Objetivo para gama alta

Prioridad:

1. Mantener interacciones fluidas sin sobrecargar el hilo principal.
2. Optimizar perceived performance mas que throughput bruto.
3. Afinar transiciones, render del mapa y carga progresiva visual.

Resultado esperado:

- Experiencia premium sin sobreingenieria.

## Siguiente fase recomendada

### Alta prioridad

1. Autohospedar o sustituir Google Fonts por stack local para reducir dependencia externa.
2. Auditar `search-results-interactive.js` para deduplicar la carga de resultados y marcadores de fondo cuando el dataset ya este disponible.
3. Implementar estrategia de imagen responsive con tamaños reales por breakpoint y formato WebP/AVIF.
4. Ejecutar medicion real con Lighthouse en perfiles moviles: gama baja, media y alta.

### Media prioridad

1. Cachear respuestas no criticas de geocoding/POI con TTL y cancelacion por navegación.
2. Revisar scripts globales como `cookie-wall.js`, `search-bar.js` y `hero-search.js` para inicializacion perezosa por presencia real del DOM.
3. Eliminar cualquier `console.*` restante y listeners no pasivos donde aplique.

## Validacion realizada

Validaciones ejecutadas en este corte:

- `php -l` sobre `functions.php`, `header.php` y `footer.php`.
- Verificacion de sintaxis JavaScript con `node --check` sobre los archivos modificados.
- Revision de errores del editor sobre archivos tocados: sin errores.

## Resumen ejecutivo

Se corrigieron tres focos de alto impacto para moviles:

- peticiones preventivas agresivas,
- cache HTML riesgoso en service worker,
- polling continuo innecesario.

Adicionalmente, se saco logica inline del layout global para volverla cacheable y menos costosa en ejecucion.

El resultado esperado es una mejora sensible en uso de red, estabilidad del render y suavidad de navegacion, especialmente en dispositivos de gama baja y media.