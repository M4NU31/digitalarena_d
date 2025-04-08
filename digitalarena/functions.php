<?php

/**
 * Site constants
 */
define( 'SITE_NAME', 'Digital Arena' );
define( 'SITE_SLUG', 'digitalarena' );
define( 'REMOTE_URL', 'https://digitalarena.tech/' );
define( 'THEME_VERSION', '1.0.1' );
define( 'THEME_ENV', 'dev' );
define( 'THEME_ASSETS', get_stylesheet_directory_uri() . '/assets/' ); 
define( 'THEME_INCLUDES', get_stylesheet_directory() . '/includes/' ); 

/** 
 * Init Theme
*/
function punch_child_setup() {  
	remove_filter( 'the_title', 'wptexturize' );
	remove_filter( 'avia_ampersand', 'avia_ampersand' );
	remove_action( 'init', 'portfolio_register' );
	 
	add_filter( 'kriesi_backlink', '__return_false' );
	add_filter( 'avf_debugging_info', '__return_false' );

	update_option( 'image_default_size', 'full' );

	add_theme_support( 'dotlotties' );
	
	add_filter( 'wp_img_tag_add_srcset_and_sizes_attr', '__return_false' );

	/* Gutenberg */
	add_filter( 'avf_block_editor_theme_support', '__return_false' );
	add_theme_support( 'align-wide' );  
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/style-editor.css' );
	
	/* Gutenberg Block patterns */
	remove_theme_support( 'core-block-patterns' );
	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {

		register_block_pattern_category( SITE_SLUG, [
			'label' => SITE_NAME,
		] );

		register_block_pattern(
			SITE_SLUG . '/pattern-1',
			array(
				'title'       => __( 'Pattern 1', 'avia_framework' ),
				'content'     => "", // https://wpblockz.com/tool/tool-to-generate-code-for-your-wordpress-block-patterns/
				'categories'  => array( SITE_SLUG ),
			)
		);	
  	}
}
add_action( 'after_setup_theme', 'punch_child_setup', 51 );

/**
 * Enqueue scripts and styles.
 */
function punch_child_scripts() {
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap', array(), null, 'all' );
	wp_enqueue_style( 'avia-module-main', THEME_ASSETS . 'css/main.css', array(), THEME_VERSION, 'all' );
	wp_enqueue_script( 'avia-module-main', THEME_ASSETS . 'js/main.js', array(), THEME_VERSION, true );

	$punch_font_families = get_field( 'font_families', 'option' );

	if( is_array( $punch_font_families ) ) {
		foreach( $punch_font_families as $punch_font_family ) {
			wp_enqueue_style( 'font-family-' . strtolower( $punch_font_family['name'] ), $punch_font_family['font_url'], array(), null, 'all' );
		}
	}

	
	if ( is_single() ) { // you can add is_tax / is_category / is_search / etc as needed

		/* Common Single CSS */
		if( is_singular( array( 'post', 'resource', 'press_and_news', 'events_and_webinars' ) ) ) {
			wp_enqueue_style( 'theme-single-common', THEME_ASSETS . 'css/single-common.css', array(), THEME_VERSION, 'all' );
		}

		/* Specific Single CSS */
		/*
		if( is_singular( 'team' ) ) {
			wp_enqueue_style( 'theme-single-team', THEME_ASSETS . 'css/single-team.css', array(), THEME_VERSION, 'all' );
		}
		*/

		if( has_blocks() ) {
			/* Gutenberg CSS */
			wp_enqueue_style( 'theme-gutenberg', THEME_ASSETS . 'css/gutenberg.css', array(), THEME_VERSION, 'all' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'punch_child_scripts', 100 );

function punch_child_admin_scripts() {
	wp_enqueue_style( 'main-admin', THEME_ASSETS . 'css/dist/admin.css', array(), THEME_VERSION, 'all' );

	/* Disabled Enfold WPSEO scripts if Gutenberg editor is enabled */
	$current_screen = get_current_screen();
    if( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ){
		wp_deregister_script( 'avia-yoast-seo-js' );
		wp_deregister_script( 'avia_analytics_js' );
	}
}
add_action( 'admin_enqueue_scripts', 'punch_child_admin_scripts', 100 );

function punch_child_gutenberg_scripts() {
	wp_enqueue_script( 'enfold-child-editor', THEME_ASSETS . 'js/dist/editor.js', array( 'wp-blocks', 'wp-dom' ), THEME_VERSION, true );
}
add_action( 'enqueue_block_editor_assets', 'punch_child_gutenberg_scripts' );

function punch_child_footer_assets() {
    ?>
	<script>document.write('<link rel="stylesheet" href="<?php echo THEME_ASSETS; ?>css/body.css?v=<?php echo THEME_VERSION; ?>">');</script>
    <?php
}
add_action( 'wp_footer', 'punch_child_footer_assets', 100 );

function punch_child_wp_head() {

}
add_action( 'wp_head', 'punch_child_wp_head', 20, 1 );

function punch_child_wp_footer() {
	
}
add_action( 'wp_footer', 'punch_child_wp_footer', 20, 1 );


require THEME_INCLUDES . 'theme-functions.php';
require THEME_INCLUDES . 'theme-shortcodes.php';
require THEME_INCLUDES . 'theme-overrides.php';
require THEME_INCLUDES . 'theme-styles.php';
require THEME_INCLUDES . 'theme-hooks.php';
require THEME_INCLUDES . 'theme-ep-hooks.php';
//require THEME_INCLUDES . 'theme-acf.php';