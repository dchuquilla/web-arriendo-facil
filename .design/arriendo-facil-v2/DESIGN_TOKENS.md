# Design Tokens: Arriendo Fácil 2.0

**Fecha:** Septiembre 1, 2026  
**Feature Slug:** `arriendo-facil-v2`  
**Stack:** WordPress + CSS Variables + Vanilla JS

---

## 1. Introducción

Este documento define todos los **design tokens** (colores, tipografía, espaciado, sombras, bordes) para Arriendo Fácil 2.0. Los tokens se implementarán como **CSS custom properties (variables CSS)** en la hoja de estilos del tema child `twentytwentyfive-child`.

**Filosofía:** Mantener paleta existente, refinar para B2B moderno.

---

## 2. Colores

### 2.1 Paleta Base

```css
/* Primarios */
--color-primary-dark: #1D2D44;      /* Azul marino - confianza */
--color-primary-light: #2C3E50;     /* Azul más claro (variante) */

/* Acentos */
--color-accent-active: #7DBE52;     /* Verde dólar - CTA, dinero */
--color-accent-hover: #4B8B4B;      /* Verde bosque - hover states */
--color-accent-light: #E8F5E9;      /* Verde muy claro - backgrounds */

/* Neutrales */
--color-background: #FFFFFF;        /* Blanco puro */
--color-surface: #F2F2F2;           /* Gris suave - alt backgrounds */
--color-text-primary: #1D2D44;      /* Mismo que primary dark */
--color-text-secondary: #666666;    /* Gris medio - secondary text */
--color-text-tertiary: #999999;     /* Gris claro - helper text */
--color-border: #E0E0E0;            /* Bordes suaves */

/* Funcionales */
--color-success: #4CAF50;           /* Verde success */
--color-warning: #FFC107;           /* Amarillo warning */
--color-error: #F44336;             /* Rojo error */
--color-info: #2196F3;              /* Azul info */

/* Shadows (Stripe-like) */
--color-shadow-light: rgba(0, 0, 0, 0.04);
--color-shadow-medium: rgba(0, 0, 0, 0.08);
--color-shadow-dark: rgba(0, 0, 0, 0.16);
```

### 2.2 Paleta Semántica

```css
/* Botones */
--color-btn-primary-bg: var(--color-accent-active);      /* Verde dólar */
--color-btn-primary-text: #FFFFFF;
--color-btn-primary-hover: var(--color-accent-hover);    /* Verde bosque */
--color-btn-secondary-bg: var(--color-surface);          /* Gris suave */
--color-btn-secondary-text: var(--color-text-primary);
--color-btn-secondary-hover: #E0E0E0;
--color-btn-outline-border: var(--color-border);
--color-btn-outline-text: var(--color-text-primary);

/* Cards */
--color-card-bg: var(--color-background);
--color-card-border: var(--color-border);

/* Inputs */
--color-input-bg: var(--color-background);
--color-input-border: var(--color-border);
--color-input-border-focus: var(--color-accent-active);
--color-input-text: var(--color-text-primary);

/* Links */
--color-link: var(--color-accent-active);
--color-link-hover: var(--color-accent-hover);

/* Hero */
--color-hero-bg: var(--color-background);
--color-hero-text: var(--color-text-primary);

/* Stats Section */
--color-stats-bg: var(--color-surface);
```

### 2.3 Uso en Contextos

| Elemento | Token | Fallback |
|----------|-------|----------|
| Heading (H1-H6) | `--color-text-primary` | #1D2D44 |
| Body text | `--color-text-secondary` | #666666 |
| Helper text | `--color-text-tertiary` | #999999 |
| Primary button | `--color-btn-primary-bg` | #7DBE52 |
| Link | `--color-link` | #7DBE52 |
| Error message | `--color-error` | #F44336 |
| Success message | `--color-success` | #4CAF50 |

---

## 3. Tipografía

### 3.1 Familias de Fuentes

```css
--font-primary: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
--font-mono: "SF Mono", Monaco, "Cascadia Code", monospace;
```

**Nota:** Inter ya existe en el proyecto. No agregar nuevas familias.

### 3.2 Escalas de Tamaño

```css
/* Headings */
--font-size-h1: 48px;               /* Desktop hero */
--font-size-h1-mobile: 32px;        /* Mobile hero */
--font-size-h2: 36px;               /* Section headings */
--font-size-h2-mobile: 28px;
--font-size-h3: 28px;               /* Subsection headings */
--font-size-h3-mobile: 22px;
--font-size-h4: 24px;               /* Card titles */
--font-size-h4-mobile: 18px;
--font-size-h5: 20px;               /* Secondary titles */
--font-size-h6: 16px;               /* Tertiary titles */

/* Body */
--font-size-body-lg: 18px;          /* Large body text */
--font-size-body: 16px;             /* Regular body */
--font-size-body-sm: 14px;          /* Small body (secondary info) */
--font-size-body-xs: 12px;          /* Extra small (labels, helper) */

/* Special */
--font-size-button: 16px;           /* Button text */
--font-size-label: 12px;            /* Form labels */
--font-size-caption: 12px;          /* Image captions, meta info */
```

### 3.3 Pesos de Fuente

```css
--font-weight-light: 300;           /* Para énfasis suave */
--font-weight-regular: 400;         /* Body text, default */
--font-weight-medium: 500;          /* Labels, secondary headings */
--font-weight-semibold: 600;        /* Headings, strong emphasis */
--font-weight-bold: 700;            /* H1, strongest emphasis */
```

### 3.4 Line Heights

```css
--line-height-tight: 1.2;           /* Headings */
--line-height-normal: 1.5;          /* Body text */
--line-height-relaxed: 1.75;        /* Long form content */
```

### 3.5 Reglas de Tipografía

| Elemento | Tamaño | Peso | Line-Height |
|----------|--------|------|-------------|
| H1 | `--font-size-h1` | 700 | 1.2 |
| H2 | `--font-size-h2` | 600 | 1.3 |
| Body | `--font-size-body` | 400 | 1.5 |
| Caption | `--font-size-caption` | 400 | 1.4 |
| Button | `--font-size-button` | 500 | 1.5 |

---

## 4. Espaciado

### 4.1 Scale 4px (Base Unit)

```css
--spacing-0: 0;
--spacing-1: 4px;       /* 4px */
--spacing-2: 8px;       /* 8px */
--spacing-3: 12px;      /* 12px */
--spacing-4: 16px;      /* 16px */
--spacing-5: 20px;      /* 20px */
--spacing-6: 24px;      /* 24px */
--spacing-7: 28px;      /* 28px */
--spacing-8: 32px;      /* 32px */
--spacing-10: 40px;     /* 40px */
--spacing-12: 48px;     /* 48px */
--spacing-16: 64px;     /* 64px */
--spacing-20: 80px;     /* 80px */
--spacing-24: 96px;     /* 96px */
```

### 4.2 Usos Comunes

```css
/* Padding */
--padding-xs: var(--spacing-2);          /* 8px */
--padding-sm: var(--spacing-3);          /* 12px */
--padding-md: var(--spacing-4);          /* 16px */
--padding-lg: var(--spacing-6);          /* 24px */
--padding-xl: var(--spacing-8);          /* 32px */

/* Margin */
--margin-xs: var(--spacing-2);           /* 8px */
--margin-sm: var(--spacing-3);           /* 12px */
--margin-md: var(--spacing-4);           /* 16px */
--margin-lg: var(--spacing-6);           /* 24px */
--margin-xl: var(--spacing-8);           /* 32px */
--margin-section: var(--spacing-16);     /* 64px entre secciones */

/* Gap (Flexbox/Grid) */
--gap-sm: var(--spacing-2);              /* 8px */
--gap-md: var(--spacing-4);              /* 16px */
--gap-lg: var(--spacing-6);              /* 24px */
--gap-xl: var(--spacing-8);              /* 32px */
```

### 4.3 Secciones

```css
/* Padding vertical de secciones */
--section-padding-mobile: var(--spacing-12);   /* 48px */
--section-padding-desktop: var(--spacing-20);  /* 80px */

/* Container max-width */
--container-max-width: 1200px;
--container-padding: var(--spacing-4);         /* 16px en mobile */
```

---

## 5. Sombras

### 5.1 Shadow Palette (Stripe-like)

```css
/* Elevation 0 - No shadow */
--shadow-none: none;

/* Elevation 1 - Subtle */
--shadow-xs: 0 1px 2px var(--color-shadow-light);

/* Elevation 2 - Cards, mild interaction */
--shadow-sm: 0 2px 4px var(--color-shadow-light),
             0 1px 2px var(--color-shadow-medium);

/* Elevation 3 - Standard cards */
--shadow-md: 0 4px 8px var(--color-shadow-light),
             0 2px 4px var(--color-shadow-medium);

/* Elevation 4 - Hover state cards */
--shadow-lg: 0 8px 16px var(--color-shadow-medium),
             0 4px 8px var(--color-shadow-light);

/* Elevation 5 - Modals, dropdowns */
--shadow-xl: 0 16px 24px var(--color-shadow-dark),
             0 8px 16px var(--color-shadow-medium);

/* Elevation 6 - Maximum depth */
--shadow-2xl: 0 20px 36px var(--color-shadow-dark),
              0 12px 20px var(--color-shadow-dark);
```

### 5.2 Uso

| Elemento | Shadow |
|----------|--------|
| Card (default) | `--shadow-md` |
| Card (hover) | `--shadow-lg` |
| Button (default) | `--shadow-sm` |
| Button (hover) | `--shadow-md` |
| Modal | `--shadow-xl` |
| Dropdown | `--shadow-lg` |
| Header (sticky) | `--shadow-sm` |

---

## 6. Bordes

### 6.1 Border Radius

```css
--radius-none: 0;
--radius-sm: 4px;           /* Botones, inputs pequeños */
--radius-md: 8px;           /* Cards, inputs */
--radius-lg: 12px;          /* Grandes componentes */
--radius-xl: 16px;          /* Secciones grandes */
--radius-full: 9999px;      /* Píldoras, avatares */
```

### 6.2 Border Width

```css
--border-width-0: 0;
--border-width-1: 1px;      /* Estándar */
--border-width-2: 2px;      /* Énfasis */
--border-width-4: 4px;      /* Foco, hover */
```

### 6.3 Uso

| Elemento | Radius |
|----------|--------|
| Card | `--radius-md` |
| Button | `--radius-sm` |
| Input | `--radius-sm` |
| Hero section | `--radius-lg` |
| Avatar | `--radius-full` |

---

## 7. Breakpoints (Mobile-First)

```css
--breakpoint-mobile: 0;        /* Default */
--breakpoint-sm: 480px;        /* Small devices */
--breakpoint-md: 768px;        /* Tablets */
--breakpoint-lg: 1024px;       /* Desktops */
--breakpoint-xl: 1280px;       /* Large desktops */
--breakpoint-2xl: 1536px;      /* Ultra-wide */
```

**Media queries:**
```css
/* Mobile (default, no query needed) */
/* Tablet and up */
@media (min-width: 768px) { ... }
/* Desktop and up */
@media (min-width: 1024px) { ... }
/* Large desktop and up */
@media (min-width: 1280px) { ... }
```

---

## 8. Componentes Base (CSS Classes)

### 8.1 Botón

```css
.btn {
  font-size: var(--font-size-button);
  font-weight: var(--font-weight-medium);
  padding: var(--spacing-3) var(--spacing-6);
  border-radius: var(--radius-sm);
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: var(--spacing-2);
}

.btn--primary {
  background-color: var(--color-btn-primary-bg);
  color: var(--color-btn-primary-text);
  box-shadow: var(--shadow-sm);
}

.btn--primary:hover {
  background-color: var(--color-btn-primary-hover);
  box-shadow: var(--shadow-md);
}

.btn--secondary {
  background-color: var(--color-btn-secondary-bg);
  color: var(--color-btn-secondary-text);
  border: 1px solid var(--color-btn-secondary-border);
}

.btn--secondary:hover {
  background-color: var(--color-btn-secondary-hover);
}

.btn--outline {
  background-color: transparent;
  color: var(--color-btn-outline-text);
  border: 1px solid var(--color-btn-outline-border);
}

.btn--outline:hover {
  background-color: var(--color-surface);
  border-color: var(--color-text-primary);
}

.btn--sm {
  padding: var(--spacing-2) var(--spacing-4);
  font-size: var(--font-size-body-sm);
}

.btn--lg {
  padding: var(--spacing-4) var(--spacing-8);
  font-size: var(--font-size-body);
}
```

### 8.2 Card

```css
.card {
  background-color: var(--color-card-bg);
  border: 1px solid var(--color-card-border);
  border-radius: var(--radius-md);
  padding: var(--padding-lg);
  box-shadow: var(--shadow-md);
  transition: all 0.2s ease;
}

.card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-2px);
}
```

### 8.3 Input

```css
input, textarea, select {
  font-family: var(--font-primary);
  font-size: var(--font-size-body);
  padding: var(--spacing-3) var(--spacing-4);
  border: 1px solid var(--color-input-border);
  border-radius: var(--radius-sm);
  background-color: var(--color-input-bg);
  color: var(--color-input-text);
  transition: all 0.2s ease;
}

input:focus, textarea:focus, select:focus {
  outline: none;
  border-color: var(--color-input-border-focus);
  box-shadow: 0 0 0 3px rgba(125, 190, 82, 0.1);
}

input::placeholder {
  color: var(--color-text-tertiary);
}
```

### 8.4 Headings

```css
h1 {
  font-size: var(--font-size-h1);
  font-weight: var(--font-weight-bold);
  line-height: var(--line-height-tight);
  color: var(--color-text-primary);
  margin-bottom: var(--spacing-4);
}

h2 {
  font-size: var(--font-size-h2);
  font-weight: var(--font-weight-semibold);
  line-height: var(--line-height-tight);
  color: var(--color-text-primary);
  margin-bottom: var(--spacing-3);
}

h3 {
  font-size: var(--font-size-h3);
  font-weight: var(--font-weight-semibold);
  line-height: var(--line-height-normal);
  color: var(--color-text-primary);
  margin-bottom: var(--spacing-2);
}

@media (max-width: 768px) {
  h1 {
    font-size: var(--font-size-h1-mobile);
  }
  h2 {
    font-size: var(--font-size-h2-mobile);
  }
  h3 {
    font-size: var(--font-size-h3-mobile);
  }
}
```

### 8.5 Párrafos

```css
p {
  font-size: var(--font-size-body);
  line-height: var(--line-height-normal);
  color: var(--color-text-secondary);
  margin-bottom: var(--spacing-4);
}

p.secondary {
  color: var(--color-text-tertiary);
  font-size: var(--font-size-body-sm);
}

a {
  color: var(--color-link);
  text-decoration: none;
  transition: color 0.2s ease;
}

a:hover {
  color: var(--color-link-hover);
  text-decoration: underline;
}
```

---

## 9. Layouts Utilitarios

```css
/* Container */
.container {
  width: 100%;
  max-width: var(--container-max-width);
  margin: 0 auto;
  padding-left: var(--spacing-4);
  padding-right: var(--spacing-4);
}

@media (min-width: 768px) {
  .container {
    padding-left: var(--spacing-6);
    padding-right: var(--spacing-6);
  }
}

/* Flex utilities */
.flex {
  display: flex;
}

.flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
}

.flex-between {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.gap-md {
  gap: var(--gap-md);
}

.gap-lg {
  gap: var(--gap-lg);
}

/* Grid */
.grid {
  display: grid;
}

.grid-2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--gap-lg);
}

@media (max-width: 768px) {
  .grid-2 {
    grid-template-columns: 1fr;
  }
}

.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--gap-lg);
}

@media (max-width: 1024px) {
  .grid-3 {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .grid-3 {
    grid-template-columns: 1fr;
  }
}

.grid-4 {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--gap-lg);
}

@media (max-width: 1024px) {
  .grid-4 {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .grid-4 {
    grid-template-columns: 1fr;
  }
}

/* Spacing utilities */
.mt-0 { margin-top: var(--spacing-0); }
.mt-1 { margin-top: var(--spacing-1); }
.mt-2 { margin-top: var(--spacing-2); }
.mt-4 { margin-top: var(--spacing-4); }
.mt-6 { margin-top: var(--spacing-6); }
.mt-8 { margin-top: var(--spacing-8); }

.mb-0 { margin-bottom: var(--spacing-0); }
.mb-1 { margin-bottom: var(--spacing-1); }
.mb-2 { margin-bottom: var(--spacing-2); }
.mb-4 { margin-bottom: var(--spacing-4); }
.mb-6 { margin-bottom: var(--spacing-6); }
.mb-8 { margin-bottom: var(--spacing-8); }

.px-4 { padding-left: var(--spacing-4); padding-right: var(--spacing-4); }
.py-6 { padding-top: var(--spacing-6); padding-bottom: var(--spacing-6); }

/* Text utilities */
.text-center {
  text-align: center;
}

.text-primary {
  color: var(--color-text-primary);
}

.text-secondary {
  color: var(--color-text-secondary);
}

.text-accent {
  color: var(--color-accent-active);
}

.text-bold {
  font-weight: var(--font-weight-bold);
}

.text-sm {
  font-size: var(--font-size-body-sm);
}

.text-xs {
  font-size: var(--font-size-body-xs);
}
```

---

## 10. Animaciones

```css
/* Smooth transitions */
@media (prefers-reduced-motion: no-preference) {
  * {
    transition: color 0.2s ease, background-color 0.2s ease, 
                border-color 0.2s ease, box-shadow 0.2s ease;
  }
}

/* Fade in on scroll */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in {
  animation: fadeIn 0.6s ease-out;
}

/* Pulse (for CTAs) */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.8;
  }
}

.pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
```

---

## 11. Dark Mode (Preparación)

```css
/* Variables dark mode (para futura implementación) */
@media (prefers-color-scheme: dark) {
  :root {
    --color-background: #1A1A1A;
    --color-surface: #2D2D2D;
    --color-text-primary: #F0F0F0;
    --color-text-secondary: #B0B0B0;
    --color-text-tertiary: #808080;
    --color-border: #404040;
    /* Mantener colores de acento */
    --color-accent-active: #7DBE52;
    --color-accent-hover: #8FD962;
  }
}
```

---

## 12. Resumen de Implementación

### En `style.css` (tema child):
1. Declarar todas las variables CSS al inicio (`:root`)
2. Aplicar en clases base (button, card, input, headings)
3. Usar en utilities (spacing, grid, text)
4. Implementar animaciones con respeto a `prefers-reduced-motion`

### Checklist:
- ✅ Colores semánticos
- ✅ Tipografía completa (sizes, weights, line-heights)
- ✅ Espaciado 4px-scale
- ✅ Sombras Stripe-like (6 niveles)
- ✅ Bordes y radius
- ✅ Componentes base (button, card, input, headings)
- ✅ Breakpoints mobile-first
- ✅ Utilities para layout
- ✅ Animaciones
- ✅ Dark mode prep

---

**Status:** ✅ Design Tokens definidos  
**Próxima fase:** Brief to Tasks (crear checklist de construcción)
