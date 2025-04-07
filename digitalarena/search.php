<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config;

	/*
	* get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	*/
	get_header();

	do_action( 'ava_after_main_title' );
?>

<div class="avia-section alternate_color avia-section-large avia-no-border-styling avia-builder-el-0 el_before_av_section avia-builder-el-first container_wrap fullsize">
	<div class="container">
		<main role="main" class="template-page content av-content-full alpha units">
			<?php
			global $wp_query;
			if( !empty( $wp_query->found_posts ) ) {
				if( $wp_query->found_posts > 1 )
				{
					$output =  "<span>".$wp_query->found_posts ."</span> Results for: <span>" . esc_attr( get_search_query() ) . "</span>";
				}
				else
				{
					$output =  "<span>".$wp_query->found_posts ."</span> Result for: <span>" . esc_attr( get_search_query() ) . "</span>";
				}
			} else {
				if( !empty( $_GET['s'] ) )
				{
					$output = "No results for: <span>" . esc_attr( get_search_query() ) . "</span>";
				}
				else
				{
					$output = "To search the site please enter a valid term.";
				}
			}
			?>
			<h1 class='search-title'>Search</h1>
			<div class="h4"><?php echo $output; ?></div>
			<h5 class="search-form-label">If you do not see the desired result, please revise your search term.</h5>
			<?php get_search_form();?>
		</main>
	</div>
</div>

<div class="avia-section main_color avia-section-default avia-no-border-styling container_wrap fullsize">
	<div class="container">
		<div class="content">
			<?php echo do_shortcode( '[ep_template_part link="201" do_shortcode="yes"]' ); ?>
			<?php echo facetwp_display( 'facet', 'load_more' ); ?>
		</div>
	</div>
</div>

<?php 
	get_footer();