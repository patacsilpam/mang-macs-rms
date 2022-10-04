<div>
    <?php
    require 'public/connection.php';
    error_reporting(0);
    $getdDailyBook = $connect->query("SELECT SUM(guests) as 'guests', YEAR(scheduled_date) as 'year',DAY(scheduled_date) as 'day'
    FROM tblreservation WHERE status IN ('Finished','Order Received') AND YEAR(scheduled_date) = YEAR(curdate()) 
    AND MONTH(scheduled_date) = MONTH(scheduled_date) 
    GROUP BY YEAR(scheduled_date), DAY(scheduled_date) 
    ORDER BY YEAR(scheduled_date),MONTH(scheduled_date),DAY(scheduled_date)");
    foreach ($getdDailyBook as $displayDailyBook) {
       $daysBook[] = $displayDailyBook['guests'];
       $dailyBook[] = $displayDailyBook['day'];
     
    }
    ?>

</div>
<script>
    // === include 'setup' then 'config' above ===
    const dailyBookLabel = <?php echo json_encode($dailyBook)?>;
    const dailyBookData  = {
        labels: dailyBookLabel,
        datasets: [{
            label: '<?php echo date('F Y')?>(Guests)',
            data: <?php echo json_encode($daysBook) ?>,
            fill:false,
            borderColor: '#394bed',
            backgroundColor:  '#394bed',
            tension: 0.1
        }]
    };

    const configdailyBookChart  = {
        type: 'line',
        data: dailyBookData,
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
        document.getElementById('daily-book-chart'),
        configdailyBookChart
    );
</script>