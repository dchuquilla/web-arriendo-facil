<?php
/**
 * Template for search results page with map and accommodation list.
 *
 * @package twentytwentyfive-child
 */

get_header();
?>

<div class="search-results-wrapper">
	<aside class="search-results-sidebar">
		<div class="search-filters">
			<h3><?php esc_html_e( 'Filters', 'twentytwentyfive-child' ); ?></h3>

			<div class="filter-group filter-price">
				<label for="filter-price-min"><?php esc_html_e( 'Price Range', 'twentytwentyfive-child' ); ?></label>
				<div class="price-inputs">
					<input type="number" id="filter-price-min" class="filter-input" placeholder="Min" min="0" />
					<span>-</span>
					<input type="number" id="filter-price-max" class="filter-input" placeholder="Max" min="0" />
				</div>
			</div>

			<div class="filter-group filter-property-type">
				<label for="filter-property-type"><?php esc_html_e( 'Property Type', 'twentytwentyfive-child' ); ?></label>
				<select id="filter-property-type" class="filter-input">
					<option value=""><?php esc_html_e( 'All types', 'twentytwentyfive-child' ); ?></option>
					<option value="apartment"><?php esc_html_e( 'Apartment', 'twentytwentyfive-child' ); ?></option>
					<option value="house"><?php esc_html_e( 'House', 'twentytwentyfive-child' ); ?></option>
					<option value="office"><?php esc_html_e( 'Office', 'twentytwentyfive-child' ); ?></option>
					<option value="room"><?php esc_html_e( 'Room', 'twentytwentyfive-child' ); ?></option>
				</select>
			</div>

			<div class="filter-group filter-amenities">
				<label><?php esc_html_e( 'Amenities', 'twentytwentyfive-child' ); ?></label>
				<label class="amenity-checkbox">
					<input type="checkbox" class="filter-amenity" value="pet-friendly" />
					<?php esc_html_e( 'Pet Friendly', 'twentytwentyfive-child' ); ?>
				</label>
				<label class="amenity-checkbox">
					<input type="checkbox" class="filter-amenity" value="wifi" />
					<?php esc_html_e( 'WiFi', 'twentytwentyfive-child' ); ?>
				</label>
				<label class="amenity-checkbox">
					<input type="checkbox" class="filter-amenity" value="parking" />
					<?php esc_html_e( 'Parking', 'twentytwentyfive-child' ); ?>
				</label>
				<label class="amenity-checkbox">
					<input type="checkbox" class="filter-amenity" value="pool" />
					<?php esc_html_e( 'Pool', 'twentytwentyfive-child' ); ?>
				</label>
			</div>

			<div class="filter-group filter-poi">
				<label><?php esc_html_e( 'Nearby Amenities', 'twentytwentyfive-child' ); ?></label>
				<label class="poi-checkbox">
					<input type="checkbox" class="filter-poi" value="transport" checked />
					<?php esc_html_e( 'Public Transport', 'twentytwentyfive-child' ); ?>
				</label>
				<label class="poi-checkbox">
					<input type="checkbox" class="filter-poi" value="parks" checked />
					<?php esc_html_e( 'Parks & Green Spaces', 'twentytwentyfive-child' ); ?>
				</label>
				<label class="poi-checkbox">
					<input type="checkbox" class="filter-poi" value="shops" checked />
					<?php esc_html_e( 'Shops & Commerce', 'twentytwentyfive-child' ); ?>
				</label>
				<label class="poi-checkbox">
					<input type="checkbox" class="filter-poi" value="health" checked />
					<?php esc_html_e( 'Health Services', 'twentytwentyfive-child' ); ?>
				</label>

				<div class="poi-radius">
					<label for="poi-radius-slider"><?php esc_html_e( 'Search Radius (km)', 'twentytwentyfive-child' ); ?></label>
					<input type="range" id="poi-radius-slider" min="1" max="5" value="2" class="radius-slider" />
					<span class="radius-value">2 km</span>
				</div>
			</div>

			<button class="button button-primary" id="clear-filters"><?php esc_html_e( 'Clear Filters', 'twentytwentyfive-child' ); ?></button>
		</div>

		<div class="results-count">
			<p id="results-count-text"><?php esc_html_e( 'Loading results...', 'twentytwentyfive-child' ); ?></p>
		</div>

		<div class="results-list" id="results-list">
			<p><?php esc_html_e( 'Loading accommodations...', 'twentytwentyfive-child' ); ?></p>
		</div>
	</aside>

	<main class="search-results-map">
		<div id="map" class="leaflet-map"></div>
	</main>
</div>

<?php get_footer(); ?>
