<?php
namespace eazyDocsPro\Admin;

/**
 * Class Delete_Post
 * @package eazyDocs\Admin
 */
class Feedback_Delete {

	/**
	 * Create_Post constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'feedback_delete' ] );
	}

	/**
	 * Delete Parent Doc
	 */
	public function feedback_delete() {
		if ( isset ( $_GET['archived_feedback_delete'] ) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['archived_feedback_delete'])) {

			$feedback_id                  = $_GET['archived_feedback_delete'] ?? '';
			wp_delete_post( $feedback_id, true );
			wp_safe_redirect( admin_url( 'admin.php?page=ezd-user-feedback' ) );

		} elseif ( isset ( $_GET['open_feedback_delete'] ) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['open_feedback_delete'])) {

			$feedback_id                  = $_GET['open_feedback_delete'] ?? '';
			wp_delete_post( $feedback_id, true );
			wp_safe_redirect( admin_url( 'admin.php?page=ezd-user-feedback-archived' ) );
			
		}
	}
}