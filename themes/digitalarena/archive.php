<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config;

	/*
	* get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	*/
	get_header();
	 
	$hero_title = is_author() ? get_queried_object()->user_nicename : get_queried_object()->name;

	do_action( 'ava_after_main_title' );
?>

<div class="single-content-section avia-section main_color avia-section-default avia-no-border-styling container_wrap fullsize avia-builder-el-0 avia-builder-el-first">
	<div class="container">
		<div class="content">
			<h1><?php echo $hero_title; ?></h1>
			<?php
				$atts = array(
					'paginate' => 'no',
					'facetwp' => true,
					'button_link' => false,
					'disable_content' => true,
					'columns' => '4',
					'columns_tablet' => '2',
					'columns_mobile' => '1',
					'items' => 4,
					'heading_type' => 'h6'
				);

				$meta = array(
					'el_class' => '',
					'ep_class' => '',
					'custom_class' => '',
					'custom_el_id' => '',
				);

				$grid = new ep_post_grid( $atts, $meta );
				$grid->query_entries();
				echo $grid->html();
			?>

			<?php echo facetwp_display( 'facet', 'load_more' ); ?>
		</div>
	</div>
</div>

<?php 
	get_footer();
