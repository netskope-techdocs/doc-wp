<?php
global $wpdb;

$date_range = strtotime( '-7 day' ); // 7 days ago
$today_date = date( 'Y-m-d' ); // today date

$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'docs') AND meta_key IN ('positive_time', 'negative_time') AND meta_value BETWEEN $today_date AND UNIX_TIMESTAMP() ORDER BY meta_value DESC" );

// get total positive and negative feedback
$totalPost = $wpdb->get_results( "SELECT COUNT(*) as total, meta_key FROM {$wpdb->prefix}postmeta WHERE post_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'docs') AND meta_key IN ('positive_time', 'negative_time') GROUP BY meta_key" );
$totalPost = array_column( $totalPost, 'total', 'meta_key' );

$labels             = [];
$Liked              = [];
$Disliked           = [];
$total_liked        = $totalPost['positive_time'] ?? '';
$total_disliked     = $totalPost['negative_time'] ?? '';

$m  = date( "m" );
$de = date( "d" );
$y  = date( "Y" );

for ( $i = 0; $i <= 6; $i ++ ) {
	$labels[]   = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	$Liked[]    = 0;
	$Disliked[] = 0;
}

// Get 7 data date wise
foreach ( $posts as $key => $item ) {
	$dates = date( 'd M, Y', strtotime( $item->meta_value ) );

	foreach ( $labels as $datekey => $weekdays ) {
		if ( $weekdays == date( 'd M, Y', strtotime( $item->meta_value ) ) ) {
			if ( $item->meta_key == 'positive_time' ) {
				$Liked[ $datekey ] = $Liked[ $datekey ] + 1;
			} else {
				$Disliked[ $datekey ] = $Disliked[ $datekey ] + 1;
			}
		}
	}
}
?>
<div class="easydocs-tab tab-active" id="analytics-feedback">

    <h2 class="title"> <?php esc_html_e( 'Feedback Analytics', 'eazydocs-pro' ); ?> </h2> <br>

    <div class="easydocs-filter-container">
        <ul class="single-item-filter">
            <li>
                <!-- Label  -->
                <div class="checkbox ezd-docs-checkbox feedbackchart">
                    <label for="positive_feedback">
                        <input type="checkbox" name="filterChart" value="Positive" id="positive_feedback" checked/>
						<?php esc_html_e( 'Positive', 'eazydocs-pro' ); ?>
                    </label>
                    <label for="negative_feedback">
                        <input type="checkbox" name="filterChart" value="Negative" id="negative_feedback" checked/>
						<?php esc_html_e( 'Negative', 'eazydocs-pro' ); ?>
                    </label>
                </div>
            </li>
            <li class="easydocs-btn easydocs-btn-blue-light easydocs-btn-rounded easydocs-btn-sm is-active" data-filter="all" onclick="AllSewvenDaysFeedback()">
				<?php esc_html_e( 'This Week', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-orange-light easydocs-btn-rounded easydocs-btn-sm" onclick="FeedbackLastMonth()">
				<?php esc_html_e( 'Last 30 Days', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-gray-light easydocs-btn-rounded easydocs-btn-sm date__range">
				<?php esc_html_e( 'Custom Date Range', 'eazydocs-pro' ); ?>
            </li>
        </ul>
    </div>
    <div class="easydocs-accordion sortabled dd accordionjs nestables-child" id="nestable-9">
        <div id="Positive_negative_feedback"></div>
        <div class="eazydocc-chartsummery">
            <div class="easydocs-accordion ezdw-50">
                <h3> <?php esc_html_e( 'Positive Feedback', 'eazydocs-pro' ); ?></h3>
                <div class="eazy-docs-row">
                    <div class="easydocs-card easy-docs-card-bg-light">
                        <div class="easydocs-card-body">
                            <div class="easydocs-card-title positive-feedback-chart t-success">0</div>
                            <div class="easydocs-card-value"> <?php esc_html_e( 'Voted Helpful', 'eazydocs-pro' ); ?> </div>
                        </div>
                    </div>
                </div>
                <div class="eazy-docs-row">
                    <div class="easydocs-summery-body">
                        <h4 class="easydocs-summery-value positive-feedback-chart-percentage">
                            <span class="dashicons dashicons-smiley t-success"></span>
			                <?php esc_html_e( '0% Positive Feedback', 'eazydocs-pro' ); ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="easydocs-accordion ezdw-50">
                <h3><?php esc_html_e( 'Negative Feedback', 'eazydocs-pro' ); ?></h3>
                <div class="eazy-docs-row">
                    <div class="easydocs-card easy-docs-card-bg-light">
                        <div class="easydocs-card-body">
                            <div class="easydocs-card-title negtive-feedback-chart t-danger">0</div>
                            <div class="easydocs-card-value"> <?php esc_html_e( 'Voted Unhelpful', 'eazydocs-pro' ); ?> </div>
                        </div>
                    </div>
                </div>
                <div class="eazy-docs-row">
                    <div class="easydocs-summery-value negative-feedback-chart-percentage">
                        <span class="dashicons dashicons-smiley t-danger"></span>
                        <?php esc_html_e( '0% Negative Feedback', 'eazydocs-pro' ); ?>
                    </div>
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
                name: "Positive",
                data: <?php echo json_encode( $Liked ); ?>,
                color: '#3AD794'
            },
            {
                name: "Negative",
                data: <?php echo json_encode( $Disliked ); ?>,
                color: '#F01A19'
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

    var P_N_ChartFeedback = new ApexCharts(document.querySelector("#Positive_negative_feedback"), options);
    P_N_ChartFeedback.render();

    var positive_feedback = document.querySelector(".positive-feedback-chart");
    var positive_feedback_percentage = document.querySelector(".positive-feedback-chart-percentage");
    positive_feedback.innerHTML = <?php echo eazydocspro_number_format( $total_liked ); ?>;
    positive_feedback_percentage.innerHTML = '<span class="dashicons dashicons-smiley t-success"></span> ' + <?php echo round( $total_liked / (  $total_disliked  + $total_liked ) * 100 ); ?> +'% Positive Feedback';

    // Show negative-feedback and negative-feedback-percentage
    var negative_feedback = document.querySelector(".negtive-feedback-chart");
    var negative_feedback_percentage = document.querySelector(".negative-feedback-chart-percentage");
    negative_feedback.innerHTML = <?php echo eazydocspro_number_format( $total_disliked ); ?>;
    negative_feedback_percentage.innerHTML = '<span class="dashicons dashicons-smiley t-danger"></span> '
        + <?php echo round( $total_disliked / ( $total_liked + $total_disliked ) * 100 ) ; ?> +'% Negative Feedback';

    // data filter series in apexchartjs
    var ezd_docs_checkbox = document.querySelectorAll(".feedbackchart input[type=checkbox]");
    ezd_docs_checkbox.forEach(function (ezd_docs_checkbox) {
        ezd_docs_checkbox.addEventListener("change", function () {
            if (this.checked) {
                P_N_ChartFeedback.showSeries(this.value);
            } else {
                P_N_ChartFeedback.hideSeries(this.value);
            }
        });
    });

    // Last 7 days
    function AllSewvenDaysFeedback() {
        P_N_ChartFeedback.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [
                {
                    name: "Positive",
                    data: <?php echo json_encode( $Liked ); ?>
                },
                {
                    name: "Negative",
                    data: <?php echo json_encode( $Disliked ); ?>
                }

            ],
        });
    }

    // Last Month Data
    function FeedbackLastMonth() {
		<?php
		global $wpdb;

		$date_range = strtotime( '-29 day' ); // 7 days ago
		$today_date = date( 'Y-m-d' ); // today date
		$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'docs') AND meta_key IN ('positive_time', 'negative_time') AND meta_value BETWEEN $today_date AND UNIX_TIMESTAMP() ORDER BY meta_value DESC" );

		$labels = [];
		$Liked = [];
		$Disliked = [];

		$m = date( "m" );
		$de = date( "d" );
		$y = date( "Y" );

		for ( $i = 0; $i <= 29; $i ++ ) {
			$labels[]   = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
			$Liked[]    = 0;
			$Disliked[] = 0;
		}

		// Get 29 data date wise
		foreach ( $posts as $key => $item ) {
			$dates = date( 'd M, Y', strtotime( $item->meta_value ) );

			foreach ( $labels as $datekey => $weekdays ) {
				# code...
				if ( $weekdays == date( 'd M, Y', strtotime( $item->meta_value ) ) ) {
					// sum of positive_time and negative_time
					if ( $item->meta_key == 'positive_time' ) {
						$Liked[ $datekey ] = $Liked[ $datekey ] + 1;
					} else {
						$Disliked[ $datekey ] = $Disliked[ $datekey ] + 1;
					}
				}
			}

		}

		?>
        P_N_ChartFeedback.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [
                {
                    name: "Positive",
                    data: <?php echo json_encode( $Liked ); ?>
                },
                {
                    name: "Negative",
                    data: <?php echo json_encode( $Disliked ); ?>
                }

            ],
        });
    }

    // onclick .date__range show calender
    function FeedbackDateRange() {
        jQuery('.date__range').daterangepicker().on('apply.daterangepicker', function (e, picker) {
            var startDate = picker.startDate.format('Y-M-D');
            var endDate = picker.endDate.format('Y-M-D');

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                data: {action: "ezd_filter_date_from_feedback", startDate: startDate, endDate: endDate},
                success: function (response) {
                    P_N_ChartFeedback.updateOptions({
                        xaxis: {
                            categories: response.data.labels,
                        },
                        series: [
                            {
                                name: 'Positive',
                                data: response.data.liked
                            },
                            {
                                name: 'Negative',
                                data: response.data.disliked
                            }],
                    });
                }
            });
        })
    }

    FeedbackDateRange();
</script>