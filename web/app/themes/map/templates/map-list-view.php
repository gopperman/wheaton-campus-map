<?php
/**
 * This template is used to display the List View for the map.
 */

global $map_locations, $map_categories, $map_locations_categories, $map_categories_term_ids; // Populated in front-page.php

?>

<div id="list-view" class="list-view closed">
	<div id="list-view-inner" class="list-view-inner">
		<div id="list-view-search" class="list-view-search list-view-filter cf">
			<label class="screen-reader-text" for="location-search">Search locations by name</label>
			<input type="search" id="list-view-location-search" class="list-view-filter-search list-view-location-search" placeholder="Search by name" />
			<button type="submit" id="list-view-location-search-submit" class="glyphicon glyphicon-search list-view-location-search-submit" value="" title="Search locations"></button>
		</div>

		<div id="list-view-categories" class="list-view-categories list-view-filter cf">
			<?php
				// Loop through map categories
				if ( ! empty ( $map_categories ) ) :
					foreach ( $map_categories as $map_category ) :
			?>
					<div class="list-view-category <?php echo esc_attr( $map_category->slug ); ?> col-xs-6 col-md-4">
						<input type="checkbox" id="list-view-category-<?php echo esc_attr( $map_category->slug ); ?>" class="list-view-filter-category" name="list-view-category-<?php echo esc_attr( $map_category->slug ); ?>" value="<?php echo esc_attr( $map_category->slug ); ?>" checked="checked" />
						<label for="list-view-category-<?php echo esc_attr( $map_category->slug ); ?>"><?php echo $map_category->name; ?></label>
					</div>
			<?php
					endforeach;
				endif;
			?>
		</div>

		<ul id="list-view-locations" class="list-view-locations">
			<?php
				// Loop through map location categories
				if ( ! empty( $map_locations_categories ) ) :
					foreach ( $map_locations_categories as $location_category_id => $location_category_posts ) :
						// Loop through posts within this category
						if ( ! empty( $location_category_posts ) ) :
							// Grab the location category object
							$location_category = $map_categories_term_ids[$location_category_id];
						?>
							<li class="list-view-location <?php echo esc_attr( $location_category->slug ); ?> list-view-location-category-name list-view-location-category-name-<?php echo esc_attr( $location_category->slug ); ?> cf" data-category="<?php echo esc_attr( $location_category->slug ); ?>"><?php echo $location_category->name; ?> Buildings</li>
						<?php
							// Setting each post to global $post so 'the_' functions work properly
							foreach ( $location_category_posts as $post ) :
								// Grab the categories for this location (because they may have more than one)
								$location_categories = get_the_category( $post->ID );

								// CSS classes
								$css_classes = array();

								// Add the location category (first category only)
								if ( ! empty( $location_categories ) ) {
									$css_classes[] = $location_categories[0]->slug;
									$css_classes[] = 'list-view-category-' . $location_categories[0]->slug;
								}

								// Sanitize CSS classes
								$css_classes = array_filter( $css_classes, 'sanitize_html_class' );

								// Implode CSS classes
								$css_classes = implode( ' ', $css_classes );

								// Description
								$rich_description = get_field( 'description' );
								$raw_description = strip_tags( $rich_description ); // Remove HTML tags
								$description = wp_trim_words( $raw_description, 15 ); // TODO: Adjust number of words
								$description = apply_filters( 'the_content', $description );
								$description = str_replace( ']]>', ']]&gt;', $description );
							?>
								<li class="list-view-location <?php echo esc_attr( $css_classes ); ?> cf" data-title="<?php echo esc_attr( get_the_title() ); ?>" data-description="<?php echo esc_attr( $raw_description ); ?>">
									<a href="<?php the_permalink(); ?>" class="list-view-location-link">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="list-view-location-image">
												<?php the_post_thumbnail( 'thumbnail' ); ?>
											</div>
										<?php endif; ?>

										<div class="list-view-location-details">
											<h4 class="list-view-location-title list-view-location-name"><?php the_title(); ?></h4>

											<div class="list-view-location-categories">
												<?php
													// Loop through categories for this location
													if ( ! empty( $location_categories ) ) :
														foreach ( $location_categories as $location_category ) :
														?>
															<span class="list-view-location-category <?php echo esc_attr( $location_category->slug ); ?> list-view-location-category-<?php echo esc_attr( $location_category->slug ); ?>"><?php echo $location_category->name; ?></span>
														<?php
														endforeach;
													endif;
												?>
											</div>

											<div class="list-view-location-description">
												<?php echo $description; ?>
											</div>
										</div>
									</a>
								</li>
							<?php
							endforeach;
						endif;
					endforeach;
				?>
					<li class="list-view-location list-view-no-results cf hidden">No Results Found</li>
				<?php
					// Reset global $post data
					wp_reset_postdata();
				else: // No Posts
					// TODO?
				endif;
			?>
		</ul>
	</div>

	<a href="#" class="button list-view-button" data-close-label="<span class=&quot;glyphicon glyphicon-list&quot;></span> Close" data-open-label="<span class=&quot;glyphicon glyphicon-list&quot;></span> List View"><span class="glyphicon glyphicon-list"></span> List View</a>
</div>

