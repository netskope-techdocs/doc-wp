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
class Accordion_Article extends Widget_Base {

    public function get_name() {
        return 'accordion_article';
    }

    public function get_title() {
        return esc_html__( 'Accordion Articles', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_keywords() {
        return [ 'accordion', 'article' ];
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    protected function register_controls() {

        /** ============ Title Section ============ **/
        $this->start_controls_section(
            'style_sec',
            [
                'label' => esc_html__( 'Article Accordion', 'docy-core' ),
            ]
        );
        
        $this->add_control(
			'cat_name',
			[
				'label' => esc_html__( 'Select category', 'docy-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => docy_cat_ids(),
                'default' => '',
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


        $this->end_controls_section();



    }

    protected function render() {

        $settings = $this->get_settings();
        include('inc/accordion-article/accordion-article.php');

    }
}