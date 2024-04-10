<?php
CSF::createSection( 'docy_opt', array(
	'title' => esc_html__( 'Blog Pages', 'docy' ),
	'id'    => 'blog_page',
	'icon'  => 'dashicons dashicons-admin-post',
) );

/**
 * Blog archive settings
 */
CSF::createSection( 'docy_opt', array(
	'parent'     => 'blog_page',
	'title'      => esc_html__( 'Blog archive', 'docy' ),
	'id'         => 'blog_meta_opt',
	'icon'       => '',
	'subsection' => true,
	'fields'     => array(

		array(
			'title' => esc_html__( 'Blog archive', 'docy' ),
			'id'    => 'Blog_archive_opt',
			'type'  => 'heading',
		),

		array(
			'title'    => esc_html__( 'Blog page title', 'docy' ),
			'subtitle' => esc_html__( 'Controls the title text that displays in the page title bar only if your front page displays your latest post in "Settings > Reading".',
				'docy' ),
			'id'       => 'blog_title',
			'type'     => 'text',
			'default'  => esc_html__( 'Blog List', 'docy' )
		),

		array(
			'title'    => esc_html__( 'Blog Layout', 'docy' ),
			'subtitle' => esc_html__( 'The Blog layout will also apply on the blog category and tag pages.', 'docy' ),
			'id'       => 'blog_layout',
			'type'     => 'image_select',
			'options'  => array(
				'list'          => DOCY_DIR_IMG . '/layouts/list.jpg',
				'grid'          => DOCY_DIR_IMG . '/layouts/blog_grid.jpg',
				'blog_category' => DOCY_DIR_IMG . '/layouts/blog_grid_category_tab.jpg',
			),
			'default'  => 'list'
		),

		array(
			'title'      => esc_html__( 'Column', 'docy' ),
			'id'         => 'blog_column',
			'type'       => 'select',
			'options'    => [
				'6' => esc_html__( 'Two', 'docy' ),
				'4' => esc_html__( 'Three', 'docy' ),
				'3' => esc_html__( 'Four', 'docy' ),
			],
			'default'    => '6',
			'dependency' => array( 'blog_layout', 'any', 'grid,blog_category' ),
		),
		array(
			'title'         => esc_html__( 'Post title length', 'docy' ),
			'subtitle'      => esc_html__( 'Blog post title length in character', 'docy' ),
			'id'            => 'post_title_length',
			'type'          => 'slider',
			'default'       => 50,
			"min"           => 1,
			"step"          => 1,
			"max"           => 500,
			'display_value' => 'text',
		),
		array(
			'title'         => esc_html__( 'Post Word Excerpt', 'docy' ),
			'subtitle'      => esc_html__( 'If post excerpt empty, the excerpt content will take from the post content. Define here how much word you want to show along with the each posts in the blog page.',
				'docy' ),
			'id'            => 'blog_excerpt',
			'type'          => 'slider',
			'default'       => 40,
			"min"           => 1,
			"step"          => 1,
			"max"           => 100,
			'display_value' => 'text'
		),
		array(
			'title'      => esc_html__( 'Continue Reading Label', 'docy' ),
			'id'         => 'blog_continue_read',
			'type'       => 'text',
			'default'    => esc_html__( 'Continue Reading', 'docy' ),
			'dependency' => array(
				array( 'blog_layout', '==', 'list' ),
			),
		),
		array(
			'title'      => esc_html__( 'Post Meta', 'docy' ),
			'subtitle'   => esc_html__( 'Show/hide post meta on blog archive page', 'docy' ),
			'id'         => 'is_post_meta',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
		),
		array(
			'title'      => esc_html__( 'Post Date', 'docy' ),
			'id'         => 'is_post_date',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_post_meta', '==', 1 )
		),
		array(
			'title'      => esc_html__( 'Post Reading Time', 'docy' ),
			'id'         => 'is_post_reading_time',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_post_meta', '==', 1 )
		),
		array(
			'title'      => esc_html__( 'Post category', 'docy' ),
			'id'         => 'is_post_cat',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_post_meta', '==', 1 )
		),
		array(
			'title'      => esc_html__( 'Author', 'docy' ),
			'id'         => 'is_post_author',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_post_meta', '==', 1 )
		),
	)
) );


/**
 * Blog Title Icon
 */

CSF::createSection( 'docy_opt', array(
	'parent'     => 'blog_page',
	'title'      => esc_html__( 'Post Format Icon', 'docy' ),
	'id'         => 'blog_post_format_icon_opt',
	'icon'       => '',
	'subsection' => true,
	'fields'     => array(

		array(
			'title'      => esc_html__( 'Post Icon', 'docy' ),
			'subtitle'   => esc_html__( 'Post Icon show', 'docy' ),
			'id'         => 'is_post_format_icon',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => false,
		),

		array(
			'id'         => 'b_standard_icon',
			'type'       => 'icon',
			'options'    => docy_cs_elegant_icons(),
			'title'      => esc_html__( 'Post Standard', 'docy' ),
			'default'    => 'icon_chat_alt',
			'dependency' => array( 'is_post_format_icon', '==', '1' )
		),
		array(
			'id'         => 'b_video_icon',
			'type'       => 'icon',
			'title'      => esc_html__( 'Post Video', 'docy' ),
			'default'    => 'social_youtube',
			'dependency' => array( 'is_post_format_icon', '==', '1' )
		),

		array(
			'id'          => 'b_icon_size',
			'type'        => 'slider',
			'title'       => esc_html__( 'Icon Size', 'docy' ),
			'unit'        => 'px',
			'output'      => '.blog_classic_item .b_top_post_content .post_icon i',
			'output_mode' => 'font-size',
			'min'         => 10,
			'max'         => 100,
			'step'        => 1,
			'dependency'  => array( 'is_post_format_icon', '==', '1' )
		),

	)
) );


if( ! function_exists( 'my_custom_color_palette' ) ) {
    function my_custom_color_palette( $colors = '' ) {
        return array( 'red', 'green', 'blue', 'yellow', 'white', 'black', 'purple' );
    }
    //add_filter( 'csf_color_palette', 'my_custom_color_palette' );
}


/**
 * Post single
 */
CSF::createSection( 'docy_opt', array(
	'parent'     => 'blog_page',
	'title'      => esc_html__( 'Blog single', 'docy' ),
	'id'         => 'blog_single_opt',
	'icon'       => '',
	'subsection' => true,
	'fields'     => array(

        //=== Title-bar
        array(
            'title' => esc_html__( 'Title Bar', 'docy' ),
            'type'  => 'heading',
        ),

        array(
            'title'   => esc_html__( 'Banner Layout', 'docy' ),
            'id'      => 'banner_type',
            'type'    => 'select',
            'options' => array(
                'colorful' => esc_html__( 'Creative Colorful', 'docy' ),
                'classic' => esc_html__( 'Classic Title Bar', 'docy' ),
                'curved' => esc_html__( 'Curved Shape', 'docy' ),
            ),
            'default' => 'colorful',
        ),

        //Media Field id name shape1, shape2, shape3 etc
        array(
            'id'    => 'banner_shape_01',
            'type'  => 'media',
            'title' => esc_html__( 'Shape 1', 'docy' ),
            'dependency'  => array( 'banner_type', '==', 'colorful' ),
        ),

        array(
            'id'    => 'banner_shape_02',
            'type'  => 'media',
            'title' => esc_html__( 'Shape 2', 'docy' ),
            'dependency'  => array( 'banner_type', '==', 'colorful' ),
        ),

        array(
            'id'                     => 'blog_single_banner_bg_color',
            'type'                   => 'background',
            'title'                  => esc_html__( 'Background', 'docy' ),
            'background_gradient'    => true,
            'background_origin'      => true,
            'background_clip'        => true,
            'background_blend_mode'  => true,
            'output'                 =>'.doc_banner_area, .tip_banner_area',
            'default'                => false,
            'dependency'             => array( 'banner_type', '||', 'colorful', 'classic' ),
        ),

		array(
			'title'  => esc_html__( 'Title Color', 'docy' ),
			'id'     => 'blog_single_banner_title_color',
			'output' => array( '.single_breadcrumb .doc_banner_content .title' ),
			'type'   => 'color',
		),

		// Post Metas
		array(
			'title'      => esc_html__( 'Post meta', 'docy' ),
			'subtitle'   => esc_html__( 'Post meta includes Date, Reading Time and Categories.', 'docy' ),
			'id'         => 'is_single_post_meta',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
		),
		array(
			'title'      => esc_html__( 'Post Date', 'docy' ),
			'id'         => 'is_single_post_date',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_single_post_meta', '==', 1 )
		),
		array(
			'title'      => esc_html__( 'Post Reading Time', 'docy' ),
			'id'         => 'is_single_reading_time',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_single_post_meta', '==', 1 )
		),
		array(
			'title'      => esc_html__( 'Categories', 'docy' ),
			'id'         => 'is_single_cats',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1',
			'dependency' => array( 'is_single_post_meta', '==', 1 )
		), //End Title Bar


        //==== Post Contents
        array(
            'title' => esc_html__( 'Post Contents', 'docy' ),
            'type'  => 'heading',
        ),

		array(
			'title'      => esc_html__( 'Post Tags', 'docy' ),
			'subtitle'   => esc_html__( 'The Post Tags shows at the bottom of the post content.', 'docy' ),
			'id'         => 'is_single_post_tag',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
			'default'    => '1'
		),

		// Related Posts
		array(
			'title'      => esc_html__( 'Related posts ', 'docy' ),
			'id'         => 'is_related_posts',
			'type'       => 'switcher',
			'text_on'    => esc_html__( 'Show', 'docy' ),
			'text_off'   => esc_html__( 'Hide', 'docy' ),
			'text_width' => 80,
		),
		array(
			'title'      => esc_html__( 'Posts section title', 'docy' ),
			'id'         => 'related_posts_title',
			'type'       => 'text',
			'default'    => esc_html__( 'Related Post', 'docy' ),
			'dependency' => array( 'is_related_posts', '==', '1' )
		),
		array(
			'title'         => esc_html__( 'Related posts count', 'docy' ),
			'id'            => 'related_posts_count',
			'type'          => 'slider',
			'default'       => 3,
			'min'           => 3,
			'step'          => 1,
			'max'           => 50,
			'display_value' => 'label',
			'dependency'    => array( 'is_related_posts', '==', '1' )
		),
	)
) );
