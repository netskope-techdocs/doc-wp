<div class="communities-boxes">
    <?php
    while( $forums->have_posts() ) : $forums->the_post();
        ?>
        <div class="docy-com-box wow fadeInRight" data-wow-delay="0.5s">
            <div class="icon-container">
                <?php the_post_thumbnail('full'); ?>
            </div>
            <div class="docy-com-box-content">
                <h3 class="title">
                    <a href="<?php the_permalink(); ?>"> <?php the_title() ?> </a>
                </h3>
                <p class="total-post"> <?php bbp_forum_topic_count(get_the_ID()); ?> <?php esc_html_e('Posts', 'docy') ?> </p>
            </div>
            <!-- /.docy-com-box-content -->
        </div>
        <!-- /.docy-com-box -->
        <?php
    endwhile;
    wp_reset_postdata();
    ?>
</div>
<!-- /.communities-boxes -->

<div class="more-communities">

    <a href="#more-category" class="collapse-btn">
        <?php echo esc_html($settings['more_txt']) ?> <i class="icon_plus"></i>
    </a>

    <div class="collapse-wrap" id="more-category">
        <div class="communities-boxes">
            <?php
            $forums2 = new WP_Query(array(
                'post_type' => 'forum',
                'posts_per_page' => !empty($settings['ppp2']) ? $settings['ppp2'] : 10,
                'offset' => !empty($settings['ppp']) ? $settings['ppp'] : 5,
                'order' => $settings['order'],
            ));
            while( $forums2->have_posts() ) : $forums2->the_post();
                ?>
                <div class="docy-com-box">
                    <div class="icon-container">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <div class="docy-com-box-content">
                        <h3 class="title">
                            <a href="<?php the_permalink(); ?>"> <?php the_title() ?> </a>
                        </h3>
                        <p class="total-post"> <?php bbp_forum_topic_count(get_the_ID()); ?> <?php esc_html_e('Posts', 'docy-core') ?> </p>
                    </div>
                    <!-- /.docy-com-box-content -->
                </div>
                <!-- /.docy-com-box -->
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <!-- /.communities-boxes -->
    </div>
    <!-- /.collapse-wrap -->
</div>
<!-- /.more-communities -->