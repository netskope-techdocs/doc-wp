<section class="doc_banner_area search-banner-light docy_search_hero hero3">
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
                            <label for="searchInput">
                                <i class="icon_search"></i>
                            </label>
                            <input type='search' id="searchInput" autocomplete="off" name="s" placeholder="<?php echo esc_attr(get_field('docy_hero_search_form_plc')) ?>" />
                            <!-- WPML Language Code -->
                            <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                                <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                            <?php endif; ?>
                            <!-- Ajax Search Loading Spinner -->
                            <?php include('search-spinner.php'); ?>
                        </div>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
        </div>
    </div>
</section>

