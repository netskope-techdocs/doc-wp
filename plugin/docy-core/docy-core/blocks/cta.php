<?php
function docy_acf_block_cta(){
    $bg_img = !empty(get_field('cta_bg_img')) ? get_field('cta_bg_img') : '';
    $title_tag = 'h3';
    ?>
    <section class="support_area c2a_sec">
        <div class="container">
            <?php if ( $bg_img ) : ?>
                <img class="shap" data-parallax='{"x": 200}' src="<?php echo$bg_img['url'] ?>" alt="<?php echo esc_attr(get_field('cta_title')); ?>">
            <?php endif; ?>
            <div class="d-flex justify-content-between">
                <div class="left">
                    <?php echo !empty(get_field('cta_title')) ? sprintf( '<%1$s class="title" data-animation="wow fadeInUp" data-wow-delay="0.2s"> %2$s </%1$s>', $title_tag, nl2br(get_field('cta_title')) ) : ''; ?>
                    <?php echo wp_kses_post(wpautop(get_field('cta_content'))) ?>
                    <?php if ( !empty(get_field('cta_btn')) ) : ?>
                        <a class="icon_btn2 wow fadeInUp c2abtn" data-wow-delay="0.6s" href="<?php echo esc_url(get_field('cta_btn_url')); ?>">
                            <?php echo esc_html(get_field('cta_btn')) ?><i class="arrow_right"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="right">
                    <?php docy_el_image(get_field('cta_featured'), 'call to action background shape'); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}