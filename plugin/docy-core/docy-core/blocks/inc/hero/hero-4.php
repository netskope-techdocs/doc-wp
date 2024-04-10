<section class="doc_banner_area_one docy_search_hero hero_cool box_input_hero">
    <?php
    docy_el_image(get_field('docy_star_1'), 'Star illustration', 'p_absolute star_one');
    docy_el_image(get_field('docy_star_2'), 'Star illustration', 'p_absolute star_two');
    docy_el_image(get_field('docy_star_3'), 'Star illustration', 'p_absolute star_three');
    docy_el_image(get_field('docy_left_image'), 'Leaf illustration', 'p_absolute bl_left');
    docy_el_image(get_field('docy_right_image'), 'Leaf illustration', 'p_absolute bl_right');
    ?>

    <div class="container">
        <div class="doc_banner_text">
            <?php if ( !empty(get_field('docy_hero_title')) ) : ?>
                <h2 class="wow fadeInUp" data-wow-delay="0.3s">
                    <?php echo wp_kses_post(get_field('docy_hero_title')); ?>
                </h2>
            <?php endif; ?>
            <?php if (!empty(get_field('docy_hero_subtitle'))) : ?>
                <p class="wow fadeInUp" data-wow-delay="0.5s"><?php echo wp_kses_post(get_field('docy_hero_subtitle'))?></p>
            <?php endif; ?>
            <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="banner_search_form focused-form">
                <div class="input-group">
                    <input type="search" name="s" id="searchInput"  class="form-control" placeholder="<?php echo esc_attr(get_field('docy_hero_search_form_plc')) ?>" autocomplete="off" />
                    <!-- WPML Language Code -->
                    <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                        <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                    <?php endif; ?>
                    <!-- Ajax Search Loading Spinner -->
                    <?php include('search-spinner.php'); ?>
                    <div class="input-group-append">
                        <button type="submit"><i class="icon_search"></i></button>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
        </div>
    </div>
</section>