<?php
namespace DocyCore\WpWidgets;
use WP_Widget;
use WP_Query;

/**
 * Class Forums_Widget
 * @package DocyCore\WpWidgets
 */
class Topic_details extends WP_Widget {

	/**
	 * bbPress Forum Widget
	 *
	 * Registers the forum widget
	 *
	 * @since 2.0.0 bbPress (r2653)
	 */
	public function __construct() {
		$widget_ops = apply_filters( 'topic_details_widget_options', array(
			'classname'                   => 'topic_details',
			'description'                 => esc_html__( 'Topic Details', 'docy-core' ),
			'customize_selective_refresh' => true
		));

		parent::__construct( false, esc_html__( '(Docy) Topic Details', 'docy-core' ), $widget_ops );
	}

	/**
	 * Displays the output, the forum list
	 *
	 * @since 2.0.0 bbPress (r2653)
	 *
	 * @param array $args Arguments
	 * @param array $instance Instance
	 */
	public function widget( $args, $instance ) {

	    if ( is_singular('topic') ) :

		// Get widget settings
		$settings = $this->parse_settings( $instance );

		// Typical WordPress filter
		$settings['title'] = apply_filters( 'widget_title', $settings['title'], $instance, $this->id_base );

		// bbPress filter
		$settings['title'] = apply_filters( 'bbp_forum_widget_title', $settings['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( ! empty( $settings['title'] ) ) {
			echo $args['before_title'] . $settings['title'] . $args['after_title'];
		}
		?>
        <div class="topic-info">

            <div class="action-button-container">
                <?php
                bbp_topic_subscription_link(array(
                    'before' => '',
                    'after' => '',
                    'unsubscribe' => esc_html__( 'Subscribed', 'docy' ),
                ));
                ?>
            </div>
            <p>
                <strong class="mini-title">
                    <?php esc_html_e("Customer", "docy-core") ?>
                </strong>
                <?php echo get_avatar(get_the_author_meta('ID'), 15) ?>
                <a href="<?php echo bbp_get_topic_author_url() ?>">
                    <?php echo get_the_author_meta('display_name'); ?>
                </a>
            </p>

            <p>
                <strong class="mini-title"> <?php esc_html_e('Contact', 'docy-core'); ?> </strong>
                <i class="icon_mail_alt"></i> <a href="mailto:<?php echo get_the_author_meta('email'); ?>">
                    <?php echo get_the_author_meta('email'); ?>
                </a>
            </p>

            <p>
                <strong class="mini-title">Related</strong>
                <i class="icon_link_alt"></i> <a href="https://work-empire.com/" target="_blank">https://work-empire.com/</a>
            </p>

            <p>
                <strong class="mini-title">
                    <?php esc_html_e('Category', 'docy-core'); ?>
                </strong>
                <?php echo get_the_post_thumbnail(bbp_get_topic_forum_id(), 'docy_20x20'); ?>
                <a href="<?php bbp_forum_permalink(bbp_get_topic_forum_id()); ?>">
                    <?php echo bbp_get_topic_forum_title() ?>
                </a>
            </p>

            <p>
                <strong class="mini-title">Assigned</strong>
                <img src="https://ticksy_avatars.s3.amazonaws.com/6697396664.jpg" alt="CreativeGigs Support" class="avatar">&nbsp;&nbsp;<a href="/agent/1174815/">CreativeGigs Support</a>
            </p>

            <p>
                <strong class="mini-title">Created</strong>
                <i class="ti ti-calendar-o ti-fw"></i> <span> <?php bbp_topic_post_date(get_the_ID()); ?> </span>
            </p>

            <a href="<?php echo get_delete_post_link(get_the_ID()) ?>" class="delete-ticket" data-ticketid="2860230">
                <strong>Delete this ticket</strong>
            </a>
        </div>

		<?php echo $args['after_widget'];

		// Reset the $post global
		wp_reset_postdata();

		endif;
	}

	/**
	 * Update the forum widget options
	 *
	 * @since 2.0.0 bbPress (r2653)
	 *
	 * @param array $new_instance The new instance options
	 * @param array $old_instance The old instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['parent_forum'] = sanitize_text_field( $new_instance['parent_forum'] );

		// Force to any
		if ( ! empty( $instance['parent_forum'] ) && ! is_numeric( $instance['parent_forum'] ) ) {
			$instance['parent_forum'] = 'any';
		}

		return $instance;
	}

	/**
	 * Output the forum widget options form
	 *
	 * @since 2.0.0 bbPress (r2653)
	 *
	 * @param $instance Instance
	 */
	public function form( $instance ) {
		// Get widget settings
		$settings = $this->parse_settings( $instance ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'docy-core' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent_forum' ); ?>"><?php esc_html_e( 'Parent Forum ID:', 'docy-core' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'parent_forum' ); ?>" name="<?php echo $this->get_field_name( 'parent_forum' ); ?>" type="text" value="<?php echo esc_attr( $settings['parent_forum'] ); ?>" />
			</label>
			<br>
			<small><?php esc_html_e( '"0" to show only root - "any" to show all', 'docy-core' ); ?></small>
		</p>
		<?php
	}

	/**
	 * Merge the widget settings into defaults array.
	 *
	 * @since 2.3.0 bbPress (r4802)
	 *
	 * @param $instance Instance
	 */
	public function parse_settings( $instance = array() ) {
		return bbp_parse_args( $instance, array(
			'title'        => esc_html__( 'Forums', 'docy-core' ),
			'parent_forum' => 0
		), 'forum_widget_settings' );
	}
}