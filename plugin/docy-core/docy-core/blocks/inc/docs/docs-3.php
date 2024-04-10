<?php
if ( get_field('order') == 'doc_asc' ) {
    $order = 'ASC';
} elseif ( get_field('order') == 'doc_desc' ){
    $order = 'DESC';
}
/**
 * Get the parent docs with query
 */
if ( !empty(get_field('exclude_docs')) ) {
    $parent_docs = get_pages(array(
        'post_type' => 'docs',
        'parent' => 0,
        'sort_order' => $order,
        'exclude' => get_field('exclude_docs')
    ));
} else {
    $parent_docs = get_pages(array(
        'post_type' => 'docs',
        'parent' => 0,
        'sort_order' => 'ASC',
    ));
}

/**
 * Get the doc sections
 */
if ( $parent_docs ) {
    foreach ( $parent_docs as $root ) {
        $sections = get_children( array(
            'post_parent'    => $root->ID,
            'post_type'      => 'docs',
            'post_status'    => 'publish',
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'posts_per_page' => !empty(get_field('show_section_count')) ? get_field('show_section_count') : -1,
        ));
        $docs[] = array(
            'doc'           => $root,
            'sections'      => $sections,
        );
    }
}
?>
<div class="question_menu docs3">
    <ul class="nav nav-tabs mb-5" role="tablist">
        <?php
        if ( get_field('custom_order') == '1' && !empty(get_field('custom_order_by')) ) {
            $custom_docs = !empty(get_field('custom_order_by')) ? get_field('custom_order_by') : '';
            $i = 0;
            foreach ( $custom_docs as $doc_item ) {
                $doc_id = $doc_item['doc_list'];
                // Active Doc
                if ( !empty(get_field('active_doc')) ) {
                    $active = $doc_id == get_field('active_doc') ? ' active' : '';
                } else {
                    $active = ( $i == 0 ) ? ' active' : '';
                }
                $post_title_slug = get_post_field('post_name', $doc_id);
                $doc_name = explode( ' ', get_the_title($doc_id) );
                $atts = "href='#doc-{$post_title_slug}'";
                $atts .= " aria-controls='doc-{$post_title_slug}'";
                ?>
                <li class="nav-item">
                    <a <?php echo $atts; ?> id="<?php echo $post_title_slug; ?>-tab" class="nav-link<?php echo esc_attr($active) ?>" data-toggle="tab">
                        <?php
                        echo get_the_post_thumbnail($doc_id, 'docy_16x16');
                        if ( get_field('tab_title_first_word') == '1' ) {
                            echo wp_kses_post($doc_name[0]);
                        } else {
                            echo wp_kses_post($doc_item->post_title);
                        }
                        ?>
                    </a>
                </li>
                <?php
                ++$i;
            }
        } else {
            if ( $parent_docs ) :
                foreach ($parent_docs as $i => $doc) :
                    // Active Doc
                    if ( !empty(get_field('active_doc')) ) {
                        $active = $doc->ID == get_field('active_doc') ? ' active' : '';
                    } else {
                        $active = ( $i == 0 ) ? ' active' : '';
                    }
                    $doc_name = explode( ' ', $doc->post_title );
                    $href = "href='#doc-{$doc->post_name}'";
                    $aria_controls = " aria-controls='doc-{$doc->post_name}'";
                    ?>
                    <li class="nav-item">
                        <a <?php echo $href.$aria_controls; ?> id="doc<?php echo $doc->post_name; ?>-tab" class="nav-link<?php echo esc_attr($active) ?>" data-toggle="tab">
                            <?php
                            echo get_the_post_thumbnail($doc->ID, 'docy_16x16');
                            if ( get_field('tab_title_first_word') == '1' ) {
                                echo wp_kses_post($doc_name[0]);
                            } else {
                                echo wp_kses_post($doc->post_title);
                            }
                            ?>
                        </a>
                    </li>
                <?php
                endforeach;
            endif;
        }
        ?>
    </ul>
    <div class="topic_list_inner">
        <div class="tab-content">
            <?php
            if ( !empty($docs) ) :
            foreach ( $docs as $i => $main_doc ) :
                // Active Doc
                if ( !empty(get_field('active_doc')) ) {
                    $active = $main_doc['doc']->ID == get_field('active_doc') ? 'show active' : '';
                } else {
                    $active = ($i == 0) ? 'show active' : '';
                }
                $doc_id = $main_doc['doc']->post_name;
                ?>
                <div class="tab-pane doc_tab_pane fade <?php echo $active; ?>" id="doc-<?php echo $doc_id ?>" role="tabpanel" aria-labelledby="<?php echo $doc_id ?>-tab">
                    <div class="row">
                        <?php
                        if ( !empty($main_doc['sections']) ) :
                        foreach ( $main_doc['sections'] as $section ) :
                            ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="topic_list_item">
                                    <?php if ( !empty($section->post_title) ) : ?>
                                        <h4> <?php echo wp_kses_post($section->post_title); ?> </h4>
                                    <?php endif; ?>
                                    <ul class="navbar-nav">
                                        <?php
                                        $doc_items = get_children( array(
                                            'post_parent'    => $section->ID,
                                            'post_type'      => 'docs',
                                            'post_status'    => 'publish',
                                            'orderby'        => 'menu_order',
                                            'order'          => 'ASC',
                                            'posts_per_page' => !empty(get_field('doc_item_count')) ? get_field('doc_item_count') : -1,
                                        ));
                                        foreach ( $doc_items as $doc_item ) :
                                            ?>
                                            <li>
                                                <a href="<?php echo get_permalink($doc_item->ID) ?>">
                                                    <?php echo wp_kses_post($doc_item->post_title) ?>
                                                </a>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                    <?php
                                    if ( !empty(get_field('read_more_text')) ) : ?>
                                        <a class="text_btn dark_btn" href="#">
                                            <?php echo esc_html(get_field('read_more_text')) ?> <i class="<?php docycore_arrow_left_right() ?>"></i>
                                        </a>
                                        <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        endif;
                        ?>
                    </div>
                </div>
                <?php
            endforeach;
            endif;
            ?>
        </div>
    </div>
</div>