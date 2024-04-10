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
        <div class="row h_content_items">
            <?php

            foreach ( $sections as $section ) :
                ?>
                <div class="col-lg-3 col-sm-6">
                    <div class="h_item">
                        <?php echo !empty($section->ID) ? get_the_post_thumbnail($section->ID, 'full') : ''; ?>
                        <a href="<?php echo get_permalink($section->ID) ?>">
                            <h4 class="ct-heading-text"><?php echo wp_kses_post($section->post_title); ?></h4>
                        </a>
                        <div class="ct-content-text">
                        <?php
                        if ( strlen(trim($section->post_excerpt)) != 0 ) {
                            echo wpautop($section->post_excerpt);
                        } else {
                            echo wpautop(wp_trim_words($section->post_content, get_field('excerpt'), ''));
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>

        <?php
        $sections2 = get_children( array(
            'post_parent'    => get_field('docy_doc_type'),
            'post_type'      => 'docs',
            'post_status'    => 'publish',
            'orderby'        => 'menu_order',
            'order'          => $order,
            'posts_per_page' => !empty(get_field('docy_doc_sections')) ? get_field('docy_doc_sections') : -1,
            'offset'         => !empty(get_field('doc_offset')) ? get_field('doc_offset') : 8,
        ));
        ?>
        <div class="h_content_items box-item collapse-wrap">
            <div class="row">
                <?php
                foreach ( $sections2 as $section ) :
                    ?>
                    <div class="col-lg-3 col-sm-6">
                        <div class="h_item">
                            <?php echo !empty($section->ID) ? get_the_post_thumbnail($section->ID, 'full') : ''; ?>
                            <a href="<?php echo get_permalink($section->ID) ?>">
                                <h4 class="ct-heading-text"><?php echo wp_kses_post($section->post_title); ?></h4>
                            </a>
                            <div class="ct-content-text">
                                <?php
                                    if ( strlen(trim($section->post_excerpt)) != 0 ) {
                                        echo wpautop($section->post_excerpt);
                                    } else {
                                        echo wpautop(wp_trim_words($section->post_content, get_field('excerpt'), ''));
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
        <?php if ( !empty(get_field('sm_btn')) ) : ?>
            <div class="more text-center">
                <a class="icon_btn2 blue collapse-btn" href="#">
                    <span> <ion-icon name="caret-down-circle-outline"></ion-icon><?php echo get_field('sm_btn') ?></span>
                    <span> <ion-icon name="caret-up-circle-outline"></ion-icon><?php echo get_field('sl_btn') ?></span>
                </a>
            </div>
        <?php endif; ?>