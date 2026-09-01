# Build Tasks: Platform Redesign – Arriendo Fácil (v1)

## Overview

This task list breaks the design brief, information architecture, and tokens into a build checklist for **v1 MVP**.

**Build Sequence**:
1. Import design tokens
2. Update base styles (resets, utilities)
3. Build header & navigation (primary nav)
4. Build core components (buttons, cards, inputs)
5. Build homepage sections (hero → featured → benefits → testimonials → cta)
6. Build property listing page (`/propiedades`)
7. Build property detail page (`/propiedades/[slug]`)
8. Build contact page (`/contacto`)
9. Mobile & responsive refinement
10. Accessibility & performance QA

**Scope (v1)**:
- ✅ 4 pages: Home, Property listing, Detail, Contact
- ✅ 4 primary filters (location, price, type, availability)
- ✅ Property detail: 6-7 blocks (not 11)
- ✅ Simplified, renter-focused
- ❌ "Cómo funciona" page (section in home only)
- ❌ Owner landing (phase 2)

**Total tasks**: 19 (reduced from 22)
**Estimated timeline**: 3–4 weeks (frontend-first, placeholders OK)

Each task is self-contained and can be reviewed independently.

---

## Phase 1: Foundation & Setup

### ✅ Task 1: Import Design Tokens
**Status**: Ready
**File(s)**: `style.css`
**Acceptance Criteria**:
- [ ] Add `@import 'design-tokens.css';` at top of `style.css`
- [ ] Verify all CSS variables load (use DevTools)
- [ ] No conflicts with existing variables
- [ ] Legacy variable mappings work (`--azul-marino`, `--verde-dolar`, etc.)

**Notes**: This is prerequisite for all following tasks. Design tokens provide all color, spacing, typography, and shadow values.

---

### ✅ Task 2: Update Base Styles & CSS Resets
**Status**: Ready
**File(s)**: `style.css` (before component styles)
**Current State**: Base styles exist; need simplification
**Changes**:
- [ ] Keep existing reset rules (`box-sizing`, `margin`, `padding`)
- [ ] Update `body` font-size to use `--font-size-md` (currently 16px, keep but via token)
- [ ] Update `body` line-height to `--line-height-normal` (1.5)
- [ ] Simplify `a` link styles (use `--color-text-link`)
- [ ] Add utility classes (`.text-center`, `.mx-auto` already exist; keep)
- [ ] Remove unused or overcomplicated utility classes

**Acceptance Criteria**:
- [ ] All base element styles reference tokens (no hardcoded colors/sizes)
- [ ] Headings (h1–h6) use appropriate font-size and weight tokens
- [ ] Body text is readable (16px base, 1.5 line-height)
- [ ] Links are visually distinct (`--color-text-link`)

---

### ✅ Task 3: Build Core Button Component Styles
**Status**: Ready
**File(s)**: `style.css`
**Current State**: `.btn`, `.btn--primary`, `.btn--outline`, `.btn--dark` exist; need refinement
**Changes**:
- [ ] Update all button variants to use new tokens:
  - `--button-padding-md` for padding
  - `--button-border-radius` for radius
  - `--button-font-weight` for weight
  - `--color-accent-primary` for primary background
  - `--color-accent-primary-hover` for hover
- [ ] Simplify box-shadow (use `--shadow-sm`, `--shadow-md`)
- [ ] Remove 3D transforms (translateY on hover is OK, no rotations)
- [ ] Ensure focus state is visible (`--shadow-focus`)
- [ ] Test all button states (normal, hover, active, focus, disabled)

**Button Variants** to keep:
- `.btn` (default, outline)
- `.btn--primary` (green, filled)
- `.btn--outline` (transparent, green border)
- `.btn--dark` (navy background)

**Acceptance Criteria**:
- [ ] All buttons use consistent padding/radius from tokens
- [ ] Hover state shows subtle shadow lift or color change
- [ ] Focus ring is visible (min 3px, high contrast)
- [ ] All 4 variants render correctly

---

### ✅ Task 4: Build Core Card Component Styles
**Status**: Ready
**File(s)**: `style.css`
**Current State**: `.card` exists; needs simplification
**Changes**:
- [ ] Update `.card` to use tokens:
  - `--card-padding` (32px)
  - `--card-border-radius` (16px)
  - `--shadow-sm` for default state
  - `--shadow-md` for hover
- [ ] Remove border-top gradient accent (simplify)
- [ ] Keep hover lift (`translateY(-8px)`)
- [ ] Border should be subtle (use `--color-border-secondary`)

**Acceptance Criteria**:
- [ ] Cards use consistent padding and radius from tokens
- [ ] Hover shows shadow elevation (no complex borders)
- [ ] Visual hierarchy is clear

---

### ✅ Task 5: Build Form Input Component Styles
**Status**: Ready
**File(s)**: `style.css`
**Current State**: Basic input styles exist
**Changes**:
- [ ] Create standardized input styles using:
  - `--input-padding` (12px 16px)
  - `--input-border-radius` (12px)
  - `--font-size-base` for text
  - `--color-border-primary` for border
  - `--color-bg-tertiary` for background (light gray)
- [ ] Focus state: `--color-border-focus` (green) + `--shadow-focus`
- [ ] Ensure min touch target 48px height (accessible)
- [ ] Add placeholder styling with `--color-text-tertiary`
- [ ] Add disabled state styling (`opacity: 0.5`)

**Acceptance Criteria**:
- [ ] Inputs are accessible (labels associated, focus ring visible)
- [ ] Focus state is clearly visible
- [ ] Placeholder text is readable but dimmed
- [ ] Disabled inputs look disabled

---

## Phase 2: Navigation & Header

### ✅ Task 6: Redesign Header & Navigation
**Status**: Ready
**File(s)**: `header.php`, `style.css`
**Current State**: Header exists with fallback menu; needs nav simplification
**Design**:
- Logo | Buscar propiedades (CTA) | Cómo funciona | Contacto

**Changes**:
- [ ] Simplify header layout to 4 items max
- [ ] Replace "Servicios, Propiedades, Cómo funciona" with new nav:
  - Home (logo click)
  - "Buscar propiedades" (CTA button, prominent)
  - "Cómo funciona" (link)
  - "Contacto" (link)
- [ ] Remove decorative effects (keep sticky header, subtle shadow)
- [ ] Mobile: Hamburger menu with same 4 items
- [ ] Use `--color-bg-primary` and `--color-text-primary` for styling
- [ ] CTA button uses `--color-accent-primary`

**Acceptance Criteria**:
- [ ] Navigation is simple and scannable (4 items max)
- [ ] "Buscar propiedades" is visually prominent (green CTA)
- [ ] Mobile hamburger is accessible (aria-label, keyboard nav)
- [ ] Sticky header works smoothly
- [ ] All links are keyboard-navigable

---

## Phase 3: Homepage Sections (Renter-Focused)

### ✅ Task 7: Redesign Hero Section
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: Hero has 3D effects, gradient background, complex card
**Design**: Cleaner, property-focused
**Changes**:
- [ ] Simplify background: use solid `--color-bg-primary` or simple gradient
- [ ] Remove circuit pattern overlay and animated grid lines
- [ ] Hero headline: "Find your perfect place to rent" (or Spanish equivalent)
- [ ] Subheadline: Short, clear value prop
- [ ] CTA button: "Buscar propiedades" (primary button)
- [ ] Remove 3D transforms (rotateY, rotateX) from hero-card
- [ ] Hero layout: 2-column (desktop) → 1-column (mobile)
- [ ] If keeping visual mockup, simplify to static card with subtle shadow
- [ ] Responsive: Image stacks below text on mobile

**Acceptance Criteria**:
- [ ] Hero conveys trust and clarity (not tech-heavy)
- [ ] CTA is prominent and clear
- [ ] Layout is responsive (2-col → 1-col)
- [ ] No confusing visual effects

---

### ✅ Task 8: Redesign Stats Bar
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: Stats bar exists; shadow could be simplified
**Changes**:
- [ ] Simplify styling: use `--shadow-md` instead of complex shadows
- [ ] Use tokens for padding, border-radius
- [ ] Responsive: 4 columns (desktop) → 2 columns (tablet) → 1 column (mobile)
- [ ] Stat numbers stay green (`--color-accent-primary`)
- [ ] Keep overall structure; just polish styling

**Acceptance Criteria**:
- [ ] Stats are visually clear and aligned
- [ ] Shadow is subtle (not heavy)
- [ ] Responsive layout works on all breakpoints

---

### ✅ Task 9: Redesign Featured Properties Carousel
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: Carousel exists; needs simplification and focus on images
**Design**: Image-first, Airbnb-style cards
**Changes**:
- [ ] Property cards show:
  - Large image (prominent, 16:9 aspect ratio)
  - Property title
  - Location (city/neighborhood)
  - Price/night
  - Brief tags (WiFi, Pets, etc.)
  - "Ver detalles" button
- [ ] Use `--property-card-*` tokens
- [ ] Image should be lazy-loaded for performance
- [ ] Card hover: subtle shadow lift, no complex effects
- [ ] Carousel controls: simple arrows, dot indicators
- [ ] Responsive: Full carousel on desktop → 1 card on mobile

**Acceptance Criteria**:
- [ ] Images are prominent (16:9 ratio, high quality)
- [ ] Card design is clean and modern
- [ ] Carousel is intuitive (arrows, dots work)
- [ ] Mobile view shows 1 card at a time

---

### ✅ Task 10: Redesign Benefits Section (Renter-Focused)
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: "Problem" section exists (owner-focused); replace with renter benefits
**Content**: Replace owner problems with renter benefits (3-4 items):
- Trusted platform (safety, reliable)
- Quick process (find → book → move in)
- 24/7 support (always available)
- Clear pricing (no surprises)

**Changes**:
- [ ] Create benefit cards (instead of problem cards)
- [ ] Each card: Icon + headline + brief description
- [ ] Use neutral icons (not error/warning symbols)
- [ ] Cards should feel positive and approachable
- [ ] Grid: 4 columns (desktop) → 2 (tablet) → 1 (mobile)

**Acceptance Criteria**:
- [ ] Benefits clearly speak to renter needs
- [ ] Card design is clean and modern
- [ ] Icons are appropriate and readable
- [ ] Layout is responsive

---

### ✅ Task 11: Redesign "How It Works" Section
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: 4-step process exists (owner-focused); simplify to 3 steps (renter-focused)
**Content**:
1. Search – Browse available properties
2. Contact – Reach out to owner
3. Move In – Confirm terms and settle

**Changes**:
- [ ] Simplify to 3 steps (currently 4)
- [ ] Remove decorative connecting line (or make very subtle)
- [ ] Step cards: Number + headline + brief copy
- [ ] Use `--step-number` styling (circular badge with green background)
- [ ] Grid: 3 columns (desktop) → 1 column (mobile)
- [ ] Keep hover lift but remove complex effects

**Acceptance Criteria**:
- [ ] 3 steps are clear and sequential
- [ ] Numbers are visually distinct
- [ ] Responsive layout works
- [ ] Line or connector is subtle (not distracting)

---

### ✅ Task 12: Redesign Testimonials Section
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: Testimonial cards exist with blur effects; simplify
**Changes**:
- [ ] Simplify background (use solid color or very subtle gradient)
- [ ] Remove blur effects on cards
- [ ] Testimonial cards: Quote + author name + role
- [ ] Grid: 2 columns (desktop) → 1 column (mobile)
- [ ] Card styling: Use `--shadow-sm` + subtle border
- [ ] Quote icon is optional (can keep for accent)

**Acceptance Criteria**:
- [ ] Testimonials are readable and credible
- [ ] Cards are clean and modern
- [ ] No excessive visual effects
- [ ] Responsive layout works

---

### ✅ Task 13: Redesign Final CTA Section
**Status**: Ready
**File(s)**: `front-page.php`, `style.css`
**Current State**: CTA section exists; needs alignment with renter focus
**Changes**:
- [ ] Headline: "Ready to find your place?" (renter-focused)
- [ ] Subheadline: Brief call to action
- [ ] CTA button: "Browse properties" (primary button, green)
- [ ] Optional: Include contact form (secondary) or just button
- [ ] Background: Use `--color-bg-secondary` for contrast

**Acceptance Criteria**:
- [ ] CTA is clear and compelling
- [ ] Button is prominent
- [ ] Message aligns with renter journey

---

### ✅ Task 14: Update Footer
**Status**: Ready
**File(s)**: `footer.php`, `style.css`
**Changes**:
- [ ] Simplify footer styling (use tokens)
- [ ] Update footer links to reflect new site structure
- [ ] Ensure responsive (4 columns → 2 → 1)
- [ ] Legal links: Privacy policy, terms of service
- [ ] Keep brand presence (logo, brief description)

**Acceptance Criteria**:
- [ ] Footer is clean and organized
- [ ] All links work
- [ ] Responsive layout works

---

## Phase 4: New Pages (v1)

### ✅ Task 15: Create Property Listing Page (`/propiedades`)
**Status**: Ready
**File(s)**: Create new template or modify `archive.php`
**Content**:
- Search/filter header (sticky)
- Filter sidebar (desktop) / drawer (mobile)
- Property grid (responsive)
- Pagination or "Load more" button

**Primary Filters** (always visible):
- [ ] Location (dropdown or search box)
- [ ] Price range slider (example: 500–5000)
- [ ] Property type (radio/checkboxes: Apartamento, Casa, Habitación, Estudio)
- [ ] Availability (dropdown: Available now, Next week, Date picker)

**Secondary Filters** ("Más filtros" accordion, not primary):
- WiFi, Pets allowed, Kitchen, Gym, Parking, etc. (add in v2 if needed)

**Property Grid**:
- [ ] Cards use `--property-card-*` tokens
- [ ] 3 columns (desktop) → 2 (tablet) → 1 (mobile)
- [ ] Image-first design (16:9 ratio)
- [ ] "Ver detalles" button links to property detail page

**Pagination**:
- [ ] Show 12 properties per page (or "Load more" button)
- [ ] Pagination links at bottom

**Acceptance Criteria**:
- [ ] 4 primary filters work and are accessible
- [ ] Property grid is clean and responsive
- [ ] Pagination works
- [ ] No performance issues (lazy load images)

---

### ✅ Task 16: Create Property Detail Page (`/propiedades/[slug]`)
**Status**: Ready
**File(s)**: Create new `single-property.php` template or modify `single.php`
**Simplified structure** (6-7 blocks, not 11):
1. Image gallery (full-width hero + thumbnails)
2. Main summary (title, location, price, rating if applicable)
3. Price & conditions (rent, deposit, contract length, utilities included)
4. Key amenities (icons only, WiFi/Kitchen/Pets/etc., not massive list)
5. Location & map (address, neighborhood)
6. House rules & requirements (brief, in accordion if long)
7. CTA block (Owner info + "Contact now" button, sticky on mobile)

**NOT in v1** (defer to v2):
- Testimonials per property
- Related properties carousel
- Full amenities breakdown
- Complex booking UI

**Acceptance Criteria**:
- [ ] Image gallery works (swipe on mobile, click for lightbox)
- [ ] All content is readable and well-spaced
- [ ] Contact CTA is prominent and sticky on mobile
- [ ] Responsive layout works
- [ ] Loads fast (images optimized)

---

### ✅ Task 17: Create Contact Page (`/contacto`)
**Status**: Ready
**File(s)**: Create new WordPress page or modify `page.php`
**Content**:
- Hero section ("Contáctanos")
- Contact info (email, phone, hours if applicable)
- Contact form (name, email, subject, message, phone)
- Optional: FAQ shortcuts or social links

**Form Fields**:
- [ ] Name (required, text)
- [ ] Email (required, email type)
- [ ] Subject (dropdown or text, required)
- [ ] Message (textarea, required)
- [ ] Phone (optional)
- [ ] Submit button
- [ ] Success/error messaging

**Acceptance Criteria**:
- [ ] Form is accessible (labels, required indicators, error handling)
- [ ] Submit button is prominent
- [ ] Confirmation message shown on success
- [ ] Responsive layout works

---

## Phase 5: Polish & QA

### ✅ Task 18: Responsive Design & Mobile Refinement
**Status**: Ready
**File(s)**: All component files
**Breakpoints**:
- Mobile: < 600px
- Tablet: 600px–899px
- Desktop: 900px+

**Focus Areas**:
- [ ] Navigation: Hamburger menu on mobile
- [ ] Hero: 2-col → 1-col, image stacks below text
- [ ] Property grid: 3-col → 2-col → 1-col
- [ ] Filter sidebar: Fixed sidebar (desktop) → Drawer (mobile)
- [ ] Buttons: Min 48px height for touch targets
- [ ] Spacing: Generous on desktop, adjusted on mobile
- [ ] Images: Responsive sizes (srcset, loading="lazy")

**Real Device Testing** (required):
- [ ] iPhone or Android phone (375–430px)
- [ ] iPad or Android tablet (768px)
- [ ] Desktop Chrome/Firefox/Safari (1200px+)

**Acceptance Criteria**:
- [ ] All breakpoints are responsive
- [ ] Touch targets are min 48px
- [ ] Sticky header works smoothly
- [ ] Images load fast (lazy loading works)
- [ ] No horizontal scroll on mobile

---

### ✅ Task 19: Accessibility Audit & Fixes
**Status**: Ready
**File(s)**: All component files
**WCAG 2.1 Level AA Checklist**:
- [ ] Color contrast: 4.5:1 for normal text, 3:1 for large
- [ ] Focus ring: Visible, min 3px, green (`--color-border-focus`)
- [ ] Keyboard navigation: Tab order logical, no traps
- [ ] Form labels: All inputs have associated `<label>` tags
- [ ] Error messages: Clear, linked to inputs
- [ ] Screen reader: Semantic HTML (buttons, links, headings), ARIA labels where needed
- [ ] Images: Descriptive alt text (or `alt=""` if decorative)
- [ ] Motion: Respect `prefers-reduced-motion` query
- [ ] Skip link: "Skip to content" at top of page

**Testing Tools**:
- [ ] axe DevTools (browser extension) — run on each page
- [ ] Keyboard-only navigation (no mouse)
- [ ] Tab through all interactive elements

**Acceptance Criteria**:
- [ ] 0 accessibility violations in axe
- [ ] All interactive elements keyboard-accessible
- [ ] Focus ring visible on all focusable elements
- [ ] Form validation is clear

---

### ✅ Task 20: Performance Optimization & Final QA
**Status**: Ready
**File(s)**: All component files
**Targets**:
- Lighthouse Performance: > 90
- First Contentful Paint (FCP): < 1.5s
- Largest Contentful Paint (LCP): < 2.5s
- Cumulative Layout Shift (CLS): < 0.1

**Optimization**:
- [ ] Lazy-load images (`loading="lazy"`)
- [ ] Compress images (WebP with JPEG fallback)
- [ ] Minify CSS (if applicable)
- [ ] Pagination limits DOM (12 properties per page, not all 150+)
- [ ] No unused CSS or JS
- [ ] Remove heavy effects (blur, complex gradients)

**Final QA Checklist**:
- [ ] All buttons use token values (no hardcoded colors)
- [ ] All cards use token values (padding, radius, shadow)
- [ ] All text uses token sizes/weights
- [ ] All spacing uses token values (--space-*)
- [ ] All transitions use token durations (150–250ms)
- [ ] Hover/focus states work consistently
- [ ] No console errors or warnings

**Testing**:
- [ ] Lighthouse audit (Chrome DevTools)
- [ ] Core Web Vitals check
- [ ] Cross-browser test (Chrome, Firefox, Safari, Edge)

**Acceptance Criteria**:
- [ ] Lighthouse Performance score > 90
- [ ] Design is cohesive (tokens applied everywhere)
- [ ] No accessibility violations
- [ ] No console errors
- [ ] Site feels modern, clean, professional, warm, trustworthy

---

## Task Dependency Map

```
Task 1 (Import Tokens) → Task 2–5 (Base styles + components)
                              ↓
                    Task 6 (Header)
                              ↓
                    Task 7–14 (Homepage sections — 7 tasks)
                              ↓
                    Task 15–17 (New pages — 3 tasks)
                              ↓
                    Task 18–20 (Polish & QA — 3 tasks)
```

**Total**: 20 tasks (reduced from 22)

All foundation tasks (1–5) must complete before component tasks (6–20).
Tasks can be reviewed in parallel once dependencies are met.

---

## Build Workflow

**Recommended workflow**:
1. Complete Phase 1 (foundation) first
2. Do Phase 2 (header) once foundation is solid
3. Build homepage sections in order (Phase 3)
4. Build new property pages (Phase 4)
5. Polish and optimize (Phase 5)

Each task can be reviewed/deployed independently, but earlier tasks enable later ones.

---

## Definition of Done

A task is complete when:
- [ ] Code is written and tested locally
- [ ] No console errors or warnings (accessibility, performance)
- [ ] Responsive design works (mobile, tablet, desktop)
- [ ] WCAG 2.1 AA accessibility standards met
- [ ] Design tokens are used (no hardcoded values)
- [ ] Visual review passed (matches design brief)
- [ ] Performance targets met (images optimized, no layout shift)
- [ ] Browser compatibility tested (Chrome, Firefox, Safari, Edge)

---

## Notes for Developers

- **Always use tokens**: Never hardcode colors, spacing, sizes. Use CSS variables from `design-tokens.css`.
- **Mobile first**: Build for mobile first, then enhance for larger screens.
- **Performance matters**: Lazy-load images, compress assets, monitor Core Web Vitals.
- **Accessibility first**: Every component should be keyboard-navigable and screen-reader friendly.
- **Test early and often**: Don't wait until the end to test responsive, a11y, and performance.
- **Communicate blockers**: If a task is blocked (missing data, unclear requirements), speak up early.

---

## v1 Launch Criteria

When all 20 tasks are complete, the site should:

**User Experience**
- ✅ Renter can find properties in < 3 clicks (home → search → results)
- ✅ Property details are clear and scannable (6-7 blocks, not overwhelming)
- ✅ Contact/inquiry is obvious (CTA visible in 2+ places per page)
- ✅ Works on mobile without frustration (48px touch targets, no scroll jank)

**Design & Aesthetics**
- ✅ Feel modern, clean, approachable (Stripe precision + Airbnb warmth)
- ✅ Navy + green used strategically (not overwhelming)
- ✅ Warm neutrals in backgrounds/borders (not cold/corporate)
- ✅ Sombras sutiles, sin excesos (no blur, no glow)
- ✅ Consistent use of tokens (no hardcoded values)

**Technical**
- ✅ WCAG 2.1 AA compliant (contrast, focus, keyboard nav, ARIA)
- ✅ Lighthouse Performance > 90
- ✅ No console errors
- ✅ Works on Chrome, Firefox, Safari, Edge
- ✅ Images optimized (lazy load, WebP fallback)

**Brand Integrity**
- ✅ Navy (`#1D2D44`) and green (`#7DBE52`) palette preserved
- ✅ Logo and header visible on all pages
- ✅ Brand promise: "Find your place, fast"

**Scope Boundaries**
- ✅ 4 pages launched: Home, Listing, Detail, Contact
- ✅ 4 primary filters functional (location, price, type, availability)
- ✅ Property detail: 6-7 blocks (not 11)
- ✅ Placeholders acceptable (real content integrates in v2)
- ✅ Frontend-first (no backend integration yet)
