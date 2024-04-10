<form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" >
    <div class="header_search_form_info search_form_wrap">
        <div class="form-group">
            <div class="input-wrapper">
                <input type='search' class="search_field_wrap" id="searchInput" autocomplete="off" name="s"  placeholder="<?php echo esc_attr($settings['placeholder']) ?>">

                <!-- Ajax Search Loading Spinner -->
                <span class="spinner search_form_spinner">
                    <img src="<?php echo DOCY_DIR_IMG ?>/icons/loading.svg" alt="<?php esc_attr_e('loading', 'docy') ?>">
                </span>
                <button type="submit" class="search_submit_btn <?php echo $settings['submit_btn_align'] ?? ''; ?>">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['submit_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </button>
                <!-- WPML Language Code -->
                <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                    <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include('ajax-sarch-results.php'); ?>
    <?php include('keywords.php'); ?>
</form>
