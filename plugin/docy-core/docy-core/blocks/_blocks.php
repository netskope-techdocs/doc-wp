<?php

if( !class_exists('docy_acf_custom_fields') ) :
    class docy_acf_custom_fields {
        // vars
        var $settings;
        function __construct() {
            // settings
            // - these will be passed into the field class.
            $this->settings = array(
                'version'	=> '1.0.0',
                'url'		=> plugin_dir_url( __FILE__ ),
                'path'		=> plugin_dir_path( __FILE__ )
            );

            // include field
            add_action('acf/include_field_types', 	array($this, 'docy_include_field')); // v5
            add_action('acf/register_fields', 		array($this, 'docy_include_field')); // v4
        }
        function docy_include_field() {
            // include
            require_once __DIR__. '/fields/class-docy-acf-field-margin-v5.php';
            require_once __DIR__. '/fields/class-docy-acf-field-padding-v5.php';
            require_once __DIR__. '/fields/class-docy-acf-field-typography-v5.php';
        }

    }
// initialize
    new docy_acf_custom_fields();
//Enqueue style and scripts
function docy_acf_assets(){
    wp_enqueue_style('docy-acf-custom', plugins_url() . '/docy-core/assets/css/acfblocks.css');
    wp_enqueue_script('docy-acf-custom', plugins_url() . '/docy-core/assets/js/acfscript.js');
}
//add_action('enqueue_block_editor_assets', 'docy_acf_assets');

// class_exists check
endif;






add_action('acf/init', function() {

    // check function exists
    if( function_exists('acf_register_block_type') ) {

        //Cheat Sheet
        acf_register_block_type( array(
            'name'              => 'docy-cheatsheet',
            'title'             => esc_html__('Cheat Sheet', 'docy-core'),
            'description'       => esc_html__('A custom cheat sheet block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_cheatsheet',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'cheat sheet', 'cheatsheet' ),
        ) );

        //Image Hotspots
        acf_register_block_type( array(
            'name'              => 'docy-image-hotspots',
            'title'             => esc_html__('Image Hotspots', 'docy-core'),
            'description'       => esc_html__('A custom image hotspots block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_image_hotspots',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'image hotspots', 'hotspots' ),
        ) );

        //List Style
        acf_register_block_type( array(
            'name'              => 'docy-list-style',
            'title'             => esc_html__('Docy List', 'docy-core'),
            'description'       => esc_html__('A custom list style block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_list',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'list', 'list style', 'docy list' ),
        ) );
    }
});

    //ACF wysiwyg editor height control
    add_action('acf/input/admin_head', 'my_acf_modify_wysiwyg_height');
    function my_acf_modify_wysiwyg_height() {
        ?>
        <style type="text/css">
            .acf-field-624bb7205c5e6 iframe{
                min-height: 0;
                height: 80px !important;
            }
            .acf-field-624bd0373703d iframe{
                min-height: 0;
                height: 100px !important;
            }
        </style>
        <?php
    }

    //Active docs list
    function acf_docy_active_docs_list( $field ) {

        $field['choices'] = docy_get_posts();
        $choices = get_field('active_doc', 'option', false);

        if( is_array($choices) ) {
            foreach( $choices as $choice ) {
                $field['choices'][ $choice ] = $choice;
            }
        }

        return $field;

    }
    add_filter('acf/load_field/name=active_doc', 'acf_docy_active_docs_list');

    //Exclude docs list
    function acf_docy_docs_list_exclude( $field ) {

        $field['choices'] = docy_get_posts();
        $choices = get_field('exclude_docs', 'option', false);

        if( is_array($choices) ) {
            foreach( $choices as $choice ) {
                $field['choices'][ $choice ] = $choice;
            }
        }

        return $field;

    }
    add_filter('acf/load_field/name=exclude_docs', 'acf_docy_docs_list_exclude');

    //docs list
    function acf_docy_doc_list( $field ) {

        $field['choices'] = docy_get_posts();
        $choices = get_field('docy_doc_type', 'option', false);

        if( is_array($choices) ) {
            foreach( $choices as $choice ) {
                $field['choices'][ $choice ] = $choice;
            }
        }

        return $field;

    }
    add_filter('acf/load_field/name=docy_doc_type', 'acf_docy_doc_list');

    //single forum list
    function acf_docy_single_forum_list( $field ) {

        $field['choices'] = docy_get_posts( 'forum' );
        $choices = get_field('select_forum', 'option', false);

        if( is_array($choices) ) {
            foreach( $choices as $choice ) {
                $field['choices'][ $choice ] = $choice;
            }
        }

        return $field;

    }
    add_filter('acf/load_field/name=select_forum', 'acf_docy_single_forum_list');

require_once __DIR__.'/test.php';
require_once __DIR__.'/tab.php';
require_once __DIR__.'/accordion.php';
require_once __DIR__.'/changelogs.php';
require_once __DIR__.'/notice.php';
require_once __DIR__.'/cheatsheet.php';
require_once __DIR__.'/hotspots.php';
require_once __DIR__.'/list.php';
require_once __DIR__.'/ask.php';
require_once __DIR__.'/cta.php';
require_once __DIR__.'/hero.php';
require_once __DIR__.'/counterup.php';
require_once __DIR__.'/video.php';
require_once __DIR__.'/forum-topics.php';
require_once __DIR__.'/forums.php';
require_once __DIR__.'/single-forum.php';
require_once __DIR__.'/subscribe.php';
require_once __DIR__.'/docs.php';
require_once __DIR__.'/single-doc.php';
require_once __DIR__.'/faq.php';
require_once __DIR__.'/testimonial.php';
require_once __DIR__.'/feature-boxes.php';
require_once __DIR__.'/feature-icon-boxes.php';