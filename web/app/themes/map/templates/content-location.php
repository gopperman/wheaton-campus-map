<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?> itemscope itemtype="http://schema.org/Place">
    <header>
			<?php if (has_post_thumbnail( $post->ID ) ): ?>
				<div id="hero" itemscope itemprop="photo" itemtype="http://schema.org/ImageObject">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
					<img src="<?= $image[0]; ?>" alt="<?= get_the_title(); ?>" itemprop="contentURL"/>
					<div id="pulldown">
						<a href="#main">Details &amp; Photos</a>
					</div>
				</div>
			<?php endif; ?>
    </header>
		<div class="container-fluid">
	    <main id="main" class="entry-content col-sm-9">
	      <h2 class="entry-title" itemprop="name"><?php the_title(); ?></h2>
				<div id="description" itemprop="description"><?= get_field('description'); ?></div>
				<?php if( have_rows('directory') ): ?>
        	<h3>Building Directory</h3>
          <ul id="directory">
            <?php while ( have_rows('directory') ) : the_row(); ?>
              <li><a href="<?= get_sub_field('link'); ?>" target="_blank"><?=get_sub_field('name'); ?></a>
            <?php endwhile; ?>
					</ul>
				<?php endif; ?>
   	 	</main>
			<aside class="col-sm-3">
				<a href="//wheatoncollege.edu/admission" target="_blank" class="button" />Schedule a campus tour</a>
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
						<div id="contact-info">
							<h3>Contact Information</h3>
				    	<?php while ( have_rows('contact_info') ) : the_row(); ?>
								<div class="contact">
									<h4><?= get_sub_field('name'); ?></h4>
									<?php if (get_sub_field('phone') != '') { ?>
										<p itemprop="telephone"><a href="tel:<?= get_sub_field('phone'); ?>"><i class="fa fa-phone"></i> <?= get_sub_field('phone'); ?></a></p>
									<?php } ?>
									<?php if (get_sub_field('email') != '') { ?>
										<p><a href="mailto:<?= get_sub_field('email'); ?>"><i class="fa fa-envelope"></i> Email <?= get_sub_field('name'); ?></a></p>
									<?php } ?>
								</div>
				    	<?php endwhile; ?>
						</div>
				 	<?php endif; ?>

				</div>
				<?php if( have_rows('hours') ): ?>
					<div id="hours">
						<h4>Building Hours</h4>
				    <?php while ( have_rows('hours') ) : the_row(); ?>
        			<p itemprop="openingHours" content="Mo <?=get_sub_field('monday'); ?>"><b>Monday: </b> <?= get_sub_field('monday'); ?></p>
        			<p itemprop="openingHours" content="Tu <?=get_sub_field('tuesday'); ?>"><b>Tuesday: </b> <?= get_sub_field('tuesday'); ?></p>
        			<p itemprop="openingHours" content="We <?=get_sub_field('wednesday'); ?>"><b>Wednesday: </b> <?= get_sub_field('wednesday'); ?></p>
        			<p itemprop="openingHours" content="Th <?=get_sub_field('thursday'); ?>"><b>Thursday: </b> <?= get_sub_field('thursday'); ?></p>
        			<p itemprop="openingHours" content="Fr <?=get_sub_field('friday'); ?>"><b>Friday: </b> <?= get_sub_field('friday'); ?></p>
        			<p itemprop="openingHours" content="Sa <?=get_sub_field('saturday'); ?>"><b>Saturday: </b> <?= get_sub_field('saturday'); ?></p>
        			<p itemprop="openingHours" content="Su <?=get_sub_field('sunday'); ?>"><b>Sunday: </b> <?= get_sub_field('sunday'); ?></p>
				    <?php endwhile; ?>
					</div>
				<?php endif; ?>
			</aside>
		</div>
		<?php $images = get_field('photo_gallery');
		if( $images ): ?>
			<div id="gallery">
        <?php foreach( $images as $image ): ?>
					<div class="photo col-xs-12 col-sm-6" itemscope itemprop="photo" itemtype="http://schema.org/ImageObject">
	        	<a href="<?php echo $image['url']; ?>">
  	        	<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" itemprop="contentURL" />
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
