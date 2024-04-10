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

        // Tab
        acf_register_block_type( array (
            'name'				=> 'docy-tab',
            'title'				=> esc_html__('Tab', 'docy-core'),
            'description'		=> esc_html__('A custom tab block by Docy.', 'docy-core'),
            'render_callback'	=> 'docy_acf_block_tab',
            'category'			=> 'formatting',
            'icon'				=> 'editor-table',
            'keywords'			=> array( 'tab', 'tabs' ),
        ));

        // Accordion
        acf_register_block_type( array (
            'name'				=> 'docy-accordion',
            'title'				=> esc_html__('Accordion', 'docy-core'),
            'description'		=> esc_html__('A custom accordion block by Docy.', 'docy-core'),
            'render_callback'	=> 'docy_acf_block_accordion',
            'category'			=> 'formatting',
            'icon'				=> 'menu-alt3',
            'keywords'			=> array( 'accordion', 'toggle' ),
        ));

        // Notice
        acf_register_block_type( array (
            'name'				=> 'docy-notice',
            'title'				=> esc_html__('Notice/Message', 'docy-core'),
            'description'		=> esc_html__('A custom notice/message block by Docy.', 'docy-core'),
            'render_callback'	=> 'docy_acf_block_notice',
            'category'			=> 'formatting',
            'icon'				=> 'info',
            'keywords'			=> array( 'notice', 'message', 'info', 'explanation', 'alert' ),
        ));

        // Changelogs
        acf_register_block_type( array (
            'name'				=> 'docy-changelogs',
            'title'				=> esc_html__('Changelogs', 'docy-core'),
            'description'		=> esc_html__('A custom changelog block by Docy.', 'docy-core'),
            'render_callback'	=> 'docy_acf_block_changelogs',
            'category'			=> 'formatting',
            'icon'				=> 'info',
            'keywords'			=> array( 'notice', 'message', 'info', 'explanation', 'alert' ),
        ));

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

        //test block
        acf_register_block_type( array(
            'name'              => 'docy-tbb',
            'title'             => esc_html__('Test Block', 'docy-core'),
            'description'       => esc_html__('A custom test block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_testblock',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'test', 'block' ),
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

        //Home hero search
        acf_register_block_type( array(
            'name'              => 'docy-home-hero-search',
            'title'             => esc_html__('Hero Search', 'docy-core'),
            'description'       => esc_html__('A custom hero search block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_home_hero_search',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'hero', 'hero search', 'home hero search' ),
            'enqueue_assets' => function(){
                wp_enqueue_style( 'niceselect', plugins_url() . '/docy-core/assets/vendors/niceselectpicker/nice-select.css', null, null, 'all' );
                wp_enqueue_script( 'niceselect', plugins_url() . '/docy-core/assets/vendors/niceselectpicker/jquery.nice-select.min.js', array('jquery'), '', true );
            },
        ) );

        //Subscribe
        acf_register_block_type( array(
            'name'              => 'docy-subscribe',
            'title'             => esc_html__('Subscribe', 'docy-core'),
            'description'       => esc_html__('A custom subscribe block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_subscribe',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'subscribe', 'docy subscribe' ),
            'enqueue_assets' => function(){
                wp_enqueue_script( 'ajax-chimp', plugins_url() . '/docy-core/assets/js/ajax-chimp.js', array('jquery'), '', true );
            },
        ) );

        //Counter up
        acf_register_block_type( array(
            'name'              => 'docy-counterup',
            'title'             => esc_html__('Docy Counter', 'docy-core'),
            'description'       => esc_html__('A custom counter up number block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_counterup',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'counter', 'counter up', 'docy counter' ),
            'enqueue_assets' => function(){
                wp_enqueue_script( 'counterup-waypoints', plugins_url() . '/docy-core/assets/vendors/counterup/jquery.waypoints.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'counterup-main', plugins_url() . '/docy-core/assets/vendors/counterup/jquery.counterup.min.js', array(), '', true );
                wp_enqueue_script( 'counterup-appear', plugins_url() . '/docy-core/assets/vendors/counterup/appear.js', array(), '', true );
            },
        ) );

        //Video Playlist
//        acf_register_block_type( array(
//            'name'              => 'docy-video-playlist',
//            'title'             => esc_html__('Video Playlist', 'docy-core'),
//            'description'       => esc_html__('A custom video playlist block by Docy.', 'docy-core'),
//            'render_callback'   => 'docy_acf_block_video',
//            'category'          => 'formatting',
//            'icon'              => 'info',
//            'keywords'          => array( 'video', 'video playlist', 'docy video playlist' ),
//            'enqueue_assets' => function(){
//                wp_enqueue_style( 'ionicons', 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css' );
//                wp_enqueue_style( 'slick', plugins_url() . '/docy-core/assets/vendors/slick/slick.css' );
//                wp_enqueue_style( 'slick-theme', plugins_url() . '/docy-core/assets/vendors/slick/slick-theme.css' );
//                wp_enqueue_style( 'video', plugins_url() . '/docy-core/assets/vendors/video/videojs.min.css' );
//                wp_enqueue_style( 'video-theaterMode', plugins_url() . '/docy-core/assets/vendors/video/videojs.theaterMode.css' );
//                wp_enqueue_script( 'ionicons', 'https://unpkg.com/ionicons@5.4.0/dist/ionicons.js', array('jquery'), '', true );
//                wp_enqueue_script( 'artplayer', plugins_url() . '/docy-core/assets/vendors/video/artplayer.js', array('jquery'), '3.5.16', true );
//                wp_enqueue_script( 'mcustomscrollbar', plugins_url() . '/docy-core/assets/vendors/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js', array('jquery'), '3.1.13', true );
//                wp_enqueue_script( 'nuevo', plugins_url() . '/docy-core/assets/vendors/video/nuevo.min.js', array('jquery'), '', true );
//                wp_enqueue_script( 'video', plugins_url() . '/docy-core/assets/vendors/video/video.min.js', array('jquery'), '', true );
//                wp_enqueue_script( 'slick', plugins_url() . '/docy-core/assets/vendors/slick/slick.js', array('jquery'), '', true );
//            },
//        ) );

        //Testimonials
        acf_register_block_type( array(
            'name'              => 'docy-testimonial',
            'title'             => esc_html__('Testimonial', 'docy-core'),
            'description'       => esc_html__('A custom testimonial block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_testimonial',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'testimonial', 'docy testimonial' ),
            'enqueue_assets' => function(){
                wp_enqueue_style( 'slick', plugins_url() . '/docy-core/assets/vendors/slick/slick.css' );
                wp_enqueue_style( 'slick-theme', plugins_url() . '/docy-core/assets/vendors/slick/slick-theme.css' );
                wp_enqueue_script( 'slick', plugins_url() . '/docy-core/assets/vendors/slick/slick.js', array('jquery'), '', true );
                wp_enqueue_script( 'docy-wow', plugins_url() . '/docy-core/assets/vendors/wow/wow.min.js', array( 'jquery' ), '1.1.3', true );
            },
        ) );

        //Forum Topics
        acf_register_block_type( array(
            'name'              => 'docy-forum-topics',
            'title'             => esc_html__('Forum Topics', 'docy-core'),
            'description'       => esc_html__('A custom forum topics block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_forum_topics',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'forum', 'forum topics' ),
        ) );

        //Single Doc
        acf_register_block_type( array(
            'name'              => 'docy-single-doc',
            'title'             => esc_html__('Single Doc', 'docy-core'),
            'description'       => esc_html__('A custom single doc block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_single_doc',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'single doc', 'docy single doc' ),
        ) );

        //Forums
        acf_register_block_type( array(
            'name'              => 'docy-forums',
            'title'             => esc_html__('Forums', 'docy-core'),
            'description'       => esc_html__('A custom forums block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_forums',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'forums', 'docy forums' ),
        ) );

        //Single Forum
        acf_register_block_type( array(
            'name'              => 'docy-single-forum',
            'title'             => esc_html__('Single Forum', 'docy-core'),
            'description'       => esc_html__('A custom single forum block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_single_forum',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'single forum', 'docy single forum' ),
        ) );

        //Docs
        acf_register_block_type( array(
            'name'              => 'docy-docs',
            'title'             => esc_html__('Docs', 'docy-core'),
            'description'       => esc_html__('A customd docs block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_docs',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'docs', 'docy docs' ),
        ) );

        //Faqs
        acf_register_block_type( array(
            'name'              => 'docy-faqs',
            'title'             => esc_html__('FAQ Tabs', 'docy-core'),
            'description'       => esc_html__('A customd faqs block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_faq',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'faqs', 'docy faqs' ),
        ) );

        //Feature Boxes
        acf_register_block_type( array(
            'name'              => 'docy-feature-boxes',
            'title'             => esc_html__('Feature Boxes', 'docy-core'),
            'description'       => esc_html__('A customd feature boxes block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_feature',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'feature', 'feature boxes' ),
        ) );

        //Feature Icon Boxes
        acf_register_block_type( array(
            'name'              => 'docy-feature-icon-box',
            'title'             => esc_html__('Feature Icon Boxes', 'docy-core'),
            'description'       => esc_html__('A customd feature icon boxes block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_feature_icon',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'feature icon', 'feature icon boxes' ),
        ) );

        //Ask
        acf_register_block_type( array(
            'name'              => 'docy-ask',
            'title'             => esc_html__('Docy Ask', 'docy-core'),
            'description'       => esc_html__('A customd ask block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_ask',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'ask', 'docy ask' ),
        ) );

        //CTA
        acf_register_block_type( array(
            'name'              => 'docy-cta',
            'title'             => esc_html__('Docy CTA', 'docy-core'),
            'description'       => esc_html__('A customd cta block by Docy.', 'docy-core'),
            'render_callback'   => 'docy_acf_block_cta',
            'category'          => 'formatting',
            'icon'              => 'info',
            'keywords'          => array( 'cta', 'docy cta' ),
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