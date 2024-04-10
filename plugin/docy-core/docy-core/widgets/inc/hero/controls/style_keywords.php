<?php
/** ============ Content Styling ============ **/

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

$this->start_controls_section(
    'style_keywords', [
        'label' => esc_html__( 'Style Keywords', 'docy-core' ),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'margin_keywords', [
        'label' => __( 'Margin', 'docy-core' ),
        'description' => __( 'Margin around the keywords block', 'docy-core' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [ '{{WRAPPER}} .header_search_keyword' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        'separator' => 'before',
        'default' => [
            'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
        ],
    ]
);

$this->add_control(
    'color_keywords_label', [
        'label' => esc_html__( 'Label Color', 'docy-core' ),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .header_search_keyword .header-search-form__keywords-label' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'color_keywords', [
        'label' => esc_html__( 'Keyword Color', 'docy-core' ),
        'type' => Controls_Manager::COLOR,
        'separator' => 'before',
        'selectors' => [
            '{{WRAPPER}} .header_search_keyword ul li a' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'color_keywords_bg', [
        'label' => esc_html__( 'Background Color', 'docy-core' ),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .header_search_keyword ul li a' => 'background: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(), [
        'name' => 'typography_keywords',
        'label' => esc_html__( 'Typography', 'docy-core' ),
        'scheme' => Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .header_search_keyword ul li a',
    ]
);

$this->add_control(
    'keywords_padding', [
        'label' => __( 'Padding', 'docy-core' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [ '{{WRAPPER}} .header_search_keyword ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        'default' => [
            'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
        ],
    ]
);

$this->add_control(
    'br', [
        'label' => __( 'Border Radius', 'docy-core' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [ '{{WRAPPER}} .header_search_keyword ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        'default' => [
            'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
        ],
    ]
);

$this->end_controls_section();