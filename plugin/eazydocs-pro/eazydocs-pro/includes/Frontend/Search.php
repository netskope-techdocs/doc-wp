<?php
namespace eazyDocsPro\Frontend;

/**
 * Class Search
 * @package eazyDocsPro\Frontend
 */
class Search {

	public function __construct() {
		// feedback
		add_action( 'wp_ajax_eazydocs_ajax_search_result', [ $this, 'fetch_posts' ] );
		add_action( 'wp_ajax_nopriv_eazydocs_ajax_search_result', [ $this, 'fetch_posts' ] );
	}

	/**
	 * Store feedback for an article.
	 * @return void
	 */
	public function fetch_posts() {
		?>
		<div class="chatbox-posts" tab-data="post">
			<?php
			$posts = new \WP_Query( [
					'post_type' => 'docs',
					's'         => $_POST['keyword'],
				]
			);

			if ( $posts->have_posts() ):
				while ( $posts->have_posts() ):
					$posts->the_post();
					?>
					<div class="post-item">

                        <nav aria-label="breadcrumb">
							<?php eazydocs_breadcrumbs(); ?>
                        </nav>

						<h2><a href="<?php echo get_the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                        <p><?php ezd_limit_letter( get_the_excerpt(), 80 ); ?></p>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
			else:
				?>
				<div class="post-item keyword-danger">
					<p><?php esc_html_e( 'No Results Found. Please Type a different keyword', 'eazydocs-pro' ) ?></p>
				</div>
			<?php

			endif;
			?>
		</div>
		<?php
		die();
	}
}