<?php
namespace DocyCore\WPML;

use WPML_Elementor_Module_With_Items;

/**
 * Counter integration
 */

defined( 'ABSPATH' ) || die();

class Counter extends WPML_Elementor_Module_With_Items  {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'counter_section';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return ['count_label', 'count_value'];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case 'count_label':
                return __( 'Counter: Label', 'docy-core' );
            case 'count_value':
                return __( 'Counter: Count Value', 'docy-core' );
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
            case 'count_label':
                return 'LINE';
            case 'count_value':
                return 'LINE';
            default:
                return '';
        }
    }
}