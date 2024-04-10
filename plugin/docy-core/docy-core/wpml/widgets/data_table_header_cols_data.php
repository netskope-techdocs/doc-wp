<?php
namespace DocyCore\WPML;

use WPML_Elementor_Module_With_Items;

/**
 * App info integration
 */

defined( 'ABSPATH' ) || die();

class data_table_header_cols_data extends WPML_Elementor_Module_With_Items  {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'data_table_header_cols_data';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return ['data_table_header_col', 'data_table_header_col_span'];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case 'data_table_header_col':
                return __( 'Table :: Column Name', 'docy-core' );
            case 'data_table_header_col_span':
                return __( 'Table :: Column Span', 'docy-core' );
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
            case 'data_table_header_col':
                return 'LINE';
            case 'data_table_header_col_span':
                return 'LINE';
            default:
                return '';
        }
    }
}
