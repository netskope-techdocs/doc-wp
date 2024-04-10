<?php
namespace eazyDocsPro\Duplicator;

/**
 * Class Section_Child_Duplicate
 * @package eazyDocsPro\Duplicator
 */
class Section_Child_Duplicate {
	public function __construct() {
		add_action( 'admin_action_child_section_doc_duplicate', [ $this, 'child_section_doc_duplicate' ] );
	}
	function child_section_doc_duplicate() {
		
		if ( isset($_GET['duplicate']) && !empty($_GET['duplicate']) && isset($_GET['action']) && $_GET['action'] === 'child_section_doc_duplicate' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['duplicate']) ) {

			$parent 		= sanitize_text_field( $_GET['parent'] ?? '' );
			$duplicate_id 	= sanitize_text_field( $_GET['duplicate'] ?? '' );
			$posts 			= get_post( $duplicate_id );
			if ( $posts ) {
				$order              		= '1';
				$rand               		= rand( 1, 9999 );				
				$section_doc_title 			= $posts->post_title;
				$section_slug 				= str_replace(' ', '-', $section_doc_title);

				$args = array(
					'post_content'  		=> $posts->post_content,
					'post_parent'   		=> $parent,
					'post_status'   		=> 'draft',
					'post_title'    		=> $posts->post_title . ' #' . $rand,
					'post_name'				=> $section_slug,
					'post_type'     		=> 'docs',
					'menu_order'    		=> $posts->menu_order + $order,
				);

				$child_id 					= wp_insert_post( $args );

				if ($child_id && !is_wp_error($child_id)) {
					wp_update_post([
						'ID' 				=> $child_id,
						'post_name' 		=> $section_slug .'-'. $child_id
					]);
				}

				/**
				 * Child Docs Duplicate by Section Child duplicator
				**/

				$child                  	= get_post( $posts->ID );
				$child = get_children( [
					'post_parent'       	=> $child->ID ?? '',
				] );
				
				foreach ( $child as $doc ) {
					
					$sections       = ezd_get_page_by_title( $doc->post_title, 'docs' );
					$is_section_id 	= '';

					foreach ( $sections as $section ) {
						$is_section_id .= $section->ID ?? '';
					}

					if ( ! empty ( $is_section_id ) ) {
						$child_doc_title 	= $doc->post_title;
						$child_slug 		= str_replace(' ', '-', $child_doc_title);

						$child_args = array(
							'post_content' 	=> $doc->post_content,
							'post_parent' 	=> $child_id,
							'post_status' 	=> 'draft',
							'post_title' 	=> $doc->post_title,
							'post_name' 	=> $child_slug,
							'post_type' 	=> 'docs'
						);

						$last_child_id 		= wp_insert_post($child_args);
						if ($last_child_id && !is_wp_error($last_child_id)) {
							wp_update_post([
								'ID' 		=> $last_child_id,
								'post_name' => $child_slug . '-' . $last_child_id
							]);
						}
					}
				}
			}
			header( "Location:" . admin_url( 'admin.php?page=eazydocs' ) );
		}
	}
}