<?php
/**
 * Performance Optimization for Arriendo Fácil
 * Targets: 0.5-1s load time, image/video optimization
 */

if ( ! defined('ABSPATH') ) { exit; }

/**
 * 1. LAZY LOADING FOR IMAGES
 * Add loading="lazy" to all img tags
 */
function af_add_lazy_loading($content) {
  if (!is_singular() && !is_home()) {
    return $content;
  }

  // Add lazy loading attribute to images without it
  $content = preg_replace(
    '/<img([^>]*?)(?<!loading=["\']lazy["\'])(\s*\/?)(>)/i',
    '<img$1 loading="lazy"$2$3',
    $content
  );

  return $content;
}
add_filter('the_content', 'af_add_lazy_loading', 20);

/**
 * 2. LAZY LOAD IFRAMES (YouTube, Vimeo, etc)
 */
function af_lazy_load_iframes($content) {
  if (!is_singular() && !is_home()) {
    return $content;
  }

  // Replace iframe src with data-src for lazy loading
  $content = preg_replace_callback(
    '/<iframe([^>]*?)src="([^"]*?)"([^>]*)><\/iframe>/i',
    function($matches) {
      $attrs = $matches[1];
      $src = $matches[2];
      $extra = $matches[3];
      
      // Add loading="lazy" and convert src to data-src
      return '<iframe' . $attrs . 'data-src="' . esc_attr($src) . '" src="about:blank" loading="lazy"' . $extra . '></iframe>';
    },
    $content
  );

  return $content;
}
add_filter('the_content', 'af_lazy_load_iframes', 21);

/**
 * 3. DEFER NON-CRITICAL CSS
 */
function af_defer_noncritical_css() {
  // No-op: Let HTTP headers handle via Cache-Control
  // This is configured in .htaccess
}

/**
 * 4. REMOVE QUERYSTRING FROM STATIC ASSETS
 * This helps with caching
 */
function af_remove_query_strings($src) {
  $output = preg_replace(
    '|\?ver=([0-9.]+)|',
    '',
    $src
  );
  return $output;
}
// Don't apply to jQuery or other critical libs
// add_filter('script_loader_src', 'af_remove_query_strings', 100);
// add_filter('style_loader_src', 'af_remove_query_strings', 100);

/**
 * 5. LAZY LOAD INLINE JAVASCRIPT EXECUTION
 * Delay JS that isn't critical until after page load
 */
function af_add_async_loading_script() {
  ?>
  <script>
  // Lazy load non-critical iframes after page load
  window.addEventListener('load', function() {
    var iframes = document.querySelectorAll('iframe[data-src]');
    iframes.forEach(function(iframe) {
      iframe.src = iframe.dataset.src;
      iframe.removeAttribute('data-src');
    });
  });

  // Intersection Observer for critical elements
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.loading = 'eager'; // Prefetch visible images
          observer.unobserve(entry.target);
        }
      });
    }, { rootMargin: '50px' });

    document.querySelectorAll('img[loading="lazy"]').forEach(function(img) {
      observer.observe(img);
    });
  }
  </script>
  <?php
}
add_action('wp_footer', 'af_add_async_loading_script', 100);

/**
 * 6. ENABLE GZIP COMPRESSION (via .htaccess already)
 */

/**
 * 7. SET CACHE HEADERS FOR STATIC ASSETS
 * Browser caching configured in .htaccess
 */
function af_cache_headers() {
  if (!is_admin()) {
    // Set cache headers for better performance
    header('Cache-Control: public, max-age=86400'); // 1 day default
    
    // For API calls, disable cache
    if (preg_match('#/wp-json/#', $_SERVER['REQUEST_URI'])) {
      header('Cache-Control: no-cache, no-store, must-revalidate');
    }
  }
}
// Don't hook on init - let .htaccess handle via mod_headers

/**
 * 8. MINIMIZE RENDER-BLOCKING RESOURCES
 */
function af_defer_non_critical_styles() {
  // CSS is already minified (style.min.css)
  // Scripts are enqueued with 'defer' in functions.php
}

/**
 * 9. IMAGE OPTIMIZATION VIA CDN PARAMS
 * Add Cloudflare Image Optimization params
 */
function af_optimize_image_urls($url) {
  // If using Cloudflare, add optimization params
  if (strpos($url, 'development.arriendofacil.net') !== false || 
      strpos($url, 'arriendofacil.net') !== false) {
    
    // Cloudflare Image Optimization format:
    // /cdn-cgi/image/width=400,quality=80/path-to-image.jpg
    // This is already handled by Cloudflare Zone Rules
  }
  
  return $url;
}

/**
 * 10. PRELOAD CRITICAL FONTS
 */
function af_preload_critical_resources() {
  // Fonts from Google Fonts should use font-display: swap
  // This is already in the font include
}

/**
 * 11. DISABLE UNNECESSARY WORDPRESS FEATURES FOR PERFORMANCE
 */
function af_performance_tweaks() {
  // Disable emoji support (small perf gain)
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');

  // Remove unnecessary XML-RPC
  add_filter('xmlrpc_enabled', '__return_false');
}
add_action('init', 'af_performance_tweaks');

/**
 * 12. OPTIMIZE WORDPRESS QUERY
 */
function af_optimize_database_queries() {
  if (!is_admin()) {
    // Limit query complexity
    add_filter('posts_per_page', function($posts_per_page) {
      return min($posts_per_page, 20); // Max 20 posts per page
    });
  }
}

/**
 * 13. VIDEO OPTIMIZATION
 * For hero video and other videos: use smaller file sizes, provide multiple formats
 */
function af_optimize_video_output($html, $url, $attr) {
  // Add preload="none" to videos to prevent auto-loading
  if (strpos($html, '<video') !== false) {
    $html = str_replace('<video', '<video preload="none" poster=""', $html);
  }
  
  return $html;
}
add_filter('wp_video_shortcode', 'af_optimize_video_output', 10, 3);

/**
 * 14. ADD PERFORMANCE MONITORING
 */
function af_add_performance_metrics() {
  if (!is_admin()) {
    ?>
    <script>
    // Track performance metrics
    window.addEventListener('load', function() {
      if (window.performance && window.performance.timing) {
        var perfData = window.performance.timing;
        var pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        
        // Send to analytics if needed
        console.log('Page Load Time: ' + pageLoadTime + 'ms');
        
        // Log to server for monitoring (optional)
        fetch('/wp-json/af/v1/performance', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            loadTime: pageLoadTime,
            url: window.location.pathname
          })
        }).catch(function() {
          // Silent fail - don't block page
        });
      }
    });
    </script>
    <?php
  }
}
// Uncomment to enable performance tracking
// add_action('wp_footer', 'af_add_performance_metrics', 999);
