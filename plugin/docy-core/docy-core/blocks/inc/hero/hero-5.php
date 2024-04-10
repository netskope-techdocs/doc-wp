<section class="doc_banner_area_two docy_search_hero box_input_hero">

    <?php
    if( get_field('docy_hero_bg_obj') == '1' ) :
    $plus_1 = get_field('docy_bg_obj_plus_1');
    if (!empty($plus_1) ) {
            ?>
            <img class="b_plus one" data-parallax='{"x": 250, "y": 160, "rotateZ":500}' src="<?php echo esc_url($plus_1['url']); ?>" alt="<?php esc_attr_e('file illustration', 'docy-core'); ?>">
            <?php
        }
    ?>

    <?php
    $plus_2 = get_field('docy_bg_obj_plus_2');
    if (!empty($plus_2) ) {
            ?>
            <img class="b_plus two" data-parallax='{"x": 250, "y": 160, "rotateZ":500}' src="<?php echo esc_url($plus_2['url']); ?>" alt="<?php esc_attr_e('file illustration', 'docy-core'); ?>">
            <?php
        }
    endif;
    ?>

    <div class="b_round r_one" data-parallax='{"x": 0, "y": 100, "rotateZ":0}'></div>
    <div class="b_round r_two" data-parallax='{"x": -10, "y": 80, "rotateY":0}'></div>
    <div class="b_round r_three"></div>
    <div class="b_round r_four"></div>

    <?php
    docy_el_image(get_field('docy_featured_image_1'), 'building illustration', 'p_absolute building_img');
    docy_el_image(get_field('docy_featured_image_2'), 'help illustration', 'p_absolute table_img wow fadeInLeft');
    docy_el_image(get_field('docy_featured_image_3'), 'help illustration', 'p_absolute bord wow fadeInRight');
    docy_el_image(get_field('docy_featured_image_4'), 'help illustration', 'p_absolute girl wow fadeInRight');
    ?>

    <div class="container">
        <div class="doc_banner_text_two text-center">
            <?php if (!empty(get_field('docy_hero_title'))) :?>
                <h2><?php echo wp_kses_post(get_field('docy_hero_title'))?></h2>
            <?php endif; ?>

            <?php if (!empty(get_field('docy_hero_subtitle'))) : ?>
                <p><?php echo wp_kses_post(get_field('docy_hero_subtitle'))?></p>
            <?php endif; ?>

            <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="banner_search_form focused-form">
                <div class="input-group">
                    <input type="search" class="form-control" name="s" id="searchInput"  placeholder="<?php echo esc_attr(get_field('docy_hero_search_form_plc')) ?>">

                    <!-- WPML Language Code -->
                    <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                        <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                    <?php endif; ?>

                    <!-- Ajax Search Loading Spinner -->
                    <?php include('search-spinner.php'); ?>

                    <div class="input-group-append">
                        <button type="submit" class="search_btn"> <?php echo esc_html(get_field('docy_classic_search_btn')) ?> </button>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
        </div>
    </div>
</section>