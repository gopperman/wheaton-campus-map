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
