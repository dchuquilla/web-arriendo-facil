# 🔧 Instrucciones de Mantenimiento CSS
## Arriendo Fácil | Guía para Futuras Actualizaciones

---

## 📍 Archivo Principal

**Ubicación:** `wordpress/wp-content/themes/twentytwentyfive-child/style.css`

**Tamaño:** ~131KB  
**Última actualización:** 2026-07-22  
**Responsable:** Tema child de Twenty Twenty-Five

---

## 🎯 Media Queries Principales

### Breakpoints Utilizados
```css
/* Móvil pequeño */
@media (max-width: 480px) { }

/* Móvil estándar */
@media (max-width: 600px) { }

/* Tablet */
@media (max-width: 900px) { }

/* Tablet grande */
@media (max-width: 1024px) { }

/* Desktop */
@media (min-width: 1400px) { }
```

---

## 📋 Componentes Críticos (Recientes)

### 1. Stats Grid (Líneas ~1729-1758)
**Responsable de:** Estadísticas en hero section  
**Cambios recientes:** Agregadas media queries 900px, 600px  
**Si necesita editar:**
- No reducir gap por debajo de `var(--space-2)` en móvil
- Mantener 1 columna en 600px o menos
- Mantener 2 columnas en 900px
- Mantener 3 columnas por defecto (desktop)

### 2. Hero Search Bar (Líneas ~1736-1758)
**Responsable de:** Input y botón de búsqueda  
**Cambios recientes:** Stack vertical en 480px, altura mínima 48px  
**Si necesita editar:**
- No reducir altura de input por debajo de 48px
- Altura del botón debe ser igual al input
- En mobile, usar `width: 100%`
- Mantener `flex-direction: column` en 480px

### 3. Featured Strip (Líneas ~2351-2378)
**Responsable de:** Cards de residencias  
**Cambios recientes:** Agregadas media queries para 1024px, 600px  
**Si necesita editar:**
- Tablet (1024px): 2 columnas
- Móvil (600px): 1 columna
- Reducir padding en móvil (`var(--space-4)`)

---

## ✅ Testing Checklist

Cuando hagas cambios en CSS, verifica:

### Móvil (375px)
- [ ] Stats legibles (sin overflow)
- [ ] Search bar accesible (48px altura)
- [ ] Botones tocables (mínimo 44px)
- [ ] Texto no cortado
- [ ] Sin scroll horizontal

### Tablet (768px)
- [ ] 2 columnas en featured items
- [ ] 2 columnas en stats
- [ ] Navegación funcional
- [ ] Imágenes centradas

### Desktop (1920px)
- [ ] 3-4 columnas en grids
- [ ] Espaciado generoso
- [ ] Contenedor max-width respetado
- [ ] Alineación perfecta

---

## 🛡️ Reglas de Oro

### ✅ HACER
- ✅ Usar `clamp()` para tipografía responsiva
- ✅ Usar variables CSS (`var(--space-X)`, `var(--font-size-X)`)
- ✅ Mobile-first (estilos base para móvil)
- ✅ Media queries en orden ascendente
- ✅ Testear en 3 resoluciones mínimo

### ❌ NO HACER
- ❌ Usar `!important` (solo si es absolutamente necesario)
- ❌ Fixed widths en elementos responsivos
- ❌ Hardcoded pixel values para espaciado
- ❌ Breakpoints arbitrarios
- ❌ Cambiar sin verificar en múltiples resoluciones

---

## 🔍 Debugging CSS

### Si algo se ve mal en móvil:
```css
/* Agregar esto temporalmente para ver límites */
* { outline: 1px solid red; }

/* Luego verifica:
   1. ¿Elementos overflow?
   2. ¿Padding suficiente?
   3. ¿Media query aplicada?
   4. ¿Especificidad CSS?
*/
```

### Herramientas útiles:
- Chrome DevTools (F12 → Toggle device toolbar)
- Responsive Design Checker online
- Real devices (iPhone, Android)

---

## 📐 Grid Layout Reference

### Stats Grid
```css
/* Desktop: 3 columnas */
grid-template-columns: repeat(3, 1fr);

/* Tablet (900px): 2 columnas */
grid-template-columns: repeat(2, 1fr);

/* Móvil (600px): 1 columna */
grid-template-columns: 1fr;
```

### Featured Strip
```css
/* Desktop: 3 columnas */
grid-template-columns: repeat(3, 1fr);

/* Tablet (1024px): 2 columnas */
grid-template-columns: repeat(2, 1fr);

/* Móvil (600px): 1 columna */
grid-template-columns: 1fr;
```

### Benefits Grid
```css
/* Desktop: 4 columnas */
grid-template-columns: repeat(4, 1fr);

/* Tablet (900px): 2 columnas */
grid-template-columns: repeat(2, 1fr);

/* Móvil (600px): 1 columna */
grid-template-columns: 1fr;
```

---

## 🚀 Deployment Checklist

Antes de hacer deploy a producción:

- [ ] Cambios testeados en 4 resoluciones
- [ ] Todos los flujos funcionan (búsqueda, contacto, navegación)
- [ ] Sin errores en consola del navegador
- [ ] Imágenes cargan correctamente
- [ ] Links funcionan
- [ ] Forms son accesibles
- [ ] CSS compilado/minificado (si aplica)
- [ ] Cache limpiado (si aplica)
- [ ] Cambios documentados

---

## 📞 Soporte

### Si necesitas ayuda:
1. Revisar `ANALISIS_UX_UI_RESPONSIVIDAD.md` - detalles del análisis
2. Revisar `RESUMEN_CORRECCIONES_UX_UI.md` - cambios específicos
3. Revisar `INFORME_FINAL_AUDIT_UX_UI.md` - informe ejecutivo
4. Comparar con `COMPARATIVA_VISUAL_ANTES_DESPUES.md` - antes vs después

---

## 📚 Variables CSS Clave

```css
/* Espaciado (escala 4px) */
--space-1: 4px;
--space-2: 8px;
--space-3: 12px;
--space-4: 16px;
--space-5: 20px;
--space-6: 24px;
--space-7: 28px;
--space-8: 32px;

/* Tipografía */
--font-size-xs: 12px;
--font-size-sm: 14px;
--font-size-base: 16px;
--font-size-lg: 18px;
--font-size-xl: 20px;
--font-size-2xl: 24px;

/* Colores (semánticos) */
--color-accent-primary: #7DBE52;
--color-text-primary: #1D2D44;
--color-text-secondary: #666666;
--color-bg-primary: #ffffff;
--color-bg-secondary: #F2F2F2;

/* Borders & Radii */
--border-radius-default: 8px;
--border-radius-md: 12px;
--border-radius-lg: 16px;
```

---

## 🎓 Tips Avanzados

### 1. Usar Flex para Layouts Lineales
```css
.hero-search-bar {
  display: flex;
  gap: var(--space-3);
  flex-direction: column; /* Stack en móvil */
}

@media (min-width: 900px) {
  .hero-search-bar {
    flex-direction: row; /* Lado a lado en desktop */
  }
}
```

### 2. Usar Grid para Layouts 2D
```css
.benefits-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: var(--space-6);
}
```

### 3. Usar `clamp()` para Tipografía Fluida
```css
.h2 {
  font-size: clamp(28px, 3.2vw, 44px);
  /* Mín: 28px | Ideal: 3.2% del viewport | Máx: 44px */
}
```

---

## 📅 Historial de Cambios

### 2026-07-22 - Auditoría UX/UI
- ✅ Agregado media query para stats-grid en 900px (2 cols)
- ✅ Agregado media query para stats-grid en 600px (1 col)
- ✅ Mejorado hero-search-bar en 480px (stack vertical)
- ✅ Mejorado featured-strip en 1024px (2 cols)
- ✅ Documentadas todas las correcciones

### Anteriores
- Ver `git log` o commits previos

---

**Última revisión:** 2026-07-22  
**Próxima revisión sugerida:** 2026-10-22 (3 meses)

