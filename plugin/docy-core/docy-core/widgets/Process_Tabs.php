<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Process_Tabs extends Widget_Base {

    public function get_name() {
        return 'docy_process_tabs';
    }

    public function get_title() {
        return esc_html__( 'Process Tabs', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    protected function register_controls() {

        // ------------------------------ Feature list ------------------------------
        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __( 'Tabs', 'docy-core' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __( 'Tab Title', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Tab Title', 'docy-core' ),
                'placeholder' => __( 'Tab Title', 'docy-core' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __( 'Top Content', 'docy-core' ),
                'placeholder' => __( 'Tab Content', 'docy-core' ),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'btm_content',
            [
                'label' => __( 'Bottom Content', 'docy-core' ),
                'default' => __( 'Tab Content', 'docy-core' ),
                'placeholder' => __( 'Tab Content', 'docy-core' ),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $repeater->end_controls_tab();

        $this->add_control(
            'tabs',
            [
                'label' => __( 'Tabs Items', 'docy-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        
        //--------------------- Section Color-----------------------------------//
        $this->start_controls_section(
            'style_tabs_sec',
            [
                'label' => __( 'Tabs Style', 'docy-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
        'style_tabs'
        );

        /// Normal  Style
        $this->start_controls_tab(
            'style_normal',
            [
                'label' => __( 'Normal', 'docy-core' ),
            ]
        );

        $this->add_control(
            'normal_title_font_color', [
                'label' => __( 'Title Font Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .design_tab .nav-item .nav-link.normal_color .title_color' => 'color: {{VALUE}}',
                )
            ]
        );

        $this->add_control(
            'normal_subtitle_font_color', [
                'label' => __( 'Subtitle Font Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .design_tab .nav-item .nav-link.normal_color p' => 'color: {{VALUE}}',
                )
            ]
        );

        $this->add_control(
            'normal_bg_color', [
                'label' => __( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .design_tab .nav-item .nav-link' => 'background: {{VALUE}};',
                )
            ]
        );

        $this->end_controls_tab();

        /// ----------------------------- Active Style--------------------------//
        $this->start_controls_tab(
            'style_active_btn',
            [
                'label' => __( 'Active', 'docy-core' ),
            ]
        );

        $this->add_control(
            'active_title_font_color', [
                'label' => __( 'Title Font Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .design_tab .nav-item .nav-link.active .title_color' => 'color: {{VALUE}};',
                )
            ]
        );

        $this->add_control(
            'active_subtitle_font_color', [
                'label' => __( 'Subtitle Font Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .design_tab .nav-item .nav-link.active p' => 'color: {{VALUE}};',
                )
            ]
        );

        $this->add_control(
            'active_bg_color', [
                'label' => __( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .design_tab .nav-item .nav-link.active' => 'background: {{VALUE}};',
                )
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_section();

        //------------------------------------ Tab Border Radius -------------------------------------------//
        $this->start_controls_section(
            'border_radius_sec', [
                'label' => __( 'Border Radius', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_radius', [
                'label' => esc_html__( 'Radius', 'docy-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .design_tab .nav-item .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        $tabs = $this->get_settings_for_display( 'tabs' );
        $id_int = substr( $this->get_id_int(), 0, 3 );
        
        ?>
        <div class="process_tab_shortcode">
            <ul class="nav nav-tabs v_menu" role="tablist">
                <?php
                $i = 0.2;
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;
                    $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
                    $active = $tab_count == 1 ? 'active' : '';
                    $this->add_render_attribute( $tab_title_setting_key, [
                        'class' => [ 'nav-link', $active ],
                        'id' => 'docy'.'-tab-'.$id_int . $tab_count,
                        'data-bs-toggle' => 'tab',
                        'role' => 'tab',
                        'data-bs-target' => '#docy-tab-content-' . $id_int . $tab_count,
                        'aria-controls' => 'docy-tab-content-' . $id_int . $tab_count,
                    ]);
                    ?>
                    <li class="nav-item wow fadeInUp" data-wow-delay="<?php echo esc_attr($i); ?>s">                    
                        <button <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> >
                            <span> <?php echo $tab_count ?> </span>
                            <?php echo wp_kses_post($item['title']); ?>
                        </button>                        
                    </li>
                    <?php
                    $i = $i + 0.2;
                endforeach;
                ?>
            </ul>
            <div class="tab-content">
                <?php
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;
                    $active = $tab_count == 1 ? 'show active' : '';
                    $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );
                    $this->add_render_attribute( $tab_content_setting_key, [
                        'class' => [ 'tab-pane', 'fade', $active ],
                        'aria-labelledby' => 'docy'.'-tab-'.$id_int . $tab_count,
                        'role' => 'tabpanel',
                        'id' => 'docy-tab-content-' . $id_int . $tab_count,
                    ] );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <?php echo wp_kses_post(wpautop($item['content'])); ?>
                        <?php if ( !empty($item['btm_content']) ) : ?>
                            <div class="version">
                                <?php echo wp_kses_post(wpautop($item['btm_content'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php
                endforeach;
                ?>
                <button class="btn btn-info btn-lg previous"><i class="arrow_carrot-left"></i></button>
                <button class="btn btn-info btn-lg next"><i class="arrow_carrot-right"></i></button>
            </div>
        </div>
        
        <script>
            (function($){
                $(document).ready(function(){
                    $(".next").on("click", function () {
                        $(".v_menu .nav-item > .active")
                        .parent()
                        .next("li")
                        .find("button")
                        .trigger("click");
                    });

                    $(".previous").on("click", function () {
                        $(".v_menu .nav-item > .active")
                        .parent()
                        .prev("li")
                        .find("button")
                        .trigger("click");
                    });
                })
            })(jQuery)
        </script>        
        <?php
    }
}