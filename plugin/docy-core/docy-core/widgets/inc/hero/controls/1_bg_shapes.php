<?php
use Elementor\Controls_Manager;

/**
 * Background Objects
 * Style 02, Style 03, Style 04
 */
$this->start_controls_section(
    'style_bg_sec2', [
        'label' => esc_html__( 'Background Objects', 'docy-core' ),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
            'style' => [ '1' ]
        ]
    ]
);

$this->add_control(
    'is_bg_objects', [
        'label' => esc_html__( 'Background Objects', 'docy-core' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'plus_1', [
        'label' => esc_html__( 'Plus 01', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/plus1.png', __FILE__)
        ],
        'condition' => [
            'is_bg_objects' => ['yes']
        ]
    ]
);

$this->add_control(
    'plus_2', [
        'label' => esc_html__( 'Plus 02', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/plus2.png', __FILE__)
        ],
        'condition' => [
            'is_bg_objects' => ['yes']
        ]
    ]
);

$this->end_controls_section();

/**
 * Background Shapes
 * Style 01 (Creative)
 */
$this->start_controls_section(
    'style_bg_shapes', [
        'label' => esc_html__( 'Shapes', 'docy-core' ),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
            'style' => '1'
        ]
    ]
);

$this->add_control(
    'shape1', [
        'label' => esc_html__( 'Shape 01', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/banner_shap1.png', __FILE__)
        ],
    ]
);

$this->add_control(
    'shape2', [
        'label' => esc_html__( 'Shape 02', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/banner_shap4.png', __FILE__)
        ],
    ]
);

$this->add_control(
    'shape3', [
        'label' => esc_html__( 'Shape 03', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/banner_shap3.png', __FILE__)
        ],
    ]
);

$this->add_control(
    'shape4', [
        'label' => esc_html__( 'Shape 04', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/banner_shap2.png', __FILE__)
        ],
    ]
);

$this->end_controls_section();