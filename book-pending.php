<?php require 'public/admin-inventory.php'; require 'public/admin-reservation.php'; ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Inventory" content="Mang Macs-Reservation">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/4adbff979d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Reservation (Pending)</title>
</head>

<body>
    <div class="grid-container">
        <!--header-->
        <header class="nav-container">
            <h3 class="mx-2 font-weight-normal">Reservation <small>(Pending)</small></h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Reservation Container-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Booking No.</th>
                                    <th scope="col">Date Schedule</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No.</th>
                                    <th scope="col">No. of Guests</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Suggestions</th>
                                </tr>
                            </thead>
                            <!---->
                            <tbody>
                                <?php
                                    require 'public/connection.php';
                                    date_default_timezone_set("Asia/Manila");
                                     //fetch waiting time from tblsettings
                                     $fetchWaitingTimeDb = $connect->query("SELECT * FROM tblsettings");
                                     $fetchWaitingTime = $fetchWaitingTimeDb->fetch_assoc();
                                     $intValTime =  $fetchWaitingTime['waitingTime'];
                                     //fetch all active reservation
                                     $queryReservation = $connect->query("SELECT * FROM tblreservation
                                     WHERE STR_TO_DATE(CONCAT(scheduled_date,' ', scheduled_time),'%Y-%m-%d %h:%i %p') >= DATE_SUB(CURDATE(), INTERVAL $intValTime MINUTE)
                                     ORDER BY STR_TO_DATE(CONCAT(scheduled_date,' ',scheduled_time),'%Y-%m-%d %h:%i %p') ASC");
                                    while($fetch = $queryReservation->fetch_assoc()){
                                   ?>
                                <tr>
                                    <td><?= $fetch['refNumber']?></td>
                                    <td><?= $fetch['scheduled_date']?> <br> <?=$fetch['scheduled_time']?></td>
                                    <td><?= $fetch['fname'] ?> <?=$fetch['lname']?></td>
                                    <td><?= $fetch['email']?></td>
                                    <td><?= $fetch['phone_no']?></td>
                                    <td><?= $fetch['guests']?></td>
                                    <td>
                                        <input type="text"  class="order-status" value="<?=$fetch['status']?>">
                                        <button title="Edit" type="button" class="btn btn-transparent"
                                            data-toggle="modal" data-target="#editUsers<?= $fetch['id'] ?>"><i
                                                class="fas fa-edit" style="color: blue;"></i></button>
                                        <?php include 'assets/template/admin/bookingStatus.php' ?>
                                    </td>
                                    <td><small><?=$fetch['comments']?></small></td>
                                    <!--
                                        <td>
                                        <a href='view-payment-1.php?order_number=' title="View Payment">
                                            <button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                        </a>
                                    </td>
                                    -->
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </main>
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
    <script src="assets/js/highlight-order-status.js"></script>
    <script>
        setTimeout(() => {
        document.location.reload();
    },60000)
    </script>
</body>
</html>