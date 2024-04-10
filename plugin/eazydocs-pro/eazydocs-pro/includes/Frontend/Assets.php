<?php
namespace eazyDocsPro\Frontend;
/**
 * Class Assets
 * @package EazyDocs\Admin
 */
class Assets {
	
	/**
	 * Assets constructor.
	 */
	public function __construct() {
		add_action('wp_enqueue_scripts', [$this, 'eazydocs_pro_wp_scripts'], 99 );
	}

	/**
	 * Register scripts and styles
	 */
	public function eazydocs_pro_wp_scripts() {
		if ( eazydocspro_assistant_assets() == true ) {
			wp_enqueue_style('eazydocs-assistant', EAZYDOCSPRO_ASSETS . '/css/assistant.css');
			wp_enqueue_script('eazydocs-assistant', EAZYDOCSPRO_ASSETS . '/js/assistant.js');
		}

		wp_register_style( 'eazydocs-tooltip', EAZYDOCSPRO_ASSETS . '/vendors/tooltipster/tooltipster.bundle.css');
		wp_register_style( 'eazydocs-pro-frontend', EAZYDOCSPRO_CSS . '/ezd-pro.css' );
		wp_register_script( 'eazydocs-pro-frontend', EAZYDOCSPRO_ASSETS . '/js/frontend.js', array( 'jquery' ), true, true );
		wp_register_script( 'eazydocs-tooltip', EAZYDOCSPRO_ASSETS . '/vendors/tooltipster/tooltipster.bundle.min.js', array( 'jquery' ), true, true );
		
		if ( ezydocspro_frontend_assets() == true ) {
			wp_enqueue_style( 'eazydocs-pro-frontend' );

			// Mark JS for left sidebar search field
			if ( function_exists( 'ezd_get_opt' ) ){
				$word_mark = ezd_get_opt( 'search_mark_word', 'eazydocs_settings' );
				if ( $word_mark == 1 ) {
					wp_enqueue_script( 'ezd-mark', EAZYDOCSPRO_ASSETS . '/js/mark.js' );
					wp_enqueue_script( 'jquery-mark', EAZYDOCSPRO_ASSETS . '/js/jquery.mark.min.js' );
				}
			}

			wp_enqueue_script( 'eazydocs-local-ajax', EAZYDOCSPRO_ASSETS . '/js/ajax.js' );
			$localized_settings = [
				'ajax_url'              => admin_url( 'admin-ajax.php' ),
				'eazydocs_local_nonce'  => wp_create_nonce( 'eazydocs_local_nonce' ),
				'current_page' 			=> get_query_var( 'paged' ) ? get_query_var('paged') : 1,
			];

			wp_localize_script( 'eazydocs-local-ajax', 'eazydocs_ajax_search', $localized_settings );
			wp_enqueue_script( 'eazydocs-pro-frontend' );
		}
	}
}