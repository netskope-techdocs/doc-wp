<?php
namespace DocyCore\Widgets;

use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use WP_Query;
use WP_Post;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Forums
 * @package DocyCore\Widgets
 */
class Nav_Menu extends Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'docy_nav_menu';
    }

    public function get_title() {
        return __( 'Docy Navigation Menu', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    protected function register_controls() {

        // --- Filter Options
        $this->start_controls_section(
            'filter_opt', [
                'label' => __( 'Menu Options', 'docy-core' ),
            ]
        );

        $menus = $this->get_available_menus();

        if ( ! empty( $menus ) ) {
            $this->add_control(
                'menu',
                [
                    'label' => esc_html__( 'Menu', 'docy-core' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => array_keys( $menus )[0],
                    'save_default' => true,
                    'separator' => 'after',
                    'description' => sprintf(
                        esc_html__( 'Go to the %1$sMenus screen%2$s to manage your menus. ', 'docy-core' ),
                        sprintf( '<a href="%s" target="_blank">', admin_url( 'nav-menus.php' ) ),
                        '</a>'
                    ),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . esc_html__( 'There are no menus in your site.', 'docy-core' ) . '</strong><br>' .
                        sprintf(
                        /* translators: 1: Link open tag, 2: Link closing tag. */
                            esc_html__( 'Go to the %1$sMenus screen%2$s to create one.', 'docy-core' ),
                            sprintf( '<a href="%s" target="_blank">', admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                            '</a>'
                        ),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $this->add_control(
            'header_layout', [
                'label' => esc_html__( 'Menu Layout', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => 'Default',
                    'search' => 'Search Form'
                ],
                'default' => 'default'
            ]
        );

        $this->add_control(
            'width', [
                'label' => esc_html__( 'Menu Width', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'container' => 'Boxed',
                    'container custom-container' => 'Wide',
                    'container-fluid' => 'Full-width'
                ],
                'default' => 'container'
            ]
        );


        $this->add_control(
            'notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => "<strog> Note: </strog> The Navbar Type, Navbar Position, Search Form options are come from Options :: Page > Header ",
                'separator' => 'after',
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        $this->end_controls_section();

        /**
         * Button Options
         */
        $this->start_controls_section(
            'button_opt', [
                'label' => __( 'Button Options', 'docy-core' ),
            ]
        );

        $this->add_control(
            'is_button', [
                'label' => esc_html__( 'Button', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'btn_label',
            [
                'label' => esc_html__( 'Button Label', 'docy-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Learn More',
                'condition' => [
                    'is_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'docy-core' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'docy-core' ),
                'default' => [
                    'url' => '#'
                ],
                'condition' => [
                    'is_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Button Style
         */
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Button Style', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_btn',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'docy-core' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'docy-core' ),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Text Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn:hover, {{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn:focus' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn:hover, {{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn:hover, {{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'docy-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __( 'Padding', 'docy-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .navbar:not(.navbar_fixed) .nav_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $available_menus = $this->get_available_menus();

        if ( ! $available_menus ) {
            return;
        }

        $settings = $this->get_active_settings();
        $sec_id = $this->get_id();
        $section_width = $this->get_current_section();
        // Get the container section controls
        $container_section = $this->get_type();

        // Button attributes
        if ( !empty($settings['link']['url']) ) {
            $this->add_link_attributes( 'button', $settings['link'] );
        }
        $this->add_render_attribute( 'button', 'class', 'nav_btn tp_btn' );
        ?>
        <div class="click_capture"></div>
        <nav <?php docy_navbar_class() ?> id="<?php docy_sticky_navbar('id') ?>">
            <div class="<?php echo $settings['width'] ?>">
                <?php Docy_helper()->logo(); ?>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'docy'); ?>">
                        <span class="menu_toggle">
                            <span class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="hamburger-cross">
                                <span></span>
                                <span></span>
                            </span>
                        </span>
                </button>
                <?php
                $header_layout = $settings['header_layout'] ?? 'default';
                include( "inc/nav-menu/layout-{$header_layout}.php" );
                ?>
            </div>
        </nav>
        <?php
        include( "inc/nav-menu/mobile-menu.php" );
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
    }

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }
}