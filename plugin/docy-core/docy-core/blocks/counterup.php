<?php
function docy_acf_block_counterup(){
    ?>
    <style>
        .docy-counter-item .icon i {
            font-size: 50px;
        }
        .docy-counter-item .icon img {
            width: 100%;
            height: auto;
        }
        .docy-counter-item .counter-info span.num-prefix,
        .docy-counter-item .counter-info span.num-suffix {
            font-weight: 900;
            line-height: 0.7em
        }
        .docy-counter-item .counter-info span.counter {
            font-weight: 900;
            line-height: 0.7em
        }
        .docy-counter-item .counter-info .counter-title span {
            line-height: 1.8em;
            font-weight: 400;
        }
        .acf-image-uploader.has-value .hide-if-value {
            display: block;
            clear: both;
            float: left;
            margin: 1em 0;
        }
        .acf-image-uploader.has-value .hide-if-value p {
            visibility: hidden;
        }
        .acf-image-uploader.has-value .hide-if-value p a {
            visibility: visible;
            float: left;
            color: transparent;
            padding-right: 2.5em;
        }
        .acf-image-uploader.has-value .hide-if-value p a:before {
            visibility: visible;
            content: "Change Image";
            position: absolute;
            color: #0071a1;
        }
    </style>
    <div class="container">
        <div class="row">
        <?php if ( have_rows('counter_box') ) : ?>
        <?php while ( have_rows('counter_box') ) : the_row(); ?>
        <?php
        $padding = get_sub_field('box_padding');
        $pt = !empty($padding['box_pt']) ? $padding['box_pt'] : '50';
        $pr = !empty($padding['box_pr']) ? $padding['box_pr'] : '50';
        $pb = !empty($padding['box_pb']) ? $padding['box_pb'] : '50';
        $pl = !empty($padding['box_pl']) ? $padding['box_pl'] : '50';
        $radius = get_sub_field('box_border_radius');
        $radius_tl = !empty($radius['radius_tl']) ? $radius['radius_tl'] : '8';
        $radius_tr = !empty($radius['radius_tr']) ? $radius['radius_tr'] : '8';
        $radius_br = !empty($radius['radius_br']) ? $radius['radius_br'] : '8';
        $radius_bl = !empty($radius['radius_bl']) ? $radius['radius_bl'] : '8';
        ?>
        <div class="col-lg-4">
            <div class="docy-counter-item d-flex align-items-center" style="padding-top: <?php echo $pt . 'px'; ?>; padding-right: <?php echo $pr . 'px'; ?>; padding-bottom: <?php echo $pb . 'px'; ?>; padding-left: <?php echo $pl . 'px'; ?>; background-color: <?php echo !empty(get_sub_field('box_background_color')) ? get_sub_field('box_background_color') : '#ffffff'; ?>; border-top-left-radius: <?php echo $radius_tl . 'px'; ?>; border-top-right-radius: <?php echo $radius_tr . 'px'; ?>; border-bottom-right-radius: <?php echo $radius_br . 'px'; ?>; border-bottom-left-radius: <?php echo $radius_bl . 'px'; ?>; margin-bottom: <?php echo !empty(get_sub_field('box_margin_bottom')) ? get_sub_field('box_margin_bottom') : '0' ?>px; border: <?php echo !empty(get_sub_field('border_width')) ? get_sub_field('border_width') : '1' ?>px solid <?php echo !empty(get_sub_field('border_color')) ? get_sub_field('border_color') : '#EAEEEF'; ?>;">
                <div class="icon">
                    <?php
                    $img = get_sub_field('counter_image');
                    if ( !empty($img) ) {
                        $img_url = $img['url'];
                        ?>
                        <img style="max-width: <?php echo !empty(get_sub_field('image_size')) ? get_sub_field('image_size') : '50'; ?>px;" src="<?php echo esc_attr($img_url); ?>" alt="<?php echo esc_attr(get_sub_field('counter_title')); ?>" class="img-fluid">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo  plugins_url() . '/docy-core/assets/images/default-icon.png'; ?>" alt="Default Icon">
                        <?php
                    }
                    ?>
                </div>
                <div class="counter-info" style="margin-left: <?php echo !empty(get_sub_field('number_gap')) ? get_sub_field('number_gap') : '30'; ?>px; ">
                    <span style="color:<?php echo !empty(get_sub_field('prefix_color')) ? get_sub_field('prefix_color') : '#6b707f'; ?>; font-size: <?php echo !empty(get_sub_field('prefix_font_size')) ? get_sub_field('prefix_font_size') : '30'; ?>px; margin-right: <?php echo !empty(get_sub_field('prefix_gap')) ? get_sub_field('prefix_gap') : '8'; ?>px;" class="num-prefix"><?php echo get_sub_field('number_prefix'); ?></span>
                    <span class="counter" style="color: <?php echo !empty(get_sub_field('number_color')) ? get_sub_field('number_color') : '#0c0d0e';?>; font-size: <?php echo !empty(get_sub_field('number_font_size')) ? get_sub_field('number_font_size') : '30'; ?>px;"><?php echo get_sub_field('count_number'); ?></span>
                    <span style="color:<?php echo !empty(get_sub_field('suffix_color')) ? get_sub_field('suffix_color') : '#6b707f'; ?>; font-size: <?php echo !empty(get_sub_field('suffix_font_size')) ? get_sub_field('suffix_font_size') : '30'; ?>px; margin-left: <?php echo !empty(get_sub_field('suffix_gap')) ? get_sub_field('suffix_gap') : '8'; ?>px;" class="num-suffix"><?php echo get_sub_field('number_suffix'); ?></span>
                    <div style="text-align: <?php echo get_sub_field('text_alignment'); ?>; color: <?php echo !empty(get_sub_field('title_color')) ? get_sub_field('title_color') : '#6b707f'; ?>; font-size: <?php echo !empty(get_sub_field('title_font_size')) ? get_sub_field('title_font_size') : '19'; ?>px;" class="counter-title"><span><?php echo get_sub_field('counter_title'); ?></span></div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            function counterUp() {
                if (jQuery('.counter').length) {
                    jQuery('.counter').counterUp({
                        delay: <?php echo !empty(get_field('animation_delay')) ? get_field('animation_delay') : '16'; ?>,
                        time: <?php echo !empty(get_field('animation_duration')) ? get_field('animation_duration') : '2000'; ?>
                    })
                }
            }
            counterUp();
        });
    </script>
    <?php
}