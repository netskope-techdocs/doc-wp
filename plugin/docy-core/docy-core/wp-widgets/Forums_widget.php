<?php
namespace DocyCore\WpWidgets;
use WP_Widget;
use WP_Query;

/**
 * Class Forums_Widget
 * @package DocyCore\WpWidgets
 */
class Forums extends WP_Widget {
	/**
	 * bbPress Forum Widget
	 *
	 * Registers the forum widget
	 */
	public function __construct() {
		$widget_ops = apply_filters( 'bbp_forums_widget_options', array(
			'classname'                   => 'ticket_widget',
			'description'                 => esc_html__( 'A list of forums with displaying topics count.', 'bbpress' ),
			'customize_selective_refresh' => true
		) );

		parent::__construct( false, esc_html__( '(Docy) Forums List', 'bbpress' ), $widget_ops );
	}

	/**
	 * Register the widget
	 *
	 * @since 2.0.0 bbPress (r3389)
	 */
	public static function register_widget() {
		register_widget( 'BBP_Forums_Widget' );
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

		// Get widget settings
		$settings = $this->parse_settings( $instance );

		// Typical WordPress filter
		$settings['title'] = apply_filters( 'widget_title',           $settings['title'], $instance, $this->id_base );

		// bbPress filter
		$settings['title'] = apply_filters( 'bbp_forum_widget_title', $settings['title'], $instance, $this->id_base );

		// Note: private and hidden forums will be excluded via the
		// bbp_pre_get_posts_normalize_forum_visibility action and function.
		$widget_query = new WP_Query( array(

			// What and how
			'post_type'      => bbp_get_forum_post_type(),
			'post_status'    => bbp_get_public_status_id(),
			'post_parent'    => $settings['parent_forum'],
			'posts_per_page' => (int) get_option( '_bbp_forums_per_page', 50 ),

			// Order
			'orderby' => 'menu_order title',
			'order'   => 'ASC',

			// Performance
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false
		) );

		// Bail if no posts
		if ( ! $widget_query->have_posts() ) {
			return;
		}

		echo $args['before_widget'];

		if ( ! empty( $settings['title'] ) ) {
			echo $args['before_title'] . $settings['title'] . $args['after_title'];
		} ?>

		<ul class="list-unstyled ticket_categories">

			<?php while ( $widget_query->have_posts() ) : $widget_query->the_post(); ?>

				<li <?php echo ( bbp_get_forum_id() === $widget_query->post->ID ? ' class="bbp-forum-widget-current-forum"' : '' ); ?>>
                    <div class="title">
                        <?php echo get_the_post_thumbnail($widget_query->post->ID, 'docy_16x16') ?>
                        <a class="bbp-forum-title" href="<?php bbp_forum_permalink( $widget_query->post->ID ); ?>">
                            <?php bbp_forum_title( $widget_query->post->ID ); ?>
                        </a>
                    </div>
					<span class="count"><?php bbp_forum_topic_count($widget_query->post->ID); ?></span>
				</li>

			<?php endwhile; ?>

		</ul>

		<?php echo $args['after_widget'];

		// Reset the $post global
		wp_reset_postdata();
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
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'bbpress' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'parent_forum' ); ?>"><?php esc_html_e( 'Parent Forum ID:', 'bbpress' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'parent_forum' ); ?>" name="<?php echo $this->get_field_name( 'parent_forum' ); ?>" type="text" value="<?php echo esc_attr( $settings['parent_forum'] ); ?>" />
			</label>

			<br />

			<small><?php esc_html_e( '"0" to show only root - "any" to show all', 'bbpress' ); ?></small>
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
			'title'        => esc_html__( 'Forums', 'bbpress' ),
			'parent_forum' => 0
		), 'forum_widget_settings' );
	}
}