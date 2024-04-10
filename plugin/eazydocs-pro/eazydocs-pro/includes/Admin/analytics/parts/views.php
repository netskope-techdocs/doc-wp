<?php
global $wpdb;

$labels         = [];
$dataCount      = [];
$monthlyViews   = [];
$m              = date( "m" );
$de             = date( "d" );
$y              = date( "Y" );

for ( $i = 0; $i <= 6; $i ++ ) {
	$labels[]    = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	$dataCount[] = 0;
}

for ( $i = 0; $i <= 29; $i ++ ) {
	$labels[]    = date( 'd M, Y', mktime( 0, 0, 0, $m, ( $de - $i ), $y ) );
	$monthlyViews[] = 0;
}
                 
$eazydocs_view_table     = $wpdb->prefix . 'eazydocs_view_log'; // Assuming the table has a prefix
// Perform the query
$results        = $wpdb->get_results("SELECT `count`, `created_at` FROM $eazydocs_view_table", ARRAY_A);

// Output the results
$rowValues      = array();
foreach ($results as $row) {
    $rowValues[$row['created_at']] = $row['count'];
}

$totalValues    = array();

// Loop through the data and sum up the values for each date
foreach ($rowValues as $dateTime => $value) {
    $date = explode(' ', $dateTime)[0]; // Extract the date part
    if ( isset( $totalValues[$date] ) ) {
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
    if ( isset( $dates[$date] ) ) {
        if (!isset($dataCounts[$i])) {
            $dataCounts[$i] = 0;
        }
        $dataCounts[$i] += $dates[$date];
    }
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
<div class="easydocs-tab tab-active" id="analytics-views">
    <h2 class="title"> Views </h2> <br>
    <div class="easydocs-filter-container">
        <ul class="single-item-filter">
            <li class="easydocs-btn easydocs-btn-blue-light easydocs-btn-rounded easydocs-btn-sm is-active" data-filter="all" onclick="ViewsLastSeveday()">
				<?php esc_html_e( 'This Week', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-orange-light easydocs-btn-rounded easydocs-btn-sm" data-filter=".protected" onclick="ViewLastMonth()">
				<?php esc_html_e( 'Last 30 Days', 'eazydocs-pro' ); ?>
            </li>
            <li class="easydocs-btn easydocs-btn-gray-light easydocs-btn-rounded easydocs-btn-sm date__range_view" data-filter=".draft">
				<?php esc_html_e( 'Custom Date Range', 'eazydocs-pro' ); ?>
            </li>
        </ul>
    </div>
    <div class="easydocs-accordion sortabled dd accordionjs nestables-child" id="nestable-9">
        <div id="OverviewViewsChart"></div>
        <div class="eazydocc-chartsummery">
            <!-- Make 3 Cards  -->
            <div class="eazy-docs-row">
                <div class="easydocs-card easy-docs-card-bg-light">
                    <div class="easydocs-card-body">
                        <div class="easydocs-card-title last-sevedays-view-chart t-success">
						    <?php echo eazydocspro_number_format( json_encode( array_sum( $dataCount ) ) ); ?>
                        </div>
                        <div class="easydocs-card-value"> <?php esc_html_e( 'This Week Views', 'eazydocs-pro' ); ?> </div>
                    </div>
                </div>
                <div class="easydocs-card easy-docs-card-bg-light">
                    <div class="easydocs-card-body">
                        <div class="easydocs-card-title last-lastmonth-view-chart t-success">
						    <?php echo eazydocspro_number_format( json_encode( array_sum( $monthlyViews ) )  ); ?>
                        </div>
                        <div class="easydocs-card-value"> <?php esc_html_e( 'Last Month Views', 'eazydocs-pro' ); ?> </div>
                    </div>
                </div>
                <div class="easydocs-card easy-docs-card-bg-light">
                    <div class="easydocs-card-body">
                        <div class="easydocs-card-title last-lastmonth-view-chart t-success">
						    <?php echo eazydocspro_number_format( ezdpro_get_total_views() ); ?>
                        </div>
                        <div class="easydocs-card-value"> <?php esc_html_e( 'Total Views', 'eazydocs-pro' ); ?> </div>
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
                name: "Views",
                data: <?php echo json_encode( $dataCount ); ?>
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

    var OverviewViewchart = new ApexCharts(document.querySelector("#OverviewViewsChart"), options);
    OverviewViewchart.render();

    function ViewsLastSeveday() {
        OverviewViewchart.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [{
                name: 'Views',
                data: <?php echo json_encode( $dataCount ); ?>
            }],
        });
    }

    function ViewLastMonth() {
		
        OverviewViewchart.updateOptions({
            xaxis: {
                categories: <?php echo json_encode( $labels ); ?>,
            },
            series: [{
                name: 'Views',
                data: <?php echo json_encode( $monthlyViews ); ?>
            }],
        });

        var last_lastmonth_view_chart = document.querySelector(".last-lastmonth-view-chart");
        last_lastmonth_view_chart.innerHTML = <?php echo eazydocspro_number_format( json_encode( array_sum( $monthlyViews ) )  ); ?>;
    }

    function ViewDateRange() {
        // add daterange picker
        jQuery('.date__range_view').daterangepicker().on('apply.daterangepicker', function (e, picker) {
            var start_date = picker.startDate.format('Y-M-D');
            var end_date = picker.endDate.format('Y-M-D');

            var data = {
                'action': 'ezd_view_date_range_data',
                'start_date': start_date,
                'end_date': end_date
            };
            jQuery.post(ajaxurl, data, function (response) {
                // var obj = response.data;
                // console.log(obj);
                OverviewViewchart.updateOptions({
                    xaxis: {
                        categories: response.data.labels,
                    },
                    series: [{
                        name: 'Views',
                        data: response.data.views
                    }],
                });  

            });
        });
    }

    ViewDateRange();
</script>