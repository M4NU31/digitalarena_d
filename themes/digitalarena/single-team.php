<?php

if ( !defined('ABSPATH') ){ die(); }
	
global $avia_config;

get_header();

do_action( 'ava_after_main_title' );

if( have_posts() ) :
	while( have_posts() ) : the_post();

        $post_id = $post->ID;
        $post_title =  get_the_title();
        $job_title = get_field( 'job_title', $post_id );
        $linkedin = get_field( 'linkedin', $post_id );

?>
  
<div class="avia-section main_color avia-section-huge avia-no-border-styling avia-full-stretch avia-bg-style-scroll container_wrap ep-lazy-loaded single-team-hero-section avia-builder-el-0 el_before_av_section avia-builder-el-first container_wrap fullsize section--map-top">
    <div class='container'>
        <div class='content'>
            <div class="entry-content-wrapper">
                <div class="columns">
                    <div class="column is-one-quarter image-column">
                        <div class="team-thumb">
                            <div class="thumb-inner-wrapper">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="column content-column">
                        <h1 class="team-title"><?php the_title(); ?></h1>
                        <h5 class="job-title"><?php echo $job_title; ?></h5>
                        <?php if( $linkedin ) { ?>
                            <div class="icon-wrapper">
                                <a href="<?php echo $linkedin; ?>" target="_blank" rel="nofollow" class="linkedin-icon"><span></span></a>
                            </div>
                        <?php } ?>
                        <div class="team-content">
                            <?php the_content(); ?>
                        </div>
                        <div class="avia-button-wrap avia-button-no-align avia-builder-el-32 el_after_av_hr el_before_av_hr ">
                            <a href="<?php echo get_permalink( 670 ); ?>" class="avia-button  avia-icon_select-no avia-style-default avia-color-goback avia-size-large">
                                <span class="avia_iconbox_title">Back to Team</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

endwhile;
endif;

get_footer();