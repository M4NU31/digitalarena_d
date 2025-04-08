<?php


/**
 * Enable ALB for All Post Types
 */
function punch_child_enable_alb_for_cpts() {
	return array( 'portfolio', 'page', 'product', 'template_part', 'tribe_events', 'post' );
}
add_filter( 'avf_alb_supported_post_types', 'punch_child_enable_alb_for_cpts' );

/**
 * Enable Gutenberg per post type
 */
function punch_child_gutenberg( $new_use_block_editor, $use_block_editor, $post_type ) {
	$gutenberg_post_types = array( 'post', 'review', 'guia' );

	return in_array( $post_type, $gutenberg_post_types ) ? true : false;
}
add_filter( 'avf_can_use_block_editor_for_post_type', 'punch_child_gutenberg', 100, 3 );

/**
 * Default Icons Hook
 */
function punch_child_default_icons( $icons ) {
	$icons['next'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
    $icons['prev'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
    $icons['next_big'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
    $icons['prev_big'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
	$icons['close'] = array( 'font' => 'fa-fontello', 'icon' => 'ue801' );

	return $icons;
}
add_filter( 'avf_default_icons', 'punch_child_default_icons', 10, 1 );

/**
 * Disables Enfold Burger addition to nav
 */
if( !function_exists( 'avia_append_burger_menu' ) ) {
	add_filter( 'wp_nav_menu_items', 'avia_append_burger_menu', 9998, 2 );
	add_filter( 'avf_fallback_menu_items', 'avia_append_burger_menu', 9998, 2 );
	function avia_append_burger_menu ( $items , $args ) {
		return $items;
	}
}

/**
 * Disables Enfold Search addition to nav
 */
if( !function_exists( 'avia_append_search_nav' ) ) {
	add_filter( 'wp_nav_menu_items', 'avia_append_search_nav', 9997, 2 );
	add_filter( 'avf_fallback_menu_items', 'avia_append_search_nav', 9997, 2 );
	function avia_append_search_nav ( $items, $args ) {
	    return $items;
	}
}

/**
 * Disables Enfold Avia Title + Breadcrumbs
 */
if( !function_exists( 'avia_title' ) ) {
	function avia_title() {}
}

/**
 * Disables Enfold Post Navigation
 */
if( !function_exists( 'avia_post_nav' ) ) {
	function avia_post_nav() {}
}

/**
 * Disable Hide Featured Image Meta
 */
if( !function_exists( 'avia_add_hide_featured_image_select' ) ) {
	function avia_add_hide_featured_image_select() {}
}

/**
 * Disable enfold query overrides on archive view
 */
if( ! function_exists( 'avia_fix_tag_archive_page' ) ) {
	function avia_fix_tag_archive_page() {}
}

/**
 * Disable Image Sizes
 * This hook will disable Enfold image sizes
 */
function punch_child_disable_image_sizes() {
	remove_image_size( '1536x1536' );	
	remove_image_size( '2048x2048' );
}
add_action( 'init', 'punch_child_disable_image_sizes', 11 );



/**
 * The Events Calendar Template Override
 */
add_action('after_setup_theme', function() {

	if( is_child_theme() ) remove_action('tribe_events_template', 'avia_events_template_paths', 10, 2 );

});

add_action('tribe_events_template', 'avia_events_template_paths_mod', 10, 2);

function avia_events_template_paths_mod( $file, $template ) {

	$redirect = array('default-template.php');

	if(in_array($template, $redirect)) {
		$file = get_stylesheet_directory() . "/tribe-events/views/" . $template;
	}

	return $file;

} 