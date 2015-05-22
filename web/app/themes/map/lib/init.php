<?php
/**
 * Roots initial setup and constants
 */
function roots_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'roots', get_template_directory() . '/lang' );

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus( array(
		'primary_navigation' => __( 'Primary Navigation', 'roots' ),
	) );

	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support( 'post-thumbnails' );
	// set_post_thumbnail_size(150, 150, false);
	// add_image_size('category-thumb', 300, 9999); // 300px wide (and unlimited height)

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	// add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style( '/assets/css/editor-style.css' );

	// Add Image Sizes
	add_image_size( 'location-featured-image', 1920, 9999, false ); // Featured Image for Single Locations
}

add_action( 'after_setup_theme', 'roots_setup' );


/**
 * Enqueue scripts and stylesheets
 */
add_action('wp_enqueue_scripts', 'wheaton_wp_enqueue_scripts', 120); // After Roots

function wheaton_wp_enqueue_scripts() {
	// Wheaton Map
	wp_enqueue_style( 'wheaton-map', get_template_directory_uri() . '/assets/css/map.css', array( 'roots_main' ) );
}