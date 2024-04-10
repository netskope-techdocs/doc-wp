<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use WP_Query;
use WP_Post;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Forum_posts
 * @package Bew\Widgets
 */
class Forum_topics extends Widget_Base {

    public function get_name() {
        return 'docy_forum_topics';
    }

    public function get_title() {
        return __( 'Forum Topics', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_style_depends() {
        return [ 'bew-topics' ];
    }

    public function get_keywords() {
        return [ 'topics', 'replies' ];
    }

    public function get_categories() {
        return [ 'bew-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'style_sec',
            [
                'label' => esc_html__( 'Preset Skins', 'docy-core' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Skin', 'docy-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'icon' => 'topic1',
                        'title' =>  esc_html__( 'List', 'docy-core'),
                    ],
                    '2' => [
                        'icon' => 'topic2',
                        'title' =>  esc_html__( 'List with excerpt', 'docy-core'),
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->end_controls_section();

        // --- Filter Options ----------------------------------------
        $this->start_controls_section(
            'filter_opt', [
                'label' => __( 'Filter Options', 'docy-core' ),
            ]
        );

        $this->add_control(
            'ppp', [
                'label' => esc_html__( 'Show Topics', 'docy-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => 5
            ]
        );

        $this->add_control(
            'author_avatar_count', [
                'label' => esc_html__( 'Author Avatars', 'docy-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => 2,
                'condition' => [
                    'style' => ['2']
                ]
            ]
        );

        $this->add_control(
            'excerpt_length', [
                'label' => esc_html__( 'Excerpt Length', 'docy-core' ),
                'description' => esc_html__( 'Enter the excerpt length in words count.', 'docy-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => 12,
                'condition' => [
                    'style' => ['2']
                ]
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__( 'Order', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ],
                'default' => 'ASC'
            ]
        );

        $this->end_controls_section();


        // --- Filter Options ----------------------------------------
        $this->start_controls_section(
            'btm_content_sec', [
                'label' => __( 'Bottom Content', 'docy-core' ),
            ]
        );

        $this->add_control(
            'btm_content', [
                'label' => esc_html__( 'Bottom Text', 'docy-core' ),
                'type' => Controls_Manager::WYSIWYG,
            ]
        );

        $this->end_controls_section();

        /**
         * Style Items
         */
        $this->start_controls_section(
            'style_items', [
                'label' => __( 'Style Items', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'spacing-item',
            [
                'label' => __( 'Spacing', 'docy-core' ),
                'description' => __( 'Spacing between the topic items', 'docy-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .topic-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'padding-item',
            [
                'label' => __( 'Padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .topic-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**============== Background shape Image =====================**/
        $this->start_controls_section(
            'style_shapes', [
                'label' => __( 'Style Section', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shape1', [
                'label' => esc_html__( 'Shape 01', 'docy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('inc/forum-topics/images/community_bg_shap_one.png', __FILE__)
                ],
                'condition' => [
                    'style' => ['2']
                ]
            ]
        );

        $this->add_control(
            'shape2', [
                'label' => esc_html__( 'Shape 02', 'docy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('inc/forum-topics/images/community_bg_shap_two.png', __FILE__)
                ],
                'condition' => [
                    'style' => ['2']
                ]
            ]
        );

        $this->add_responsive_control(
            'padding_sec',
            [
                'label' => __( 'Section Padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .bew-topics' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $forum_posts = new WP_Query(array(
            'post_type' => 'topic',
            'posts_per_page' => !empty($settings['ppp']) ? $settings['ppp'] : -1,
            'order' => $settings['order'],
        ));

        include ("inc/forum-topics/forum-topics-{$settings['style']}.php");
    }
}