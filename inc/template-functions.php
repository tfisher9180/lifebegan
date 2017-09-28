<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package LifeBegan
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function lifebegan_body_classes( $classes ) {
	global $post;
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	if ( isset ( $post->ID ) && get_the_post_thumbnail( $post->ID ) ) {
		$classes[] = 'has-featured-image';
	}

	return $classes;
}
add_filter( 'body_class', 'lifebegan_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function lifebegan_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'lifebegan_pingback_header' );
