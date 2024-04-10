<?php
// Overview Chart filer by date range
function edz_filter_overview_date() {
	global $wpdb;
	$start_date = sanitize_text_field( $_POST['startDate'] );
	$end_date   = sanitize_text_field( $_POST['endDate'] );

	$posts
		= $wpdb->get_results( "SELECT post_id, SUM(count) AS totalcount, created_at FROM {$wpdb->prefix}eazydocs_view_log WHERE created_at BETWEEN '$start_date' AND '$end_date' GROUP BY post_id" );

	// get data from wp_eazydocs_search_log base on $start_date and $end_date with prefix
	$prefix              = $wpdb->prefix;
	$eazydocs_search_log = $prefix . 'eazydocs_search_log';
	$eazydocs_search_log_data
	                     = $wpdb->get_results( "SELECT * FROM $eazydocs_search_log WHERE created_at BETWEEN '$start_date' AND '$end_date' GROUP BY created_at" );

	$labels              = [];
	$ViewsCount          = [];
	$Liked               = [];
	$Disliked            = [];
	$searchCount         = [];
	$searchCountNotFound = [];

	$m  = date( "m" ); //current month
	$de = date( "d" ); //current day
	$y  = date( "Y" ); //current year

	// Generating apexChart labels
	$datediff = strtotime( $end_date ) - strtotime( $start_date );
	$datediff = floor( $datediff / ( 60 * 60 * 24 ) );

	for ( $i = 0; $i < $datediff + 1; $i ++ ) {
		$labels[]              = date( "Y-m-d", strtotime( $start_date . ' + ' . $i . 'day' ) );
		$ViewsCount[]          = 0;
		$Liked[]               = 0;
		$Disliked[]            = 0;
		$searchCount[]         = 0;
		$searchCountNotFound[] = 0;
	}

	// Get 7 data date wise
	foreach ( $posts as $key => $item ) {
		$dates = date( 'Y-m-d', strtotime( $item->created_at ) );

		foreach ( $labels as $datekey => $weekdays ) {
			if ( $weekdays == $dates ) {
				$Liked[ $datekey ]    = $Liked[ $datekey ] + (int) get_post_meta( $item->post_id, 'positive', false );
				$Disliked[ $datekey ] = $Disliked[ $datekey ] + (int) get_post_meta( $item->post_id, 'negative', false );
				if ( get_post_meta( $item->post_id, 'post_views_count', true ) ) {
					$ViewsCount[ $datekey ] = $item->totalcount;
				} else {
					$ViewsCount[ $datekey ] = $item->totalcount;
				}
			}

			// if $weekdays equal to array data $eazydocs_search_log_data created_at then add count and not_found_count
			if ( $weekdays == date( 'Y-m-d', strtotime( $eazydocs_search_log_data[ $datekey ]->created_at ) ) ) {
				$searchCount[ $datekey ]         = $searchCount[ $datekey ] + $eazydocs_search_log_data[ $datekey ]->count;
				$searchCountNotFound[ $datekey ] = $searchCountNotFound[ $datekey ] + $eazydocs_search_log_data[ $datekey ]->not_found_count;
			}
		}
	}

	wp_send_json_success( array(
		'labels'              => $labels,
		'views'               => $ViewsCount,
		'liked'               => $Liked,
		'disliked'            => $Disliked,
		'searchCount'         => $searchCount,
		'searchCountNotFound' => $searchCountNotFound
	) );
	wp_die();  //die();
}
add_action( 'wp_ajax_edz_filter_overview_date', 'edz_filter_overview_date' );

// View Chart action by date range
function ezd_view_date_range_data() {
	global $wpdb;

	$start_date = $_POST['start_date'];
	$end_date   = $_POST['end_date'];

	$posts = $wpdb->get_results( "SELECT post_id, SUM(count) AS totalcount, created_at FROM {$wpdb->prefix}eazydocs_view_log WHERE created_at BETWEEN '$start_date' AND '$end_date' GROUP BY post_id" );
 

	$labels     = [];
	$ViewsCount = [];

	$m  = date( "m" ); //current month
	$de = date( "d" ); //current day
	$y  = date( "Y" ); //current year

	// Generating apexChart labels
	$datediff = strtotime( $end_date ) - strtotime( $start_date );
	$datediff = floor( $datediff / ( 60 * 60 * 24 ) );

	for ( $i = 0; $i < $datediff + 1; $i ++ ) {
		$labels[]     = date( "Y-m-d", strtotime( $start_date . ' + ' . $i . 'day' ) );
		$ViewsCount[] = 0;
	}


	foreach ( $posts as $key => $item ) {
		$dates = date( 'Y-m-d', strtotime( $item->created_at ) );

		foreach ( $labels as $datekey => $weekdays ) {
			if ( $weekdays == $dates ) {
				if ( get_post_meta( $item->post_id, 'post_views_count', true ) ) {
					$ViewsCount[ $datekey ] = $item->totalcount;
				}
			}
		}

	}


	wp_reset_postdata();

	wp_send_json_success( array( 'labels' => $labels, 'views' => $ViewsCount ) );
	wp_die();  //die();
}
add_action( 'wp_ajax_ezd_view_date_range_data', 'ezd_view_date_range_data' );

// Feedback Chart action by date range
function ezd_filter_date_from_feedback() {
	global $wpdb;

	$start_date = sanitize_text_field( $_POST['startDate'] );
	$end_date   = sanitize_text_field( $_POST['endDate'] );

	$start_date = date( 'Y-m-d', strtotime( $start_date ) );
	$end_date   = date( 'Y-m-d', strtotime( $end_date ) );

	// get wp_postmeta base on $start_date and $end_date and post_type = docs and meta_key = positive_time and negative_time where between $start_date and $end_date
	$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'docs') AND meta_key IN ('positive_time', 'negative_time') AND meta_value BETWEEN '$start_date' AND '$end_date' ORDER BY meta_value DESC" );

	$labels   = [];
	$Liked    = [];
	$Disliked = [];

	$m  = date( "m" ); //current month
	$de = date( "d" ); //current day
	$y  = date( "Y" ); //current year

	// Generating apexChart labels
	$datediff = strtotime( $end_date ) - strtotime( $start_date );
	$datediff = floor( $datediff / ( 60 * 60 * 24 ) );

	for ( $i = 0; $i < $datediff + 1; $i ++ ) {
		$labels[]   = date( "Y-m-d", strtotime( $start_date . ' + ' . $i . 'day' ) );
		$Liked[]    = 0;
		$Disliked[] = 0;
	}

	// Get 7 data date wise
	foreach ( $posts as $key => $item ) {
		$dates = date( 'Y-m-d', strtotime( $item->meta_value ) );

		foreach ( $labels as $datekey => $weekdays ) {
			# code...
			if ( $weekdays == date( 'Y-m-d', strtotime( $item->meta_value ) ) ) {
				// sum of positive_time and negative_time
				if ( $item->meta_key == 'positive_time' ) {
					$Liked[ $datekey ] = $Liked[ $datekey ] + 1;
				} else {
					$Disliked[ $datekey ] = $Disliked[ $datekey ] + 1;
				}

			}
		}
	}

	wp_send_json_success( array( 'labels' => $labels, 'liked' => $Liked, 'disliked' => $Disliked ) );
	wp_die();  //die();
}
add_action( 'wp_ajax_ezd_filter_date_from_feedback', 'ezd_filter_date_from_feedback' );

// Search Chart action by date range
function ezd_filter_date_from_search() {
	global $wpdb;

	$start_date = sanitize_text_field( $_POST['startDate'] );
	$end_date   = sanitize_text_field( $_POST['endDate'] );

	$search_keyword
		= $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}eazydocs_search_log WHERE created_at BETWEEN '$start_date' AND '$end_date' ORDER BY created_at DESC" );

	$labels              = [];
	$total_search        = [];
	$searchCount         = [];
	$searchCountNotFound = [];

	$m  = date( "m" ); //current month
	$de = date( "d" ); //current day
	$y  = date( "Y" ); //current year

	// Generating apexChart labels
	$datediff = strtotime( $end_date ) - strtotime( $start_date );
	$datediff = floor( $datediff / ( 60 * 60 * 24 ) );

	for ( $i = 0; $i < $datediff + 1; $i ++ ) {
		$labels[]              = date( "Y-m-d", strtotime( $start_date . ' + ' . $i . 'day' ) );
		$total_search[]        = 0;
		$searchCount[]         = 0;
		$searchCountNotFound[] = 0;
	}


	// Get 7 data date wise
	foreach ( $search_keyword as $key => $item ) {

		foreach ( $labels as $datekey => $weekdays ) {
			if ( $weekdays == date( 'Y-m-d', strtotime( $item->created_at ) ) ) {
				$total_search[ $datekey ]        = count( $search_keyword );
				$searchCount[ $datekey ]         = array_sum( array_column( $search_keyword, 'count' ) );
				$searchCountNotFound[ $datekey ] = array_sum( array_column( $search_keyword, 'not_found_count' ) );
			}
		}

	}

	wp_send_json_success( array(
		'labels'              => $labels,
		'searchCount'         => $searchCount,
		'totalSearch'         => $total_search,
		'searchCountNotFound' => $searchCountNotFound
	) );
	wp_die();  //die();
}
add_action( 'wp_ajax_ezd_filter_date_from_search', 'ezd_filter_date_from_search' );


/**
 * Search Helpful Docs
 */
add_action( 'wp_ajax_ezd_search_helpful_docs_paginate', 'ezd_search_helpful_docs_paginate' );
add_action( 'wp_ajax_nopriv_ezd_search_helpful_docs_paginate', 'ezd_search_helpful_docs_paginate' );
function ezd_search_helpful_docs_paginate() {
	$type = isset( $_GET['type'] ) ? $_GET['type'] : 'most_helpful';

	if ( $type == 'most_helpful' ) {
		if ( isset( $_GET['total_page'] ) ) {
			$total_page = intval( $_GET['total_page'] );

			$posts = get_posts( [ 'post_type' => 'docs', 'posts_per_page' => - 1, 'inclusive' => true ] );

			$post_data = [];
			foreach ( $posts as $key => $post ) {
				$post_data[ $key ]['post_id']        = $post->ID;
				$post_data[ $key ]['post_title']     = $post->post_title;
				$post_data[ $key ]['post_edit_link'] = get_edit_post_link( $post->ID );
				$post_data[ $key ]['post_permalink'] = get_permalink( $post->ID );
				// sum of total positive votes for a post
				$post_data[ $key ]['positive_time'] = array_sum( get_post_meta( $post->ID, 'positive', false ) );

				$post_data[ $key ]['negative_time'] = array_sum( get_post_meta( $post->ID, 'negative', false ) );
			}
			// if post has positive_time number large then negative_time number then show large number first
			usort( $post_data, function ( $a, $b ) {
				return $b['positive_time'] <=> $a['positive_time'];
			} );

			foreach ( $post_data as $key => $post ) {
				if ( $post['positive_time'] > 0 ) {
					if ( $key >= 0 && $key <= $total_page ) {
						?>
                        <li class="dd-item dd3-item dd-item-parent easydocs-accordion-item  ez-section-acc-item type-docs"
                            data-id="<?php echo $post['post_id']; ?>">
                            <div class="dd3-content">
                                <div class="accordion-title ez-section-title expand--child has-child">
                                    <div class="left-content">
										<?php
										$edit_link = 'javascript:void(0)';
										$target    = '_self';
										if ( current_user_can( 'publish_pages' ) ) {
											$edit_link = $post['post_edit_link'];
											$target    = '_blank';
										}
										?>
                                        <h4>
                                            <a href="<?php echo esc_attr( $edit_link ); ?>" target="<?php echo esc_attr( $target ); ?>">
												<?php echo $post['post_title']; ?>
                                            </a>
                                        </h4>
                                        <ul class="actions">
                                            <li>
                                                <a href="<?php echo $post['post_permalink']; ?>" target="_blank"
                                                   title="<?php esc_attr_e( 'View this doc item in new tab', 'eazydocs-pro' ) ?>">
                                                    <span class="dashicons dashicons-external"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="right-content">
										<?php
										$positive = $post['positive_time'];
										$negative = $post['negative_time'];

										$positive_title = $positive ? sprintf( _n( '%d Positive vote, ', '%d Positive votes and ', $positive, 'eazydocs-pro' ),
											number_format_i18n( $positive ) ) : esc_html__( 'No Positive votes, ', 'eazydocs-pro' );
										$negative_title = $negative ? sprintf( _n( '%d Negative vote found.', '%d Negative votes found.', $negative,
											'eazydocs-pro' ), number_format_i18n( $negative ) ) : esc_html__( 'No Negative votes.', 'eazydocs-pro' );

										$positive_icon = '';
										if ( $positive || $negative ) {
											$positive_icon
												           = '<div class="votes"> <div class="like"> <span class="t-success dashicons dashicons-thumbs-up"></span> '
												             . $positive . '</div>';
											$positive_icon .= $negative > 0
												? '<div class="dislike"> <span class="t-danger dashicons dashicons-thumbs-down"></span> ' . $negative . '</div>'
												: '';
											$positive_icon .= '</div>';
										}

										$sum_votes = $positive + $negative;
										echo $positive_icon;
										?>
                                        <span class="progress-text">
										<?php
										if ( $positive || $negative ) {
											echo "<progress id='file' value='$positive' max='$sum_votes' title='$positive_title$negative_title'> </progress>";
										} else {
											esc_html_e( 'No rates', 'eazydocs-pro' );
										}
										?>
									</span>
                                    </div>
                                </div>
                            </div>
                        </li>
						<?php
					}
				}
			}

			wp_reset_postdata();

		} else {
			// Return an error message if the total_page parameter is not set
			echo 'Error: total_page parameter is missing';
		}
	} else {
		if ( isset( $_GET['total_page'] ) ) {
			$total_page = intval( $_GET['total_page'] );

			$posts = get_posts( [ 'post_type' => 'docs', 'posts_per_page' => - 1, 'inclusive' => true ] );

			$post_data = [];
			foreach ( $posts as $key => $post ) {
				$post_data[ $key ]['post_id']        = $post->ID;
				$post_data[ $key ]['post_title']     = $post->post_title;
				$post_data[ $key ]['post_edit_link'] = get_edit_post_link( $post->ID );
				$post_data[ $key ]['post_permalink'] = get_permalink( $post->ID );
				// sum of total positive votes for a post
				$post_data[ $key ]['positive_time'] = array_sum( get_post_meta( $post->ID, 'positive', false ) );

				$post_data[ $key ]['negative_time'] = array_sum( get_post_meta( $post->ID, 'negative', false ) );
			}
			// if post has positive_time number large then negative_time number then show large number first
			usort( $post_data, function ( $a, $b ) {
				return $b['negative_time'] <=> $a['negative_time'];
			} );

			foreach ( $post_data as $key => $post ) {
				if ( $post['negative_time'] > 0 ) {
					if ( $key >= 0 && $key <= $total_page ) {
						?>
                        <li class="dd-item dd3-item dd-item-parent easydocs-accordion-item  ez-section-acc-item type-docs"
                            data-id="<?php echo $post['post_id']; ?>">
                            <div class="dd3-content">
                                <div class="accordion-title ez-section-title expand--child has-child">
                                    <div class="left-content">
										<?php
										$edit_link = 'javascript:void(0)';
										$target    = '_self';
										if ( current_user_can( 'publish_pages' ) ) {
											$edit_link = $post['post_edit_link'];
											$target    = '_blank';
										}
										?>
                                        <h4>
                                            <a href="<?php echo esc_attr( $edit_link ); ?>" target="<?php echo esc_attr( $target ); ?>">
												<?php echo $post['post_title']; ?>
                                            </a>
                                        </h4>
                                        <ul class="actions">
                                            <li>
                                                <a href="<?php echo $post['post_permalink']; ?>" target="_blank"
                                                   title="<?php esc_attr_e( 'View this doc item in new tab', 'eazydocs-pro' ) ?>">
                                                    <span class="dashicons dashicons-external"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="right-content">
										<?php
										$positive = $post['positive_time'];
										$negative = $post['negative_time'];

										$positive_title = $positive ? sprintf( _n( '%d Positive vote, ', '%d Positive votes and ', $positive, 'eazydocs-pro' ),
											number_format_i18n( $positive ) ) : esc_html__( 'No Positive votes, ', 'eazydocs-pro' );
										$negative_title = $negative ? sprintf( _n( '%d Negative vote found.', '%d Negative votes found.', $negative,
											'eazydocs-pro' ), number_format_i18n( $negative ) ) : esc_html__( 'No Negative votes.', 'eazydocs-pro' );

										$positive_icon = '';
										if ( $positive | $negative ) {
											$positive_icon .= '<div class="votes">';
											$positive_icon .= $positive > 0 ? '<div class="like"> <span class="t-success dashicons dashicons-thumbs-up"></span>'
											                                  . $positive . '</div>' : '';
											$positive_icon .= '<div class="dislike"> <span class="t-danger dashicons dashicons-thumbs-down"></span> '
											                  . $negative . '</div>';
											$positive_icon .= '</div>';
										}

										$sum_votes = $positive + $negative;
										echo $positive_icon;
										?>
                                        <span class="progress-text">
									<?php
									if ( $positive || $negative ) {
										echo "<progress id='file' value='$positive' max='$sum_votes' title='$positive_title$negative_title'> </progress>";
									} else {
										esc_html_e( 'No rates', 'eazydocs-pro' );
									}
									?>
									</span>
                                    </div>
                                </div>
                            </div>
                        </li>
						<?php
					}

				}
			}
		} else {
			// Return an error message if the total_page parameter is not set
			echo 'Error: total_page parameter is missing';
		}
	}
	wp_die(); // Always remember to call wp_die() after sending an AJAX response
}