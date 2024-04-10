<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
$opt          = get_option( 'docy_opt' );
$bg_shape     = ! empty( $opt['error_bg_shape_image'] ) ? $opt['error_bg_shape_image']['url'] : DOCY_DIR_IMG . '/404_bg.png';
$error2_image = ! empty( $opt['error2_image']['url'] ) ? $opt['error2_image']['url'] : DOCY_DIR_IMG . '/new/error.png';
?>
<section class="error_area bg_color">
    <div class="error_dot one"></div>
    <div class="error_dot two"></div>
    <div class="error_dot three"></div>
    <div class="error_dot four"></div>
    <div class="container">
        <div class="error_content_two text-center">
            <div class="error_img">
                <img class="p_absolute error_shap" src="<?php echo esc_url( $bg_shape ) ?>" alt="<?php esc_attr_e( '404 page background shape.', 'docy' ); ?>">
                <div class="one wow clipInDown" data-wow-delay="1s">
                    <img class="img_one" src="<?php echo DOCY_DIR_IMG ?>/404_two.png" alt="<?php esc_attr_e( '4 illustration', 'docy' ); ?>">
                </div>
                <div class="two wow clipInDown" data-wow-delay="1.5s">
                    <img class="img_two" src="<?php echo DOCY_DIR_IMG ?>/404_three.png" alt="<?php esc_attr_e( '0 illustration', 'docy' ); ?>">
                </div>
                <div class="three wow clipInDown" data-wow-delay="1.8s">
                    <img class="img_three" src="<?php echo DOCY_DIR_IMG ?>/404_one.png" alt="<?php esc_attr_e( '4 illustration', 'docy' ); ?>">
                </div>
            </div>

            <?php            
            echo sprintf("<h1>%s</h1>", docy_opt('error_heading',  __( "Error! We can't find the page you're looking for.", 'docy' )  ));
            echo wp_kses_post( docy_opt( 'error_subtitle',  __( "We can't seem to find the page you're looking for", 'docy' ) ) );
            ?>

            <form action="<?php echo esc_url( home_url( '/' ) ) ?>" class="error_search">
                <input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Search', 'docy' ) ?>">
            </form>

            <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="action_btn box_shadow_none">
                <i class="arrow_left"></i> <?php echo esc_html( docy_opt( 'error_home_btn_label',  __( "Go Back to home Page", 'docy' ) ) ); ?>
            </a>
        </div>
    </div>
</section>

<?php
get_footer( 'empty' );