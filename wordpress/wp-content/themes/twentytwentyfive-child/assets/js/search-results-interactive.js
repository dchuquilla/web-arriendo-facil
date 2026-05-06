/**
 * Search Results Interactive - Accommodation Map and List Synchronization
 */

(function() {
	'use strict';

	const SearchResults = {
		map: null,
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

		init() {
			this.cacheElements();
			this.initMap();
			this.bindEvents();
			this.loadInitialLocation();
			this.loadResults();
		},

		loadInitialLocation() {
			const params = new URLSearchParams(window.location.search);
			this.currentFilters.location = params.get('location') || '';
			const lat = params.get('latitude');
			const lng = params.get('longitude');
			if (lat && lng) {
				this.currentFilters.latitude = parseFloat(lat);
				this.currentFilters.longitude = parseFloat(lng);
			}
		},

		cacheElements() {
			this.elements = {
				map: document.getElementById('map'),
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

			this.map = L.map('map').setView([0, 0], 13);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© OpenStreetMap contributors',
				maxZoom: 19,
			}).addTo(this.map);
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
			this.loadResults();
		},

		onPoiFilterChange() {
			this.updatePoiSettings();
			this.loadResults();
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
			this.loadResults();
		},

		loadResults() {
			const params = {
				...this.currentFilters,
				location: this.getSearchLocation(),
			};

			fetch(`${window.location.origin}/wp-json/af/v1/accommodations/search`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(params),
			})
				.then(response => response.json())
				.then(data => this.renderResults(data))
				.catch(error => console.error('Error loading results:', error));
		},

		getSearchLocation() {
			const params = new URLSearchParams(window.location.search);
			return params.get('location') || '';
		},

		renderResults(data) {
			if (!data.success) {
				this.elements.resultsList.innerHTML = '<p>Error loading results</p>';
				return;
			}

			this.updateResultsCount(data.count, data.total);
			this.renderResultsList(data.results);
			this.updateMapMarkers(data.results);

			if (data.results.length > 0) {
				this.fitMapBounds(data.results);
				this.loadPoiMarkers();
			}
		},

		updateResultsCount(count, total) {
			this.elements.resultsCount.textContent =
				count === 0
					? 'No results found'
					: `Showing ${count} of ${total} accommodations`;
		},

		renderResultsList(accommodations) {
			if (accommodations.length === 0) {
				this.elements.resultsList.innerHTML = '<p>No accommodations match your filters</p>';
				return;
			}

			const html = accommodations.map(acc => `
				<div class="accommodation-card" data-id="${acc.id}">
					${acc.image_url ? `<div class="accommodation-image"><img src="${this.escapeHtml(acc.image_url)}" alt="${this.escapeHtml(acc.title)}" loading="lazy" /></div>` : ''}
					<h4 class="accommodation-title">${this.escapeHtml(acc.title)}</h4>
					<p class="accommodation-location">${this.escapeHtml(acc.location)}</p>
					<div class="accommodation-meta">
						<span>${acc.bedrooms} 🛏️ ${acc.bathrooms} 🚿</span>
						<span class="accommodation-price">$${acc.price.toFixed(0)}</span>
					</div>
					<a href="${this.escapeHtml(acc.url)}" class="button button-small">${window.i18n?.viewDetails || 'View Details'}</a>
				</div>
			`).join('');

			this.elements.resultsList.innerHTML = html;

			// Add click handlers for cards
			document.querySelectorAll('.accommodation-card').forEach(card => {
				card.addEventListener('click', () => {
					const id = card.dataset.id;
					this.highlightAccommodation(id);
				});
			});
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

			accommodations.forEach(acc => {
				if (acc.latitude && acc.longitude) {
					const marker = L.marker([acc.latitude, acc.longitude], {
						icon: L.divIcon({
							className: 'accommodation-marker',
							html: '<div class="marker-bg">🏠</div>',
							iconSize: [32, 32],
							iconAnchor: [16, 32],
							popupAnchor: [0, -32],
						}),
					}).addTo(this.map);

					const popupContent = `
						<div class="map-info-popup">
							${acc.image_url ? `<img src="${this.escapeHtml(acc.image_url)}" style="width:100%;height:120px;object-fit:cover;border-radius:4px;margin-bottom:8px;" />` : ''}
							<div class="map-info-title">${this.escapeHtml(acc.title)}</div>
							<div>${this.escapeHtml(acc.location)}</div>
							<div class="map-info-price">$${acc.price.toFixed(0)}/mo</div>
							<a href="${this.escapeHtml(acc.url)}" class="button button-small" style="margin-top:8px;">${window.i18n?.viewDetails || 'View Details'}</a>
						</div>
					`;

					marker.bindPopup(popupContent);

					marker.addEventListener('click', () => {
						this.highlightAccommodation(acc.id);
					});

					this.accommodationMarkers[acc.id] = marker;
				}
			});
		},

		fitMapBounds(accommodations) {
			const bounds = L.latLngBounds();
			accommodations.forEach(acc => {
				if (acc.latitude && acc.longitude) {
					bounds.extend([acc.latitude, acc.longitude]);
				}
			});

			if (bounds.isValid()) {
				this.map.fitBounds(bounds, { padding: [50, 50] });
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
				const lat = el.center?.lat || el.lat;
				const lng = el.center?.lon || el.lon;

				if (lat && lng) {
					const marker = L.circleMarker([lat, lng], {
						radius: 6,
						fillColor: typeColors[type],
						color: '#fff',
						weight: 2,
						opacity: 0.8,
						fillOpacity: 0.7,
					}).addTo(this.map);

					const title = el.tags?.name || el.tags?.shop || el.tags?.leisure || type;
					marker.bindPopup(`<strong>${this.escapeHtml(title)}</strong><br>${type}`);

					const key = `${type}_${lat}_${lng}`;
					this.poiMarkers[key] = marker;
				}
			});
		},

		clearAccommodationMarkers() {
			Object.values(this.accommodationMarkers).forEach(marker => marker.remove());
			this.accommodationMarkers = {};
		},

		clearPoiMarkers() {
			Object.values(this.poiMarkers).forEach(marker => marker.remove());
			this.poiMarkers = {};
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
