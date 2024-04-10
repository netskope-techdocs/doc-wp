<?php
global $wpdb;
$date_range = strtotime( '-7 day' );
//  get views from wp eazy docs views table and post type docs and sum count
$posts = $wpdb->get_results( "SELECT post_id, SUM(count) AS totalcount, created_at FROM {$wpdb->prefix}eazydocs_view_log WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY post_id" );

// get data from wp_eazydocs_search_log base on $date_range with prefix
$search_keyword = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}eazydocs_search_log WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" );

// get total search count from wp_eazydocs_search_log table and check if empty then set 0
$total_search = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}eazydocs_search_log" );
if ( empty( $total_search ) ) {
	$total_search = 0;
}

// Get total failed searches from wp_eazydocs_search_log
$total_failed_search = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}eazydocs_search_log WHERE not_found_count > 0" );
if ( empty( $total_failed_search ) ) {
    $total_failed_search = 0;
}

// get total positive feedback count from wp meta table and check if empty then set 0
$total_positive_feedback = $wpdb->get_var( "SELECT SUM(meta_value) FROM {$wpdb->prefix}postmeta WHERE meta_key = 'positive'" );
if ( empty( $total_positive_feedback ) ) {
	$total_positive_feedback = 0;
}

// get total negative feedback count from wp meta table and check if empty then set 0
$total_negative_feedback = $wpdb->get_var( "SELECT SUM(meta_value) FROM {$wpdb->prefix}postmeta WHERE meta_key = 'negative'" );
if ( empty( $total_negative_feedback ) ) {
	$total_negative_feedback = 0;
}

$labels              = [];
$dataCount           = [];
$Liked               = [];
$Disliked            = [];
$searchCount         = [];
$searchCountNotFound = [];

$m  = date( "m" );
$de = date( "d" );
$y  = date( "Y" );

for ( $i = 0; $i <= 6; $i ++ ) {
	$labels[]              = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	$dataCount[]           = 0;
	$Liked[]               = 0;
	$Disliked[]            = 0;
	$searchCount[]         = 0;
	$searchCountNotFound[] = 0;
}

// Get 7 data date wise
foreach ( $posts as $key => $item ) {
	$dates = date( 'd M, Y', strtotime( $item->created_at ) );

	foreach ( $labels as $datekey => $weekdays ) {
		if ( $weekdays == $dates ) {
			$Liked[ $datekey ]    = $Liked[ $datekey ] + array_sum( get_post_meta( $item->post_id, 'positive', false ) );
			$Disliked[ $datekey ] = $Disliked[ $datekey ] + array_sum( get_post_meta( $item->post_id, 'negative', false ) );
			
			$searchCount[ $datekey ]         = array_sum( array_column( $search_keyword, 'count' ) );
			$searchCountNotFound[ $datekey ] = array_sum( array_column( $search_keyword, 'not_found_count' ) );

		}
	}
}

// re-tweaked the views              
$eazydocs_view_table = $wpdb->prefix . 'eazydocs_view_log'; // Assuming the table has a prefix
// Perform the query
$results = $wpdb->get_results("SELECT `count`, `created_at` FROM $eazydocs_view_table", ARRAY_A);

// Output the results
$rowValues = array();
foreach ($results as $row) {
    $rowValues[$row['created_at']] = $row['count'];
}

$totalValues = array();

// Loop through the data and sum up the values for each date
foreach ($rowValues as $dateTime => $value) {
    $date = explode(' ', $dateTime)[0]; // Extract the date part
    if (isset($totalValues[$date])) {
        $totalValues[$date] += $value;
    } else {
        $totalValues[$date] = $value;
    }
}

// Output the total values
$dataCounts = array();
foreach ($totalValues as $date => $total) {
    $dataCounts[$date] = $total;
}

// Get the current date
$currentDate = date('Y-m-d');

// Iterate over the past 7 days
for ($i = 0; $i <= 6; $i++) {
    $date = date('Y-m-d', strtotime("-$i days"));

    // If the date exists in your data, add its value to the sum
    if (isset($dates[$date])) {
        if (!isset($dataCounts[$i])) {
            $dataCounts[$i] = 0;
        }
        $dataCounts[$i] += $dates[$date];
    }
}
for ( $i = 0; $i <= 29; $i ++ ) {
	$labels[]    = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	$monthlyViews[] = 0;
}

// Output the results
foreach ($dataCounts as $day => $sum) {
    // echo "Day $day: $sum<br>";

    $dataCounts[$day] = $sum;
}

$currentDate = date('Y-m-d');
// Iterate over the dates and reorganize the keys
foreach ($dataCounts as $date => $value) {
    $daysDifference = floor((strtotime($currentDate) - strtotime($date)) / (60 * 60 * 24));
    if ($daysDifference >= 0 && $daysDifference <= 6) {
        $dataCount[$daysDifference] = $value;
    }

    if ($daysDifference >= 0 && $daysDifference <= 29) {
        $monthlyViews[$daysDifference] = $value;
    }
}

?>

<div class="easydocs-tab tab-active" id="analytics-overview">
    <h2 class="title"> <?php esc_html_e( 'Analytics Overview', 'eazydocs-pro' ); ?> </h2> <br>
    <div class="easydocs-filter-container">
        <ul class="single-item-filter">
            <li>
                <!-- Label  -->
                <div class="checkbox ezd-docs-checkbox chartoverview">
                    <label for="views">
                        <input type="checkbox" name="filterChart" value="Views" id="views" checked/>
						<?php esc_html_e( 'Views', 'eazydocs-pro' ); ?>
                    </label>
                    <label for="feedback">
                        <input type="checkbox" name="filterChart" value="Feedback" id="feedback" checked/>
						<?php esc_html_e( 'Feedback', 'eazydocs-pro' ); ?>
                    </label>
                    <label for="searches">
                        <input type="checkbox" name="filterChart" value="Searches" id="searches" checked/>
						<?php esc_html_e( 'Searches', 'eazydocs-pro' ); ?>
                    </label>
                </div>
            </li>
            <li class="easydocs-btn easydocs-btn-blue-light easydocs-btn-rounded easydocs-btn-sm is-active" data-filter="all" onclick="OverviewAllTimes()">
				<?php esc_html_e( 'This Week', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-orange-light easydocs-btn-rounded easydocs-btn-sm" data-filter=".lastmonth" onclick="OverviewLastmonth()">
				<?php esc_html_e( 'Last Month', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-gray-light easydocs-btn-rounded easydocs-btn-sm date__range_overview"
                data-filter=".customdate"> <?php esc_html_e( 'Custom Date Range', 'eazydocs-pro' ); ?> </li>
        </ul>
    </div>
    <div class="easydocs-accordion sortabled dd accordionjs nestables-child">
        <div id="OvervIewChart"></div>
        <div class="eazydocc-chartsummery">
            <div class="easydocs-accordion ezdw-50">
                <h3> <?php esc_html_e( 'Article Feedback', 'eazydocs-pro' ); ?> </h3>
                <div class="eazy-docs-row">
                    <div class="easydocs-card easy-docs-card-bg-light">
                        <div class="easydocs-card-body">
                            <div class="easydocs-card-title positive-feedback t-success">
								<?php echo eazydocspro_number_format( $total_positive_feedback ); ?>
                            </div>
                            <div class="easydocs-card-value">
								<?php esc_html_e( 'Voted Helpful', 'eazydocs-pro' ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="easydocs-card easy-docs-card-bg-light">
                        <div class="easydocs-card-body">
                            <div class="easydocs-card-title negative-feedback t-danger">
                                <?php echo eazydocspro_number_format( $total_negative_feedback ); ?>
                            </div>
                            <div class="easydocs-card-value">
								<?php esc_html_e( 'Voted Not Helpful', 'eazydocs-pro' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="eazy-docs-row">
                    <h4 class="easydocs-summery-value article-feedback">
                        <span class="dashicons dashicons-smiley t-success"></span>
						<?php esc_html_e( 'Article Feedback', 'eazydocs-pro' ); ?>
                    </h4>
                </div>
            </div>

            <div class="easydocs-accordion ezdw-50">
                <h3> <?php esc_html_e( 'Search Effectiveness', 'eazydocs-pro' ); ?> </h3>
                <div class="eazy-docs-row">
                    <div class="easydocs-card easy-docs-card-bg-light">
                        <div class="easydocs-card-body">
                            <div class="easydocs-card-title total-search t-success">
								<?php echo eazydocspro_number_format( $total_search ); ?>
                            </div>
                            <div class="easydocs-card-value">
								<?php esc_html_e( 'Total Searches', 'eazydocs-pro' ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="easydocs-card easy-docs-card-bg-light">
                        <div class="easydocs-card-body">
                            <div class="easydocs-card-title total-search t-danger">
								<?php echo eazydocspro_number_format( $total_failed_search ); ?>
                            </div>
                            <div class="easydocs-card-value">
								<?php esc_html_e( 'Failed Searches', 'eazydocs-pro' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="eazy-docs-row">
                    <!-- Total summary heading and icon -->
                    <h4 class="easydocs-summery-value search-effectiveness">
                        <span class="dashicons dashicons-smiley t-success"></span>
						<?php esc_html_e( '0% Search Effectiveness', 'eazydocs-pro' ); ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fetch apexchartjs area chart in #OvervIewChart
    var options = {
        chart: {
            height: 450,
            type: 'area',
        },
        dataLabels: {
            enabled: false
        },
        series: [
            {
                name: "Views",
                data: <?php echo json_encode( $dataCount ); ?>
            },
            {
                name: "Feedback",
                data: <?php echo json_encode( $Liked + $Disliked ); ?>
            },
            {
                name: "Searches",
                data: <?php echo json_encode( $searchCount ); ?>
            }
        ],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: <?php echo json_encode( $labels ); ?>,
        },
        tooltip: {
            // x: {
            //     format: 'dd/MM/yy HH:mm'
            // },
        },
    };

    var Overviewchart = new ApexCharts(document.querySelector("#OvervIewChart"), options);
    Overviewchart.render();

    // Count Overviewchart in positive-feedback
    var positive_feedback = document.querySelector(".positive-feedback");
    positive_feedback = <?php echo $total_positive_feedback; ?>;

    // Count and sum negative-feedback of Disliked
    var negative_feedback = document.querySelector(".negative-feedback");
    negative_feedback = <?php echo $total_negative_feedback; ?>;

    // Count and sum total-views of dataCount
    var failed_searches = <?php echo $total_failed_search; ?>;

    // Count and sum total-search of total_search
    var total_search = document.querySelector(".total-search");
    total_search = <?php echo $total_search; ?>;

    // Article feedback of article-feedback if positive_feedback is greater than negative_feedback change value of article-feedback to percentage
    var article_feedback = document.querySelector(".article-feedback");
    if (positive_feedback > 0 || negative_feedback > 0) {
        if (positive_feedback > negative_feedback) {
            article_feedback.innerHTML = '<span class="dashicons dashicons-smiley t-success"></span> ' + Math.round(positive_feedback / (positive_feedback + negative_feedback) * 100) + '% Article Success';
        } else {
            article_feedback.innerHTML = '<span class="dashicons dashicons-smiley t-danger"></span> ' + Math.round(negative_feedback / (negative_feedback + positive_feedback) * 100) + '% Article Success';
        }
    } else {
        article_feedback.innerHTML = '';
    }

    // search-effectiveness if total-views is greater than negative_feedback change value of search-effectiveness to percentage
    var search_effectiveness = document.querySelector(".search-effectiveness");
    if (failed_searches > 0 || total_search > 0) {
        if (failed_searches > total_search) {
            search_effectiveness.innerHTML = '<span class="dashicons dashicons-smiley t-danger"></span> ' + Math.round(failed_searches / (parseInt(failed_searches) + parseInt(total_search)) * 100) + '% Search Effectiveness';
        } else {
            search_effectiveness.innerHTML = '<span class="dashicons dashicons-smiley t-success"></span> ' + Math.round(total_search / (parseInt(failed_searches) + parseInt(total_search)) * 100) + '% Search Effectiveness';
        }
    } else {
        search_effectiveness.innerHTML = '';
    }

    // .ezd-docs-checkbox each input[type=checkbox] check then alert
    var ezd_docs_checkbox = document.querySelectorAll(".chartoverview input[type=checkbox]");
    ezd_docs_checkbox.forEach(function (ezd_docs_checkbox) {
        ezd_docs_checkbox.addEventListener("change", function () {
            if (this.checked) {
                Overviewchart.showSeries(this.value);
            } else {
                Overviewchart.hideSeries(this.value);
            }
        });
    });

    function OverviewAllTimes() {
        // Update the apexchart in liked and disliked OverviewTabs
        Overviewchart.updateSeries([

            {
                name: 'Views',
                data: <?php echo json_encode( $dataCount ); ?>
            },
            {
                name: 'Feedback',
                data: <?php echo json_encode( $Liked ); ?>
            },
            {
                name: 'Searches',
                data: <?php echo json_encode( array_reverse( $searchCount ) ); ?>
            }

        ])
    }


    function OverviewLastmonth() {
		<?php
		global $wpdb;
		$date_range = strtotime( '-29 day' );

		//  get views from wp eazy docs views table and post type docs and sum count
		$posts = $wpdb->get_results( "SELECT post_id, SUM(count) AS totalcount, created_at FROM {$wpdb->prefix}eazydocs_view_log WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY post_id" );

		// get data from wp_eazydocs_search_log base on $date_range with prefix
		$search_keyword = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}eazydocs_search_log WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" );


		$labels = [];
 
		$Liked = [];
		$Disliked = [];
		$searchCount = [];
		$searchCountNotFound = [];

		$m = date( "m" );
		$de = date( "d" );
		$y = date( "Y" );

		for ( $i = 0; $i <= 29; $i ++ ) {
			$labels[]              = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	 
			$Liked[]               = 0;
			$Disliked[]            = 0;
			$searchCount[]         = 0;
			$searchCountNotFound[] = 0;
		}

		foreach ( $posts as $key => $item ) {
			$dates = date( 'd M, Y', strtotime( $item->created_at ) );

			foreach ( $labels as $datekey => $weekdays ) {
				# code...
				if ( $weekdays == $dates ) {
					$Liked[ $datekey ]    = $Liked[ $datekey ] + array_sum( get_post_meta( $item->post_id, 'positive', false ) );
					$Disliked[ $datekey ] = $Disliked[ $datekey ] + array_sum( get_post_meta( $item->post_id, 'negative', false ) );
					
					$searchCount[ $datekey ]         = array_sum( array_column( $search_keyword, 'count' ) );
					$searchCountNotFound[ $datekey ] = array_sum( array_column( $search_keyword, 'not_found_count' ) );
				}
			}
		}

		?>

        Overviewchart.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [{
                name: 'Views',
                data: <?php echo json_encode( $monthlyViews ); ?>
            },
                {
                    name: 'Feedback',
                    data: <?php echo json_encode( $Liked ); ?>
                },
                {
                    name: 'Searches',
                    data: <?php echo json_encode( $searchCount ); ?>
                }],
        });
    }

    // Function OverviewDateRange
    function OverViewDateRange() {
        jQuery('.date__range_overview').daterangepicker().on('apply.daterangepicker', function (e, picker) {
            var startDate = picker.startDate.format('Y-M-D');
            var endDate = picker.endDate.format('Y-M-D');

            // console.log(startDate +" To "+ endDate);

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                data: {action: "edz_filter_overview_date", startDate: startDate, endDate: endDate},
                success: function (response) {
                    Overviewchart.updateOptions({
                        xaxis: {
                            categories: response.data.labels,
                        },
                        series: [{
                            name: 'Views',
                            data: response.data.views
                        },
                            {
                                name: 'Feedback',
                                data: response.data.liked
                            },
                            {
                                name: 'Searches',
                                data: response.data.searchCount
                            }],
                    });
                }
            });
        })
    }

    OverViewDateRange();
</script>