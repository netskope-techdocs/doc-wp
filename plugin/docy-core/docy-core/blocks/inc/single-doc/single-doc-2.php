<?php
if ( ! empty( get_field('docy_doc_type') ) ) {
    if ( get_field('docy_doc_order') == 'docy_doc_asc' ) {
        $order = 'ASC';
    } elseif ( get_field('docy_doc_order') == 'docy_doc_desc' ) {
        $order = 'DESC';
    }
    $sections = get_children(array(
        'post_parent' => get_field('docy_doc_type'),
        'post_type' => 'docs',
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => $order,
        'posts_per_page' => !empty(get_field('docy_doc_sections')) ? get_field('docy_doc_sections') : 8,
    ));
}
$box_padding = get_field('sd_box_padding');
//$padding_top = ! empty( $box_padding['padding_top'] ) ? $box_padding['padding_top']."px" : '';
$padding_right = ! empty( $box_padding['padding_right'] ) ? $box_padding['padding_right']."px" : '';
$padding_bottom = ! empty( $box_padding['padding_bottom'] ) ? $box_padding['padding_bottom']."px" : '';
$padding_left = ! empty( $box_padding['padding_left'] ) ? $box_padding['padding_left']."px" : '';
$box_bg = ! empty( get_field( 'box_bg_color' ) ) ? get_field( 'box_bg_color' ) : '#fbfbfc';

?>
<style>
    .recommended_item{
        padding-top: <?php echo esc_attr( $box_padding['padding_top'] ) ?>;
        padding-right:  <?php echo esc_attr( $padding_right ) ?>;
        padding-bottom: <?php echo esc_attr( $padding_bottom ) ?>;
        padding-left: <?php echo esc_attr( $padding_left ) ?>;
        background: <?php echo esc_attr( $box_bg ) ?>;

    }

</style>
<section class="recommended_topic_area">
    <div class="container">
        <div class="recommended_topic_inner">
            <?php if ( get_field('docy_doc_bg_obj') == '1' ) : ?>
            <?php if( ! empty(get_field('docy_doc_bg_shape')) ) : ?>
            <?php docy_el_image(get_field('docy_doc_bg_shape'), 'curve shape', 'doc_shap_one'); ?>
            <?php endif; ?>
            <?php if( get_field('docy_round_obj1') == '1' ) : ?>
                <div class="doc_round one" data-parallax='{"x": -80, "y": -100, "rotateY":0}'></div>
            <?php endif; ?>
            <?php if( get_field('docy_round_obj2') == '1' ) : ?>
                <div class="doc_round two" data-parallax='{"x": -10, "y": 70, "rotateY":0}'></div>
            <?php endif; ?>
            <?php endif; ?>

            <?php if ( !empty(get_field('docy_doc_tt') || get_field('docy_doc_subtt')) ) : ?>
                <div class="doc_title text-center">
                    <?php echo !empty(get_field('docy_doc_tt')) ? sprintf( '<h2 class="title" data-animation="wow fadeInUp" data-wow-delay="0.2s"> %2$s </h2>', get_field('docy_doc_tt'), nl2br(get_field('docy_doc_tt')) ) : ''; ?>
                    <?php if (!empty(get_field('docy_doc_subtt')) ) : ?>
                        <p class="subtitle wow fadeInUp" data-wow-delay="0.4s"> <?php echo wp_kses_post(get_field('docy_doc_subtt')); ?> </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php
                $delay = 0.2;
                foreach ( $sections as $section ) :
                    $doc_items = get_children( array(
                        'post_parent'    => $section->ID,
                        'post_type'      => 'docs',
                        'post_status'    => 'publish',
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                        'posts_per_page' => !empty(get_field('docy_doc_articles')) ? get_field('docy_doc_articles') : -1,
                    ));
                ?>
                    <div class="col-lg-3 col-6">
                        <div class="recommended_item box-item wow fadeInUp" data-wow-delay="<?php echo esc_attr($delay) ?>s">
                            <?php
                            if ( has_post_thumbnail($section->ID) ) {
                                echo get_the_post_thumbnail($section->ID, 'full');
                            }

                            if ( !empty($section->post_title) ) { ?>
                                <a href="<?php echo get_permalink($section->ID); ?>">
                                    <h3 class="ct-heading-text"> <?php echo wp_kses_post( $section->post_title ); ?> </h3>
                                </a>
                                <?php
                            }

                            if ( !empty($doc_items) ) : ?>
                                <ul class="list-unstyled">
                                    <?php
                                    foreach ( $doc_items as $doc_item ) :
                                        ?>
                                        <li>
                                            <a class="ct-content-text" href="<?php echo get_permalink($doc_item->ID) ?>">
                                                <?php echo wp_kses_post($doc_item->post_title) ?>
                                            </a>
                                        </li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php
                    $delay = $delay + 0.1;
                endforeach;
                ?>
        </div>
        <?php
        if ( get_field('docy_doc_sec_btn') == '1' && !empty(get_field('docy_btn_txt')) ) : ?>
            <div class="text-center wow fadeInUp" data-wow-delay="0.2s">
                <a href="<?php echo esc_url(get_field('docy_doc_btn_url')); ?>" class="question_text">
                    <?php echo wp_kses_post(get_field('docy_btn_txt')) ?>
                </a>
            </div>
        <?php endif; ?>
        </div>
    </div>
</section>