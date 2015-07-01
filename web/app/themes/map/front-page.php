<?php get_template_part('templates/page', 'header'); ?>

<?php
	/*
	 * Map locations
	 */

	// Grab the location post count
	$location_count = wp_count_posts( 'location' );

	// Map locations query
	$map_locations = new WP_Query( array(
		'post_type' => 'location',
		'posts_per_page' => $location_count->publish,
		'orderby' => 'title',
		'order' => 'ASC'
	) );

	// Grab map categories (uses default 'category' taxonomy)
	$map_categories = get_categories();

	// Create a list of map categories by term ID
	$map_categories_term_ids = array();

	// Create a list of map locations within their respected categories
	$map_locations_categories = array();

	// Loop through map categories to setup base category arrays
	if ( ! empty ( $map_categories ) )
		foreach ( $map_categories as $map_category ) {
			// Add this category to the term ID array
			$map_categories_term_ids[$map_category->term_id] = $map_category;

			// Create a base array for this map category for locations
			$map_locations_categories[$map_category->term_id] = array();
		}

	// Loop through map locations
	if ( $map_locations->have_posts() )
		while ( $map_locations->have_posts() ) {
			$map_locations->next_post();

			// Grab the categories for this location
			$location_categories = get_the_category( $map_locations->post->ID );

			// Loop through categories for this location
			if ( ! empty( $location_categories ) ) {
				// Grab the term ID (first category only) TODO: Should we reference all categories?
				$term_id = $location_categories[0]->term_id;

				// Store a reference to this post in the first category array
				if ( isset( $map_locations_categories[$term_id] ) )
					$map_locations_categories[$term_id][] = $map_locations->post;

			}
		}
?>

<?php get_template_part( 'templates/map', 'list-view' ); // List View ?>

<div id="viewport">
	<div id="map" class="z1">
		<a href="#overlay" class="pin residential" ></a>
	</div>
</div>
