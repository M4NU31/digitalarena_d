<?php

function punch_output_acf_css_var( $acf_key, $css_var, $is_sub_field = false ){
    if( $is_sub_field ) {
        $acf_value = get_sub_field( $acf_key );
    } else {
        $acf_value = get_field( $acf_key, 'option' );
    }
    
    if( $acf_value ) {
        echo $css_var . ': ' . $acf_value . ';';
    }
}

function punch_options_ff() {
    $punch_font_families_options = array(
        '' => 'Default'
    );

    $punch_font_families = get_field( 'font_families', 'option' );

    if( is_array( $punch_font_families ) ) {
        foreach( $punch_font_families as $key => $punch_font_family ) {
            $punch_font_families_options["'" . $punch_font_family['name'] . "'"] = $punch_font_family['name'];
        }
    }

    return $punch_font_families_options;
}

function punch_options_colors() {

    $color_options = array(
        '' => 'Default'
    );

    $primary_colors = get_field( 'primary_colors', 'option' );
    $secondary_colors = get_field( 'secondary_colors', 'option' );
    $tertiary_colors = get_field( 'tertiary_colors', 'option' );
    $additional_colors = get_field( 'additional_colors', 'option' );

    if( is_array( $primary_colors ) ) {
        foreach( $primary_colors as $key => $color ) {
            $key = $key + 1;
            $color_options["var(--colorP{$key})"] = 'Primary ' . $key . ' - ' . $color['color'];
        }
    }

    if( is_array( $secondary_colors ) ) {
        foreach( $secondary_colors as $key => $color ) {
            $key = $key + 1;
            $color_options["var(--colorS{$key})"] = 'Secondary ' . $key . ' - ' . $color['color'];
        }
    }

    if( is_array( $tertiary_colors ) ) {
        foreach( $tertiary_colors as $key => $color ) {
            $key = $key + 1;
            $color_options["var(--colorT{$key})"] = 'Tertiary ' . $key . ' - ' . $color['color'];
        }
    }

    if( is_array( $additional_colors ) ) {
        foreach( $additional_colors as $key => $color ) {
            $key = $key + 1;
            $color_options["var(--colorE{$key})"] = 'Additional ' . $key . ' - ' . $color['color'];
        }
    }

    return $color_options;
}

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Punch Settings',
        'menu_title'    => 'Punch Settings',
        'menu_slug'     => 'punch-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

}

function acf_load_color_field_choices( $field ) {
    $field['choices'] = punch_options_colors();
    return $field;    
}

add_filter( 'acf/load_field/name=top_menu_bg_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=main_menu_bg_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=hamburger_bg_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=menu_item_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=menu_item_color_hover', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=main_background_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=main_text_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=alternate_background_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=alternate_text_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=text_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=background_color', 'acf_load_color_field_choices' );

// Heading Colors
add_filter( 'acf/load_field/name=heading_color', 'acf_load_color_field_choices' );
add_filter( 'acf/load_field/name=heading_alternate_color', 'acf_load_color_field_choices' );

function acf_load_ff_field_choices( $field ) {
    $field['choices'] = punch_options_ff();
    return $field;    
}
add_filter( 'acf/load_field/name=font_family', 'acf_load_ff_field_choices' );
add_filter( 'acf/load_field/name=heading_font_family', 'acf_load_ff_field_choices' );


add_action( 'wp_head', function() {
    ?>
    <style>
        :root{
            <?php

            /* Colors */
            if( have_rows( 'primary_colors', 'option' ) ):
                $i = 1;
                while( have_rows( 'primary_colors', 'option' ) ) : the_row();
                    $color = get_sub_field( 'color' );
                    ?>
                    --colorP<?php echo $i;?>: <?php echo $color; ?>;
                    <?php
                    $i++;
                endwhile;
            endif;

            if( have_rows( 'secondary_colors', 'option' ) ):
                $i = 1;
                while( have_rows( 'secondary_colors', 'option' ) ) : the_row();
                    $color = get_sub_field( 'color' );
                    ?>
                    --colorS<?php echo $i;?>: <?php echo $color; ?>;
                    <?php
                    $i++;
                endwhile;
            endif;

            if( have_rows( 'tertiary_colors', 'option' ) ):
                $i = 1;
                while( have_rows( 'tertiary_colors', 'option' ) ) : the_row();
                    $color = get_sub_field( 'color' );
                    ?>
                    --colorT<?php echo $i;?>: <?php echo $color; ?>;
                    <?php
                    $i++;
                endwhile;
            endif;

            if( have_rows( 'additional_colors', 'option' ) ):
                $i = 1;
                while( have_rows( 'additional_colors', 'option' ) ) : the_row();
                    $color = get_sub_field( 'color' );
                    ?>
                    --colorE<?php echo $i;?>: <?php echo $color; ?>;
                    <?php
                    $i++;
                endwhile;
            endif;


            /* Header */
            if( get_field( 'top_menu_bg_color', 'option' ) ) { ?>
                --headerTopMenuBgColor: <?php the_field( 'top_menu_bg_color', 'option' ); ?>;<?php 
            }
            if( get_field( 'main_menu_bg_color', 'option' ) ) { ?>
                --headerMenuBgColor: <?php the_field( 'main_menu_bg_color', 'option' ); ?>;<?php 
            } 
            if( get_field( 'hamburger_bg_color', 'option' ) ) { ?>
                --headerHamburgerBgColor: <?php the_field( 'hamburger_bg_color', 'option' ); ?>;<?php 
            } 
            if( get_field( 'menu_item_size', 'option' ) ) { ?>
                --headerItemSize: <?php the_field( 'menu_item_size', 'option' ); ?>;<?php 
            } 
            if( get_field( 'menu_item_color', 'option' ) ) { ?>
                --headerItemColor: <?php the_field( 'menu_item_color', 'option' ); ?>;<?php 
            }
            if( get_field( 'menu_item_color_hover', 'option' ) ) { ?>
                --headerItemColorHover: <?php the_field( 'menu_item_color_hover', 'option' ); ?>;<?php 
            } 
            if( get_field( 'logo_width', 'option' ) ) { ?>
                --headerLogoWidth: <?php the_field( 'logo_width', 'option' ); ?>;<?php 
            } 
            if( get_field( 'logo_height', 'option' ) ) { ?>
                --headerLogoHeight: <?php the_field( 'logo_height', 'option' ); ?>;<?php 
            } 
            
            ?>
        }


        /* Section */
        <?php if( get_field( 'main_background_color', 'option' ) || get_field( 'main_text_color', 'option' ) ) { ?>
        .avia-section{
            <?php 
                punch_output_acf_css_var( 'main_background_color', '--sectionBgColor' );
                punch_output_acf_css_var( 'main_text_color', '--sectionColor' ); 
            ?>
        }
        <?php } ?>

        <?php if( get_field( 'alternate_background_color', 'option' ) || get_field( 'alternate_text_color', 'option' ) ) { ?>
        .avia-section.alternate_color{
            <?php 
                punch_output_acf_css_var( 'alternate_background_color', '--sectionBgColor' );
                punch_output_acf_css_var( 'alternate_text_color', '--sectionColor' ); 
            ?>
        }
        <?php } ?>


        /* Buttons */
        <?php
        if( have_rows( 'default_button_style', 'option' ) ):
            while( have_rows( 'default_button_style', 'option' ) ) : the_row();
        ?>
        div .avia-button,
        .button,
        .wp-block-button a,
        .menu-button .menu-item-inner{
            <?php
            punch_output_acf_css_var( 'font_size', '--buttonFontSize', true );
            punch_output_acf_css_var( 'font_family', '--buttonFontFamily', true );
            punch_output_acf_css_var( 'font_weight', '--buttonFontWeight', true );
            punch_output_acf_css_var( 'background_color', '--buttonBgColor', true );
            punch_output_acf_css_var( 'text_color', '--buttonColor', true );
            punch_output_acf_css_var( 'border_radius', '--buttonBorderRadius', true );
            punch_output_acf_css_var( 'padding', '--buttonPadding', true );
            ?>
        }
        <?php
        endwhile;
        endif;
        ?>
        <?php
            if( have_rows( 'button_styles', 'option' ) ):

                $i = 1;
                while( have_rows( 'button_styles', 'option' ) ) : the_row();
                    $style = sanitize_title( get_sub_field( 'name' ) );
                    echo "div .avia-style-" . $style . " {";
                        punch_output_acf_css_var( 'font_size', '--buttonFontSize', true );
                        punch_output_acf_css_var( 'font_family', '--buttonFontFamily', true );
                        punch_output_acf_css_var( 'font_weight', '--buttonFontWeight', true );
                        punch_output_acf_css_var( 'background_color', '--buttonBgColor', true );
                        punch_output_acf_css_var( 'text_color', '--buttonColor', true );
                        punch_output_acf_css_var( 'border_radius', '--buttonBorderRadius', true );
                        punch_output_acf_css_var( 'padding', '--buttonPadding', true );
                    echo "}";
                    $i++;
                endwhile;
            endif;


            /* Headings */
            if( have_rows( 'all_headings', 'option' ) ):
                while( have_rows( 'all_headings', 'option' ) ) : the_row();

                    if( have_rows( 'heading_settings_h1', 'option' ) ):
                        while( have_rows( 'heading_settings_h1', 'option' ) ) : the_row();
                            ?>
                                h1, .h1 .av-special-heading-tag{
                                    <?php
                                    punch_output_acf_css_var( 'heading_color', '--headingColor', true );
                                    punch_output_acf_css_var( 'heading_alternate_color', '--headingColorAlt', true );
                                    punch_output_acf_css_var( 'heading_font_size', '--headingSize', true );
                                    punch_output_acf_css_var( 'heading_font_weight', '--headingWeight', true );
                                    punch_output_acf_css_var( 'heading_font_family', '--headingFontFamily', true );
                                    punch_output_acf_css_var( 'heading_line_height', '--headingLineHeight', true );
                                    punch_output_acf_css_var( 'heading_letter_spacing', '--headingLetterSpacing', true );
                                    punch_output_acf_css_var( 'heading_text_transform', '--headingTransform', true );
                                    punch_output_acf_css_var( 'heading_font_size_tablet', '--headingSizeTablet', true );
                                    punch_output_acf_css_var( 'heading_font_size_mobile', '--headingSizeMobile', true );
                                    ?>
                                }
                            <?php
                        endwhile;
                    endif;

                    if( have_rows( 'heading_settings_h2', 'option' ) ):
                        while( have_rows( 'heading_settings_h2', 'option' ) ) : the_row();
                            ?>
                                h2, .h2 .av-special-heading-tag{
                                    <?php
                                    punch_output_acf_css_var( 'heading_color', '--headingColor', true );
                                    punch_output_acf_css_var( 'heading_alternate_color', '--headingColorAlt', true );
                                    punch_output_acf_css_var( 'heading_font_size', '--headingSize', true );
                                    punch_output_acf_css_var( 'heading_font_weight', '--headingWeight', true );
                                    punch_output_acf_css_var( 'heading_font_family', '--headingFontFamily', true );
                                    punch_output_acf_css_var( 'heading_line_height', '--headingLineHeight', true );
                                    punch_output_acf_css_var( 'heading_letter_spacing', '--headingLetterSpacing', true );
                                    punch_output_acf_css_var( 'heading_text_transform', '--headingTransform', true );
                                    punch_output_acf_css_var( 'heading_font_size_tablet', '--headingSizeTablet', true );
                                    punch_output_acf_css_var( 'heading_font_size_mobile', '--headingSizeMobile', true );
                                    ?>
                                }
                            <?php
                        endwhile;
                    endif;

                    if( have_rows( 'heading_settings_h3', 'option' ) ):
                        while( have_rows( 'heading_settings_h3', 'option' ) ) : the_row();
                            ?>
                                h3, .h3 .av-special-heading-tag{
                                    <?php
                                    punch_output_acf_css_var( 'heading_color', '--headingColor', true );
                                    punch_output_acf_css_var( 'heading_alternate_color', '--headingColorAlt', true );
                                    punch_output_acf_css_var( 'heading_font_size', '--headingSize', true );
                                    punch_output_acf_css_var( 'heading_font_weight', '--headingWeight', true );
                                    punch_output_acf_css_var( 'heading_font_family', '--headingFontFamily', true );
                                    punch_output_acf_css_var( 'heading_line_height', '--headingLineHeight', true );
                                    punch_output_acf_css_var( 'heading_letter_spacing', '--headingLetterSpacing', true );
                                    punch_output_acf_css_var( 'heading_text_transform', '--headingTransform', true );
                                    punch_output_acf_css_var( 'heading_font_size_tablet', '--headingSizeTablet', true );
                                    punch_output_acf_css_var( 'heading_font_size_mobile', '--headingSizeMobile', true );
                                    ?>
                                }
                            <?php
                        endwhile;
                    endif;

                    if( have_rows( 'heading_settings_h4', 'option' ) ):
                        while( have_rows( 'heading_settings_h4', 'option' ) ) : the_row();
                            ?>
                                h4, .h4 .av-special-heading-tag{
                                    <?php
                                    punch_output_acf_css_var( 'heading_color', '--headingColor', true );
                                    punch_output_acf_css_var( 'heading_alternate_color', '--headingColorAlt', true );
                                    punch_output_acf_css_var( 'heading_font_size', '--headingSize', true );
                                    punch_output_acf_css_var( 'heading_font_weight', '--headingWeight', true );
                                    punch_output_acf_css_var( 'heading_font_family', '--headingFontFamily', true );
                                    punch_output_acf_css_var( 'heading_line_height', '--headingLineHeight', true );
                                    punch_output_acf_css_var( 'heading_letter_spacing', '--headingLetterSpacing', true );
                                    punch_output_acf_css_var( 'heading_text_transform', '--headingTransform', true );
                                    punch_output_acf_css_var( 'heading_font_size_tablet', '--headingSizeTablet', true );
                                    punch_output_acf_css_var( 'heading_font_size_mobile', '--headingSizeMobile', true );
                                    ?>
                                }
                            <?php
                        endwhile;
                    endif;

                    if( have_rows( 'heading_settings_h5', 'option' ) ):
                        while( have_rows( 'heading_settings_h5', 'option' ) ) : the_row();
                            ?>
                                h5, .h5 .av-special-heading-tag{
                                    <?php
                                    punch_output_acf_css_var( 'heading_color', '--headingColor', true );
                                    punch_output_acf_css_var( 'heading_alternate_color', '--headingColorAlt', true );
                                    punch_output_acf_css_var( 'heading_font_size', '--headingSize', true );
                                    punch_output_acf_css_var( 'heading_font_weight', '--headingWeight', true );
                                    punch_output_acf_css_var( 'heading_font_family', '--headingFontFamily', true );
                                    punch_output_acf_css_var( 'heading_line_height', '--headingLineHeight', true );
                                    punch_output_acf_css_var( 'heading_letter_spacing', '--headingLetterSpacing', true );
                                    punch_output_acf_css_var( 'heading_text_transform', '--headingTransform', true );
                                    punch_output_acf_css_var( 'heading_font_size_tablet', '--headingSizeTablet', true );
                                    punch_output_acf_css_var( 'heading_font_size_mobile', '--headingSizeMobile', true );
                                    ?>
                                }
                            <?php
                        endwhile;
                    endif;

                    if( have_rows( 'heading_settings_h6', 'option' ) ):
                        while( have_rows( 'heading_settings_h6', 'option' ) ) : the_row();
                            ?>
                                h6, .h6 .av-special-heading-tag{
                                    <?php
                                    punch_output_acf_css_var( 'heading_color', '--headingColor', true );
                                    punch_output_acf_css_var( 'heading_alternate_color', '--headingColorAlt', true );
                                    punch_output_acf_css_var( 'heading_font_size', '--headingSize', true );
                                    punch_output_acf_css_var( 'heading_font_weight', '--headingWeight', true );
                                    punch_output_acf_css_var( 'heading_font_family', '--headingFontFamily', true );
                                    punch_output_acf_css_var( 'heading_line_height', '--headingLineHeight', true );
                                    punch_output_acf_css_var( 'heading_letter_spacing', '--headingLetterSpacing', true );
                                    punch_output_acf_css_var( 'heading_text_transform', '--headingTransform', true );
                                    punch_output_acf_css_var( 'heading_font_size_tablet', '--headingSizeTablet', true );
                                    punch_output_acf_css_var( 'heading_font_size_mobile', '--headingSizeMobile', true );
                                    ?>
                                }
                            <?php
                        endwhile;
                    endif;

                endwhile;
            endif;
        ?>
    </style>
    <?php
});
