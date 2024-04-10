<?php
namespace eazyDocsPro\Duplicator;

/**
 * Class Parent_Duplicate
 * @package eazyDocsPro\Duplicator
 */
class Parent_Duplicate {
	public function __construct() {
		add_action( 'admin_action_parent_doc_duplicate', [ $this, 'parent_doc_duplicate' ] );
	}
	function parent_doc_duplicate() {
	 
		if ( isset($_GET['duplicate']) && !empty($_GET['duplicate']) && isset($_GET['action']) && $_GET['action'] === 'parent_doc_duplicate' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['duplicate']) ) {
			
			$duplicate_id 		= sanitize_text_field( $_GET['duplicate'] ?? '' );
			$posts              = get_post( $duplicate_id );
			$order              = '1';
			$rand               = rand( 1, 9999 );
			
			$main_doc_title 	= $posts->post_title;
			$main_doc_slug 		= str_replace(' ', '-', $main_doc_title) ;
 
			$args = array(
				'post_content'  => $posts->post_content,
				'post_parent'   => 0,
				'post_status'   => 'draft',
				'post_title'    => $posts->post_title . ' #' . $rand,
				'post_type'     => 'docs',
				'menu_order'    => $posts->menu_order + $order,
			);
			$main_doc_id 		= wp_insert_post( $args );
			if ($main_doc_id && !is_wp_error($main_doc_id)) {
				wp_update_post([
					'ID' 		=> $main_doc_id,
					'post_name' => $main_doc_slug .'-'. $main_doc_id
				]);
			}

			/**
			 * Section Docs Duplicate by Parent duplicator
			 **/

			$parent = get_children( [
				'post_parent'    => $posts->ID ?? ''
			] );
 
			foreach ( $parent as $pid ) {

				$section 		= ezd_get_page_by_title( $pid->post_title, 'docs' );
				$is_section_id 	= '';

				foreach ( $section as $sec ) {
					$is_section_id .= $sec->ID ?? '';
				}
				
				if ( ! empty ( $is_section_id ) ) {

					$section_doc_title 	= $pid->post_title;
					$section_slug 		= str_replace(' ', '-', $section_doc_title);

					$sec_args = array(
						'post_content' 		=> $pid->post_content,
						'post_parent' 		=> $main_doc_id,
						'post_status' 		=> 'draft',
						'post_title' 		=> $pid->post_title . ' #' . $rand,
						'post_type' 		=> 'docs',
						'menu_order' 		=> $pid->menu_order + $order,
					);

					$sec_doc_id = wp_insert_post($sec_args);
					if ($sec_doc_id && !is_wp_error($sec_doc_id)) {
						wp_update_post([
							'ID' 			=> $sec_doc_id,
							'post_name' 	=> $section_slug . '-' . $sec_doc_id
						]);
					}
				}

				/**
				 * Section Child Docs Duplicate by Parent duplicator
				 **/
				
				$dp2 = get_children( [
					'post_parent' 	=> $pid->ID ?? ''
				] );
				foreach ( $dp2 as $dp3 ) {
					
					$childs			= ezd_get_page_by_title( $dp3->post_title, 'docs' );
					$is_child_id 	= '';

					foreach ( $childs as $child ) {
						$is_child_id .= $child->ID ?? '';
					}

					if ( ! empty ( $is_child_id ) ) {
						$child_doc_title 	= $dp3->post_title;
						$child_slug 		= str_replace(' ', '-', $child_doc_title);

						$child_args = array(
							'post_content' 	=> $dp3->post_content,
							'post_parent' 	=> $sec_doc_id,
							'post_status' 	=> 'draft',
							'post_title' 	=> $dp3->post_title . ' #' . $rand,
							'post_type' 	=> 'docs'
						);

						$child_doc_id = wp_insert_post($child_args);
						if ($child_doc_id && !is_wp_error($child_doc_id)) {
							wp_update_post([
								'ID' 		=> $child_doc_id,
								'post_name' => $child_slug . '-' . $child_doc_id
							]);
						}
					}

				/**
				 * Child Docs Duplicate by Parent duplicator
				 **/

				$child_dp3 = get_children( [
					'post_parent'			=> $dp3->ID ?? ''
				] );
					
				foreach ( $child_dp3 as $childs_dp3 ) {
					$last_childs 			= ezd_get_page_by_title( $childs_dp3->post_title, 'docs' );
					$is_last_child 			= '';
					
					foreach ( $last_childs as $last_child ) {
						$is_last_child .= $last_child->ID;
					}

					if ( ! empty ( $is_last_child ) ) {

						$last_child_doc_title = $childs_dp3->post_title;
						$last_child_slug 	= str_replace(' ', '-', $last_child_doc_title);

						$last_child_arg = array(
							'post_content' 	=> $childs_dp3->post_content,
							'post_parent' 	=> $child_doc_id,
							'post_status' 	=> 'draft',
							'post_title' 	=> $childs_dp3->post_title,
							'post_type' 	=> 'docs'
						);

						$last_child_doc = wp_insert_post($last_child_arg);
						if ($last_child_doc && !is_wp_error($last_child_doc)) {
							wp_update_post([
								'ID' 		=> $last_child_doc,
								'post_name' => $last_child_slug . '-' . $last_child_doc
							]);
						}
					}
				}
			}
		}
		header( "Location:" . admin_url( 'admin.php?page=eazydocs' ) );
		}
	}
}