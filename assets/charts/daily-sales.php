<div>
    <?php
    require 'public/connection.php';
    error_reporting(0);
    $getDays = $connect->query("SELECT COUNT(product_name), YEAR(required_date) as 'year',DAY(required_date) as 'day',
    SUM(price*quantity) as 'totalSales' FROM tblorderdetails
    WHERE order_status IN ('Order Completed','Order Received') AND YEAR(required_date) = YEAR(curdate()) 
    AND MONTH(required_date) = MONTH(required_date()) GROUP BY YEAR(required_date),DAY(required_date) 
    ORDER BY YEAR(required_date),MONTH(required_date),DAY(required_date)");
  
    foreach ($getDays as $displayDays) {
       $days[] = $displayDays['day'];
       $dailySales[] = $displayDays['totalSales'];
    }
    ?>

</div>
<script>
    // === include 'setup' then 'config' above ===
    const dailyLabel = <?php echo json_encode($days)?>;
    const dailyData  = {
        labels: dailyLabel,
        datasets: [{
            label: 'Daily Sales (Month of <?php echo date('F Y')?>)',
            data: <?php echo json_encode($dailySales) ?>,
            fill:false,
            borderColor: '#394bed',
            backgroundColor:  '#394bed',
            tension: 0.1
        }]
    };
 
    const configdailyChart  = {
        type: 'line',
        data: dailyData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                yAxes: [{
                    ticks: {
                        fontSize: 18
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontSize: 18
                    }
                }],
            }
        },
    };

    var dailyChart = new Chart(
        document.getElementById('daily-sales-chart'),
        configdailyChart
    );
</script>