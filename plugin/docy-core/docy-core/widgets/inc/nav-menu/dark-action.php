<?php
$opt = get_option('docy_opt');
$is_dark_switcher = $opt['is_dark_switcher'] ?? '';
$is_button = $settings['is_button'] ?? '';
$two_button = $is_button == 'yes' && $is_dark_switcher == '1' ? 'two-button' : '';

if ( $is_button == 'yes' || $is_dark_switcher == '1' ) :
	?>
    <div class="right-nav <?php echo $two_button; ?>">
		<?php
        if ( $is_button == 'yes' && ! empty( $settings['btn_label'] ) ):
            ?>
            <a <?php echo $this->get_render_attribute_string('button') ?>>
                <?php echo $settings['btn_label']; ?>
            </a>
		    <?php
		endif;

		if ( $is_dark_switcher == '1' ) :
			wp_enqueue_style( 'docy-dark-mode' );
			wp_enqueue_script( 'docy-dark-mode' );
			?>
            <div class="px-2 darkmode-btn" title="<?php esc_attr_e( 'Toggle dark mode', 'docy' ); ?>">
                <label for="something" class="tab-btn tab-btns" id="dark-switch">
                    <ion-icon name="moon"></ion-icon>
                </label>
                <label for="something" class="tab-btn" id="day-switch">
                    <ion-icon name="sunny"></ion-icon>
                </label>
                <label id="ball" class=" ball" for="something"></label>
                <input type="checkbox" name="something" id="something" class="dark_mode_switcher something">
            </div>
		<?php endif; ?>

		<?php
		$is_search_form = $opt['is_search_form'] ?? '1';
        $header_layout = $settings['header_layout'] ?? 'default';
		if ( $is_search_form == '1' && $header_layout == 'default' ) :
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