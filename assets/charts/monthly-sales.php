<div>
    <?php
        require 'public/connection.php';
        error_reporting(0);
        $getMonth = $connect->query("SELECT YEAR(created_at) as 'year',MONTHNAME(created_at) as 'month',
        SUM(price*quantity) as 'totalSales' FROM tblorderdetails WHERE order_status='Order Completed'
        AND YEAR(created_at) = YEAR(curdate()) 
        GROUP BY YEAR(created_at) = YEAR(curdate()),
        MONTH(created_at) ORDER BY YEAR(created_at),MONTH(created_at)");
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