<?php

/**
 * Overrides Enfold Plus ALB Tab Name
 */
function punch_child_tab_name(){
	return SITE_NAME;
}
add_filter( 'avf_ep_tab_name', 'punch_child_tab_name', 1 );

/**
 * Button Styles
 * This hook will add/remove button color options on Buttons and Button Group
 */
function punch_child_avf_button_styles( $options ) {

    if( have_rows( 'button_styles', 'option' ) ):
	
		while( have_rows( 'button_styles', 'option' ) ) : the_row();

			$name = get_sub_field( 'name' );
			$class = sanitize_title( get_sub_field( 'name' ) );

			$options[$name] = $class;

		endwhile;

	else:
	
		$options = array(
			'Main' => 'main',
			'Outline' => 'outline',
			'Link' => 'link'
		);

	endif;

	return $options;
}
add_filter( 'avf_ep_buttons_style_options', 'punch_child_avf_button_styles', 10, 1 );

function punch_child_avf_button_colors( $options ) {
	$options = array(
		'Default' => 'default'
	);

	return $options;
}
add_filter( 'avf_ep_buttons_color_options', 'punch_child_avf_button_colors', 10, 1 );

function punch_child_avf_button_color_default( $option ) {
	$option = 'large';

	return $option;
}
add_filter( 'avf_ep_buttons_size_std', 'punch_child_avf_button_color_default', 10, 1 );

function punch_child_avf_button_size_options( $options ) {
	$options = array(
		'Small' => 'small',
		'Medium' => 'medium',
		'Large' => 'large'
	);

	return $options;
}
add_filter( 'avf_ep_buttons_size_options', 'punch_child_avf_button_size_options', 10, 1 );

/**
 * Overrides Enfold Plus Post Grid Template inclusion
 */
function punch_child_posts_template_override( $template, $post_type, $post_id, $meta ){
	/**
	 * Default template override
	 */
	$post_template = THEME_INCLUDES . "loop-content-" . $post_type . ".php";
	if( file_exists( $post_template ) ) $template = $post_template;

	/**
	 * Other Usages
	 */
	/* 
	if( $meta['ep_class'] == 'custom_style' ) {
		$template = THEME_INCLUDES . "loop-content-custom-style-" . $post_type . ".php";
	}
	*/

	/*
	if( in_array( $post_type, array( 'post', 'news' ) ) ) {
		$template = THEME_INCLUDES . "loop-content-common.php";
	} 
	*/

	return $template;
}
add_filter( 'avf_ep_post_grid_post_template', 'punch_child_posts_template_override', 10, 4 );
add_filter( 'avf_ep_post_slider_post_template', 'punch_child_posts_template_override', 10, 4 );

/**
 * Overrides Enfold Plus Content Slider Template inclusion
 */
function punch_child_slider_slide_template_override( $template, $atts, $meta ){
	/*
	if( strpos( $meta['custom_class'], 'custom' ) !== false ){
		$template = THEME_INCLUDES . "content-slider-custom.php";
	}
	*/

	return $template;
}
add_filter( 'avf_ep_content_slider_slide_template', 'punch_child_slider_slide_template_override', 10, 3 );

/**
 * Overrides Enfold Plus Item Grid Template inclusion
 */
function punch_child_item_grid_item_override( $template, $atts, $meta ){

	/*
	if( strpos( $meta['custom_class'], 'custom' ) !== false ){
		$template = THEME_INCLUDES . "item-grid-custom.php";
	}
	*/

	return $template;
}
add_filter( 'avf_ep_item_grid_item_template', 'punch_child_item_grid_item_override', 10, 3 );

/**
 * Tab Slider Overrides
 */
function punch_child_tab_slider_options( $options ) {
	
	/*
	$options[] = array(
		"name" 	=> __( "New option", 'avia_framework' ),
		"desc" 	=> __( "new option", 'avia_framework' ),
		"id" 	=> "new_option",
		"std" 	=> "",
		"type" 	=> "input"
	);
	*/
	
	return $options;
}
add_filter( 'avf_ep_tab_slider_options', 'punch_child_tab_slider_options' );

function punch_child_ig_options( $options ) {
	
	/*
	$options[] = array(	
		'name' 	=> __( 'Is Card Grid', 'avia_framework' ),
		'desc' 	=> __( 'Check to only display icon on hover', 'avia_framework' ),
		'id' 	=> 'icon_hover',
		'type' 	=> 'checkbox',
		'std' 	=> '',
		'lockable' => true,
	);

	$options[] = array(
		"name" 	=> __( "New option", 'avia_framework' ),
		"desc" 	=> __( "new option", 'avia_framework' ),
		"id" 	=> "new_option",
		"std" 	=> "",
		"type" 	=> "input",
		'required'	=> array( 'icon_hover', 'not', '' )
	);
	*/
	
	return $options;
}
add_filter( 'avf_ep_item_grid_item_options', 'punch_child_ig_options' );

function punch_child_tab_slider_control_override( $template, $atts, $meta ){
	/*
	if( $meta['ep_class'] == 'tabslider--simple' ) {
		$template = THEME_INCLUDES . "avia-shortcodes/tab_slider/tabslider--custom-control.php";
	}
	*/

	return $template;
}
add_filter( 'avf_ep_tab_slider_control_template', 'punch_child_tab_slider_control_override', 10, 3 );

function punch_child_tab_slider_slide_override( $template, $atts, $meta ){
	/*
	if( $meta['ep_class'] == 'tabslider--simple' ) {
		$template = THEME_INCLUDES . "avia-shortcodes/tab_slider/tabslider--custom-slide.php";
	}
	*/

	return $template;
}
add_filter( 'avf_ep_tab_slider_slide_template', 'punch_child_tab_slider_slide_override', 10, 3 );

/**
 * Removes default heading font size
 */
function punch_child_subheading_default_size( $heading ) {
	return '';
}
add_filter( 'avf_ep_subheading_default_size', 'punch_child_subheading_default_size' );

/**
 * Post Query hook for Posts Grid/Slider
 */
function punch_child_posts_query( $post_query, $meta ) {
	/**
	 * Related Posts hook
	 */
    if( $meta['ep_class'] == 'related-posts' ){
        $post_query = punch_child_get_related_posts_query( $post_query );
    }

	return $post_query;
}
add_filter( 'avf_ep_post_grid_query', 'punch_child_posts_query', 10, 2 );
add_filter( 'avf_ep_post_slider_query', 'punch_child_posts_query', 10, 2 );

/**
 * This hooks allows you to modify the set of classes a Posts Grid/Slider Item will get.
 */
function punch_child_featured_post_item_classes( $classes, $slug, $post_id, $meta, $shortcode ){
	/**
	 * Removes default entry-cpt slug class from featured-posts
	 */
	if( strpos( $meta['el_class'], 'featured-posts' ) !== false ){
        $classes['slug_class'] = "entry-featured-{$slug}";
    }

	if( is_search() ) { // maybe add is_archive here 
		$classes['slug_class'] = "entry-search";
	}

	/**
	 * Adds image-is-higher class to featured-posts
	 */
	if( has_post_thumbnail( $post_id ) ){

		$thumbnail_width = wp_get_attachment_metadata( get_post_thumbnail_id( $post_id ) )['width'];
		$thumbnail_height = wp_get_attachment_metadata( get_post_thumbnail_id( $post_id ) )['height'];

		if( $thumbnail_height > $thumbnail_width ){
			$classes[] = ' image-is-higher';
		}

		if( ( $thumbnail_height / $thumbnail_width ) < 0.2 ){
			$classes[] = ' image-is-shorter';
		}

	}

	if( get_field( 'start_date', $post_id ) ) {
		$start_date = strtotime( get_field( 'start_date', $post_id ) );
		$end_date = get_field( 'end_date', $post_id ) ? strtotime( get_field( 'end_date', $post_id ) ) : $start_date;

		// check if start date is in the past to identify upcoming events
		if( $start_date < time() && $end_date < time() ) {
			$classes[] = ' is-past';
		} else {
			$classes[] = ' is-upcoming';
		}
	}

    return $classes;
}
add_filter( 'avf_ep_post_item_classes', 'punch_child_featured_post_item_classes', 10, 5 );

/**
 * Used for experimental archive/search view Posts Grid rendering
 */
function punch_child_posts_query_object( $query_object, $meta ) {
    // Bail out if this Post's Grid query is irreplaceable.
    if ( $query_object->query['suppress_replacements'] ?? false ) {
        return $query_object;
    }

    if ( is_archive() || is_search() ) {
        global $wp_query;
        $query_object = $wp_query;
    }

    return $query_object;
}
add_filter( 'avf_ep_post_grid_query_object', 'punch_child_posts_query_object', 10, 2 );


/**
 * Post vars filters
 */
function punch_child_post_item_link( $post_link, $post_type, $post_id, $meta, $shortcode ) {
    $post_link = punch_child_custom_link( $post_id )['link'];

	return $post_link;
}
add_filter( 'avf_ep_post_item_link', 'punch_child_post_item_link', 10, 5 );

function punch_child_post_item_link_attrs( $post_link_attrs, $post_type, $post_id, $meta, $shortcode ) {
    $post_link_attrs = punch_child_custom_link( $post_id )['attrs'];

	return $post_link_attrs;
}
add_filter( 'avf_ep_post_item_link_attrs', 'punch_child_post_item_link_attrs', 10, 5 );

function punch_child_post_item_content( $post_content, $post_type, $post_id, $meta, $shortcode ) {
    /*
    if( $post_type == 'team' ) {
        $post_content = get_field( 'job_title' );
    }
    */

	return $post_content;
}
add_filter( 'avf_ep_post_item_content', 'punch_child_post_item_content', 10, 5 );

function punch_child_post_item_date( $post_date, $post_type, $post_id, $meta, $shortcode ) {
    $post_date = punch_child_format_date( $post_id, $post_date );
    
	return $post_date;
}
add_filter( 'avf_ep_post_item_date', 'punch_child_post_item_date', 10, 5 );

function ava_ep_post_grid_post_meta_space( $post_type, $post_id, $meta, $atts ) {
	if( $post_type == 'leadership' ) return;
    echo punch_child_single_meta( $post_id, $atts );
}
add_action( 'ava_ep_post_grid_post_space_4', 'ava_ep_post_grid_post_meta_space', 10, 4 );

/* 
function punch_child_post_item_taxonomy( $post_taxonomy, $post_type, $post_id, $meta, $shortcode ) {
	return $post_taxonomy;
}
add_filter( 'avf_ep_post_item_taxonomy', 'punch_child_post_item_taxonomy', 10, 5 );

function punch_child_post_item_content_length( $post_content_length, $post_type, $post_id, $meta, $shortcode ) {
	return $post_content_length;
}
add_filter( 'avf_ep_post_item_content_length', 'punch_child_post_item_content_length', 10, 5 );

function punch_child_post_item_vars( $post_vars, $post_type, $post_id, $meta, $shortcode ) {
	return $post_vars;
}
add_filter( 'avf_ep_post_item_vars', 'punch_child_post_item_vars', 10, 5 );
*/

function punch_child_term_link( $term_link, $term, $taxonomy ){
	if ( class_exists( 'WPSEO_Taxonomy_Meta' ) ) {
		$overview_page = WPSEO_Taxonomy_Meta::get_term_meta( $term->term_id, $taxonomy, 'canonical' );
		if( $overview_page ) {
			$term_link = $overview_page;
		}
	}

    return $term_link;
}
add_filter( 'term_link', 'punch_child_term_link', 10, 3 );

function enfold_child_mega_menu_featured_post( $output, $item, $depth, $args ) {
    $featured_post_id = get_field( 'featured_post', $item );

    if ( ! $featured_post_id ) {
        return $output;
    }

    $grid_atts = array(
        'shortcode' => 'ep_posts_grid',
        'meta' => array(
            'el_class' => '',
            'ep_class' => '',
        ),
        'disable_term_links' => '',
        'disable_button' => '',
        'button_link' => '',
        'disable_link' => '',
        'post_taxonomy' => '',
        'post_terms_number' => 1,
        'excerpt_length' => '',
        'date_format' => '',
    );
    extract( EnfoldPlusHelpers::get_post_vars( $featured_post_id, $grid_atts ) );

    ob_start();
    ?>
    <div class="mega-menu-featured-post">
        <?php if ( $post_terms ): ?>
            <div class="mega-menu-featured-post-category">
                <?php echo $post_terms; ?>
            </div>
        <?php endif ?>
        <div class="mega-menu-featured-post-title">
            <a href="<?php echo $permalink; ?>" <?php echo $link_attrs; ?>>
                <?php echo $post_title; ?>
            </a>
        </div>
        <div class="mega-menu-featured-post-button">
            <a href="<?php echo $permalink; ?>" <?php echo $link_attrs; ?> class="avia-button avia-color-light-gray">Read More</a>
        </div>
    </div>
    <?php

    return $output . ob_get_clean();
}
add_filter( 'walker_nav_menu_start_el', 'enfold_child_mega_menu_featured_post', 999, 4 );