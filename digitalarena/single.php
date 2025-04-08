<?php

if ( !defined('ABSPATH') ){ die(); }
	
global $avia_config;

get_header();

do_action( 'ava_after_main_title' );

if( have_posts() ) :
	while( have_posts() ) : the_post();
	$post_id = get_the_ID();

	$post_category = 'category';
	$back_to = punch_child_get_back_button( $post_id, $post_category );
	
?>
<div class="single-content-section avia-section alternate_color avia-section-default avia-no-border-styling container_wrap fullsize avia-builder-el-0 avia-builder-el-first">
	<div class="container">
		<div class="content">
			<div class="entry-content-wrapper">
				<div class="single-post-header">

					<?php 
					if( has_term( '', 'category', $post_id ) ) {
						echo "<div class='ep-post-terms'>" . EnfoldPlusHelpers::get_terms_with_links( $post_id, 'category', ", ", '1' ) . "</div>"; 
					}
					?>

					<?php echo punch_child_single_title( $post_id ); ?>
					<div class="single-post-meta">
						<div class="single-post-date">
							<?php echo get_the_date( get_option( 'date_format' ), $post_id ); ?>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<div class="single-content-section avia-section main_color avia-section-default avia-no-border-styling container_wrap fullsize">
	<div class="container">
		<div class="content">
			<div class="entry-content-wrapper">
				<?php if ( get_field( 'hide_featured_image' ) == 0 && !empty( get_the_post_thumbnail() ) ) { ?>
						<div class="single-post-thumbnail"><?php the_post_thumbnail(); ?></div>
					<?php } ?>
				<?php the_content(); ?>
				<div class="single-post-footer">
					<?php avia_social_share_links( array(), false, "Share this post" ); ?>
					
					<?php 
					if( has_term( '', 'post_tag', $post_id ) ) {
						echo "<h3 class='tags-label'>Tags</h3>";
						echo "<div class='ep-post-terms'>" . EnfoldPlusHelpers::get_terms_with_links( $post_id, 'post_tag', " ", '5' ) . "</div>"; 
					}
					?>

					<?php comments_template(); ?>

					<a href="<?php echo $back_to['link']; ?>" class="avia-button avia-icon_select-no avia-style-default avia-color-goback avia-size-large">
						<span class="avia_iconbox_title"><?php echo $back_to['label']; ?></span>
					</a>

				</div>
			</div>
        </div>
	</div>
</div>

<?php if ( punch_child_has_related_posts() ): ?>
<div class="main_color related-posts-section">
	<div class="container">
		<div class="content">
			<div class="ep-columns related-posts-header">
				<div class="ep-columns-inner">
					<div class="ep-column">
						<div class="h3">
							<div class="av-special-heading-tag">Related Content</div>
						</div>
					</div>
					<div class="ep-column">
						<a href="<?php echo $back_to['link']; ?>" class="avia-button avia-icon_select-no avia-style-default avia-color-link avia-size-large avia-position-left">
							<span class="avia_iconbox_title">View all</span>
						</a>
					</div>
				</div>
			</div>
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
                'ep_class' => 'related-posts',
                'custom_class' => '',
                'custom_el_id' => '',
            );

			$grid = new ep_post_grid( $atts, $meta );
			$grid->query_entries();
			echo $grid->html();
		?>
		</div>
	</div>
</div>
<?php endif ?>

<?php

endwhile;
endif;

get_footer();

?>