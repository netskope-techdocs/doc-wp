<?php
function docy_acf_block_feature(){
    $top_gap = get_field('fbox_margin_top');
    ?>
        <section class="h_feature_area">
            <div class="container">
                <div class="h_feature_box" style="margin-top: <?php echo esc_attr($top_gap); ?>px;">
                    <div class="row m-0">
                        <?php if ( have_rows('featured_boxes') ) : ?>
                        <?php while (have_rows('featured_boxes')) : the_row() ; ?>
                        <div class="col-md-4 col-sm-6 p-0">
                            <div class="h_feature_item">
                                <img class="wow fadeInUp" data-wow-delay="0.2s" src="<?php echo get_sub_field('featured_image')['url']; ?>" alt="" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                <a href="#">
                                    <h4 class="wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"><?php echo get_sub_field('title'); ?></h4>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php
}