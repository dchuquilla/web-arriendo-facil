/**
 * Search Bar - Location Search with Google Places API
 */

(function() {
	'use strict';

	const SearchBar = {
		apiKey: null,
		autocompleteService: null,
		placesService: null,
		currentSuggestions: [],

		init() {
			this.cacheElements();
			if (!this.elements.searchInput) {
				console.warn('Search bar elements not found');
				return;
			}

			this.bindEvents();

			const apiKey = document.body.dataset.googlePlacesKey || null;
			if (apiKey) {
				this.initGooglePlaces(apiKey);
			}
		},

		cacheElements() {
			this.elements = {
				searchInput: document.getElementById('search-bar-input'),
				searchBtn: document.getElementById('search-bar-btn'),
				gpsBtn: document.getElementById('search-bar-gps'),
				suggestionsList: document.getElementById('search-suggestions'),
			};
		},

		bindEvents() {
			this.elements.searchInput.addEventListener('input', (e) => this.onSearchInput(e));
			this.elements.searchInput.addEventListener('keydown', (e) => this.onSearchKeydown(e));
			this.elements.searchBtn.addEventListener('click', () => this.performSearch());
			if (this.elements.gpsBtn) {
				this.elements.gpsBtn.addEventListener('click', () => this.useCurrentLocation());
			}
		},

		initGooglePlaces(apiKey) {
			this.apiKey = apiKey;

			const script = document.createElement('script');
			script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places`;
			script.async = true;
			script.defer = true;

			script.onload = () => {
				this.autocompleteService = new google.maps.places.AutocompleteService();
				this.placesService = new google.maps.places.PlacesService(
					document.createElement('div')
				);
			};

			document.head.appendChild(script);
		},

		onSearchInput(e) {
			const value = e.target.value.trim();

			if (!value || value.length < 2) {
				this.clearSuggestions();
				return;
			}

			if (this.autocompleteService) {
				this.getGooglePlacesSuggestions(value);
			} else {
				this.getLocalSuggestions(value);
			}
		},

		onSearchKeydown(e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				this.performSearch();
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
							latitude: position.coords.latitude,
							longitude: position.coords.longitude,
						});
					},
					() => resolve(null),
					{ enableHighAccuracy: true, timeout: 6000, maximumAge: 300000 }
				);
			});
		},

		getGooglePlacesSuggestions(query) {
			if (!this.autocompleteService) {
				return;
			}

			this.autocompleteService.getPlacePredictions(
				{
					input: query,
					componentRestrictions: { country: 'ec' },
				},
				(predictions, status) => {
					if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
						this.renderSuggestions(
							predictions.map(p => ({
								label: p.main_text,
								description: p.description,
								placeId: p.place_id,
							}))
						);
					}
				}
			);
		},

		getLocalSuggestions(query) {
			const locations = [
				'Quito, Mariscal',
				'Quito, La Carolina',
				'Quito, Bellavista',
				'Quito, Cumbaya',
				'Quito, Tumbaco',
				'Guayaquil, Centro',
				'Guayaquil, Samborondon',
				'Guayaquil, Kennedy',
				'Cuenca, Centro',
				'Cuenca, Paute',
			];

			const filtered = locations.filter(loc =>
				loc.toLowerCase().includes(query.toLowerCase())
			);

			this.renderSuggestions(
				filtered.map(loc => ({
					label: loc.split(',')[1].trim(),
					description: loc,
				}))
			);
		},

		renderSuggestions(suggestions) {
			if (!this.elements.suggestionsList) {
				return;
			}

			this.currentSuggestions = suggestions;

			const html = suggestions.map((sug, idx) => `
				<li data-index="${idx}">
					<strong>${this.escapeHtml(sug.label)}</strong>
					<small>${this.escapeHtml(sug.description)}</small>
				</li>
			`).join('');

			this.elements.suggestionsList.innerHTML = html;
			this.elements.suggestionsList.style.display = 'block';

			document.querySelectorAll('#search-suggestions li').forEach((li, idx) => {
				li.addEventListener('click', () => this.selectSuggestion(idx));
			});
		},

		clearSuggestions() {
			if (this.elements.suggestionsList) {
				this.elements.suggestionsList.style.display = 'none';
				this.elements.suggestionsList.innerHTML = '';
			}
			this.currentSuggestions = [];
		},

		selectSuggestion(index) {
			const suggestion = this.currentSuggestions[index];
			if (suggestion) {
				this.elements.searchInput.value = suggestion.description;
				this.clearSuggestions();

				if (suggestion.placeId && this.placesService) {
					this.getPlaceDetails(suggestion.placeId);
				}
			}
		},

		getPlaceDetails(placeId) {
			if (!this.placesService) {
				this.performSearch();
				return;
			}

			this.placesService.getDetails(
				{
					placeId: placeId,
					fields: ['geometry', 'formatted_address'],
				},
				(place, status) => {
					if (status === google.maps.places.PlacesServiceStatus.OK && place.geometry) {
						window.searchLocation = {
							location: this.elements.searchInput.value,
							latitude: place.geometry.location.lat(),
							longitude: place.geometry.location.lng(),
						};
					}
					this.performSearch();
				}
			);
		},

		async performSearch() {
			const location = this.elements.searchInput.value.trim();
			if (!location) {
				return;
			}

			const params = new URLSearchParams({
				location: location,
			});

			if (
				window.searchLocation &&
				window.searchLocation.location === location &&
				Number.isFinite(window.searchLocation.latitude) &&
				Number.isFinite(window.searchLocation.longitude)
			) {
				params.set('latitude', window.searchLocation.latitude);
				params.set('longitude', window.searchLocation.longitude);
			} else {
				const userLocation = await this.getUserLocation();
				if (userLocation) {
					params.set('latitude', userLocation.latitude);
					params.set('longitude', userLocation.longitude);
				}
			}

			window.location.href = `/search-results?${params.toString()}`;
		},

		useCurrentLocation() {
			if (!navigator.geolocation) {
				alert('Geolocation is not supported');
				return;
			}

			navigator.geolocation.getCurrentPosition(
				(position) => {
					window.searchLocation = {
						location: 'My Location',
						latitude: position.coords.latitude,
						longitude: position.coords.longitude,
					};

					const params = new URLSearchParams({
						location: 'My Location',
						latitude: position.coords.latitude,
						longitude: position.coords.longitude,
					});

					window.location.href = `/search-results?${params.toString()}`;
				},
				(error) => {
					console.error('Geolocation error:', error);
					alert('Unable to get your location');
				}
			);
		},

		escapeHtml(text) {
			const div = document.createElement('div');
			div.textContent = text;
			return div.innerHTML;
		},
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => SearchBar.init());
	} else {
		SearchBar.init();
	}

	window.SearchBar = SearchBar;
})();
