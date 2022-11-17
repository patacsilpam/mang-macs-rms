<?php
require 'public/admin-inventory.php';
require 'public/admin-orders.php'
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Orders" content="Mang Macs-Orders">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4adbff979d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Order(Out for Delivery & Ready for Pick Up)</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3 class="mx-2 font-weight-normal">Order <small>(Out for Delivery & Ready for Pick Up)</small></h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Sales' Categories-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ordered Date</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Order Type</th>
                                    <th scope="col">Total Order Amount</th>
                                    <th scope="col">Order Time</th>
                                    <th scope="col">Required Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="trans_separate">
                                <?php
                                    require 'public/connection.php';
                                    /*fetch new orders with "Out for Delivery" status for deliver order method 
                                    and "Ready for Pick Up" status for pick up order method 
                                    from table `tblorderdetails` with join table `tblcustomerorder`*/
                                    $getOrders = "SELECT DISTINCT(tblcustomerorder.order_number),tblcustomerorder.id,
                                    tblcustomerorder.token,tblorderdetails.created_at,
                                    tblcustomerorder.customer_name,tblorderdetails.order_status,
                                    tblorderdetails.order_type,tblcustomerorder.total_amount,tblorderdetails.required_date,
                                    tblorderdetails.required_time,tblcustomerorder.email,tblcustomerorder.delivery_fee
                                    FROM tblcustomerorder LEFT JOIN tblorderdetails 
                                    ON tblorderdetails.order_number = tblcustomerorder.order_number
                                    WHERE tblorderdetails.order_status IN ('Out for Delivery','Ready for Pick Up')
                                    GROUP BY tblorderdetails.order_number 
                                    ORDER BY STR_TO_DATE(CONCAT(tblorderdetails.required_date,' ',tblorderdetails.required_time),'%Y-%m-%d %h:%i %p') ASC";
                                    $displayOrders = $connect->query($getOrders);
                                    while($fetch = $displayOrders->fetch_assoc()){
                                   ?>
                                <tr>
                                    <th scope="row">#<?=$fetch['order_number']?></th>
                                    <td><?=$fetch['created_at']?></td>
                                    <td><?=$fetch['customer_name']?></td>
                                    <td><?=$fetch['order_type']?></td>
                                    <td>₱ <?=$fetch['total_amount'] + $fetch['delivery_fee']?>.00</td>
                                    <td><?php if($fetch['required_time'] == '-- --') {echo 'Order Now';} else {echo 'Order Later';}  ?></td>
                                    <td><?=$fetch['required_date']?><br><?=$fetch['required_time']?></td>
                                    <td>
                                        <input type="text" value="<?=$fetch['order_status']?>" class="order-status"  name="orderStatus"/>
                                    </td>
                                    <td>
                                        <a href='order_summary.php?order_number=<?= $fetch['order_number'];?>' title="View Order Details">
                                            <button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                        </a>
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
        <?php include 'assets/template/admin/sidebar.php' ?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
    <script src="assets/js/highlight-order-status.js"></script>
</body>

</html>