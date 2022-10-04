<?php require 'public/admin-inventory.php'; require 'public/admin-count-orders.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
    <script src="https://kit.fontawesome.com/4adbff979d.js" crossorigin="anonymous"></script>
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
            <!--Row 1--->
            <article class="sales-order-container">
                <!--Chart for orders-->
                <section class="sales-report-orders">
                    <!---Active Order--->
                    <section>
                        <section class="box-orders">
                            <h3>New Order</h3>
                            <section class="view-sales-details">
                                <p class="text--active"><?php countActiveOrders();?></p>
                                <a href="orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                      <!--New Reservation---->
                      <section>
                        <section class="box-orders">
                            <h3>New Reservation</h3>
                            <section class="view-sales-details">
                                <p class="text--active"><?php countActiveBooking() ?></p>
                                <a href="reservation.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
                <section class="sales-report-orders">
                     <!--Delivered Order---->
                    <section>
                        <section class="box-orders">
                            <h3>Delivery Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--delivered"><?php  countDeliveryOrders() ?></p>
                                <a href="delivered-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                     <!--Pick Up Order---->
                    <section>
                        <section class="box-orders">
                            <h3>Pick Up Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--pickUp"><?php countPickUpOrders() ?></p>
                                <a href="pick-up-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                     <!--Cancelled Order---->
                     <section>
                        <section class="box-orders">
                            <h3>Cancelled Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--cancelled"><?php countCancelledOrders() ?></p>
                                <a href="cancelled-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                     <!--Cancelled Reservation---->
                     <section>
                        <section class="box-orders">
                            <h3>Cancelled Reservation</h3>
                            <section class="view-sales-details">
                                <p class="text--cancelled"><?php countCancelledBooking() ?></p>
                                <a href="cancelled-booking.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
                <section class="sales-report-orders">
                     <!--POS Order---->
                     <section>
                        <section class="box-orders">
                            <h3>POS Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--total"><?php countPosOrders()?></p>
                                <a href="total-pos.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                     <!--Total Order---->
                     <section>
                        <section class="box-orders">
                            <h3>Total Order</h3>
                            <section class="view-sales-details">
                                <p class="text--total"><?php countTotalOrders();?></p>
                                <a href="total-order.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                    <!--Total Reservation---->
                    <section>
                        <section class="box-orders">
                            <h3>Total Reservation</h3>
                            <section class="view-sales-details">
                                <p class="text--total"><?php countTotalBooking() ?></p>
                                <a href="total-booking.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                     <!--Customers-->
                    <section>
                        <section class="box-orders">
                            <h3>Mang Macs App Customers</h3>
                            <section class="view-sales-details">
                                <p class="text--active"><?php countCustomers() ?></p>
                                <a href="customers.php" title="View Details">View</a>
                            </section>
                        </section>
                </section>
            </article>
            <article class="sales-order-container">
            <section class="sales-graph" style="position: relative;">
                    <section class="sales-title">
                        <h3>Total Sales Order(<?php echo date('Y') ?>)</h3>
                        <section>
                            <ul class="nav nav-pills" id="myTab">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#dailySales">Daily</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#weeklySales">Weekly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#monthlySales">Monthly</a>
                                </li>
                            </ul>
                        </section>
                    </section>
                    <section class="tab-content">
                        <section id="dailySales" class="container tab-pane active"><br />
                            <canvas id="daily-sales-chart" class="canvas" style="width:250px; height:80px">
                                <?php include 'assets/charts/daily-sales.php'?>
                            </canvas>
                        </section>
                        <section id="weeklySales" class="container tab-pane fade"><br />
                            <canvas id="weekly-sales-chart" class="canvas" style="width: 250px; height:70px">
                                <?php include 'assets/charts/weekly-sales.php'?>
                            </canvas><br>
                            <section class="text-center">
                                <?php echo date('F d',strtotime("sunday last week"))?> -
                                <?php echo date('F d',strtotime("saturday this week"))?>
                            </section>
                        </section>
                        <section id="monthlySales" class="container tab-pane fade"><br />
                            <canvas id="monthly-sales-chart" class="canvas" style="width: 250px; height:80px">
                                <?php include 'assets/charts/monthly-sales.php'?>3
                            </canvas>
                        </section>
                    </section>
                </section>
            </article>
            <article class="sales-book-container">
                <!--chart for reservation-->
                <article>
                    <section class="sales-graph">
                        <section class="sales-title">
                            <h3>Total Reservation 2022</h3>
                            <section>
                                <ul class="nav nav-pills" id="myTab">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#dailyBook">Daily</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#weeklyBook">Weekly</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#monthlyBook">Monthly</a>
                                    </li>
                                </ul>
                            </section>
                        </section>
                        <section class="tab-content">
                            <section id="dailyBook" class="container tab-pane active"><br>
                                <canvas id="daily-book-chart" class="canvas" style="width:250px; height:80px">
                                    <?php include 'assets/charts/daily-book.php'?>
                                </canvas>
                            </section>
                            <section id="weeklyBook" class="container tab-pane fade"><br>
                                <canvas id="weekly-book-chart" class="canvas" style="width:250px; height:70px">
                                    <?php include 'assets/charts/weekly-book.php'?>
                                </canvas>
                                <section class="text-center">
                                    <?php echo date('F d',strtotime("sunday last week"))?> -
                                    <?php echo date('F d',strtotime("saturday this week"))?>
                                </section>
                            </section>
                            <section id="monthlyBook" class="container tab-pane fade"><br>
                                <canvas id="monthly-book-chart" class="canvas" style="width:250px; height:80px">
                                    <?php include 'assets/charts/monthly-book.php'?>
                                </canvas>
                            </section>
                        </section>
                    </section>
                </article>
            </article>
        </main>
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
</body>

</html>