<?php if (is_front_page()) { ?>
<header class="banner navbar navbar-default navbar-static-top" role="banner">
  <div class="container-fluid">
    <div class="navbar-header">
	    <a href="#" class="button list-view-button" data-close-label="Close" data-open-label="List">List</a>
<!--      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>-->
      <a class="navbar-brand" href="<?php echo home_url(); ?>/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/wheaton-logo.png" width="323" height="68" alt="Wheaton College Logo" /></a>
    </div>

    <nav class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>
		<div id="ctas">
			<div class="social" class="hidden-xs hidden-sm">
				<a href="https://www.facebook.com/WheatonCollege" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>
				<a href="https://twitter.com/wheaton" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>
				<a href="https://instagram.com/wheatoncollege" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a>
			</div>
			<a class="button" href="http://wheatoncollege.edu/admission/visit-campus/">Visit Campus</a>
		</div>
  </div>
</header>
<? } ?>