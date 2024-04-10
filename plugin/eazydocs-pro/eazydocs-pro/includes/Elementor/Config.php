<?php
namespace eazyDocsPro\Elementor;

/**
 * Class Config
 * @package eazyDocsPro\Elementor
 */

class Config{
    function __construct(){
      add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
    }

    public function register_widgets( $widgets_manager ) {
       // Include Widget files
       require_once( __DIR__ . '/Glossary_Doc/Glossary_Doc.php' );
       $widgets_manager->register( new Glossary_Doc\Glossary_Doc() );
    }
}