<?php require 'public/admin-inventory.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Dashboard</title>
</head>

<body>
    <div class="grid-container">
        <!--header-->
        <header class="nav-container">
            <h3>Dashboard</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Inventory Container-->
        <main class="main-container">
            <section>
                <article>
                    <div class="boxes">
                        <div class="line-box-1">
                            <div class="box1">
                                <h5 class="text-sales">Sales</h5>
                                <span><?php //getSales('totalSales'); ?></span>
                            </div>
                            <div class="box2">
                                <h5 class="text-sales">Reservation</h5>
                                <span><?php //getReservation('totalGuests'); ?></span>
                            </div>
                            <div class="box3">
                                <h5 class="text-sales">Delivery</h5>
                                <span><?php //getDelivery('orderType'); ?></span>
                            </div>
                            <div class="box4">
                                <h5 class="text-sales">Stocks</h5>
                                <span><?php //getStocks('totalStocks') ?></span>
                            </div>
                        </div>
                    </div>
                    <!--Charts-->
                    <div class="line-chart-1">
                        <div>
                            <canvas id="dailyChart" class="canvas" width="600" height="350"></canvas>
                            <?php //include 'charts/dailyChart.php'?>
                        </div>
                        <div>
                            <canvas id="weeklyChart" class="canvas" width="600" height="350"></canvas>
                            <?php //include 'charts/weeklyChart.php'?>
                        </div>
                    </div>
                    <div class="line-chart-2">
                        <div>
                            <canvas id="monthlyChart" class="canvas" width="600" height="350"></canvas>
                            <?php //include 'charts/monthlyChart.php'?>
                        </div>
                        <div>
                            <canvas id="yearlyChart" class="canvas" width="600" height="350"></canvas>
                            <?php //include 'charts/yearlyChart.php'?>
                        </div>
                    </div>
                </article>
            </section>
        </main>
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>

</body>

</html>