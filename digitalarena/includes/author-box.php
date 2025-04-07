<?php
$author_id = $term->term_id;
$headshot = get_field( 'headshot', 'post_author_' . $author_id );
$author = $term->name;
$description = $term->description;
$title = get_field( 'title', 'post_author_' . $author_id );
$linkedin = get_field( 'linkedin', 'post_author_' . $author_id );
?>

<div class="author">
    <?php if( $headshot ){ ?>
        <div class="author-img">
            <?php echo wp_get_attachment_image( $headshot, 'medium', false, '' ); ?>
        </div>
    <?php } ?>
    <div class="author-content">
        <div class="author-header">
            <div class="author-titles">
                <div class="author-name h4">
                    <?php echo $author; ?>
                </div>
                <?php if( $title ){ ?>
                    <div class="author-title h6">
                        <?php echo $title; ?>
                    </div>
                <?php } ?>
            </div>
            <?php if( $linkedin ){ ?>
                <div class="author-socials">
                    <a href="<?php echo $linkedin; ?>" class="linkedin"></a>
                </div>
            <?php } ?>
        </div>
        <?php if( $description ){ ?>
            <div class="author-description">
                <?php echo $description; ?>
            </div>
        <?php } ?>
        <a href="<?php echo get_term_link( $author_id, 'post_author' ); ?>" class="avia-button avia-icon_select-no avia-style-default avia-color-link avia-size-large avia-position-left">
            <span class="avia_iconbox_title">More about this author</span>
        </a>
    </div>
</div>