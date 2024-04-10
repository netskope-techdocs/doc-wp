<?php
namespace DocyCore\WPML;

use WPML_Elementor_Module_With_Items;

/**
 * App info integration
 */

defined( 'ABSPATH' ) || die();

class data_table_content_rows extends WPML_Elementor_Module_With_Items  {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'data_table_content_rows';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return ['data_table_content_row_title', 'data_table_content_row_content'];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case 'data_table_content_row_title':
                return __( 'Table :: Cell Title', 'docy-core' );
            case 'data_table_content_row_content':
                return __( 'Table :: Cell Text', 'docy-core' );
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
            case 'data_table_content_row_title':
                return 'LINE';
            case 'data_table_content_row_content':
                return 'AREA';
            default:
                return '';
        }
    }
}
