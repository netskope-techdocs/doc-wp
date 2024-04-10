<?php
namespace DocyCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Hotspots Widget
 */
class Image_HotSpots extends Widget_Base {

    /**
	 * Retrieve image hotspots widget name.
	 */
    public function get_name() {
        return 'docy-image-hotspots';
    }

    /**
	 * Retrieve image hotspots widget title.
	 */
    public function get_title() {
        return __( 'Docy Image Hotspots', 'docy-core' );
    }

    /**
	 * Retrieve the list of categories the image hotspots widget belongs to.
	 */
    public function get_categories() {
        return [ 'docy-elements' ];
    }

    /**
	 * Retrieve image hotspots widget icon.
	 */
    public function get_icon() {
        return 'eicon-image-hotspot';
    }

    public function get_style_depends() {
        return [ 'tooltipster' ];
    }

    public function get_script_depends() {
        return [ 'tooltipster' ];
    }

    public function get_keywords() {
        return [
            'image',
            'image hotspots',
            'image hot spots',
            'preview window',
            'tooltip',
            'tooltip',
            'pointers',
            'pointers',
        ];
    }

    /**
	 * Register image hotspots widget controls.
	 */
    protected function register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Content Tab: Image
         */
        $this->start_controls_section(
            'section_image',
            [
                'label'                 => __( 'Image', 'docy-core' ),
            ]
        );

		$this->add_control(
			'image',
			[
                'label' => __( 'Choose Image', 'elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
			]
		);

        $this->add_control(
            'hotspots_in_lightbox',
            [
                'label'           => __( 'Open Hotspots in Lightbox', 'docy-core' ),
                'type'            => Controls_Manager::SWITCHER,
                'default'         => 'yes',
                'label_on'        => __( 'Yes', 'docy-core' ),
                'label_off'       => __( 'No', 'docy-core' ),
                'return_value'    => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Hotspots
         */
        $this->start_controls_section(
            'section_hotspots',
            [
                'label'                 => __( 'Hotspots', 'docy-core' ),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs( 'hot_spots_tabs' );

        $repeater->start_controls_tab( 'tab_content', [ 'label' => __( 'Content', 'docy-core' ) ] );

            $repeater->add_control(
                'content',
                [
                    'label'           => __( 'Text', 'docy-core' ),
                    'type'            => Controls_Manager::WYSIWYG,
                    'default'         => 'Lorem ipsum some dummy text is here.',
                ]
            );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_position', [ 'label' => __( 'Position', 'docy-core' ) ] );

            $repeater->add_control(
                'left_position',
                [
                    'label'         => __( 'Left Position', 'docy-core' ),
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

            $repeater->add_control(
                'top_position',
                [
                    'label'         => __( 'Top Position', 'docy-core' ),
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

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'hotspots',
            [
                'label'                 => '',
                'type'                  => Controls_Manager::REPEATER,
                'fields'                => $repeater->get_controls(),
                'title_field'           => '{{{ content }}}',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Hotspot
         */
        $this->start_controls_section(
            'section_hotspots_style',
            [
                'label'                 => __( 'Hotspot', 'docy-core' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'hotspot_icon_size',
            [
                'label'                 => __( 'Size', 'docy-core' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '14' ],
                'range'                 => [
                    'px' => [
                        'min'   => 6,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-hot-spot-wrap .hotspot-svg-icon' => 'width:{{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'icon_color_normal',
            [
                'label'                 => __( 'Color', 'docy-core' ),
                'type'                  => Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap, {{WRAPPER}} .eael-hot-spot-inner, {{WRAPPER}} .eael-hot-spot-inner:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'docy-core' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap, {{WRAPPER}} .eael-hot-spot-inner, {{WRAPPER}} .eael-hot-spot-inner:before, {{WRAPPER}} .eael-hotspot-icon-wrap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_border_normal',
				'label'                 => __( 'Border', 'docy-core' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .eael-hot-spot-wrap'
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => __( 'Border Radius', 'docy-core' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .eael-hot-spot-wrap, {{WRAPPER}} .eael-hot-spot-inner, {{WRAPPER}} .eael-hot-spot-inner:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'                 => __( 'Padding', 'docy-core' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .eael-hot-spot-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'icon_box_shadow',
				'selector'              => '{{WRAPPER}} .eael-hot-spot-wrap',
				'separator'             => 'before',
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Tooltip
         */
        $this->start_controls_section(
            'section_tooltips_style',
            [
                'label'                 => __( 'Tooltip', 'docy-core' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_bg_color',
            [
                'label'                 => __( 'Background Color', 'docy-core' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
            ]
        );

        $this->add_control(
            'tooltip_color',
            [
                'label'                 => __( 'Text Color', 'docy-core' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
            ]
        );

        $this->add_control(
            'tooltip_width',
            [
                'label'         => __( 'Width', 'docy-core' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' 	=> [
                        'min' 	=> 50,
                        'max' 	=> 400,
                        'step'	=> 1,
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		wp_deregister_script('TweenMax');

        if ( $settings['hotspots_in_lightbox'] != 'yes' ) :
            ?>
            <div class="pointing_img_container pointing_img_two">
                <?php echo wp_get_attachment_image( $settings['image']['id'], 'full', array('class' => 'img-fluid') ); ?>
                <?php
                foreach ( $settings['hotspots'] as $ii => $hotspot ) :
                    switch ( $ii ) {
                        case '1':
                            $point_ii = 'one';
                            break;
                        case '2':
                            $point_ii = 'two';
                            break;
                        case '3':
                            $point_ii = 'three';
                            break;
                        case '4':
                            $point_ii = 'four';
                            break;
                        case '5':
                            $point_ii = 'five';
                            break;
                        default:
                            $point_ii = '';
                    }
                    ?>
                    <div class="img_pointing <?php echo $point_ii.' elementor-repeater-item-'.$hotspot['_id'] ?> tooltips" data-tooltip-content="#tooltip-<?php echo $hotspot['_id'] ?>">
                        <div class="dot"></div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
            <?php
        endif;

        if ( $settings['hotspots_in_lightbox'] == 'yes' ) :
            if ( !empty($settings['image']['id']) ) :
                ?>
                <div class="pointing_img">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo esc_attr($this->get_id()); ?>">
                        <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                    </a>
                </div>
                <?php
            endif;
            ?>
            <div class="modal fade img_modal" id="exampleModal-<?php echo esc_attr($this->get_id()); ?>" tabindex="-2" role="dialog" aria-hidden="false">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class=" icon_close"></i>
                </button>
                <div class="modal-dialog pointing_img_container" role="document">
                    <div class="modal-content">
                        <?php
                        if ( !empty($settings['image']['id']) ) {
                            echo wp_get_attachment_image( $settings['image']['id'], 'full' );
                        }
                        if ( !empty($settings['hotspots']) ) {
                        foreach ( $settings['hotspots'] as $i => $hotspot ) {
                            switch ( $i ) {
                                case '1':
                                    $point_i = 'one';
                                    break;
                                case '2':
                                    $point_i = 'two';
                                    break;
                                case '3':
                                    $point_i = 'three';
                                    break;
                                case '4':
                                    $point_i = 'four';
                                    break;
                                case '5':
                                    $point_i = 'five';
                                    break;
                                default:
                                    $point_i = '';
                            }
                            ?>
                            <div class="img_pointing tooltips <?php echo $point_i . ' elementor-repeater-item-'.$hotspot['_id'] ?>" data-tooltip-content="#tooltip-<?php echo $hotspot['_id'] ?>">
                                <div class="dot"></div>
                            </div>
                            <?php
                        }}
                        ?>
                    </div>
                </div>
            </div>
            <?php
        endif;

        // Spot Tooltips
        if ( !empty($settings['hotspots']) ) {
            foreach ( $settings['hotspots'] as $hotspot ) {
                ?>
                <div class="tooltip_templates d-none">
                    <div id="tooltip-<?php echo $hotspot['_id']; ?>">
                        <div class="img_pointing_content">
                            <?php echo $this->parse_text_editor(wpautop($hotspot['content'])) ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <script>
            (function($){
                $(document).ready(function(){
                    /*--------------- tooltip js--------*/
                    function tooltip() {
                        if ($('.tooltips').length) {
                            $('.tooltips').tooltipster({
                            interactive: true,
                            arrow: true,
                            animation: 'grow',
                            delay: 200,
                            });
                        }
                    }
                    tooltip();
                    $('.tooltips_one').data('tooltip-custom-class', 'tooltip_blue').tooltip();
                    $('.tooltips_two').data('tooltip-custom-class', 'tooltip_danger').tooltip();
                });
            })(jQuery);
        </script>
        <?php
    }
}