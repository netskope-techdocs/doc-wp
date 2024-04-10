<?php
if ( get_field('faq_cat_order') == 'faq_asc' ) {
    $order = 'ASC';
} elseif ( get_field('faq_cat_order') == 'faq_desc' ) {
    $order = 'DESC';
}
$cats = get_terms( array (
    'taxonomy' => 'faq_cat',
    'hide_empty' => true,
    'orderby' => get_field('faq_cat_by'),
    'order' => $order,
));
?>
    <div class="question_inner row">
        <div class="col-lg-3">
            <div class="question_menu">
                <?php if ( !empty(get_field('faq_nav_title')) ) : ?>
                    <h3><?php echo wp_kses_post(get_field('faq_nav_title')) ?></h3>
                <?php endif; ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php
                    foreach ( $cats as $index => $cat ) :
                        $tab_count = $index + 1;
                        $active = $tab_count == 1 ? 'active' : '';
                        ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo $active; ?>" id="<?php echo $cat->slug.'-tab'; ?>" data-toggle="tab" href="#<?php echo $cat->slug; ?>" role="tab" aria-controls="<?php echo $cat->slug; ?>" aria-selected="<?php echo $tab_count == 1 ? 'true' : 'false' ?>">
                                <?php echo $cat->name; ?>
                            </a>
                        </li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content question_list" id="myTabContent">
                <?php
                foreach ( $cats as $index => $cat ) :
                    $tab_count = $index + 1;
                    $cat_active = $tab_count == 1 ? ' show active' : '';

                    ?>
                    <div class="tab-pane fade <?php echo $cat_active; ?>" id="<?php echo $cat->slug; ?>" role="tabpanel" aria-labelledby="<?php echo $cat->slug.'-tab'; ?>">
                        <?php
                        $faqs = new WP_Query( array (
                            'post_type' => 'faq',
                            'posts_per_page' => -1,
                            'tax_query' => array (
                                array(
                                    'taxonomy' => 'faq_cat',
                                    'field'    => 'slug',
                                    'terms'    => $cat->slug,
                                ),
                            ),
                        ));
                        $faq_i = 0;
                        while ( $faqs->have_posts() ) : $faqs->the_post();
                            $is_expanded = $faq_i == 0 ? 'true' : 'false';
                            $is_show = $faq_i == 0 ? ' show' : '';
                            $is_collapsed = $faq_i == 0 ? '' : ' collapsed';
                            ?>
                            <div class="ques_item fadeInUp" data-wow-delay="0.2s">
                                <a href="#faq-<?php the_ID(); ?>">
                                    <h4><?php the_title() ?></h4>
                                </a>
                                <?php the_content(); ?>
                            </div>
                            <?php
                            ++$faq_i;
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
