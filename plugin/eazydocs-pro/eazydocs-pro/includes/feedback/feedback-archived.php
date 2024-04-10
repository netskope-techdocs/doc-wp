<?php 
$ezd_open_feedback = new WP_Query([
    'post_type'     => 'ezd_feedback',
    'posts_per_page'    => -1,
    'meta_query'    => array(
        array(
            'key' => 'ezd_feedback_status', 
            'value' => 'false',
            'compare' => '!='
        )
    )
]);

$ezd_archive_feedback = new WP_Query([
    'post_type'     => 'ezd_feedback',
    'posts_per_page'    => -1,
    'meta_query'    => array(
        array(
            'key' => 'ezd_feedback_status', 
            'value' => 'false',
            'compare' => '='
        )
    )
]);

$open_count = $ezd_open_feedback->post_count;
$archive_count = $ezd_archive_feedback->post_count;
?>

<div class="wrap">
    <h2>User Feedback</h2>
    
    <div class="ezd-feedback-wrap"> 

       <div class="ezd-head-options-wrap">
        <div class="ezd-head-opt-btn"> 
            <a href="admin.php?page=ezd-user-feedback">Open
                <span>(<?php echo $open_count; ?>)</span> 
            </a>
            <a href="admin.php?page=ezd-user-feedback-archived" class="active">Archived 
                <span>(<?php echo $archive_count; ?>)</span> 
            </a>
        </div>
        <div class="ezd-head-opt-search"> 
            <form method="get" action="admin.php?page=ezd-user-feedback-archived"> 
                <input type="hidden" name="page" value="ezd-user-feedback-archived">
                <input type="search" name="feedback_search" value="">
                <input type="submit" value="Search feedback" class="button button-default">;
            </form>
        </div>
       </div>

        <?php 
        if (  isset ( $_GET['feedback_search'] ) ) {
            include EAZYDOCSPRO_PATH . '/includes/feedback/feedback-archive-search.php';
        }else {
        if($ezd_archive_feedback->have_posts()) :
        while($ezd_archive_feedback->have_posts()) : $ezd_archive_feedback->the_post(); 
        $doc_id = get_post_meta(get_the_ID(),'ezd_feedback_id', true); 
        ?>
        <div class="ezd-feedback-item">
            <h2>
                <a href="<?php echo get_the_permalink($doc_id); ?>">
                <?php echo get_post_meta(get_the_ID(),'ezd_feedback_subject', true); ?>
                </a>
                - 
                <?php  echo get_post_meta(get_the_ID(),'ezd_feedback_name', true); ?>
            </h2>
            
            <div class="ezd-feedback-meta">
                <div class="ezd-meta-date-time">
                    <span class="dashicons dashicons-clock"></span>
                    <?php echo get_the_date(get_option('date_format') . ' ' . get_option('time_format')); ?>
                </div>
                <div class="ezd-meta-mail">
                    <span class="dashicons dashicons-email-alt"></span>
                    <a href="mailto:<?php echo get_post_meta(get_the_ID(),'ezd_feedback_email', true); ?>">
                        <?php echo get_post_meta(get_the_ID(),'ezd_feedback_email', true); ?>
                    </a>
                </div>
            </div>
            <?php echo wpautop(get_the_content(get_the_ID())); ?>
            <div class="ezd-feedback-btn">
                <a class="ezd-feedback-delete" href="admin.php?page=ezd-user-feedback&open_feedback_delete=<?php echo get_the_ID(); ?>&_wpnonce=<?php echo wp_create_nonce(get_the_ID()); ?>"><span class="dashicons dashicons-trash"></span></a>
                <a class="ezd-feedback-open" href="admin.php?page=ezd-user-feedback&feedback_open=<?php echo get_the_ID(); ?>&_wpnonce=<?php echo wp_create_nonce(get_the_ID()); ?>">
                    <span class="dashicons dashicons-hidden"></span>
                </a>
            </div>    
        </div>
        <?php endwhile;
        else: ?>
        <p class="ezd-no-feedback-found"><?php esc_html_e('No feedback found!', 'eazydocs-pro' ); ?></p>
        <?php 
        endif;
        wp_reset_postdata();
        }
        ?>

    </div>
</div>