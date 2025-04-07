<?php

/**
 * Debug mode
 */
function punch_child_debug_mode(){
	return THEME_ENV == "dev" ? "debug" : "";
}
add_action( 'avia_builder_mode', 'punch_child_debug_mode' );

/**
 * BE Media from production hook, needed for local dev
 */
function punch_child_prefix_production_url( $url ) {
	return REMOTE_URL;
}
add_filter( 'be_media_from_production_url', 'punch_child_prefix_production_url' );

/**
 * Google Fonts Hook
 */
function punch_child_custom_google_fonts( $fonts ){
	// $fonts["Roboto"] = "Roboto:300,400,700";
	return $fonts;  
}
add_filter( 'avf_google_heading_font', 'punch_child_custom_google_fonts', 10, 2 );
add_filter( 'avf_google_content_font', 'punch_child_custom_google_fonts', 10, 2 );

/**
 * Avia Shortcodes Hook
 */
function punch_child_shortcodes( $paths ) {
	/* Note: if using a table.php replacement, you may want to run this at 20 priority so it loads before Enfold plus */
	$child_path = THEME_INCLUDES . "avia-shortcodes/";
	array_unshift( $paths, $child_path );

	return $paths;
}
add_filter( 'avia_load_shortcodes', 'punch_child_shortcodes', 21, 1 );

/**
 * Hook into Sidebar options for custom header options
 */
function punch_child_layout_elements( array $elements ) {
	foreach( $elements as $key => $element ) {

		switch($element['id']){
			case 'layout':
			case 'sidebar':
			case 'header_title_bar':
			case 'header_transparency':
			unset( $elements[$key] );
			break;
		}

	}

	$elements[] = array(
		"slug"  => "layout",
		"name"  => __( "Header Coloring",'avia_framework' ),
		"id"    => "header_color",
		"desc"  => "Set header style for this Page",
		"type"  => "select",
		"std"   => "",
		"class" => "avia-style",
		"subtype" => array( 
							__("Default",'avia_framework') => '',
							__('Alternate','avia_framework') => 'is-alternate',

				)
		);

	$elements[] = array(
			"slug"  => "layout",
			"name"  => __( "Announcement Banner",'avia_framework' ),
			"id"    => "announcement_banner",
			"desc"  => "Enables Announcement Banner for this Page",
			"type"  => "select",
			"std"   => "",
			"class" => "avia-style",
			"subtype" => array(
								__("Disable",'avia_framework') => '',
								__('Enable','avia_framework') => 'enabled',
		
					)
			);

	return $elements;
}
add_filter( 'avf_builder_elements', 'punch_child_layout_elements', 10001, 1 );


/**
 * Set alternate header to all archive views
 */
function punch_child_header_class( $class ) {
	// if ( is_archive() ) $class .= ' is-alternate';

	if( is_singular() ) {
		$post_id = get_the_ID();
		if( get_post_meta( $post_id, 'announcement_banner', true ) == 'enabled' ) {
			$class .= ' has-bar';
		}
	}

	return $class;
}
add_filter( 'avf_header_class_filter', 'punch_child_header_class' );

/**
 * Hook to add/modify Theme Options fields
 */
function punch_child_option_page_data_init( $elements ){
	/**
	 * Announcement Bar Field adding to Theme Options
	 */
	$elements[] =	array(
		"name" 	=> __( "Announcement Banner", 'avia_framework' ),
		"id" 	=> "announcement_banner",
		"type" 	=> "text",
		"slug"	=> "avia"
  	);
	return $elements;
}
add_filter( 'avf_option_page_data_init', 'punch_child_option_page_data_init' );

/** 
 * Replaces href value on Menu items linking to # in with javascript:void(0)
 */
function punch_child_menu_items_replace_hash( $menu_item ) {
	// Ignore non-link items
	if ( strpos( $menu_item, '<a ') === false ) {
		return $menu_item;
	}

	$menu_item = str_replace( '<a', '<a class="menu-item-inner"', $menu_item );

	if ( strpos( $menu_item, 'href="' ) === false || strpos( $menu_item, 'href="#"' ) !== false ) {
		$menu_item = str_replace( '<a class="menu-item-inner"', '<span class="menu-item-inner no-link"', $menu_item );
		$menu_item = str_replace( 'href="#"', '', $menu_item );
		$menu_item = str_replace( '</a', '</span', $menu_item );
	}
	return $menu_item;
}
add_filter( 'walker_nav_menu_start_el', 'punch_child_menu_items_replace_hash', 999 );

/**
 * Redirect Block
 */
function punch_child_redirect_func() {

	if ( is_author() || is_date() ) {
		wp_redirect( home_url() );
		exit();
	}
	
	if( is_singular() ){
		if( function_exists( 'get_field' ) ) {
			if( get_field( "custom_link" ) ) {
				$redirect_to = get_field( "custom_link" );
				wp_redirect( $redirect_to );
				exit();
			}
		}
	}

}
add_filter( 'template_redirect', 'punch_child_redirect_func' );

/**
 * Yoast SEO custom link exclusion
 */
function punch_child_wpseo_exclude_from_sitemap() {

	$exclude_array = array();
	$domain = $_SERVER['SERVER_NAME'];

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'any',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'     => 'custom_link',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => 'custom_link',
				'value'   => '',
				'compare' => '!=',
			),
		)
	);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$this_post_id = get_the_ID();
			$custom_link = get_post_meta( $this_post_id, 'custom_link', true );

			if( strpos( $custom_link, $domain ) == false ){
				$exclude_array[] = get_the_ID();
			}
		}
	}

	wp_reset_postdata();
	return $exclude_array;

}
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'punch_child_wpseo_exclude_from_sitemap' );


/**
 * Misc Hooks
 */
function punch_child_upload_mimes( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';
	return $mimes;
}
add_filter( 'upload_mimes', 'punch_child_upload_mimes' );

function punch_child_wp_responsive_images() {
	return 1;
}
add_filter( 'max_srcset_image_width', 'punch_child_wp_responsive_images' );

/**
 * Yoast hook to modify default Byline author, replacing it with values from taxonomy 'post_author'
 */
function punch_child_wpseo_enhanced_slack_data( $data, $presentation ) {
	if( is_singular( 'post' ) ) {
		$post_id = get_the_ID();
		if( has_term( "", "post_author", $post_id ) ) { 
			$authors = array();
			foreach ( get_the_terms( $post_id, "post_author" ) as $author ) { 
				$author_id = $author->term_id;
				$authors[] = get_term_field( 'name', $author_id );
			}
			$data[ \__( 'Written by', 'wordpress-seo' ) ] = implode( ", ", $authors );
		}
	}
	return $data;
}
add_filter( 'wpseo_enhanced_slack_data', 'punch_child_wpseo_enhanced_slack_data', 10, 2 );

/**
 * Hook to disable Yoast Schema.org per Page, requires a disable_yoast_schema bool ACF field
 */
function punch_child_wpseo_disable_yoast_schema( $bool ) {
	if( is_singular() && get_field( 'disable_yoast_schema' ) ) {
		$bool = false;
	}
	return $bool;
}
add_filter( 'wpseo_json_ld_output', 'punch_child_wpseo_disable_yoast_schema', 10, 1 );

add_filter( 'wp_img_tag_add_auto_sizes', '__return_false' );	
