<?php
namespace DocyCore\WPML;

use WPML_Elementor_Module_With_Items;

/**
 * App info integration
 */

defined( 'ABSPATH' ) || die();

class Cheatsheet extends WPML_Elementor_Module_With_Items  {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'cheat_sheet_contents';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return ['cs_title', 'cs_content', 'cs_number'];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'cs_title':
				return __( 'Cheat Sheet :: Box Title', 'docy-core' );
			case 'cs_content':
				return __( 'Cheat Sheet :: Box Content', 'docy-core' );
			case 'cs_number':
                return __( 'Cheat Sheet :: Box Number', 'docy-core' );
			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'cs_title':
				return 'LINE';
			case 'cs_content':
				return 'AREA';
			case 'cs_number':
				return 'LINE';
			default:
				return '';
		}
	}
}
