<div class="klb-shop-banner page-header">
	<div class="container">
		<h1 class="entry-title"><?php the_archive_title(); ?></h1>
		<div class="shop-page-header--categories">
			<ul>
				
				<?php $term_children = get_term_children( get_queried_object()->term_id, 'product_cat' ); ?>
				<?php if($term_children){ ?>
					<?php foreach($term_children as $child){ ?>
						<?php $childterm = get_term_by( 'id', $child, 'product_cat' ); ?>
						<li><a href="<?php echo esc_url(get_term_link( $child )); ?>"><?php echo esc_html($childterm->name); ?></a></li>
					<?php } ?>
				<?php } ?>
					
			</ul>
		</div>
	</div><!-- container -->
</div><!-- page-header -->

