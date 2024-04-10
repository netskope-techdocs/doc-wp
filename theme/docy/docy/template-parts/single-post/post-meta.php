<?php
$opt = get_option('docy_opt' );
$post_meta = $opt['is_single_post_meta'] ?? '1';
if ( $post_meta == '1' ) :
    ?>
    <div class="single_post_author d-flex justify-content-center">
        <div class="text post_tag">
            <?php
            $post_date = $opt['is_single_post_date'] ?? '';
            if ( $post_date == '1' ) :
                ?>
                <a href="<?php Docy_helper()->day_link(); ?>" class="meta-item date">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <?php the_time(get_option('date_format')); ?>
                </a>
                <?php
            endif;

            $reading_time = $opt['is_single_reading_time'] ?? '';
            if ( $reading_time == '1' ) :
                ?>
                <div class="meta-item read-time" title="<?php docy_reading_time(get_the_ID()); esc_html_e(' to read this post', 'docy'); ?>">
                    <ion-icon name="time-outline"></ion-icon>
                    <?php docy_reading_time(get_the_ID()); ?>
                </div>
                <?php
            endif;

            $is_single_cats = $opt['is_single_cats'] ?? '';
            if ( $is_single_cats == '1' ) :
                ?>
                <div class="cats meta-item">
                    <ion-icon name="pricetags-outline"></ion-icon>
                    <?php the_category(','); ?>
                </div>
                <?php
            endif;
            
            if ( function_exists('docy_post_share') ) {
                docy_post_share();
            }
            
           docy_post_views(get_the_ID());
            ?>
            <div class="views meta-item">
                <ion-icon name="eye"></ion-icon>
                <span> <?php echo get_post_meta( get_the_ID(), 'docy_post_views_count', true ) . __( ' Views', 'docy' ); ?> </span>
            </div>
                
        </div>
    </div>
    <div class="docy-link-copied-wrap"></div>
<?php
endif;