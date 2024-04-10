<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use WP_Query;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Faq
 * @package DocyCore\Widgets
 */
class Faq extends Widget_Base {
    public function get_name() {
        return 'docy_faq';
    }

    public function get_title() {
        return esc_html__( 'FAQ Tabs', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    public function get_keywords() {
        return [ 'frequently asked questions', 'docy', 'tabs', 'faqs' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'style_sec',
            [
                'label' => esc_html__( 'Preset Skins', 'docy-core' ),
            ]
        );

        $this->add_control(
            'style', [
                'label' => esc_html__( 'Skin', 'docy-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __( 'Top - Tabbed', 'coro-core' ),
                        'icon' => 'faq1',
                    ],
                    '2' => [
                        'title' => __( 'Left Side - Box Tabbed', 'coro-core' ),
                        'icon' => 'faq2',
                    ],
                    '3' => [
                        'title' => __( 'Left Side - Tag Style Tab', 'coro-core' ),
                        'icon' => 'faq3',
                    ],
                ],
                'toggle' => false,
                'default' => '1',
            ]
        );

        $this->add_control(
            'nav_title',
            [
                'label' => esc_html__( 'Navigation Title', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Quick Navigation',
                'condition' => [
                    'style' => ['2', '3']
                ]
            ]
        );

        $this->end_controls_section();

        // ---------------------------------- Filter Options ------------------------
        $this->start_controls_section(
            'filter', [
                'label' => esc_html__( 'Filter Options', 'docy-core' ),
            ]
        );

        $this->add_control(
            'cat_number', [
                'label' => esc_html__( 'Category Number', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => '6'
            ]
        );

        $this->add_control(
			'exclude_cat', [
				'label'    => esc_html__( 'Exclude Docs', 'docy-core' ),
				'type'     => Controls_Manager::SELECT2,
				'options'  => docy_get_faq_categories(),
				'multiple' => true
			]
		);

        $this->add_control(
            'order_cat', [
                'label' => esc_html__( 'Category Order', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'orderby_cat', [
                'label' => esc_html__( 'Category Order by', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'count' => 'Count',
                    'none' => 'None',
                ],
                'default' => 'name'
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

    }

    protected function render() {
        $settings           = $this->get_settings();

        $cats = get_terms( array (
            'taxonomy'      => 'faq_cat',
            'hide_empty'    => true,
            'orderby'       => $settings['orderby_cat'] ?? 'name',
            'order'         => $settings['order_cat'] ?? 'ASC',
            'number'        => $settings['cat_number'] ?? 6,
            'exclude'       => $settings['exclude_cat'] ?? '',
        ));

        include( "inc/faqs/faq-{$settings['style']}.php" );
    }

}