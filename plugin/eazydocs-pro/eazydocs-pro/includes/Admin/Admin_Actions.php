<?php

namespace eazyDocsPro\Admin;

/**
 * Class Admin_Actions
 *
 * @package eazyDocsPro\Admin
 */
class Admin_Actions {
	function __construct() {
		add_action( 'eazydocs_single_duplicate', [ $this, 'single_duplicate' ] );
		add_action( 'eazydocs_child_section_doc_duplicate', [ $this, 'child_section_duplicate' ], 99, 2 );
		add_action( 'eazydocs_section_doc_duplicate', [ $this, 'section_duplicate' ], 99, 2 );
		add_action( 'eazydocs_parent_doc_duplicate', [ $this, 'parent_duplicate' ], 99, 1 );
		add_action( 'eazydocs_doc_visibility', [ $this, 'doc_visibility' ], 99, 1 );
		add_action( 'eazydocs_doc_visibility_depth_one', [ $this, 'doc_visibility_depth_one' ], 99, 1 );
		add_action( 'eazydocs_doc_visibility_depth_two', [ $this, 'doc_visibility_depth_two' ], 99, 1 );
		add_action( 'eazydocs_doc_sidebar', [ $this, 'doc_sidebar' ], 99, 5 );
		add_action( 'eazydocs_notification', [ $this, 'notification' ], 99, 1 );
		add_action( 'wp_ajax_eazydocs_sortable_docs', [ $this, 'sortable_docs' ] );
		add_action( 'ezd_pro_admin_menu', [ $this, 'ezd_admin_menu' ], 0, 1 );
		add_action( 'posts_where', [ $this, 'feedback_search_by_title_keyword' ], 10, 2 );
		add_action( 'eazydocs_parent_doc_drag', [ $this, 'parent_doc_drag' ] );
		add_action( 'eazydocs_social_share', [ $this, 'social_share' ] );
	}

	/**
	 * EazyDocs Single Duplicator
	 *
	 * @param $id
	 */
	public function single_duplicate( $id ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?action=doc_single_duplicate&_wpnonce=<?php echo wp_create_nonce($id); ?>&duplicate=<?php echo esc_attr( $id ); ?>" target="_blank"
           class="docs-duplicate" title="<?php esc_attr_e( 'Duplicate this doc with the child docs.', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-admin-page"></span>
        </a>
	<?php }

	/**
	 * EazyDocs Child Section Duplicator
	 *
	 * @param $id
	 * @param $parent
	 */
	public function child_section_duplicate( $id, $parent ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?action=child_section_doc_duplicate&_wpnonce=<?php echo wp_create_nonce($id); ?>&duplicate=<?php echo esc_attr( $id ); ?>&parent=<?php echo esc_attr( $parent ); ?>"
           target="_blank" class="docs-duplicate" title="<?php esc_attr_e( 'Duplicate this doc with the child docs.', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-admin-page"></span>
        </a>
	<?php }

	/**
	 * EazyDocs Section Duplicator
	 *
	 * @param $id
	 * @param $parent
	 */
	public function section_duplicate( $id, $parent ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?action=section_doc_duplicate&_wpnonce=<?php echo wp_create_nonce($id); ?>&duplicate=<?php echo esc_attr( $id ); ?>&parent=<?php echo esc_attr( $parent ); ?>"
           target="_blank" class="docs-duplicate" title="<?php esc_attr_e( 'Duplicate this doc with the child docs.', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-admin-page"></span>
        </a>
	<?php }

	/**
	 * EazyDocs Parent Duplicator
	 *
	 * @param $id
	 * @param $parent
	 */
	public function parent_duplicate( $id ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?action=parent_doc_duplicate&_wpnonce=<?php echo wp_create_nonce($id); ?>&duplicate=<?php echo esc_attr( $id ); ?>" target="_blank"
           class="docs-duplicate" title="<?php esc_attr_e( 'Duplicate this doc with the child docs.', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-admin-page"></span>
            <span>Duplicate</span>
        </a>
	<?php }

	/**
	 * EazyDocs Doc visibility
	 *
	 * @param $id
	 * @param $parent
	 */
	public function doc_visibility( $id ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?doc_visibility=<?php echo esc_attr( $id ); ?>&_wpnonce=<?php echo wp_create_nonce($id); ?>" target="_blank" class="docs-visibility"
           title="<?php esc_attr_e( 'Docs visibility', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-visibility"></span>
            <span>Visibility </span>
        </a>
	<?php }

	public function doc_visibility_depth_one( $id ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?section_doc_visibility=<?php echo esc_attr( $id ); ?>&doc_depth_one=yes&_wpnonce=<?php echo wp_create_nonce($id); ?>" class="docs-visibility"
           title="<?php esc_attr_e( 'Section visibility', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-visibility"></span>
        </a>
	<?php }

	public function doc_visibility_depth_two( $id ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?section_doc_visibility=<?php echo esc_attr( $id ); ?>&doc_depth_two=yes&_wpnonce=<?php echo wp_create_nonce($id); ?>" class="docs-visibility"
           title="<?php esc_attr_e( 'Section visibility', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-visibility"></span>
        </a>
	<?php }

	/**
	 * EazyDocs Doc Sidebar
	 *
	 * @param $id
	 * @param $parent
	 */
	public function doc_sidebar( $id, $left_type, $left_cont, $right_type, $right_cont ) { ?>
        <a href="<?php echo admin_url( 'admin.php' ); ?>?doc_sidebar=<?php echo esc_attr( $id . $left_type . $left_cont . $right_type . $right_cont ); ?>&_wpnonce=<?php echo wp_create_nonce($id); ?>"
           target="_blank" class="docs-sidebar" title="<?php esc_attr_e( 'Docs Sidebar', 'eazydocs-pro' ); ?>">
            <span class="dashicons dashicons-welcome-widgets-menus"></span>
            <span>Sidebar </span>
        </a>
	<?php }

	public function parent_doc_drag() { 
		if ( current_user_can('manage_options') ) :
			?>
			<div class="dd-handle dd3-handle" style="z-index: 1;">
				<svg class="dd-handle-icon" width="15px" height="15px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
					title="<?php esc_attr_e( 'Hold the mouse and drag to move this doc.', 'eazydocs-pro' ); ?>">
					<path fill="none" stroke="#bbc0c4" stroke-width="2"
						d="M15,5 L17,5 L17,3 L15,3 L15,5 Z M7,5 L9,5 L9,3 L7,3 L7,5 Z M15,13 L17,13 L17,11 L15,11 L15,13 Z M7,13 L9,13 L9,11 L7,11 L7,13 Z M15,21 L17,21 L17,19 L15,19 L15,21 Z M7,21 L9,21 L9,19 L7,19 L7,21 Z"/>
				</svg>
			</div>
			<?php
		endif;
	}

	/**
	 * EazyDocs Notification
	 */
	public function notification() {
		$counter = eazydocs_voted() + ezd_comment_count();
		?>
        <li class="easydocs-notification" title="<?php esc_attr_e( 'Notifications', 'eazydocs-pro' ); ?>">
            <div class="header-notify-icon">
                <img class="notify-icon" src="<?php echo EAZYDOCSPRO_IMG ?>/admin/notification.svg" alt="<?php esc_html_e( 'Notify Icon', 'eazydocs-pro' ); ?>">
            </div>
			<?php if ( $counter > 0 ) : ?>
                <span class="easydocs-badge">
                 <?php echo esc_html( $counter ); ?>
                </span>
			<?php endif; ?>

            <div class="easydocs-dropdown notification-dropdown">

				<?php if ( $counter > 0 ) : ?>
                    <div class="notification-head d-flex alignment-center justify-content-between ez-pb-0">
                        <span class="header-text">
                            <?php esc_html_e( 'Notifications', 'eazydocs-pro' ); ?>
                        </span>
                    </div>
                    <div class="notification-body" data-ref="container-1">
                        <div class="filter-button-group easydocs-filters">
                            <button type="button" class="easydocs-btn easydocs-btn-gray easydocs-btn-round easydocs-btn-sm mixitup-control-active"
                                    data-filter="*">
                                <span class="dashicons dashicons-screenoptions"></span>
								<?php esc_html_e( 'All', 'eazydocs-pro' ); ?>
                            </button>
                            <button type="button" class="easydocs-btn easydocs-btn-gray easydocs-btn-round easydocs-btn-sm" data-filter=".chat">
                                <span class="dashicons dashicons-admin-comments"></span>
								<?php esc_html_e( 'Comments', 'eazydocs-pro' ); ?>
                            </button>
                            <button type="button" class="easydocs-btn easydocs-btn-gray easydocs-btn-round easydocs-btn-sm" data-filter=".like">
                                <span class="dashicons dashicons-thumbs-up"></span>
								<?php esc_html_e( 'Vote', 'eazydocs-pro' ); ?>
                            </button>
                        </div>
                        <div class="notify-column">
							<?php
							$args = array(
								'post_type'      => 'docs',
								'posts_per_page' => - 1,
								'post_status'    => array( 'publish' )
							);

							$positive_arr = [];
							$negative_arr = [];

							foreach ( get_posts( $args ) as $posts ) {
								// Positive
								$positive       = get_post_meta( $posts->ID, 'positive_time', true );
								$is_p           = ! empty( $positive ) ? 'p' : '';
								$positive_arr[] = get_post_meta( $posts->ID, 'positive_time', true ) . $is_p;

								// Negative
								$negative       = get_post_meta( $posts->ID, 'negative_time', true );
								$is_n           = ! empty( $negative ) ? 'n' : '';
								$negative_arr[] = get_post_meta( $posts->ID, 'negative_time', true ) . $is_n;
							}
							$positive_arr = array_filter( $positive_arr );
							$negative_arr = array_filter( $negative_arr );
							$vote_dates   = array_merge( $positive_arr, $negative_arr );

							// Sort with vote suffix
							usort( $vote_dates, "main_date_sort" );
							$votes    = array_filter( $vote_dates );
							$no_np    = array_merge( $positive_arr, $negative_arr );
							$np_value = [];

							foreach ( $no_np as $pid ) {
								$pid_trim = substr( $pid, - 1 );
								if ( $pid_trim == 'p' ) {
									$vote_text = 'Positive ';
								} elseif ( $pid_trim == 'n' ) {
									$vote_text = 'Negative ';
								}
								$np_value[] = rtrim( $pid, $pid_trim );
							}

							// Sort without vote suffix
							usort( $np_value, "date_sort" );
							$join_arrays = array_combine( $votes, $np_value );
							foreach ( $join_arrays as $np => $item ) :
								$is_np = substr( $np, - 1 );
								if ( $is_np == 'p' ) {
									$vote_text  = 'Positive ';
									$vote_color = 'green ';
									$vote_icon  = 'dashicons-thumbs-up';
								} elseif ( $is_np == 'n' ) {
									$vote_text  = 'Negative ';
									$vote_color = 'red ';
									$vote_icon  = 'dashicons-thumbs-down';
								}
								$args2      = array(
									'post_type'      => 'docs',
									'posts_per_page' => - 1,
									'meta_query'     => array(
										array(
											'value' => $item
										)
									)
								);
								$date_posts = get_posts( $args2 );
								foreach ( $date_posts as $posts ) :
									?>
                                    <div class="notification-item mix like"
                                         onclick="window.open('<?php echo get_the_permalink( $posts ); ?>?read_unread=<?php echo $posts->ID; ?>','new_window');">
                                        <div class="notification-image notification-border-red">
											<?php
											if ( has_post_thumbnail( $posts->ID ) ) {
												echo get_the_post_thumbnail( $posts->ID, 'thumbnail' );
											} else {
												eazydocs_pro_img( EAZYDOCSPRO_IMG . '/admin/placeholder.jpg', 'EazyDocs Pro Placeholder image' );
											}
											?>
                                            <span class="notify-badge notify-badge-blue">
                                             	<span class="dashicons <?php echo esc_attr( $vote_icon ); ?>"> </span>
                                            </span>
                                        </div>
                                        <div class="notification-content">
                                            <div class="d-flex flex-column">
                                                <h5 class="notify-name">
                                                    <a href="<?php echo get_the_permalink( $posts ); ?>" target="_blank">
														<?php echo get_the_title( $posts->ID ); ?>
                                                    </a>
                                                    <!---- Read / Unread -->
													<?php //echo get_post_meta(get_the_ID(), 'ezd_doc_read_unread', true);
													?>
                                                </h5>
                                                <div class="reply-text text-blue mt-2">
													<?php esc_html_e( 'Voted', 'eazydocs-pro' ); ?>
                                                    <strong> <span class="<?php echo esc_attr( $vote_color ); ?>"> <?php echo esc_html( $vote_text ); ?> </span>
                                                    </strong>
                                                </div>
                                            </div>
                                            <small class="notify-date">
												<?php echo human_time_diff( strtotime( $item ), current_time( 'timestamp', 1 ) ) . __( ' ago',
														'eazydocs-pro' ); ?>
                                            </small>
                                        </div>
                                    </div>
								<?php
								endforeach;
							endforeach;
							wp_reset_postdata();
							// Ended vote area

							$args     = array(
								'number'      => 5,
								'post_status' => 'publish',
								'post_type'   => array( 'docs' ),
								'parent'      => 0,
								'order'       => 'desc',
							);
							$comments = get_comments( $args );
							foreach ( $comments as $comment ) :
								?>
                                <a href="<?php echo get_comment_link( $comment ); ?>" target="_blank" class="notification-item-permalink">
                                    <div class="notification-item mix chat">
                                        <div class="notification-image notification-border-red">
											<?php echo get_avatar( $comment, 40 ); ?>
                                            <span class="notify-badge notify-badge-green">
                                          <span class="dashicons dashicons-admin-comments"></span>
                                        </span>
                                        </div>
                                        <div class="notification-content">
                                            <div class="d-flex alignment-center">
                                                <h5 class="notify-name">
													<?php echo $comment->comment_author; ?>
                                                </h5>
                                                <span class="reply-text">
                                                <?php esc_html_e( 'Responded on', 'eazydocs-pro' ); ?>
                                            </span>
                                            </div>
                                            <p class="notify-short-description">
												<?php echo $comment->post_title; ?>
                                            </p>
                                            <small class="notify-date">
												<?php echo human_time_diff( strtotime( $comment->comment_date ), current_time( 'timestamp', 1 ) ) . __( ' ago',
														'eazydocs-pro' ); ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
							<?php
							endforeach;
							?>
                        </div>
                    </div>
				<?php else : ?>
                    <div class="notification-head d-flex alignment-center justify-content-center no-notification-text">
						<?php esc_html_e( 'No new notifications', 'eazydocs-pro' ); ?>
                    </div>
				<?php endif; ?>
            </div>
        </li>
	<?php }
	// Notification ended

	/**
	 * Sort docs.
	 *
	 * @return void
	 */
	public function sortable_docs() {

		$doc_ids = $_POST['page_id_array'];

		if ( $doc_ids ) {
			foreach ( $doc_ids as $order => $id ) {
				wp_update_post( [
					'ID'         => $id,
					'menu_order' => $order
				] );
			}
		}
		exit;
	}

	public function ezd_admin_menu() {
		$capabilites = 'manage_options';
		add_submenu_page( 'eazydocs', __( 'Users Feedback', 'eazydocs-pro' ), __( 'Users Feedback', 'eazydocs-pro' ), $capabilites, 'ezd-user-feedback',
			[ $this, 'user_feedback' ] );
		add_submenu_page( 'eazydocs', __( 'Badges', 'eazydocs-pro' ), __( 'Badges', 'eazydocs-pro' ), $capabilites,
			'edit-tags.php?taxonomy=doc_badge&post_type=docs' );
		add_submenu_page( '', __( 'Feedbacks Archived', 'eazydocs-pro' ), __( 'Feedbacks Archived', 'eazydocs-pro' ), $capabilites,
			'ezd-user-feedback-archived', [ $this, 'user_feedback_archived' ] );
		if ( class_exists( 'EazyDocs' ) && eaz_fs()->is_plan( 'promax' ) ) {
			add_submenu_page( 'eazydocs', __( 'Analytics', 'eazydocs-pro' ), __( 'Analytics', 'eazydocs-pro' ), $capabilites, 'ezd-analytics', [ $this, 'analytics_presents_pro' ] );
		}
	}

	public function user_feedback() {
		include EAZYDOCSPRO_PATH . '/includes/feedback/feedback-open.php';
	}

	public function user_feedback_archived() {
		include EAZYDOCSPRO_PATH . '/includes/feedback/feedback-archived.php';
	}

	public function analytics_presents_pro() {
		include EAZYDOCSPRO_PATH . '/includes/Admin/analytics/Analytics.php';
	}

	public function feedback_search_by_title_keyword( $where, $wp_query ) {
		global $wpdb;
		if ( $title = $wp_query->get( 'feedback_search_title' ) ) {
			$where .= " AND " . $wpdb->posts . ".post_title LIKE '" . esc_sql( $wpdb->esc_like( $title ) ) . "%'";
		}

		return $where;
	}

	public function social_share() {
		echo "sharer";
	}
}

if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
	$is_post          = $_GET['post'] ?? '';
	$get_post_type    = get_post_type( $is_post );
	$add_new_doc_type = $_GET['post_type'] ?? '';
	if ( $get_post_type == 'docs' || $add_new_doc_type == 'docs' ) {
		global $current_user;
		wp_get_current_user();

		$guest_email         = strtolower( get_bloginfo( 'name' ) );
		$guest_email         = str_replace( ' ', '_', $guest_email );
		$frontend_submission = ezd_get_opt( 'ezd_fronted_submission' );

		$frontend_edit = $frontend_submission['frontend-edit-switcher'] ?? '';
		$edit_user     = $frontend_submission['docs-frontend-edit-user-permission'] ?? '';
		$user_id       = $frontend_submission['docs-frontend-edit-user'] ?? '';

		$frontend_add = $frontend_submission['frontend-add-switcher'] ?? '';
		$add_user     = $frontend_submission['docs-frontend-add-user-permission'] ?? '';
		$add_user_id  = $frontend_submission['docs-frontend-add-user'] ?? '';

		if ( $frontend_edit == 1 || $frontend_add == 1 ) {
			if ( $edit_user == 'guest' || $add_user == 'guest' ) {
				$user_info     = get_userdata( $user_id );
				$username      = $user_info->user_login ?? $guest_email . '_guest';
				$add_user_info = get_userdata( $add_user_id );
				$add_username  = $add_user_info->user_login ?? $guest_email . '_guest';

				if ( $current_user->user_login == $username || $current_user->user_login == $add_username ) : ?>
                    <style>
                        /* Doc editor screen */
                        #adminmenuback {
                            width: 0 !important;
                        }

                        .editor-post-locked-modal__buttons .components-flex-item:last-child,
                        button.components-button.editor-post-switch-to-draft.is-tertiary,
                        #adminmenuwrap,
                        #wpadminbar {
                            display: none;
                        }

                        .auto-fold .interface-interface-skeleton {
                            left: 0 !important;
                            top: 0 !important;
                        }

                        #wpcontent {
                            margin-left: 0;
                        }

                        .edit-post-header > div:first-child {
                            width: 0;
                        }

                        .edit-post-header > div:first-child .edit-post-fullscreen-mode-close {
                            display: none;
                        }

                        .editor-styles-wrapper .wp-block {
                            width: 100% !important;
                            padding: 0 15px;
                        }

                        a.components-button.components-menu-item__button {
                            display: none;
                        }
                    </style>
				<?php endif;
			}
		}
	}
}