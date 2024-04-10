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
?>
<div class="container">
    <div class="row">
        <?php
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
            <div class="col-lg-4 col-sm-6">
                <div class="categories_guide_item box-item wow fadeInUp">
                    <?php
                    if ( has_post_thumbnail($section->ID) ) {
                        echo get_the_post_thumbnail($section->ID, 'full');
                    }
                    ?>
                    <a class="doc_tag_title" href="<?php echo get_permalink($section->ID) ?>">
                        <h4 class="ct-heading-text"><?php echo wp_kses_post($section->post_title); ?></h4>
                    </a>
                    <ul class="list-unstyled tag_list">
                        <?php
                        foreach ( $doc_items as $doc_item ) : ?>
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
                    if ( !empty(get_field('sd_read_more_txt')) ) : ?>
                        <a href="<?php echo get_permalink($section->ID); ?>" class="doc_border_btn">
                            <?php echo esc_html(get_field('sd_read_more_txt')) ?>
                            <i class="<?php docycore_arrow_left_right() ?>"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        endforeach;
        ?>
    </div>
	<?php
	if ( get_field('docy_doc_sec_btn') == '1' && !empty(get_field('docy_btn_txt') ) ) : ?>
    <div class="text-center">
        <a href="<?php echo esc_url(get_field('docy_doc_btn_url')); ?>" class="action_btn all_doc_btn wow fadeinUp">
            <?php echo esc_html(get_field('docy_btn_txt')) ?><i class="<?php docycore_arrow_left_right() ?>"></i>
        </a>
    </div>
	<?php endif; ?>
</div>