# Build Tasks: Arriendo Fácil 2.0

**Fecha:** Septiembre 1, 2026  
**Feature Slug:** `arriendo-facil-v2`  
**Stack:** WordPress + CSS Variables + Vanilla JS

---

## Cómo usar este documento

- [ ] Tarea pendiente
- [x] Tarea completada

Cada fase debe completarse **en orden**. No saltes fases. Si un task depende de otro, se indica con `→ depende de`.

---

## FASE 1: Setup & Base Styles

Implementar el sistema de design tokens y componentes base en CSS.

### 1.1 Crear archivo de variables CSS

- [ ] Crear archivo `.design/arriendo-facil-v2/tokens.css` con todas las variables del DESIGN_TOKENS.md
- [ ] Declararlas en `:root` (colores, tipografía, espaciado, sombras, radios, breakpoints)
- [ ] Validar que no entren en conflicto con estilos existentes en `style.css`
- [ ] Documentar qué variables sobrescriben cuáles

### 1.2 Implementar estilos base

- [ ] Reset CSS (html, body, * { box-sizing: border-box })
- [ ] Body: font, color, background
- [ ] Headings (h1-h6) con variables de tamaño + peso
- [ ] Párrafos (p) con line-height y color
- [ ] Links (a) con color y hover state
- [ ] Tabla de estilos verificada en browser

### 1.3 Implementar componentes base

- [ ] Botón (`.btn`, `.btn--primary`, `.btn--secondary`, `.btn--outline`)
- [ ] Botón: hover, active, focus states
- [ ] Botón: tamaños (sm, md, lg)
- [ ] Card (`.card` con sombra, border, padding)
- [ ] Card: hover state (sombra más grande, lift)
- [ ] Input/Textarea/Select (`.form-control`) con focus state
- [ ] Verificar accesibilidad (focus visible, color contrast)

### 1.4 Implementar utilities

- [ ] Spacing utilities (mt-0, mt-2, mt-4, mb-4, mb-8, px-4, py-6)
- [ ] Grid utilities (`.grid`, `.grid-2`, `.grid-3`, `.grid-4`)
- [ ] Flex utilities (`.flex`, `.flex-center`, `.flex-between`, `.gap-md`, `.gap-lg`)
- [ ] Text utilities (`.text-center`, `.text-primary`, `.text-secondary`, `.text-bold`, `.text-sm`, `.text-xs`)
- [ ] Container utility (`.container` con max-width)
- [ ] Responsive validadas en mobile (375px), tablet (768px), desktop (1024px)

### 1.5 Verificar con inspector

- [ ] Abrir browser, inspeccionar elementos
- [ ] Colores correctos en headings, buttons, links
- [ ] Tipografía: tamaños, pesos, line-heights correctos
- [ ] Espaciado: padding, margin consistentes
- [ ] Sombras: sutiles en cards, prominentes en hover
- [ ] Todos los tamaños de fuente responden a media queries

**Salida esperada:** `tokens.css` + actualizaciones en `style.css` con componentes base funcionales.

---

## FASE 2: Header & Navigation

Implementar header sticky, logo, nav links, y hamburger menu en mobile.

### 2.1 Estructura HTML del header

- [ ] Crear `header.php` (o actualizar el existente) con:
  - [ ] Logo (imagen o SVG) linked a home
  - [ ] Nav lista: Home, Blog, Contacto
  - [ ] CTA Button: "Solicitar Demo"
  - [ ] Hamburger menu (☰) para mobile
- [ ] Estructura semántica: `<header>`, `<nav>`, `<ul>`, `<li>`, `<a>`

### 2.2 CSS del header

- [ ] Estilos base: bg, padding, display flex
- [ ] Header sticky: `position: sticky; top: 0; z-index: 100;`
- [ ] Sombra suave debajo del header
- [ ] Logo size (max 60px height)
- [ ] Nav links: color, hover state (subrayado verde)
- [ ] CTA Button: verde dólar, hover states

### 2.3 Mobile menu (hamburger)

- [ ] Botón hamburger: visible solo en <768px
- [ ] Botón: cursor pointer, hover state
- [ ] Menu toggle: clase `.menu-active` que muestra/oculta menu
- [ ] Menu desplegable: posición absolute, overlay en mobile
- [ ] Menu items apilados (stack vertical)
- [ ] Click en logo o item cierra menu

### 2.4 JavaScript del header

- [ ] Escuchar click en hamburger button
- [ ] Toggle clase `.menu-active` en nav
- [ ] Click en nav item o logo → cierra menu
- [ ] Escuchar escape key → cierra menu
- [ ] Smooth scroll a secciones (opcional, para enlaces internos)

### 2.5 Accesibilidad

- [ ] Hamburger button tiene `aria-label="Abrir menú"`
- [ ] Menu tiene `aria-expanded="true/false"`
- [ ] Links son tabulables (`:focus` visible)
- [ ] Contraste de color WCAG AA en nav links

**Salida esperada:** Header sticky funcional, responsive, accesible.

---

## FASE 3: Hero Section

Landing page principal. Pitch claro, subheadline, CTAs, imagen.

### 3.1 Estructura HTML

- [ ] Sección con clase `.hero`
- [ ] Container dentro
- [ ] Div `.hero__content` (texto lado izq desktop)
  - [ ] H1: "Operación de propiedades sin el estrés"
  - [ ] Subheadline: "Gestiona cuotas, servicios y pagos en un lugar. Deja la ocupación a otros."
  - [ ] 2 Botones: "Ver Demo" (primario) + "Contactar" (secundario)
- [ ] Div `.hero__image` (imagen lado der desktop)
  - [ ] Placeholder o imagen real del dashboard/ilustración

### 3.2 CSS del hero

- [ ] Background: blanco o gris suave (#F2F2F2)
- [ ] Padding vertical: `--spacing-20` (80px) desktop, `--spacing-12` (48px) mobile
- [ ] Layout desktop: flex 60/40 (texto/imagen)
- [ ] Layout mobile: stack vertical (texto arriba, imagen abajo)
- [ ] H1: `--font-size-h1` (48px desktop, 32px mobile), azul marino, bold
- [ ] Subheadline: `--font-size-body-lg` (18px), gris medio, normal weight
- [ ] Botones: spacing entre ellos, responsivos
- [ ] Imagen: max-width 100%, aspect-ratio 16:9

### 3.3 Animaciones

- [ ] Fade-in suave al cargar (elemento `.fade-in`)
- [ ] H1 anima primero, luego subheadline, luego buttons (staggered)
- [ ] Imagen anima desde abajo (translateY)
- [ ] Animations respetan `prefers-reduced-motion`

### 3.4 Responsive

- [ ] Desktop (1024px+): 60/40 lado a lado
- [ ] Tablet (768px): stack pero con buena proporción
- [ ] Mobile (<768px): full stack, padding reducido

**Salida esperada:** Hero section atractivo, responsive, con animaciones sutiles.

---

## FASE 4: Problema Section (Pain Points)

4 cards mostrando dolores comunes de operadores.

### 4.1 Estructura HTML

- [ ] Sección con clase `.problema`
- [ ] H2: "El problema con la gestión manual"
- [ ] Grid de 4 cards: `.grid-4` (o `.grid-2` mobile)
- [ ] Cada card:
  - [ ] Icono/emoji (❌ o ⚠️)
  - [ ] H3: título del dolor
  - [ ] P: descripción breve

### 4.2 Contenido (4 dolores)

- [ ] Card 1: "Cuotas en Excel, pagos perdidos"
- [ ] Card 2: "Sin visibilidad sobre deudas de inquilinos"
- [ ] Card 3: "Alícuotas imposibles de explicar"
- [ ] Card 4: "Crecimiento detenido por gestión manual"

### 4.3 CSS de cards

- [ ] Usar componente `.card` (border, sombra, padding, radius)
- [ ] Color de fondo: blanco
- [ ] Icono: tamaño 48px, color rojo/naranja (#F44336 o #FF6F00)
- [ ] H3: `--font-size-h4`, azul marino
- [ ] P: `--font-size-body-sm`, gris medio
- [ ] Hover state: sombra aumenta, card sube 2px

### 4.4 Responsive

- [ ] Desktop: 4 cards en grid 2x2
- [ ] Tablet: 2 cards por fila
- [ ] Mobile: 1 card por fila (stack)

### 4.5 Accesibilidad

- [ ] Heading hierarchy: H2 → H3
- [ ] Alto contraste en text
- [ ] Cards tabulables si son clickeable (no obligatorio)

**Salida esperada:** 4 cards de dolor, responsive, con hover effects.

---

## FASE 5: Solución Section (How We Solve)

Presentar la propuesta de forma clara y tangible.

### 5.1 Estructura HTML

- [ ] Sección con clase `.solucion`
- [ ] H2: "Cómo lo resolvemos"
- [ ] Layout: 2 columnas (imagen | texto) o stacked mobile
  - [ ] Div `.solucion__image`: Imagen central (dashboard screenshot o ilustración)
  - [ ] Div `.solucion__content`:
    - [ ] 4 puntos con checkmarks verdes ✓
    - [ ] Cada punto: H3 + descripción breve

### 5.2 Contenido (4 puntos)

- [ ] ✓ "Cuotas Centralizadas" + descripción
- [ ] ✓ "Servicios Automáticos" + descripción
- [ ] ✓ "Alícuotas Transparentes" + descripción
- [ ] ✓ "Control de Pagos" + descripción

### 5.3 CSS de solución

- [ ] Layout desktop: 50/50 flex
- [ ] Layout mobile: stack vertical
- [ ] Imagen: max-width 100%, aspect-ratio 16:9, rounded corners
- [ ] Checkmark: ✓ en verde dólar (#7DBE52), tamaño 24px, bold
- [ ] H3 y P: tipografía base con spacing
- [ ] Background: blanco o gris suave alternado con hero

### 5.4 Animaciones

- [ ] Imagen anima desde izquierda en scroll
- [ ] Puntos avanzan staggered desde abajo
- [ ] Subtles, sin distraer

**Salida esperada:** Sección clara mostrando cómo resuelves el problema.

---

## FASE 6: Características Section

4 grandes cards mostrando módulos principales.

### 6.1 Estructura HTML

- [ ] Sección con clase `.caracteristicas`
- [ ] H2: "Características Principales"
- [ ] Grid de 4 cards: `.grid-4` (→ 2 cols tablet, 1 mobile)
- [ ] Cada card:
  - [ ] Icono grande (📊 💰 📋 ✓)
  - [ ] H3: nombre del módulo
  - [ ] P: descripción
  - [ ] Link "Más info →" (opcional)

### 6.2 Contenido (4 características)

- [ ] 📊 "Control de Cuotas" + descripción
- [ ] 💰 "Gestión de Servicios" + descripción
- [ ] 📋 "Alícuotas" + descripción
- [ ] ✓ "Control de Pagos" + descripción

### 6.3 CSS de cards

- [ ] Usar componente `.card`
- [ ] Icono: 48px, color verde dólar, centrado arriba
- [ ] H3: `--font-size-h4`, azul marino
- [ ] P: `--font-size-body-sm`, gris medio
- [ ] Link: verde con hover subrayado
- [ ] Hover state: sombra grande, lift

### 6.4 Responsive

- [ ] Desktop: 4 cards en fila (grid-4)
- [ ] Tablet: 2x2 grid
- [ ] Mobile: 1 card por fila

**Salida esperada:** 4 feature cards grandes, responsivas, con iconos.

---

## FASE 7: Social Proof Section

Stats o testimonial para generar confianza.

### 7.1 Estructura HTML (opción: Stats)

- [ ] Sección con clase `.social-proof` (o `.stats`)
- [ ] Background: gris suave (#F2F2F2)
- [ ] Container con 3 columnas:
  - [ ] Stat 1: "150+" + "Propiedades Gestionadas"
  - [ ] Stat 2: "98%" + "Tasa de Ocupación"
  - [ ] Stat 3: "+25%" + "Rentabilidad"

### 7.2 CSS de stats

- [ ] Layout: 3 columnas desktop, 1 mobile
- [ ] Número grande: `--font-size-h1` (48px), verde dólar, bold
- [ ] Label: `--font-size-body`, gris medio
- [ ] Centra todo
- [ ] Línea divisora entre stats (opcional)

### 7.3 Accesibilidad

- [ ] Números con `aria-label` descriptivo

**Salida esperada:** Sección de confianza con 3 stats destacadas.

---

## FASE 8: Blog Preview Section

3 posts destacados mostrando expertise.

### 8.1 Estructura HTML

- [ ] Sección con clase `.blog-preview`
- [ ] H2: "Insights sobre Gestión de Propiedades"
- [ ] Grid de 3 posts: `.grid-3` (→ 1 mobile)
- [ ] Cada post card:
  - [ ] Imagen featured (aspect-ratio 16:9)
  - [ ] H3: título del post
  - [ ] P: extracto (máx 100 caracteres)
  - [ ] Fecha: "Sep 1, 2026"
  - [ ] Link "Leer más →"

### 8.2 Posts iniciales (placeholder)

- [ ] "5 errores comunes en la gestión de alícuotas"
- [ ] "Cómo automatizar cuotas sin perder control"
- [ ] "Guía: servicios básicos en arriendos"

### 8.3 CSS de posts

- [ ] Usar componente `.card` base
- [ ] Imagen: full-width, rounded top, aspect-ratio 16:9
- [ ] H3: `--font-size-h4`, azul marino
- [ ] P: `--font-size-body-sm`, gris medio, 2-3 líneas (ellipsis)
- [ ] Fecha: `--font-size-body-xs`, gris claro
- [ ] Link: verde con → arrow
- [ ] Hover state: imagen scale, card lift

### 8.4 Responsive

- [ ] Desktop: 3 posts en fila
- [ ] Tablet: 2 posts
- [ ] Mobile: 1 post por fila

### 8.5 Footer de sección

- [ ] Link "Ver todos los posts →" al final
- [ ] Link lleva a `/blog` (crear después)

**Salida esperada:** Grid de 3 blog posts, responsivo, con hover effects.

---

## FASE 9: CTA Final Section

Full-width call-to-action para convertir.

### 9.1 Estructura HTML

- [ ] Sección con clase `.cta-final`
- [ ] Background: Verde dólar (#7DBE52) o Azul marino (#1D2D44)
- [ ] Container con:
  - [ ] H2: "Empieza a gestionar propiedades como un profesional"
  - [ ] Subheadline: "Habla con nosotros hoy"
  - [ ] 2 Botones:
    - [ ] "Solicitar Demo" (primario, blanco text)
    - [ ] "Hablar con ventas" (secundario, outline)

### 9.2 CSS de CTA

- [ ] Padding vertical: `--spacing-16` (64px) desktop, `--spacing-12` (48px) mobile
- [ ] Text center align
- [ ] H2: blanco, `--font-size-h2`, bold
- [ ] Subheadline: blanco/light gray, `--font-size-body-lg`
- [ ] Botones: arriba o lado a lado (flex)
- [ ] Botón primario: bg blanco, text azul marino
- [ ] Botón secundario: border blanco, text blanco

### 9.3 Interactividad

- [ ] Botón "Solicitar Demo": abre form o redirect a Calendly
- [ ] Botón "Hablar con ventas": abre contact form

### 9.4 Accesibilidad

- [ ] Botones tabulables
- [ ] Contraste blanco sobre color de fondo ✓

**Salida esperada:** CTA section atractiva y convertible.

---

## FASE 10: Footer

Navegación, links, contacto, copyright.

### 10.1 Estructura HTML

- [ ] Footer con clase `.footer`
- [ ] 4 columnas (desktop):
  - [ ] Col 1: Logo + descripción breve
  - [ ] Col 2: Links (Home, Blog, Contacto)
  - [ ] Col 3: Legales (Privacidad, Términos)
  - [ ] Col 4: Contacto (email, phone, sociales)
- [ ] Bottom: Copyright

### 10.2 Contenido

- [ ] Logo
- [ ] "Arriendo Fácil - Gestión profesional de propiedades"
- [ ] Links: Home, Blog, Contacto
- [ ] Links legales: Política de Privacidad, Términos de Servicio
- [ ] Contacto: email, teléfono
- [ ] Sociales: LinkedIn
- [ ] Copyright: "© 2026 Arriendo Fácil. Todos los derechos reservados."

### 10.3 CSS de footer

- [ ] Background: azul marino (#1D2D44)
- [ ] Text: blanco
- [ ] Padding: `--spacing-12` (48px) desktop, `--spacing-8` (32px) mobile
- [ ] Layout desktop: 4 cols grid
- [ ] Layout mobile: stack vertical
- [ ] Links: verde hover
- [ ] Border-top: sombra suave

### 10.4 Responsive

- [ ] Desktop: 4 columnas
- [ ] Tablet: 2 columnas
- [ ] Mobile: 1 columna (stack)

**Salida esperada:** Footer funcional, responsive, accesible.

---

## FASE 11: Blog Page (MVP)

Página de listado de posts (MVP simple).

### 11.1 Estructura HTML

- [ ] Crear `page-blog.php` o `/blog/index.php`
- [ ] Header + Hero pequeño
- [ ] Grid de posts (todas, no solo 3)
- [ ] Paginación (10 posts por página)
- [ ] Search/filter (opcional para MVP)

### 11.2 Contenido

- [ ] Query posts de categoría "blog" o tipo "post"
- [ ] Mostrar featured image, título, extracto, fecha
- [ ] Link a post completo

### 11.3 CSS de grid

- [ ] Reutilizar `.card` de blog preview
- [ ] `.grid-3` responsive
- [ ] Consistencia visual con resto del sitio

### 11.4 Post individual (single.php)

- [ ] Mostrar: título, fecha, contenido completo
- [ ] Sidebar: posts relacionados (opcional)
- [ ] CTA al final: "Solicitar Demo"

**Salida esperada:** Blog page functional, MVP simple.

---

## FASE 12: Contacto Page (MVP)

Página de contacto con form o info.

### 12.1 Estructura HTML

- [ ] Crear `page-contacto.php`
- [ ] Header + Hero pequeño ("Contacto")
- [ ] Div `.contact-container`:
  - [ ] Form: nombre, email, mensaje
  - [ ] O: info de contacto directo + form tipo Calendly

### 12.2 Form HTML

- [ ] Input: nombre (required)
- [ ] Input: email (required)
- [ ] Textarea: mensaje
- [ ] Button: "Enviar" (verde dólar)

### 12.3 Form CSS

- [ ] Usar componentes `.form-control`
- [ ] Labels sobre inputs
- [ ] Spacing consistente
- [ ] Focus state: border verde
- [ ] Error state: border rojo, mensaje error rojo

### 12.4 Form JS (básico)

- [ ] Validar campos requeridos
- [ ] Validar email format
- [ ] On submit: enviar via AJAX o POST (usar plugin existente o email)
- [ ] Success message: "Gracias, nos contactaremos pronto"

**Salida esperada:** Contacto page simple, functional.

---

## FASE 13: Responsive & Testing

Validar que TODO funciona en todos los tamaños.

### 13.1 Desktop (1280px)

- [ ] Abrir en navegador a 1280px
- [ ] Inspeccionar cada sección
- [ ] Colores correctos
- [ ] Typography: headings grandes, body legible
- [ ] Spacing: padding/margin consistentes
- [ ] Botones: tamaño y color correcto
- [ ] Hover states: funcionales
- [ ] Layout: no overflow, no gaps raros

### 13.2 Tablet (768px)

- [ ] Redimensionar a 768px
- [ ] Hamburger menu aparece
- [ ] Grid 4 → 2 cols
- [ ] Grid 3 → 2 cols (con fallback a 1 si es necesario)
- [ ] Imagen/texto ajustan bien
- [ ] Spacing se reduce apropiadamente
- [ ] Botones: tamaño toca bien en touch

### 13.3 Mobile (375px)

- [ ] Redimensionar a 375px (iPhone SE)
- [ ] Todo stack vertical
- [ ] Texto legible (no muy pequeño)
- [ ] Botones: toca fácil (48px+ height)
- [ ] Imágenes: full width con padding
- [ ] No hay scroll horizontal
- [ ] Heading tamaños reducidos (h1 32px, etc)

### 13.4 Browser testing

- [ ] Chrome/Edge (Chromium)
- [ ] Firefox
- [ ] Safari (si tienes Mac)
- [ ] Mobile Safari (iOS simulator)

### 13.5 Accesibilidad

- [ ] Tab navigation: funciona en todos los links y botones
- [ ] Color contrast: WCAG AA ✓ (tools: WAVE, Axe)
- [ ] Alt text: todas las imágenes tienen alt
- [ ] Heading hierarchy: h1 → h2 → h3, no se salta
- [ ] Focus indicators: visible al tabular

### 13.6 Performance

- [ ] Lighthouse Chrome: PageSpeed > 85
- [ ] LCP (Largest Contentful Paint): < 2.5s
- [ ] FID (First Input Delay): < 100ms
- [ ] CLS (Cumulative Layout Shift): < 0.1
- [ ] Images optimizadas (WebP, lazy-load)
- [ ] Minify CSS/JS

**Salida esperada:** Sitio fully responsive, accesible, performante.

---

## FASE 14: Blog Content

Crear 3 posts iniciales (content creation).

### 14.1 Posts iniciales

- [ ] **Post 1:** "5 errores comunes en la gestión de alícuotas"
  - [ ] 800-1200 palabras
  - [ ] Featured image
  - [ ] Escrito, optimizado SEO

- [ ] **Post 2:** "Cómo automatizar cuotas sin perder control"
  - [ ] 800-1200 palabras
  - [ ] Featured image
  - [ ] Escrito, optimizado SEO

- [ ] **Post 3:** "Guía: servicios básicos en arriendos"
  - [ ] 800-1200 palabras
  - [ ] Featured image
  - [ ] Escrito, optimizado SEO

### 14.2 SEO basics

- [ ] Título compelling
- [ ] Meta description (160 chars)
- [ ] Slug URL-friendly
- [ ] Imagen optimizada (< 200KB)
- [ ] Internal links a otros posts

**Salida esperada:** 3 posts publicados, SEO-friendly.

---

## FASE 15: Refinamientos Finales

Detalles, polish, verificación final.

### 15.1 Transiciones & animaciones

- [ ] Fade-in en scroll para secciones
- [ ] Hover states en todas las cards
- [ ] Button press effect (scale small)
- [ ] Smooth scroll entre secciones
- [ ] Todas las animaciones respetan `prefers-reduced-motion`

### 15.2 Dark mode (opcional)

- [ ] Implementar variables dark mode en CSS
- [ ] Probar en navegador `prefers-color-scheme: dark`
- [ ] Todos los colores legibles en dark mode

### 15.3 SEO & Meta

- [ ] Meta title: "Arriendo Fácil | Gestión Profesional de Propiedades"
- [ ] Meta description: pitch de 160 chars
- [ ] OG tags: og:title, og:description, og:image
- [ ] Favicon: visible en pestaña
- [ ] robots.txt & sitemap.xml (si aplicable)

### 15.4 Verificación final

- [ ] [ ] Zero console errors
- [ ] [ ] Todos los links funcionan
- [ ] [ ] Formularios envían correctamente
- [ ] [ ] Mobile funciona en dispositivo real (si posible)
- [ ] [ ] Performance > 85 en Lighthouse
- [ ] [ ] Accesibilidad > 90 en Lighthouse
- [ ] [ ] SEO checklist completo

**Salida esperada:** Sitio pulido, ready para deployment.

---

## FASE 16: Deployment & Go Live

Subir a producción.

### 16.1 Pre-deployment

- [ ] Backup base de datos
- [ ] Backup de archivos
- [ ] Test en staging (si existe)
- [ ] QA final en staging

### 16.2 Deployment

- [ ] Subir archivos CSS/JS a servidor
- [ ] Verificar que los cambios son visibles
- [ ] Testear en producción (smoke test)
- [ ] Verificar que el tracking de analytics funciona

### 16.3 Post-deployment

- [ ] Anunciar internamente (equipo)
- [ ] Monitorear errores (Sentry o logs)
- [ ] Feedback de usuarios
- [ ] Arreglar bugs críticos ASAP

**Salida esperada:** Sitio en vivo, funcional, monitoreado.

---

## Resumen por Fase

| Fase | Duración Estimada | Entregable |
|------|-------------------|-----------|
| 1. Setup & Base Styles | 2-3 días | tokens.css + componentes base |
| 2. Header & Nav | 1-2 días | Header sticky, mobile menu |
| 3. Hero | 1-2 días | Hero section responsive |
| 4. Problema | 1 día | 4 pain point cards |
| 5. Solución | 1 día | Solution section |
| 6. Características | 1 día | 4 feature cards |
| 7. Social Proof | 0.5 días | Stats section |
| 8. Blog Preview | 1 día | 3 blog cards |
| 9. CTA Final | 0.5 días | CTA section |
| 10. Footer | 1 día | Footer complete |
| 11. Blog Page | 2-3 días | Blog listing + single post |
| 12. Contacto | 1-2 días | Contact form |
| 13. Responsive & Test | 2-3 días | Cross-browser testing |
| 14. Blog Content | 3-5 días | 3 posts creados |
| 15. Refinamientos | 2-3 días | Polish, animations, dark mode |
| 16. Deployment | 1 día | Go live |
| **TOTAL** | **~25-35 días** | **Landing page lista** |

---

## Dependencias Clave

```
FASE 1 (Setup)
    ↓ depende de nada
FASES 2-10 (Componentes)
    ↓ depende de FASE 1
FASE 11-12 (Pages)
    ↓ depende de FASES 2-10
FASE 13 (Testing)
    ↓ depende de FASES 2-12
FASE 14 (Content)
    ↓ paralelo a FASES 2-12
FASE 15 (Polish)
    ↓ depende de todas las anteriores
FASE 16 (Deployment)
    ↓ depende de FASE 15 + 14
```

---

**Status:** ✅ Checklist de construcción completo  
**Próxima fase:** Frontend Design (CONSTRUIR)

Vamos a comenzar con **FASE 1: Setup & Base Styles**. ¿Listo?
