<section class="doc_community_area bew-topics topics-block">
    <?php
    $topics_padding = get_field('topic_item_padding');
    docy_el_image(get_field('docy_lwe_shape1'), 'Background shape', 'shap_one');
    docy_el_image(get_field('docy_lwe_shape2'), 'Background shape', 'shap_two');
    ?>
    <style>
        .doc_community_item{
            padding-top: <?php echo esc_attr( $topics_padding['padding_top'] ); ?>px;
            padding-right:  <?php echo esc_attr( $topics_padding['padding_right'] ); ?>px;
            padding-bottom: <?php echo esc_attr( $topics_padding['padding_bottom'] ); ?>px;
            padding-left: <?php echo esc_attr( $topics_padding['padding_left'] ); ?>px;
        }
    </style>
    <div class="container">
        <div class="doc_title text-center">
            <?php if ( !empty( get_field('ft_title') ) ) : ?>
                <h2 class="title" data-animation="wow fadeInUp" data-wow-delay="0.2s"><?php echo  get_field('ft_title'); ?></h2>
            <?php endif; ?>
            <?php if ( !empty( get_field('ft_subtitle')) ) : ?>
                <p class="subtitle wow fadeInUp" data-wow-delay="0.4s"> <?php echo wp_kses_post( get_field('ft_subtitle') ); ?> </p>
            <?php endif; ?>
        </div>
        <div class="doc_community_info">
            <?php
            if ( get_field('docy_ft_order') == 'docy_ft_asc' ) {
                $order = 'ASC';
            } elseif (get_field('docy_ft_order') == 'docy_ft_desc' ) {
                $order = 'DESC';
            }

            $forum_posts = new WP_Query(array(
                'post_type' => 'topic',
                'posts_per_page' => !empty(get_field('docy_ft_st')) ? get_field('docy_ft_st') : -1,
                'order' => $order,
            ));
            $delay = 0.1;
            $duration = 0.5;
            while ( $forum_posts->have_posts() ) : $forum_posts->the_post();
                add_filter( 'excerpt_length', function (){
                    $excerpt_length = !empty(get_field('docy_lwe_len')) ? get_field('docy_lwe_len') : 12;
                    return $excerpt_length;
                }, 999 );
                $excerpt = wp_trim_excerpt('', get_the_ID());
                ?>
                <div class="doc_community_item topic-item wow fadeInUp" data-wow-delay="<?php echo esc_attr($delay) ?>s">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="doc_community_icon">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="doc_entry_content">
                        <a href="<?php the_permalink(); ?>">
                            <h4><?php the_title() ?></h4>
                        </a>
                        <?php echo wpautop($excerpt); ?>
                        <div class="doc_entry_info">
                            <ul class="list-unstyled author_avatar">
                                <?php
                                $replies = new WP_Query(array(
                                    'post_type' => 'reply',
                                    'post_per_page' => -1,
                                    'post_parent' => get_the_ID()
                                ));
                                $author_ids = [];
                                $author_names = '';
                                $show_avatar_count = !empty(get_field('docy_lwe_avatar')) ? get_field('docy_lwe_avatar') : 1;

                                $i = 1;
                                while ( $replies->have_posts() ) : $replies->the_post();
                                    $author_ids[get_the_author_meta('ID')] =  '';
                                    ++$i;
                                endwhile;

                                $author_count = count($author_ids);
                                $ii = 0;
                                foreach ( $author_ids as $author_id => $v ) {
                                    if ( $ii == $show_avatar_count ) {
                                        break;
                                    }
                                    echo '<li> ' . get_avatar($author_id, 36) . ' </li>';
                                    $author_separator = $ii == $author_count ? '' : ', ';
                                    $author_names .= get_the_author_meta('display_name', $author_id).$author_separator;
                                    ++$ii;
                                }
                                wp_reset_postdata();

                                $remaining_authors_count = $author_count - $show_avatar_count;
                                if ( $author_count > $show_avatar_count ) : ?>
                                    <li class="avatar_plus">+<?php echo $remaining_authors_count; ?></li>
                                <?php endif; ?>
                            </ul>

                            <?php if ( $author_count > $show_avatar_count ) : ?>
                                <div class="text">
                                    <?php echo esc_html($replies->found_posts) ?> <?php esc_html_e('Replies in this topic.'); ?> <br>
                                    <?php esc_html_e('Written by ', 'docy-core'); echo $author_names ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                $delay = $delay + 0.1;
                $duration = $duration + 0.1;
            endwhile;
            wp_reset_postdata();
            ?>
            <?php if ( !empty(get_field('docy_lwe_btc')) ) : ?>
                <div class="text-center wow fadeInUp" data-wow-delay="0.4s">
                   <?php echo wp_kses_post(get_field('docy_lwe_btc')) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>