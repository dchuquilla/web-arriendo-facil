# Design Brief: Arriendo Fácil 2.0

**Fecha:** Septiembre 1, 2026  
**Proyecto:** Landing Page + Slash Blog (Posicionamiento B2B)  
**Feature Slug:** `arriendo-facil-v2`

---

## 1. Descripción Ejecutiva

Arriendo Fácil está pivotando de una plataforma renter-facing a un **sistema interno de gestión operativa de propiedades**. Esta landing page y blog comunican externamente qué ofrecemos: un gestor profesional de la operación diaria de arriendos (cuotas, servicios básicos, cánones, control de pagos) para operadores y propietarios que ya tienen la ocupación asegurada.

**Core Message:** "Nosotros manejamos la operación. Tú enfócate en crecer."

---

## 2. Objetivos

1. **Comunicar claramente** el nuevo giro de negocio (de marketplace a SaaS operativo)
2. **Generar leads** de operadores/propietarios interesados en gestión profesional
3. **Posicionarse como expertos** en operación de arriendos en Ecuador
4. **Reutilizar assets** del frontend actual sin eliminar nada (solo ocultar)
5. **Mantener consistencia visual** con la identidad Arriendo Fácil

---

## 3. Audiencia Primaria

**Segmento:** Operadores de propiedades, propietarios con múltiples unidades, gestoras inmobiliarias

**Pain Points:**
- Caos en el control de pagos de cuotas y servicios
- Falta de claridad en alícuotas y distribución de gastos
- Procesos manuales y propensos a errores
- Sin visibilidad sobre cánones de arriendo

**Necesidades:**
- Solución centralizada y confiable
- Automatización de cálculos y reportes
- Control granular de ingresos y gastos
- Soporte profesional

---

## 4. Propuesta de Valor

| Aspecto | Ventaja |
|--------|---------|
| **Experiencia** | 150+ propiedades gestionadas, 98% ocupación |
| **Especialización** | Enfocados solo en la operación, no en ocupación |
| **Transparencia** | Cuotas, alícuotas, servicios en un dashboard |
| **Escalabilidad** | Sistema diseñado para crecer contigo |
| **Soporte Local** | Equipo que entiende el mercado Ecuador |

---

## 5. Dirección Visual & Filosofía

**Paleta de Colores:**
- **Primario:** Azul marino `#1D2D44` (confianza, profesionalismo)
- **Acento:** Verde dólar `#7DBE52` (crecimiento, dinero)
- **Hover/Secundario:** Verde bosque `#4B8B4B`
- **Fondo:** Gris suave `#F2F2F2`

**Filosofía Estética:**
- **Moderno + Corporate:** Limpio, minimalista, pero acogedor
- **B2B Intent:** Profesional sin ser frío; accesible sin ser simplista
- **Mobile-First:** Responsive, rápido, optimizado para decisiones on-the-go
- **Energía de crecimiento:** Verde dólar activo, CTA prominentes

**Tipografía & Espaciado:**
- Mantener sistema de design tokens actual (Inter, scale 4px, sombras Stripe-like)
- Mejorar jerarquía visual para contenido B2B

---

## 6. Estructura de Página Propuesta

### 6.1 Hero Section
**Objetivo:** Comunicar propuesta de valor de un vistazo

**Elementos:**
- Headline fuerte: "Operación de propiedades sin el estrés"
- Subheadline: "Gestiona cuotas, servicios y pagos en un lugar. Deja la ocupación a otros."
- Imagen/Ilustración: Dashboard en uso o gráfico de control
- CTA Primario: "Ver Demo" o "Hablar con un especialista"

---

### 6.2 Problema (Pain Point Section)
**Objetivo:** Conectar emocionalmente con operadores frustrados

**Formato:** 3-4 cards con dolor específico + icono
- ❌ "Cuotas calculadas en Excel, pagos perdidos"
- ❌ "Sin visibilidad sobre qué inquilino debe qué"
- ❌ "Alícuotas imposibles de explicar a propietarios"
- ❌ "Crecimiento detenido por gestión manual"

---

### 6.3 Cómo Resolvemos (Solution Section)
**Objetivo:** Presentar el sistema de forma tangible

**Formato:** Diagrama visual + copy
- **Cuotas Centralizadas:** Todo el dinero en un lugar, reportes en tiempo real
- **Servicios Automáticos:** Cálculos claros, pagos scheduled
- **Alícuotas Transparentes:** Dashboard para propietarios y operadores
- **Control de Pagos:** Alertas, historial, proyecciones

---

### 6.4 Características/Módulos (Features Section)
**Objetivo:** Mostrar alcance sin overwhelm

**Formato:** 4 tarjetas grandes con icono + descripción breve
1. 📊 **Control de Cuotas** — Ingresos, calendario, histórico
2. 💰 **Gestión de Servicios** — Agua, luz, gas, internet
3. 📋 **Alícuotas** — Distribución automática, reportes
4. ✓ **Control de Pagos** — Seguimiento, alertas, cobranza

---

### 6.5 Social Proof (Opcional: Stats/Testimonials)
**Objetivo:** Generar confianza

**Formato:** Stats o testimonial de cliente actual
- "150+ propiedades bajo gestión"
- "98% tasa de ocupación"
- "+25% rentabilidad con operación optimizada"

---

### 6.6 Slash Blog (Blog Section)
**Objetivo:** Posicionamiento SEO, value-add content

**Formato:** Grid de 3 posts destacados con imagen, extracto, fecha
**Ejemplos de Temas:**
- "5 errores comunes en la gestión de alícuotas"
- "Cómo automatizar cuotas sin perder control"
- "Guía: servicios básicos en arriendos"
- "Cobranza efectiva sin dejar clientes molestos"

**Strategy:** 1 post/semana inicialmente, dirigido a keyword research sobre gestión de propiedades

---

### 6.7 CTA Fuerte (Call-to-Action Section)
**Objetivo:** Convertir interés en acción

**Formato:** Sección full-width, contraste visual, 2 opciones
- **Primario:** "Solicitar Demo" (form o Calendly)
- **Secundario:** "Hablar con ventas" (chat o email)

**Copy:** "Empieza a gestionar propiedades como un profesional. Hablemos."

---

### 6.8 Footer
**Objetivo:** Navegación, links, contacto

**Contenido:**
- Links: Home, Blog, Contacto, Política de Privacidad
- Contacto: Email, teléfono, ubicación
- Social links: LinkedIn (profesional)
- Copyright

---

## 7. Características Técnicas

- **Stack:** WordPress + Theme Child `twentytwentyfive-child`
- **Reutilización:** Componentes del frontend actual (ocultos, no eliminados)
- **Mobile-First:** Responsive en mobile, tablet, desktop
- **Performance:** Optimizado para Core Web Vitals
- **Accesibilidad:** WCAG 2.1 AA

---

## 8. Entregables

1. ✅ DESIGN_BRIEF.md (este documento)
2. ⏳ INFORMATION_ARCHITECTURE.md (estructura y flujos)
3. ⏳ DESIGN_TOKENS.* (variables CSS refinadas)
4. ⏳ TASKS.md (checklist de construcción)
5. ⏳ Frontend construido (pages + componentes)
6. ⏳ DESIGN_REVIEW.md + screenshots (validación final)

---

## 9. Restricciones & Consideraciones

- **No eliminar componentes actuales**, solo ocultar
- **Mantener identidad visual existente** (colores, tipografía, espaciado)
- **Enfoque B2B**, no B2C
- **Landing page estática** (el CMS está en WordPress, pero no tiene funcionalidad de backend aquí)
- **Blog será manual inicialmente** (después puede automatizarse)

---

## 10. Métricas de Éxito

- [ ] Landing page posicionada para keywords de "gestión de propiedades"
- [ ] 50+ leads/mes desde el sitio
- [ ] Tasa de conversión demo/contacto: 15%+
- [ ] Blog con 10+ artículos en 3 meses
- [ ] Bounce rate < 45%
- [ ] Time on page > 2 min (engagement)

---

**Aprobación:** Dario Chuquilla  
**Estado:** ✅ Listo para Fase 3 (Arquitectura de Información)
