<?php if (is_front_page()) { ?>
<footer class="content-info" role="contentinfo">
  <div class="container-fluid">
		&copy; <?= date("Y") ?> <a href="//wheatoncollege.edu">Wheaton College</a>
		<div class="social" class="hidden-xs">
    	<a href="https://www.facebook.com/WheatonCollege" target="_blank"><i class="fa fa-facebook"></i></a>
      <a href="https://twitter.com/wheaton" target="_blank"><i class="fa fa-twitter"></i></a>
      <a href="https://instagram.com/wheatoncollege" target="_blank"><i class="fa fa-instagram"></i></a>
    </div>
  </div>
</footer>
<?php } ?>

<?php wp_footer(); ?>
