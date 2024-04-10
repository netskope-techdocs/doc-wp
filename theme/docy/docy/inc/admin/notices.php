<?php
/**
 * Deactivate Other plugins
 */
if ( isset( $_GET['deactivate'] ) && ! empty( $_GET['deactivate'] ) ) {
	$plugin = sanitize_text_field( $_GET['deactivate'] );
	add_action( 'admin_init', "docy_deactivate_other_plugin" );
	function docy_deactivate_other_plugin() {
		$plugin = ! empty ( $_GET['deactivate'] ) ? sanitize_text_field( $_GET['deactivate'] ) : '';
		deactivate_plugins( "$plugin/$plugin.php" );
		$url    = admin_url( 'plugins.php' );
		wp_safe_redirect( $url );
	}
}

/**
 * Notice
 * Deactivate the Redux Framework
 *
 * @return void
 */

add_action( 'admin_notices', function () {
	if ( is_plugin_active( 'redux-framework/redux-framework.php' ) ) :
		?>
        <div class="notice notice-warning docy-notice">
            <p>
				<?php esc_html_e( 'We have detected another Options Framework Plugin installed in this site.', 'docy' ); ?> <br>
				<?php esc_html_e( "We've removed dependency from Redux framework. If you don't use Redux framework's other features, you can deactivate it.", 'docy' ); ?>
            </p>
            <p>
                <a href="?deactivate=redux-framework" class="button-primary button-large">
					<?php esc_html_e( 'Deactivate Redux Framework', 'docy' ); ?>
                </a>
            </p>
            <button type="button" class="notice-dismiss"></button>            
        </div>
	    <?php
	endif;
} );