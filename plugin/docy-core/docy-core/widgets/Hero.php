<?php
namespace DocyCore\Widgets;

use Elementor\Repeater;
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
 * Class Hero
 * @package DocyCore\Widgets
 */
class Hero extends Widget_Base {

    public function get_name() {
        return 'docy_hero';
    }

    public function get_title() {
        return esc_html__( 'Hero Search', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-device-desktop';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    public function get_style_depends() {
        return [ 'nice-select' ];
    }

    public function get_script_depends() {
        return [ 'nice-select' ];
    }

    protected function register_controls() {


        //-------------------------------- Select Style ------------------------------------- //
        $this->start_controls_section(
            'style_sec',
            [
                'label' => esc_html__( 'Preset Skins', 'docy-core' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Hero Style', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( 'Creative', 'docy-core'),
                    '2' => esc_html__( 'Classic', 'docy-core'),
                    '3' => esc_html__( 'Minimal', 'docy-core'),
                    '4' => esc_html__( 'Cool Theme', 'docy-core'),
                    '5' => esc_html__( 'Light Theme', 'docy-core'),
                    '6' => esc_html__( 'Community', 'docy-'),
                ],
                'default' => '1',
            ]
        );

        $this->end_controls_section();


        /** ============ Title Section ============ **/
        $this->start_controls_section(
            'content_sec',
            [
                'label' => esc_html__( 'Title', 'docy-core' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title Text', 'docy-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'How can we help you?',
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => __( 'Title Tag', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => docy_el_title_tags(),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__( 'Subtitle Text', 'docy-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();


        /** ============ Search Form ============ **/
        $this->start_controls_section(
            'search_form_sec',
            [
                'label' => esc_html__( 'Search Form', 'docy-core' ),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__( 'Placeholder', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Search for Topics....',
            ]
        );

        $this->add_control(
            'submit_btn_label',
            [
                'label' => esc_html__( 'Submit Button Label', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Search',
                'condition' => [
                    'style' => ['4', '5']
                ]
            ]
        );

        $this->add_control(
            'is_dropdown', [
                'label' => esc_html__( 'Post Types Dropdown', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'condition' => [
                    'style' => ['1']
                ]
            ]
        );

        $this->add_control(
            'is_keywords', [
                'label' => esc_html__( 'Keywords', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'keywords_label',
            [
                'label' => esc_html__( 'Keywords Label', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Popular:',
                'condition' => [
                    'is_keywords' => 'yes'
                ]
            ]
        );

        $keywords = new \Elementor\Repeater();

        $keywords->add_control(
            'title', [
                'label' => __( 'Title', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'keywords',
            [
                'label' => __( 'Repeater List', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $keywords->get_controls(),
                'default' => [
                    [
                        'title' => __( 'Keyword #1', 'docy-core' ),
                    ],
                    [
                        'title' => __( 'Keyword #2', 'docy-core' ),
                    ],
                ],
                'title_field' => '{{{ title }}}',
                'prevent_empty' => false,
                'condition' => [
                    'is_keywords' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Condition: Hero 5
         * Group: Featured Images
         */
        include ('inc/hero/controls/5_featured_images.php');

	    /**
	     * Peoples Images
         * Community
	     */
        $this->start_controls_section(
            'peoples_sec', [
                'label' => esc_html__( 'Peoples Images', 'docy-core' ),
                'condition' => [
	                'style' => ['6']
                ]
            ]
        );

	    $peoples = new Repeater();

	    $peoples->add_control(
		    'image', [
			    'label' => esc_html__( 'People Image', 'docy-core' ),
			    'type' => Controls_Manager::MEDIA,
		    ]
	    );

	    $peoples->add_responsive_control(
		    'people_left_position',
		    [
			    'label'         => __( 'Horizontal Position', 'docy-core' ),
			    'type'          => Controls_Manager::SLIDER,
			    'range'         => [
				    'px' 	=> [
					    'min' 	=> 0,
					    'max' 	=> 100,
					    'step'	=> 0.1,
				    ],
			    ],
			    'selectors'     => [
				    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}%;',
			    ],
		    ]
	    );

	    $peoples->add_responsive_control(
		    'people_top_position',
		    [
			    'label'         => __( 'Vertical Position', 'docy-core' ),
			    'type'          => Controls_Manager::SLIDER,
			    'range'         => [
				    'px' 	=> [
					    'min' 	=> 0,
					    'max' 	=> 100,
					    'step'	=> 0.1,
				    ],
			    ],
			    'selectors'     => [
				    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}%;',
			    ],
		    ]
	    );

	    $this->add_control(
		    'peoples', [
			    'label' => esc_html__('Peoples', 'rogan-core'),
			    'type' => Controls_Manager::REPEATER,
			    'title_field' => '{{{ name }}}',
			    'fields' => $peoples->get_controls(),
		    ]
	    );

        $this->end_controls_section();


        /** ============ Content Styling ============ **/
        $this->start_controls_section(
            'style_content_sec', [
                'label' => esc_html__( 'Style Content', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color_title', [
                'label' => esc_html__( 'Title Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_title',
                'label' => esc_html__( 'Title Typography', 'docy-core' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'color_subtitle', [
                'label' => esc_html__( 'Subtitle Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => esc_html__( 'Subtitle Typography', 'docy-core' ),
                'name' => 'typography_subtitle',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .subtitle',
            ]
        );

        $this->end_controls_section();


	    /**
	     * Style Background
	     * Style 04 (Cool)
	     */
        include ('inc/hero/controls/4_bg_obj.php');


        /**
         * Background Shapes
         * Style 01 (Creative)
         */
        include ('inc/hero/controls/1_bg_shapes.php');


        /**
         * Background Shapes
         * Style 02 (classic)
         */
        include ('inc/hero/controls/2_bg_obj_classic.php');

        /**
         * Style Keywords
         * Global
         */
        include ('inc/hero/controls/style_keywords.php');


        /**
         * Section Style
         */
        $this->start_controls_section(
            'style_sec_opt', [
                'label' => esc_html__( 'Section Style', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'sec_padding', [
                'label' => __( 'Section padding', 'docy-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .docy_search_hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                'default' => [
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                ],
            ]
        );

        $this->add_control(
            'sec_height',
            [
                'label' => __( 'Section Height', 'docy-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                ],
                'selectors' => ['{{WRAPPER}} .docy_search_hero' => 'height: {{SIZE}}{{UNIT}};'],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'sec_bg_colors',
                'label' => __( 'Background', 'docy-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => ' {{WRAPPER}} .docy_search_hero',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

        include( "inc/hero/hero-{$settings['style']}.php" );
    }
}