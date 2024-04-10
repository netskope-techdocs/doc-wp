<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Accordion
 * @package DocyCore\Widgets
 */
class Accordion extends Widget_Base {

    public function get_name() {
        return 'docy_accordion';
    }

    public function get_title() {
        return esc_html__( 'Docy Accordion', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_keywords() {
        return [ 'toggle' ];
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    protected function register_controls() {

        /** ============ Title Section ============ **/
        $this->start_controls_section(
            'style_sec',
            [
                'label' => esc_html__( 'Accordion', 'docy-core' ),
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'toggle' => esc_html__( 'Toggle', 'docy-core'),
                    'accordion' => esc_html__( 'Accordion', 'docy-core'),
                ],
                'default' => 'toggle',
            ]
        );

        $this->add_control(
            'collapse_state', [
                'label' => esc_html__( 'Expanded', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'docy-core' ),
                'label_off' => esc_html__( 'No', 'docy-core' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title Text', 'docy-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__( 'Content Text', 'docy-core' ),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab
         */
        $this->start_controls_section(
            'title_style_sec', [
                'label' => esc_html__( 'Style Title', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'color_title', [
                'label' => esc_html__( 'Text Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_banner_text h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_color_title', [
                'label' => esc_html__( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_banner_text h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_title',
                'label' => esc_html__( 'Typography', 'docy-core' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .doc_banner_text h2',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Styling
         */
        $this->start_controls_section(
            'style_subtitle_sec', [
                'label' => esc_html__( 'Style Content', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'color_subtitle', [
                'label' => esc_html__( 'Text Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .doc_banner_text p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_color_subtitle', [
                'label' => esc_html__( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .doc_banner_text p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => esc_html__( 'Subtitle Typography', 'docy-core' ),
                'name' => 'typography_subtitle',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .doc_banner_text p',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        if ( $settings['type'] == 'toggle' ) {
            include('inc/accordion/_toggle.php');
        }

        if ( $settings['type'] == 'accordion' ) {
            include('inc/accordion/_accordion.php');
        }
    }
}