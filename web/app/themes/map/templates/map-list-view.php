<?php
/**
 * This template is used to display the List View for the map.
 */

global $map_locations, $map_categories; // Populated in front-page.php

?>

<div id="list-view" class="list-view closed">
	<div id="list-view-top" class="list-view-top">
		<div id="list-view-search" class="list-view-search list-view-filter cf">
			<label class="screen-reader-text" for="location-search">Search locations by name</label>
			<input type="search" id="list-view-location-search" class="list-view-location-search" placeholder="Search by name" />
			<button type="submit" id="list-view-location-search-submit" class="button glyphicon glyphicon-search list-view-location-search-submit" value="" title="Search locations"></button>
		</div>

		<div id="list-view-categories" class="list-view-categories list-view-filter cf">
			<?php
				// Loop through map categories
				if ( ! empty( $map_categories ) ) :
					foreach( $map_categories as $map_category ) :
			?>
					<div class="list-view-category <?php echo esc_attr( $map_category->slug ); ?>">
						<input type="checkbox" id="list-view-category-<?php echo esc_attr( $map_category->slug ); ?>" name="list-view-category-<?php echo esc_attr( $map_category->slug ); ?>" value="<?php echo esc_attr( $map_category->slug ); ?>" checked="checked" />
						<label for="list-view-category-<?php echo esc_attr( $map_category->slug ); ?>"><?php echo $map_category->name; ?></label>
					</div>
			<?php
					endforeach;
				endif;
			?>
		</div>
	</div>

	<div id="list-view-bottom" class="list-view-bottom">
		<div id="list-view-locations" class="list-view-locations">
			<?php
				// Loop through locations
				if ( $map_locations->have_posts() ) :
					while ( $map_locations->have_posts() ) : $map_locations->the_post();
						// Grab the categories for this location
						$location_categories = get_the_category();

						// CSS classes
						$css_classes = array();

						// Loop through categories for this location
						if ( ! empty( $location_categories ) )
							foreach ( $location_categories as $location_category ) {
								// Add the location category slug to CSS classes
								$css_classes[] = $location_category->slug;
								$css_classes[] = 'list-view-category-' . $location_category->slug;
							}

						// Sanitize CSS classes
						$css_classes = array_filter( $css_classes, 'sanitize_html_class' );

						// Implode CSS classes
						$css_classes = implode( ' ', $css_classes );
					?>
						<div class="list-view-location <?php echo esc_attr( $css_classes ); ?> cf">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="list-view-location-image">
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</div>
							<?php endif; ?>

							<div class="list-view-location-details">
								<h3 class="list-view-location-title list-view-location-name"><?php the_title(); ?></h3>

								<div class="list-view-location-categories">
									<?php
										// Loop through categories for this location
										if ( ! empty( $location_categories ) ) :
											// Grab the count of location categories
											$location_categories_count = count( $location_categories );

											$location_categories_output = '';
											$location_categories_index = 1;
											foreach ( $location_categories as $location_category ) {
												$location_categories_output .= '<span class="list-view-location-category">'. $location_category->name . '</span>';

												// If we have more than one category
												if ( $location_categories_count > 1 ) {
													// If we're not on the last index
													if ( $location_categories_index !== $location_categories_count ) {
														$location_categories_output .= '<span class="list-view-location-separator">, </span>';
													}

													// Increase the index count
													$location_categories_index++;
												}
											}

											// Output location categories
											echo $location_categories_output;
										endif;
									?>
								</div>

								<div class="list-view-location-description">
									<?php
										$description = get_field( 'description' );
										$description = wp_trim_words( $description, 15 ); // TODO: Adjust number of words
										$description = apply_filters( 'the_content', $description );
										$description = str_replace( ']]>', ']]&gt;', $description );

										echo $description;
									?>
								</div>
							</div>
						</div>
					<?php
					endwhile;

					// Reset global $post
					wp_reset_postdata();
				else: // No Posts
					// TODO?
				endif;
			?>
		</div>
	</div>

	<a href="#" class="button list-view-button" data-close-label="Close" data-open-label="List View">List View</a>
</div>

