<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
			<div id="hero">
				<?php if (has_post_thumbnail( $post->ID ) ): ?>
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
					<img src="<?= $image[0]; ?>" alt="<?= get_the_title(); ?>" />
					<div id="pulldown">
						<a href="#main">Details &amp; Photos</a>
					</div>
				<?php endif; ?>
			</div>
    </header>
		<div class="container-fluid">
	    <main class="entry-content col-sm-9">
	      <h2 class="entry-title"><?php the_title(); ?></h2>
				<p><?= get_field('description'); ?>
				<!--Directory-->
   	 	</main>
			<aside class="col-sm-3">
				<a href="//wheatoncollege.edu/admissions" target="_blank" class="button" />Schedule a campus tour</a>
				<div class="factbox">
					<?php if( have_rows('quick_facts') ): ?>
						<h3>Quick Facts</h3>
						<ul id="quickfacts">
				    	<?php while ( have_rows('quick_facts') ) : the_row(); ?>
								<li><?=get_sub_field('fact'); ?>
				    	<?php endwhile; ?>
						</ul>
				 	<?php endif; ?>
					<b>Features: </b><?= get_field('features'); ?>
					<?php if( have_rows('contact_info') ): ?>
						<h4>Contact Information</h4>
						<ul id="contact-info">
				    	<?php while ( have_rows('contact_info') ) : the_row(); ?>
								<li><a href="<?=(get_sub_field('type') === 'Phone') ? 'tel:' : 'mailto:'; ?><?=get_sub_field('value');?>">
									<?=(get_sub_field('type') === 'Phone') ? '<i class="fa fa-phone"></i>' : '<i class="fa fa-envelope"></i>'; ?> <?=get_sub_field('name'); ?>
								</a>
				    	<?php endwhile; ?>
						</ul>
				 	<?php endif; ?>

				</div>
				<?php if( have_rows('hours') ): ?>
					<div id="hours">
						<h4>Building Hours</h4>
				    <?php while ( have_rows('hours') ) : the_row(); ?>
        			<p><b>Monday: </b> <?= get_sub_field('monday'); ?></p>
        			<p><b>Tuesday: </b> <?= get_sub_field('tuesday'); ?></p>
        			<p><b>Wednesday: </b> <?= get_sub_field('wednesday'); ?></p>
        			<p><b>Thursday: </b> <?= get_sub_field('thursday'); ?></p>
        			<p><b>Friday: </b> <?= get_sub_field('friday'); ?></p>
        			<p><b>Saturday: </b> <?= get_sub_field('saturday'); ?></p>
        			<p><b>Sunday: </b> <?= get_sub_field('sunday'); ?></p>
				    <?php endwhile; ?>
					</div>
				<?php endif; ?>
			</aside>
		</div>
		<?php $images = get_field('photo_gallery');
		if( $images ): ?>
			<div id="gallery">
        <?php foreach( $images as $image ): ?>
					<div class="photo col-xs-12 col-sm-6">
	        	<a href="<?php echo $image['url']; ?>">
  	        	<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
    	      </a>
						<div class="meta">
		          <p><?php echo $image['caption']; ?></p>
							<a href="#" class="enlarge button hidden-xs" rel="nofollow"><i class="fa fa-search-plus"></i> View Larger</a>
						</div>
					</div>
        <?php endforeach; ?>
			</div>
		<?php endif; ?>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
  </article>
<?php endwhile; ?>
