<?php

/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package WordPress
* @subpackage Furnob
* @since 1.0.0
*/

	remove_action( 'furnob_main_header', 'furnob_main_header_function', 10 );
	remove_action( 'furnob_main_footer', 'furnob_main_footer_function', 10 );

    get_header();

    while ( have_posts() ) : the_post();
        the_content();
    endwhile;

    get_footer();
?>
