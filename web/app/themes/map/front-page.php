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
?>

<?php get_template_part( 'templates/map', 'list-view' ); // List View ?>
<div id="viewport">
	<div id="map" class="z1"></div>
</div>
