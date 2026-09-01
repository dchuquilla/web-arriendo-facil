# Information Architecture: Arriendo Fácil 2.0

**Fecha:** Septiembre 1, 2026  
**Feature Slug:** `arriendo-facil-v2`

---

## 1. Mapa de Sitio (Site Map)

```
arriendo-facil.ec/
├── / (Home / Landing Page)
│   ├── #hero
│   ├── #problema
│   ├── #solucion
│   ├── #caracteristicas
│   ├── #social-proof
│   ├── #blog-preview
│   ├── #cta-final
│   └── #footer
├── /blog (Blog Index - opcional fase 1)
│   ├── /blog/[slug] (Post Individual)
│   ├── /blog?category=gestion
│   ├── /blog?search=cuotas
│   └── Search & Filter
└── /contacto (Contact - opcional fase 1)
    ├── Form
    └── Info de contacto
```

**Nota:** En esta fase nos enfocamos en **Home + Blog Preview**. `/blog` y `/contacto` pueden ser MVP después.

---

## 2. Navegación

### 2.1 Header/Navbar

**Desktop (1024px+):**
```
[Logo Arriendo Fácil] [Home] [Blog] [Contacto] [CTA - Demo]
```

**Mobile (<768px):**
```
[Logo] [Hamburger Menu ☰]
  ↓
  [Home]
  [Blog]
  [Contacto]
  [CTA - Demo]
```

**Behavior:**
- Sticky en scroll (permanece visible)
- Logo clickeable → Home
- CTA siempre visible y destacado (verde dólar)
- Menu toggle en mobile

---

### 2.2 Footer

**Estructura:**
```
[Logo] [Redes] [Links] [Contacto] [Copyright]
```

**Columns:**
1. **Sobre Arriendo Fácil:** Breve descripción + logo
2. **Recursos:** Links a blog, guías
3. **Empresa:** Contacto, política de privacidad, términos
4. **Social:** LinkedIn, email, teléfono

---

## 3. Estructura de la Home (Landing Page)

### 3.1 Hero Section

**Objetivo:** Capturar atención en 3 segundos

**Layout:**
```
┌─────────────────────────────────────┐
│                                     │
│  H1: "Operación de propiedades      │
│       sin el estrés"                │
│                                     │
│  Subheadline: "Gestiona cuotas,     │
│  servicios y pagos en un lugar.     │
│  Deja la ocupación a otros."        │
│                                     │
│  [CTA Primario: Ver Demo]           │
│  [CTA Secundario: Contactar]        │
│                                     │
│  (Imagen: Dashboard o ilustración)  │
│                                     │
└─────────────────────────────────────┘
```

**Responsive:**
- Desktop: Lado izquierdo texto (60%), lado derecho imagen (40%)
- Tablet: Texto arriba, imagen abajo (responsive)
- Mobile: Stack vertical, full-width

**Tipografía:**
- H1: 48px (desktop), 32px (mobile), azul marino
- Subheadline: 18px, gris oscuro
- Body text: 16px

**Colores:**
- Fondo: Blanco o gris suave (#F2F2F2)
- Texto: Azul marino (#1D2D44)
- Botones: Verde dólar (#7DBE52) con hover verde bosque

---

### 3.2 Problema (Pain Points Section)

**Objetivo:** Conectar emocionalmente, validar que entienden el dolor

**Layout:** 4 Cards en grid (2x2 desktop, stack mobile)

```
┌──────────────┐  ┌──────────────┐
│ ❌ Dolor 1   │  │ ❌ Dolor 2   │
│ Descripción  │  │ Descripción  │
└──────────────┘  └──────────────┘

┌──────────────┐  ┌──────────────┐
│ ❌ Dolor 3   │  │ ❌ Dolor 4   │
│ Descripción  │  │ Descripción  │
└──────────────┘  └──────────────┘
```

**Contenido:**
1. "Cuotas en Excel, pagos perdidos"
2. "Sin visibilidad sobre deudas"
3. "Alícuotas imposibles de explicar"
4. "Crecimiento detenido por gestión manual"

**Tipografía & Spacing:**
- Card: padding 24px, borde suave, sombra Stripe-like
- Icon: 48px, rojo/naranja (cambio de paleta)
- Headline: 18px, azul marino
- Body: 14px, gris

---

### 3.3 Solución (How We Solve Section)

**Objetivo:** Presentar la propuesta de forma tangible

**Layout:** Vertical con diagrama central o lado a lado

```
┌─────────────────────────────────────┐
│                                     │
│  "Cómo lo resolvemos"               │
│                                     │
│  [Visual: Diagrama de flujo]        │
│                                     │
│  ✓ Cuotas Centralizadas             │
│  ✓ Servicios Automáticos            │
│  ✓ Alícuotas Transparentes          │
│  ✓ Control de Pagos                 │
│                                     │
└─────────────────────────────────────┘
```

**Estructura:**
- Heading: "Cómo lo resolvemos"
- Imagen central (dashboard o ilustración)
- 4 puntos con checkmarks verdes

---

### 3.4 Características (Features Section)

**Objetivo:** Mostrar alcance sin overwhelm

**Layout:** 4 Cards grandes en grid (2x2 desktop, stack mobile)

```
┌──────────────────┐  ┌──────────────────┐
│ 📊 Control de    │  │ 💰 Gestión de    │
│    Cuotas        │  │    Servicios     │
│ Descripción...   │  │ Descripción...   │
└──────────────────┘  └──────────────────┘

┌──────────────────┐  ┌──────────────────┐
│ 📋 Alícuotas     │  │ ✓ Control de     │
│                  │  │   Pagos          │
│ Descripción...   │  │ Descripción...   │
└──────────────────┘  └──────────────────┘
```

**Cada Card incluye:**
- Icono (emoji o SVG)
- Headline: 20px
- Descripción: 14px
- Optional: Link "Más info" (flecha verde)

---

### 3.5 Social Proof (Stats/Testimonials)

**Objetivo:** Generar confianza antes de CTA

**Formato:** Horizontal timeline o grid de 3 items

```
┌─────────────────────────────────────┐
│                                     │
│  150+              98%         +25%  │
│  Propiedades    Ocupación   Rentabilidad
│  Gestionadas                        │
│                                     │
└─────────────────────────────────────┘
```

**Alt: Testimonial card** (si hay disponible de cliente actual)

---

### 3.6 Blog Preview Section

**Objetivo:** Mostrar expertise, link a blog

**Layout:** 3 Posts destacados en card grid (1 col mobile, 2 tablet, 3 desktop)

```
┌────────────────────┐  ┌────────────────────┐  ┌────────────────────┐
│ [Imagen]           │  │ [Imagen]           │  │ [Imagen]           │
│                    │  │                    │  │                    │
│ Headline del post  │  │ Headline del post  │  │ Headline del post  │
│ Extracto (100 chars)   │ Extracto (100 chars)   │ Extracto (100 chars)   │
│ Sep 1, 2026        │  │ Aug 25, 2026       │  │ Aug 18, 2026       │
│ [Leer más →]       │  │ [Leer más →]       │  │ [Leer más →]       │
└────────────────────┘  └────────────────────┘  └────────────────────┘

[Ver todos los posts →]
```

**Posts iniciales:**
1. "5 errores comunes en la gestión de alícuotas"
2. "Cómo automatizar cuotas sin perder control"
3. "Guía: servicios básicos en arriendos"

---

### 3.7 CTA Final Section

**Objetivo:** Convertir interés en acción

**Layout:** Full-width, high contrast

```
┌─────────────────────────────────────┐
│  Fondo: Verde dólar / Azul marino   │
│                                     │
│  "Empieza a gestionar propiedades   │
│   como un profesional"              │
│                                     │
│  [CTA Primario: Solicitar Demo]     │
│  [CTA Secundario: Hablar con ventas]│
│                                     │
└─────────────────────────────────────┘
```

**Form CTA:**
- Email + Submit
- O redirect a Calendly (booking)

---

### 3.8 Footer

**Layout:**

```
┌────────────────────────────────────────┐
│ [Logo] [Links] [Social] [Copyright]    │
│ [Redes] [Contacto] [Políticas]         │
└────────────────────────────────────────┘
```

---

## 4. User Flows

### 4.1 Flow: Nuevo visitante → Demo

```
Visita Home
    ↓
Lee Hero + Problema
    ↓
Convencido? → Haz click en "Ver Demo"
    ↓
Modal o form de contacto
    ↓
Ingresa email + nombre
    ↓
Recibe confirmación + Calendly link
    ↓
Agendas demo
```

### 4.2 Flow: Visitante → Blog

```
Visita Home
    ↓
Scroll hasta "Blog Preview"
    ↓
Click en "Leer más" de un post
    ↓
Navega a /blog/[slug]
    ↓
Lee post completo
    ↓
Opción: Vuelve a Home o ve otro post
```

### 4.3 Flow: Contacto

```
Click en "Contacto" (header)
    ↓
Navega a /contacto
    ↓
Ve form o info de contacto
    ↓
Elige método: Email, teléfono, chat
    ↓
Contacta directo
```

---

## 5. Wireframe Logic (Pseudo-wireframe)

### Desktop (1024px+)

```
┌─────────────────────────────────────────────────┐
│ [Logo] [Nav Links] [CTA Demo]                   │ ← Header sticky
├─────────────────────────────────────────────────┤
│                   HERO                          │ ← Hero
│  Texto (60%) | Imagen (40%)                     │
├─────────────────────────────────────────────────┤
│              PROBLEMA (4 Cards)                 │ ← Pain points
│  [Card] [Card] | [Card] [Card]                  │
├─────────────────────────────────────────────────┤
│              SOLUCIÓN                           │ ← Solution
│  Texto + Imagen central                         │
├─────────────────────────────────────────────────┤
│          CARACTERÍSTICAS (4 Cards)              │ ← Features
│  [Feature] [Feature] | [Feature] [Feature]      │
├─────────────────────────────────────────────────┤
│              SOCIAL PROOF (Stats)               │ ← Stats
├─────────────────────────────────────────────────┤
│            BLOG PREVIEW (3 Posts)               │ ← Blog
│  [Post] [Post] [Post]                           │
├─────────────────────────────────────────────────┤
│              CTA FINAL                          │ ← CTA section
│  [Demo] [Contactar]                             │
├─────────────────────────────────────────────────┤
│              FOOTER                             │ ← Footer
└─────────────────────────────────────────────────┘
```

### Mobile (<768px)

```
┌─────────────────────────┐
│ [Logo] [☰ Menu]         │ ← Header
├─────────────────────────┤
│      HERO (Stack)       │
│  Texto                  │
│  Imagen (full width)    │
├─────────────────────────┤
│   PROBLEMA (Stack)      │
│  [Card]                 │
│  [Card]                 │
│  [Card]                 │
│  [Card]                 │
├─────────────────────────┤
│  SOLUCIÓN (Stack)       │
│  Texto                  │
│  Imagen                 │
├─────────────────────────┤
│ CARACTERÍSTICAS (Stack) │
│  [Feature]              │
│  [Feature]              │
│  [Feature]              │
│  [Feature]              │
├─────────────────────────┤
│    SOCIAL PROOF         │
├─────────────────────────┤
│  BLOG PREVIEW (Stack)   │
│  [Post]                 │
│  [Post]                 │
│  [Post]                 │
├─────────────────────────┤
│      CTA FINAL          │
│  [Demo]                 │
│  [Contactar]            │
├─────────────────────────┤
│       FOOTER            │
└─────────────────────────┘
```

---

## 6. Breakpoints & Responsive Strategy

**Mobile-First Approach:**

- **Mobile:** < 768px (base)
- **Tablet:** 768px - 1023px (adjustments)
- **Desktop:** 1024px+ (full layout)

**Cambios clave:**
- Hero: Stack vertical (mobile) → lado a lado (desktop)
- Cards: 1 col (mobile) → 2 cols (tablet) → 2-4 cols (desktop)
- Nav: Hamburger (mobile) → horizontal (desktop)
- Padding/Margin: Scale 4px (consistent)

---

## 7. Interactividad & Behaviors

### Scroll Behaviors
- ✓ Smooth scroll entre secciones
- ✓ Header sticky (permanece visible)
- ✓ Fade-in animations al scroll (subtle, no overwhelm)

### Hover States
- ✓ Botones: Color change + slight scale
- ✓ Cards: Sombra aumenta + slight lift
- ✓ Links: Color verde + underline

### Form Interactions
- ✓ Input focus: Border verde + icon change
- ✓ Validation: Error message rojo suave
- ✓ Success: Confirmation modal con CTA a Calendly

---

## 8. Accesibilidad (WCAG 2.1 AA)

- ✓ Heading hierarchy: H1 → H2 → H3 (no se salta niveles)
- ✓ Alt text en todas las imágenes
- ✓ Color contrast: WCAG AA mínimo
- ✓ Keyboard nav: Tab + Enter accesibles en todos los CTA
- ✓ Focus indicators: Visible en todos los elementos interactivos
- ✓ Semántica HTML5: `<header>`, `<nav>`, `<main>`, `<section>`, `<footer>`

---

## 9. Consideraciones de Implementación

### Componentes Reutilizables (del actual frontend)
- Button (primario/secundario/outline)
- Card (con padding, sombra Stripe-like)
- Header/Navigation
- Footer
- Form inputs

### Nuevos Componentes
- Hero con layout asimétrico
- Stats card
- Blog card preview
- Testimonial card (si se usa)

### Optimizaciones
- Lazy-load imágenes del blog
- Fonts optimizados (Inter ya existe)
- CSS variables para colores y espaciado

---

## 10. Resumen Técnico

| Aspecto | Especificación |
|---------|---|
| **Lenguaje** | HTML5 + PHP (WordPress) |
| **CSS** | CSS3 con variables existentes |
| **JS** | Vanilla JS (scroll, menu toggle, form) |
| **Performance** | LCP < 2.5s, FID < 100ms |
| **Fonts** | Inter (existente) |
| **Paleta** | Colores existentes (#1D2D44, #7DBE52, etc) |
| **Icons** | SVG o emojis (mantener simple) |
| **Images** | Optimizados WebP + fallback |

---

**Status:** ✅ Arquitectura definida  
**Próxima fase:** Design Tokens (refinamiento visual)
