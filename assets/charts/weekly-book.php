<div>
    <?php
        require 'public/connection.php';
        error_reporting(0);
        $getWeeklyBook = $connect->query("SELECT DAYNAME(created_at) as 'weeks',WEEK(created_at) as 'numWeeks',
        SUM(guests) as 'guests' FROM tblreservation 
        WHERE status='Approve' AND week(created_at)=week(curdate()) AND YEAR(created_at)=YEAR(curdate())
        GROUP BY day(created_at) ORDER BY created_at ASC");
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