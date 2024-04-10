<?php
namespace eazyDocsPro\Frontend;

class Frontend {
	public function __construct() {
        add_filter( 'body_class', [ $this, 'body_class' ] );
	}
    
	/**
	 * @return array
	 *
	 * @since 1.0.0
	 */
    public function body_class( $classes ) {
        
        $current_theme 	= 'ezd-theme-'.str_replace(' ', '-', strtolower(wp_get_theme()));
        $classes[]		= $current_theme;
        
        return $classes;
    }
}