<?php
defined( 'ABSPATH' ) || die();

require_once __DIR__ . '/widgets/Cheatsheet.php';
require_once __DIR__ . '/widgets/Counter.php';
require_once __DIR__ . '/widgets/data_table_header_cols_data.php';
require_once __DIR__ . '/widgets/data_table_content_rows.php';
require_once __DIR__ . '/widgets/Hero_keywords.php';
require_once __DIR__ . '/widgets/List_items.php';
require_once __DIR__ . '/widgets/Tab_items.php';
require_once __DIR__ . '/widgets/testimonials.php';

$widgets_map = [
    
    /**
     * Alert
     */
    'docly_alerts_box' => [
        'fields'     => [
            [
                'field' => 'alert_title',
                'type' => __('Alert Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'alert_description',
                'type' => __('Alert Description', 'docy-core'),
                'editor_type' => 'AREA'
            ],
        ],
    ],
    
    'docy_accordion' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Accordion Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'subtitle',
                'type' => __('Accordion Subtitle', 'docy-core'),
                'editor_type' => 'AREA'
            ],
        ],
    ],
    
    'docy_button_icons' => [
        'fields'     => [
            [
                'field' => 'btn_label',
                'type' => __('Button Label', 'docy-core'),
                'editor_type' => 'LINE'
            ],
        ],
    ],
    
    'Docy_contact_banner' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Call to Action :: Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'content',
                'type' => __('Call to Action :: Subtitle', 'docy-core'),
                'editor_type' => 'AREA'
            ],
            [
                'field' => 'btn_label',
                'type' => __('Call to Action :: Button Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
        ],
    ],
    
    'docly_cheatsheet' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Cheat Sheet :: Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            'integration-class' => 'DocyCore\WPML\Cheatsheet',
        ],
    ],
    
    'docly_counter' => [
        'fields' => [],
        'integration-class' => 'DocyCore\WPML\Counter',
    ],
    
    'docly-data-table' => [
        'fields'     => [],
        'integration-class' => ['DocyCore\WPML\data_table_header_cols_data', 'DocyCore\WPML\data_table_content_rows'],
    ],

    'docy_hero' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Hero :: Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'subtitle',
                'type' => __('Hero :: Subtitle', 'docy-core'),
                'editor_type' => 'AREA'
            ],
            [
                'field' => 'placeholder',
                'type' => __('Hero :: Placeholder', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'submit_btn_label',
                'type' => __('Hero :: Submit Label', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'keywords_label',
                'type' => __('Hero :: Keywords Label', 'docy-core'),
                'editor_type' => 'LINE'
            ],
        ],
        'integration-class' => 'DocyCore\WPML\Hero_keywords',
    ],

    'docy_info_box' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Info Box :: Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'link_title',
                'type' => __('Info Box :: Link Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
        ],
    ],

    'docly_list_item' => [
        'fields' => [],
        'integration-class' => 'DocyCore\WPML\List_items',
    ],

    'docy-subscribe' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Mailchimp Form :: Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'email_placeholder',
                'type' => __('Mailchimp Form :: Email Placeholder', 'docy-core'),
                'editor_type' => 'LINE'
            ],
            [
                'field' => 'btn_label',
                'type' => __('Mailchimp Form :: Button Label', 'docy-core'),
                'editor_type' => 'LINE'
            ],
        ],
    ],

    'docy_tabs' => [
        'fields' => [],
        'integration-class' => 'DocyCore\WPML\Tab_items',
    ],

    'docy_testimonial' => [
        'fields' => [],
        'integration-class' => 'DocyCore\WPML\testimonials',
    ],

    'docy_videos_playlist' => [
        'fields'     => [
            [
                'field' => 'title',
                'type' => __('Video Playlist :: Title', 'docy-core'),
                'editor_type' => 'LINE'
            ],
        ],
    ],
];