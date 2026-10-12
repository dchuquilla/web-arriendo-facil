<?php
/**
 * 404 Error Page - Arriendo Fácil
 */
if ( ! defined('ABSPATH') ) { exit; }
get_header();
?>

<main id="main-content" class="af-404-page">
  <div class="container">
    <div class="af-404-grid">
      <!-- Left: Message -->
      <div class="af-404-content">
        <h1 class="af-404-number">404</h1>
        <h2 class="af-404-title"><?php esc_html_e('Página no encontrada', 'twentytwentyfive-child'); ?></h2>
        <p class="af-404-desc"><?php esc_html_e('La página que buscas no existe o ha sido removida.', 'twentytwentyfive-child'); ?></p>
        
        <div class="af-404-actions">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
            <?php esc_html_e('← Volver al inicio', 'twentytwentyfive-child'); ?>
          </a>
          <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--secondary">
            <?php esc_html_e('Contactar soporte →', 'twentytwentyfive-child'); ?>
          </a>
        </div>
      </div>
      
      <!-- Right: Icon -->
      <div class="af-404-visual">
        <div class="af-404-icon">🏠</div>
      </div>
    </div>
  </div>
</main>

<style>
.af-404-page {
  min-height: 65vh;
  display: flex;
  align-items: center;
  padding: var(--space-8) 0;
  background: var(--color-bg-primary);
}

.af-404-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-10);
  align-items: center;
}

@media (max-width: 768px) {
  .af-404-grid {
    grid-template-columns: 1fr;
    gap: var(--space-6);
  }
}

.af-404-content {
  text-align: left;
}

.af-404-number {
  font-size: 5.5rem;
  font-weight: 900;
  line-height: 1;
  color: var(--color-primary);
  margin: 0 0 var(--space-2) 0;
  letter-spacing: -2px;
}

.af-404-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--color-text-primary);
  margin: 0 0 var(--space-3) 0;
  line-height: 1.2;
}

.af-404-desc {
  font-size: 1rem;
  color: var(--color-text-secondary);
  line-height: 1.6;
  margin: 0 0 var(--space-6) 0;
  max-width: 400px;
}

.af-404-actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3);
}

.af-404-actions .btn {
  padding: 10px 20px;
  font-size: 0.9rem;
  white-space: nowrap;
}

.af-404-visual {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 300px;
}

.af-404-icon {
  font-size: 6rem;
  line-height: 1;
  animation: float-404 3s ease-in-out infinite;
}

@keyframes float-404 {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-30px); }
}

@media (max-width: 768px) {
  .af-404-number {
    font-size: 3.5rem;
  }
  
  .af-404-title {
    font-size: 1.5rem;
  }
  
  .af-404-icon {
    font-size: 4rem;
  }
  
  .af-404-visual {
    min-height: 200px;
  }
}
</style>

<?php get_footer();
