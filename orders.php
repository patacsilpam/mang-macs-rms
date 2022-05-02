<?php require 'public/admin-inventory.php'; require 'public/admin-orders.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Orders" content="Mang Macs-Orders">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Orders</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Orders</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Sales' Categories-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <div class="add-product">
                        </div>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ordered Date</th>
                                    <th scope="col">Account Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Order Type</th>
                                    <th scope="col">Total Order Amount</th>
                                    <th scope="col">Required Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <!---->
                            <tbody>
                                <?php
                                    require 'public/connection.php';
                                    $getOrders = "SELECT tblcustomerorder.order_number,tblcustomerorder.id,
                                    tblorderdetails.created_at,tblcustomerorder.customer_name,tblorderdetails.order_status,
                                    tblorderdetails.order_type,tblcustomerorder.total_amount,tblorderdetails.required_date,
                                    tblorderdetails.required_time,tblcustomerorder.email
                                    FROM tblcustomerorder LEFT JOIN tblorderdetails 
                                    ON tblorderdetails.order_number = tblcustomerorder.order_number
                                    WHERE tblorderdetails.order_status = 'Pending' OR tblorderdetails.order_status = 'Order Received'
                                    OR tblorderdetails.order_status = 'Shipped'";
                                    $displayOrders = $connect->query($getOrders);
                                    while($fetch = $displayOrders->fetch_assoc()){
                                   ?>
                                <tr>
                                    <th scope="row"><?=$fetch['id']?></th>
                                    <td><?=$fetch['created_at']?></td>
                                    <td><?=$fetch['customer_name']?></td>
                                    <td width="150">
                                        <span class="flex">
                                            <?=$fetch['order_status']?>
                                            <button title="Edit" type="button" class="btn btn-transparent"
                                                data-toggle="modal"
                                                data-target="#editUsers<?= $fetch['order_number'] ?>"><i
                                                    class="fas fa-edit" style="color: blue;"></i></button>
                                            <?php include 'assets/template/admin/orderStatus.php' ?>
                                        </span>
                                    </td>
                                    <td><?=$fetch['order_type']?></td>
                                    <td><?=$fetch['total_amount']?></td>
                                    <td><?=$fetch['required_date']?><br><?=$fetch['required_time']?></td>
                                    <td>
                                        <a href='order_summary.php?order_number=<?= $fetch['order_number'];?>'
                                            title="View Order Details"><i class="fas fa-arrow-circle-right"></i></a>
                                    </td>
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
        <!--Sidebar-->
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
</body>

</html>