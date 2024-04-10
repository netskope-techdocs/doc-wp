<?php

namespace eazyDocsPro\Duplicator;

/**
 * Class Section_Duplicate
 *
 * @package eazyDocsPro\Duplicator
 */
class Section_Duplicate {
	public function __construct() {
		add_action( 'admin_action_section_doc_duplicate', [ $this, 'section_doc_duplicate' ] );
	}

	function section_doc_duplicate() {
		
		if ( isset($_GET['duplicate']) && !empty($_GET['duplicate']) && isset($_GET['action']) && $_GET['action'] === 'section_doc_duplicate' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], $_GET['duplicate']) ) {

			$parent 		= sanitize_text_field( $_GET['parent'] ?? '' );
			$duplicate_id 	= sanitize_text_field( $_GET['duplicate'] ?? '' );
			$posts  		= get_post( $duplicate_id );
			$order  		= '1';
			$rand   		= rand( 1, 9999 );

			$section_doc_title = $posts->post_title;
			$section_doc_slug  = str_replace( ' ', '-', $section_doc_title );

			$args = array(
				'post_content' => $posts->post_content,
				'post_parent'  => $parent,
				'post_status'  => 'draft',
				'post_title'   => $posts->post_title . ' #' . $rand,
				'post_type'    => 'docs',
				'menu_order'   => $posts->menu_order + $order,
			);

			$sec_id = wp_insert_post( $args );
			if ( $sec_id && ! is_wp_error( $sec_id ) ) {
				wp_update_post( [
					'ID'        => $sec_id,
					'post_name' => $section_doc_slug . '-' . $sec_id
				] );
			}

			/**
			 * Section Child Docs Duplicate by Section duplicator
			 **/

			$child = get_children( [
				'post_parent' => $posts->ID
			] );
			foreach ( $child as $doc ) {

				$sections       	= ezd_get_page_by_title( $doc->post_title, 'docs' );
				$is_section_id 		= '';

				foreach ( $sections as $section ) {
					$is_section_id .= $section->ID ?? '';
				}			

				if ( ! empty ( $is_section_id ) ) {

					$child_doc_title = $doc->post_title;
					$child_doc_slug  = str_replace( ' ', '-', $child_doc_title );

					$child_args = array(
						'post_content' => $doc->post_content,
						'post_parent'  => $sec_id ?? '',
						'post_status'  => 'draft',
						'post_title'   => $doc->post_title . ' #' . $rand,
						'post_type'    => 'docs'
					);

					$child_id = wp_insert_post( $child_args );
					if ( $child_id && ! is_wp_error( $child_id ) ) {
						wp_update_post( [
							'ID'        => $child_id,
							'post_name' => $child_doc_slug . '-' . $child_id
						] );
					}
				}

				/**
				 * Child Docs Duplicate by Section duplicator
				 **/

				$dp2 = get_children( [
					'post_parent' => $doc->ID
				] );
				foreach ( $dp2 as $dp3 ) {
					
					$childs       	= ezd_get_page_by_title( $dp3->post_title, 'docs' );
					$is_child_id 	= '';

					foreach ( $childs as $child ) {
						$is_child_id .= $child->ID ?? '';
					}

					if ( ! empty ( $is_child_id ) ) {

						$last_child_doc_title = $dp3->post_title;
						$last_child_doc_slug  = str_replace( ' ', '-', $last_child_doc_title );

						$childs = array(
							'post_content' => $dp3->post_content,
							'post_parent'  => $child_id ?? '',
							'post_status'  => 'draft',
							'post_title'   => $dp3->post_title,
							'post_type'    => 'docs'
						);

						$last_child_id = wp_insert_post( $childs );
						if ( $last_child_id && ! is_wp_error( $last_child_id ) ) {
							wp_update_post( [
								'ID'        => $last_child_id,
								'post_name' => $last_child_doc_slug . '-' . $last_child_id
							] );
						}
					}
				}
			}

			header( "Location:" . admin_url( 'admin.php?page=eazydocs' ) );
		}
	}
}