/**
 * Hero Search Bar - Location Search with Google Places API
 */

(function() {
	'use strict';

	const SEARCH_LIMITS = Object.freeze({
		min: 2,
		max: 100,
	});

	const FRIENDLY_SEARCH_ERROR = 'No se pudo procesar la búsqueda. Intenta nuevamente.';

	const HeroSearch = {
		apiKey: null,
		autocompleteService: null,
		currentSuggestions: [],
		activeRequestId: 0,
		inputDebounceTimer: null,

		init() {
			this.cacheElements();
			if (!this.elements.searchInput) {
				return;
			}

			this.bindEvents();
		},

		cacheElements() {
			this.elements = {
				searchInput: document.getElementById('hero-search-input'),
				searchBtn: document.getElementById('hero-search-btn'),
				suggestionsList: document.getElementById('hero-search-suggestions'),
			};
		},

		bindEvents() {
			this.elements.searchInput.addEventListener('input', (e) => this.onSearchInput(e));
			this.elements.searchInput.addEventListener('keydown', (e) => this.onSearchKeydown(e));
			this.elements.searchBtn.addEventListener('click', () => this.performSearch());

			// Close suggestions on click outside
			document.addEventListener('click', (e) => {
				if (!e.target.closest('.hero-search-bar')) {
					this.clearSuggestions();
				}
			});
		},

		sanitizeQuery(raw) {
			if (typeof raw !== 'string') {
				return '';
			}

			return raw
				.replace(/[\u0000-\u001F\u007F]/g, '')
				.replace(/[<>`]/g, '')
				.replace(/\s+/g, ' ')
				.trim()
				.slice(0, SEARCH_LIMITS.max);
		},

		debounceSuggestions(query) {
			if (this.inputDebounceTimer) {
				window.clearTimeout(this.inputDebounceTimer);
			}

			this.inputDebounceTimer = window.setTimeout(() => {
				this.fetchSuggestions(query);
			}, 180);
		},

		fetchSuggestions(query) {
			this.ensureGooglePlacesReady();

			if (this.autocompleteService) {
				this.getGooglePlacesSuggestions(query);
				return;
			}

			this.getLocalSuggestions(query);
		},

		initGooglePlaces(apiKey) {
			this.apiKey = apiKey;

			if (window.__afGooglePlacesReadyPromise) {
				return window.__afGooglePlacesReadyPromise;
			}

			if (window.google && window.google.maps && window.google.maps.places) {
				window.__afGooglePlacesReadyPromise = Promise.resolve();
				return window.__afGooglePlacesReadyPromise;
			}

			const existingScript = document.querySelector('script[data-af-google-places="1"]');
			if (existingScript) {
				window.__afGooglePlacesReadyPromise = new Promise((resolve, reject) => {
					existingScript.addEventListener('load', () => resolve(), { once: true });
					existingScript.addEventListener('error', (err) => reject(err), { once: true });
				});
				return window.__afGooglePlacesReadyPromise;
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

			return window.__afGooglePlacesReadyPromise;
 		},

		ensureGooglePlacesReady() {
			if (this.autocompleteService) {
				return Promise.resolve();
			}

			if (window.google && window.google.maps && window.google.maps.places) {
				this.autocompleteService = new google.maps.places.AutocompleteService();
				return Promise.resolve();
			}

			const apiKey = document.body.dataset.googlePlacesKey || null;
			if (!apiKey) {
				return Promise.resolve();
			}

			return this.initGooglePlaces(apiKey)
				.then(() => {
					if (window.google && window.google.maps && window.google.maps.places) {
						this.autocompleteService = new google.maps.places.AutocompleteService();
					}
				})
				.catch(() => {});
		},

		onSearchInput(e) {
			try {
				const value = this.sanitizeQuery(e.target.value);

				if (e.target.value !== value) {
					e.target.value = value;
				}

				if (!value || value.length < SEARCH_LIMITS.min) {
					this.clearSuggestions();
					return;
				}

				this.debounceSuggestions(value);
			} catch (_err) {
				this.clearSuggestions();
				this.setInputError(true);
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

				const finish = value => resolve(value);

				const fetchPosition = (timeoutMs) => {
					let settled = false;
					const done = value => {
						if (settled) return;
						settled = true;
						finish(value);
					};

					const hardTimeout = window.setTimeout(() => done(null), timeoutMs);

					navigator.geolocation.getCurrentPosition(
						position => {
							window.clearTimeout(hardTimeout);
							done({
								latitude: position.coords.latitude,
								longitude: position.coords.longitude,
							});
						},
						() => {
							window.clearTimeout(hardTimeout);
							done(null);
						},
						{ enableHighAccuracy: false, timeout: timeoutMs, maximumAge: 300000 }
					);
				};

				// If permission was already granted, GPS resolves fast — worth a short wait.
				// If it's still 'prompt', skip immediately: waiting would let the OS prompt
				// appear only to be dismissed by the imminent navigation.
				if (navigator.permissions && navigator.permissions.query) {
					navigator.permissions.query({ name: 'geolocation' }).then(status => {
						if (status.state === 'granted') {
							fetchPosition(1500);
						} else {
							finish(null);
						}
					}).catch(() => finish(null));
					return;
				}

				// Older browsers without Permissions API: skip to avoid killing prompt on nav.
				finish(null);
			});
		},

		getGooglePlacesSuggestions(query) {
			if (!this.autocompleteService) {
				return;
			}

			const requestId = ++this.activeRequestId;

			this.autocompleteService.getPlacePredictions(
				{
					input: query,
					componentRestrictions: { country: 'ec' },
				},
				(predictions, status) => {
					if (requestId !== this.activeRequestId) {
						return;
					}

					if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
						this.renderSuggestions(
							predictions.map(p => ({
								label: this.sanitizeQuery(p.main_text),
								description: this.sanitizeQuery(p.description),
							}))
						);
						this.setInputError(false);
						return;
					}

					this.clearSuggestions();
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
			this.elements.suggestionsList.textContent = '';

			const fragment = document.createDocumentFragment();
			suggestions.forEach((sug, idx) => {
				const li = document.createElement('li');
				li.dataset.index = String(idx);
				li.setAttribute('role', 'option');
				li.id = `hero-search-option-${idx}`;

				const strong = document.createElement('strong');
				strong.textContent = this.sanitizeQuery(sug.label);

				const small = document.createElement('small');
				small.textContent = this.sanitizeQuery(sug.description);

				li.appendChild(strong);
				li.appendChild(small);
				li.addEventListener('click', () => this.selectSuggestion(idx));
				fragment.appendChild(li);
			});

			this.elements.suggestionsList.appendChild(fragment);
			const hasSuggestions = suggestions.length > 0;
			this.elements.suggestionsList.style.display = hasSuggestions ? 'block' : 'none';
			this.elements.searchInput.setAttribute('aria-expanded', hasSuggestions ? 'true' : 'false');
		},

		clearSuggestions() {
			if (this.elements.suggestionsList) {
				this.elements.suggestionsList.style.display = 'none';
				this.elements.suggestionsList.textContent = '';
			}
			if (this.elements.searchInput) {
				this.elements.searchInput.setAttribute('aria-expanded', 'false');
			}
			this.currentSuggestions = [];
		},

		selectSuggestion(index) {
			const suggestion = this.currentSuggestions[index];
			if (suggestion) {
				this.elements.searchInput.value = suggestion.description;
				this.clearSuggestions();
				this.performSearch();
			}
		},

		async performSearch() {
			try {
				const location = this.sanitizeQuery(this.elements.searchInput.value);
				if (!location || location.length < SEARCH_LIMITS.min) {
					this.setInputError(true);
					return;
				}

				this.setInputError(false);
				this.elements.searchInput.value = location;

				const params = new URLSearchParams({
					location: location,
				});

				const userLocation = await this.getUserLocation();
				if (userLocation) {
					params.set('latitude', String(userLocation.latitude));
					params.set('longitude', String(userLocation.longitude));
				}

				const targetUrl = new URL('/search-results', window.location.origin);
				targetUrl.search = params.toString();
				window.location.assign(targetUrl.toString());
			} catch (_err) {
				this.setInputError(true);
				if (window.alert) {
					window.alert(FRIENDLY_SEARCH_ERROR);
				}
			}
		},

		setInputError(hasError) {
			if (!this.elements.searchInput) {
				return;
			}
			this.elements.searchInput.setAttribute('aria-invalid', hasError ? 'true' : 'false');
		},

		escapeHtml(text) {
			const div = document.createElement('div');
			div.textContent = text;
			return div.innerHTML;
		},
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => HeroSearch.init());
	} else {
		HeroSearch.init();
	}

	window.HeroSearch = HeroSearch;
})();
