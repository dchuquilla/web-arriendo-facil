# Information Architecture: Arriendo Fácil Platform Redesign

## Site Map

```
/ (Landing – Arrendatario)
├── /propiedades (Property Listing & Search)
│   └── /propiedades/[slug] (Property Detail Page)
├── /como-funciona (How It Works)
├── /contacto (Contact)
└── /para-propietarios (Separate landing for Owners – minimal scope)

Additional:
├── /politica-privacidad (Privacy Policy)
├── /terminos-servicio (Terms of Service)
└── /faq (FAQ – future phase)
```

### URL Patterns

| Path | Purpose | Template | User |
|------|---------|----------|------|
| `/` | Main landing; call-to-action for property discovery | front-page.php | Renter |
| `/propiedades` | Property search + filter interface; shows paginated or infinite-scroll results | archive.php (or custom) | Renter |
| `/propiedades/[slug]` | Individual property detail; full info, images, contact form | single.php (custom post type) | Renter |
| `/como-funciona` | Step-by-step process; builds trust; SEO-friendly | page.php | Renter |
| `/contacto` | Contact form, support info, FAQ shortcuts | page.php | Both |
| `/para-propietarios` | Owner-focused landing; minimal for now | separate page or template | Owner |

---

## Navigation Model

### Primary Navigation (All Pages)

**Desktop Header (Fixed/Sticky)**
```
[Logo: Arriendo Fácil] | [Buscar propiedades] | [Cómo funciona] | [Contacto]
```

- **Logo**: Links to `/` (home). Clickable brand reinforces trust.
- **Buscar propiedades**: CTA button linking to `/propiedades`. Visual weight = primary action.
- **Cómo funciona**: Educational link to `/como-funciona`. Reduces friction for uncertain renters.
- **Contacto**: Link to `/contacto`. Support signal for trust-building.

**Mobile Navigation (< 768px)**
- Hamburger menu (3-line icon, top-right)
- Slides in from top or side; same 4 nav items
- Logo always visible; nav toggle clearly labeled

### Secondary Navigation

**On `/propiedades` (Property Listing)**
- Sidebar or inline filters (left or top, depending on breakpoint)
  - Price range slider
  - Location (dropdown or search)
  - Property type (checkboxes)
  - Other features (checklist)
- Sort options: Relevance, Price (low-high, high-low), Newest, Distance (if location set)

**On `/propiedades/[slug]` (Property Detail)**
- Breadcrumb: `Home > Propiedades > [Property Name]`
- Image gallery nav: Thumbs or lightbox arrows
- Sticky CTA button: "Contactar ahora" or "Iniciar arriendo"

### Utility Navigation

**Footer (All Pages)**
```
[Logo & Brand Description] | [Links] | [Social] | [Legal]
```
- Links: Quiénes somos, Blog, Soporte
- Legal: Política de privacidad, Términos de servicio
- Social: Links to social media (if applicable)

---

## Content Hierarchy

### Homepage (`/`)

**User Goal**: Understand platform value and take action to explore properties.

**Content Order** (above to below fold):

1. **Hero Section** ⭐⭐⭐
   - Why: Immediate value prop. Sets emotional tone (trust, modernity).
   - Content: Headline ("Find your perfect place"), subheadline, CTA button ("Buscar ahora")
   - Visual: Hero image or background (quality matters for trust)
   - Accessibility: High contrast, clear CTA

2. **Featured Properties Carousel** ⭐⭐⭐
   - Why: Renter's primary need is to see available options immediately.
   - Content: 4–6 curated property cards (image, title, location, price, quick details)
   - Interaction: Carousel controls (previous/next) or swipe on mobile
   - Performance: Lazy-load images, optimize file size

3. **Benefits for Renters** ⭐⭐
   - Why: Addresses renter concerns (trust, ease, safety)
   - Content: 3–4 benefit cards (e.g., "Trusted platform," "Quick process," "24/7 support")
   - Visual: Icons or small illustrations, not overwhelming

4. **How It Works** ⭐⭐
   - Why: Reduces friction; renters want to understand the process before committing
   - Content: 3 steps (Search → Book → Move In) with icons and brief copy
   - Link: "Learn more" button to `/como-funciona` (full page)

5. **Testimonials** ⭐
   - Why: Social proof builds trust; secondary but important
   - Content: 2–3 renter quotes with names, brief context
   - Visual: Simple cards, no excessive styling

6. **Final CTA Section** ⭐⭐
   - Why: Last chance to drive action before footer
   - Content: Headline ("Ready?") + button ("Browse all properties")
   - Link: Directs to `/propiedades`

7. **Footer** ⭐
   - Why: Legal, support, navigation
   - Content: Links, social, legal pages

---

### Property Listing & Search (`/propiedades`)

**User Goal**: Discover properties efficiently using filters; see results clearly.

**Layout Structure** (above to below fold):

1. **Search Header** ⭐⭐⭐
   - Sticky or prominent at top
   - Input field: "Search by location..." (search text)
   - Filters button: "Filtrar" (mobile) or sidebar (desktop)
   - Sort dropdown: "Ordenar por: Relevancia, Precio, Más nuevos"

2. **Filters Panel** (Sidebar on desktop, Drawer on mobile) ⭐⭐⭐
   - Price range: Slider (`$500–$5000 per month`)
   - Location: Search box or dropdown (auto-complete if many options)
   - Property type: Checkboxes (Apartamento, Casa, Habitación, Estudio)
   - Other features: Checkboxes (WiFi, Mascotas permitidas, Cocina, Gimnasio, etc.)
   - Action buttons: "Aplicar filtros," "Limpiar filtros"

3. **Results Counter** ⭐
   - Text: "Showing X of Y properties"
   - Helps user understand scope; transparency builds trust

4. **Property Grid** ⭐⭐⭐
   - Responsive: 3 columns (desktop) → 2 columns (tablet) → 1 column (mobile)
   - Card content (minimum):
     - Image (full-width, 16:9 aspect ratio, high quality)
     - Title (property name)
     - Location (city, neighborhood)
     - Price (per month, clearly marked)
     - Brief tags (WiFi, Pets, etc.)
     - "Ver detalles" button
   - Hover state: Subtle shadow lift, image zoom (slight)
   - Lazy loading: Load images as user scrolls

5. **Pagination or Infinite Scroll** ⭐⭐
   - Recommendation: Pagination (clearer for UX, better for SEO)
   - Options: "Previous | Page 1 2 3 ... | Next"
   - Or: "Load more" button at bottom (infinite scroll alternative)
   - Mobile: Single "Load more" button (easier thumb target)

6. **Empty State (if no results)** ⭐
   - Message: "No properties found. Try adjusting your filters."
   - Suggestions: Link to reset filters, or suggest popular areas

---

### Property Detail (`/propiedades/[slug]`)

**User Goal**: Understand property fully; build confidence; initiate contact/booking.

**Content Order**:

1. **Image Gallery** ⭐⭐⭐
   - Primary: Large hero image (full-width or near-full)
   - Thumbnails: Scrollable gallery of additional photos
   - Interaction: Click to expand, lightbox view, swipe on mobile
   - Performance: Lazy-load; use WebP with fallbacks

2. **Property Header** ⭐⭐⭐
   - Title: Property name
   - Location: Full address (or general area for privacy)
   - Price: Prominent, clearly marked (e.g., "$1,200/month")
   - Rating: Stars (if applicable) + number of reviews

3. **Quick Info Cards** ⭐⭐
   - Bedrooms, bathrooms, square footage, property type
   - Layout: 4-column grid (desktop) → 2 columns (mobile) → 1 column (small mobile)

4. **Description** ⭐⭐
   - Full property description (max 2–3 paragraphs)
   - Key features list (amenities, house rules)

5. **Amenities/Features** ⭐⭐
   - List of amenities with icons (WiFi, Kitchen, AC, etc.)
   - Clearly marked as included/not included

6. **House Rules** ⭐
   - If applicable; brief, clear rules

7. **Owner/Contact Info** ⭐⭐⭐
   - Owner name/avatar
   - Brief bio (trust signal)
   - Response time (e.g., "Usually responds in 2 hours")
   - Contact button: "Contactar propietario" (prominent CTA)

8. **Booking / Contact Form** ⭐⭐⭐
   - CTA button: "Iniciar arriendo" or "Contactar ahora"
   - Form fields: Name, email, phone, move-in date, questions
   - Accessibility: Labels, error handling, success message

9. **Testimonials** ⭐
   - 2–3 past renter reviews (if applicable)
   - Rating, quote, renter name

10. **Related Properties** ⭐
    - Carousel or grid: "Similar properties" in same area or price range
    - Link back to search

11. **Breadcrumb & Footer** ⭐
    - Breadcrumb at top for navigation context
    - Footer with standard links

---

### How It Works (`/como-funciona`)

**User Goal**: Understand the rental process step-by-step; remove uncertainty; build confidence.

**Content Order**:

1. **Hero Section** ⭐⭐
   - Title: "Cómo funciona Arriendo Fácil"
   - Subheading: "Un proceso simple y seguro en 3 pasos"

2. **Process Steps** ⭐⭐⭐
   - Step 1: Buscar (Browse, filter, find)
   - Step 2: Contactar (Reach out to owner, ask questions)
   - Step 3: Confirmar (Agree on terms, check in)
   - For each step: Icon, headline, description, optional screenshot

3. **Benefits Section** ⭐⭐
   - Why use Arriendo Fácil: Trust, protection, support

4. **FAQ** ⭐
   - Common questions: How long does it take? What's the fee? Can I cancel?
   - Accordion or collapsible sections

5. **CTA** ⭐⭐
   - "Ready to find your place?" → Button to `/propiedades`

---

### Contact (`/contacto`)

**User Goal**: Reach support; submit inquiry; get questions answered.

**Content Order**:

1. **Hero Section** ⭐⭐
   - Title: "Contáctanos"
   - Subheading: "Estamos aquí para ayudarte"

2. **Contact Methods** ⭐⭐
   - Email, phone, chat/support link
   - Hours of operation (if applicable)

3. **Contact Form** ⭐⭐⭐
   - Fields: Name, email, subject, message, phone (optional)
   - Submit button
   - Success/error message handling

4. **FAQ Shortcuts** ⭐
   - Link to common questions
   - Reduces support burden

---

## User Flows

### Flow 1: Renter Discovery (Homepage → Property Listing → Detail)

```
1. User lands on / (Homepage)
   ↓
2. User sees hero + featured properties
   - Decision: Explore featured property or search all?
   ↓ (A) Click featured property
3. User goes to /propiedades/[slug] (Property Detail)
   ↓ (B) Click "Buscar propiedades" CTA
4. User goes to /propiedades (Property Listing)
   ↓
5. User filters/searches (price, location, type)
   ↓
6. User sees results grid
   ↓
7. User clicks property card
   ↓
8. User views /propiedades/[slug] (Detail)
   ↓
9. User clicks "Contactar" or "Iniciar arriendo"
   ↓
10. Contact form opens or user is directed to contact flow
```

### Flow 2: Direct Search

```
1. User lands on / (Homepage)
   ↓
2. User clicks "Buscar propiedades" in nav
   ↓
3. User goes to /propiedades
   ↓
4. User sets filters
   ↓
5. User browsing results
   ↓
6–10. (Same as Flow 1 from step 6 onward)
```

### Flow 3: Education + Discovery

```
1. User lands on / (Homepage)
   ↓
2. User sees "Cómo funciona" section
   ↓
3. User clicks "Learn more"
   ↓
4. User goes to /como-funciona (How It Works page)
   ↓
5. User reads process
   ↓
6. User clicks "Buscar ahora" CTA
   ↓
7. User goes to /propiedades
   ↓
8–10. (Property discovery continues)
```

### Flow 4: Contact Support

```
1. User is on any page
   ↓
2. User clicks "Contacto" in nav
   ↓
3. User goes to /contacto
   ↓
4. User fills contact form
   ↓
5. Form submitted; confirmation message shown
   ↓
6. Support team follows up
```

---

## Naming Conventions

Consistency across the UI. Pick one term and use everywhere:

| Concept | Label in UI | Why |
|---------|------------|-----|
| Rental listing | Propiedad | Short, familiar in Spanish rental market |
| View details | Ver detalles | Standard CTA; clear action |
| Contact owner | Contactar propietario | Direct, transparent |
| Start rental | Iniciar arriendo | Clear action aligned with renter goal |
| Filter | Filtrar | Consistent with common pattern |
| Apply filters | Aplicar filtros | Clear action |
| Property features | Características / Amenidades | Use consistently; avoid mixing |
| Owner profile | Perfil del propietario | Standard terminology |
| Review / Testimonial | Reseña / Testimonio | Use "Reseña" for user-generated, "Testimonio" for case studies |
| How it works | Cómo funciona | Short, catchy, familiar |

---

## Component Reuse Map

Structural components shared across pages to maintain consistency and efficiency:

| Component | Used On | Behavior Differences |
|-----------|---------|---------------------|
| Header (nav + logo) | All pages | Sticky; mobile hamburger adapts |
| Hero section | `/`, `/como-funciona`, `/contacto` | Image/background varies; copy changes |
| Property card | `/propiedades` (grid), `/` (featured carousel) | Detail level varies (carousel = minimal; grid = full) |
| Contact form | `/contacto`, `/propiedades/[slug]` | Fields may vary (support form vs. inquiry form) |
| CTA button (primary) | All pages | Same style; link destination varies |
| Footer | All pages | Consistent layout and links |
| Breadcrumb | `/propiedades`, `/propiedades/[slug]`, `/como-funciona` | Number of levels varies |

---

## Content Growth Plan

**Dynamic vs. Static Content**

- **Properties**: Grows continuously (150+ and expanding)
  - Strategy: Pagination (recommended) or "Load more" infinite scroll
  - Searchable/filterable; indexed by price, location, type
  - Archive pattern: Older properties may be deprioritized or archived

- **Featured Properties** (Homepage carousel): Curated set; rotates monthly
  - Static list; marketing team updates

- **Testimonials**: Grows as renters submit reviews
  - Homepage: 2–3 featured
  - Property detail: 2–3 property-specific
  - Future: Dedicated testimonials page

- **Blog / Resources** (Future phase): If added, use standard blog archive + pagination

- **FAQ**: Initially static; grows as support collects common questions
  - Single `/faq` page with categories and search

---

## URL Strategy

### Pattern Rules

```
/propiedades           → Property listing (filterable archive)
/propiedades/[slug]    → Individual property detail (unique URL per property)
/como-funciona         → Static educational page
/contacto              → Static contact page
/para-propietarios     → Owner-focused landing (may expand to /dashboard, /admin in future)
/politica-privacidad   → Legal page
/terminos-servicio     → Legal page
```

### Query Parameters (on `/propiedades`)

- `?price=500-2000` → Filter by price range
- `?location=bogota` → Filter by location (slug)
- `?type=apartamento` → Filter by property type
- `?sort=price_asc` → Sort order
- `?page=2` → Pagination

Example: `/propiedades?location=bogota&price=500-1500&sort=price_asc&page=2`

### Dynamic Segments

- `[slug]` in `/propiedades/[slug]` = unique property identifier
  - Example: `/propiedades/apartamento-moderno-bogota-123`
  - Slug should be readable (property name + location) for SEO

---

## Mobile-First Responsive Patterns

**Breakpoints** (matching current codebase):
- Mobile: < 600px
- Tablet: 600px – 899px
- Desktop: 900px+

**Layout Adaptations**:
- **Navigation**: 4 items (logo, search, how-it-works, contact) → Hamburger menu on mobile
- **Hero**: 2-column (desktop) → 1-column (mobile); image stacks below text
- **Property grid**: 3 columns (desktop) → 2 columns (tablet) → 1 column (mobile)
- **Filters**: Sidebar (desktop) → Drawer/modal (mobile); slide in from left or top
- **Property detail**: 2-column layout (images left, info right, desktop) → 1-column stacked (mobile)
- **Cards**: Maintain spacing; ensure touch targets min 48px (buttons, links)

---

## Accessibility Considerations

All pages follow WCAG 2.1 Level AA:

- **Keyboard navigation**: Tab order logical; no traps; focus ring visible
- **Screen readers**: Semantic HTML; ARIA labels for custom components (filters, carousels, modals)
- **Color contrast**: 4.5:1 minimum for text; 3:1 for large text
- **Focus management**: Modals trap focus; close/return properly
- **Forms**: Labels associated with inputs; error messages clear; required fields marked
- **Images**: Descriptive alt text; carousel has ARIA controls
- **Skip links**: "Skip to content" link at top of page (for keyboard users)
- **Reduced motion**: Respect `prefers-reduced-motion`; no auto-play animations

---

## Performance Targets

- **First Contentful Paint (FCP)**: < 1.5s
- **Largest Contentful Paint (LCP)**: < 2.5s
- **Cumulative Layout Shift (CLS)**: < 0.1
- **Time to Interactive (TTI)**: < 3.5s

**Optimization strategies**:
- Lazy-load images (especially property photos)
- Compress images (WebP with fallbacks)
- Minimize CSS/JS; defer non-critical JS
- Use pagination or infinite scroll to limit DOM nodes
- Cache filter results (localStorage or server-side)

---

## Next Phase

Phase 4 (Design Tokens) will establish the visual language (colors, spacing, typography, shadows) based on the Stripe + Airbnb aesthetic defined in the brief.

Then Phase 5 (Brief to Tasks) will break this IA into a build checklist.
