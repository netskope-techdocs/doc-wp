<section class="doc_features_area">
    <?php
    docy_el_image($settings['shape1'], 'Background shape', 'doc_features_shap');
    ?>
    <div class="container">
        <div class="doc_features_inner">
            <?php
            $delay = 0.1;
            $duration = 0.5;
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
                $forums2 = new WP_Query(array(
                    'post_type' => 'forum',
                    'posts_per_page' => !empty($settings['ppp2']) ? $settings['ppp2'] : 10,
                    'offset' => !empty($settings['ppp']) ? $settings['ppp'] : 5,
                    'order' => $settings['order'],
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
            <a href="#more-features" class="collapse-btn see_btn">
                <i class="arrow_carrot-down"></i>
                <span class="more"> <?php echo esc_html($settings['more_txt']) ?> </span>
                <span class="less"> <?php echo esc_html($settings['less_txt']) ?> </span>
            </a>
        </div>
    </div>
</section>