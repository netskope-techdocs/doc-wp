<?php
namespace eazyDocsPro\Admin;

/**
 * Class Single_Duplicate
 * @package eazyDocsPro\Duplicator
 */
class Feedback_Update {
	public function __construct() {
		add_action( 'admin_init', [ $this, 'ezd_feedback_updated' ] );
	}

	function ezd_feedback_updated() {
		if ( isset ( $_GET['feedback_activity'] ) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['feedback_activity'])) {

			$page_id = sanitize_text_field( $_GET['feedback_activity'] ?? '' );
			update_post_meta( $page_id, 'ezd_feedback_status', 'false' );
			wp_safe_redirect( admin_url( 'admin.php?page=ezd-user-feedback' ) );

		} elseif ( isset ( $_GET['feedback_open'] ) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['feedback_open'])) {

			$page_id = sanitize_text_field( $_GET['feedback_open'] ?? '' );
			update_post_meta( $page_id, 'ezd_feedback_status', 'true' );
			wp_safe_redirect( admin_url( 'admin.php?page=ezd-user-feedback-archived' ) );
		}
	}
}