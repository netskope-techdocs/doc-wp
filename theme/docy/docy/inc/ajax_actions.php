<?php

/**
 * Docs Search results
 */
add_action( 'wp_ajax_docy_search_data_fetch', 'docy_search_data_fetch' );
add_action( 'wp_ajax_nopriv_docy_search_data_fetch', 'docy_search_data_fetch' );
function docy_search_data_fetch() {
	$opt                = get_option( 'docy_opt' );
	$is_ajax_search_tab = $opt['is_ajax_search_tab'] ?? '';
	$no_thumbnail 		= $opt['is_search_result_thumbnail'] == false ? 'no-thumbnail' :  '';
	global $post;

	if ( class_exists( 'EazyDocs' ) || class_exists( 'bbPress' ) ) :
		if ( $is_ajax_search_tab == '1' ) :
			?>
            <div class="searchbar-tabs">
				<?php 
				if ( class_exists( 'EazyDocs' ) ) :
					?>
                    <button type="button" id="search-docs" class="tab-item active" value="docs" onclick="searchDocTab()">
						<?php esc_html_e( 'Docs', 'docy' ) ?>
                    </button>
					<?php 
				endif; 

				if ( class_exists( 'bbPress' ) ) :
					?>
                    <button type="button" id="search-forum" class="tab-item" value="forum" onclick="searchForumTab()">
						<?php esc_html_e( 'Forum', 'docy' ) ?>
                    </button>
					<?php 
				endif;
				?>
                <button type="button" id="search-blog" class="tab-item" value="blog" onclick="searchBlogTab()">
					<?php esc_html_e( 'Blog', 'docy' ) ?>
                </button>
            </div>
		    <?php
		endif;
	endif;

	echo '<div class="search-results-tab ' .esc_attr($no_thumbnail).'" id="doc-search-results">';

	if ( isset( $_GET['wpml_lang'] ) ) {
		do_action( 'wpml_switch_language', $_GET['wpml_lang'] );
	}

    $posts = new WP_Query( [
            'post_type'			=> 'docs',
            's'     			=> $_POST['keyword'] ?? '',
			'post_status' 		=> [ 'publish', 'private' ],
			'posts_per_page'  	=> docy_opt('doc_result_limit', 5)
        ]
    );

    if ( $posts->have_posts() ):
        while ( $posts->have_posts() ) : $posts->the_post();
            ?>
            <div class="search-result-item" onclick="document.location='<?php echo get_the_permalink(get_the_ID()); ?>'">
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="title">
                    <?php
					if ( docy_opt('is_search_result_thumbnail') ) :
						if ( has_post_thumbnail() ) :
							the_post_thumbnail('ezd_searrch_thumb16x16');
						else:
							?>
							<svg width="16px" aria-labelledby="title" viewBox="0 0 17 17" fill="currentColor" class="block h-full w-auto" role="img"><title id="title">Building Search UI</title><path d="M14.72,0H2.28A2.28,2.28,0,0,0,0,2.28V14.72A2.28,2.28,0,0,0,2.28,17H14.72A2.28,2.28,0,0,0,17,14.72V2.28A2.28,2.28,0,0,0,14.72,0ZM2.28,1H14.72A1.28,1.28,0,0,1,16,2.28V5.33H1V2.28A1.28,1.28,0,0,1,2.28,1ZM1,14.72V6.33H5.33V16H2.28A1.28,1.28,0,0,1,1,14.72ZM14.72,16H6.33V6.33H16v8.39A1.28,1.28,0,0,1,14.72,16Z"></path></svg>
							<?php 
						endif;
					endif;
					?>
                    <span class="doc-section">
                        <?php the_title(); ?>
                    </span>
                    <svg viewBox="0 0 24 24" fill="none" color="white" stroke="white" width="16px" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block h-auto w-16"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                </a>
                <?php 
				if ( docy_opt('is_search_result_breadcrumb') ) {
					eazydocs_search_breadcrumbs();
				}
				?>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <div>
            <h5 class="error title"> <?php esc_html_e( 'No result found!', 'docy' ); ?> </h5>
        </div>
        <?php
    endif;

	echo '</div>';
	if ( class_exists( 'bbPress' ) ) {
		echo '<div class="search-results-tab ' .esc_attr($no_thumbnail).'" id="forum-search-results"></div>';
	}
	echo '<div class="search-results-tab ' .esc_attr($no_thumbnail).'" id="blog-search-results"></div>';

	die();
}

/**
 * Forum Search results
 */
add_action( 'wp_ajax_docy_forum_search_results', 'docy_forum_search_results' );
add_action( 'wp_ajax_nopriv_docy_forum_search_results', 'docy_forum_search_results' );
function docy_forum_search_results() {
	// Forums query
    $topics = new WP_Query( array(
        'post_type'      => 'topic',
        's'              => $_POST['keyword'] ?? '',
        'posts_per_page' => docy_opt('doc_result_limit', 5),
    ) );

	if ( $topics->have_posts() ) :
        while ( $topics->have_posts() ) : $topics->the_post();
            ?>
            <div class="search-result-item forum" onclick="document.location='<?php echo get_the_permalink(get_the_ID()); ?>'">
                
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                    <?php
					if ( docy_opt('is_search_result_thumbnail') ) :
						if ( has_post_thumbnail() ) :
							the_post_thumbnail('ezd_searrch_thumb16x16');
						else:
							?>
							<svg width="16px" aria-labelledby="title" viewBox="0 0 17 17" fill="currentColor" class="block h-full w-auto" role="img"><title id="title">Building Search UI</title><path d="M14.72,0H2.28A2.28,2.28,0,0,0,0,2.28V14.72A2.28,2.28,0,0,0,2.28,17H14.72A2.28,2.28,0,0,0,17,14.72V2.28A2.28,2.28,0,0,0,14.72,0ZM2.28,1H14.72A1.28,1.28,0,0,1,16,2.28V5.33H1V2.28A1.28,1.28,0,0,1,2.28,1ZM1,14.72V6.33H5.33V16H2.28A1.28,1.28,0,0,1,1,14.72ZM14.72,16H6.33V6.33H16v8.39A1.28,1.28,0,0,1,14.72,16Z"></path></svg>
							<?php
						endif;
					endif;
					?>
					<span class="topic-section">
                        <?php the_title(); ?>
                    </span>
                    <svg viewBox="0 0 24 24" fill="none" color="white" stroke="white" width="16px" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block h-auto w-16"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>						
                </a>
				<?php 
				if ( docy_opt('is_search_result_breadcrumb') ) :
					?>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"> </li>
						<li class="breadcrumb-item">
							<?php esc_html_e( 'Forums', 'docy' ); ?>
						</li>
						<li class="breadcrumb-item">
							<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>" class="bbp-breadcrumb-root">
								<?php echo bbp_get_topic_forum_title() ?>
							</a>
						</li>
					</ol>
					<?php 
				endif;
				?>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
	endif;
	
	die();
}

/**
 * Blog Search results
 */
add_action( 'wp_ajax_docy_blog_search_results', 'docy_blog_search_results' );
add_action( 'wp_ajax_nopriv_docy_blog_search_results', 'docy_blog_search_results' );
function docy_blog_search_results() {
	// Forums query
	$posts = new WP_Query( array(
		'post_type'      => 'post',
		's'              => $_POST['keyword'] ?? '',
		'posts_per_page' => docy_opt('doc_result_limit', 5),
	) );

    while ( $posts->have_posts() ) : $posts->the_post();
        ?>
        <div class="search-result-item">
			<a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                    <?php
					if ( docy_opt('is_search_result_thumbnail') ) :
						if ( has_post_thumbnail() ) :
							the_post_thumbnail('ezd_searrch_thumb16x16');
						else:
							?>
							<svg width="16px" aria-labelledby="title" viewBox="0 0 17 17" fill="currentColor" class="block h-full w-auto" role="img"><title id="title">Building Search UI</title><path d="M14.72,0H2.28A2.28,2.28,0,0,0,0,2.28V14.72A2.28,2.28,0,0,0,2.28,17H14.72A2.28,2.28,0,0,0,17,14.72V2.28A2.28,2.28,0,0,0,14.72,0ZM2.28,1H14.72A1.28,1.28,0,0,1,16,2.28V5.33H1V2.28A1.28,1.28,0,0,1,2.28,1ZM1,14.72V6.33H5.33V16H2.28A1.28,1.28,0,0,1,1,14.72ZM14.72,16H6.33V6.33H16v8.39A1.28,1.28,0,0,1,14.72,16Z"></path></svg>
							<?php
						endif;
					endif;
					?>
					<span class="topic-section">
                        <?php the_title(); ?>
                    </span>
                    <svg viewBox="0 0 24 24" fill="none" color="white" stroke="white" width="16px" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block h-auto w-16"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>						
                </a>
           
			<?php 
				if ( docy_opt('is_search_result_breadcrumb') ) :
					?>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<?php esc_html_e( 'Blog', 'docy' ); ?>
						</li>
						<li class="breadcrumb-item">
							<a class="cat" href="<?php Docy_helper()->first_category_link(); ?>">
								<?php Docy_helper()->first_category(); ?>
							</a>
						</li>
						<li class="breadcrumb-item"> </li>
					</ol>
					<?php 
				endif;
				?>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();

	die();
}

/**
 * Loading Post
 *
 * @return string
 */
add_action( 'wp_ajax_docy_loading_post', 'docy_loading_post' );
add_action( 'wp_ajax_nopriv_docy_loading_post', 'docy_loading_post' );

/**
 * Loading forum posts
 */
function docy_loading_post() {
	global $wpdb;

	$nonce   = sanitize_text_field( $_POST['nonce'] );
	$type    = sanitize_text_field( $_POST['type'] );
	$post_in = sanitize_text_field( $_POST['a_t_id'] );
	$count   = sanitize_text_field( $_POST['count'] );
	$parent  = sanitize_text_field( $_POST['parent'] );
	if ( ! wp_verify_nonce( $nonce, 'docy-nonce' ) ) {
		die( '-1' );
	}
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$q     = [
		'post_type'           => 'topic',
		'post_parent'         => $parent,
		'order'               => 'DESC',
		'orderby'             => 'post_date',
		'post_status'         => 'publish',
		'posts_per_page'      => - 1,
		'ignore_sticky_posts' => 1,
	];
	if ( $type == 'author' ) {
		$auth_ids = [
			'author' 		  	=> $post_in,
		];
		$q        				= array_merge( $q, $auth_ids );
	} elseif ( $type == 'tag' ) {
		$tax_query[] = [
			'taxonomy' => 'topic-tag',
			'field'    => 'term_id',
			'terms'    => $post_in,
		];
	}
	$tax_query[] = [
		'taxonomy' => 'post_format',
		'field'    => 'slug',
		'terms'    => [ 'post-format-quote', 'post-format-link' ],
		'operator' => 'NOT IN',
	];
	if ( ! empty( $tax_query ) ) {
		$tax_query = array_merge( [ 'relation' => 'AND' ], $tax_query );
		$q         = array_merge( $q, [ 'tax_query' => $tax_query ] );
	}
	$query = new WP_Query( $q );

	if ( $query->have_posts() ):
		echo '<div class="community-posts-wrapper bb-radius">';
		while ( $query->have_posts() ): $query->the_post();
			global $post;
			$author_id      = $post->post_author;
			$parent_post_id = $parent;
			$favoriters     = get_post_meta( get_the_ID(), '_bbp_favorite', true );
			$favorite_count = ! empty( $favoriters ) ? $favoriters[0] : '0';
			$get_reply      = get_post_meta( get_the_ID(), '_bbp_reply_count', true );
			$_reply_count   = isset( $get_reply ) && ! empty( $get_reply ) ? $get_reply : 0;
			?>
            <div class="community-post style-two <?php the_author_meta( 'user_nicename', $author_id ); ?>">
                <div class="post-content">
                    <div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ) ?>
                    </div>
                    <div class="entry-content">
						<?php the_title( sprintf( '<a href="%s" rel="bookmark"> <h3 class="post-title">', esc_url( get_permalink() ) ), '</h3></a>' ); ?>
                        <ul class="meta">
                            <li>
								<?php echo get_the_post_thumbnail( bbp_get_topic_forum_id(), array( 40, 40 ) ); ?>
                                <a href="<?php echo get_permalink( bbp_get_topic_forum_id() ); ?>">
									<?php echo get_the_title( bbp_get_topic_forum_id() ); ?>
                                </a>
                            </li>
                            <li><i class="icon_clock_alt"></i> <?php bbp_topic_post_date( get_the_ID() ); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="post-meta-wrapper">
                    <ul class="post-meta-info">
                        <li><a href="#"><i class="icon_chat_alt"></i><?php echo esc_html( $_reply_count ); ?></a></li>
                        <li><a href="#"><i class="icon_star"></i><?php echo esc_html( $favorite_count ); ?></a></li>
                    </ul>
                </div>
            </div>
		<?php
		endwhile;
		wp_reset_postdata();

		echo '</div>';
	else:
		echo '<div class="community-post-error bug">';
		echo '<div class="error-content">';
		echo '<svg height="40" class="docy-error error-icon" viewBox="0 0 24 24" version="1.1" width="40" aria-hidden="true"><path d="M12 7a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0112 7zm1 9a1 1 0 11-2 0 1 1 0 012 0z"></path><path fill-rule="evenodd" d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zM2.5 12a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z"></path></svg>';
		echo '<h3 class="error">' . esc_html__( 'Oops! No results matched your search.', 'docy' ) . '</h3>';
		echo '<p class="error">' . esc_html__( 'You could search again.', 'docy' ) . '</p>';
		echo '</div>';
		echo '</div>';
	endif;

	die;
}

/**
 * Loading Post
 *
 * @return string
 */
add_action( 'wp_ajax_docy_open_post', 'docy_open_post' );
add_action( 'wp_ajax_nopriv_docy_open_post', 'docy_open_post' );

function docy_open_post() {
	global $wpdb;

	$is_queried_obj = is_singular( 'forum' ) ? get_queried_object_id() : false;
	$nonce          = sanitize_text_field( $_POST['nonce'] );
	$type           = sanitize_text_field( $_POST['type'] );
	$post_in        = sanitize_text_field( $_POST['a_t_id'] );
	$count          = sanitize_text_field( $_POST['count'] );
	$parent         = sanitize_text_field( $_POST['parent'] );
	$userid         = sanitize_text_field( $_POST['userid'] );

	if ( ! wp_verify_nonce( $nonce, 'docy-nonce' ) ) {
		die( '-1' );
	}
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$q = [
		'post_type'           => 'topic',
		'post_parent'         => $parent,
		'order'               => 'DESC',
		'orderby'             => 'post_date',
		'posts_per_page'      => get_option( '_bbp_topics_per_page', 10 ),
		'ignore_sticky_posts' => 1,
		'author'              => $userid
	];
	if ( $type == 'open' ) {
		$status = [
			'post_status' => 'publish',
		];
		$q      = array_merge( $q, $status );
	} elseif ( $type == 'closed' ) {
		$status = [
			'post_status' => 'closed',
		];
		$q      = array_merge( $q, $status );
	}
	$tax_query[] = [
		'taxonomy' => 'post_format',
		'field'    => 'slug',
		'terms'    => [ 'post-format-quote', 'post-format-link' ],
		'operator' => 'NOT IN',
	];
	if ( ! empty( $tax_query ) ) {
		$tax_query = array_merge( [ 'relation' => 'AND' ], $tax_query );
		$q         = array_merge( $q, [ 'tax_query' => $tax_query ] );
	}
	$query = new WP_Query( $q );
	if ( $query->have_posts() ):
		echo '<div class="community-posts-wrapper bb-radius">';
		while ( $query->have_posts() ): $query->the_post();
			global $post;
			$author_id = $post->post_author;
			//$parent_post_id = get_post_meta( get_the_ID(), '_bbp_topic_id', true );
			$parent_post_id = $parent;
			$favoriters     = get_post_meta( get_the_ID(), '_bbp_favorite', true );
			$favorite_count = ! empty( $favoriters ) ? $favoriters[0] : '0';
			$get_reply      = get_post_meta( get_the_ID(), '_bbp_reply_count', true );
			$_reply_count   = isset( $get_reply ) && ! empty( $get_reply ) ? $get_reply : 0;
			?>

            <div class="community-post style-two <?php the_author_meta( 'user_nicename', $author_id ); ?>">
                <div class="post-content">
                    <div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ) ?>
                    </div>
                    <div class="entry-content">
						<?php the_title( sprintf( '<a href="%s" rel="bookmark"> <h3 class="post-title">', get_permalink() ), '</h3></a>' ); ?>
                        <ul class="meta">
                            <li>
								<?php echo get_the_post_thumbnail( bbp_get_topic_forum_id(), array( 40, 40 ) ); ?>
                                <a href="<?php echo get_permalink( bbp_get_topic_forum_id() ); ?>">
									<?php echo get_the_title( bbp_get_topic_forum_id() ); ?>
                                </a>
                            </li>
                            <li><i class="icon_clock_alt"></i> <?php bbp_topic_post_date( get_the_ID() ); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="post-meta-wrapper">
                    <ul class="post-meta-info">
                        <li><a href="#"><i class="icon_chat_alt"></i><?php echo esc_html( $_reply_count ); ?></a></li>
                        <li><a href="#"><i class="icon_star"></i><?php echo esc_html( $favorite_count ); ?></a></li>
                    </ul>
                </div>
            </div>
		    <?php
        endwhile;
		wp_reset_postdata();

		echo '</div>';
	else:
		echo '<div class="community-post-error bug">';
		echo '<div class="error-content">';
		echo '<svg height="40" class="docy-error error-icon" viewBox="0 0 24 24" version="1.1" width="40" aria-hidden="true"><path d="M12 7a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0112 7zm1 9a1 1 0 11-2 0 1 1 0 012 0z"></path><path fill-rule="evenodd" d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zM2.5 12a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z"></path></svg>';
		echo '<h3 class="error">' . esc_html__( 'Oops! No results matched your search.', 'docy' ) . '</h3>';
		echo '<p class="error">' . esc_html__( 'You could search again.', 'docy' ) . '</p>';
		echo '</div>';
		echo '</div>';
	endif;
	die;
}

add_action( 'wp_ajax_docy_loading_sort_post', 'docy_loading_sort_post' );
add_action( 'wp_ajax_nopriv_docy_loading_sort_post', 'docy_loading_sort_post' );

function docy_loading_sort_post() {
	global $wpdb;

	$nonce  = sanitize_text_field( $_POST['nonce'] );
	$sort   = sanitize_text_field( $_POST['sort'] );
	$parent = sanitize_text_field( $_POST['parent'] );

	if ( ! wp_verify_nonce( $nonce, 'docy-nonce' ) ) {
		die( '-1' );
	}

	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$q = [
		'post_type'           => 'topic',
		'post_parent'         => $parent,
		'post_status'         => 'publish',
		'posts_per_page'      => get_option( '_bbp_topics_per_page', 10 ),
		'ignore_sticky_posts' => 1,
	];
	if ( $sort == 'newest_posts' ) {
		$newest_posts = [
			'order' => 'DESC',
		];
		$q            = array_merge( $q, $newest_posts );
	} elseif ( $sort == 'oldest_posts' ) {
		$oldest_posts = [
			'order' => 'ASC',
		];
		$q            = array_merge( $q, $oldest_posts );
	} elseif ( $sort == 'comment_count' ) {
		$comment_count = [
			'meta_key' => '_bbp_reply_count',
			'orderby'  => 'meta_value_num',
			'order'    => 'DESC',
		];
		$q             = array_merge( $q, $comment_count );
	} elseif ( $sort == 'comment_date' ) {
		$comment_count = [
			'meta_key'  => '_bbp_reply_count',
			'meta_type' => 'NUMERIC',
			'orderby'   => 'meta_value_num',
			'order'     => 'ASC',
		];
		$q             = array_merge( $q, $comment_count );
	} elseif ( $sort == 'recent_updated_post' ) {
		$post_date = [
			'orderby' => 'post_modified',
			'order'   => 'DESC',
		];
		$q         = array_merge( $q, $post_date );
	} elseif ( $sort == 'last_recent_updated_post' ) {
		$post_modified = [
			'orderby' => 'post_modified',
			'order'   => 'ASC',
		];
		$q             = array_merge( $q, $post_modified );
	}
	$tax_query[] = [
		'taxonomy' => 'post_format',
		'field'    => 'slug',
		'terms'    => [ 'post-format-quote', 'post-format-link' ],
		'operator' => 'NOT IN',
	];
	if ( ! empty( $tax_query ) ) {
		$tax_query = array_merge( [ 'relation' => 'AND' ], $tax_query );
		$q         = array_merge( $q, [ 'tax_query' => $tax_query ] );
	}
	$query = new WP_Query( $q );
	if ( $query->have_posts() ):
		echo '<div class="community-posts-wrapper bb-radius">';
		while ( $query->have_posts() ): $query->the_post();
			global $post;

			$author_id      = $post->post_author;
			$parent_post_id = $parent;
			$favoriters     = get_post_meta( get_the_ID(), '_bbp_favorite', true );
			$favorite_count = ! empty( $favoriters ) ? $favoriters[0] : '0';
			$get_reply      = get_post_meta( get_the_ID(), '_bbp_reply_count', true );
			$_reply_count   = isset( $get_reply ) && ! empty( $get_reply ) ? $get_reply : 0;
			?>
            <div class="community-post style-two <?php the_author_meta( 'user_nicename', $author_id ); ?>">
                <div class="post-content">
                    <div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ) ?>
                    </div>
                    <div class="entry-content">
						<?php the_title( sprintf( '<a href="%s" rel="bookmark"> <h3 class="post-title">', esc_url( get_permalink() ) ), '</h3></a>' ); ?>
                        <ul class="meta">
                            <li>
                                <?php 
								if ( get_the_post_thumbnail_url($parent_post_id) ) :
									?>
                                    <img src="<?php echo get_the_post_thumbnail_url( $parent_post_id ); ?>" alt="<?php echo get_the_title( $parent_post_id ); ?>">
									<?php 
								endif;
								?>
                                <a href="<?php echo get_permalink( $parent_post_id ); ?>"> <?php echo get_the_title( $parent_post_id ); ?> </a>
                            </li>
                            <li><i class="icon_clock_alt"></i> <?php bbp_topic_post_date( get_the_ID() ); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="post-meta-wrapper">
                    <ul class="post-meta-info">
                        <li><a href="#"><i class="icon_chat_alt"></i><?php echo esc_html( $_reply_count ); ?></a></li>
                        <li><a href="#"><i class="icon_star"></i><?php echo esc_html( $favorite_count ); ?></a></li>
                    </ul>
                </div>
            </div>
		<?php endwhile;
		wp_reset_postdata();

		echo '</div>';
	else:
		echo '<div class="community-post-error bug">';
		echo '<div class="error-content">';
		echo '<svg height="40" class="docy-error error-icon" viewBox="0 0 24 24" version="1.1" width="40" aria-hidden="true"><path d="M12 7a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0112 7zm1 9a1 1 0 11-2 0 1 1 0 012 0z"></path><path fill-rule="evenodd" d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zM2.5 12a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z"></path></svg>';
		echo '<h3 class="error">' . esc_html__( 'Oops! No results matched your search.', 'docy' ) . '</h3>';
		echo '<p class="error">' . esc_html__( 'You could search again.', 'docy' ) . '</p>';
		echo '</div>';
		echo '</div>';
	endif;

	die;
}

add_action( 'wp_ajax_docy_loading_pagination', 'docy_loading_pagination' );
add_action( 'wp_ajax_nopriv_docy_loading_pagination', 'docy_loading_pagination' );

function docy_loading_pagination() {
	global $wpdb;
	$nonce  = sanitize_text_field( $_POST['nonce'] );
	$list   = sanitize_text_field( $_POST['list'] );
	$parent = sanitize_text_field( $_POST['parent'] );
	if ( ! wp_verify_nonce( $nonce, 'docy-nonce' ) ) {
		die( '-1' );
	}
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$q = [
		'post_type'           => 'topic',
		'post_parent'         => $parent,
		'order'               => 'DESC',
		'orderby'             => 'post_date',
		'posts_per_page'      => get_option( '_bbp_topics_per_page', 10 ),
		'ignore_sticky_posts' => 1,
		'paged'               => sanitize_text_field( $_POST['paged'] ),
		'page'                => sanitize_text_field( $_POST['paged'] ),

	];

	$query = new WP_Query( $q );
	if ( $query->have_posts() ):
		echo '<div class="community-posts-wrapper bb-radius">';
		while ( $query->have_posts() ): $query->the_post();
			global $post;
			$author_id      = $post->post_author;
			$parent_post_id = $parent;
			$favoriters     = get_post_meta( get_the_ID(), '_bbp_favorite', true );
			$favorite_count = ! empty( $favoriters ) ? $favoriters[0] : '0';
			$get_reply      = get_post_meta( get_the_ID(), '_bbp_reply_count', true );
			$_reply_count   = isset( $get_reply ) && ! empty( $get_reply ) ? $get_reply : 0;
			?>
            <div class="community-post style-two <?php the_author_meta( 'user_nicename', $author_id ); ?>">
                <div class="post-content">
                    <div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ) ?>
                    </div>
                    <div class="entry-content">
						<?php the_title( sprintf( '<a href="%s" rel="bookmark"> <h3 class="post-title">', get_permalink() ), '</h3></a>' ); ?>
                        <ul class="meta">
                            <li><img src="<?php echo get_the_post_thumbnail_url( $parent_post_id ); ?>" alt="<?php echo get_the_title( $parent_post_id ); ?>">
                                <a href="<?php echo get_permalink( $parent_post_id ); ?>"> <?php echo get_the_title( $parent_post_id ); ?> </a>
                            </li>
                            <li><i class="icon_clock_alt"></i> <?php bbp_topic_post_date( get_the_ID() ); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="post-meta-wrapper">
                    <ul class="post-meta-info">
                        <li><a href="#"><i class="icon_chat_alt"></i><?php echo esc_html( $_reply_count ); ?></a></li>
                        <li><a href="#"><i class="icon_star"></i><?php echo esc_html( $favorite_count ); ?></a></li>
                    </ul>
                </div>
            </div>
		<?php
		endwhile;
		wp_reset_postdata();
		echo '</div>';

	else:
		echo '<div class="community-post-error bug">';
		echo '<div class="error-content">';
		echo '<svg height="40" class="docy-error error-icon" viewBox="0 0 24 24" version="1.1" width="40" aria-hidden="true"><path d="M12 7a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0112 7zm1 9a1 1 0 11-2 0 1 1 0 012 0z"></path><path fill-rule="evenodd" d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zM2.5 12a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z"></path></svg>';
		echo '<h3 class="error">' . esc_html__( 'Oops! No results matched your search.', 'docy' ) . '</h3>';
		echo '<p class="error">' . esc_html__( 'You could search again.', 'docy' ) . '</p>';
		echo '</div>';
		echo '</div>';
	endif;

	die;
}

add_action( 'wp_ajax_docy_tooltip_post', 'docy_tooltip_post' );
add_action( 'wp_ajax_nopriv_docy_tooltip_post', 'docy_tooltip_post' );

function docy_tooltip_post() {
	global $wpdb;
	$slug_id          = url_to_postid( $_POST['slug_id'] );
	$p_query          = get_post( $slug_id );
	$featured_img_url = get_the_post_thumbnail_url( $p_query->ID, 'full' );
	$image_alt        = get_post_meta( $p_query->ID, '_wp_attachment_image_alt', true );
	
	if ( ! empty( $featured_img_url ) ):
		?>
        <img src="<?php echo esc_url( $featured_img_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
		<?php 
	endif;
	?>
    <div class="text">
        <h6>
            <a href="<?php echo esc_url( get_page_link( $p_query->ID ) ); ?>">
				<?php echo esc_url( $p_query->post_title ); ?>
            </a>
        </h6>
        <p><?php echo wp_trim_words( $p_query->post_content, 40, '...' ); ?></p>
    </div>

	<?php
	die();
}