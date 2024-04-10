<section class="doc_banner_area_dip docy_search_hero">
    <ul class="list-unstyled banner_shap_img_dip">
        <li> <?php docy_el_image($settings['classic_obj1'], 'Banner shape', '', array('data-parallax' => '{"x": 180, "y": 80, "rotateY":2000}')); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj1'], 'Banner shape', '', array('data-parallax' => '{"x": 180, "y": 80, "rotateY":2000}')); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj1'], 'Banner shape', '', array('data-parallax' => '{"x": 180, "y": 80, "rotateY":2000}')); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj2'], 'Banner object'); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj3'], 'Banner object'); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj4'], 'Banner object'); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj5'], 'Banner object'); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj6'], 'Banner object'); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj7'], 'Banner object'); ?> </li>
        <li> <?php docy_el_image($settings['classic_obj8'], 'Banner object'); ?> </li>
    </ul>
    <div class="container">
        <div class="doc_banner_content">
            <?php
            echo !empty($settings['title']) ? sprintf( '<%1$s class="title wow fadeInUp" data-wow-delay="0.2s"> %2$s </%1$s>', $title_tag, nl2br($settings['title']) ) : '';
            if ( !empty($settings['subtitle']) ) : ?>
                <p class="subtitle wow fadeInUp" data-wow-delay="0.2s">
                    <?php echo wp_kses_post($settings['subtitle'])?>
                </p>
            <?php
            endif;
            ?>
            <form action="<?php echo esc_url(home_url('/')) ?>" class="header_search_form" role="search" method="get">
                <div class="header_search_form_info">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type='search' id="searchInput" autocomplete="off" name="s"  placeholder="<?php echo esc_attr($settings['placeholder']) ?>" />
                            <!-- Ajax Search Loading Spinner -->
                            <?php include('search-spinner.php'); ?>
                            <!-- WPML Language Code -->
                            <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                                <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                            <?php endif; ?>
                        </div>
                        <?php
                        if ( !empty( $settings['submit_btn_label'] ) ) : ?>
                            <button type="submit" class="submit_btn">
                                <?php echo esc_html($settings['submit_btn_label']) ?>
                            </button>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
        </div>
    </div>
</section>