<?php
function docy_acf_block_ask(){
    ?>
    <section class="asking_area">
        <div class="container p-0">
            <div class="row">
                <?php if(have_rows('ask_boxes')) : ?>
                <?php while(have_rows('ask_boxes')) : the_row('ask_boxes') ; ?>
                <div class="col-lg-6">
                    <div class="asking_item">
                        <h5><?php echo get_sub_field('content'); ?></h5>
                        <h4><?php echo get_sub_field('title'); ?></h4>
                        <img src="<?php echo get_sub_field('bg_img')['url']; ?>" alt="<?php echo get_sub_field('title'); ?>">
                        <a class="main_btn blue wow fadeInUp" data-wow-delay="0.3s" href="<?php echo get_sub_field('btn_url'); ?>" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"><?php echo get_sub_field('btn_label'); ?></a>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}