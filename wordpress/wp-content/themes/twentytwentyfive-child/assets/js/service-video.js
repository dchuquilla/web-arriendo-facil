/**
 * Video de la página de detalle de servicio.
 *
 * Usa la IFrame API de YouTube para mostrar un overlay propio cuando el video
 * termina, de modo que nunca se vean las sugerencias de YouTube.
 *
 * El gestor de cookies (Complianz) puede reemplazar/desactivar el iframe después
 * de cargar la página: por eso el reproductor sólo se crea cuando el iframe ya
 * apunta a YouTube, y se vuelve a crear si se reactiva más tarde.
 */
(function () {
  'use strict';

  var API_SRC = 'https://www.youtube.com/iframe_api';
  window.afServicePlayers = window.afServicePlayers || {};

  function isPlayable(el) {
    var src = (el.getAttribute('src') || '').toLowerCase();
    return src.indexOf('youtube-nocookie.com/embed/') !== -1 || src.indexOf('youtube.com/embed/') !== -1;
  }

  function currentFrame(box) {
    var frames = box.querySelectorAll('iframe');
    for (var i = 0; i < frames.length; i++) {
      if (frames[i].getAttribute('data-video-id')) {
        return frames[i];
      }
    }
    return null;
  }

  function createPlayer(box) {
    var el = currentFrame(box);

    if (!el || !isPlayable(el)) {
      return; // el iframe sigue bloqueado por el gestor de cookies
    }
    if (el.getAttribute('data-af-ready') === '1') {
      return;
    }
    if (!window.YT || !window.YT.Player) {
      return; // la API aún no está cargada (se reintenta al cargarla)
    }
    el.setAttribute('data-af-ready', '1');

    var overlay = box.querySelector('.af-video__ended');
    var replay = overlay ? overlay.querySelector('[data-af-replay]') : null;
    var key = box.getAttribute('data-video-key') || el.getAttribute('data-video-id');

    var player;
    try {
      player = new window.YT.Player(el, {
        videoId: el.getAttribute('data-video-id'),
        host: 'https://www.youtube-nocookie.com',
        playerVars: {
          rel: 0,
          modestbranding: 1,
          iv_load_policy: 3,
          playsinline: 1
        },
        events: {
          onStateChange: function (event) {
            if (!overlay) {
              return;
            }
            // ENDED → nuestro overlay tapa las sugerencias de YouTube.
            overlay.hidden = event.data !== window.YT.PlayerState.ENDED;
          }
        }
      });
    } catch (error) {
      el.removeAttribute('data-af-ready');
      return;
    }

    window.afServicePlayers[key] = player;

    if (replay) {
      replay.addEventListener('click', function () {
        overlay.hidden = true;
        player.seekTo(0, true);
        player.playVideo();
      });
    }

  }

  function watch(box) {
    if (box.getAttribute('data-af-watch') === '1') {
      return;
    }
    box.setAttribute('data-af-watch', '1');

    createPlayer(box);

    if (!window.MutationObserver) {
      return;
    }

    var observer = new MutationObserver(function () {
      createPlayer(box);
    });
    observer.observe(box, {
      childList: true,
      subtree: true,
      attributes: true,
      attributeFilter: ['src', 'class']
    });
  }

  function scan() {
    var boxes = document.querySelectorAll('.af-video[data-video-key]');
    for (var i = 0; i < boxes.length; i++) {
      watch(boxes[i]);
      createPlayer(boxes[i]); // por si la API se cargó después del observer
    }
  }

  function loadApi() {
    scan(); // intenta ya (si no hay gestor de cookies, basta esto)

    if (window.YT && window.YT.Player) {
      scan();
      return;
    }

    var script = document.createElement('script');
    script.src = API_SRC;
    script.async = true;
    document.head.appendChild(script);

    var tries = 0;
    var timer = window.setInterval(function () {
      tries += 1;
      if (window.YT && window.YT.Player) {
        window.clearInterval(timer);
        scan();
      } else if (tries > 100) {
        // Sin API queda el iframe normal (con rel=0: sólo sugerencias del canal).
        window.clearInterval(timer);
      }
    }, 100);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadApi);
  } else {
    loadApi();
  }
})();
