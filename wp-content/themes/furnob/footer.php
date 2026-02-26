<?php
/**
 * footer.php
 * @package WordPress
 * @subpackage Furnob
 * @since Furnob 1.0
 * 
 */
 ?>

		</div><!-- site-content -->
	</main><!-- site-primary -->

	<?php furnob_do_action( 'furnob_before_main_footer'); ?>

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>
		<?php
        /**
        * Hook: furnob_main_footer
        *
        * @hooked furnob_main_footer_function - 10
        */
        do_action( 'furnob_main_footer' );
	
		?>
	<?php } ?>

	<?php furnob_do_action( 'furnob_after_main_footer'); ?>

	<div class="site-mask"></div>

	<?php wp_footer(); ?>
	</body>
</html>