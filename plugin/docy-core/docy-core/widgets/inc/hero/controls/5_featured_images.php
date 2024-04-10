<?php
/** ============ Featured Images Light  ============ **/

use Elementor\Controls_Manager;

$this->start_controls_section(
    'f_images_sec2',
    [
        'label' => esc_html__( 'Featured Images', 'docy-core' ),
        'condition' => [
            'style' => ['5']
        ]
    ]
);

$this->add_control(
    'light_f_img1', [
        'label' => esc_html__( 'Featured Image 01', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/building.png', __FILE__)
        ]
    ]
);


$this->add_control(
    'light_f_img3', [
        'label' => esc_html__( 'Featured Image 03', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/table.svg', __FILE__)
        ]
    ]
);

$this->add_control(
    'light_f_img4', [
        'label' => esc_html__( 'Featured Image 04', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/bord.png', __FILE__)
        ]
    ]
);

$this->add_control(
    'light_f_img5', [
        'label' => esc_html__( 'Featured Image 05', 'docy-core' ),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => plugins_url('images/girl.png', __FILE__)
        ]
    ]
);

$this->end_controls_section();