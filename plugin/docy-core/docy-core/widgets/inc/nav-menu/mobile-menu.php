<?php
$opt = get_option( 'docy_opt' );
$white_logo = $opt['sticky_logo']['url'] ?? '';
$retina_white_logo = !empty($opt['retina_sticky_logo']['url']) ? "srcset='{$opt['retina_sticky_logo']['url']} 2x'" : '';
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
           <?php include( "dark-action.php" ); ?>
        </div>
    </div>
</div>

<div class="side_menu">
    <div class="mobile_menu_header">
        <?php if ( !empty($opt['main_logo']['url']) ) : ?>
            <div class="mobile_logo">
                <a href="<?php echo esc_url(home_url('/')) ?>">
                    <img src="<?php echo esc_url($opt['main_logo']['url']) ?>" alt="<?php bloginfo('name'); ?>">
                    <?php if ( !empty($white_logo) ) : ?>
                        <img class="logo-light" src="<?php echo esc_url($white_logo) ?>" alt="<?php bloginfo('name'); ?>" <?php echo $retina_white_logo ?>>
                    <?php endif; ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="close_nav">
            <i class="icon_close"></i>
        </div>
    </div>

    <?php include('dark-switcher.php'); ?>

    <div class="mobile_nav_wrapper">
        <nav class="mobile_nav_bottom">
            <?php
            if ( has_nav_menu('main_menu') ) {
                wp_nav_menu( array (
                    'menu' => $settings['menu'],
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