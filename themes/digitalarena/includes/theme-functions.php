<?php 

function custom_wp_is_mobile() {
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = false;
	} elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) !== false // many mobile devices (all iPhone, iPad, etc.)
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' ) !== false ) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}
	/**
	* Filters whether the request should be treated as coming from a mobile device or not.
	*
	* @since 4.9.0
	*
	* @param bool $is_mobile Whether the request is from a mobile device or not.
	*/
	return $is_mobile;
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);
	
	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;
	
	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}
	
	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function hex2rgba($color, $opacity = false) {
	
	$default = 'rgb(0,0,0)';
	
	//Return default if no color provided
	if(empty($color))
	return $default; 
	
	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	
	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
	
	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);
	
	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
		$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}
	
	//Return rgb(a) color string
	return $output;
}

function punch_child_format_date( $post_id ){
	$date_format = get_option( 'date_format' );
	$post_date_class = "";
	if( get_field( 'start_date', $post_id ) ) {
		$start_date = strtotime( get_field( 'start_date', $post_id ) );
		$end_date = strtotime( get_field( 'end_date', $post_id ) );
		if( $start_date !== $end_date ){
			
			$start_month = date( "F", $start_date );
			$end_month = date( "F", $end_date );
			
			if( $start_month == $end_month ){
				$post_date = date( "F", $start_date ) . " " . date( "j", $start_date ) . " - " . date( "j", $end_date ) . ", " . date( "Y", $start_date );
			} else {
				$post_date = date( "F j", $start_date ) . " - " . date( "F j", $end_date ) . ", " . date( "Y", $start_date ) ;
			}
			
		} else {
			$post_date = date( $date_format, $start_date );
		}
	} else {
		$post_date = get_the_date( $date_format, $post_id );
	}
	
	return $post_date;
}

function punch_child_custom_link( $post_id ){
	
	$custom_link_data = array();
	$custom_link_data['attrs'] = '';
	$custom_link_data['link'] = get_permalink( $post_id );
	
	if ( !empty ( get_field ( 'custom_link', $post_id ) ) ) {
		$custom_link_data['link'] = get_field( 'custom_link', $post_id );
		$domain = $_SERVER['SERVER_NAME'];
		if( strpos( $custom_link_data['link'], $domain ) == false ){
			$custom_link_data['attrs'] = 'target="_blank" rel="nofollow"';
		}
	} 
	
	return $custom_link_data;
}

function punch_child_single_title( $post_id ) {
	$output = "";

	$post_title = get_field( 'custom_title', $post_id ) ? get_field( 'custom_title', $post_id ) : get_the_title( $post_id );
	$output .= '<h1 class="entry-title">' . $post_title . '</h1>';

	if( get_field( 'custom_subtitle', $post_id ) ) {
		$output .= '<div class="entry-subtitle">' . get_field( 'custom_subtitle', $post_id ) . '</div>';
	}

	return $output;
}


function punch_child_single_meta( $post_id, $atts = false ) {
	$post_date = punch_child_format_date( $post_id );
	if( $atts && !empty( $atts['disable_date'] ) ) return;
	ob_start();
    ?>
	<div class="ep-post-meta">
		<?php if( get_field( 'location', $post_id ) ) { ?>
			<div class="ep-post-location has-icon"><?php echo get_field( 'location', $post_id ); ?></div>
		<?php } ?>
		<?php echo $post_date; ?>
		<?php if( get_field( 'time', $post_id ) ) { ?>
			<div class="ep-post-time has-icon"><?php echo get_field( 'time', $post_id ); ?></div>
		<?php } ?>
	</div>
	<?php
	return ob_get_clean();
}


function punch_logo( $full = false ) {
	$logo_output = "";

	$logo_output = "<div class='logo-main'>" . wp_get_attachment_image( attachment_url_to_postid( avia_get_option( 'logo' ) ), 'full', false, '' ) . "</div>";
	if( $full ){
		$logo_output .= "<div class='logo-alternate'>" . wp_get_attachment_image( attachment_url_to_postid( avia_get_option( 'alternate_logo' ) ), 'full', false, '' ) . "</div>";
	}

	ob_start();
	?>
	<a href="<?php echo bloginfo( 'url' ); ?>" class="logo aria-label="<?php echo SITE_NAME; ?> Logo">
		<?php echo $logo_output; ?>
    </a>
	<?php
	return ob_get_clean();
}



/**
 * Returns the WP_Query args for Related Posts. Extracted because we'll be
 * doing the same query on two places.
 *
 * See: theme-ep-hooks: punch_child_posts_query()
 * See: theme-functions: punch_child_has_related_posts()
 */
function punch_child_get_related_posts_query( $post_query ) {
    $current_post_id = get_the_ID();

    $post_query['post_type'] = get_post_type();
    $post_query['post__not_in'] = array( $current_post_id );

    /* Added option to have custom set of related posts, requires ACF Pro and fields properly set */
    if( have_rows( 'related_posts' ) ){
        $posts_to_include = array();

        while( have_rows( 'related_posts' ) ){
            the_row();
            $posts_to_include[] = get_sub_field( 'related_post' );
        }

        $post_query['post__in'] = $posts_to_include;
    } else {
        $taxonomy = 'category';

        $terms = get_the_terms( $current_post_id, $taxonomy );

        if( ! empty( $terms ) ) {
            $terms_array = array_map(
                function ( $term ) {
                    return (int) $term->term_id;
                },
                $terms
            );

            $post_query['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'terms' => $terms_array,
                ),
            );
        }

        $taxonomy = 'post_tag';

        $terms = get_the_terms( $current_post_id, $taxonomy );

        if( ! empty( $terms ) ) {
            $terms_array = array_map(
                function ( $term ) {
                    return (int) $term->term_id;
                },
                $terms
            );

            $post_query['tax_query'][] = array(
                'taxonomy' => $taxonomy,
                'terms' => $terms_array,
            );
        }
    }

    return $post_query;
}

/**
 * WARNING: This function expects to work under the context of a single Post
 * request.
 */
function punch_child_has_related_posts() {
    $post_query = array(
        'post_type' => get_post_type(),
        'posts_per_page' => -1,
        'ignore_sticky_posts' => true,
    );

    $post_query = punch_child_get_related_posts_query( $post_query );

    $query = new WP_Query( $post_query );
    $has_posts =$query->have_posts();
    wp_reset_postdata(); // This is important too.

    return $has_posts;
}


function punch_child_get_back_button( $post_id, $taxonomy ){
	$data = array();

	if( has_term( '', $taxonomy, $post_id ) ) {
		$post_terms = get_the_terms( $post_id, $taxonomy );
		$data['label'] = __( "Back to ", "punch" ) . $post_terms[0]->name;
		$data['link'] = get_term_link( $post_terms[0]->term_id, $taxonomy );
	}

	return $data;
}
