<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use WP_Query;
use WP_Post;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Forums
 * @package DocyCore\Widgets
 */
class Forums extends Widget_Base {

	public function get_name() {
		return 'docy_forums';
	}

	public function get_title() {
		return __( 'Forums', 'docy-core' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'docy-elements' ];
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
                'label' => esc_html__( 'Forums Style', 'docy-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'icon' => 'forums1',
                        'title' => esc_html__( '01 : Forums', 'docy-core'),
                    ],
                    '2' => [
                        'icon' => 'forums2',
                        'title' => esc_html__( '02 : Forums', 'docy-core'),
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->end_controls_section(); // End Style

		// --- Filter Options
		$this->start_controls_section(
			'filter_opt', [
				'label' => __( 'Filter Options', 'docy-core' ),
			]
		);

		$this->add_control(
			'ppp', [
				'label' => esc_html__( 'Show Forums', 'docy-core' ),
				'description' => esc_html__( 'Show the forums count at the initial view. Default is 5 forums in a row.', 'docy-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'default' => 5
			]
		);

		$this->add_control(
			'ppp2', [
				'label' => esc_html__( 'Hidden Forums', 'docy-core' ),
				'description' => esc_html__( 'Hidden forums will show on clicking on the More button.', 'docy-core' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => true,
				'default' => 10
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

        // --- Read More Options
        $this->start_controls_section(
            'button_opt', [
                'label' => __( 'Read More Options', 'docy-core' ),
            ]
        );

        $this->add_control(
            'more_txt', [
                'label' => esc_html__( 'Read More Text', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'More Communities'
            ]
        );

        $this->add_control(
            'less_txt', [
                'label' => esc_html__( 'Read Less Text', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Less Communities'
            ]
        );

        $this->end_controls_section();


        /**============== Background shape Image =====================**/
        $this->start_controls_section(
            'style_shapes', [
                'label' => __( 'Shape Images', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shape1', [
                'label' => esc_html__( 'Shape', 'docy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('inc/forums/images/shap_white.png', __FILE__)
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

        $forums = new WP_Query(array(
            'post_type' => 'forum',
            'posts_per_page' => !empty($settings['ppp']) ? $settings['ppp'] : 5,
            'order' => $settings['order'],
        ));

		// File Include
        include( "inc/forums/forums-{$settings['style']}.php" );
	}
}