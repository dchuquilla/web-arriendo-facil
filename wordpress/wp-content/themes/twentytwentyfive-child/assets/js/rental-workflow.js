/**
 * rental-workflow.js
 *
 * Handles availability status on single accommodation pages.
 * Booking/queue actions are handled in chatbot, not in-page forms.
 */
(function () {
  'use strict';

  // ── Bootstrap guard ──────────────────────────────────────────────────────
  if ( ! window.afWorkflow || ! window.afWorkflow.accommodationId ) {
    return;
  }

  var cfg             = window.afWorkflow;
  var ajaxUrl         = cfg.ajaxUrl;
  var accommodationId = parseInt( cfg.accommodationId, 10 );
  var nonce           = cfg.nonce;

  // ── DOM refs ─────────────────────────────────────────────────────────────
  var badgeEl        = document.getElementById( 'af-booking-status-badge' );
  var loadingEl      = document.getElementById( 'af-booking-loading' );
  var slotsSection   = document.getElementById( 'af-booking-slots-section' );
  var slotsList      = document.getElementById( 'af-booking-slots-list' );
  var queueSection   = document.getElementById( 'af-booking-queue-section' );
  var errorEl        = document.getElementById( 'af-booking-error' );

  var visitForm      = document.getElementById( 'af-visit-form' );
  var visitSlotId    = document.getElementById( 'af-visit-slot-id' );
  var visitSlotLabel = document.getElementById( 'af-visit-slot-label' );
  var visitName      = document.getElementById( 'af-visit-name' );
  var visitEmail     = document.getElementById( 'af-visit-email' );
  var visitPhone     = document.getElementById( 'af-visit-phone' );
  var visitNotes     = document.getElementById( 'af-visit-notes' );
  var visitFeedback  = document.getElementById( 'af-visit-feedback' );
  var visitSubmit    = document.getElementById( 'af-visit-submit' );
  var visitCancel    = document.getElementById( 'af-visit-cancel' );

  var queueForm      = document.getElementById( 'af-queue-form' );
  var queueName      = document.getElementById( 'af-queue-name' );
  var queueEmail     = document.getElementById( 'af-queue-email' );
  var queuePhone     = document.getElementById( 'af-queue-phone' );
  var queueMessage   = document.getElementById( 'af-queue-message' );
  var queueFeedback  = document.getElementById( 'af-queue-feedback' );
  var queueSubmit    = document.getElementById( 'af-queue-submit' );

  if ( ! badgeEl ) {
    return;
  }

  // ── Helpers ───────────────────────────────────────────────────────────────
  function show( el ) {
    if ( el ) { el.removeAttribute( 'hidden' ); }
  }
  function hide( el ) {
    if ( el ) { el.setAttribute( 'hidden', 'hidden' ); }
  }
  function setFeedback( el, msg, isError ) {
    if ( ! el ) { return; }
    el.textContent = msg;
    el.className = 'af-booking-feedback' + ( isError ? ' af-booking-feedback--error' : ' af-booking-feedback--success' );
    show( el );
  }
  function clearFeedback( el ) {
    if ( ! el ) { return; }
    el.textContent = '';
    hide( el );
  }
  function setBadge( stateCode, message ) {
    if ( ! badgeEl ) { return; }
    var map = {
      available: 'af-booking-badge--available',
      reserved:  'af-booking-badge--reserved',
      rented:    'af-booking-badge--rented',
      private:   'af-booking-badge--private',
      unavailable: 'af-booking-badge--private',
    };
    badgeEl.className = 'af-booking-badge ' + ( map[ stateCode ] || 'af-booking-badge--private' );
    badgeEl.textContent = message || stateCode;
  }
  function showChatbotOnlyHint(availabilityData) {
    if (!errorEl) { return; }

    var canStart = availabilityData && availabilityData.can_start_flow;
    var reason = availabilityData && availabilityData.message ? availabilityData.message : '';
    var baseText = canStart
      ? 'Puedes reservar tu visita en un paso rápido. Completa tus datos y te confirmaremos por correo.'
      : 'Esta propiedad tiene disponibilidad limitada. Puedes registrar tu intención de visita.';

    errorEl.className = 'af-booking-section';
    errorEl.innerHTML = '<p style="margin:0 0 .5rem;">' + escHtml(reason || baseText) + '</p>' +
      '<button type="button" class="btn btn--primary btn--full" data-af-reserve-trigger data-af-accommodation-id="' + escHtml(String(accommodationId)) + '" data-af-accommodation-title="' + escHtml(document.title || '') + '">Reservar</button>';
    show(errorEl);
  }
  function post( data ) {
    var body = new FormData();
    Object.keys( data ).forEach( function ( k ) { body.append( k, data[ k ] ); } );
    return fetch( ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body } )
      .then( function ( r ) { return r.json(); } );
  }
  function disableBtn( btn, label ) {
    if ( btn ) { btn.disabled = true; btn.textContent = label || '…'; }
  }
  function enableBtn( btn, label ) {
    if ( btn ) { btn.disabled = false; btn.textContent = label; }
  }
  function formatDatetime( dateStr, startTime ) {
    if ( ! dateStr ) { return dateStr; }
    try {
      var d = new Date( dateStr + 'T' + ( startTime || '00:00' ) );
      return d.toLocaleString( 'es-EC', {
        weekday: 'long', year: 'numeric', month: 'long',
        day: 'numeric', hour: '2-digit', minute: '2-digit'
      } );
    } catch (e) {
      return dateStr + ( startTime ? ' ' + startTime : '' );
    }
  }

  // ── Slot card ─────────────────────────────────────────────────────────────
  function renderSlots( slots ) {
    if ( ! slotsList ) { return; }
    slotsList.innerHTML = '';

    if ( ! slots || slots.length === 0 ) {
      slotsList.innerHTML = '<p class="af-no-slots">' + ( cfg.i18n.noSlots || 'No hay horarios disponibles por ahora.' ) + '</p>';
      return slots;
    }

    slots.forEach( function ( slot ) {
      var btn = document.createElement( 'button' );
      btn.type = 'button';
      btn.className = 'af-slot-btn';
      btn.setAttribute( 'role', 'listitem' );
      btn.setAttribute( 'data-slot-id', slot.id );
      btn.innerHTML =
        '<span class="af-slot-date">' + escHtml( formatDatetime( slot.visit_date, slot.start_time ) ) + '</span>' +
        '<span class="af-slot-time">' + escHtml( slot.start_time || '' ) + ' – ' + escHtml( slot.end_time || '' ) + '</span>' +
        '<span class="af-slot-spots">' + ( cfg.i18n.spotsLeft || 'Cupos disponibles' ) + '</span>';
      btn.addEventListener( 'click', function () {
        openVisitForm( slot );
      } );
      slotsList.appendChild( btn );
    } );

    return slots;
  }

  function escHtml( s ) {
    return String( s || '' )
      .replace( /&/g, '&amp;' )
      .replace( /</g, '&lt;' )
      .replace( />/g, '&gt;' )
      .replace( /"/g, '&quot;' );
  }

  function openVisitForm( slot ) {
    if ( visitSlotId ) { visitSlotId.value = slot.id; }
    if ( visitSlotLabel ) {
      visitSlotLabel.textContent = formatDatetime( slot.visit_date, slot.start_time );
    }
    hide( slotsList );
    show( visitForm );
    if ( visitName ) { visitName.focus(); }
  }

  // ── 1. Check availability ─────────────────────────────────────────────────
  function checkAvailability() {
    show( loadingEl );
    hide( slotsSection );
    hide( queueSection );
    hide( errorEl );

    return post( {
      action: 'af_get_accommodation_availability',
      accommodation_id: accommodationId,
      nonce: nonce,
    } )
      .then( function ( res ) {
        hide( loadingEl );

        if ( ! res || ! res.success ) {
          var msg = res && res.data && res.data.message ? res.data.message : ( cfg.i18n.errorGeneric || 'No se pudo verificar disponibilidad.' );
          if ( errorEl ) {
            errorEl.textContent = msg;
            show( errorEl );
          }
          return null;
        }

        var d = res.data;
        setBadge( d.state || d.status, d.message );

        // Frontend decision: this page only shows status and sends user to chatbot.
        hide( slotsSection );
        hide( queueSection );
        showChatbotOnlyHint(d);
        return null;
      } )
      .catch( function () {
        hide( loadingEl );
        if ( errorEl ) {
          errorEl.textContent = cfg.i18n.errorNetwork || 'Error de conexión. Intenta recargar la página.';
          show( errorEl );
        }
      } );
  }

  // ── 2. Load slots (legacy, kept for compatibility) ──────────────────────
  function loadSlots() {
    show( loadingEl );
    return post( {
      action: 'af_get_visit_slots',
      accommodation_id: accommodationId,
      nonce: nonce,
    } )
      .then( function ( res ) {
        hide( loadingEl );
        var slots = ( res && res.success && res.data && res.data.slots ) ? res.data.slots : [];
        renderSlots( slots );

        if ( slots.length > 0 ) {
          show( slotsSection );
        } else {
          showQueueSection( 'no_slots' );
        }
      } )
      .catch( function () {
        hide( loadingEl );
        showQueueSection( 'error' );
      } );
  }

  // ── 3. Show queue section (legacy, kept for compatibility) ──────────────
  function showQueueSection( reasonCode ) {
    if ( queueSection ) {
      var hint = queueSection.querySelector( '.af-booking-hint' );
      if ( hint ) {
        var messages = {
          rented:       cfg.i18n.queueRented    || 'Esta propiedad está actualmente rentada. Te avisamos cuando esté disponible.',
          reserved:     cfg.i18n.queueReserved  || 'Esta propiedad tiene una reserva activa. Ingresa a la lista de espera.',
          private:      cfg.i18n.queuePrivate   || 'Esta propiedad no está disponible públicamente en este momento.',
          unavailable:  cfg.i18n.queueUnavailable || 'Propiedad no disponible. Únete a la lista de espera.',
          no_slots:     cfg.i18n.queueNoSlots   || 'No hay horarios de visita disponibles ahora. Regístrate y te contactaremos.',
        };
        hint.textContent = messages[ reasonCode ] || hint.textContent;
      }
      show( queueSection );
    }
  }

  // ── 4. Book a visit slot (legacy, kept for compatibility) ───────────────
  if ( visitForm ) {
    visitForm.addEventListener( 'submit', function ( e ) {
      e.preventDefault();
      clearFeedback( visitFeedback );

      var slotId = visitSlotId && visitSlotId.value ? parseInt( visitSlotId.value, 10 ) : 0;
      var name   = visitName  && visitName.value.trim();
      var email  = visitEmail && visitEmail.value.trim();

      if ( ! slotId || ! name || ! email ) {
        setFeedback( visitFeedback, cfg.i18n.fillRequired || 'Completa los campos obligatorios.', true );
        return;
      }

      disableBtn( visitSubmit, cfg.i18n.sending || 'Enviando…' );

      post( {
        action:      'af_book_visit_slot',
        slot_id:     slotId,
        guest_name:  name,
        guest_email: email,
        guest_phone: visitPhone ? visitPhone.value.trim() : '',
        notes:       visitNotes ? visitNotes.value.trim() : '',
        nonce:       nonce,
      } )
        .then( function ( res ) {
          enableBtn( visitSubmit, cfg.i18n.confirmVisit || 'Confirmar visita' );
          if ( res && res.success ) {
            setFeedback( visitFeedback, ( res.data && res.data.message ) || cfg.i18n.visitBooked || '¡Visita agendada! Te enviaremos un correo de confirmación.', false );
            visitForm.reset();
            // Re-load slots to reflect updated availability.
            window.setTimeout( loadSlots, 1500 );
          } else {
            var httpCode = res && res.data && res.data.code ? res.data.code : 0;
            var msg = ( res && res.data && res.data.message )
              ? res.data.message
              : ( httpCode === 409 ? ( cfg.i18n.slotConflict || 'Este horario ya fue reservado. Elige otro.' ) : ( cfg.i18n.errorGeneric || 'No se pudo reservar la visita.' ) );
            setFeedback( visitFeedback, msg, true );
          }
        } )
        .catch( function () {
          enableBtn( visitSubmit, cfg.i18n.confirmVisit || 'Confirmar visita' );
          setFeedback( visitFeedback, cfg.i18n.errorNetwork || 'Error de conexión. Intenta de nuevo.', true );
        } );
    } );
  }

  if ( visitCancel ) {
    visitCancel.addEventListener( 'click', function () {
      hide( visitForm );
      show( slotsList );
      clearFeedback( visitFeedback );
    } );
  }

  // ── 5. Join interest queue (legacy, kept for compatibility) ─────────────
  if ( queueForm ) {
    queueForm.addEventListener( 'submit', function ( e ) {
      e.preventDefault();
      clearFeedback( queueFeedback );

      var name  = queueName  && queueName.value.trim();
      var email = queueEmail && queueEmail.value.trim();

      if ( ! name || ! email ) {
        setFeedback( queueFeedback, cfg.i18n.fillRequired || 'Completa los campos obligatorios.', true );
        return;
      }

      disableBtn( queueSubmit, cfg.i18n.sending || 'Enviando…' );

      post( {
        action:          'af_join_interest_queue',
        accommodation_id: accommodationId,
        name:            name,
        email:           email,
        phone:           queuePhone ? queuePhone.value.trim() : '',
        message:         queueMessage ? queueMessage.value.trim() : '',
        nonce:           nonce,
      } )
        .then( function ( res ) {
          enableBtn( queueSubmit, cfg.i18n.joinQueue || 'Unirme a lista de espera' );
          if ( res && res.success ) {
            setFeedback( queueFeedback, ( res.data && res.data.message ) || cfg.i18n.queueJoined || '¡Listo! Te avisaremos cuando esta propiedad esté disponible.', false );
            queueForm.reset();
          } else {
            var msg = ( res && res.data && res.data.message ) || cfg.i18n.errorGeneric || 'No se pudo registrar tu interés. Intenta nuevamente.';
            setFeedback( queueFeedback, msg, true );
          }
        } )
        .catch( function () {
          enableBtn( queueSubmit, cfg.i18n.joinQueue || 'Unirme a lista de espera' );
          setFeedback( queueFeedback, cfg.i18n.errorNetwork || 'Error de conexión. Intenta de nuevo.', true );
        } );
    } );
  }

  // ── Boot ───────────────────────────────────────────────────────────────────
  checkAvailability();

} )();
