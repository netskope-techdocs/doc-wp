<?php
namespace DocyCore\WPML;

use WPML_Elementor_Module_With_Items;

/**
 * App info integration
 */

defined( 'ABSPATH' ) || die();

class Tab_items extends WPML_Elementor_Module_With_Items  {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'tabs';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return ['tab_title', 'tab_content'];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'tab_title':
				return __( 'Tab :: Title', 'docy-core' );
			case 'tab_content':
				return __( 'Tab :: Content', 'docy-core' );
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
			case 'tab_title':
				return 'LINE';
			case 'tab_content':
				return 'AREA';
			default:
				return '';
		}
	}
}
