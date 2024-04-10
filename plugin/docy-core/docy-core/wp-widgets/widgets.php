<?php
// Require widget files
require plugin_dir_path(__FILE__) . 'Recent_posts.php';
require plugin_dir_path(__FILE__) . 'About.php';
require plugin_dir_path(__FILE__) . 'Docs.php';
require plugin_dir_path(__FILE__) . 'Forums_widget.php';
require plugin_dir_path(__FILE__) . 'Topic_details.php';
require plugin_dir_path(__FILE__) . 'Bbpress_Forum_Topic_Info.php';

// Register Widgets
add_action( 'widgets_init', function() {
    register_widget( 'DocyCore\WpWidgets\Recent_Posts');
    register_widget('DocyCore\WpWidgets\About');
    //register_widget( 'DocyCore\WpWidgets\Docs');
    if ( class_exists('bbPress') ) {
        unregister_widget( 'BBP_Forums_Widget' );
	    register_widget( 'DocyCore\WpWidgets\Forums' );
	    register_widget( 'DocyCore\WpWidgets\Bbpress_Forum_Topic_Info' );
	    //register_widget( 'DocyCore\WpWidgets\Topic_details' );
    }
});