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
<?php 
	//Build a persistent locations array
	$locations = array();
	$query_locations = new WP_Query( array(
		'post_type' => 'location',
		'posts_per_page' => $location_count->publish,
	) );
	while ($query_locations->have_posts()) {
		$query_locations->the_post();
  	$row = array(
    	'title' => get_the_title(),
    	'permalink' => get_the_permalink(),
    	'tags' => get_the_tags(),
    	'categories' => get_the_category()
  	);
		if ( has_post_thumbnail() ) {
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID() ));
			$row['thumbnail'] = $thumbnail[0];
		}
  	$fields = get_fields();
  	if ($fields) {
    	foreach($fields as $field_name => $value) {
      	$field = get_field_object($field_name, false, array('load_value' => false));
      	$row[$field_name] = $value;
    	}
  	}
  	$locations[] = $row;
	}
	wp_reset_postdata();
?>
<div id="viewport">
	<div id="map" class="z1">
		<div id="map_controls">
			<a class="zoomin">+</a>
			<a class="zoomout">-</a>
		</div>
		<ul id="map_locations">
			<? foreach($locations as $location) { ?>
				<li class="location <?= $location['categories'][0]->slug; ?>" style='left:<?= $location['x_coord']; ?>%;top:<?= $location['y_coord']; ?>%;'>
					<div class="quicklook<?=($location['x_coord']>72) ? ' right' : '' ?>">
						<div class="col-xs-5">
							<img src="<?=$location['thumbnail']; ?>" alt="<?=$location['title']; ?>" class="thumb" />
						</div>
						<div class="col-xs-7">
							<h2><a href="<?= $location['permalink'].'?lightbox'; ?>" class="location-lightbox" data-toggle="lightbox"><?=$location['title']; ?></a></h2>
							<p><?=wp_trim_words($location['description'],15); ?></p>
							<a href="<?=$location['permalink'].'?lightbox'; ?>" class="button more location-lightbox" data-toggle="lightbox">More</a>
						</div>
					</div>
					<a href="#" class="pin"></a>
			<? } ?>
		</ul>
	</div>
</div>
