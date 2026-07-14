/**
 * Search Results Interactive - Accommodation Map and List Synchronization
 */

(function() {
	'use strict';

	const SearchResults = {
		defaultCenter: { lat: -0.1807, lng: -78.4678 }, // Quito fallback
		map: null,
		markerLayer: null,
		backgroundMarkerLayer: null,
		allAccommodationMarkers: {},
		accommodationMarkers: {},
		poiMarkers: {},
		currentLocation: null,
		currentFilters: {
			location: '',
			latitude: null,
			longitude: null,
			radius_km: 10,
			price_min: 0,
			price_max: 999999,
			bedrooms: 0,
			bathrooms: 0,
			property_type: '',
			amenities: [],
			sort: 'relevance',
		},
		poiSettings: {
			transport: true,
			parks: true,
			shops: true,
			health: true,
			radius: 2,
		},
		resultsAbortController: null,
		resultsDebounceId: null,
		resultsCache: new Map(),
		resultsCacheTtlMs: 45000,
		resultsFetchTimeoutMs: 12000,
		mapAlertTimeoutId: null,

		async init() {
			this.cacheElements();
			this.initMap();
			this.bindEvents();
			this.loadInitialLocation();
			await this.setInitialMapCenter();
			// Kick off both in parallel: search results render immediately,
			// background markers load during idle time to avoid blocking the UI.
			this.loadResults();
			this.scheduleBackgroundMarkers();
		},

		loadInitialLocation() {
			const params = new URLSearchParams(window.location.search);
			this.currentFilters.location = params.get('location') || '';
			const lat = params.get('latitude');
			const lng = params.get('longitude');
			if (lat && lng) {
				const parsedLat = parseFloat(lat);
				const parsedLng = parseFloat(lng);
				if (Number.isFinite(parsedLat) && Number.isFinite(parsedLng)) {
					this.currentFilters.latitude = parsedLat;
					this.currentFilters.longitude = parsedLng;
				}
			}

			// Fallback to sessionStorage from search-bar
			if (!this.currentFilters.latitude || !this.currentFilters.longitude) {
				const stored = sessionStorage.getItem('searchLocation');
				if (stored && Date.now() - JSON.parse(stored).timestamp < 600000) {
					const data = JSON.parse(stored);
					this.currentFilters.latitude = data.latitude;
					this.currentFilters.longitude = data.longitude;
					if (!this.currentFilters.location) {
						this.currentFilters.location = data.location;
					}
				}
			}
		},

		cacheElements() {
			this.elements = {
				map: document.getElementById('map'),
				mapAlert: document.getElementById('map-alert'),
				resultsList: document.getElementById('results-list'),
				resultsCount: document.getElementById('results-count-text'),
				priceMinInput: document.getElementById('filter-price-min'),
				priceMaxInput: document.getElementById('filter-price-max'),
				propertyTypeSelect: document.getElementById('filter-property-type'),
				amenityCheckboxes: document.querySelectorAll('.filter-amenity'),
				poiCheckboxes: document.querySelectorAll('.filter-poi'),
				radiusSlider: document.getElementById('poi-radius-slider'),
				clearFiltersBtn: document.getElementById('clear-filters'),
			};
		},

		initMap() {
			if (!this.elements.map) {
				console.error('Map container not found');
				return;
			}

			this.map = L.map('map').setView([this.defaultCenter.lat, this.defaultCenter.lng], 12);

			L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
				attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors © <a href="https://carto.com/attributions">CARTO</a>',
				subdomains: 'abcd',
				maxZoom: 19,
			}).addTo(this.map);

			// Background layer: all accommodations, always visible (added first = below search results)
			this.backgroundMarkerLayer = L.layerGroup();
			this.map.addLayer(this.backgroundMarkerLayer);

			if (typeof L.markerClusterGroup === 'function') {
				this.markerLayer = L.markerClusterGroup({
					showCoverageOnHover: false,
					spiderfyOnMaxZoom: true,
					maxClusterRadius: 55,
				});
			} else {
				this.markerLayer = L.layerGroup();
			}

			this.map.addLayer(this.markerLayer);

			// On mobile the CSS grid layout may not be fully resolved when Leaflet
			// initialises, causing it to record a 0-size container and placing all
			// markers outside the visible viewport.  A single rAF lets the browser
			// finish painting the layout before we correct the map dimensions.
			requestAnimationFrame(() => {
				this.map.invalidateSize();
			});

			// Keep the map correctly sized whenever the container changes
			// (device rotation, mobile browser chrome hiding/showing, etc.).
			if (typeof ResizeObserver !== 'undefined') {
				const ro = new ResizeObserver(() => {
					this.map.invalidateSize();
				});
				ro.observe(this.elements.map);
			} else {
				// Fallback for older browsers that lack ResizeObserver.
				window.addEventListener('orientationchange', () => {
					setTimeout(() => this.map.invalidateSize(), 200);
				});
				window.addEventListener('resize', () => {
					this.map.invalidateSize();
				});
			}
		},

		async setInitialMapCenter() {
			if (!this.map) {
				return;
			}

			const searchLocation = this.getSearchLocation();
			const hasUrlCoordinates = Number.isFinite(this.currentFilters.latitude) && Number.isFinite(this.currentFilters.longitude);
			const urlLocation = hasUrlCoordinates
				? { lat: this.currentFilters.latitude, lng: this.currentFilters.longitude }
				: null;

			let userLocation = null;
			if (!urlLocation) {
				userLocation = await this.getUserLocation();
			}

			if (searchLocation && searchLocation.toLowerCase() !== 'my location') {
				const biasLocation = urlLocation || userLocation;
				const geocoded = await this.geocodeLocation(searchLocation, biasLocation);
				if (geocoded) {
					this.currentFilters.latitude = geocoded.lat;
					this.currentFilters.longitude = geocoded.lng;
					this.map.setView([geocoded.lat, geocoded.lng], 15);
					this.currentLocation = geocoded;
					return;
				}
			}

			if (urlLocation) {
				this.map.setView([this.currentFilters.latitude, this.currentFilters.longitude], 15);
				this.currentLocation = {
					lat: this.currentFilters.latitude,
					lng: this.currentFilters.longitude,
				};
				return;
			}

			if (userLocation) {
				this.map.setView([userLocation.lat, userLocation.lng], 14);
				this.currentLocation = userLocation;
				return;
			}

			this.map.setView([this.defaultCenter.lat, this.defaultCenter.lng], 12);
		},

		async geocodeLocation(locationText, userLocation = null) {
			try {
				const attempts = [];

				if (userLocation && Number.isFinite(userLocation.lat) && Number.isFinite(userLocation.lng)) {
					const latDelta = 1.2;
					const lngDelta = 1.2;
					const left = userLocation.lng - lngDelta;
					const right = userLocation.lng + lngDelta;
					const top = userLocation.lat + latDelta;
					const bottom = userLocation.lat - latDelta;
					attempts.push(
						`https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&bounded=1&viewbox=${left},${top},${right},${bottom}&q=${encodeURIComponent(locationText)}`
					);
				}

				attempts.push(
					`https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&countrycodes=ec&q=${encodeURIComponent(locationText)}`,
					`https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&countrycodes=ec&q=${encodeURIComponent(`${locationText}, Ecuador`)}`,
					`https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&q=${encodeURIComponent(locationText)}`
				);

				for (const url of attempts) {
					const response = await fetch(url, {
						headers: { Accept: 'application/json' },
					});

					if (!response.ok) {
						continue;
					}

					const data = await response.json();
					if (!Array.isArray(data) || data.length === 0) {
						continue;
					}

					const lat = parseFloat(data[0].lat);
					const lng = parseFloat(data[0].lon);
					if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
						continue;
					}

					return { lat, lng };
				}

				return null;
			} catch (error) {
				console.warn('Location geocoding failed:', error);
				return null;
			}
		},

		getUserLocation() {
			return new Promise(resolve => {
				if (!navigator.geolocation) {
					resolve(null);
					return;
				}

				navigator.geolocation.getCurrentPosition(
					position => {
						resolve({
							lat: position.coords.latitude,
							lng: position.coords.longitude,
						});
					},
					() => resolve(null),
					{ enableHighAccuracy: false, timeout: 4000, maximumAge: 600000 }
				);
			});
		},

		bindEvents() {
			this.elements.priceMinInput.addEventListener('change', () => this.onFilterChange());
			this.elements.priceMaxInput.addEventListener('change', () => this.onFilterChange());
			this.elements.propertyTypeSelect.addEventListener('change', () => this.onFilterChange());
			this.elements.amenityCheckboxes.forEach(cb => cb.addEventListener('change', () => this.onFilterChange()));
			this.elements.poiCheckboxes.forEach(cb => cb.addEventListener('change', () => this.onPoiFilterChange()));
			this.elements.radiusSlider.addEventListener('input', () => this.onPoiRadiusChange());
			this.elements.clearFiltersBtn.addEventListener('click', () => this.clearFilters());
		},

		onFilterChange() {
			this.updateFilters();
			this.scheduleResultsLoad();
		},

		onPoiFilterChange() {
			this.updatePoiSettings();
			this.clearPoiMarkers();
			this.loadPoiMarkers();
		},

		onPoiRadiusChange() {
			const radius = parseInt(this.elements.radiusSlider.value, 10);
			this.poiSettings.radius = radius;
			document.querySelector('.radius-value').textContent = `${radius} km`;
			this.clearPoiMarkers();
			this.loadPoiMarkers();
		},

		updateFilters() {
			this.currentFilters.price_min = parseFloat(this.elements.priceMinInput.value) || 0;
			this.currentFilters.price_max = parseFloat(this.elements.priceMaxInput.value) || 999999;
			this.currentFilters.property_type = this.elements.propertyTypeSelect.value;
			this.currentFilters.amenities = Array.from(this.elements.amenityCheckboxes)
				.filter(cb => cb.checked)
				.map(cb => cb.value);
		},

		updatePoiSettings() {
			this.poiSettings.transport = document.querySelector('.filter-poi[value="transport"]').checked;
			this.poiSettings.parks = document.querySelector('.filter-poi[value="parks"]').checked;
			this.poiSettings.shops = document.querySelector('.filter-poi[value="shops"]').checked;
			this.poiSettings.health = document.querySelector('.filter-poi[value="health"]').checked;
		},

		clearFilters() {
			this.elements.priceMinInput.value = '';
			this.elements.priceMaxInput.value = '';
			this.elements.propertyTypeSelect.value = '';
			this.elements.amenityCheckboxes.forEach(cb => cb.checked = false);
			this.updateFilters();
			this.scheduleResultsLoad();
		},

		scheduleResultsLoad(delay = 160) {
			if (this.resultsDebounceId) {
				window.clearTimeout(this.resultsDebounceId);
			}

			this.resultsDebounceId = window.setTimeout(() => {
				this.resultsDebounceId = null;
				this.loadResults();
			}, delay);
		},

		buildResultsCacheKey(params) {
			return JSON.stringify({
				location: params.location || '',
				latitude: Number.isFinite(params.latitude) ? Number(params.latitude).toFixed(5) : null,
				longitude: Number.isFinite(params.longitude) ? Number(params.longitude).toFixed(5) : null,
				radius_km: params.radius_km,
				price_min: params.price_min,
				price_max: params.price_max,
				bedrooms: params.bedrooms,
				bathrooms: params.bathrooms,
				property_type: params.property_type || '',
				amenities: Array.isArray(params.amenities) ? params.amenities.slice().sort() : [],
				sort: params.sort || 'relevance',
			});
		},

		getCachedResults(cacheKey) {
			const cached = this.resultsCache.get(cacheKey);
			if (!cached) {
				return null;
			}

			if ((Date.now() - cached.ts) > this.resultsCacheTtlMs) {
				this.resultsCache.delete(cacheKey);
				return null;
			}

			return cached.data;
		},

		setCachedResults(cacheKey, data) {
			if (!data || typeof data !== 'object') {
				return;
			}

			if (this.resultsCache.size > 24) {
				const firstKey = this.resultsCache.keys().next().value;
				if (firstKey) {
					this.resultsCache.delete(firstKey);
				}
			}

			this.resultsCache.set(cacheKey, {
				ts: Date.now(),
				data,
			});
		},

		loadResults() {
			const params = {
				...this.currentFilters,
				location: this.getSearchLocation(),
			};

			if (!Number.isFinite(params.latitude)) {
				delete params.latitude;
			}
			if (!Number.isFinite(params.longitude)) {
				delete params.longitude;
			}

			const cacheKey = this.buildResultsCacheKey(params);
			const cached = this.getCachedResults(cacheKey);
			if (cached) {
				this.renderResults(cached);
				return;
			}

			if (this.resultsAbortController) {
				this.resultsAbortController.abort();
			}

			this.resultsAbortController = new AbortController();
			const controller = this.resultsAbortController;
			const timeoutId = window.setTimeout(() => {
				controller.abort();
			}, this.resultsFetchTimeoutMs);

			fetch(`${window.location.origin}/wp-json/af/v1/accommodations/search`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(params),
				signal: controller.signal,
			})
				.then(response => response.json())
				.then(data => {
					this.setCachedResults(cacheKey, data);
					this.renderResults(data);
				})
				.catch(error => {
					if (error && error.name === 'AbortError') {
						return;
					}
					console.error('Error loading results:', error);
					this.showMapAlert('La búsqueda tardó demasiado. Intenta de nuevo.', 4000);
					if (this.elements.resultsCount) {
						this.elements.resultsCount.textContent = 'No se pudieron cargar los resultados.';
					}
				})
				.finally(() => {
					window.clearTimeout(timeoutId);
					if (this.resultsAbortController === controller) {
						this.resultsAbortController = null;
					}
				});
		},

		getSearchLocation() {
			const params = new URLSearchParams(window.location.search);
			return params.get('location') || '';
		},

		async renderResults(data) {
			if (!data.success) {
				this.showMapAlert('No se pudieron cargar resultados en este momento.');
				this.elements.resultsList.innerHTML = '<p>Error loading results</p>';
				return;
			}

			this.updateResultsCount(data.count, data.total);
			this.clearPoiMarkers();
			const markerCount = this.updateMapMarkers(data.results);

			if (markerCount > 0) {
				this.hideMapAlert();
			}

			if (data.results.length > 0 && markerCount > 0) {
				this.renderResultsList(data.results);
				this.fitMapBounds(data.results);
				this.loadPoiMarkers();
				return;
			}

			if (data.results.length > 0 && markerCount === 0) {
				this.renderResultsList(data.results);
				this.showMapAlert('No hay coordenadas para mostrar estas acomodaciones en el mapa.');
				return;
			}

			this.showMapAlert('No existen acomodaciones para esa búsqueda. Arrastra el mapa para explorar otras opciones.', 6500);
			const fallbackResults = await this.fetchAllAccommodations();
			this.renderResultsList(data.results, fallbackResults);

			if (Number.isFinite(this.currentFilters.latitude) && Number.isFinite(this.currentFilters.longitude)) {
				this.map.setView([this.currentFilters.latitude, this.currentFilters.longitude], 13);
			}
		},

		updateResultsCount(count, total) {
			this.elements.resultsCount.textContent =
				count === 0
					? 'No se encontraron resultados'
					: `Mostrando ${count} de ${total} inmuebles`;
		},

		renderResultsList(accommodations, fallbackAccommodations = []) {
			if (accommodations.length === 0) {
				if (fallbackAccommodations.length === 0) {
					this.elements.resultsList.innerHTML = '<p>No accommodations match your filters</p>';
					return;
				}

				const fallbackHtml = fallbackAccommodations.map(acc => this.buildAccommodationCardHtml(acc)).join('');
				this.elements.resultsList.innerHTML = `
					<p>No accommodations match your filters.</p>
					<p class="fallback-results-title">Mas opciones disponibles</p>
					${fallbackHtml}
				`;
				this.bindAccommodationCardClicks();
				return;
			}

			const html = accommodations.map(acc => this.buildAccommodationCardHtml(acc)).join('');

			this.elements.resultsList.innerHTML = html;
			this.bindAccommodationCardClicks();
		},

		buildAccommodationCardHtml(acc) {
			const labels = window.afSearchResultsI18n || window.i18n || {};
			const isOccupied = this.isOccupiedAccommodation(acc);
			const price = Number.isFinite(Number(acc.price)) ? Number(acc.price).toFixed(0) : '0';
			const viewDetailsText = labels.viewDetails || 'Ver detalles';
			const reserveText = labels.reserve || 'Reservar';
			const occupiedText = labels.occupiedUnavailable || 'NO DISPONIBLE - OCUPADA';
			const cardClasses = isOccupied
				? 'accommodation-card af-featured-accommodation--occupied af-occupied-accommodation--occupied'
				: 'accommodation-card';
			const occupiedOverlay = isOccupied
				? '<div class="af-occupied-overlay"><span class="af-occupied-badge">Ocupada</span></div>'
				: '';
			const actionsHtml = isOccupied
				? `<button type="button" class="button button-small" disabled aria-disabled="true">${this.escapeHtml(occupiedText)}</button>`
				: `<button type="button" class="button button-small" data-af-reserve-trigger data-af-accommodation-id="${acc.id}" data-af-accommodation-title="${this.escapeHtml(acc.title)}" data-af-is-occupied="0">${reserveText}</button>`;
			return `
				<div class="${cardClasses}" data-id="${acc.id}">
					${acc.image_url ? `<div class="accommodation-image"><img src="${this.escapeHtml(acc.image_url)}" alt="${this.escapeHtml(acc.title)}" loading="lazy" />${occupiedOverlay}</div>` : ''}
					<h4 class="accommodation-title">${this.escapeHtml(acc.title)}</h4>
					<p class="accommodation-location">${this.escapeHtml(acc.location)}</p>
					<div class="accommodation-meta">
						<span>${acc.bedrooms} 🛏️ ${acc.bathrooms} 🚿</span>
						<span class="accommodation-price">$${price}</span>
					</div>
					<div class="af-reserve-actions">
						${actionsHtml}
						<a href="${this.escapeHtml(acc.url)}" class="button button-small">${viewDetailsText}</a>
					</div>
				</div>
			`;
		},

		isOccupiedAccommodation(acc) {
			if (!acc || typeof acc !== 'object') return false;
			const value = acc.is_occupied;
			return value === true || value === 1 || value === '1' || value === 'true';
		},

		bindAccommodationCardClicks() {

			// Add click handlers for cards
			document.querySelectorAll('.accommodation-card').forEach(card => {
				card.addEventListener('click', (e) => {
					if (e.target.closest('a') || e.target.closest('[data-af-reserve-trigger]')) return;
					const id = card.dataset.id;
					const link = card.querySelector('a.button');
					if (link) {
						window.location.href = link.href;
					} else {
						this.highlightAccommodation(id);
					}
				});
			});
		},

		scheduleBackgroundMarkers() {
			const run = () => this.loadBackgroundMarkers();
			if (typeof window.requestIdleCallback === 'function') {
				window.requestIdleCallback(run, { timeout: 3000 });
			} else {
				setTimeout(run, 500);
			}
		},

		async loadBackgroundMarkers() {
			const accommodations = await this.fetchAllAccommodations();
			accommodations.forEach(acc => {
				const lat = parseFloat(acc.latitude);
				const lng = parseFloat(acc.longitude);
				if (!Number.isFinite(lat) || !Number.isFinite(lng) || (lat === 0 && lng === 0)) return;
				if (this.allAccommodationMarkers[acc.id]) return;

				const marker = L.marker([lat, lng], {
					icon: L.divIcon({
						className: 'accommodation-marker accommodation-marker--bg',
						html: '<div class="marker-core marker-core--bg" aria-hidden="true">🏠</div>',
						iconSize: [56, 56],
						iconAnchor: [28, 56],
						popupAnchor: [0, -56],
					}),
				});

				const popupContent = `
					<div class="map-info-popup">
						${acc.image_url ? `<img src="${this.escapeHtml(acc.image_url)}" style="width:100%;height:120px;object-fit:cover;border-radius:4px;margin-bottom:8px;" />` : ''}
						<div class="map-info-title">${this.escapeHtml(acc.title)}</div>
						<div>${this.escapeHtml(acc.location)}</div>
						<div class="map-info-price">$${Number(acc.price || 0).toFixed(0)}/mo</div>
						<a href="${this.escapeHtml(acc.url)}" class="button button-small" style="margin-top:8px;">${viewDetailsText}</a>
					</div>
				`;
				marker.bindPopup(popupContent);
				this.backgroundMarkerLayer.addLayer(marker);
				this.allAccommodationMarkers[acc.id] = marker;
			});
		},

		async fetchAllAccommodations() {
			const CACHE_KEY = 'af_all_accommodations';
			const CACHE_TTL = 5 * 60 * 1000; // 5 minutes

			try {
				const cached = sessionStorage.getItem(CACHE_KEY);
				if (cached) {
					const { ts, data } = JSON.parse(cached);
					if (Date.now() - ts < CACHE_TTL) {
						return data;
					}
				}
			} catch (_) { /* sessionStorage may be unavailable */ }

			try {
				const payload = {
					location: '',
					radius_km: 50,
					price_min: 0,
					price_max: 999999,
					bedrooms: 0,
					bathrooms: 0,
					property_type: '',
					amenities: [],
					sort: 'newest',
					per_page: 100,
					page: 1,
				};

				const controller = new AbortController();
				const timeoutId = window.setTimeout(() => controller.abort(), this.resultsFetchTimeoutMs);

				let response;
				try {
					response = await fetch(`${window.location.origin}/wp-json/af/v1/accommodations/search`, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
						},
						body: JSON.stringify(payload),
						signal: controller.signal,
					});
				} finally {
					window.clearTimeout(timeoutId);
				}

				if (!response.ok) {
					return [];
				}

				const data = await response.json();
				if (!data.success || !Array.isArray(data.results)) {
					return [];
				}

				try {
					sessionStorage.setItem(CACHE_KEY, JSON.stringify({ ts: Date.now(), data: data.results }));
				} catch (_) { /* storage full or unavailable */ }

				return data.results;
			} catch (error) {
				console.warn('Fallback accommodations load failed:', error);
				return [];
			}
		},

		highlightAccommodation(accommodationId) {
			document.querySelectorAll('.accommodation-card').forEach(card => {
				card.classList.remove('active');
			});
			const activeCard = document.querySelector(`.accommodation-card[data-id="${accommodationId}"]`);
			if (activeCard) {
				activeCard.classList.add('active');
				activeCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			}

			if (this.accommodationMarkers[accommodationId]) {
				const marker = this.accommodationMarkers[accommodationId];
				marker.openPopup();
				this.map.setView(marker.getLatLng(), 15);
			}
		},

		updateMapMarkers(accommodations) {
			this.clearAccommodationMarkers();
			let markerCount = 0;

			accommodations.forEach(acc => {
				const viewDetailsText = (window.i18n && window.i18n.viewDetails) ? window.i18n.viewDetails : 'Ver detalles';
				const lat = parseFloat(acc.latitude);
				const lng = parseFloat(acc.longitude);
				if (Number.isFinite(lat) && Number.isFinite(lng) && (lat !== 0 || lng !== 0)) {
					// Hide the blue background marker while this accommodation is shown as an active result.
					if (this.backgroundMarkerLayer && this.allAccommodationMarkers[acc.id]) {
						this.backgroundMarkerLayer.removeLayer(this.allAccommodationMarkers[acc.id]);
					}

					const marker = L.marker([lat, lng], {
						icon: L.divIcon({
							className: 'accommodation-marker',
							html: '<div class="marker-ping"></div><div class="marker-core" aria-hidden="true">🏠</div>',
							iconSize: [56, 56],
							iconAnchor: [28, 56],
							popupAnchor: [0, -56],
						}),
					});

					const popupContent = `
						<div class="map-info-popup">
							${acc.image_url ? `<img src="${this.escapeHtml(acc.image_url)}" style="width:100%;height:120px;object-fit:cover;border-radius:4px;margin-bottom:8px;" />` : ''}
							<div class="map-info-title">${this.escapeHtml(acc.title)}</div>
							<div>${this.escapeHtml(acc.location)}</div>
							<div class="map-info-price">$${Number(acc.price || 0).toFixed(0)}/mo</div>
							<a href="${this.escapeHtml(acc.url)}" class="button button-small" style="margin-top:8px;">${viewDetailsText}</a>
						</div>
					`;

					marker.bindPopup(popupContent);

					marker.addEventListener('click', () => {
						this.highlightAccommodation(acc.id);
					});

					if (this.markerLayer) {
						this.markerLayer.addLayer(marker);
					} else {
						marker.addTo(this.map);
					}

					this.accommodationMarkers[acc.id] = marker;
					markerCount += 1;
				}
			});

			return markerCount;
		},

		fitMapBounds(accommodations) {
			// Guarantee Leaflet knows the real container size before fitting bounds.
			// Without this, fitBounds() calculates pixel positions using a stale
			// (potentially zero) size and markers land outside the visible area.
			this.map.invalidateSize({ pan: false });

			const bounds = L.latLngBounds();
			let coordinateCount = 0;
			accommodations.forEach(acc => {
				const lat = parseFloat(acc.latitude);
				const lng = parseFloat(acc.longitude);
				if (Number.isFinite(lat) && Number.isFinite(lng) && (lat !== 0 || lng !== 0)) {
					bounds.extend([lat, lng]);
					coordinateCount += 1;
				}
			});

			if (bounds.isValid()) {
				if (coordinateCount === 1) {
					this.map.setView(bounds.getCenter(), 16);
					return;
				}

				this.map.fitBounds(bounds, {
					padding: [20, 20],
					maxZoom: 15,
				});
			}
		},

		loadPoiMarkers() {
			if (Object.keys(this.accommodationMarkers).length === 0) {
				return;
			}

			const bounds = this.map.getBounds();
			const center = bounds.getCenter();
			const radius = this.poiSettings.radius * 1000;

			const overpassQueries = this.buildOverpassQueries(center, radius);

			overpassQueries.forEach((query, type) => {
				if (!this.poiSettings[type]) return;

				fetch('https://overpass-api.de/api/interpreter', {
					method: 'POST',
					body: query,
				})
					.then(response => response.json())
					.then(data => this.addPoiMarkers(data.elements, type))
					.catch(error => console.warn(`Error loading ${type} POI:`, error));
			});
		},

		buildOverpassQueries(center, radius) {
			const bbox = `(${center.lat - radius / 111000},${center.lng - radius / 111000},${center.lat + radius / 111000},${center.lng + radius / 111000})`;

			return new Map([
				['transport', `[out:json];(node["public_transport"="stop"]${bbox};way["highway"~"bus_stop|tram_stop"]${bbox};);out center;`],
				['parks', `[out:json];(node["leisure"="park"]${bbox};way["leisure"="park"]${bbox};);out center;`],
				['shops', `[out:json];(node["shop"]${bbox};way["shop"]${bbox};);out center;`],
				['health', `[out:json];(node["amenity"~"hospital|clinic|pharmacy"]${bbox};way["amenity"~"hospital|clinic|pharmacy"]${bbox};);out center;`],
			]);
		},

		addPoiMarkers(elements, type) {
			if (!elements) return;

			const typeIcons = {
				transport: '🚌',
				parks: '🌳',
				shops: '🏪',
				health: '🏥',
			};

			const typeColors = {
				transport: '#3388ff',
				parks: '#7dbe52',
				shops: '#ff9800',
				health: '#f44336',
			};

			elements.forEach(el => {
				const lat = (el.center && el.center.lat) || el.lat;
				const lng = (el.center && el.center.lon) || el.lon;

				if (lat && lng) {
					const marker = L.circleMarker([lat, lng], {
						radius: 6,
						fillColor: typeColors[type],
						color: '#fff',
						weight: 2,
						opacity: 0.8,
						fillOpacity: 0.7,
					}).addTo(this.map);

					const tags = el.tags || {};
					const title = tags.name || tags.shop || tags.leisure || type;
					marker.bindPopup(`<strong>${this.escapeHtml(title)}</strong><br>${type}`);

					const key = `${type}_${lat}_${lng}`;
					this.poiMarkers[key] = marker;
				}
			});
		},

		clearAccommodationMarkers() {
			// Restore blue background markers for accommodations that were temporarily hidden.
			if (this.backgroundMarkerLayer) {
				Object.keys(this.accommodationMarkers).forEach(id => {
					if (this.allAccommodationMarkers[id]) {
						this.backgroundMarkerLayer.addLayer(this.allAccommodationMarkers[id]);
					}
				});
			}

			if (this.markerLayer && typeof this.markerLayer.clearLayers === 'function') {
				this.markerLayer.clearLayers();
			} else {
				Object.values(this.accommodationMarkers).forEach(marker => marker.remove());
			}
			this.accommodationMarkers = {};
		},

		clearPoiMarkers() {
			Object.values(this.poiMarkers).forEach(marker => marker.remove());
			this.poiMarkers = {};
		},

		showMapAlert(message, autoHideMs = 0) {
			if (!this.elements.mapAlert) {
				return;
			}

			if (this.mapAlertTimeoutId) {
				window.clearTimeout(this.mapAlertTimeoutId);
				this.mapAlertTimeoutId = null;
			}

			this.elements.mapAlert.textContent = message;
			this.elements.mapAlert.classList.remove('is-hidden');

			if (autoHideMs > 0) {
				this.mapAlertTimeoutId = window.setTimeout(() => {
					this.hideMapAlert();
				}, autoHideMs);
			}
		},

		hideMapAlert() {
			if (!this.elements.mapAlert) {
				return;
			}

			if (this.mapAlertTimeoutId) {
				window.clearTimeout(this.mapAlertTimeoutId);
				this.mapAlertTimeoutId = null;
			}

			this.elements.mapAlert.textContent = '';
			this.elements.mapAlert.classList.add('is-hidden');
		},

		escapeHtml(text) {
			const div = document.createElement('div');
			div.textContent = text;
			return div.innerHTML;
		},
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => SearchResults.init());
	} else {
		SearchResults.init();
	}

	window.SearchResults = SearchResults;
})();
