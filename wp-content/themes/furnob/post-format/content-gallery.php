<article id="post-<?php the_ID(); ?>" <?php post_class('klb-article post'); ?>>
	<figure class="entry-media">
		<?php $images = rwmb_meta( 'klb_blogitemslides', 'type=image_advanced&size=medium' ); ?>
		<?php if($images) { ?>
			
			<div class="blog-gallery">
				<?php  foreach ( $images as $image ) { ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<img src="<?php echo esc_url($image['full_url']); ?>" alt="<?php the_title_attribute(); ?>">
					</a>
				<?php } ?>
			</div>
		<?php } ?>
	</figure>
	<div class="entry-wrapper">
		<div class="entry-meta">
			<div class="meta-item entry-published"><a href="<?php the_permalink(); ?>"> <?php echo get_the_date(); ?></a></div>
			
			<?php if(has_category()){ ?>
				<div class="entry-category">
					<?php the_category(' '); ?>
				</div><!-- entry-category -->
			<?php } ?>

			<?php the_tags( '<div class="meta-item entry-tags">', ', ', ' </div>'); ?>
			
			<?php if ( is_sticky()) {
				printf( '<div class="meta-item sticky-post">%s</div>', esc_html__('Featured', 'furnob' ) );
			} ?>
		</div>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry-content">
			<div class="klb-post">
				<?php the_excerpt(); ?>
				<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'furnob' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
			</div>
		</div><!-- entry-content -->
	</div><!-- entry-wrapper -->
</article><!-- post -->