# Project Decisions – Platform Redesign v1

**Date**: 2026-04-28
**Status**: 🟢 Go / Approved

---

## ✅ Confirmations & Decisions

### Audience & Vision
- ✅ **Primary user**: Renter (arrendatario)
- ✅ **Homepage direction**: Renter-focused (find properties fast)
- ✅ **Secondary audience**: Owners (propietarios) → Separate landing later, not in v1

### Scope – Pages (v1 Only)
| Page | Status | Notes |
|------|--------|-------|
| Homepage | ✅ Build | Renter-focused, sections optimized |
| Property Listing (`/propiedades`) | ✅ Build | With filters, grid, pagination |
| Property Detail (`/propiedades/[slug]`) | ✅ Build | Simplified to 6-7 blocks, not 11 |
| Contact (`/contacto`) | ✅ Build | Simple form + info |
| How It Works (`/como-funciona`) | ❌ Skip v1 | Lives as homepage section only. Separate page if SEO/campaign need arises later. |
| Owner Landing (`/para-propietarios`) | ❌ Skip v1 | Add link in header/footer ("¿Eres propietario?"). Build separate landing in Phase 2. |

**Impact**: 4 pages to build (not 6). Reduces scope ~30%.

---

### Filters (Property Listing)

**Primary filters** (always visible):
1. Location (dropdown or search box)
2. Price range (slider)
3. Property type (radio/checkboxes: Apartamento, Casa, Habitación, Estudio)
4. Availability (dropdown: Available now, Next week, Date picker)

**Secondary filters** ("Más filtros" accordion):
- WiFi, Pets allowed, Kitchen, Gym, Parking, etc.

**Impact**: Simpler UX, less overwhelming. Easy to expand later.

---

### Property Detail Page

**Simplified structure** (6-7 blocks, not 11):
1. Image gallery (hero + thumbnails)
2. Main summary (title, location, price, rating if applicable)
3. Price & conditions (monthly rent, deposit, contract length, utilities included)
4. Key amenities (WiFi, Kitchen, Pets, etc. — just icons, no massive list)
5. Location & map (address, neighborhood, proximity to key places)
6. House rules & requirements (brief, in accordion if long)
7. CTA block (Owner info + "Contact now" button, sticky on mobile)

**Removed from v1**:
- Detailed testimonials per property (can add in v2)
- Related properties carousel (can add in v2)
- Full amenities breakdown (replace with icons only)
- Complex booking timeline UI

**Impact**: Faster to build, easier to use, cleaner. Can expand in v2 with data.

---

### Design Direction

**Color philosophy**:
- Navy (`#1D2D44`) as trust base (text, backgrounds, accents)
- Green (`#7DBE52`) only as functional accent (buttons, focus, highlights) — not everywhere
- Add **warm neutrals** for backgrounds/borders:
  - Warm white (`#fafaf8` instead of `#f2f2f2`)
  - Warm gray for borders (`#e8e8e6` instead of hard gray)
  - Cream/beige for card backgrounds on secondary sections
- **Remove cold feeling** — current grays feel corporate/tech. Warmer palette feels approachable.

**Shadows**:
- ✅ Keep simplified (sm, md, lg, xl)
- ✅ Remove blur-heavy effects
- ✅ No glows or gradients on shadows

**Overall feel**: Professional + Warm (not cold/corporate). Stripe's precision meets Airbnb's friendliness.

---

### Technical Decisions

**Stack**:
- ✅ WordPress/PHP (keep current structure)
- ✅ CSS variables (not Tailwind) — fits theme, reduces friction
- ✅ No structural refactor (use existing patterns)
- ✅ Frontend-first (placeholders for content, integrate backend later)

**Testing Requirements**:
- ✅ Desktop Chrome/Firefox/Safari
- ✅ Tablet iPad or Android tablet simulator
- ✅ **Mobile real device preferred** (iPhone or Android phone)
  - Reason: Sticky header, keyboard on mobile, touch targets, scroll behavior need real testing
- ✅ Accessibility (axe DevTools + keyboard nav)
- ✅ Performance (Lighthouse, Core Web Vitals)

**Deployment**:
- Build on staging first, validate with team, then merge to production
- No breaking changes to existing owner-facing functionality

---

### Timeline (Realistic)

**Assumption**: 1 developer, frontend-first, placeholders OK, no backend integration yet.

| Phase | Tasks | Estimated | Notes |
|-------|-------|-----------|-------|
| Phase 1: Foundation | 5 | 2–3 days | Tokens, base styles, core components |
| Phase 2: Header | 1 | 1 day | Navigation simplification |
| Phase 3: Homepage | 7 | 4–5 days | Simplified from 8 (removed "Cómo funciona" page) |
| Phase 4: New Pages | 3 | 5–6 days | Property listing, detail (simplified), contact |
| Phase 5: Polish & QA | 3 | 2–3 days | Responsive, accessibility, performance |
| **Total v1** | **19** | **3–4 weeks** | Frontend-first, no backend, placeholders |

**If backend integration is included** → Add 2–3 weeks for API integration, data flow, edge cases.

---

### Out of Scope (v1)

- ❌ Owner dashboard (phase 2)
- ❌ Owner landing (`/para-propietarios`) (phase 2)
- ❌ "Cómo funciona" page (homepage section is enough)
- ❌ Dark mode (designed for, not implemented)
- ❌ Blog/Resources section
- ❌ Search autocomplete (backend feature)
- ❌ Booking system / Payments (backend feature)
- ❌ Multi-language support
- ❌ Full property detail page with 11 blocks

---

### Questions Resolved

#### Q: "What if owners ask why homepage focuses on renters?"
**A**: Because renters are the paying/engaged user. Owners will have `/para-propietarios` landing. Homepage is marketing to growth audience. Explain in launch communication.

#### Q: "When do we build the owner dashboard?"
**A**: Phase 2 (not in scope for v1). Owner dashboard is separate project, doesn't block renter experience.

#### Q: "Do we need "Cómo funciona" page for SEO?"
**A**: Not yet. Homepage section is enough for launch. If marketing wants to run campaigns or SEO shows demand, build separate page in v2.

#### Q: "What about property detail feature X?"
**A**: If it's not in the 6-7 blocks, it goes in v2. We're shipping a working MVP, not a feature-complete product. Feedback from real users will guide v2 priorities.

#### Q: "Can we use Tailwind instead of CSS variables?"
**A**: Not in v1. CSS variables fit better with current theme, reduce migration risk. Tailwind is option for v2 if scalability becomes issue.

#### Q: "Do we need real images for launch?"
**A**: Placeholders are OK for v1. Design should work with good imagery (16:9 aspect ratio, high quality). Real property images integrate in v2 with backend.

---

## ✅ Sign-Off

**Renter-first redesign v1 is approved to proceed.**

**Key commitments**:
1. ✅ 4 pages (Home, Listing, Detail, Contact)
2. ✅ Simplified UI (4 primary filters, 6-7 detail blocks)
3. ✅ Warm neutral design (navy + green + warm grays)
4. ✅ CSS variables (no Tailwind)
5. ✅ Frontend-first, placeholders OK
6. ✅ 3–4 week timeline
7. ✅ Mobile testing on real devices
8. ✅ WCAG 2.1 AA accessibility

**Owner landing deferred to Phase 2** with visible link in header/footer.

---

## Next Step

👉 **Phase 1: Foundation** begins.

Import tokens, build base styles, create core components (buttons, cards, inputs).

Ready to start? ✅
