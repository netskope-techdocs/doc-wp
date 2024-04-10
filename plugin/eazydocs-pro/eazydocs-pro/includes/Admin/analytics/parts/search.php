<?php
global $wpdb;

$search_keyword
	= $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}eazydocs_search_log WHERE created_at BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() ORDER BY created_at DESC" );

$labels              = [];
$total_search        = [];
$searchCount         = [];
$searchCountNotFound = [];

$m  = date( "m" );
$de = date( "d" );
$y  = date( "Y" );

for ( $i = 0; $i <= 6; $i ++ ) {
	$labels[]              = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	$total_search[]        = 0;
	$searchCount[]         = 0;
	$searchCountNotFound[] = 0;
}

// Get 7 data date wise
foreach ( $search_keyword as $key => $item ) {
	$dates = date( 'd M, Y', strtotime( $item->created_at ) );

	foreach ( $labels as $datekey => $weekdays ) {
		if ( $weekdays == date( 'd M, Y', strtotime( $item->created_at ) ) ) {
			$total_search[ $datekey ]        = count( $search_keyword );
			$searchCount[ $datekey ]         = array_sum( array_column( $search_keyword, 'count' ) );
			$searchCountNotFound[ $datekey ] = array_sum( array_column( $search_keyword, 'not_found_count' ) );

		}
	}

}

?>

<div class="easydocs-tab tab-active" id="analytics-search">

    <h2 class="title"> Search Analytics </h2> <br>

    <div class="easydocs-filter-container">
        <ul class="single-item-filter">
            <li>
                <!-- Label  -->
                <div class="checkbox ezd-docs-checkbox search_chart">
                    <label for="total_search">
                        <input type="checkbox" name="searchChart" value="Total Search" id="total_search" checked/>
						<?php esc_html_e( 'Total Search', 'eazydocs-pro' ); ?>
                    </label>
                    <label for="result_found">
                        <input type="checkbox" name="searchChart" value="Result Found" id="result_found" checked/>
						<?php esc_html_e( 'Result Found', 'eazydocs-pro' ); ?>
                    </label>
                    <label for="result_not_found">
                        <input type="checkbox" name="searchChart" value="Result Not Found" id="result_not_found" checked/>
						<?php esc_html_e( 'No Result Found', 'eazydocs-pro' ); ?>
                    </label>
                </div>
            </li>
            <li class="easydocs-btn easydocs-btn-blue-light easydocs-btn-rounded easydocs-btn-sm is-active" data-filter="all" onclick="SearchSevenDays()">
				<?php esc_html_e( 'This Week', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-orange-light easydocs-btn-rounded easydocs-btn-sm" data-filter=".protected" onclick="SearchLastMonth()">
                <span class="dashicons dashicons-lock"></span>
				<?php esc_html_e( 'Last 30 Days', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-gray-light easydocs-btn-rounded easydocs-btn-sm date__range_from_search" data-filter=".draft">
                <span class="dashicons dashicons-edit-page"></span>
				<?php esc_html_e( 'Custom Date Range', 'eazydocs-pro' ); ?>
            </li>
        </ul>
    </div>
    <div class="easydocs-accordion sortabled dd accordionjs nestables-child" id="nestable-9">
        <div id="Search_analytics"></div>
    </div>
    <!-- Search Summery and show popular search and not found search -->
    <div class="eazy-docs-row">
        <div class="easydocs-card">
            <div class="easydocs-card-body">
                <table class="eazy-docs-table">
                    <thead>
                    <tr>
                        <th>
							<?php esc_html_e( 'Popular Keywords', 'eazydocs-pro' ); ?>
                        </th>
                        <th>
							<?php esc_html_e( 'Count', 'eazydocs-pro' ); ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					$search_keyword = $wpdb->get_results( "SELECT keyword, COUNT(*) AS count FROM {$wpdb->prefix}eazydocs_search_keyword GROUP BY keyword ORDER BY count DESC LIMIT 20" );
					if ( count( $search_keyword ) > 0 ) :
						foreach ( $search_keyword as $key => $item ): ?>
                            <tr>
                                <td>
									<?php echo esc_html( $item->keyword ); ?>
                                </td>
                                <td>
									<?php echo $item->count; ?>
                                </td>
                            </tr>
						<?php endforeach; ?>
					<?php else : ?>
                        <tr>
                            <td colspan="2">
								<?php esc_html_e( 'No data found', 'eazydocs-pro' ); ?>
                            </td>
                        </tr>
					<?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="easydocs-card">
            <div class="easydocs-card-body">
                <table class="eazy-docs-table">
                    <thead>
                        <tr>
                            <th>
                                <?php esc_html_e( 'Not Found Keywords', 'eazydocs-pro' ); ?>
                            </th>
                            <th>
                                <?php esc_html_e( 'Count', 'eazydocs-pro' ); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					$keywords = ezd_get_search_keywords();

					if ( count( $keywords ) > 0 ) :
						foreach ( $keywords as $key => $item ) : ?>
                            <tr>
                                <td>
									<?php echo $item->keyword; ?>
                                </td>
                                <td>
									<?php echo $item->not_found_count; ?>
                                </td>
                            </tr>
						<?php endforeach; ?>
					<?php else : ?>
                        <tr>
                            <td colspan="2">
								<?php esc_html_e( 'No data found', 'eazydocs-pro' ); ?>
                            </td>
                        </tr>
					<?php endif; ?>
                    </tbody>
                </table>
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
                name: "Total Search",
                data: <?php echo json_encode( $total_search ); ?>
            },
            {
                name: "Result Found",
                data: <?php echo json_encode( $searchCount ); ?>
            },
            {
                name: "Result Not Found",
                data: <?php echo json_encode( $searchCountNotFound ); ?>,
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

    var Search_Analytics = new ApexCharts(document.querySelector("#Search_analytics"), options);
    Search_Analytics.render();

    // Last 7 days
    function SearchSevenDays() {
        Search_Analytics.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [
                {
                    name: "Total Search",
                    data: <?php echo json_encode( $total_search ); ?>
                },
                {
                    name: "Result Found",
                    data: <?php echo json_encode( $searchCount ); ?>
                },
                {
                    name: "Result Not Found",
                    data: <?php echo json_encode( $searchCountNotFound ); ?>
                }

            ],
        });
    }

    // Last Month Data
    function SearchLastMonth() {
		<?php
		global $wpdb;

		$search_keyword
			= $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}eazydocs_search_log WHERE created_at BETWEEN DATE_SUB(NOW(), INTERVAL 29 DAY) AND NOW() ORDER BY created_at DESC" );

		$labels = [];
		$total_search = [];
		$searchCount = [];
		$searchCountNotFound = [];

		$m = date( "m" );
		$de = date( "d" );
		$y = date( "Y" );

		for ( $i = 0; $i <= 29; $i ++ ) {
			$labels[]              = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
			$total_search[]        = 0;
			$searchCount[]         = 0;
			$searchCountNotFound[] = 0;
		}

		// Get 7 data date wise
		foreach ( $search_keyword as $key => $item ) {

			foreach ( $labels as $datekey => $weekdays ) {
				if ( $weekdays == date( 'd M, Y', strtotime( $item->created_at ) ) ) {
					$total_search[ $datekey ]        = count( $search_keyword );
					$searchCount[ $datekey ]         = array_sum( array_column( $search_keyword, 'count' ) );
					$searchCountNotFound[ $datekey ] = array_sum( array_column( $search_keyword, 'not_found_count' ) );

				}
			}

		}
		?>
        Search_Analytics.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [
                {
                    name: "Total Search",
                    data: <?php echo json_encode( $total_search ); ?>
                },
                {
                    name: "Result Found",
                    data: <?php echo json_encode( $searchCount ); ?>
                },
                {
                    name: "Result Not Found",
                    data: <?php echo json_encode( $searchCountNotFound ); ?>
                }
            ],
        });
    }

    // get data date range
    function date__range_from_search() {
        jQuery('.date__range_from_search').daterangepicker().on('apply.daterangepicker', function (e, picker) {
            var startDate = picker.startDate.format('Y-M-D');
            var endDate = picker.endDate.format('Y-M-D');

            // console.log(startDate +" To "+ endDate);

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                data: {action: "ezd_filter_date_from_search", startDate: startDate, endDate: endDate},
                success: function (response) {
                    Search_Analytics.updateOptions({
                        xaxis: {
                            categories: response.data.labels,
                        },
                        series: [
                            {
                                name: "Total Search",
                                data: response.data.totalSearch
                            },
                            {
                                name: 'Result Found',
                                data: response.data.searchCount
                            },
                            {
                                name: 'Result Not Found',
                                data: response.data.searchCountNotFound
                            }],
                    });
                }
            });
        })
    }

    date__range_from_search();

    // data filter series in apexchartjs
    var ezd_docs_checkbox = document.querySelectorAll(".search_chart input[type=checkbox]");
    ezd_docs_checkbox.forEach(function (ezd_docs_checkbox) {
        ezd_docs_checkbox.addEventListener("change", function () {
            if (this.checked) {
                Search_Analytics.showSeries(this.value);
            } else {
                Search_Analytics.hideSeries(this.value);
            }
        });
    });
</script>