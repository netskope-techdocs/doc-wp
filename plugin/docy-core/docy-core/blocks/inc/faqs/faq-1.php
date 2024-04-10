<div class="doc_faq_area">
    <ul class="nav nav-tabs doc_tag" id="myTab-<?php echo $this->get_id() ?>" role="tablist">
        <?php
        foreach ( $cats as $index => $cat ) :
            $tab_count = $index + 1;
            $tab_title_faq_setting_key = $this->get_repeater_setting_key( 'tab_li', '', $index );
            $active = $tab_count == 1 ? ' active' : '';
            $this->add_render_attribute( $tab_title_faq_setting_key, [
                'href' => '#'.$cat->slug,
                'class' => [ 'nav-link', $active ],
                'id' => $cat->slug.'-tab',
                'data-toggle' => 'tab',
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
    <div class="tab-content" id="myTabContent-<?php echo $this->get_id() ?>">
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
                <div class="row">
                    <div class="col-lg-12">
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
                                $active = $faq_i == 0 ? ' active' : '';
                                $is_show = $faq_i == 0 ? ' show' : '';
                                $is_collapsed = $faq_i == 0 ? '' : ' collapsed';
                                ?>
                                <div class="card<?php echo esc_attr($active) ?>">
                                    <div class="card-header" id="heading-<?php echo $faq_i.$cat->slug.'-'; the_ID(); ?>">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link<?php echo esc_attr($is_collapsed) ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $faq_i.$cat->slug.'-';the_ID(); ?>" aria-expanded="true" aria-controls="collapse-<?php echo $faq_i.$cat->slug.'-';the_ID(); ?>">
                                                <?php the_title() ?><i class="icon_plus"></i><i class="icon_minus-06"></i>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse-<?php echo $faq_i.$cat->slug.'-';the_ID(); ?>" class="collapse <?php echo esc_attr($is_show) ?>" aria-labelledby="heading-<?php echo $faq_i.$cat->slug.'-';the_ID(); ?>" data-parent="#accordion-<?php echo $cat->slug; ?>">
                                        <div class="card-body">
                                            <?php the_content(); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                ++$faq_i;
                            endwhile;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
        ?>
    </div>
</div>