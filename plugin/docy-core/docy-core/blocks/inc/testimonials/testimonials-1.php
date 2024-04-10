<section class="doc_testimonial_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="doc_testimonial_slider">
                    <?php
                    if ( have_rows('docy_testi_list') ) {
                        $i = 0;
                        while ( have_rows('docy_testi_list') ) : the_row() ;
                        $i++;
                        $name = strtolower(get_sub_field('name'));
                        $name = explode(' ', $name);
                        $id = $name[0]."-".$i;
                            ?>
                            <div class="item testimonial-item-<?php echo $id; ?>">
                                <?php echo !empty(get_sub_field('content')) ? '<h3>'.wp_kses_post(get_sub_field('content')).'</h3>' : ''; ?>
                                <div class="name">
                                    <?php
                                    echo !empty(get_sub_field('name')) ? '<h5>'.wp_kses_post(get_sub_field('name')).'</h5>' : '';
                                    echo !empty(get_sub_field('designation')) ? '<span>'.wp_kses_post(get_sub_field('designation')).'</span>' : '';
                                    ?>
                                </div>
                                <?php if ( !empty(get_sub_field('signature')) ) : ?>
                                    <a href="#" class="sign">
                                        <?php echo wp_get_attachment_image( get_sub_field('signature')['ID'], 'full' ) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php
                        endwhile;
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="doc_img_slider">
                    <?php
                    if ( have_rows('docy_testi_list') ) {
                        $i = 0;
                        while ( have_rows('docy_testi_list') ) : the_row() ;
                        $i++;
                        $name = strtolower(get_sub_field('name'));
                        $name = explode(' ', $name);
                        $id = $name[0]."-".$i;
                            ?>
                            <div class="item testimonial-item-<?php echo $id; ?>">
                                <?php
                                if ( !empty(get_sub_field('shape')) ) :
                                    echo wp_get_attachment_image( get_sub_field('shape')['ID'], 'full', '', array( 'class' => 'dot' ) );
                                endif;

                                echo '<div class="round one"></div>';
                                echo '<div class="round two"></div>';

                                if ( !empty(get_sub_field('author_image')) ) :
                                    echo wp_get_attachment_image( get_sub_field('author_image')['ID'], 'full' );
                                endif;
                                ?>
                            </div>
                            <?php
                        endwhile;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    ;(function($){
        "use strict";
        $(document).ready(function () {
            $(".doc_testimonial_slider").slick({
                autoplay: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                <?php if ( is_rtl() ) : ?>
                rtl:true,
	            <?php endif; ?>
                autoplaySpeed: 2000,
                speed: 2000,
                dots: true,
                arrows: false,
                asNavFor: ".doc_img_slider",
            });
            $(".doc_img_slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
	            <?php if ( is_rtl() ) : ?>
                rtl:true,
	            <?php endif; ?>
                asNavFor: ".doc_testimonial_slider",
                arrows: false,
                fade: true,
                focusOnSelect: true,
            });
        });
    })(jQuery)
</script>