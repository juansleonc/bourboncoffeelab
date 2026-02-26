<?php


class klb_widget_klb_product_categories extends WP_Widget { 
	
	// Widget Settings
	function __construct() {
		$widget_ops = array('description' => esc_html__('For Main Shop Page.','furnob-core') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'klb_product_categories' );
		 parent::__construct( 'klb_product_categories', esc_html__('Furnob Product Categories','furnob-core'), $widget_ops, $control_ops );
	}

	// Widget Output
	function widget($args, $instance) {
		if(!is_product_category()){
			extract($args);
			$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
			$exclude = $instance['exclude'];

			echo $before_widget;

			if($title) {
				echo $before_title . $title . $after_title;
			}


			if($exclude == 'all'){
				$terms = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'parent'    => 0,
				) );
			} else {
				$str = $exclude;
		    	$arr = explode(',', $str);
		
				$terms = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'parent'    => 0,
					'exclude'   => $arr,
				) );
			}
			
			wp_enqueue_script( 'klb-widget-product-categories');
			wp_enqueue_style( 'klb-widget-product-categories');
			
			echo '<div class="widget-body">';
			echo '<div class="widget-checkbox-list">';
			echo '<ul>';

			foreach ( $terms as $term ) {
				$term_children = get_term_children( $term->term_id, 'product_cat' );
				
				$checkbox = '';
				if(isset($_GET['filter_cat'])){
					if(in_array($term->term_id, explode(',',$_GET['filter_cat']))){
						$checkbox = 'checked';
					}
				}
				

				echo '<li>';
				echo '<a href="'.esc_url(furnob_get_cat_url($term->term_id)).'" class="product_cat">';
				echo '<input name="product_cat[]" value="'.esc_attr($term->term_id).'" id="'.esc_attr($term->name).'" type="checkbox" '.esc_attr($checkbox).'>';
				echo '<label ><span></span>'.esc_html($term->name).'</label>';
				echo '</a>';
					if($term_children){
						echo '<ul class="children">';
						
						foreach($term_children as $child){
							$childterm = get_term_by( 'id', $child, 'product_cat' );
							$ancestor = get_ancestors( $childterm->term_id, 'product_cat' );
							
							$term_third_children = get_term_children( $childterm->term_id, 'product_cat' );

							$childcheckbox = '';
							if(isset($_GET['filter_cat'])){
								if(in_array($childterm->term_id, explode(',',$_GET['filter_cat']))){ 
									$childcheckbox .= 'checked';
								}
							} 
							
							if($childterm->parent && (sizeof($term_third_children)>0)){
								echo '<li>';
								echo '<a href="'.esc_url( furnob_get_cat_url($childterm->term_id)).'">';
								echo '<input name="product_cat[]" value="'.esc_attr($childterm->term_id).'" id="'.esc_attr($childterm->name).'" type="checkbox" '.esc_attr($childcheckbox).'>';
								echo '<label><span></span>'.esc_html($childterm->name).'</label>';
								echo '</a>';
								if($term_third_children){
									
									echo '<ul class="children">';
									foreach($term_third_children as $third_child){
										$thirdchildterm = get_term_by( 'id', $third_child, 'product_cat' );
										$thirdchildthumbnail_id = get_term_meta( $thirdchildterm->term_id, 'thumbnail_id', true );
										$thirdchildimage = wp_get_attachment_url( $thirdchildthumbnail_id );
										
										$thirdchildcheckbox = '';
										if(isset($_GET['filter_cat'])){
											if(in_array($thirdchildterm->term_id, explode(',',$_GET['filter_cat']))){ 
												$thirdchildcheckbox .= 'checked';
											}
										} 
										
										echo '<li>';
										echo '<a href="'.esc_url( furnob_get_cat_url($thirdchildterm->term_id)).'">';
										echo '<input name="product_cat[]" value="'.esc_attr($thirdchildterm->term_id).'" id="'.esc_attr($thirdchildterm->name).'" type="checkbox" '.esc_attr($thirdchildcheckbox).'>';
										echo '<label><span></span>'.esc_html($thirdchildterm->name).'</label>';
										echo '</a>';
										echo '</li>';
									}
									echo '</ul>';
								}
								
								echo '</li>';
							} elseif (sizeof($ancestor) == 1) {
								echo '<li>';
								echo '<a href="'.esc_url( furnob_get_cat_url($childterm->term_id)).'">';
								echo '<input name="product_cat[]" value="'.esc_attr($childterm->term_id).'" id="'.esc_attr($childterm->name).'" type="checkbox" '.esc_attr($childcheckbox).'>';
								echo '<label><span></span>'.esc_html($childterm->name).'</label>';
								echo '</a>';
								echo '</li>';
							}
					
						}
						echo '</ul>';
					} 
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';
			echo '</div>';


			echo $after_widget;
		}
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['exclude'] = strip_tags($new_instance['exclude']);
		
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => 'Product Categories', 'exclude' => 'All');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','furnob-core'); ?></label>
			<input class="widefat"  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php esc_html_e('Exclude id:','furnob-core'); ?></label>
			<input class="widefat"  id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" value="<?php echo $instance['exclude']; ?>" />
		</p>

	<?php
	}
}

// Add Widget
function klb_widget_klb_product_categories_init() {
	register_widget('klb_widget_klb_product_categories');
}
add_action('widgets_init', 'klb_widget_klb_product_categories_init');

?>