<div class="question_inner row">
    <div class="col-lg-3">
        <div class="question_menu">
            <?php if ( !empty($settings['nav_title']) ) : ?>
                <h3><?php echo wp_kses_post($settings['nav_title']) ?></h3>
            <?php endif; ?>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php
                foreach ( $cats as $index => $cat ) :
                    $tab_count = $index + 1;
                    $tab_title_faq_setting_key = $this->get_repeater_setting_key( 'tab_li', '', $index );
                    $active = $tab_count == 1 ? 'active' : '';
                    $this->add_render_attribute( $tab_title_faq_setting_key, [
                        'class' => [ 'nav-link', $active ],
                        'id' => $cat->slug.'-tab',
                        'data-bs-toggle' => 'tab',
                        'href' => '#'.$cat->slug,
                        'role' => 'tab',
                        'aria-controls' => $cat->slug,
                        'aria-selected' => $tab_count == 1 ? 'true' : 'false'
                    ]);
                    ?>
                    <li class="nav-item" role="presentation">
                        <a <?php echo $this->get_render_attribute_string( $tab_title_faq_setting_key ); ?>>
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
                $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', '', $index );
                $cat_active = $tab_count == 1 ? ' show active' : '';
                $this->add_render_attribute( $tab_content_setting_key, [
                    'class' => [ 'tab-pane fade', $cat_active ],
                    'id' => $cat->slug,
                    'role' => 'tabpanel',
                    'aria-labelledby' => $cat->slug.'-tab'
                ]);
                ?>
                <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
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