<section class="doc_banner_area banner_creative1 docy_search_hero">
    <ul class="list-unstyled banner_shap_img">
        <li> <?php docy_el_image(get_field('docy_hero_bg_shape_1'), 'Banner shape', ''); ?> </li>
        <li> <?php docy_el_image(get_field('docy_hero_bg_shape_2'), 'Banner shape', ''); ?> </li>
        <li> <?php docy_el_image(get_field('docy_hero_bg_shape_3'), 'Banner shape', ''); ?> </li>
        <li> <?php docy_el_image(get_field('docy_hero_bg_shape_4'), 'Banner shape', ''); ?> </li>
        <?php
        if ( get_field('docy_hero_bg_obj') == '1' ) :
            echo '<li>'; docy_el_image(get_field('docy_bg_obj_plus_1'), 'Plus icon', '', array('data-parallax' => '{"x": -180, "y": 80, "rotateY":2000}') ); echo '</li>';
            echo '<li>'; docy_el_image(get_field('docy_bg_obj_plus_2'), 'Plus icon', '', array('data-parallax' => '{"x": -50, "y": -160, "rotateZ":200}') ); echo '</li>';
            ?>
            <li></li>
            <li></li>
            <li></li>
        <?php endif; ?>
    </ul>
    <div class="container">
        <div class="doc_banner_content">
            <?php
            $title_tag = 'h2';
            $title_color = get_field('title_color');
            echo !empty(get_field('docy_hero_title')) ? sprintf( '<%1$s style="color: %2$s" class="title wow fadeInUp" data-wow-delay="0.2s"> %3$s </%1$s>', $title_tag, $title_color, nl2br(get_field('docy_hero_title')) ) : '';
            if ( !empty(get_field('docy_hero_subtitle')) ) : ?>
                <p style="<?php echo !empty(get_field('subtitle_color')) ? get_field('subtitle_color') : '#fff'; ?>" class="subtitle wow fadeInUp" data-wow-delay="0.2s">
                    <?php echo wp_kses_post(get_field('docy_hero_subtitle'))?>
                </p>
            <?php endif; ?>
            <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="docy_search_hero header_search_form focused-form">
                <div class="header_search_form_info <?php echo ( get_field('docy_hero_post_dd') == '1' ) ? 'has_drop' : ''; ?>">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <label for="searchInput">
                                <i class="icon_search"></i>
                            </label>
                            <input type='search' id="searchInput" autocomplete="off" name="s" placeholder="<?php echo esc_attr(get_field('docy_hero_search_form_plc')) ?>">

                            <!-- Ajax Search Loading Spinner -->
                            <?php include('search-spinner.php'); ?>

                            <!-- WPML Language Code -->
                            <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                                <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                            <?php endif; ?>

                            <input type="hidden" id="hidden_post_type" name="post_type" value="docs" />
                            <?php if ( get_field('docy_hero_post_dd') == '1' ) : ?>
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
