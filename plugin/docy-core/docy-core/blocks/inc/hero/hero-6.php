<?php
wp_enqueue_script('parallax-scroll');
?>
<section class="docy-banner-support hero_community docy_search_hero">
    <div class="banner-content text-center">
        <div class="banner-content-wrapper">
            <?php if (!empty(get_field('docy_hero_title'))) :?>
                <h1 class="banner-title wow fadeInUp"><?php echo wp_kses_post(get_field('docy_hero_title'))?></h1>
            <?php endif; ?>
            <?php if (!empty(get_field('docy_hero_subtitle'))) : ?>
                <p class="banner-description wow fadeInUp"><?php echo wp_kses_post(get_field('docy_hero_subtitle'))?></p>
            <?php endif; ?>
            <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="focused-form banner_search_form">
                <div class="input-group">
                    <input type="search" class="form-control" name="s" id="searchInput"  placeholder="<?php echo esc_attr(get_field('docy_hero_search_form_plc')) ?>">
                    <!-- WPML Language Code -->
                    <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                        <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                    <?php endif; ?>
                    <div class="input-group-append">
                        <button type="submit"><i class="icon_search"></i></button>
                    </div>
                </div>
                <?php include('ajax-sarch-results.php'); ?>
                <?php include('keywords.php'); ?>
            </form>
            <!-- /.banner-search-form-wrapper -->
        </div>
        <!-- /.banner-content-wrapper -->
    </div>
    <!-- /.banner-content -->
    <?php if ( have_rows('docy_people_imgs') ) : ?>
        <ul class="people-image wow fadeIn" data-wow-delay="0.7s">
            <?php
            while(have_rows('docy_people_imgs')) : the_row();
            $people = get_sub_field('docy_people_img');
                ?>
                <li>
                    <?php echo wp_get_attachment_image($people['id'], 'full', array('class' => 'wow zoomIn', 'data-wow-delay' => '0.4s')) ?>
                </li>
            <?php
            endwhile;
            ?>
        </ul>
    <?php endif; ?>
    <?php if ( get_field('docy_hero_bg_obj') == '1' ) : ?>
        <ul class="partical-animation wow fadeIn" data-wow-delay="0.9s">
            <?php
            $plus_1 = get_field('docy_bg_obj_plus_1');
            if ( !empty($plus_1) ) : ?>
                <li class="partical">
                    <img data-parallax='{"x": -180, "y": 80, "rotateY":2000}' src="<?php echo esc_url($plus_1['url']) ?>" alt="partical">
                </li>
            <?php endif; ?>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <li class="partical"></li>
            <?php
            $plus_2 = get_field('docy_bg_obj_plus_2');
            if ( !empty($plus_2) ) : ?>
                <li class="partical">
                    <img src="<?php echo esc_url($plus_2['url']) ?>" data-parallax='{"x": -250, "y": -160, "rotateZ":200}' alt="partical">
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</section>