<?php
namespace eazyDocsPro\Admin;

/**
 * Class Assets
 * @package EazyDocs\Admin
 */
class Assets {
	/**
	 * Assets constructor.
	 */
	public function __construct() {
		// add script to admin head
		add_action( 'admin_head', [$this, 'admin_analytics_scripts'], 999 );
        add_action( 'admin_enqueue_scripts', [$this, 'admin_scripts'], 999 );
	}

	/**
	 * Register scripts and styles [ ADMIN ]
	 */
	public function admin_scripts() {
		if ( ezydocspro_admin_assets() == true ) {
			wp_enqueue_style( 'ezd-pro-admin', EAZYDOCSPRO_CSS . '/ezd-pro-admin.css' );
			wp_enqueue_style( 'eazydocs-datepricker-css', '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css' );

			wp_enqueue_script( 'Sortable', EAZYDOCSPRO_ASSETS . '/js/admin.js', array( 'jquery' ), true, true );
			wp_enqueue_script( 'ezydocs-feedback', EAZYDOCSPRO_ASSETS . '/js/feedback.js', array( 'jquery' ), true, true );
			wp_enqueue_script( 'eazydocs-duplicate', EAZYDOCSPRO_ASSETS . '/js/duplicate.js', array( 'jquery' ), true, true );
			wp_localize_script( 'jquery', 'eazydocspro_local_object',
				array(
					'feedback_prompt_archive_title'   => esc_html__( 'Archive This Message', 'eazydocs-pro' ),
					'feedback_prompt_archive_desc'    => esc_html__( 'Click on the Mark as Archive button to archive this message.', 'eazydocs-pro' ),
					'feedback_prompt_open_title'      => esc_html__( 'Open This Message', 'eazydocs-pro' ),
					'feedback_prompt_open_desc'       => esc_html__( 'Click on the Mark as Open button to Open this message.', 'eazydocs-pro' ),
					'feedback_prompt_delete_title'    => esc_html__( 'Delete This Message', 'eazydocs-pro' ),
					'feedback_prompt_delete_desc'     => esc_html__( 'Click on the Delete button to delete this message.', 'eazydocs-pro' )
				)
			);
		}
	}

	/**
	 * Add script to admin head
	 */
	public function admin_analytics_scripts() {
		if ( ezydocspro_admin_assets() == true ){
			echo '<script type="text/javascript" src="'.EAZYDOCSPRO_ASSETS.'/js/apexchart.js"></script>';
			echo '<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>';
			echo '<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>';
		}
	}
	
}