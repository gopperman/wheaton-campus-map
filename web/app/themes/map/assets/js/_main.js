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

			console.log('ok');
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
			$('a[href*=#]:not([href=#])').click(function() {
				if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
					var target = $(this.hash);
					target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
					if (target.length) {
						$('html,body').animate({
							scrollTop: target.offset().top
						}, 600);
						return false;
					}
				}
			});

		// Ekko Lightbox
		$document.delegate( '*[data-toggle="lightbox"]', 'click', function( event ) {
			// Prevent default
			event.preventDefault();

			// Add Lightbox
			jQuery( this ).ekkoLightbox( {
				left_arrow_class: '.glyphicon .glyphicon-menu-left',
				right_arrow_class: '.glyphicon .glyphicon-menu-right'
			} );
		} );

		/*
		 * Map - List View
		 */
		var $list_view_button = $( '.list-view-button' ),
			$list_view = $list_view_button.parent(),
			$list_view_locations_wrap = $list_view.find( '.list-view-locations' ),
			$list_view_locations = $list_view_locations_wrap.find( '.list-view-location' ),
			$list_view_filter_sections = $list_view.find( '.list-view-filter' ),
			$list_view_filters = $list_view_filter_sections.find( 'input' );

		// List View button click
		$list_view_button.on( 'touch click', function( event ) {
			// Prevent default
			event.preventDefault();

			// Prevent propagation (bubbling) to other elements
			event.stopPropagation();

			// If the list view is currently closed
			if ( $list_view.hasClass( 'closed' ) ) {
				// Open the list view
				$list_view.removeClass( 'closed' );

				// Change the label of the list view button
				$list_view_button.html( $list_view_button.data( 'close-label' ) );

				// Adjust the body class
				$body.addClass( 'list-view-open' );
			}
			// Otherwise it is open
			else {
				// Close the list view
				$list_view.addClass( 'closed' );

				// Change the label of the list view button
				$list_view_button.html( $list_view_button.data( 'open-label' ) );

				// Adjust the body class
				$body.removeClass( 'list-view-open' );
			}
		} );

		// Document click
		$document.on( 'touch click', function( event ) {
			// Close the list view
			$list_view.addClass( 'closed' );

			// Change the label of the list view button
			$list_view_button.html( $list_view_button.data( 'open-label' ) );

			// Adjust the body class
			$body.removeClass( 'list-view-open' );
		} );

		// List View location links click
		$list_view_locations_wrap.on( 'touch click', function( event ) {
			// Prevent propagation (bubbling) to other elements
			event.stopPropagation();
		} );

		// List View filter click
		$list_view_filter_sections.on( 'touch click', function( event ) {
			// Prevent propagation (bubbling) to other elements
			event.stopPropagation();
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
							$this.removeClass( 'hidden category-hidden' );
						}
						// Unchecked
						else {
							$this.addClass( 'hidden category-hidden' );
						}
					}
				} );
			}
		} );

		// List View search filter input, keyup, change, search
		$list_view_filters.on( 'input keyup change search', function( event ) {
			var $this = $( this );

			// Search
			if ( $this.hasClass( 'list-view-filter-search' ) ) {
				// TODO
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
