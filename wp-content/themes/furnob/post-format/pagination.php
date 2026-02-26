<?php 

$pages = paginate_links();

if($pages){
	global $wp_query, $wp_rewrite;


    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $url_parts    = explode( '?', $pagenum_link );
 
    // Get max pages and current page out of the current query, if available.
    $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
 
    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
 
    // URL base depends on permalink settings.
    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';


	$args = array(
		'base'               => $pagenum_link,
		'format'             => $format,
		'total'              => $wp_query->max_num_pages,
		'current' 			 => $current,
		'aria_current'       => 'page',
		'show_all'           => false,
		'end_size'           => 1,
		'mid_size'           => 1,
		'prev_next'          => true,
		'prev_text'          => '<i class="klbth-icon-left-open-big"></i>',
		'next_text'          => '<i class="klbth-icon-right-open-big"></i>',
		'type'               => 'list',
		'add_args'           => false,
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => ''
	); 

?>

<div class="col col-12">
	<div class="site-pagination">
		<?php echo paginate_links( $args ) ?>
	</div>
</div>

<?php } ?>