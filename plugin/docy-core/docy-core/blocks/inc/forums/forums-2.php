<div class="communities-boxes">
    <?php
    $forums = new WP_Query(array(
        'post_type' => 'forum',
        'posts_per_page' => !empty(get_field('docy_show_forums')) ? get_field('docy_show_forums') : 5,
        'order' => get_field('docy_order_by'),
    ));
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
        <?php echo esc_html(get_field('docy_forum_btn')) ?> <i class="icon_plus"></i>
    </a>

    <div class="collapse-wrap" id="more-category">
        <div class="communities-boxes">
            <?php
            if ( get_field('docy_order_by') == 'docy_asc' ) {
                $order = 'ASC';
            } elseif ( get_field('docy_order_by') == 'docy_desc' ) {
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