<?php

namespace DocyCore\Widgets;

use Elementor\Repeater;
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
 * Class Docs
 * @package DocyCore\Widgets
 */
class Docs extends Widget_Base {

	public function get_name() {
		return 'docy_docs';
	}

	public function get_title() {
		return __( 'Docs', 'docy-core' );
	}

	public function get_icon() {
		return 'eicon-document-file';
	}

	public function get_categories() {
		return [ 'docy-elements' ];
	}

	protected function register_controls() {

		$repeater = new \Elementor\Repeater();

		// ---Start Document Setting
		$this->start_controls_section(
			'doc_design_sec', [
				'label' => __( 'Preset Skin', 'docy-core' ),
			]
		);

		$this->add_control(
			'style', [
				'label'   => esc_html__( 'Skins', 'docy-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'1' => [
						'title' => __( 'Tabbed with doc lists', 'coro-core' ),
						'icon'  => 'docs-1',
					],
					'2' => [
						'title' => __( 'Flat tabbed docs', 'coro-core' ),
						'icon'  => 'docs-2',
					],
					'3' => [
						'title' => __( 'Boxed Style', 'coro-core' ),
						'icon'  => 'docs-3',
					],
					'4' => [
						'title' => __( 'Book Chapters / Tutorials', 'coro-core' ),
						'icon'  => 'docs-4',
					],
					'5' => [
						'title' => __( 'List Style', 'coro-core' ),
						'icon'  => 'docs-5',
					],
				],
				'toggle'  => false,
				'default' => '1',
			]
		);

		$this->end_controls_section();

		// --- Filter Options
		$this->start_controls_section(
			'document_filter', [
				'label' => __( 'Filter Options', 'docy-core' ),
			]
		);

		$this->add_control(
			'docs_slug_format', [
				'label'     => esc_html__( 'ID Format', 'docy-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'1'     => 'Slug ID',
					'2'     => 'Number ID',
				],
				'description'   => esc_html__( 'If the slug ID does not work then you should pick the number ID.', 'docy-core' ),
				'condition' => [
					'style' => [ '1', '2', '3', '4' ]
				],
				'default'   => '1'
			]
		);

		$this->add_control(
			'exclude', [
				'label'    => esc_html__( 'Exclude Docs', 'docy-core' ),
				'type'     => Controls_Manager::SELECT2,
				'options'  => docy_get_posts(),
				'multiple' => true
			]
		);

		$this->add_control(
			'show_section_count', [
				'label'       => esc_html__( 'Show Section Count', 'docy-core' ),
				'description' => esc_html__( 'The number of sections to show under every documentation tab. Leave empty or give value -1 to show all sections.', 'docy-core' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => true,
				'default'     => 6,
				'condition'   => [
					'style' => [ '1', '2', '3', '4' ]
				]
			]
		);

		$this->add_control(
			'active_doc',
			[
				'label'       => __( 'Active Doc', 'docly-core' ),
				'description' => __( 'Select the active Doc tab by default.', 'docly-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => docy_get_posts(),
				'label_block' => true,
				'condition'   => [
					'style' => [ '1', '2', '3' ]
				]
			]
		);

		$this->add_control(
			'ppp_doc_items', [
				'label'       => esc_html__( 'Show Doc Item Count', 'docy-core' ),
				'description' => esc_html__( 'The number of doc items to under every doc sections. Leave empty or give value -1 to show all sections.', 'docy-core' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => true,
				'default'     => 4,
				'condition'   => [
					'is_custom_order' => '',
					'style' => [ '1', '2', '3', '4' ]
				],
			]
		);

		$this->add_control(
			'main_doc_excerpt', [
				'label'       => esc_html__( 'Main Doc Excerpt', 'docy-core' ),
				'description' => esc_html__( 'Excerpt word limit of main documentation. If the excerpt got empty, this will get from the post content.', 'docy-core' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => true,
				'default'     => 15,
				'condition'   => [
					'style' => [ '2', '4' ]
				]
			]
		);

		$this->add_control(
			'doc_sec_excerpt', [
				'label'       => esc_html__( 'Doc Section Excerpt', 'docy-core' ),
				'description' => esc_html__( 'Excerpt word limit of the documentation sections. If the excerpt got empty, this will get from the post content.', 'docy-core' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => true,
				'default'     => 8,
				'condition'   => [
					'style' => '2'
				]
			]
		);

		$this->add_control(
			'order', [
				'label'     => esc_html__( 'Order', 'docy-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'ASC'  => 'ASC',
					'DESC' => 'DESC'
				],
				'default'   => 'ASC',
				'condition' => [
					'is_custom_order' => ''
				]
			]
		);

		$this->add_control(
			'is_custom_order',
			[
				'label'        => __( 'Custom Order', 'docly-core' ),
				'description'  => __( 'Order the Doc tabs as you want.', 'docly-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
				'condition'    => [
					'style' => [ '1', '2', '3' ]
				]
			]
		);

		$doc = new Repeater();

		$doc->add_control(
			'doc',
			[
				'label'       => __( 'Doc', 'docly-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => docy_get_posts(),
				'label_block' => true,
			]
		);

		$this->add_control(
			'docs',
			[
				'label'         => __( 'Tabs Items', 'docly-core' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $doc->get_controls(),
				'title_field'   => '{{{ doc }}}',
				'prevent_empty' => false,
				'condition'     => [
					'is_custom_order' => 'yes'
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'labels', [
				'label' => esc_html__( 'Labels', 'docy-core' ),
				'condition'   => [
					'style' => [ '1', '2', '3', '4' ]
				]
			]
		);

		$this->add_control(
			'is_tab_title_first_word',
			[
				'label'        => __( 'Tab Title First Word', 'docy-core' ),
				'description'  => __( 'Show the first word of the doc in Tab Title.', 'docy-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'read_more', [
				'label'       => esc_html__( 'Read More Text', 'docy-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'View All',
				'condition'   => [
					'style' => [ '1', '2', '3' ]
				]
			]
		);

		$this->add_control(
			'book_chapter_prefix',
			[
				'label'     => __( 'Book Chapters / Tutorials Prefix', 'docy-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'style' => [ '4' ]
				]
			]
		);

		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings();

		/**
		 * Get the parent docs with query
		 */
		if ( ! empty( $settings['exclude'] ) ) {
			$parent_docs = get_pages( array(
				'post_type'  => 'docs',
				'parent'     => 0,
				'sort_order' => $settings['order'],
				'exclude'    => $settings['exclude']
			));
		} else {
			$parent_docs = get_pages( array(
				'post_type'  => 'docs',
				'parent'     => 0,
				'sort_order' => $settings['order'],
			) );
		}

		/**
		 * Get the doc sections
		 */
		if ( $parent_docs ) {
			foreach ( $parent_docs as $root ) {
				$sections = get_children( array(
					'post_parent'    => $root->ID,
					'post_type'      => 'docs',
					'post_status'    => 'publish',
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'posts_per_page' => ! empty( $settings['show_section_count'] ) ? $settings['show_section_count'] : - 1,
				) );
				$docs[]   = array(
					'doc'      => $root,
					'sections' => $sections,
				);
			}
		}

		include( "inc/docs/docs-{$settings['style']}.php" );
	}
}