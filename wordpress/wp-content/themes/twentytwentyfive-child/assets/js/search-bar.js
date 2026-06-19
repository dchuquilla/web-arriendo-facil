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
		googleLoadPromise: null,

		init() {
			this.cacheElements();
			if (!this.elements.searchInput) {
				console.warn('Search bar elements not found');
				return;
			}

			this.bindEvents();
		},

		lazyInitGooglePlaces() {
			if (this.autocompleteService) return;

			if (window.google && window.google.maps && window.google.maps.places) {
				this.autocompleteService = new google.maps.places.AutocompleteService();
				this.placesService = new google.maps.places.PlacesService(document.createElement('div'));
				return;
			}

			const apiKey = document.body.dataset.googlePlacesKey || null;
			if (apiKey) {
				this.initGooglePlaces(apiKey).then(() => {
					if (window.google && window.google.maps && window.google.maps.places) {
						this.autocompleteService = new google.maps.places.AutocompleteService();
						this.placesService = new google.maps.places.PlacesService(document.createElement('div'));
					}
				});
			}
		},

		cacheElements() {
			this.elements = {
				searchInput: document.getElementById('search-bar-input'),
				searchBtn: document.getElementById('search-bar-btn'),
				suggestionsList: document.getElementById('search-suggestions'),
			};
		},

		bindEvents() {
			this.elements.searchInput.addEventListener('input', (e) => this.onSearchInput(e));
			this.elements.searchInput.addEventListener('keydown', (e) => this.onSearchKeydown(e));
			this.elements.searchBtn.addEventListener('click', () => this.performSearch());
		},

		initGooglePlaces(apiKey) {
			this.apiKey = apiKey;

			if (window.__afGooglePlacesReadyPromise) {
				this.googleLoadPromise = window.__afGooglePlacesReadyPromise;
				return this.googleLoadPromise;
			}

			if (window.google && window.google.maps && window.google.maps.places) {
				window.__afGooglePlacesReadyPromise = Promise.resolve();
				this.googleLoadPromise = window.__afGooglePlacesReadyPromise;
				return this.googleLoadPromise;
			}

			const existingScript = document.querySelector('script[data-af-google-places="1"]');
			if (existingScript) {
				window.__afGooglePlacesReadyPromise = new Promise((resolve, reject) => {
					existingScript.addEventListener('load', () => resolve(), { once: true });
					existingScript.addEventListener('error', (err) => reject(err), { once: true });
				});
				this.googleLoadPromise = window.__afGooglePlacesReadyPromise;
				return this.googleLoadPromise;
			}

			window.__afGooglePlacesReadyPromise = new Promise((resolve, reject) => {
				const script = document.createElement('script');
				script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places`;
				script.async = true;
				script.defer = true;
				script.setAttribute('data-af-google-places', '1');

				script.onload = () => resolve();
				script.onerror = (err) => reject(err);

				document.head.appendChild(script);
			});

			this.googleLoadPromise = window.__afGooglePlacesReadyPromise;
			return this.googleLoadPromise;
		},

		onSearchInput(e) {
			const value = e.target.value.trim();

			if (!value || value.length < 2) {
				this.clearSuggestions();
				return;
			}

			this.lazyInitGooglePlaces();

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
			const fragment = document.createDocumentFragment();

			suggestions.forEach((sug, idx) => {
				const li = document.createElement('li');
				li.dataset.index = idx;

				const strong = document.createElement('strong');
				strong.textContent = sug.label;

				const small = document.createElement('small');
				small.textContent = sug.description;

				li.appendChild(strong);
				li.appendChild(small);
				li.addEventListener('click', () => this.selectSuggestion(idx));

				fragment.appendChild(li);
			});

			this.elements.suggestionsList.innerHTML = '';
			this.elements.suggestionsList.appendChild(fragment);
			this.elements.suggestionsList.style.display = 'block';
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
						sessionStorage.setItem('searchLocation', JSON.stringify({
							location: this.elements.searchInput.value,
							latitude: place.geometry.location.lat(),
							longitude: place.geometry.location.lng(),
							timestamp: Date.now(),
						}));
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

			   // Removed geolocation logic for GPS button

			window.location.href = `/search-results?${params.toString()}`;
		},


	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => SearchBar.init());
	} else {
		SearchBar.init();
	}

	window.SearchBar = SearchBar;
})();
