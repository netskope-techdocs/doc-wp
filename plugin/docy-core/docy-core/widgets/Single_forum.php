<?php
namespace DocyCore\Widgets;

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
class Single_forum extends Widget_Base {

	public function get_name() {
		return 'docy_single_forum';
	}

	public function get_title() {
		return __( 'Single Forum', 'docy-core' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'docy-elements' ];
	}

	protected function register_controls() {

		//-------------------------------- Select Style ------------------------------------- //
		$this->start_controls_section(
			'style_sec',
			[
				'label' => esc_html__( 'Preset Skins', 'docy-core' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Forums Style', 'docy-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'1' => [
						'icon'  => 'single_forum_1',
						'title' => esc_html__( '01 : Single Forum With Topics', 'docy-core' ),
					],
					'2' => [
						'icon'  => 'single_forum_2',
						'title' => esc_html__( '02 : Single Forum', 'docy-core' ),
					],
				],
				'default' => '1',
			]
		);

		$this->end_controls_section(); // End Style

		$this->start_controls_section(
			'forum_thumb', [
				'label' => __( 'Thumbnail', 'docy-core' ),
			]
		);

		$this->add_control(
			'cover_image', [
				'label' => __( 'Custom Cover Image', 'docy-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'If this is not set, the featured image will be used by default', 'docy-core' )
			]
		);

        $this->end_controls_section();

		// --- Filter Options
		$this->start_controls_section(
			'filter_opt', [
				'label' => __( 'Filter Options', 'docy-core' ),
			]
		);

		$this->add_control(
			'forum_id', [
				'label'   => esc_html__( 'Select Forum', 'docy-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => docy_get_posts( 'forum' )
			]
		);

		$this->add_control(
			'ppp', [
				'label'       => esc_html__( 'Topics', 'docy-core' ),
				'description' => esc_html__( 'Maximum number of topics.', 'docy-core' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => true,
				'default'     => 3
			]
		);

		$this->add_control(
			'order', [
				'label'   => esc_html__( 'Order', 'docy-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'ASC'  => 'ASC',
					'DESC' => 'DESC'
				],
				'default' => 'ASC'
			]
		);

        $this->add_control(
            'word_length',[
                'label' => __( 'Number of Words', 'docy-core' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Number of words to show as forum content', 'docy-core' ),
                'default' => 12
            ]
        );

		$this->add_control(
			'read_more',
			[
				'label'       => esc_html__( 'Read More Text', 'docy-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'View All', 'docy-core' ),
			]
		);

		$this->end_controls_section();

		/**============== Background shape Image =====================**/
		$this->start_controls_section(
			'single_forum_style', [
				'label' => __( 'Single Forum Style', 'docy-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .forum-card, {{WRAPPER}} .forum-with-topics .topic-table .topic-heading, {{WRAPPER}} .forum-with-topics .topic-table .topic-contents',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings           = $this->get_settings();
		$forum_id           = $settings['forum_id'] ? $settings['forum_id'] : '';
        $cover_image        = $settings['cover_image'];
		$post_thumbnail_url = !empty( $cover_image['url'] ) ? $cover_image['url'] : get_the_post_thumbnail_url( $forum_id );

		$topics = new WP_Query( array(
			'post_type'      => bbp_get_topic_post_type(),
			'order'          => $settings['order'] ? $settings['order'] : 'DESC',
			'posts_per_page' => $settings['ppp'] ? $settings['ppp'] : 3,
			'post_parent'    => $forum_id,
		) );

		if ( $forum_id ) {
			include( "inc/single-forum/single-forum-{$settings['style']}.php" );
		} else {
			?>
            <div class="alert alert-warning" role="alert">
				<?php _e( 'Please select a forum.', 'docy-core' ); ?>
            </div>
			<?php
		}
	}
}