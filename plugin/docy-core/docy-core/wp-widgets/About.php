<?php
namespace DocyCore\WpWidgets;
use WP_Widget;

// About us
class About extends WP_Widget {
    public function __construct()  { // 'About us' Widget Defined
        parent::__construct( 'docy_about', esc_html__( '(Docy) About Us', 'docy-core'), array(
            'description'   => esc_html__( 'About us with logo and social links.', 'docy-core'),
            'classname'     => 'doc_about_widget'
        ));
    }

    // Front End
    public function widget($args, $instance) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        $desc = function_exists('get_field') ? get_field( 'desc',  'widget_'.$args['widget_id']) : '';
        $logo = function_exists('get_field') ? get_field( 'logo',  'widget_'.$args['widget_id']) : '';
        $logo_url = function_exists('get_field') ? get_field( 'logo_url',  'widget_'.$args['widget_id']) : '';
        $social_links = function_exists('get_field') ? get_field( 'social_links',  'widget_'.$args['widget_id']) : '';

        echo $args['before_widget'];
            ?>
            <a href="<?php echo esc_url($logo_url) ?>">
                <?php echo !empty($logo['id']) ? wp_get_attachment_image( $logo['id'], 'full' ) : ''; ?>
            </a>
            <?php echo !empty($desc) ? wpautop($desc) : ''; ?>
            <?php if ( $social_links == '1' ) : ?>
                <ul class="list-unstyled">
                    <?php docycore_social_links(); ?>
                </ul>
            <?php endif; ?>
            <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {

    }

    // Update Data
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        return $instance;
    }

}