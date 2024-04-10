<?php

use Elementor\Controls_Manager;

/** ============ Featured Images ============ **/
$this->start_controls_section(
    'f_images_sec',
    [
        'label' => esc_html__( 'Featured Images', 'docy-core' ),
        'condition' => [
            'style' => ['4']
        ]
    ]
);

$this->add_control(
    'left_img', [
        'label' => esc_html__( 'Left Image', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/v.svg', __FILE__)
        ]
    ]
);

$this->add_control(
    'right_img', [
        'label' => esc_html__( 'Right Image', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/b_leaf.svg', __FILE__)
        ]
    ]
);

$this->end_controls_section();


/**
 * Style Background
 * Style 04 (Cool)
 */
$this->start_controls_section(
    '4_bg_obj', [
        'label' => esc_html__( 'Style Background', 'docy-core' ),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
            'style' => ['4']
        ]
    ]
);

$this->add_control(
    'background_image', [
        'label' => esc_html__( 'Background Image', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/banner_bg_two.png', __FILE__)
        ]
    ]
);

$this->add_control(
    'star_1', [
        'label' => esc_html__( 'Star 01', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/star.png', __FILE__)
        ]
    ]
);

$this->add_control(
    'star_2', [
        'label' => esc_html__( 'Star 02', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/star.png', __FILE__)
        ]
    ]
);

$this->add_control(
    'star_3', [
        'label' => esc_html__( 'Star 03', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/star.png', __FILE__)
        ]
    ]
);

$this->end_controls_section();