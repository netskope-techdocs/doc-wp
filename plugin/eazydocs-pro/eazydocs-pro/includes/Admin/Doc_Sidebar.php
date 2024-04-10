<?php
namespace eazyDocsPro\Admin;

/**
 * Class Single_Duplicate
 * @package eazyDocsPro\Duplicator
 */
class Doc_Sidebar {
	public function __construct() {
		add_action( 'admin_init', [ $this, 'ezd_doc_sidebar' ] );
	}

	function ezd_doc_sidebar() {
 
		if (isset($_GET['doc_sidebar']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['doc_sidebar'])) {

			$current_post 			= sanitize_text_field( $_GET['doc_sidebar'] ?? '' );
			$ezd_doc_content_type 	= sanitize_text_field( $_GET['content_type'] ?? '' );
			$left_side_sidebar 		= sanitize_text_field( $_GET['left_side_sidebar'] ?? '' );
			$content_type 			= sanitize_text_field( $_GET['shortcode_right'] ?? '' );
			echo $page_contents_right 	= esc_textarea( $_GET['shortcode_content_right'] ?? '' );

			if( $content_type == 'widget_data_right'){
				$shortcode_content_right = sanitize_text_field( $_GET['right_side_sidebar'] ?? '' );
			}else{
				$page_content_right      = substr( ezd_chrEncode( $page_contents_right ), 6 );
				$shortcode_content_right = substr_replace( $page_content_right, "", - 6 );
				$shortcode_content_right = str_replace('style@',"style=", $shortcode_content_right);
				$shortcode_content_right = str_replace(';hash;',"#", $shortcode_content_right);
				$shortcode_content_right = str_replace('style&equals;',"style", $shortcode_content_right);
			}
			
			$page_contents 				= esc_textarea( $_GET['shortcode_content'] ?? '' );

			if ( $ezd_doc_content_type == 'widget_data' ) {
				$shortcode_content 		= $left_side_sidebar;

			} else {
				$page_content      		= substr( ezd_chrEncode( $page_contents ), 6 );
				$shortcode_content 		= substr_replace( $page_content, "", - 6 );
				$shortcode_content 		= str_replace('style@',"style=", $shortcode_content);
				$shortcode_content   	= str_replace(';hash;',"#", $shortcode_content);
				$shortcode_content   	= str_replace('style&equals;',"style", $shortcode_content);
			}
			
			if ( $current_post != 0 ) {
				update_post_meta( $current_post, 'ezd_doc_left_sidebar_type', $ezd_doc_content_type );
				update_post_meta( $current_post, 'ezd_doc_right_sidebar_type', $content_type );
				update_post_meta( $current_post, 'ezd_doc_left_sidebar', $shortcode_content );
				update_post_meta( $current_post, 'ezd_doc_right_sidebar', $shortcode_content_right );
			}
			wp_safe_redirect( admin_url( 'admin.php?page=eazydocs' ) );
		}
	}
}