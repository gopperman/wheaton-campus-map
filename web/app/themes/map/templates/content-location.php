<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?> itemscope itemtype="http://schema.org/Place">
    <header>
			<?php if (has_post_thumbnail( $post->ID ) ): ?>
				<div id="hero" itemscope itemprop="photo" itemtype="http://schema.org/ImageObject">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'location-featured-image' ); ?>
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
		    <div class="categories">
			    <?php
				    $categories = get_the_category();
			        $cat_names = array();

			        // Loop through categories
			        foreach ( $categories as $category )
				        // Add the name to our list
				        $cat_names[] = $category->name;

			        // Implode the list for output
			        echo implode( ', ', $cat_names );
			    ?>
		    </div>
				<div id="description" itemprop="description"><?= get_field('description'); ?></div>
				<?php if( have_rows('directory') ): ?>
        	<h3 class="section-title">Building Departments</h3>
          <ul id="directory" class="cf">
            <?php while ( have_rows('directory') ) : the_row(); ?>
              <li><a href="<?= get_sub_field('link'); ?>" target="_blank"><?=get_sub_field('name'); ?></a>
            <?php endwhile; ?>
					</ul>
				<?php endif; ?>
   	 	</main>
			<aside class="col-sm-3">
				<a href="//wheatoncollege.edu/admission" target="_blank" class="button">Schedule Your Campus Tour</a>
				<div class="factbox">
					<?php if( have_rows('quick_facts') ): ?>
						<h3 class="section-title">Building Features</h3>
						<ul id="quickfacts">
				    	<?php while ( have_rows('quick_facts') ) : the_row(); ?>
								<li><?=get_sub_field('fact'); ?>
				    	<?php endwhile; ?>
						</ul>
				 	<?php endif; ?>
					<?php if( have_rows('contact_info') ): ?>
						<div id="contact-info">
							<h3 class="section-title">Contact Information</h3>
				    	<?php while ( have_rows('contact_info') ) : the_row(); ?>
								<div class="contact">
									<h4><?= get_sub_field('name'); ?></h4>
									<?php if (get_sub_field('phone') != '') { ?>
										<p><a href="tel:<?= get_sub_field('phone'); ?>">Call <span itemprop="telephone"><?= get_sub_field('phone'); ?></span></a></p>
									<?php } ?>
									<?php if (get_sub_field('email') != '') { ?>
										<p><a href="mailto:<?= get_sub_field('email'); ?>">Email <?= get_sub_field('name'); ?></a></p>
									<?php } ?>
									<?php if ( get_sub_field( 'more_info' ) != '' ) : ?>
										<p><a href="<?= esc_url( get_sub_field( 'more_info' ) ); ?>" class="more-info" target="_blank">More Information</a></p>
									<?php endif; ?>
								</div>
				    	<?php endwhile; ?>
						</div>
				 	<?php endif; ?>
				</div>
			</aside>
		</div>
		<?php
			$images = get_field('photo_gallery');
			if( $images ):
				// Keep track of images output
				$image_num = 0;
		?>
			<div id="gallery">
				<?php
					foreach ( $images as $image ) :
						// Increase the count
						$image_num++;
				?>
					<?php if ( $image_num % 2 ) : // Odd Images only ?>
						<div class="clearfix">
					<?php endif; ?>

					<div class="photo col-xs-12 col-sm-6" itemscope itemprop="photo" itemtype="http://schema.org/ImageObject">
						<a href="<?php echo $image['url']; ?>">
							<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" itemprop="contentURL" />
						</a>
						<div class="meta">
							<p><?php echo $image['caption']; ?></p>
							<a href="#" class="enlarge button hidden-xs" rel="nofollow"><i class="fa fa-search-plus"></i> View Larger</a>
						</div>
					</div>

					<?php if ( $image_num % 2 === 0 ) : // Even Images only ?>
						</div>
					<?php endif; ?>
				<?php
					endforeach;
				?>

				<?php
					// Close the clearfix if there was an odd amount of images only, otherwise it remains open
					if ( count( $images ) % 2 ) :
				?>
					</div>
				<?php
					endif;
				?>
			</div>
		<?php
			endif;
		?>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
  </article>
<?php endwhile; ?>
