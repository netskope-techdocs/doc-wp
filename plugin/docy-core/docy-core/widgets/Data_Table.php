<?php

namespace DocyCore\Widgets;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Plugin;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Repeater;
use Elementor\Icons_Manager;

use \Essential_Addons_Elementor\Classes\Helper;

class Data_Table extends Widget_Base {


	public $unique_id = null;
	public function get_name()
	{
		return 'docly-data-table';
	}

	public function get_title()
	{
		return esc_html__( 'Docy Data Table', 'docy-core');
	}

	public function get_icon()
	{
		return 'eicon-table';
	}

	public function get_categories()
	{
		return ['docy-elements'];
	}

	public function get_keywords()
	{
		return [
			'table',
			'data table',
			'comparison table',
			'grid'
		];
	}

	protected function register_controls()
	{
		/**
		 * -------------------------------------------
		 * Data Table Style
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'section_data_table_style_settings',
			[
				'label' => esc_html__( 'General', 'docy-core'),
			]
		);

		$this->add_control(
			'table_style',
			[
				'label' => __( 'Table Style', 'docy-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'table_shortcode' => esc_html__( 'Default', 'docy-core' ),
					'basic_table_info' => esc_html__( 'Basic', 'docy-core' ),
					'table-dark' => esc_html__( 'Dark', 'docy-core' ),
				],
				'default' => 'table_shortcode',
			]
		);

		$this->end_controls_section();


		/**
		 * Data Table Header
		 */
		$this->start_controls_section(
			'section_data_table_header',
			[
				'label' => esc_html__('Header', 'docy-core')
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'data_table_header_col',
			[
				'label' => esc_html__('Column Name', 'docy-core'),
				'default' => esc_html__('Table Header', 'docy-core'),
				'type' => Controls_Manager::TEXT,
				'dynamic'   => ['active' => true],
				'label_block' => false,
			]
		);

		$repeater->add_control(
			'data_table_header_col_span',
			[
				'label' => esc_html__('Column Span', 'docy-core'),
				'default' => '',
				'type' => Controls_Manager::TEXT,
				'dynamic'   => ['active' => true],
				'label_block' => false,
			]
		);

		$repeater->add_control(
			'data_table_header_col_icon_enabled',
			[
				'label' => esc_html__('Enable Header Icon', 'docy-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('yes', 'docy-core'),
				'label_off' => __('no', 'docy-core'),
				'default' => 'false',
				'return_value' => 'true',
			]
		);

		$repeater->add_control(
			'data_table_header_icon_type',
			[
				'label'    => esc_html__('Header Icon Type', 'docy-core'),
				'type'    => Controls_Manager::CHOOSE,
				'options'               => [
					'none'        => [
						'title'   => esc_html__('None', 'docy-core'),
						'icon'    => 'fa fa-ban',
					],
					'icon'        => [
						'title'   => esc_html__('Icon', 'docy-core'),
						'icon'    => 'fa fa-star',
					],
					'image'       => [
						'title'   => esc_html__('Image', 'docy-core'),
						'icon'    => 'eicon-image-bold',
					],
				],
				'default'               => 'icon',
				'condition' => [
					'data_table_header_col_icon_enabled' => 'true'
				]
			]
		);

		// Comment on this control
		$repeater->add_control(
			'data_table_header_col_icon_new',
			[
				'label' => esc_html__('Icon', 'docy-core'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'data_table_header_col_icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'data_table_header_col_icon_enabled' => 'true',
					'data_table_header_icon_type'	=> 'icon'
				]
			]
		);

		$repeater->add_control(
			'data_table_header_col_img',
			[
				'label' => esc_html__( 'Image', 'docy-core'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'data_table_header_icon_type'	=> 'image'
				]
			]
		);

		$repeater->add_control(
			'data_table_header_col_img_size',
			[
				'label' => esc_html__( 'Image Size(px)', 'docy-core'),
				'default' => '25',
				'type' => Controls_Manager::NUMBER,
				'label_block' => false,
				'condition' => [
					'data_table_header_icon_type'	=> 'image'
				]
			]
		);

		$repeater->add_control(
			'data_table_header_css_class',
			[
				'label'			=> esc_html__( 'CSS Class', 'docy-core'),
				'type'			=> Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' 	=> false,
			]
		);

		$repeater->add_control(
			'data_table_header_css_id',
			[
				'label'			=> esc_html__( 'CSS ID', 'docy-core'),
				'type'			=> Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block'	=> false,
			]
		);

		$this->add_control(
			'data_table_header_cols_data',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'data_table_header_col' => 'Table Header' ],
					[ 'data_table_header_col' => 'Table Header' ],
					[ 'data_table_header_col' => 'Table Header' ],
					[ 'data_table_header_col' => 'Table Header' ],
				],
				'fields'      =>  $repeater->get_controls() ,
				'title_field' => '{{data_table_header_col}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Data Table Content
		 */
		$this->start_controls_section(
			'section_data_table_cotnent',
			[
				'label' => esc_html__( 'Content', 'docy-core')
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'data_table_content_row_type',
			[
				'label' => esc_html__( 'Row Type', 'docy-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'row',
				'label_block' => false,
				'options' => [
					'row' => esc_html__( 'Row', 'docy-core'),
					'col' => esc_html__( 'Column', 'docy-core'),
				]
			]
		);

		$repeater->add_control(
			'data_table_content_row_colspan',
			[
				'label'			=> esc_html__( 'Col Span', 'docy-core'),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> esc_html__( 'Default: 1 (optional).'),
				'default' 		=> 1,
				'min'     		=> 1,
				'label_block'	=> true,
				'condition' 	=> [
					'data_table_content_row_type' => 'col'
				]
			]
		);

		$repeater->add_control(
			'data_table_content_type',
			[
				'label'		=> esc_html__( 'Content Type', 'docy-core'),
				'type'	=> Controls_Manager::CHOOSE,
				'options'               => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'docy-core'),
						'icon' => 'fa fa-info',
					],
					'textarea'        => [
						'title'   => esc_html__( 'Textarea', 'docy-core'),
						'icon'    => 'fa fa-text-width',
					],
					'editor'       => [
						'title'   => esc_html__( 'Editor', 'docy-core'),
						'icon'    => 'fa fa-pencil',
					]
				],
				'default'	=> 'textarea',
				'condition' => [
					'data_table_content_row_type' => 'col'
				]
			]
		);

		$repeater->add_control(
			'data_table_content_row_rowspan',
			[
				'label'			=> esc_html__( 'Row Span', 'docy-core'),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> esc_html__( 'Default: 1 (optional).'),
				'default' 		=> 1,
				'min'     		=> 1,
				'label_block'	=> true,
				'condition' 	=> [
					'data_table_content_row_type' => 'col'
				]
			]
		);


		$repeater->add_control(
			'data_table_icon_content_new',
			[
				'label' => esc_html__( 'Icon', 'docy-core'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'data_table_icon_content',
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition' => [
					'data_table_content_type' => [ 'icon' ]
				]
			]
		);

		$repeater->add_control(
			'data_table_content_row_title',
			[
				'label' => esc_html__( 'Cell Text', 'docy-core'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic'   => ['active' => true],
				'label_block' => true,
				'default' => esc_html__( 'Content', 'docy-core'),
				'condition' => [
					'data_table_content_row_type' => 'col',
					'data_table_content_type' => 'textarea'
				]
			]
		);

		$repeater->add_control(
			'data_table_content_row_content',
			[
				'label' => esc_html__( 'Cell Text', 'docy-core'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => esc_html__( 'Content', 'docy-core'),
				'condition' => [
					'data_table_content_row_type' => 'col',
					'data_table_content_type' => 'editor'
				]
			]
		);

		$repeater->add_control(
			'data_table_content_row_title_link',
			[
				'label' => esc_html__( 'Link', 'docy-core'),
				'type' => Controls_Manager::URL,
				'dynamic'   => ['active' => true],
				'label_block' => true,
				'default' => [
					'url' => '',
					'is_external' => '',
				],
				'show_external' => true,
				'separator' => 'before',
				'condition' => [
					'data_table_content_row_type' => 'col',
					'data_table_content_type' => 'textarea'
				],
			]
		);

		$repeater->add_control(
			'data_table_content_row_css_class',
			[
				'label'			=> esc_html__( 'CSS Class', 'docy-core'),
				'type'			=> Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block'	=> false,
				'condition' 	=> [
					'data_table_content_row_type' => 'col'
				]
			]
		);

		$repeater->add_control(
			'data_table_content_row_css_id',
			[
				'label'			=> esc_html__( 'CSS ID', 'docy-core'),
				'type'			=> Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block'	=> false,
				'condition' 	=> [
					'data_table_content_row_type' => 'col'
				]
			]
		);

		$this->add_control(
			'data_table_content_rows',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'data_table_content_row_type' => 'row' ],
					[ 'data_table_content_row_type' => 'col' ],
					[ 'data_table_content_row_type' => 'col' ],
					[ 'data_table_content_row_type' => 'col' ],
					[ 'data_table_content_row_type' => 'col' ],
				],
				'fields' =>  $repeater->get_controls() ,
				'title_field' => '{{data_table_content_row_type}}::{{data_table_content_row_title || data_table_content_row_content}}',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Data Table Header Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'section_data_table_title_style_settings',
			[
				'label' => esc_html__( 'Header Style', 'docy-core'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);


		$this->add_control(
			'section_data_table_header_radius',
			[
				'label' => esc_html__( 'Header Border Radius', 'docy-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} thead tr th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
					'{{WRAPPER}} thead tr th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;',
				],
			]
		);

		$this->add_responsive_control(
			'data_table_each_header_padding',
			[
				'label' => esc_html__( 'Padding', 'docy-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .table-header th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->start_controls_tabs('data_table_header_title_clrbg');

		$this->start_controls_tab( 'data_table_header_title_normal', [ 'label' => esc_html__( 'Normal', 'docy-core') ] );

		$this->add_control(
			'data_table_header_title_color',
			[
				'label' => esc_html__( 'Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} thead tr th' => 'color: {{VALUE}};',
					'{{WRAPPER}} tbody > tr td.th' => 'color: {{VALUE}};',
					'{{WRAPPER}} tbody > tr:nth-child(2n) td.th' => 'color: {{VALUE}};',
					'{{WRAPPER}} tbody > tr:nth-child(2n+1) td.th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_header_title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} thead tr th' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} thead tr .th' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} tbody > tr td.th' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} tbody > tr:nth-child(2n) td.th' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} tbody > tr:nth-child(2n+1) td.th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'data_table_header_border',
				'label' => esc_html__( 'Border', 'docy-core'),
				'selector' => '{{WRAPPER}} thead tr th'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'data_table_header_title_hover', [ 'label' => esc_html__( 'Hover', 'docy-core') ] );

		$this->add_control(
			'data_table_header_title_hover_color',
			[
				'label' => esc_html__( 'Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} thead tr th:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_header_title_hover_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} thead tr th:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'data_table_header_hover_border',
				'label' => esc_html__( 'Border', 'docy-core'),
				'selector' => '{{WRAPPER}} thead tr th:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'data_table_header_title_typography',
				'selector' => '{{WRAPPER}} thead > tr th .data-table-header-text',
			]
		);

		$this->add_responsive_control(
			'header_icon_size',
			[
				'label'      => __('Icon Size', 'docy-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 70,
					],
				],
				'default'    => [
					'size' => 20,
				],
				'selectors'  => [
					'{{WRAPPER}} thead tr th i'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} thead tr th .data-table-header-svg-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_icon_position_from_top',
			[
				'label'      => __('Icon Position', 'docy-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 70,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} thead tr th .data-header-icon' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_icon_space',
			[
				'label'      => __('Icon Space', 'docy-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 70,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} thead tr th i, {{WRAPPER}} thead tr th img' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Data Table Content Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'section_data_table_content_style_settings',
			[
				'label' => esc_html__( 'Content Style', 'docy-core'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs('data_table_content_row_cell_styles');

		$this->start_controls_tab('data_table_odd_cell_style', ['label' => esc_html__( 'Normal', 'docy-core')]);

		$this->add_control(
			'data_table_content_odd_style_heading',
			[
				'label' => esc_html__( 'ODD Cell', 'docy-core'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'data_table_content_color_odd',
			[
				'label' => esc_html__( 'Color ( Odd Row )', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n) td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_content_bg_odd',
			[
				'label' => esc_html__( 'Background ( Odd Row )', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n) td' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_content_even_style_heading',
			[
				'label' => esc_html__( 'Even Cell', 'docy-core'),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'data_table_content_even_color',
			[
				'label' => esc_html__( 'Color ( Even Row )', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d7882',
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_content_bg_even_color',
			[
				'label' => esc_html__( 'Background Color (Even Row)', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n+1) td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'data_table_cell_border',
				'label' => esc_html__( 'Border', 'docy-core'),
				'selector' => '{{WRAPPER}} tbody tr td',
				'separator'	=> 'before'
			]
		);

		$this->add_responsive_control(
			'data_table_each_cell_padding',
			[
				'label' => esc_html__( 'Padding', 'docy-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('data_table_odd_cell_hover_style', ['label' => esc_html__( 'Hover', 'docy-core')]);

		$this->add_control(
			'data_table_content_hover_color_odd',
			[
				'label' => esc_html__( 'Color ( Odd Row )', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n) td:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_content_hover_bg_odd',
			[
				'label' => esc_html__( 'Background ( Odd Row )', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n) td:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_content_even_hover_style_heading',
			[
				'label' => esc_html__( 'Even Cell', 'docy-core'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'data_table_content_hover_color_even',
			[
				'label' => esc_html__( 'Color ( Even Row )', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d7882',
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n+1) td:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'data_table_content_bg_even_hover_color',
			[
				'label' => esc_html__( 'Background Color (Even Row)', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} tbody > tr:nth-child(2n+1) td:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'data_table_content_typography',
				'selector' => '{{WRAPPER}} tbody tr td'
			]
		);

		$this->add_control(
			'data_table_content_link_typo',
			[
				'label' => esc_html__( 'Link Color', 'docy-core'),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		/* Table Content Link */
		$this->start_controls_tabs( 'data_table_link_tabs' );

		// Normal State Tab
		$this->start_controls_tab( 'data_table_link_normal', [ 'label' => esc_html__( 'Normal', 'docy-core') ] );

		$this->add_control(
			'data_table_link_normal_text_color',
			[
				'label' => esc_html__( 'Text Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#c15959',
				'selectors' => [
					'{{WRAPPER}} table td a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab( 'data_table_link_hover', [ 'label' => esc_html__( 'Hover', 'docy-core') ] );

		$this->add_control(
			'data_table_link_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d7882',
				'selectors' => [
					'{{WRAPPER}} table td a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		/* Table Content Icon  Style*/

		$this->add_control(
			'data_table_content_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'docy-core'),
				'type' => Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_responsive_control(
			'data_table_content_icon_size',
			[
				'label'      => __('Icon Size', 'docy-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 70,
					],
				],
				'default'    => [
					'size' => 20,
				],
				'selectors'  => [
					'{{WRAPPER}} tbody .td-content-wrapper .eael-datatable-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} tbody .td-content-wrapper .eael-datatable-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'separator'	=> 'before'
			]
		);

		$this->start_controls_tabs( 'data_table_icon_tabs' );

		// Normal State Tab
		$this->start_controls_tab( 'data_table_icon_normal', [ 'label' => esc_html__( 'Normal', 'docy-core') ] );

		$this->add_control(
			'data_table_icon_normal_color',
			[
				'label' => esc_html__( 'Icon Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#c15959',
				'selectors' => [
					'{{WRAPPER}} tbody .td-content-wrapper .eael-datatable-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} tbody .td-content-wrapper .eael-datatable-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab( 'data_table_icon_hover', [ 'label' => esc_html__( 'Hover', 'docy-core') ] );

		$this->add_control(
			'data_table_link_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'docy-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d7882',
				'selectors' => [
					'{{WRAPPER}} tbody .td-content-wrapper:hover .eael-datatable-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} tbody .td-content-wrapper:hover .eael-datatable-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


	}


	protected function render( ) {

		$settings = $this->get_settings_for_display();

		$table_tr = [];
		$table_td = [];



		// Storing Data table content values
		foreach( $settings['data_table_content_rows'] as $content_row ) {
			$row_id = uniqid();
			if( $content_row['data_table_content_row_type'] == 'row' ) {
				$table_tr[] = [
					'id' => $row_id,
					'type' => $content_row['data_table_content_row_type'],
				];

			}
			if( $content_row['data_table_content_row_type'] == 'col' ) {

				$icon_migrated = isset($settings['__fa4_migrated']['data_table_icon_content_new']);
				$icon_is_new = empty($settings['data_table_icon_content']);

				$target = !empty($content_row['data_table_content_row_title_link']['is_external']) ? 'target="_blank"' : '';
				$nofollow = !empty($content_row['data_table_content_row_title_link']['nofollow']) ? 'rel="nofollow"' : '';

				$table_tr_keys = array_keys( $table_tr );
				$last_key = end( $table_tr_keys );

				$tbody_content = ($content_row['data_table_content_type'] == 'editor') ? $content_row['data_table_content_row_content'] :$content_row['data_table_content_row_title'];

				$table_td[] = [
					'row_id'		=> $table_tr[$last_key]['id'],
					'type'			=> $content_row['data_table_content_row_type'],
					'content_type'	=> $content_row['data_table_content_type'],
					'title'			=> $tbody_content,
					'link_url'		=> !empty($content_row['data_table_content_row_title_link']['url'])?$content_row['data_table_content_row_title_link']['url']:'',
					'icon_content_new'	=> !empty($content_row['data_table_icon_content_new']) ? $content_row['data_table_icon_content_new']:'',
					'icon_content'	=> !empty($content_row['data_table_icon_content']) ? $content_row['data_table_icon_content']:'',
					'icon_migrated'	=> $icon_migrated,
					'icon_is_new'	=> $icon_is_new,
					'link_target'	=> $target,
					'nofollow'		=> $nofollow,
					'colspan'		=> $content_row['data_table_content_row_colspan'],
					'rowspan'		=> $content_row['data_table_content_row_rowspan'],
					'tr_class'		=> $content_row['data_table_content_row_css_class'],
					'tr_id'			=> $content_row['data_table_content_row_css_id']
				];
			}
		}
		$table_th_count = count($settings['data_table_header_cols_data']);
		$this->add_render_attribute('data_table_wrap', [
			'class'                  => 'table_shortcode-wrap',
			'data-table_id'          => esc_attr($this->get_id())
		]);
		if(isset($settings['section_data_table_enabled']) && $settings['section_data_table_enabled']){
			$this->add_render_attribute('data_table_wrap', 'data-table_enabled', 'true');
		}

		$this->add_render_attribute('data_table', [
			'class'	=> [ 'table doc-data-table', $settings['table_style'] ],
			'id'	=> 'table_shortcode-'.esc_attr($this->get_id())
		]);

		$this->add_render_attribute( 'td_content', [
			'class'	=> 'td-content'
		]);

		?>
        <div <?php echo $this->get_render_attribute_string('data_table_wrap'); ?>>
            <table <?php echo $this->get_render_attribute_string('data_table'); ?>>
                <thead>
                <tr class="table-header">
					<?php $i = 0; foreach( $settings['data_table_header_cols_data'] as $header_title ) :
						$this->add_render_attribute('th_class'.$i, [
							'class'		=> [ $header_title['data_table_header_css_class'] ],
							'id'		=> $header_title['data_table_header_css_id'],
							'colspan'	=> $header_title['data_table_header_col_span']
						]);

						if(apply_filters('eael/pro_enabled', false)) {
							$this->add_render_attribute('th_class'.$i, 'class', 'sorting' );
						}
						?>
                        <th <?php echo $this->get_render_attribute_string('th_class'.$i); ?>>
							<?php if( $header_title['data_table_header_col_icon_enabled'] == 'true' && $header_title['data_table_header_icon_type'] == 'icon' ) : ?>
								<?php if (empty($header_title['data_table_header_col_icon']) || isset($header_title['__fa4_migrated']['data_table_header_col_icon_new'])) { ?>
									<?php if( isset($header_title['data_table_header_col_icon_new']['value']['url']) ) : ?>
                                        <img class="data-header-icon data-table-header-svg-icon" src="<?php echo $header_title['data_table_header_col_icon_new']['value']['url'] ?>" alt="<?php echo esc_attr(get_post_meta($header_title['data_table_header_col_icon_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>" />
									<?php else : ?>
                                        <i class="<?php echo $header_title['data_table_header_col_icon_new']['value'] ?> data-header-icon"></i>
									<?php endif; ?>
								<?php } else { ?>
                                    <i class="<?php echo $header_title['data_table_header_col_icon'] ?> data-header-icon"></i>
								<?php } ?>
							<?php endif; ?>
							<?php
							if( $header_title['data_table_header_col_icon_enabled'] == 'true' && $header_title['data_table_header_icon_type'] == 'image' ) :
								$this->add_render_attribute('data_table_th_img'.$i, [
									'src'	=> esc_url( $header_title['data_table_header_col_img']['url'] ),
									'class'	=> 'table_shortcode-th-img',
									'style'	=> "width:{$header_title['data_table_header_col_img_size']}px;",
									'alt'	=> esc_attr(get_post_meta($header_title['data_table_header_col_img']['id'], '_wp_attachment_image_alt', true))
								]);
								?><img <?php echo $this->get_render_attribute_string('data_table_th_img'.$i); ?>><?php endif; ?><span class="data-table-header-text"><?php echo __( $header_title['data_table_header_col'] , 'docy-core'); ?></span></th>
						<?php $i++; endforeach; ?>
                </tr>
                </thead>
                <tbody>
				<?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
                    <tr>
						<?php
						for( $j = 0; $j < count( $table_td ); $j++ ) {
							if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {

								$this->add_render_attribute('table_inside_td'.$i.$j,
									[
										'colspan' => $table_td[$j]['colspan'] > 1 ? $table_td[$j]['colspan'] : '',
										'rowspan' => $table_td[$j]['rowspan'] > 1 ? $table_td[$j]['rowspan'] : '',
										'class'		=> $table_td[$j]['tr_class'],
										'id'		=> $table_td[$j]['tr_id']
									]
								);
								?>
								<?php if(  $table_td[$j]['content_type'] == 'icon' ) : ?>
                                    <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <div class="td-content-wrapper">
											<?php if ( $table_td[$j]['icon_is_new'] || $table_td[$j]['icon_migrated']) { ?>
                                                <span class="eael-datatable-icon">
                                                        <?php Icons_Manager::render_icon( $table_td[$j]['icon_content_new'] );?>
                                                        </span>
											<?php } else { ?>
                                                <span class="<?php echo $table_td[$j]['icon_content'] ?>" aria-hidden="true"></span>
											<?php } ?>
                                        </div>
                                    </td>
								<?php elseif(  $table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url']) ) : ?>
                                    <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <div class="td-content-wrapper">
                                            <a href="<?php echo esc_url( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                        </div>
                                    </td>

								<?php elseif( $table_td[$j]['content_type'] == 'template' && ! empty($table_td[$j]['template']) ) : ?>
                                    <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <div class="td-content-wrapper">
                                            <div <?php echo $this->get_render_attribute_string('td_content'); ?>>
												<?php echo Plugin::$instance->frontend->get_builder_content(intval($table_td[$j]['template']), true); ?>
                                            </div>
                                        </div>
                                    </td>
								<?php else: ?>
                                    <td <?php echo $this->get_render_attribute_string('table_inside_td'.$i.$j); ?>>
                                        <div class="td-content-wrapper"><div <?php echo $this->get_render_attribute_string('td_content'); ?>><?php echo $table_td[$j]['title']; ?></div></div>
                                    </td>
								<?php endif; ?>
								<?php
							}
						}
						?>
                    </tr>
				<?php endfor; ?>
                </tbody>
            </table>
        </div>
		<?php
	}

}