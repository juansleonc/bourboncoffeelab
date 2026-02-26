<article id="post-<?php the_ID(); ?>" <?php post_class('single-post post'); ?>>
	<figure class="entry-media embed-responsive embed-responsive-16by9">
	   <?php echo get_post_meta($post->ID, 'klb_blogaudiourl', true); ?>
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
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'furnob' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
			</div>
		</div><!-- entry-content -->
	</div><!-- entry-wrapper -->
</article><!-- post -->