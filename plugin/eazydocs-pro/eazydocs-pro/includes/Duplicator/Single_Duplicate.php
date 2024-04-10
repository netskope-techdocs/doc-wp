<?php
namespace eazyDocsPro\Duplicator;

/**
 * Class Single_Duplicate
 * @package eazyDocsPro\Duplicator
 */
class Single_Duplicate {
	public function __construct() {
		add_action( 'admin_action_doc_single_duplicate', [ $this, 'doc_single_duplicate' ] );
	}
	function doc_single_duplicate() {
		
		if ( isset($_GET['duplicate']) && !empty($_GET['duplicate']) && isset($_GET['action']) && $_GET['action'] === 'doc_single_duplicate' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['duplicate']) ) {
			
			$duplicate_id 	= sanitize_text_field( $_GET['duplicate'] ?? '' );
			$posts 			= get_post( $duplicate_id );
			$order 			= '1';
			if ( $posts ) {
				
				$doc_title 	= $posts->post_title;
				$doc_slug 	= str_replace(' ', '-', $doc_title);

				$args = array(
					'post_content'  => $posts->post_content,
					'post_parent'   => $posts->post_parent,
					'post_status'   => 'draft',
					'post_title'    => $posts->post_title,
					'post_name'		=> $doc_slug,
					'post_type'     => 'docs',
					'menu_order'    => $posts->menu_order + $order,
				);

				$single_id 			= wp_insert_post( $args );
				if ($single_id && !is_wp_error($single_id)) {
					wp_update_post([
						'ID' 		=> $single_id,
						'post_name' => $doc_slug .'-'. $single_id
					]);
				}

				header( "Location:" . admin_url( 'admin.php?page=eazydocs' ) );
			}
		}
	}
}