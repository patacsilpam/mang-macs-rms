<div>
    <?php
        require 'public/connection.php';
        error_reporting(0);
        $firstDayOfWeek = date('F d',strtotime("sunday last week"));
        $getWeek = $connect->query("SELECT DAYNAME(required_date) as 'weeks',WEEK(required_date) as 'numWeeks',
        SUM(price * quantity) as 'totalSales' FROM tblorderdetails 
        WHERE order_status IN ('Order Completed','Order Received')  AND week(required_date)=week(curdate()) AND YEAR(required_date)=YEAR(curdate())
        GROUP BY day(required_date)  ORDER BY required_date ASC");
        foreach ($getWeek as $displayWeek) {
            $strWeeks[] = $displayWeek['weeks'];
            $weeklySales[] = $displayWeek['totalSales'];
        }
     ?>
</div>
<script>
// === include 'setup' then 'config' above ===
const weeklyLabel = <?= json_encode($strWeeks)?>;
const weeklyData = {
    labels: weeklyLabel,
    datasets: [{
        label: 'Weekly Sales (Week <?= date('W')?>)',
        data: <?= json_encode($weeklySales) ?>,
        fill: false,
        borderColor: '#39edae',
        backgroundColor: '#39edae',
        tension: 0.1
    }]
};

const configWeeklyChart = {
    type: 'line',
    data: weeklyData,
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

var weeklyChart = new Chart(
    document.getElementById('weekly-sales-chart'),
    configWeeklyChart
);
</script>