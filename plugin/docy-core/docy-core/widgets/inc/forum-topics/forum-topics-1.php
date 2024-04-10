<div class="community-posts-wrapper bew-topics">
    <?php
    while ( $forum_posts->have_posts() ) : $forum_posts->the_post();
        $favoriters = bbp_get_topic_favoriters();
        $favorite_count = !empty($favoriters) ? $favoriters[0] : '0';
        ?>
        <div class="community-post topic-item wow fadeInUp" data-wow-delay="0.5s">
            <div class="post-content">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40) ?>
                </div>
                <div class="entry-content">
                    <h3 class="post-title">
                        <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
                    </h3>
                    <?php esc_html_e('Last active: ', 'docy-core'); echo bbp_get_forum_last_active_time(get_the_ID()) ?>
                </div>
            </div>
            <div class="post-meta-wrapper">
                <ul class="post-meta-info">
                    <li>
                        <a href="<?php bbp_topic_permalink(); ?>">
                            <i class="icon_chat_alt"></i>
                            <?php bbp_show_lead_topic() ? bbp_topic_reply_count(get_the_ID()) : bbp_topic_post_count(get_the_ID()); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php bbp_topic_permalink(); ?>">
                            <i class="icon_star_alt"></i> <?php echo esc_html($favorite_count) ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();
    ?>
</div>