<?php
$opt = get_option( 'docy_opt' );
?>
<div class="mobile_main_menu <?php Docy_helper()->navbar_type(); ?>" id="<?php docy_sticky_navbar('id', 'mobile') ?>">
    <div class="container">
        <div class="mobile_menu_left">
            <button type="button" class="navbar-toggler mobile_menu_btn">
                <span class="menu_toggle ">
                    <span class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </span>
            </button>
            <?php Docy_helper()->logo(); ?>
        </div>
        <div class="mobile_menu_right">
           <?php get_template_part( 'template-parts/header-elements/action-button' ); ?>
        </div>
    </div>
</div>

<div class="side_menu <?php Docy_helper()->navbar_type(); ?>">
    <div class="mobile_menu_header">
        <div class="close_nav">
            <i class="icon_close"></i>
        </div>
        <?php 
        if ( !empty( $opt['main_logo']['url'] ) ) :
            ?>
            <div class="mobile_logo">
                <?php Docy_helper()->logo(); ?>
            </div>
            <?php 
        endif;
        ?>
    </div>

    <?php get_template_part( 'template-parts/header-elements/dark-switcher' ); ?>

    <div class="mobile_nav_wrapper">
        <nav class="mobile_nav_bottom">
            <?php
            if ( has_nav_menu('main_menu') ) {
                wp_nav_menu( array (
                    'menu' => 'main_menu',
                    'theme_location' => 'main_menu',
                    'container' => null,
                    'menu_class' => "navbar-nav menu ml-auto",
                    'walker' => new Docy_Mobile_Nav_Walker(),
                    'depth' => 4
                ));
            }
            ?>
        </nav>
    </div>
</div>