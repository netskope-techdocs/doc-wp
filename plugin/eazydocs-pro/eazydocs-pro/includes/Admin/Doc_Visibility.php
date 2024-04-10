<?php
namespace eazyDocsPro\Admin;

/**
 * Class Section_Duplicate
 * @package eazyDocsPro\Duplicator
 */
class Doc_Visibility {
	public function __construct() {
		add_action( 'admin_init', [ $this, 'ezd_doc_visibility' ] );
	}
	function ezd_doc_visibility() { 

		if ( isset( $_GET['doc_visibility'] ) && isset( $_GET['doc_visibility_type'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], $_GET['doc_visibility'] ) ) {

			$doc_id 					= sanitize_text_field( $_GET['doc_visibility'] ?? '' );
			$doc_visibility_type 		= sanitize_text_field( $_GET['doc_visibility_type'] ?? '' );
			
			$doc_password_input 		= '';
			if ( $doc_visibility_type == 'protected' ) {
				$doc_password_input 	= htmlspecialchars( $_GET['doc_password_input'] ?? '' );
				$doc_password_input 	= str_replace(';hash;',"#", $doc_password_input);			
				$doc_visibility_type 	= 'publish';
			}
			
			if ( ! empty($doc_id) ) {
				$parent_doc_id = $doc_id.',';
				$doc_args = get_children([
					'post_type'			=> 'docs',
					'post_parent'		=> $doc_id
				]);
				
				$sec_ids                = '';
				$child_sec_ids          = '';
				$child_ids              = '';
				foreach ( $doc_args as $pid ) {
					$sec_ids .= $pid->ID.',';
					
					$dp2 = get_children( [
						'post_parent' 	=> $pid->ID
					] );

					foreach ( $dp2 as $dp3 ) {
						$child_sec_ids .= $dp3->ID.',';
						
						$childs = get_children(array(
							'post_parent'  => $dp3->ID,
							'post_type'    => 'docs'
							)
						);
						
						foreach ( $childs as $child ) {
							$child_sec_ids .= $child->ID.',';
						}
					}
				}
				
				$docs_ids 				= $parent_doc_id . $sec_ids . $child_sec_ids . $child_ids;
				$docs_ids 				= rtrim($docs_ids, ",");
				$doc_ids                = explode( ',', $docs_ids );
				$doc_ids_int            = array_map( 'intval', $doc_ids );
				
				foreach ( $doc_ids_int as $doc_id_int ) {				
					$doc_title 			= get_the_title($doc_id_int);
					$doc_title_by_id 	= explode('#', $doc_title); 
					
					$doc_status = array(
						'post_title'	=> $doc_title_by_id[0],
						'ID' 			=> $doc_id_int,
						'post_type'		=> 'docs',
						'post_status'	=> $doc_visibility_type,
						'post_password'	=> $doc_password_input
					);	
								
					wp_update_post($doc_status);
				}

				header( "Location:" . admin_url( 'admin.php?page=eazydocs' ) );
			}
		}
	}
}