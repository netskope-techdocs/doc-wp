<?php
$opt = get_option('docy_opt' );
$post_author_id = get_post_field( 'post_author', get_the_ID() );
$banner_shape_01 = function_exists('get_field') ? get_field('banner_shape_01') : '';
$banner_shape_02 = function_exists('get_field') ? get_field('banner_shape_02') : '';
$banner_shape_opt_01 = docy_opt('banner_shape_01');
$banner_shape_opt_02 = docy_opt('banner_shape_02');
?>
<section class="doc_banner_area single_breadcrumb">
    <ul class="list-unstyled banner_shap_img">
        <li>
            <?php
            if ( !empty($banner_shape_01) ) {
                echo wp_get_attachment_image($banner_shape_01, 'full');
            }
            elseif ( !empty($banner_shape_opt_01['id'])) {
                echo wp_get_attachment_image($banner_shape_opt_01['id'], 'full');
            } else { ?>
                <img src="<?php echo DOCY_DIR_IMG . '/banner-blog/banner_shap1.png' ?>" alt="<?php esc_attr_e( 'banner shape', 'docy' ) ?>">
                <?php
            }
            ?>
        </li>
        <li><img src="<?php echo DOCY_DIR_IMG . '/banner-blog/banner_shap4.png' ?>" alt="<?php esc_attr_e('banner shape', 'docy') ?>"></li>
        <li><img src="<?php echo DOCY_DIR_IMG . '/banner-blog/banner_shap3.png' ?>" alt="<?php esc_attr_e('banner shape', 'docy') ?>"></li>
        <li>
            <?php
            if ( !empty($banner_shape_02) ) {
                echo wp_get_attachment_image($banner_shape_02, 'full');
            }
            elseif ( !empty($banner_shape_opt_02['id'])) {
                echo wp_get_attachment_image($banner_shape_opt_02['id'], 'full');
            } else { ?>
                <img src="<?php echo DOCY_DIR_IMG . '/banner-blog/banner_shap2.png' ?>" alt="<?php esc_attr_e( 'banner shape', 'docy' ) ?>">
                <?php
            }
            ?>
        </li>

        <li><img data-parallax='{"x": -180, "y": 80, "rotateY":2000}' src="<?php echo DOCY_DIR_IMG . '/banner-blog/plus1.png' ?>" alt="<?php esc_attr_e('plus icon', 'docy') ?>"></li>
        <li><img data-parallax='{"x": -50, "y": -160, "rotateZ":200}' src="<?php echo DOCY_DIR_IMG . '/banner-blog/plus2.png' ?>" alt="<?php esc_attr_e('plus icon', 'docy') ?>"></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="container">
        <div class="doc_banner_content">
            <?php the_title('<h1 class="title">', '</h1>') ?>
            <?php get_template_part('template-parts/single-post/post-meta'); ?>
        </div>
    </div>
</section>