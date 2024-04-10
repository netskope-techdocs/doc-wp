<?php
/**
 * Get the value of a settings field.
 *
 * @param string $option  settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function eazydocspro_get_option( $option, $section, $default = '' ) {
	$options = get_option( $section );

	if ( isset( $options[ $option ] ) ) {
		return $options[ $option ];
	}

	return $default;
}

/**
 * Get the docs search keywords query
 *
 * @return array|object|stdClass[]|null
 */
function ezd_get_search_keywords() {
	global $wpdb;

	return $wpdb->get_results( "SELECT {$wpdb->prefix}eazydocs_search_keyword.keyword, COUNT(*) AS not_found_count FROM {$wpdb->prefix}eazydocs_search_log JOIN {$wpdb->prefix}eazydocs_search_keyword ON {$wpdb->prefix}eazydocs_search_keyword.id = {$wpdb->prefix}eazydocs_search_log.keyword_id WHERE {$wpdb->prefix}eazydocs_search_log.not_found_count = 1 GROUP BY {$wpdb->prefix}eazydocs_search_keyword.keyword ORDER BY not_found_count DESC LIMIT 20" );
}


if ( ! function_exists( 'eazydocs_breadcrumbs' ) ) {

	/**
	 * Docs breadcrumb.
	 *
	 * @return void
	 */
	function eazydocs_breadcrumbs() {
		global $post;

		$home_text       = ezd_get_opt( 'breadcrumb-home-text', 'eazydocs_settings' );
		$front_page      = ! empty ( $home_text ) ? esc_html( $home_text ) : esc_html__( 'Home', 'eazydocs-pro' );
		$docs_home       = ezd_get_opt( 'docs-slug', 'eazydocs_settings' );
		$docs_page_title = ezd_get_opt( 'docs-page-title', 'eazydocs_settings' );
		$docs_page_title = ! empty ( $docs_page_title ) ? esc_html( $docs_page_title ) : esc_html__( 'Docs', 'eazydocs-pro' );

		$html = '';
		$args = apply_filters( 'eazydocs_breadcrumbs', [
			'delimiter' => '',
			'home'      => $front_page,
			'before'    => '<li class="breadcrumb-item active">',
			'after'     => '</li>',
		] );

		$breadcrumb_position = 1;

		$html .= '<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
		$html .= eazydocs_get_breadcrumb_item( $args['home'], home_url( '/' ), $breadcrumb_position );
		$html .= $args['delimiter'];

		if ( $docs_home ) {
			++ $breadcrumb_position;

			$html .= eazydocs_get_breadcrumb_item( $docs_page_title, get_permalink( $docs_home ), $breadcrumb_position );
			$html .= $args['delimiter'];
		}

		if ( 'docs' == $post->post_type && $post->post_parent ) {
			$parent_id   = $post->post_parent;
			$breadcrumbs = [];

			while ( $parent_id ) {
				++ $breadcrumb_position;

				$page          = get_post( $parent_id );
				$breadcrumbs[] = eazydocs_get_breadcrumb_item( get_the_title( $page->ID ), get_permalink( $page->ID ), $breadcrumb_position );
				$parent_id     = $page->post_parent;
			}

			$breadcrumbs = array_reverse( $breadcrumbs );

			for ( $i = 0; $i < count( $breadcrumbs ); ++ $i ) {
				$html .= $breadcrumbs[ $i ];
				$html .= ' ' . $args['delimiter'] . ' ';
			}
		}

		$html .= ' ' . $args['before'] . get_the_title() . $args['after'];

		$html .= '</ol>';

		echo apply_filters( 'eazydocs_breadcrumbs_html', $html, $args );
	}
}

// Recently Viewed Docs
add_action( 'template_redirect', 'ezd_posts_visited' );
function ezd_posts_visited() {
	if ( is_single() && get_post_type() == 'docs' ) {
		$cooki    = 'eazydocs_recent_posts';
		$ft_posts = isset( $_COOKIE[ $cooki ] ) ? json_decode( htmlspecialchars( $_COOKIE[ $cooki ], true ) ) : null;
		if ( isset( $ft_posts ) ) {
			// Remove current post in the cookie
			$ft_posts = array_diff( $ft_posts, array( get_the_ID() ) );
			// update cookie with current post
			array_unshift( $ft_posts, get_the_ID() );
		} else {
			$ft_posts = array( get_the_ID() );
		}
		setcookie( $cooki, json_encode( $ft_posts ), time() + ( DAY_IN_SECONDS * 31 ), COOKIEPATH, COOKIE_DOMAIN );
	}
}

/**
 * EazyDocsPro img callback
 *
 * @param $src
 * @param $alt
 */
function eazydocs_pro_img( $src, $alt ) {
	echo "<img src='" . $src . "' alt='" . $alt . "' />";
}

/**
 * Votes counter
 *
 * @return int
 */
function eazydocs_voted() {

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
	$votes = array_filter( $vote_dates );

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
	$doc_count   = 0;
	$join_arrays = array_combine( $votes, $np_value );
	foreach ( $join_arrays as $np => $item ) :
		$doc_count ++;
		$is_np = substr( $np, - 1 );

		if ( $is_np == 'p' ) {
			$vote_text  = 'Positive ';
			$vote_color = 'green ';
		} elseif ( $is_np == 'n' ) {
			$vote_text  = 'Negative ';
			$vote_color = 'red ';
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
	endforeach;

	return $doc_count;
	wp_reset_postdata();
}

/**
 * EazyDocsPro comments counter
 *
 * @return int
 */
function ezd_comment_count() {
	$args     = array(
		'number'      => 5,
		'post_status' => 'publish',
		'post_type'   => array( 'docs' ),
		'parent'      => 0,
	);
	$comments = get_comments( $args );

	return count( $comments );
}

/**
 * Get all WP Roles
 *
 * @return string[]
 */
function eazydocs_user_role_names() {
	global $wp_roles;
	if ( ! isset( $wp_roles ) ) {
		$wp_roles = new WP_Roles();
	}

	return $wp_roles->get_names();
}

/**
 * Limit latter
 *
 * @param        $string
 * @param        $limit_length
 * @param string $suffix
 */
function ezd_limit_letter( $string, $limit_length, $suffix = '...' ) {
	if ( strlen( $string ) > $limit_length ) {
		echo strip_shortcodes( substr( $string, 0, $limit_length ) . $suffix );
	} else {
		echo strip_shortcodes( esc_html( $string ) );
	}
}

/**
 * Get total views
 *
 * @return int
 */
function ezdpro_get_total_views() {
	global $wpdb;

	$eazydocs_view_table = $wpdb->prefix . 'eazydocs_view_log'; // Assuming the table has a prefix
	// Perform the query
	$results 			 = $wpdb->get_results("SELECT `count`, `created_at` FROM $eazydocs_view_table", ARRAY_A);

	// Output the results
	$rowValues      	 = array();
	foreach ($results as $row) {
		$rowValues[$row['created_at']] = $row['count'];
	}

	$totalValues    	= array();

	// Loop through the data and sum up the values for each date
	foreach ($rowValues as $dateTime => $value) {
		$date = explode(' ', $dateTime)[0]; // Extract the date part
		if ( isset( $totalValues[$date] ) ) {
			$totalValues[$date] += $value;
		} else {
			$totalValues[$date] = $value;
		}
	}

	$ViewsTotalsum = 0;

	// Loop through the values and add them to the sum
	foreach ($totalValues as $value) {
		$ViewsTotalsum += $value;
	}

	// Output the result
	return $ViewsTotalsum;
}

//CUSTOM META BOX
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'EZD Feedback Options', 'EZD Feedback Options', 'ezd_feedback_docs', 'ezd_feedback' );
	add_meta_box( 'doc_extra_information', 'Additional Information', 'ezd_docs_extra_info', 'docs' );
} );

function ezd_feedback_docs() {
	?>
    <p><b>ID</b><br/>
        <input type="text" name="ezd_feedback_id" value="<?php echo get_post_meta( get_the_ID(), 'ezd_feedback_id', true ); ?>" class="widefat"/>
    </p>
    <p><b>Name</b><br/>
        <input type="text" name="ezd_feedback_name" value="<?php echo get_post_meta( get_the_ID(), 'ezd_feedback_name', true ); ?>" class="widefat"/>
    </p>
    <p><b>Email</b><br/>
        <input name="ezd_feedback_email" value="<?php echo get_post_meta( get_the_ID(), 'ezd_feedback_email', true ); ?>" class="widefat"/>
    </p>
    <p><b>Subject</b><br/>
        <input name="ezd_feedback_subject" value="<?php echo get_post_meta( get_the_ID(), 'ezd_feedback_subject', true ); ?>" class="widefat"/>
    </p>
    <p><b>Status</b><br/>
        <input name="ezd_feedback_status" value="<?php echo get_post_meta( get_the_ID(), 'ezd_feedback_status', true ); ?>" class="widefat"/>
    </p>
<?php }

function ezd_docs_extra_info() {
	?>
    <p><b><?php echo esc_html( 'Doc Contributors' ); ?></b><br/>
        <input type="text" name="ezd_doc_contributors" value="<?php echo get_post_meta( get_the_ID(), 'ezd_doc_contributors', true ); ?>" class="widefat"/>
    </p>
    <p><b><?php echo esc_html( 'Read / Unread' ); ?></b><br/>
        <input type="text" name="ezd_doc_read_unread" value="<?php echo get_post_meta( get_the_ID(), 'ezd_doc_read_unread', true ); ?>" class="widefat"/>
    </p>
    <p><b><?php echo esc_html( 'Read / Unread Time' ); ?></b><br/>
        <input type="text" name="ezd_doc_read_unread_time" value="<?php echo get_post_meta( get_the_ID(), 'ezd_doc_read_unread_time', true ); ?>"
               class="widefat"/>
    </p>
    <p><b><?php echo esc_html( 'Left Sidebar' ); ?></b><br/>
        <input type="text" name="ezd_doc_left_sidebar_type" value="<?php echo get_post_meta( get_the_ID(), 'ezd_doc_left_sidebar_type', true ); ?>"
               class="widefat"/><br/>
        <textarea name="ezd_doc_left_sidebar" id="" rows="5" class="widefat"> <?php echo get_post_meta( get_the_ID(), 'ezd_doc_left_sidebar',
				true ); ?> </textarea>
    </p>
    <p><b><?php echo esc_html( 'Right Sidebar' ); ?></b><br/>
        <input type="text" name="ezd_doc_right_sidebar_type" value="<?php echo get_post_meta( get_the_ID(), 'ezd_doc_right_sidebar_type', true ); ?>"
               class="widefat"/><br/>
        <textarea name="ezd_doc_right_sidebar" id="" rows="5" class="widefat"> <?php echo get_post_meta( get_the_ID(), 'ezd_doc_right_sidebar',
				true ); ?> </textarea>
    </p>
<?php }

add_action( 'save_post', function ( $post_id ) {
	// Feedback Options
	$ezd_feedback_id          = $_POST['ezd_feedback_id'] ?? '';
	$ezd_feedback_name        = $_POST['ezd_feedback_name'] ?? '';
	$ezd_feedback_email       = $_POST['ezd_feedback_email'] ?? '';
	$ezd_feedback_subject     = $_POST['ezd_feedback_subject'] ?? '';
	$ezd_feedback_status      = $_POST['ezd_feedback_status'] ?? '';
	$ezd_doc_contributors     = $_POST['ezd_doc_contributors'] ?? '';
	$ezd_doc_read_unread      = $_POST['ezd_doc_read_unread'] ?? '';
	$ezd_doc_read_unread_time = $_POST['ezd_doc_read_unread_time'] ?? '';

	$ezd_doc_left_sidebar  = $_POST['ezd_doc_left_sidebar'] ?? '';
	$ezd_doc_right_sidebar = $_POST['ezd_doc_right_sidebar'] ?? '';

	update_post_meta( $post_id, 'ezd_feedback_id', $ezd_feedback_id );
	update_post_meta( $post_id, 'ezd_feedback_name', $ezd_feedback_name );
	update_post_meta( $post_id, 'ezd_feedback_email', $ezd_feedback_email );
	update_post_meta( $post_id, 'ezd_feedback_subject', $ezd_feedback_subject );
	update_post_meta( $post_id, 'ezd_feedback_status', $ezd_feedback_status );
	update_post_meta( $post_id, 'ezd_doc_read_unread', $ezd_doc_read_unread );
	update_post_meta( $post_id, 'ezd_doc_read_unread_time', $ezd_doc_read_unread_time );

	update_post_meta( $post_id, 'ezd_doc_left_sidebar', $ezd_doc_left_sidebar );
	update_post_meta( $post_id, 'ezd_doc_right_sidebar', $ezd_doc_right_sidebar );

	$ezd_doc_revisions     = wp_get_post_revisions( get_the_ID() );
	$ezd_doc_revision_list = '';
	foreach ( $ezd_doc_revisions as $ezd_doc_revision ) {
		$ezd_doc_revision_list .= $ezd_doc_revision->post_author . ',';
	}

	update_post_meta( $post_id, 'ezd_doc_contributors', $ezd_doc_revision_list );
} );

// User Feedback archive menu active
add_action( 'admin_footer', function () { ?>
    <script>
      // User feedback archived
      feedback_archived = 'admin.php?page=ezd-user-feedback-archived';
      doc_badge = 'edit-tags.php?taxonomy=doc_badge&post_type=docs';

      // EazyDocs menu active when it's EazyDocs screen
      if (window.location.href.indexOf(feedback_archived) > -1) {
        jQuery('.toplevel_page_eazydocs').
            removeClass('wp-not-current-submenu').
            addClass('wp-has-current-submenu wp-menu-open').
            find('li').
            has('a[href*="admin.php?page=ezd-user-feedback"]').
            addClass('current');
      }
      if (window.location.href.indexOf(doc_badge) > -1) {
        jQuery('.toplevel_page_eazydocs').
            removeClass('wp-not-current-submenu').
            addClass('wp-has-current-submenu wp-menu-open').
            find('li').
            has('a[href*="edit-tags.php?taxonomy=doc_badge&post_type=docs"]').
            addClass('current');
      }
    </script>
<?php } );

/**
 * Private Doc visibility
 * Guest Login / Login Required
 * Login with custom form
 **/
function ezd_private_login() {
	if ( is_404() ) {
		global $wp_query;
		global $wpdb;
		$query          = $wp_query->request;
		$statuses       = $wpdb->get_results( $query );
		$is_post_status = '';

		if ( $statuses ) {
			foreach ( $statuses as $status ) {
				$is_post_status = $status->post_status ?? '';
				$is_post_id     = $status->ID ?? '';
			}
		}
		
		if ( $is_post_status == 'private' && get_post_type( $is_post_id ) == 'docs' ) {
			$doc_user_mode    = ezd_get_opt( 'private_doc_mode' );
			$add_user_page_id = ezd_get_opt( 'private_doc_login_page' );
			$add_user_page_id = get_permalink( $add_user_page_id );

			if ( $doc_user_mode == 'login' && ! empty( $add_user_page_id ) ) {
				if ( ! is_user_logged_in() ) {
					wp_safe_redirect( $add_user_page_id . '?post_id=' . $is_post_id . '&private_doc=yes' );
				}
			}
		} 
	}
}

// Run before the headers and cookies are sent.
add_action( 'wp', 'ezd_private_login' );


/**
 * EazyDocs Login Form
 *
 * @param array $atts
 * @param array $content
 *
 * @return void
 */
add_shortcode( 'ezd_login_form', function ( $atts, $content = [] ) {
	$ezd_login_atts = shortcode_atts( [
		'login_title'      => __( 'You must log in to continue.', 'eazydocs-pro' ),
		'login_subtitle'   => __( 'Login to ' . get_bloginfo(), 'eazydocs-pro' ),
		'login_btn'        => __( 'Log In', 'eazydocs-pro' ),
		'login_forgot_btn' => __( 'Forgotten account?', 'eazydocs-pro' ),
	], $atts );

	ob_start();
	if ( is_user_logged_in() ) {
		/* Silence is golden */
	} else {
		if ( function_exists( 'eazydocs_get_template' ) ) {
			eazydocs_get_template( 'ezd-login.php', [
				'login_title'      => $ezd_login_atts['login_title'] ?? '',
				'login_subtitle'   => $ezd_login_atts['login_subtitle'] ?? '',
				'login_btn'        => $ezd_login_atts['login_btn'] ?? '',
				'login_forgot_btn' => $ezd_login_atts['login_forgot_btn'] ?? '',
			] );
		}
	}

	return ob_get_clean();
} );


/**
 *  EazyDcos login by ajax
 * Add AJAX actions for both logged in and non-logged in users
 */
add_action('wp_ajax_ezd_login_check', 'ezd_login_check');
add_action('wp_ajax_nopriv_ezd_login_check', 'ezd_login_check');

function ezd_login_check() {
    // Security check
    check_ajax_referer('eazydocs_local_nonce', 'nonce');

    // Get username and password from AJAX request
    $username = sanitize_user($_POST['log']);
    $password = sanitize_text_field($_POST['pwd']);

    // Perform your custom username and password check
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user)) {
        // Failed authentication
        $response = array('success' => false, 'message' => esc_html__('Invalid username or password', 'eazydocs'));
    } else {
        // Successful authentication
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );

        $user_signon = wp_signon($creds, false);

        if (is_wp_error($user_signon)) {
            // Failed signon
            $response = array('success' => false, 'message' => esc_html__('Login failed', 'eazydocs'));
        } else {
            // Successful signon
            $response = array('success' => true, 'message' => esc_html__('Login successful', 'eazydocs'));

            // Check if 'redirect_to' is set in $_POST
            $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : home_url();

            // Add the redirection URL to the response
            $response['redirect_to'] = $redirect_to;
        }
    }

    // Send JSON response
    wp_send_json($response);
}

add_action( 'wp_head', function () {
	$doc_login    = function_exists('ezd_get_page_by_title') ? ezd_get_page_by_title( 'Documentation Login' ) : [];
	$doc_login_id = $doc_login[0]->ID ?? '';
	?>
    <style>
        <?php echo '.page-id-'.$doc_login_id; ?>
        .ezd_doc_login_form {
            margin: auto;
            width: 515px;
        }

        <?php echo '.page-id-'.$doc_login_id; ?>
        .ezd_doc_login_wrap {
            background-color: #e9ebee;
            width: 100%;
            height: 100vh;
            display: flex;
        }

        <?php echo '.page-id-'.$doc_login_id; ?>
        .ezd_doc_login_form input {
            width: 300px
        }

        <?php echo '.page-id-'.$doc_login_id; ?>
        .ezd-login-form-wrap {
            padding: 22px 108px 26px;
        }
    </style>
<?php } );


add_action( 'wp_ajax_ezd_doc_contributor', 'ezd_doc_contributor' );
add_action( 'wp_ajax_nopriv_ezd_doc_contributor', 'ezd_doc_contributor' );
function ezd_doc_contributor( $doc_id_int ) {
	$is_doc_delete = $_POST['contributor_delete'] ?? '';
	$is_doc_add    = $_POST['contributor_add'] ?? '';

	if ( $is_doc_delete ) {

		$ezd_doc_contributor_list = get_post_meta( $_POST['data_doc_id'], 'ezd_doc_contributors', true );
		$ezd_doc_contributor_list = explode( ',', $ezd_doc_contributor_list );

		$is_doc_delete_unique = array_diff( $ezd_doc_contributor_list, [ $is_doc_delete ] );

		$is_doc_delete_ids = '';
		foreach ( $is_doc_delete_unique as $is_doc_delete_id ) {
			$is_doc_delete_ids .= $is_doc_delete_id . ',';
		}
		update_post_meta( $_POST['data_doc_id'], 'ezd_doc_contributors', $is_doc_delete_ids );
		?>

        <ul class="users_wrap_item <?php echo esc_attr( 'to-add-user-' . $is_doc_delete ); ?>" id="<?php echo esc_attr( 'to-add-user-' . $is_doc_delete ); ?>">
            <li>
                <a href='<?php echo get_author_posts_url( $is_doc_delete ); ?>'>
					<?php echo get_avatar( $is_doc_delete, '35' ); ?>
                </a>
            </li>
            <li>
                <a href='<?php echo get_author_posts_url( $is_doc_delete ); ?>'>
					<?php echo get_the_author_meta( 'display_name', $is_doc_delete ); ?>
                </a>
                <span>
					<?php echo get_the_author_meta( 'user_email', $is_doc_delete ); ?>
				</span>
            </li>
            <li>
                <a data_name="<?php echo get_the_author_meta( 'display_name', $is_doc_delete ); ?>" class="ezd_contribute_add circle-btn"
                   data-contributor-add="<?php echo esc_attr( $is_doc_delete ); ?>"
                   data-doc-id="<?php echo esc_attr( $_POST['data_doc_id'] ); ?>"> &plus; </a>
            </li>
        </ul>
		<?php
	}

	if ( $is_doc_add ) {
		$ezd_doc_contributor_list = get_post_meta( $_POST['data_doc_id'], 'ezd_doc_contributors', true );
		$ezd_doc_contributors     = $ezd_doc_contributor_list . $is_doc_add . ',';
		update_post_meta( $_POST['data_doc_id'], 'ezd_doc_contributors', $ezd_doc_contributors );
		?>
        <ul class="users_wrap_item <?php echo esc_attr( 'user-' . $is_doc_add ); ?>" id="<?php echo esc_attr( 'user-' . $is_doc_add ); ?>">
            <li>
                <a href='<?php echo get_author_posts_url( $is_doc_add ); ?>'>
					<?php echo get_avatar( $is_doc_add, '35' ); ?>
                </a>
            </li>
            <li>
                <a href='<?php echo get_author_posts_url( $is_doc_add ); ?>'>
					<?php echo get_the_author_meta( 'display_name', $is_doc_add ); ?>
                </a>
                <span>
					<?php echo get_the_author_meta( 'user_email', $is_doc_add ); ?>
				</span>
            </li>
            <li>
                <a data_name="<?php echo get_the_author_meta( 'display_name', $is_doc_add ); ?>" class="ezd_contribute_delete circle-btn"
                   data-contributor-delete="<?php echo esc_attr( $is_doc_add ); ?>"
                   data-doc-id="<?php echo esc_attr( $_POST['data_doc_id'] ); ?>">
                    &times;
                </a>
            </li>
        </ul>
		<?php
	}
	wp_die();
}

/**
 * Admin assets
 *
 * @return bool|void
 */
function ezydocspro_admin_assets() {
	$admin_page = $_GET['page'] ?? '';
	$post_type  = $_GET['post_type'] ?? '';

	if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/users.php' ) || $admin_page == 'eazydocs' || $admin_page == 'eazydocs-settings'
	     || $admin_page == 'ezd-analytics'
	     || $admin_page == 'ezd-user-feedback'
	     || $admin_page == 'ezd-user-feedback-archived'
	     || $post_type == 'onepage-docs'
	) {
		return true;
	}
}

/**
 * Number format function
 *
 * @param $number
 *
 * @return mixed|string
 */
function eazydocspro_number_format( $number ) {
	if ( $number >= 1000 && $number < 1000000 ) {
		$number = round( $number / 1000, 1 ) . 'k';
	} elseif ( $number >= 1000000 && $number < 1000000000 ) {
		$number = round( $number / 1000000, 1 ) . 'm';
	} elseif ( $number >= 1000000000 && $number < 1000000000000 ) {
		$number = round( $number / 1000000000, 1 ) . 'b';
	} elseif ( $number >= 1000000000000 ) {
		$number = round( $number / 1000000000000, 1 ) . 't';
	}

	return $number;
}

/**
 * Frontend assets
 *
 * @return bool|void
 */
function ezydocspro_frontend_assets() {
	global $post;
	$post_content_check = $post->post_content ?? '';

	if ( in_array( 'eazydocs_shortcode', get_body_class() ) || has_shortcode( $post_content_check, 'ezd_login_form' ) || is_singular( 'docs' )
	     || is_singular( 'onepage-docs' )
	) {
		return true;
	}
}

/**
 * Assistant assets
 *
 * @return bool|void
 */
function eazydocspro_assistant_assets() {
	$opt       = get_option( 'eazydocs_settings' );
	$assistant = $opt['assistant_visibility'] ?? '1';

	if ( $assistant == 1 ) {
		return true;
	}
}

// Get top level parent doc id
function get_root_parent_id( $page_id ) {
	global $wpdb;
	$parent = $wpdb->get_var( "SELECT post_parent FROM $wpdb->posts WHERE post_type='docs' AND post_status='publish' AND ID = '$page_id'" );
	if ( $parent == 0 ) {
		return $page_id;
	} else {
		return get_root_parent_id( $parent );
	}
}

/**
 * Assign parent to new doc
 *
 * @param string  $post_content
 * @param WP_Post $post
 *
 * @return string
 */
function ezd_assign_parent_to_new_doc( $post_content, $post ) {
	if ( $post->post_type != 'docs' ) {
		return $post_content;
	}

	if ( isset($_GET['add_new_doc']) && isset($_GET['ezd_doc_order']) ) {
		$post->post_parent 	= $_GET['ezd_doc_parent'] ?? ''; // Parent post_id goes here
		$post->menu_order  .= $_GET['ezd_doc_order'] ?? ''; // Total child posts counter as order goes here
		wp_update_post( $post );
	}
	
	return $post_content;
}

add_filter( 'default_content', 'ezd_assign_parent_to_new_doc', 10, 2 );

// Register image size for embed post
add_image_size( 'ezd_embed_thumb', 100, 100, true );

/**
 * Get contributors
 */
function load_more_contributors() {

	$users = get_users([
		'number' 	=> $_POST['loaditems'] ?? '',
		'paged' 	=> $_POST['page'] ?? '',
		'exclude' 	=> $_POST['exclude'] ?? ''
	]);
	
	if ( ! empty( $users ) ) :
		foreach ($users as $user ) :
			?>
			<ul class="users_wrap_item to-add-<?php echo esc_attr('user-'.$user->ID); ?>"
				id="to-add-<?php echo esc_attr('user-'.$user->ID); ?>">
				<li>
					<a href='<?php echo get_author_posts_url($user->ID); ?>'>
						<?php echo get_avatar($user->ID, '35'); ?>
					</a>
				</li>
				<li>
					<a href='<?php echo get_author_posts_url($user->ID); ?>'>
						<?php echo $user->display_name ?? ''; ?>
					</a>
					<span> <?php echo $user->user_email ?? ''; ?> </span>
				</li>
				<li>
					<a data_name="<?php echo get_the_author_meta( 'display_name', $user->ID ); ?>" class="circle-btn ezd_contribute_add" data-contributor-add="<?php echo esc_attr($user->ID); ?>" data-doc-id="<?php echo esc_attr(get_the_ID()); ?>">
						&plus;
					</a>
				</li>
			</ul>
			<?php
		endforeach;
	endif;
	die;
}
add_action( 'wp_ajax_load_more_contributors', 'load_more_contributors' );
add_action( 'wp_ajax_nopriv_load_more_contributors', 'load_more_contributors' );