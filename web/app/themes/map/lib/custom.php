<?php
/**
 * Custom functions
 */
function create_locations() {
	//Register custom Locations post type
  $location_args = array(
    'public'              =>  true,
    'label'               =>  'Locations',
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_admin_bar'   => true,
		'show_in_nav_menus'		=> true,
    'show_in_menu'        => true,
    'query_var'           => true,
    'rewrite'             => array( 'slug' => 'location' ),
    'capability_type'     => 'post',
    'has_archive'         => true,
    'hierarchical'        => true,
    'menu_position'       => 4,
		'taxonomies'					=> array('category', 'post_tag'),
    'supports'            => array( 'custom-fields', 'revisions', 'title', 'editor', 'author', 'thumbnail', 'excerpt')
  );
	if (!post_type_exists( 'location' ) ) {
	  register_post_type( 'location', $location_args);
	} else {
   echo 'the post type does exist';
	}
}

add_action('init', 'create_locations');


/*
 * This function adds a "lightbox" rewrite endpoint.
 */
add_action( 'init', 'wheaton_map_add_lightbox_endpoint' );

function wheaton_map_add_lightbox_endpoint() {
	add_rewrite_endpoint( 'lightbox', EP_PERMALINK ); // http://example.com/permalink/lightbox/
}

/**
 * This function modifies the request to ensure the above URL Endpoint functions as we desire.
 */
add_filter( 'request', 'wheaton_map_request' );

function wheaton_map_request( $request ) {
	// Check to make sure our endpoint is set
	if ( isset( $request['lightbox'] ) )
		$request['lightbox'] = true;

	return $request;
}

/**
 * This function flushes the rewrite rules to ensure the endpoint registered above functions properly on activation.
 */
add_action( 'after_switch_theme', 'wheaton_map_after_switch_theme' );

function wheaton_map_after_switch_theme() {
	flush_rewrite_rules();
}

/* Custom Fields */
//include "fields.php";
?>
