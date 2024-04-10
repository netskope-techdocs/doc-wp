<?php
namespace DocyCore\WPML;

use WPML_Elementor_Module_With_Items;

/**
 * App info integration
 */

defined( 'ABSPATH' ) || die();

class testimonials extends WPML_Elementor_Module_With_Items  {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'testimonials';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return ['name', 'designation', 'content'];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	protected function get_title( $field ) {
		switch ( $field ) {
			case 'name':
				return __( 'Testimonials :: Name', 'docy-core' );
			case 'designation':
				return __( 'Testimonials :: Designation', 'docy-core' );
			case 'content':
                return __( 'Testimonials :: Content', 'docy-core' );
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
			case 'name':
				return 'LINE';
			case 'designation':
				return 'LINE';
			case 'content':
				return 'AREA';
			default:
				return '';
		}
	}
}
