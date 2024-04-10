<?php
$opt = get_option('docy_opt');
$is_dark_switcher = $opt['is_dark_switcher'] ?? '';

if ( $is_dark_switcher == '1' ) :
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
<?php endif; ?>