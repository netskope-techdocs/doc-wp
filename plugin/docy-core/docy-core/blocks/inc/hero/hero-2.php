<section class="doc_banner_area_dip docy_search_hero">
    <ul class="list-unstyled banner_shap_img_dip">
        <li> <?php docy_el_image(get_field('docy_classic_object_1'), 'Banner shape', '', array('data-parallax' => '{"x": 180, "y": 80, "rotateY":2000}')); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_1'), 'Banner shape', '', array('data-parallax' => '{"x": 180, "y": 80, "rotateY":2000}')); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_1'), 'Banner shape', '', array('data-parallax' => '{"x": 180, "y": 80, "rotateY":2000}')); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_2'), 'Banner object'); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_3'), 'Banner object'); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_4'), 'Banner object'); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_5'), 'Banner object'); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_6'), 'Banner object'); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_7'), 'Banner object'); ?> </li>
        <li> <?php docy_el_image(get_field('docy_classic_object_8'), 'Banner object'); ?> </li>
    </ul>
    <div class="container">
        <div class="doc_banner_content">
            <?php
            $title_tag = 'h2';
            echo !empty(get_field('docy_hero_title')) ? sprintf( '<%1$s class="title wow fadeInUp" data-wow-delay="0.2s"> %2$s </%1$s>', $title_tag, nl2br(get_field('docy_hero_title')) ) : '';
            if ( !empty(get_field('docy_hero_subtitle')) ) : ?>
                <p class="subtitle wow fadeInUp" data-wow-delay="0.2s">
                    <?php echo wp_kses_post(get_field('docy_hero_subtitle'))?>
                </p>
            <?php endif; ?>
            <form action="<?php echo esc_url(home_url('/')) ?>" class="header_search_form" role="search" method="get">
                <div class="header_search_form_info">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type='search' id="searchInput" autocomplete="off" name="s" placeholder="<?php echo esc_attr(get_field('docy_hero_search_form_plc')) ?>" />
                            <!-- Ajax Search Loading Spinner -->
                            <?php include('search-spinner.php'); ?>
                            <!-- WPML Language Code -->
                            <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                                <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                            <?php endif; ?>
                        </div>
                        <?php
                        if ( !empty( get_field('docy_classic_search_btn') ) ) : ?>
                            <button type="submit" class="submit_btn">
                                <?php echo esc_html(get_field('docy_classic_search_btn')) ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
        </div>
    </div>
</section>