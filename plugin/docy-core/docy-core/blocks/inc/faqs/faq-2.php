<div class="doc_faq_area_two">
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="fact_navigation_info">
                <?php if ( !empty($settings['nav_title']) ) : ?>
                    <h4 class="c_head"> <?php echo wp_kses_post($settings['nav_title']) ?> </h4>
                <?php endif; ?>
                <ul class="nav nav-tabs fact_navigation" id="myTab" role="tablist">
                    <?php
                    foreach ( $cats as $index => $cat ) :
                        $tab_count = $index + 1;
                        $tab_title_faq_setting_key = $this->get_repeater_setting_key( 'tab_li', '', $index );
                        $active = $tab_count == 1 ? 'active' : '';
                        $this->add_render_attribute( $tab_title_faq_setting_key, [
                            'class' => [ 'nav-link', $active ],
                            'id' => $cat->slug.'-tab',
                            'data-toggle' => 'tab',
                            'href' => '#'.$cat->slug,
                            'role' => 'tab',
                            'aria-controls' => $cat->slug,
                            'aria-selected' => $tab_count == 1 ? 'true' : 'false'
                        ]);
                        ?>
                        <li class="nav-item">
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
        <div class="col-lg-8 col-md-7">
            <div class="tab-content ps-5" id="myTabContent-<?php echo $this->get_id() ?>">
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
                    <div class="accordion doc_faq_info" id="accordion-<?php echo $cat->slug; ?>">
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
                            <div class="card">
                                <div class="card-header" id="heading-<?php echo $cat->slug.$faq_i.'-'; the_ID(); ?>">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link<?php echo esc_attr($is_collapsed) ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $cat->slug.$faq_i.'-';the_ID(); ?>" aria-expanded="<?php echo esc_attr($is_expanded) ?>" aria-controls="collapse-<?php echo $cat->slug.$faq_i.'-';the_ID(); ?>">
                                            <?php the_title() ?><i class="icon_plus"></i><i class="icon_minus-06"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse-<?php echo $cat->slug.$faq_i.'-';the_ID(); ?>" class="collapse<?php echo esc_attr($is_show) ?>" aria-labelledby="heading-<?php echo $cat->slug.$faq_i.'-';the_ID(); ?>" data-parent="#accordion-<?php echo $cat->slug; ?>">
                                    <div class="card-body">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            ++$faq_i;
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
            </div>
        </div>
    </div>
</div>
