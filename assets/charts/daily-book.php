<div>
    <?php
    require 'public/connection.php';
    error_reporting(0);
    $getdDailyBook = $connect->query("SELECT SUM(guests) as 'guests', YEAR(created_at) as 'year',DAY(created_at) as 'day'
    FROM tblreservation WHERE status='Reserved' AND YEAR(created_at) = YEAR(curdate()) 
    AND MONTH(created_at) = MONTH(curdate()) 
    GROUP BY YEAR(created_at), DAY(created_at) 
    ORDER BY YEAR(created_at),MONTH(created_at),DAY(created_at)");
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