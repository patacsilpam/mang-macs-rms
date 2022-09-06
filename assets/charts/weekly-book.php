<div>
    <?php
        require 'public/connection.php';
        error_reporting(0);
        $getWeeklyBook = $connect->query("SELECT DAYNAME(scheduled_date) as 'weeks',WEEK(scheduled_date) as 'numWeeks',
        SUM(guests) as 'guests' FROM tblreservation 
        WHERE status IN ('Finished','Order Received') AND week(scheduled_date)=week(curdate()) AND YEAR(scheduled_date)=YEAR(curdate())
        GROUP BY day(scheduled_date) ORDER BY scheduled_date ASC");
        foreach ($getWeeklyBook as $displayWeeklyBook) {
            $weeksBook[] = $displayWeeklyBook['guests'];
            $weeklyBook[] = $displayWeeklyBook['weeks'];
        }
     ?>
</div>
<script>
// === include 'setup' then 'config' above ===
const weeklyBookLabel = <?php echo json_encode($weeklyBook)?>;
const weelyBookData = {
    labels: weeklyBookLabel,
    datasets: [{
        label: 'Weekly Booking (Week <?= date('W')?>)',
        data: <?php echo json_encode($weeksBook) ?>,
        fill: false,
        borderColor: '#39edae',
        backgroundColor: '#39edae',
        tension: 0.1
    }]
};

const configWeeklyBookChart = {
    type: 'line',
    data: weelyBookData,
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

var dailyBookChart = new Chart(
    document.getElementById('weekly-book-chart'),
    configWeeklyBookChart
);
</script>