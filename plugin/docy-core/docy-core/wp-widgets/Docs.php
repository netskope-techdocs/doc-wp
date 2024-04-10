<?php
namespace DocyCore\WpWidgets;
use WP_Widget;
use WP_Query;

/**
 * Widget API: WP_Widget_Recent_Posts class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Docs extends WP_Widget {

    /**
     * Sets up a new Recent Posts widget instance.
     *
     * @since 2.8.0
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'docs_widget',
            'description' => esc_html__( 'List of your documentations.', 'docy' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'docy-docs', esc_html__( '(Docy) Docs List', 'docy' ), $widget_ops );
        $this->alt_option_name = 'widget_docs';
    }

    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Documentation List', 'docy' );

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number ) {
            $number = 5;
        }

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>

        <ul class="list-unstyled">
            <?php
            /**
             * Get the parent docs with query
             */
            $docs = get_pages(array(
                'post_type' => 'docs',
                'parent' => 0,
                'number' => $number
            ));
            foreach ( $docs as $doc ) :
                $favicon_icon = function_exists('get_field') ? get_field('favicon_icon', $doc->ID) : '';
                //echo $favicon_icon;
                ?>
                <li>
                    <a href="<?php echo get_permalink($doc->ID); ?>">
                        <?php
                        echo wp_get_attachment_image($favicon_icon, 'full');
                        echo wp_kses_post($doc->post_title);
                        ?>
                    </a>
                </li>
                <?php
            endforeach;
            ?>
        </ul>

        <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $length   = isset( $instance['length'] ) ? absint( $instance['length'] ) : 24;
        $show_date      = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'docy' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of Posts to Show:', 'docy' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="4" /></p>
        <?php
    }

    /**
     * Handles updating the settings for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        return $instance;
    }
}



