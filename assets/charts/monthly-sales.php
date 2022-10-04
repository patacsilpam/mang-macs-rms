<div>
    <?php
        require 'public/connection.php';
        error_reporting(0);
        $getMonth = $connect->query("SELECT YEAR(completed_time) as 'year',MONTHNAME(completed_time) as 'month',
        SUM((price * quantity) + (add_ons_fee * quantity)) as 'totalSales' FROM tblorderdetails WHERE order_status IN ('Order Completed','Order Received','Finished') 
        AND YEAR(completed_time) = YEAR(curdate()) 
        GROUP BY YEAR(completed_time) = YEAR(curdate()),
        MONTH(completed_time) ORDER BY YEAR(completed_time),MONTH(completed_time)");
        foreach ($getMonth as $displayMonth) {
        $months[] = $displayMonth['month'];
        $monthlySales[] = $displayMonth['totalSales'];
        
        }
    ?>

</div>
<script>
// === include 'setup' then 'config' above ===
const monthlyLabels = <?php echo json_encode($months)?>;
const monthlyData = {
    labels: monthlyLabels,
    datasets: [{
        label: 'Total Monthly Sales (₱) <?= date('- Y')?>',
        data: <?php echo json_encode ($monthlySales)?>,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        backgroundColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }]
};

const configMonthlyChart = {
    type: 'line',
    data: monthlyData,
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

var monthlyChart = new Chart(
    document.getElementById('monthly-sales-chart'),
    configMonthlyChart
);
</script>