<?php 
/**
 * Highlight search terms.
 *
 * This function will highlight any text that matches the term that
 * was searched.
 *
 * @since 4.0.0
 *
 * @link http://www.grafipress.co.za
 *
 */
if ( ! function_exists( 'grafipress_highlight_search_term' ) ) { 
	function grafipress_highlight_search_term( $text ){
	    if( is_search() ) {
			$keys = implode( '|', explode(' ', get_search_query() ) );
			$text = preg_replace( '/(' . $keys .')/iu', '<span class="search-term">\0</span>', $text );
		}
	    return $text;
	}
	add_filter( 'the_excerpt', 'grafipress_highlight_search_term' );
	add_filter( 'the_title', 'grafipress_highlight_search_term' );
	apply_filters( 'the_content', 'grafipress_highlight_search_term' );
}

/**
 * Search autofocus
 *
 * This function sets the autofocus attribute on certain
 * situations for a search form.
 *
 * @since 4.0.0
 * @link http://www.grafipress.co.za
 */
if( ! function_exists( 'grafipress_search_autofocus') ) {
	function grafipress_search_autofocus() {
		if( is_404() ) {
			$autofocus = 'autofocus';
			//$placeholder = 'Please try searching for it instead. Hit enter to begin search';
		} else {
			$autofocus = '';
			//$placeholder = 'Search...';
		}
	echo $autofocus;
	}
}

/**
 * Search palceholder
 *
 * This function sets the placeholder attribute on certain
 * situations for a search form.
 *
 * @since 4.0.0
 * @link http://www.grafipress.co.za
 */
if( ! function_exists( 'grafipress_search_placeholder') ) {
	function grafipress_search_placeholder() {
		if( is_404() ) {
			//$autofocus = 'autofocus';
			$placeholder = __( 'Maybe try a search?', 'gws' );
		} else {
			//$autofocus = '';
			$placeholder = __( 'Search...', 'gws' );
		}
	echo $placeholder;
	}
} 

/**
 * Generate dynamic search result page heading.
 *
 * This function will return the count of all search results
 * as well as the rest of the page heading for the search page.
 *
 * @since 4.0.0
 *
 * @link http://www.grafipress.co.za
 *
 */
if( !function_exists( 'grafipress_search_heading') ) {
	function grafipress_search_heading() {
		global $wp_query; 

		$total_results = $wp_query->found_posts; 

		if( (int)$total_results > 1 ) {
			$grafipress_plural = 's';			
		} else {
			$grafipress_plural = '';
		}

		printf( __( '%s Search result%s found for %s', 'gws' ), $total_results, $grafipress_plural, '<span class="search-term">"' . get_search_query() . '"</span>' );
	}
}

/**
 * Search auto-redirect.
 *
 * This function will count search results and if only one
 * result is found it will automatically redirect to the result.
 *
 * @since 1.0.0
 * @package Wordpress
 * @subpackage G12
 * @link http://www.grafipress.co.za
 */
if( ! function_exists( 'grafipress_search_redirect' ) ) {
	function grafipress_search_redirect() {
	    if ( is_search() ) {
	        global $wp_query;
	        if ( $wp_query->post_count == 1 && $wp_query->max_num_pages == 1 ) {
	        	wp_redirect( get_permalink( $wp_query->posts[ '0' ]->ID ) );
	            exit;
	        }
	    }
	}
	add_action( 'template_redirect', 'grafipress_search_redirect' );
}