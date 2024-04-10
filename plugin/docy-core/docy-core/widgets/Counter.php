<?php
namespace DocyCore\Widgets;

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class Counter
 * @package DocyCore\Widgets
 */
class Counter extends Widget_Base {

    public function get_name() {
        return 'docly_counter';
    }

    public function get_title() {
        return __( 'Counter Fun Facts', 'rogan-core' );
    }

    public function get_icon() {
        return 'eicon-counter-circle';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    public function get_keywords() {
        return [ 'Count', 'Stats', 'fun facts' ];
    }

    public function get_script_depends() {
        return [ 'tweenmax', 'wavify', 'counterup', 'waypoints' ];
    }

    protected function register_controls()
    {
	    $this->start_controls_section(
		    'style_sec',
		    [
			    'label' => esc_html__( 'Hero', 'docy-core' ),
		    ]
	    );

	    $this->add_control(
		    'style',
		    [
			    'label' => esc_html__( 'Hero Style', 'docy-core' ),
			    'type' => Controls_Manager::SELECT,
			    'options' => [
				    '1' => esc_html__( 'Flat UI', 'docy-core'),
				    '2' => esc_html__( 'Gradient Multicolor', 'docy-core'),
			    ],
			    'default' => '1',
		    ]
	    );

	    $this->end_controls_section();

        //----------------------------- Counter Section --------------------------------------//
        $this->start_controls_section(
            'counter_sec',
            [
                'label' => esc_html__('Counter', 'rogan-core'),
            ]
        );

        $counter1 = new \Elementor\Repeater();

	    $counter1->add_control(
            'count_value', [
                'label' => esc_html__('Count Value', 'rogan-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '354',
            ]
        );

	    $counter1->add_control(
            'count_label', [
                'label' => esc_html__('Count Label', 'rogan-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Global Customer',
            ]
        );

        $this->add_control(
            'counter_section', [
                'label' => esc_html__('Counter', 'rogan-core'),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ count_value }}}',
                'fields' => $counter1->get_controls(),
                'condition' => [
	                'style' => ['1']
                ]
            ]
        );

	    $counter2 = new \Elementor\Repeater();

	    $counter2->add_control(
		    'count_value', [
			    'label' => esc_html__('Count Value', 'rogan-core'),
			    'type' => Controls_Manager::TEXT,
			    'label_block' => true,
			    'default' => '354',
		    ]
	    );

	    $counter2->add_control(
		    'count_label', [
			    'label' => esc_html__('Count Label', 'rogan-core'),
			    'type' => Controls_Manager::TEXT,
			    'label_block' => true,
			    'default' => 'Global Customer',
		    ]
	    );

	    $counter2->add_control(
		    'icon', [
			    'label' => esc_html__('Icon Image', 'rogan-core'),
			    'type' => Controls_Manager::MEDIA,
		    ]
	    );

	    $counter2->add_control(
		    'color_count_label', [
			    'label' => esc_html__('Count Label Color', 'rogan-core'),
			    'type' => Controls_Manager::COLOR,
			    'separator' => 'before',
			    'selectors' => [
				    '{{WRAPPER}} {{CURRENT_ITEM}} .counter' => 'color: {{VALUE}};',
			    ],
		    ]
	    );

	    $counter2->add_control(
		    'image_shadow_color', [
			    'label' => esc_html__('Icon Shadow Color', 'rogan-core'),
			    'type' => Controls_Manager::COLOR,
			    'separator' => 'before',
			    'selectors' => [
				    '{{WRAPPER}} {{CURRENT_ITEM}} .fanfact-icon img' => 'filter: drop-shadow(0px 20px 40px {{VALUE}});',
			    ],
		    ]
	    );

        $this->add_control(
            'counter2_section', [
                'label' => esc_html__('Counter', 'rogan-core'),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ count_value }}}',
                'fields' => $counter2->get_controls(),
	            'condition' => [
	            	'style' => ['2']
	            ]
            ]
        );

        $this->end_controls_section();


        /**
         * Style Tab
         * Theme Counter Style
         */
        /****************************** Theme Counter **************************/
        $this->start_controls_section(
            'theme_counter_sec',
            [
                'label' => esc_html__('Counter Style', 'rogan-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'sec_padding', [
                'label' => __( 'Section padding', 'docy-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .doc_fun_fact_area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .funfact-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                ],
            ]
        );

        $this->add_control(
            'sec_bg_color', [
                'label' => esc_html__('Background Color', 'rogan-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_fun_fact_area' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sec_bg_color2', [
                'label' => esc_html__('Background Color 02', 'rogan-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .funfact-area' => 'background-image: linear-gradient(45deg, {{sec_bg_color.VALUE}} 0%, {{VALUE}} 100%);',
                ],
            ]
        );

        $this->add_control(
            'color_count_value', [
                'label' => esc_html__('Count Text Color', 'rogan-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .doc_fact_item .counter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_count_value',
                'label' => esc_html__('Count Text Typography', 'rogan-core'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .doc_fact_item .counter',
            ]
        );

        $this->add_control(
            'color_count_label', [
                'label' => esc_html__('Count Label Color', 'rogan-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .doc_fact_item p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_count_label',
                'label' => esc_html__('Count Text Typography', 'rogan-core'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .doc_fact_item p',
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings();
        $counters = $settings['counter_section'];
	    include( "inc/counter/counter-{$settings['style']}.php" );
    }
}