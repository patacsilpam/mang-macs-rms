<?php require 'public/admin-inventory.php'; require 'public/admin-count-orders.php'?>
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
            <!--Row 1--->
            <article class="sales-order-container">
                <!--Chart for orders-->
                <section class="sales-graph">
                    <section class="sales-title">
                        <h3>Sales Order 2022</h3>
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
                        <section id="dailySales" class="container tab-pane active"><br>
                            <h5>1</h5>
                        </section>
                        <section id="weeklySales" class="container tab-pane fade"><br>
                            <h5>2</h5>
                        </section>
                        <section id="monthlySales" class="container tab-pane fade"><br>
                            <h5>3</h5>
                        </section>
                    </section>
                </section>
                <section class="sales-report-orders">
                    <!---Active Order--->
                    <section>
                        <section class="box-orders">
                            <h3>Active Order</h3>
                            <section class="view-sales-details">
                                <p class="text--active"><?php countActiveOrders('countActiveOrder');?></p>
                                <a href="orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                    <!--Total Order---->
                    <section>
                        <section class="box-orders">
                            <h3>Total Order</h3>
                            <section class="view-sales-details">
                                <p class="text--total"><?php countActiveOrders('countTotalOrder');?></p>
                                <a href="total-order.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                    <!--Cancelled Order---->
                    <section>
                        <section class="box-orders">
                            <h3>Cancelled Order</h3>
                            <section class="view-sales-details">
                                <p class="text--cancelled"><?php countCancelledOrders('countCancelledOrders') ?></p>
                                <a href="cancelled-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
            </article>
            <!---Row 2-->
            <article class="sales-order-container">
                 <!--Delivered Orders-->
                <section class="sales-order-type">
                    <section>
                        <section class="box-orders">
                            <h3>Delivered Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--delivered"><?php  countDeliveryOrders('countDeliveryOrders') ?></p>
                                <a href="delivered-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
                 <!--Dine In Orders-->
                <section class="sales-order-type box-middle">
                    <section>
                        <section class="box-orders">
                            <h3>Dine In Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--dineIn"><?php countDineInOrders('countDineInOrders') ?></p>
                                <a href="dine-in-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
                <!--Pick Up Orders-->
                <section class="sales-order-type">
                    <section>
                        <section class="box-orders">
                            <h3>Pick Up Orders</h3>
                            <section class="view-sales-details">
                                <p class="text--pickUp"><?php countPickUpOrders('countPickUpOrder') ?></p>
                                <a href="pick-up-orders.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
            </article>
            <!--Row 3-->
            <article class="sales-book-container">
                <!--chart for reservation-->
                <article>
                    <section class="sales-graph">
                        <section class="sales-title">
                            <h3>Sales Reservation 2022</h3>
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
                                <h5>1</h5>
                            </section>
                            <section id="weeklyBook" class="container tab-pane fade"><br>
                                <h5>2</h5>
                            </section>
                            <section id="monthlyBook" class="container tab-pane fade"><br>
                                <h5>3</h5>
                            </section>
                        </section>
                    </section>
                </article>
            </article>
            <!--Row 4-->
            <article class="sales-order-container">
                <!--Active Booking-->
                <section class="sales-order-type">
                    <section>
                        <section class="box-orders">
                            <h3>Active Booking</h3>
                            <section class="view-sales-details">
                                <p class="text--active"><?php countActiveBooking('countActiveBooking') ?></p>
                                <a href="reservation.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
                <!--Total Booking-->
                <section class="sales-order-type box-middle">
                    <section>
                        <section class="box-orders">
                            <h3>Total Booking</h3>
                            <section class="view-sales-details">
                                <p class="text--total"><?php countTotalBooking('countTotalBooking') ?></p>
                                <a href="total-booking.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
                  <!--Cancelled Booking-->
                <section class="sales-order-type">
                    <section>
                        <section class="box-orders">
                            <h3>Cancelled Booking</h3>
                            <section class="view-sales-details">
                                <p class="text--cancelled"><?php countCancelledBooking('countCancelledBooking') ?></p>
                                <a href="cancelled-booking.php" title="View Details">View</a>
                            </section>
                        </section>
                    </section>
                </section>
            </article>
        </main>
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>

</body>

</html>