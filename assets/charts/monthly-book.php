<div>
    <?php
        require 'public/connection.php';
        error_reporting(0);
        $getMonthlyBook = $connect->query("SELECT SUM(guests)as 'guests',YEAR(scheduled_date) as 'year',
        MONTHNAME(scheduled_date) as 'month' FROM tblreservation WHERE status IN ('Finished','Order Received')
        AND YEAR(scheduled_date) = YEAR(curdate()) 
        GROUP BY YEAR(scheduled_date) = YEAR(curdate()), MONTH(scheduled_date) ORDER BY YEAR(scheduled_date),MONTH(scheduled_date)");
        foreach ($getMonthlyBook as $displayMonthlyBook) {
        $monthsBook[] = $displayMonthlyBook['guests'];
        $monthlyBook[] = $displayMonthlyBook['month'];
        }
    ?>

</div>
<script>
// === include 'setup' then 'config' above ===
const monthlyBookLabel = <?php echo json_encode($monthlyBook)?>;
const monthlyBookData = {
    labels: monthlyBookLabel,
    datasets: [{
        label: 'Monthly Booking <?= date('Y')?> ',
        data: <?php echo json_encode($monthsBook) ?>,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        backgroundColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }]
};

const configMonthlyBookChart = {
    type: 'line',
    data: monthlyBookData,
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

var monthlyBookChart = new Chart(
    document.getElementById('monthly-book-chart'),
    configMonthlyBookChart
);
</script>