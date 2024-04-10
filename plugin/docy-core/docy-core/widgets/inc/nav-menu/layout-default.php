<?php
$s_value = get_search_query() ? get_search_query() : '';
$opt = get_option('docy_opt');

$menu_align = $opt['menu_align'] ?? '';
$is_menu_center = '';
switch ( $menu_align ) {
    case 'left':
        $menu_class = 'justify-content-lg-between ms-5';
        break;
    case 'center':
        $menu_class = '';
        $is_menu_center = 'm-auto';
        break;
    default:
        $menu_class = '';
}
?>
<div class="collapse navbar-collapse <?php echo esc_attr($menu_class) ?>" id="navbarSupportedContent">
    <form action="<?php echo esc_url(home_url("/")) ?>" class="search-input toggle" method="get">
        <input type="search" placeholder="<?php esc_attr_e('Search...', 'docy'); ?>" name="s" value="<?php echo esc_attr($s_value) ?>">
        <button type="submit" class="search-icon"> <ion-icon name="search-outline"></ion-icon> </button>
    </form>
    <?php
    if ( has_nav_menu('main_menu') ) {
        wp_nav_menu( array (
            'menu' => $settings['menu'],
            'container' => null,
            'menu_class' => "navbar-nav menu ml-auto $is_menu_center",
            'menu_id' => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'walker' => new Docy_Nav_Walker(),
            'depth' => 4
        ));
    }

    include( "dark-action.php" );
    ?>
</div>