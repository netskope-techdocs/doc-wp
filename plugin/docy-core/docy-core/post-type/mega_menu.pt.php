<?php
// event.pt.php

/**
 * Use namespace to avoid conflict
 */
namespace PostType;

/**
 * Class Portfolio
 * @package PostType
 *
 * Use actual name of post type for
 * easy readability.
 *
 * Potential conflicts removed by namespace
 */
class Mega_Menu {

    /**
     * @var string
     *
     * Set post type params
     */
    private $type               = 'mega_menu';
    private $slug               = 'mega_menu';
    private $name               = 'Mega Menus';
    private $singular_name      = 'Mega Menu';
    private $icon               = 'dashicons-feedback';

    /**
     * Register post type
     */
    public function register() {
        $opt = get_option( 'docy_opt');
        $slug = !empty($opt['mega_menu_slug']) ? strtolower(str_replace( ' ', '', $opt['mega_menu_slug'])) : $this->slug;
        $labels = array(
            'name'                  => esc_html_x( 'Mega Menus', 'Post Type General Name', 'docy-core' ),
            'singular_name'         => esc_html_x( 'Mega Menu', 'Post Type Singular Name', 'docy-core' ),
            'add_new'               => esc_html__( 'Add New', 'docy-core' ),
            'add_new_item'          => esc_html__( 'Add New', 'docy-core' ) . $this->singular_name,
            'edit_item'             => esc_html__( 'Edit', 'docy-core' ) . $this->singular_name,
            'new_item'              => esc_html__( 'New ', 'docy-core' ) . $this->singular_name,
            'all_items'             => esc_html__( 'All ', 'docy-core' )  . $this->name,
            'view_item'             => esc_html__( 'View ', 'docy-core' ) . $this->singular_name,
            'view_items'            => esc_html__( 'View ', 'docy-core' ) . $this->name,
            'search_items'          => esc_html__( 'Search ', 'docy-core' ) . $this->name,
            'not_found'             => esc_html__( 'No ', 'docy-core' ) . strtolower($this->name) . esc_html__( ' found', 'docy-core'),
            'not_found_in_trash'    => esc_html__( 'No ', 'docy-core' ) . strtolower($this->name) .  esc_html__( ' found in Trash', 'docy-core'),
            'parent_item_colon'     => '',
            'menu_name'             => $this->name,
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array( 'slug' => $slug ),
            'capability_type'       => 'post',
            'has_archive'           => false,
            'hierarchical'          => true,
            'menu_position'         => 8,
            'supports'              => array( 'title', 'author', 'elementor' ),
            'yarpp_support'         => true,
            'menu_icon'             => $this->icon
        );

        register_post_type( $this->type, $args );
    }

    /**
     * @param $columns
     * @return mixed
     *
     * Choose the columns you want in
     * the admin table for this post
     */
    public function set_columns($columns) {
        // Set/unset post type table columns here

        return $columns;
    }

    /**
     * @param $column
     * @param $post_id
     *
     * Edit the contents of each column in
     * the admin table for this post
     */
    public function edit_columns($column, $post_id) {
        // Post type table column content code here
    }

    /**
     * Portfolio constructor.
     *
     * When class is instantiated
     */
    public function __construct() {

        // Register the post type
        add_action( 'init', array($this, 'register'));

        // Admin set post columns
        add_filter( 'manage_edit-'.$this->type.'_columns',        array($this, 'set_columns'), 10, 1) ;

        // Admin edit post columns
        add_action( 'manage_'.$this->type.'_posts_custom_column', array($this, 'edit_columns'), 10, 2 );

    }

}

/**
 * Instantiate class, creating post type
 */
new Mega_Menu();