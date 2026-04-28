# Design Tokens: Arriendo Fácil Platform Redesign

## Overview

This token system implements the **Modern Professional Clean** aesthetic—a hybrid of Stripe's minimalist clarity and Airbnb's discovery-driven, image-forward design.

**Location**: `/wordpress/wp-content/themes/twentytwentyfive-child/design-tokens.css`

**How to use**: Import `design-tokens.css` at the top of `style.css`:
```css
@import 'design-tokens.css';
```

All values reference CSS custom properties (variables) defined here. This enables:
- Consistent design system across all pages
- Easy dark mode support (via `[data-theme="dark"]`)
- Centralized updates (change one value, update everywhere)

---

## Color System

### Semantic Color Tokens (Light Mode)

| Token | Value | Use Case |
|-------|-------|----------|
| `--color-bg-primary` | `#ffffff` | Main page background |
| `--color-bg-secondary` | `#f8f9fa` | Card, section backgrounds |
| `--color-bg-tertiary` | `#f2f2f2` | Input, well, subtle background |
| `--color-bg-inverse` | `#1d2d44` | Dark background |
| `--color-bg-overlay` | `rgba(29, 45, 68, 0.5)` | Modal overlay backdrop |
| `--color-text-primary` | `#1d2d44` | Main text (navy) |
| `--color-text-secondary` | `#9e9e9e` | Muted text (gray) |
| `--color-text-tertiary` | `#b0b0b0` | Placeholder, disabled text |
| `--color-text-inverse` | `#ffffff` | Text on dark backgrounds |
| `--color-text-link` | `#7dbe52` | Link color (green) |
| `--color-border-primary` | `rgba(29, 45, 68, 0.12)` | Default borders |
| `--color-border-secondary` | `rgba(29, 45, 68, 0.06)` | Subtle borders |
| `--color-border-focus` | `#7dbe52` | Focus ring color |
| `--color-accent-primary` | `#7dbe52` | Primary CTA (green) |
| `--color-accent-primary-hover` | `#6ba847` | Hover state |
| `--color-accent-primary-active` | `#4b8b4b` | Active/pressed state |
| `--color-status-success` | `#22c55e` | Success feedback |
| `--color-status-error` | `#ef4444` | Error feedback |

### Why Semantic Names?

Instead of color names like `--green` or `--blue-300`, we use semantic names like `--color-accent-primary` and `--color-text-secondary`. This means:
- Easier dark mode support (swap values, not names)
- Clearer intent (you know when to use each color)
- Changes propagate everywhere (recolor the brand in one place)

### Dark Mode

Dark mode tokens are defined under `[data-theme="dark"]` and `@media (prefers-color-scheme: dark)`. The colors are intentionally adjusted (not inverted) to maintain accessibility and aesthetic coherence:
- Backgrounds are warm-tinted (not pure black)
- Text is slightly dimmed (not pure white) for comfort
- Accent colors are slightly lighter to maintain contrast

---

## Spacing Scale

Base unit: **4px**. All spacing uses this scale to maintain harmony:

| Token | Value | Use Case |
|-------|-------|----------|
| `--space-0` | `0` | No spacing |
| `--space-1` | `4px` | Minimal gap (icon spacing, tight borders) |
| `--space-2` | `8px` | Extra small (button padding) |
| `--space-3` | `12px` | Small (form labels, small components) |
| `--space-4` | `16px` | Base (padding, margins, section gaps) |
| `--space-5` | `24px` | Medium (section gaps, card spacing) |
| `--space-6` | `32px` | Large (section padding, generous gaps) |
| `--space-7` | `48px` | Extra large (major section gaps) |
| `--space-8` | `64px` | Huge (hero, major spacing) |
| `--space-9` | `96px` | Extra huge |
| `--space-10` | `128px` | Massive (full-height gaps) |

**Example**:
```css
.card {
  padding: var(--space-6);          /* 32px padding */
  margin-bottom: var(--space-5);    /* 24px gap below */
}

.hero {
  padding: var(--space-8) 0;        /* 64px top/bottom */
}
```

---

## Typography

### Font Families

- **Display & Body**: `Inter` with system fallback (`-apple-system`, `Segoe UI`, `Roboto`, sans-serif)
- **Mono**: `Monaco`, `Menlo`, `Ubuntu Mono` (for code)

### Font Sizes

| Token | Value | Use Case |
|-------|-------|----------|
| `--font-size-xs` | `12px` | Small labels, captions |
| `--font-size-sm` | `14px` | Secondary text, small buttons |
| `--font-size-base` | `16px` | Body baseline |
| `--font-size-md` | `17px` | Body text (standard) |
| `--font-size-lg` | `20px` | Subheadings |
| `--font-size-xl` | `24px` | Section headings |
| `--font-size-2xl` | `28px` | Page subheadings |
| `--font-size-3xl` | `32px` | Major headings |
| `--font-size-4xl` | `40px` | Large headings |
| `--font-size-5xl` | `48px` | Extra large |
| `--font-size-6xl` | `64px` | Hero display |

### Font Weights

| Token | Value | Use Case |
|-------|-------|----------|
| `--font-weight-normal` | `400` | Body text |
| `--font-weight-medium` | `500` | Slight emphasis |
| `--font-weight-semibold` | `600` | Form labels, subheadings |
| `--font-weight-bold` | `700` | Headings, strong emphasis |
| `--font-weight-black` | `800` | Display, hero text |

### Line Heights

| Token | Value | Use Case |
|-------|-------|----------|
| `--line-height-tight` | `1.1` | Headlines (compact) |
| `--line-height-snug` | `1.25` | Subheadings |
| `--line-height-normal` | `1.5` | Body text (readable) |
| `--line-height-relaxed` | `1.6` | Spacious body |
| `--line-height-loose` | `1.8` | Extra spacious text |

### Letter Spacing

| Token | Value | Use Case |
|-------|-------|----------|
| `--letter-spacing-tight` | `-0.02em` | Headline tightness |
| `--letter-spacing-normal` | `0` | Body text |
| `--letter-spacing-wide` | `0.05em` | Labels, all-caps |

**Example**:
```css
h1 {
  font-size: var(--font-size-5xl);
  font-weight: var(--font-weight-black);
  line-height: var(--line-height-tight);
  letter-spacing: var(--letter-spacing-tight);
}

body {
  font-size: var(--font-size-md);
  line-height: var(--line-height-normal);
}
```

---

## Layout & Borders

### Max Widths

| Token | Value | Use Case |
|-------|-------|----------|
| `--max-width-content` | `65ch` | Optimal reading width for body text |
| `--max-width-wide` | `90ch` | Wider content area |
| `--max-width-page` | `1200px` | Full page container width |

### Border Radius

| Token | Value | Use Case |
|-------|-------|----------|
| `--border-radius-sm` | `8px` | Small buttons, inputs |
| `--border-radius-md` | `12px` | Standard cards, modals |
| `--border-radius-lg` | `16px` | Large cards, sections |
| `--border-radius-xl` | `20px` | Feature cards, hero elements |
| `--border-radius-2xl` | `24px` | Large showcase cards |
| `--border-radius-full` | `9999px` | Pill/circle shapes |

**Philosophy**: Rounded corners feel modern and friendly (vs. sharp Stripe-like design). Use small-to-medium radius for trust; avoid extreme roundness.

---

## Shadows

Simplified shadow system (vs. old system with heavy blur). These follow **Stripe's aesthetic**: subtle, purposeful, and performant.

| Token | Value | Use Case |
|-------|-------|----------|
| `--shadow-sm` | `0 2px 8px rgba(...)` | Subtle elevation (hover states) |
| `--shadow-md` | `0 4px 16px rgba(...)` | Standard cards |
| `--shadow-lg` | `0 8px 32px rgba(...)` | Modals, dropdowns |
| `--shadow-xl` | `0 12px 48px rgba(...)` | Large elevation |
| `--shadow-focus` | `0 0 0 3px rgba(...)` | Accessibility focus ring |

**Example**:
```css
.card {
  box-shadow: var(--shadow-md);
  border-radius: var(--border-radius-lg);
}

.card:hover {
  box-shadow: var(--shadow-lg);
}

input:focus {
  box-shadow: var(--shadow-focus);
}
```

---

## Motion & Transitions

### Duration

| Token | Value | Use Case |
|-------|-------|----------|
| `--duration-instant` | `50ms` | Instant feedback (hover, active) |
| `--duration-fast` | `150ms` | Fast interactions |
| `--duration-normal` | `250ms` | Default transitions |
| `--duration-slow` | `400ms` | Slow, noticeable transitions |
| `--duration-slower` | `600ms` | Very slow, deliberate transitions |

### Easing Functions

| Token | Cubic Bezier | Use Case |
|-------|------------|----------|
| `--easing-default` | `(0.4, 0, 0.2, 1)` | Standard ease (most use) |
| `--easing-in` | `(0.4, 0, 1, 1)` | Acceleration (appear) |
| `--easing-out` | `(0, 0, 0.2, 1)` | Deceleration (disappear) |
| `--easing-inout` | `(0.4, 0, 0.2, 1)` | Smooth both directions |

### Common Transitions

```css
--transition: var(--duration-normal) var(--easing-default);
--transition-fast: var(--duration-fast) var(--easing-default);
--transition-slow: var(--duration-slow) var(--easing-default);
```

**Example**:
```css
.button {
  transition: background-color var(--transition), box-shadow var(--transition);
}

.button:hover {
  background-color: var(--color-accent-primary-hover);
  box-shadow: var(--shadow-md);
}
```

### Reduced Motion Respects

The system automatically disables transitions for users with `prefers-reduced-motion: reduce`. This is handled in `design-tokens.css`.

---

## Responsive Breakpoints

Mobile-first approach. Design for small screens first, then add complexity:

| Token | Value | Device |
|-------|-------|--------|
| `--breakpoint-sm` | `375px` | Mobile (iPhone SE) |
| `--breakpoint-md` | `600px` | Larger mobile |
| `--breakpoint-lg` | `768px` | Tablet |
| `--breakpoint-xl` | `900px` | Small desktop |
| `--breakpoint-2xl` | `1200px` | Desktop |
| `--breakpoint-3xl` | `1536px` | Large desktop |

**Example**:
```css
.grid {
  display: grid;
  grid-template-columns: 1fr;  /* Mobile: 1 column */
}

@media (min-width: 768px) {
  .grid {
    grid-template-columns: 2fr 1fr;  /* Tablet+: 2 columns */
  }
}

@media (min-width: 900px) {
  .grid {
    grid-template-columns: repeat(3, 1fr);  /* Desktop: 3 columns */
  }
}
```

---

## Component-Level Tokens

These combine base tokens for common patterns:

### Buttons

```css
--button-padding-sm: var(--space-2) var(--space-4);      /* 8px 16px */
--button-padding-md: var(--space-3) var(--space-6);      /* 12px 32px */
--button-padding-lg: var(--space-4) var(--space-8);      /* 16px 64px */
--button-border-radius: var(--border-radius-md);         /* 12px */
--button-font-weight: var(--font-weight-semibold);       /* 600 */
--button-font-size: var(--font-size-base);               /* 16px */
```

### Cards

```css
--card-padding: var(--space-6);                          /* 32px */
--card-border-radius: var(--border-radius-lg);           /* 16px */
--card-box-shadow: var(--shadow-sm);                     /* Subtle lift */
```

### Inputs

```css
--input-padding: var(--space-3) var(--space-4);          /* 12px 16px */
--input-border-radius: var(--border-radius-md);          /* 12px */
--input-font-size: var(--font-size-base);                /* 16px */
```

### Property Cards (Image-first, Airbnb-style)

```css
--property-card-border-radius: var(--border-radius-lg);  /* 16px */
--property-card-image-aspect-ratio: 16 / 9;             /* Wide images */
--property-card-image-height: 240px;                     /* Prominent image */
--property-card-padding: var(--space-4);                 /* 16px */
```

---

## Gradients

### Accent Gradient

Used sparingly for primary CTAs and highlights:
```css
--gradient-accent: linear-gradient(135deg, #7dbe52 0%, #4b8b4b 100%);
```

### Overlay Gradient

For image overlays (dark bottom, fades to transparent):
```css
--gradient-overlay: linear-gradient(to top, rgba(29, 45, 68, 0.5) 0%, transparent 100%);
```

**Philosophy**: Minimize gradients. Use solid colors + shadows for depth. Gradients are reserved for accent elements and brand moments.

---

## Legacy Compatibility

Existing CSS still uses old variable names (e.g., `--azul-marino`, `--verde-dolar`). The token system maps these to semantic names:

```css
--azul-marino: var(--color-text-primary);
--verde-dolar: var(--color-accent-primary);
--border: var(--color-border-primary);
```

This allows a gradual migration without breaking existing styles.

---

## How to Use in Components

### Button Example

```css
.btn {
  padding: var(--button-padding-md);
  border-radius: var(--button-border-radius);
  font-weight: var(--button-font-weight);
  background: var(--color-bg-primary);
  color: var(--color-text-primary);
  border: var(--border-width-default) solid var(--color-border-primary);
  transition: all var(--transition);
}

.btn:hover {
  background: var(--color-bg-secondary);
  box-shadow: var(--shadow-md);
}

.btn--primary {
  background: var(--color-accent-primary);
  color: var(--color-text-inverse);
  border: none;
}

.btn--primary:hover {
  background: var(--color-accent-primary-hover);
  box-shadow: 0 4px 12px rgba(125, 190, 82, 0.3);
}
```

### Property Card Example

```css
.property-card {
  border-radius: var(--property-card-border-radius);
  background: var(--color-bg-primary);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  transition: box-shadow var(--transition);
}

.property-card__image {
  width: 100%;
  aspect-ratio: var(--property-card-image-aspect-ratio);
  object-fit: cover;
}

.property-card__info {
  padding: var(--property-card-padding);
}

.property-card:hover {
  box-shadow: var(--shadow-md);
}
```

---

## Next Steps

1. **Import tokens** into `style.css`:
   ```css
   @import 'design-tokens.css';
   ```

2. **Update existing components** to use tokens instead of hardcoded values

3. **Test dark mode** by adding `data-theme="dark"` to `<html>` element (future phase)

4. **Monitor and refine** based on build feedback

---

## Philosophy Summary

- **Clarity over decoration**: Every token serves a purpose
- **Generous spacing**: Trust is built through breathing room
- **Strategic color**: Accent colors earn their use
- **Subtle shadows**: Depth without heaviness
- **Accessibility first**: Contrast, focus states, motion respect built-in
- **Responsive by default**: Breakpoints guide layout decisions
- **Performance**: Simple shadows, minimal effects

This system is the visual foundation for a trustworthy, modern, renter-focused platform.
