<?php
/*
	Template Name: Event
	Template Post Type: post
*/

if ( !defined('ABSPATH') ){ die(); }
	
global $avia_config;

get_header();

do_action( 'ava_after_main_title' );

if( have_posts() ) :
	while( have_posts() ) : the_post();
	$post_id = get_the_ID();
	$post_type = get_post_type( $post_id );
	
	$post_category = 'category';

	switch ( $post_type ) {
		case 'resource':
			$post_category = 'resource_type';
			break;
	}

	$back_to = punch_child_get_back_button( $post_id, $post_category );

?>
<div class="single-content-section avia-section main_color avia-section-default avia-no-border-styling container_wrap fullsize avia-builder-el-0 avia-builder-el-first">
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
						<?php 
						if( has_term( '', 'post_author', $post_id ) ) {
							?>
							<div class="single-post-authors">
							<?php
							$the_authors = get_the_terms( $post_id, 'post_author' );
							?>
							<span>By:
							<?php
							foreach( $the_authors as $key => $term ) {
								$author_name = $term->name;
								// echo author name with a an anchor link to #author-box and a comma separator, excluding the last item

								echo '<a href="#author">' . $author_name . '</a>';
								if ( $key !== array_key_last( $the_authors ) ) {
									echo ", ";
								}
							}
							?>
							</span>
							</div>
							<?php
						}
						?>
						<div class="single-post-date">
							<?php echo get_the_date( get_option( 'date_format' ), $post_id ); ?>
						</div>
					</div>
					<?php if ( get_field( 'hide_featured_image' ) == 0 && !empty( get_the_post_thumbnail() ) ) { ?>
						<div class="single-post-thumbnail"><?php the_post_thumbnail(); ?></div>
					<?php } ?>
				</div>
				<?php the_content(); ?>
				<div class="single-post-footer">
					<?php avia_social_share_links( array(), false, "Share this post" ); ?>
					
					<?php 
					if( has_term( '', 'post_tag', $post_id ) ) {
						echo "<div class='ep-post-terms'>" . EnfoldPlusHelpers::get_terms_with_links( $post_id, 'post_tag', ", ", '5' ) . "</div>"; 
					}

					if( has_term( '', 'post_author', $post_id ) ) {
						$authors = get_the_terms( $post_id, 'post_author' );
						$author_or_authors = count( $authors ) > 1 ? 'Authors' : 'Author';
						?>
						<div id="author" class="author-box">
						<h6>About the <?php echo $author_or_authors; ?></h6>
						<?php
						foreach( $the_authors as $key => $term ) {
							include( THEME_INCLUDES . '/author-box.php' );
						}
						?>
						</div>
						<?php
					}
					?>

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
                'ep_class' => '',
                'custom_class' => 'related-posts',
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