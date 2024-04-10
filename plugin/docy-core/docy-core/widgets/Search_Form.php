<?php
namespace DocyCore\Widgets;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use WP_Query;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Search_Form
 * @package DocyCore\Widgets
 */
class Search_Form extends Widget_Base {

    public function get_name() {
        return 'docy_search_form';
    }

    public function get_title() {
        return esc_html__( 'Docy Search Form', 'docy-core' );
    }

    public function get_icon() {
        return 'dashicons-search';
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

        /** ============ Search Form ============ **/
        $this->start_controls_section(
            'search_form_sec',
            [
                'label' => esc_html__( 'Form', 'docy-core' ),
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
            'btn-divider',
            [
                'label' => esc_html__( 'Button', 'docy-core' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

	    $this->add_control(
		    'submit_btn_icon',
		    [
			    'label' => esc_html__( 'Submit Button Icon', 'docy-core' ),
			    'type' => \Elementor\Controls_Manager::ICONS,
			    'default' => [
				    'value' => 'fas fa-search',
				    'library' => 'solid',
			    ],
		    ]
	    );
        
        $this->add_control(
			'submit_btn_align',
			[
				'label' => esc_html__( 'Alignment', 'docy-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'docy-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'docy-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'right'
			]
		);


        $this->end_controls_section();


        $this->start_controls_section(
            'keywords_sec',
            [
                'label' => esc_html__( 'Keywords', 'docy-core' ),
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

	    $this->add_responsive_control(
		    'keywords_align',
		    [
			    'label' => __( 'Alignment', 'docy-core' ),
			    'type' => Controls_Manager::CHOOSE,
			    'options' => [
				    'start' => [
					    'title' => __( 'Left', 'docy-core' ),
					    'icon' => 'eicon-h-align-left',
				    ],
				    'center' => [
					    'title' => __( 'Center', 'docy-core' ),
					    'icon' => 'eicon-h-align-center',
				    ],
				    'end' => [
					    'title' => __( 'Right', 'docy-core' ),
					    'icon' => 'eicon-h-align-right',
				    ],
			    ],
			    'prefix_class' => 'elementor%s-align-',
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
         * Style Keywords
         * Global
         */
        include ('inc/search-form/controls/style.php');
    }

    protected function render() {
        $settings = $this->get_settings();
        $title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';
        include( "inc/search-form/search-form.php" );
    }
}