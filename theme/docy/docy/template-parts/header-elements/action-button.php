<?php

$action_btn_link 	= function_exists( 'get_field' ) ? get_field( 'action_btn_link' ) : '';
$is_menu_btn_page 	= function_exists( 'get_field' ) ? get_field( 'is_menu_btn' ) : '';
$is_menu_btn      	= $is_menu_btn_page ?? docy_opt('is_menu_btn');

// Button Title
$btn_title 			= '';
if ( ! empty( $action_btn_link['title'] ) ) {
	$btn_title 		= $action_btn_link['title'];
} else {
	$btn_title 		= docy_opt('menu_btn_label');
}

// Button URL
$btn_url 			= '#';
if ( ! empty( $action_btn_link['url'] ) ) {
	$btn_url 		= $action_btn_link['url'];
} else {
	$btn_url 		= docy_opt('menu_btn_url');
}

// Button Target
$btn_target 		= '';
if ( ! empty( $action_btn_link['target'] ) ) {
	$btn_target 	= "target='{$action_btn_link['target']}'";
} else {
	$btn_target 	= docy_opt('menu_btn_target', '_self');
}

$button_style 		= function_exists( 'get_field' ) ? get_field( 'button_style' ) : '';
$btn_type     		= '';
if ( ! empty( $button_style ) ) {
	$btn_type 		= ( $button_style == 'outline' ) ? 'tp_btn' : '';
} elseif ( $button_style == '' ) {
	$btn_type 		= 'tp_btn';
}

$two_button 		= $is_menu_btn == 'yes' && docy_opt('is_dark_switcher') == '1' ? 'two-button' : '';

if ( ( $is_menu_btn == '1' && ! empty( $btn_title ) ) || docy_opt('is_dark_switcher') == '1' ) :
	?>
    <div class="right-nav <?php echo $two_button; ?>">
		<?php 
		if ( $is_menu_btn == '1' && ! empty( $btn_title ) ):
			?>
            <a class="nav_btn tp_btn" href="<?php echo esc_url( $btn_url ) ?>" target="<?php echo esc_attr( $btn_target ) ?>">
				<?php echo esc_html( $btn_title ) ?>
            </a>
		    <?php
		endif;

		if ( docy_opt('is_dark_switcher') == '1' ) :
			wp_enqueue_style( 'docy-dark-mode' );
			wp_enqueue_script( 'docy-dark-mode' );
			?>
            <div class="px-2 darkmode-btn" title="<?php esc_attr_e( 'Toggle dark mode', 'docy' ); ?>">
                <label for="something" class="tab-btn tab-btns">
                    <ion-icon name="moon"></ion-icon>
                </label>
                <label for="something" class="tab-btn">
                    <ion-icon name="sunny"></ion-icon>
                </label>
                <label id="ball" class=" ball" for="something"></label>
                <input type="checkbox" name="something" id="something" class="dark_mode_switcher something">
            </div>
			<?php 
		endif;
	
		
		if ( docy_opt('is_search_form', '1') == '1' && docy_opt('header_layout', 'default') == 'default' ) :
			?>
            <div class="search-icon">
                <ion-icon class="close-outline" name="close-outline"></ion-icon>
                <ion-icon class="search-outline" name="search-outline"></ion-icon>
            </div>
		    <?php
		endif;
		?>
    </div>
	<?php
endif;