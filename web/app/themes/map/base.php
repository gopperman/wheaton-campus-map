<?php if (array_key_exists('json', $_GET)) {
	get_template_part('templates/json');
} else { 
	if (!array_key_exists('lightbox', $_GET)) get_template_part('templates/head'); ?>
	<body <?php body_class(); ?>>

  	<!--[if lt IE 8]>
    	<div class="alert alert-warning">
      	<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    	</div>
  	<![endif]-->

	  <?php
  	  do_action('get_header');
    	// Use Bootstrap's navbar if enabled in config.php
    	if (current_theme_supports('bootstrap-top-navbar')) {
      	get_template_part('templates/header-top-navbar');
    	} else {
      	get_template_part('templates/header');
    	}
  	?>

    <?php include roots_template_path(); ?>

  	<?php get_template_part('templates/footer'); ?>

	</body>
	</html>
<?php } ?>
