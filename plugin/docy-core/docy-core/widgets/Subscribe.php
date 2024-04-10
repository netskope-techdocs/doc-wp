<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Testimonial_carousel
 * @package DocyCore\Widgets
 */
class Subscribe extends \Elementor\Widget_Base {

    public function get_name() {
        return 'docy-subscribe';
    }

    public function get_title() {
        return __( 'Subscribe Form', 'docy-core' );
    }

    public function get_icon() {
        return 'eicon-mailchimp';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    public function get_keywords() {
        return [ 'mailchimp', 'form', 'subscribe' ];
    }

    public function get_script_depends() {
        return [ 'ajax-chimp' ];
    }

    protected function register_controls() {
        // ------------------------------ Title ------------------------------ //
        $this->start_controls_section(
            'title_sec', [
                'label' => __( 'Title', 'docy-core' ),
            ]
        );

        $this->add_control(
            'title', [
                'label' => __( 'Title', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Great Customer
Relationships start here'
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => __( 'Title Tag', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => docy_el_title_tags(),
            ]
        );

        $this->end_controls_section(); // End Title


        //----------------------------------- Start Mailchimp Form Settings -------------------------------------------//
        $this->start_controls_section(
            'form_settings', [
                'label' => esc_html__( 'Form Settings', 'buttonz' ),
            ]
        );

        $this->add_control(
            'email_placeholder', [
                'label' => esc_html__( 'Email Placeholder', 'buttonz' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Your email'
            ]
        );

        $this->add_control(
            'action_url', [
                'label' => esc_html__( 'Action URL', 'buttonz' ),
                'description' => __( 'Enter here your MailChimp action URL. <a href="https://goo.gl/k5a2tA" target="_blank"> How to </a>', 'buttonz' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'https://edubdonline.us9.list-manage.com/subscribe/post?u=e533cc3d8e231e6fb2f797147&amp;id=eedf314a5e'
            ]
        );

        $this->add_control(
            'btn_label', [
                'label' => esc_html__( 'Button Label', 'buttonz' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Get started',
            ]
        );

        $this->add_control(
            'form_bottom_content', [
                'label' => __( 'Form Bottom Content', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'separator' => 'before',
            ]
        );

        $this->end_controls_section(); // End Mailchimp Form


        /**
         * Style Form ------------------------------------------------------
         */
        $this->start_controls_section(
            'style_form', [
                'label' => __( 'Form', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'email-input_radius',
            [
                'label' => __( 'Input Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_inner .doc_subscribe_form .input-fill input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'email_input_bg_color', [
                'label' => __( 'Input Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_inner .doc_subscribe_form .input-fill input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_icon_color', [
                'label' => __( 'Input Icon Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_inner .doc_subscribe_form .input-fill input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn-style',
            [
                'label'     => esc_html__( 'Button', 'docy-core' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btn-radius',
            [
                'label' => __( 'Input Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_form .submit_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //---------------------------- Normal and Hover ---------------------------//
        $this->start_controls_tabs(
            'style_tabs'
        );

        // Normal Color
        $this->start_controls_tab(
            'normal_btn_style',
            [
                'label' => __( 'Normal', 'buttonz' ),
            ]
        );

        $this->add_control(
            'normal_text_color', [
                'label' => __( 'Text Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_form .submit_btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'normal_bg_color', [
                'label' => __( 'Background Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_form .submit_btn' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Color
        $this->start_controls_tab(
            'hover_btn_style',
            [
                'label' => __( 'Hover', 'buttonz' ),
            ]
        );

        $this->add_control(
            'hover_text_color', [
                'label' => __( 'Text Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_form .submit_btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_bg_color', [
                'label' => __( 'Background Color', 'buttonz' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_form .submit_btn:before' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Title
         */
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Title', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color', [
                'label' => __( 'Text Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'text_typo',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->end_controls_section();


        /**========================= Shape Images ================================**/
        $this->start_controls_section(
            'shape_images', [
                'label' => __( 'Shapes', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shape1', [
                'label' => __( 'Shape 01', 'docy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('images/subscribe_shap.png', __FILE__)
                ],
            ]
        );

        $this->add_control(
            'shape2', [
                'label' => __( 'Shape 02', 'docy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('images/subscribe_shap_two.png', __FILE__)
                ],
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- Style Section ---------------------------//
        $this->start_controls_section(
            'style_section', [
                'label' => __( 'Style Section', 'docy-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'sec_padding',
            [
                'label' => __( 'Padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sec_radius',
            [
                'label' => __( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sec_bg_color', [
                'label' => __( 'Background Color', 'docy-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doc_subscribe_inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();
        $title = !empty($settings['title']) ? $settings['title'] : '';
        $title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';
        $btn_label = !empty($settings['btn_label']) ? $settings['btn_label'] : '';
        $form_bottom_content = !empty($settings['form_bottom_content']) ? $settings['form_bottom_content'] : '';
        $email_placeholder = !empty($settings['email_placeholder']) ? $settings['email_placeholder'] : '';
        ?>
        <div class="doc_subscribe_inner">
            <?php
            docy_el_image($settings['shape1'], 'docy curve shape top', 'one');
            docy_el_image($settings['shape2'], 'docy curve shape bottom', 'two');
            if ( $title ) : ?>
                <div class="text wow fadeInLeft" data-wow-delay="0.2s">
                    <?php echo sprintf( '<%1$s class="title"> %2$s </%1$s>', $title_tag, nl2br($title) ) ?>
                </div>
                <?php
            endif
            ?>
            <form action="#" class="doc_subscribe_form wow fadeInRight mailchimp" data-wow-delay="0.4s"
                  method="post">
                <div class="form-group">
                    <div class="input-fill">
                        <input type="email" name="EMAIL" id="email" class="memail" placeholder="<?php echo esc_attr($email_placeholder) ?>">
                    </div>
                    <?php if ($btn_label) : ?>
                        <button type="submit" class="submit_btn"><?php echo esc_html($btn_label) ?></button>
                    <?php endif ?>
                    <p class="mchimp-errmessage" style="display: none;"></p>
                    <p class="mchimp-sucmessage" style="display: none;"></p>
                </div>
                <?php echo !empty($form_bottom_content) ? wp_kses_post($form_bottom_content) : ''; ?>
            </form>
        </div>

        <script>
            ;(function($){
                "use strict";
                $(document).ready(function () {

                    $(".mailchimp").ajaxChimp({
                        callback: mailchimpCallback,
                        url:
                            "<?php echo esc_js($settings['action_url']) ?>", //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".
                    });
                    $(".memail").on("focus", function () {
                        $(".mchimp-errmessage").fadeOut();
                        $(".mchimp-sucmessage").fadeOut();
                    });
                    $(".memail").on("keydown", function () {
                        $(".mchimp-errmessage").fadeOut();
                        $(".mchimp-sucmessage").fadeOut();
                    });
                    $(".memail").on("click", function () {
                        $(".memail").val("");
                    });

                    function mailchimpCallback(resp) {
                        if (resp.result === "success") {
                            $(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
                            $(".mchimp-sucmessage").fadeOut(500);
                        } else if (resp.result === "error") {
                            $(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
                        }
                    }
                });
            })(jQuery)
        </script>

        <?php
    }
}