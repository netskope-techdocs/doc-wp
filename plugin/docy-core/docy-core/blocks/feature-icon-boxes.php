<?php
function docy_acf_block_feature_icon(){
    ?>
        <section class="solution_area">
            <div class="container">
                <div class="row solution_inner">
                    <?php if ( have_rows('feature_icon_boxes') ) : ?>
                    <?php while ( have_rows('feature_icon_boxes') ) : the_row('feature_icon_boxes'); ?>
                    <div class="col-lg-6 mb-3">
                        <div class="solution_item wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp; background-color: <?php echo get_sub_field('box_bg_color'); ?>;">
                            <div class="media d-flex align-items-start">
                                <div class="d-flex">
                                    <img src="<?php echo get_sub_field('f_icon')['url']; ?>" alt="" class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <a href="#">
                                        <h4><?php echo get_sub_field('title'); ?></h4>
                                    </a>
                                    <p><?php echo get_sub_field('content'); ?></p>
                                    <a class="text_btn" href="<?php echo get_sub_field('button_url'); ?>"><?php echo get_sub_field('button_text'); ?> <i class="arrow_right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php
}