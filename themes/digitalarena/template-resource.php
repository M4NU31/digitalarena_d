<?php
/*
	Template Name: Resources
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
<div class="single-content-section single-post-columnized avia-section main_color avia-section-default avia-no-border-styling container_wrap fullsize avia-builder-el-0 avia-builder-el-first">
	<div class="container">
		<div class="content">
			<div class="entry-content-wrapper">
                <div class="ep-columns">
                    <div class="ep-columns-inner">
                        <?php if ( get_field( 'hide_featured_image' ) == 0 && !empty( get_the_post_thumbnail() ) ) { ?>
                        <div class="ep-column single-post-side-content is-resource">    
                            <div class="single-post-thumbnail has-shadow"><?php the_post_thumbnail(); ?></div>
                            <?php
                            if( has_term( '', 'post_tag', $post_id ) ) {
                                ?>
                                <h6 class="is-color-p3 is-marginless">Tags:</h6>
                                <?php
                                echo "<div class='ep-post-terms'>" . EnfoldPlusHelpers::get_terms_with_links( $post_id, 'post_tag', ", ", '5' ) . "</div>"; 
                            }
                            ?>
                        </div>
                        <?php } ?>
                        <div class="ep-column single-post-main-content is-resource">
                            <div class="single-post-header">
                                <?php 
                                if( has_term( '', 'category', $post_id ) ) {
                                    echo "<div class='ep-post-terms'>" . EnfoldPlusHelpers::get_terms_with_links( $post_id, 'category', ", ", '1' ) . "</div>"; 
                                }
                                ?>
                                <?php echo punch_child_single_title( $post_id ); ?>
                            </div>
                            <?php the_content(); ?>
                            <div class="single-post-footer">
								<a href="<?php echo $back_to['link']; ?>" class="avia-button avia-icon_select-no avia-style-default avia-color-goback avia-size-large">
									<span class="avia_iconbox_title"><?php echo $back_to['label']; ?></span>
								</a>
                            </div>
                        </div>
                    </div>
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