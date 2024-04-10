<section class="doc_banner_area banner_creative1 docy_search_hero">
    <ul class="list-unstyled banner_shap_img">
        <li> <?php docy_el_image($settings['shape1'], 'Banner shape', ''); ?> </li>
        <li> <?php docy_el_image($settings['shape2'], 'Banner shape', ''); ?> </li>
        <li> <?php docy_el_image($settings['shape3'], 'Banner shape', ''); ?> </li>
        <li> <?php docy_el_image($settings['shape4'], 'Banner shape', ''); ?> </li>
        <?php
        if ( $settings['is_bg_objects'] == 'yes' ) :
            echo '<li>'; docy_el_image($settings['plus_1'], 'Plus icon', '', array('data-parallax' => '{"x": -180, "y": 80, "rotateY":2000}') ); echo '</li>';
            echo '<li>'; docy_el_image($settings['plus_2'], 'Plus icon', '', array('data-parallax' => '{"x": -50, "y": -160, "rotateZ":200}') ); echo '</li>';
            ?>
            <li></li>
            <li></li>
            <li></li>
            <?php
        endif;
        ?>
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
            <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="docy_search_hero header_search_form focused-form">
                <div class="header_search_form_info <?php echo ( $settings['is_dropdown'] == 'yes' ) ? 'has_drop' : ''; ?>">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <label for="searchInput">
                                <i class="icon_search"></i>
                            </label>
                            <input type='search' id="searchInput" autocomplete="off" name="s"  placeholder="<?php echo esc_attr($settings['placeholder']) ?>">

                            <!-- Ajax Search Loading Spinner -->
                            <?php include('search-spinner.php'); ?>

                            <!-- WPML Language Code -->
                            <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                                <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                            <?php endif; ?>

                            <input type="hidden" id="hidden_post_type" name="post_type" value="docs" />
                            <?php if ( $settings['is_dropdown'] == 'yes' ) : ?>
                                <select class="search-expand-types custom-select" id="search_post_type">
                                    <option value="all"> <?php esc_html_e( 'All', 'docy-core' ); ?> </option>
                                    <?php if ( class_exists('EazyDocs') ) : ?>
                                        <option value="docs"> <?php esc_html_e( 'Docs', 'docy-core' ) ?> </option>
                                    <?php endif; ?>
                                    <?php if ( class_exists('bbPress') ) : ?>
                                        <option value="bbp_search"> <?php esc_html_e( 'Forum', 'docy-core' ); ?> </option>
                                    <?php endif; ?>
                                    <option value="post"> <?php esc_html_e('Blog', 'docy-core'); ?> </option>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
        </div>
    </div>
</section>
