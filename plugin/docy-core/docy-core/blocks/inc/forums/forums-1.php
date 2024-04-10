<section class="doc_features_area">
    <?php 
        $top_margin = get_field('sec_margin');
        $margin_top = !empty($top_margin) ? $top_margin : '' ;
    ?>
    <style>
        .doc_features_inner{
            top: <?php echo esc_attr( $margin_top ); ?>px
        }
    </style>
    <?php

    if(!empty(get_field('forum_bg_shape'))){
        $bg_img = get_field('forum_bg_shape');
        docy_el_image($bg_img['url'], 'Background shape', 'doc_features_shap');
    }
    ?>
    <div class="container">
        <div class="doc_features_inner">
            <?php
            $delay = 0.1;
            $duration = 0.5;
            $forums = new WP_Query(array(
                'post_type' => 'forum',
                'posts_per_page' => !empty(get_field('docy_show_forums')) ? get_field('docy_show_forums') : 5,
                'order' => get_field('docy_order_by'),
            ));
            while( $forums->have_posts() ) : $forums->the_post();
                ?>
                <div class="media d-flex doc_features_item wow fadeInUp" data-wow-delay="<?php echo esc_attr($delay) ?>s" data-wow-duration="<?php echo esc_attr($duration) ?>s">
                    <?php the_post_thumbnail('full'); ?>
                    <div class="media-body">
                        <a href="<?php the_permalink(); ?>">
                            <h4><?php the_title() ?></h4>
                        </a>
                        <p><?php bbp_forum_topic_count(get_the_ID()); ?> <?php esc_html_e('Posts', 'docy') ?></p>
                    </div>
                </div>
                <?php
                $delay = $delay + 0.1;
                $duration = $duration + 0.1;
            endwhile;
            wp_reset_postdata();
            ?>
            <div class="see_more_item collapse-wrap">
                <?php
                if( get_field('docy_order_by') == 'docy_asc' ) {
                    $order = 'ASC';
                } elseif (get_field('docy_order_by') == 'docy_desc') {
                    $order = 'DESC';
                }
                $forums2 = new WP_Query(array(
                    'post_type' => 'forum',
                    'posts_per_page' => !empty(get_field('docy_hidden_forums')) ? get_field('docy_hidden_forums') : 10,
                    'offset' => !empty(get_field('docy_show_forums')) ? get_field('docy_show_forums') : 5,
                    'order' => $order,
                ));
                while( $forums2->have_posts() ) : $forums2->the_post();
                    ?>
                    <div class="media d-flex doc_features_item">
                        <?php the_post_thumbnail('full'); ?>
                        <div class="media-body">
                            <a href="<?php the_permalink(); ?>">
                                <h4><?php the_title() ?></h4>
                            </a>
                            <p><?php bbp_forum_topic_count(get_the_ID()); ?> <?php esc_html_e('Posts', 'docy-core') ?></p>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
 
                ?>
            </div>
            <a href="#more-features" class="collapse-btn see_btn"><i class="arrow_carrot-down_alt2"></i>
                <?php echo esc_html(get_field('docy_forum_btn')) ;  ?>
            </a>
        </div>
    </div>
</section>