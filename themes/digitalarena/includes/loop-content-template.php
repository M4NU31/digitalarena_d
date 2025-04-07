<?php
/* this is a template for a Post type that would require a custom coded template, this is usable only on Posts Grids */
?>
<div class="<?php echo $item_classes; ?>" <?php echo $item_style_tag; ?>>
    <div class="ep-item-grid-item-inner <?php echo $column_class_inner; ?>">

        <?php if( empty( $disable_image ) && $post_image ) { ?>
            <?php echo $post_image; ?>
        <?php } ?>
            
        <?php if( empty( $disable_tax ) && $post_terms ) { ?>
        <div class="ep-item-grid-item-terms">
            <?php echo $post_terms; ?>
        </div>
        <?php } ?>

        <?php if( empty( $disable_date ) ) { ?>
        <div class="ep-item-grid-item-date">
            <?php echo $post_date; ?>
        </div>
        <?php } ?>

        <?php if( empty( $disable_title ) ) { ?>
        <<?php echo $heading_type; ?> class="ep-item-grid-item-title" <?php echo $heading_style; ?>>
            <?php echo $post_title; ?>
        </<?php echo $heading_type; ?>>
        <?php } ?>

        <?php if( empty( $disable_content ) ) { ?>
        <div class="ep-item-grid-item-content">
            <?php echo $post_content; ?>
        </div>
        <?php } ?>

        <?php if( empty( $disable_button ) && empty( $disable_link ) && ! empty( $button_link ) ) { ?>
        <div class="ep-item-grid-item-button-wrapper">
            <a href="<?php echo $permalink; ?>" <?php echo $link_attrs; ?> class="avia-button avia-color-<?php echo $button_color; ?> avia-size-medium">
                <span class="avia_iconbox_title"><?php echo $link_label; ?></span>
            </a>
        </div>
        <?php } ?>

    </div>
</div>
