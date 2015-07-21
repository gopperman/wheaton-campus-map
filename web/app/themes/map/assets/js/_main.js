/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages
			var $document = $( document ),
				$body = $( 'body' );

			//Asynchronously load external CSS - Font Awesome
			var fa = document.createElement('link');
			fa.href = 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css';
			fa.rel = 'stylesheet';
			fa.type = 'text/css';
			document.getElementsByTagName('head')[0].appendChild(fa);

			//Google Fonts
			var gf = document.createElement('link');
			gf.href = '//fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald:400,700';
			gf.rel = 'stylesheet';
			gf.type = 'text/css';
			document.getElementsByTagName('head')[0].appendChild(gf);

			//Smooth Scrolling
			$document.delegate( 'a[href*=#]:not([href=#])', 'click', function() {
				if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
					var target = $(this.hash);
					target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
					if (target.length) {
						$('html,body').animate({
							scrollTop: target.offset().top
						}, 600);
						$( '.ekko-lightbox' ).animate( {
							scrollTop: target.position().top
						}, 600 );
						return false;
					}
				}
			});

      //Map Control Singleton
			function Map() {
				this.locations = $('.location');
				this.map = $('#map');
				this.resetActiveLocations = function() {
					this.locations.removeClass('active');
				};
				this.zoomOut = function() {
					if (!this.map.hasClass('z1')) {
						if (this.map.hasClass('z2')) {
							this.map.removeClass('z2');
							this.map.addClass('z1');
						} else {
							this.map.removeClass('z3');
							this.map.addClass('z2');
						}
					}
				};
				this.zoomIn = function() {
					if (!this.map.hasClass('z3')) {
						if (this.map.hasClass('z2')) {
							this.map.removeClass('z2');
							this.map.addClass('z3');
						} else {
							this.map.removeClass('z1');
							this.map.addClass('z2');
						}
					}
				};
				this.center = function() {
					$('#viewport').animate({
						scrollTop: (this.map.height() / 2) - (window.innerHeight / 2),
						scrollLeft: (this.map.width() / 2) - (window.innerWidth / 2)
					}, 0);
				};
				this.closeListView = function() {
					// Close the list view
					$list_view.addClass( 'closed' );

					// Change the label of the list view button
					$list_view_buttons.each( function ( ) {
						var $this = $( this );
						$this.html( $this.data( 'open-label' ) );
					} );

					// Adjust the body class
					$body.removeClass( 'list-view-open' );
				};
				// Bind Actions
				this.locations.on('tap click', function(e) {
					if (!$(this).hasClass('active')) {
						e.preventDefault();
						map.resetActiveLocations();
						$(this).addClass('active');
						if (!$(e.target).hasClass('location-lightbox')) {
							e.stopPropagation();
						}
					}
				});
				$('#map').click(function(e) {
					map.resetActiveLocations();
					map.closeListView();
				});
				$('.zoomin').on('tap click', function(e) {
					map.zoomIn();
				});
				$('.zoomout').on('tap click', function(e) {
					map.zoomOut();
				});
			}
			var map = map || new Map();
			map.center();

		// Map Panning
		$('#viewport').kinetic('attach', {cursor : 'pointer'});

		// Ekko Lightbox
		$document.delegate( '*[data-toggle="lightbox"]', 'touch click', function( event ) {
			var $this = $( this ), $ekko_lightbox, $ekko_lightbox_header, $ekko_lightbox_footer;

			// Prevent default
			event.preventDefault();

			// Add Lightbox
			$this.ekkoLightbox( {
				left_arrow_class: '.glyphicon .glyphicon-menu-left',
				right_arrow_class: '.glyphicon .glyphicon-menu-right'
			} );

			// Location Lightbox Links
			if ( $this.hasClass( 'location-lightbox' ) ) {
				$ekko_lightbox = $( '.ekko-lightbox' );
				$ekko_lightbox_header = $ekko_lightbox.find( '.modal-header' );
				$ekko_lightbox_footer = $ekko_lightbox.find( '.modal-footer' );

				// Add location-lightbox CSS class to modal wrapper
				$ekko_lightbox.addClass( 'location-lightbox' );

				// Adjust the modal header content
				$ekko_lightbox_header.addClass( 'modal-header-wheaton' ); // Add modal-header-wheaton CSS class to modal header
				$ekko_lightbox_header.find( 'button' ).addClass( 'button' ).html( 'Back' ); // Adjust close button label and CSS class
				$ekko_lightbox_header.find( '.modal-title' ).remove(); // Remove title element

				// Adjust the modal footer content
				$ekko_lightbox_footer.addClass( 'modal-footer-wheaton' ).show().html( '' ); // Add modal-footer-wheaton CSS class to modal header, show footer, and remove all content
				$ekko_lightbox_header.find( 'button' ).clone().appendTo( $ekko_lightbox_footer ); // Add the back button
			}
		} );

		/*
		 * Map - List View
		 */
		var $list_view_buttons = $( '.list-view-button' ),
			$list_view = $( '#list-view' ),
			$list_view_locations_wrap = $list_view.find( '.list-view-locations' ),
			$list_view_locations = $list_view_locations_wrap.find( '.list-view-location' ),
			$list_view_locations_categories = $list_view_locations.filter( '.list-view-location-category-name' ),
			$list_view_no_results = $list_view_locations.filter( '.list-view-no-results' ),
			$list_view_filter_sections = $list_view.find( '.list-view-filter' ),
			$list_view_filters = $list_view_filter_sections.find( 'input' );

		// List View button click
		$list_view_buttons.on( 'touch click', function( event ) {
			var $this = $( this );

			// Prevent default
			event.preventDefault();

			// Prevent propagation (bubbling) to other elements
			event.stopPropagation();

			// If the list view is currently closed
			if ( $list_view.hasClass( 'closed' ) ) {
				// Open the list view
				$list_view.removeClass( 'closed' );

				// Change the label of the list view button
				$this.html( $this.data( 'close-label' ) );

				// Adjust the body class
				$body.addClass( 'list-view-open' );
			}
			// Otherwise it is open
			else {
				// Close the list view
				$list_view.addClass( 'closed' );

				// Change the label of the list view button
				$this.html( $this.data( 'open-label' ) );

				// Adjust the body class
				$body.removeClass( 'list-view-open' );
			}
		} );

		// List View category filter change
		$list_view_filters.on( 'change', function( event ) {
			var $self = $( this),
				category;

			// Categories
			if ( $self.hasClass( 'list-view-filter-category' ) ) {
				// Store a reference to the category
				category = $self.val();

				// Loop through list locations
				$list_view_locations.each( function() {
					var $this = $( this );

					// Category match
					if ( $this.hasClass( category ) ) {
						// Checked
						if ( $self.prop( 'checked' ) ) {
							// If this item isn't hidden by search
							if ( ! $this.hasClass( 'search-hidden' ) ) {
								// Remove the hidden and category-hidden classes
								$this.removeClass( 'hidden category-hidden' );
							}
							// Otherwise, if it is hidden by search
							else {
								// Remove the category-hidden class
								$this.removeClass( 'category-hidden' );
							}
						}
						// Unchecked
						else {
							// If this item isn't hidden by search
							if ( ! $this.hasClass( 'search-hidden' ) ) {
								// Add the hidden and category-hidden classes
								$this.addClass( 'hidden category-hidden' );
							}
							// Otherwise, if it is hidden by search
							else {
								// Add the category-hidden class
								$this.addClass( 'category-hidden' );
							}
						}
					}
				} );

				// If no categories are visible, show no results
				if ( ! $list_view_locations_categories.filter( ':visible' ).length ) {
					$list_view_no_results.removeClass( 'hidden' );
				}
				// Otherwise if no results was hidden by category filters, hide no results
				else {
					$list_view_no_results.addClass( 'hidden' );
				}
			}
		} );

		// List View search filter input, keyup, change, search
		$list_view_filters.on( 'input keyup change search', function( event ) {
			var $this = $( this );

			// Search
			if ( $this.hasClass( 'list-view-filter-search' ) ) {
				var search_terms = $this.data( 'search-terms'),
					search_value = $this.val(),
					terms, match, matches = [], non_matches = [];

				// Bail if the cached search term matches the current value
				if ( search_terms === search_value ) {
					return;
				}

				// Store a reference to the search term in jQuery data
				$this.data( 'search-terms', search_value );

				// Update the search terms reference
				search_terms = search_value;

				// If we have terms
				if ( search_terms.length > 0 ) {
					// Escape the term string for RegExp meta characters (these would cause our regex logic to fail)
					terms = search_terms.replace( /[-\/\\^$*+?.()|[\]{}]/g, '\\$&' );

					// Each term is separated by a space, replace spaces with word delimiters
					terms = terms.replace( / /g, ')(?=.*' );

					// Create a new regex object/expression
					match = new RegExp( '^(?=.*' + terms + ').+', 'i' );

					// Loop through list locations
					$list_view_locations.each( function() {
						var $this = $( this ),
							title = $this.data( 'title' );

						// If we have a search term match (location title), skipping category name and no results items
						if ( ! $this.hasClass( 'list-view-location-category-name' ) && ! $this.hasClass( 'list-view-no-results' ) && title && title.match( match ) ) {
							// Add this location to the matches array
							matches.push( $this );

							// If this item isn't hidden by category
							if ( ! $this.hasClass( 'category-hidden' ) ) {
								// Remove the hidden and search-hidden classes
								$this.removeClass( 'hidden search-hidden' );
							}
							// Otherwise, if it is hidden by category
							else {
								// Remove the search-hidden classes
								$this.removeClass( 'search-hidden' );
							}
						}
						// Otherwise if we don't have a search term match (location title), skipping category name and no results items
						else if ( ! $this.hasClass( 'list-view-location-category-name' ) && ! $this.hasClass( 'list-view-no-results' ) ) {
							// Add this location to the non-matches array
							non_matches.push( $this );

							// If this item isn't hidden by category
							if ( ! $this.hasClass( 'category-hidden' ) ) {
								// Add the hidden and search-hidden classes
								$this.addClass( 'hidden search-hidden' );
							}
							// Otherwise, if it is hidden by category
							else {
								// Add the search-hidden classes
								$this.addClass( 'search-hidden' );
							}
						}
					} );

					// If we don't have any matches
					if ( ! matches.length ) {
						// Hide the category name items
						$list_view_locations_categories.addClass( 'hidden search-hidden' );

						// Show the no results item
						$list_view_no_results.removeClass( 'hidden' );
					}
					// Otherwise, if we have matches
					else {
						// Show the category name items
						$list_view_locations_categories.removeClass( 'hidden search-hidden' );

						// Hide the no results item
						$list_view_no_results.addClass( 'hidden' );

						// Loop through list view categories
						$list_view_locations_categories.each( function () {
							var $this = $( this ),
								category = $this.data( 'category' );

							// If the category name is the only element visible with the category CSS class, hide it now
							if ( $list_view_locations.filter( '.' + category + ':visible' ).length === 1 ) {
								$this.addClass( 'hidden search-hidden' );
							}
							// Otherwise show the element if it isn't hidden by a category
							else if ( ! $this.hasClass( 'category-hidden' ) ) {
								$this.removeClass( 'hidden search-hidden' );
							}
							// Otherwise just remove the search-hidden CSS class
							else {
								$this.removeClass( 'search-hidden' );
							}
						} );

						// If by now we have nothing visible in the list view, show no results
						if ( ! $list_view_locations.filter( ':visible' ).length ) {
							// Show the no results item
							$list_view_no_results.removeClass( 'hidden' );
						}
					}
				}
				// Otherwise show all locations that aren't hidden by categories
				else {
					// Loop through list locations
					$list_view_locations.each( function() {
						var $this = $( this );

						// Ignore locations that are hidden via categories
						if ( ! $this.hasClass( 'category-hidden' ) && $this.hasClass( 'search-hidden' ) ) {
							// Show search hidden items
							$this.removeClass( 'hidden search-hidden' );
						}
						else {
							// Remove search-hidden class
							$this.removeClass( 'search-hidden' );
						}
					} );
				}
			}
		} );
   }
  },
  // Home page
  home: {
    init: function() {
      // JavaScript to be fired on the home page
    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
