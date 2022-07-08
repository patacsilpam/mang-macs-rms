<?php require 'public/admin-inventory.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Orders" content="Mang Macs-Orders">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Order Summary</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Order Summary</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php' ?>
            </ul>
        </header>
        <!--Sales' Categories-->
        <main class="main-container">
            <section class="order-summary-1">
                <article class="order-summary-number">
                    <h3>
                        <a href="orders.php" title="Back"><i class="fa fa-arrow-circle-left"></i></a>
                        Order # : <?=$_GET['order_number']?>
                    </h3>
                    <i>Orders / Order # : <?=$_GET['order_number']?></i>
                </article>
                <hr>
                <article class="order-summary-details">
                    <article>
                        <?php
                        require 'public/connection.php';
                        $getOrderNumber = $_GET['order_number'];
                        $getOrderSummary = $connect->prepare("SELECT tblcustomerorder.order_number,tblcustomerorder.customer_name,
                            tblorderdetails.created_at,tblorderdetails.required_date,tblorderdetails.required_time,
                            tblorderdetails.order_type,tblorderdetails.order_status,tblcustomerorder.email,
                            tblcustomerorder.phone_number,tblcustomerorder.total_amount
                            FROM tblcustomerorder LEFT JOIN tblorderdetails
                            ON tblcustomerorder.order_number = tblorderdetails.order_number
                            WHERE tblorderdetails.order_number=? LIMIT 1");
                        $getOrderSummary->bind_param('s',$getOrderNumber);
                        $getOrderSummary->execute();
                        $getOrderSummary->bind_result($orderNumber,$customerName,$placedOn,$requiredDate,$requiredTime,$orderType,$orderStatus,$email,$phoneNumber,$totalAmount);
                        while($getOrderSummary->fetch()){
                        $GLOBALS['totalAmount'] = $totalAmount;
                   ?>
                        <p><strong>Order Number:</strong> <?=$orderNumber?></p>
                        <p><strong>Account name:</strong> <?=$customerName?></p>
                        <p><strong>Date Added:</strong> <?=$placedOn?></p>
                        <p><strong>Delivery Time:</strong> <?=$requiredDate." ". $requiredTime?></p>
                        <p><strong>Order Type:</strong> <?=$orderType; ?></p>
                    </article>
                    <article>
                        <p><strong>Order Status:</strong> <?=$orderStatus?></p>
                        <p><strong>Email:</strong> <?=$email?></p>
                        <p><strong>Phone Number:</strong> <?=$phoneNumber?></p>
                        <p><strong>Total Amount:</strong> <?=$totalAmount?></p>
                        <p><strong><a href="view-payment.php?order_number=<?= $getOrderNumber?>">View Payment</a></strong></p>
                        <?php } ?>
                    </article>
                </article>
            </section>
            <section class="order-summary-2">
                <article class="tab-content">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="nav-item w-50">
                            <a class="nav-link active m-1  bg-dark text-white w-100" data-toggle="tab"
                                href="#orderProduct">Order Product</a>
                        </li>
                        <li class="nav-item  w-50">
                            <a class="nav-link m-1  bg-dark text-white" data-toggle="tab"
                                href="#shippingAddress">Shipping Address</a>
                        </li>
                    </ul>
                    <article class="tab-pane active" id="orderProduct">

                        <div class="table-responsive table-container">
                            <div class="add-product">
                            </div>
                            <table id="example" class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Order Number</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Add Ons</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require 'public/connection.php';
                                    $recipientName="";
                                    $orderNumber = $_GET['order_number'];
                                    $getOrderSummary = $connect->prepare("SELECT order_number,product_name,quantity,price,product_variation,add_ons,recipient_name FROM tblorderdetails WHERE order_number=?");
                                    echo $connect->error;
                                    $getOrderSummary->bind_param('s',$orderNumber);
                                    $getOrderSummary->execute();
                                    $getOrderSummary->bind_result($orderId,$productName,$quantity,$price,$variation,$addOns,$recipientName);
                                    while($getOrderSummary->fetch()){
                                   
                                        ?>
                                    <tr>
                                        <td><?=$orderId?></td>
                                        <td><?=$productName?></td>
                                        <td><?=$quantity?></td>
                                        <td><?=$price?></td>
                                        <td><?=$variation?></td>
                                        <td><?=$addOns?></td>
                                        <td><?=$subTotal = $price * $quantity;?></td>
                                    </tr>
                                    <?php
                                    }
                                    
                               ?>
                                </tbody>
                                <tr>
                                    <td col="7"><b>Total Amount</b>: <?= $totalAmount?></td>
                                </tr>
                            </table>
                        </div>

                    </article>
                    <article class="tab-pane fade" id="shippingAddress">
                        <?php
                            $orderNumber = $_GET['order_number'];
                            require 'public/connection.php';
                            $getOrder = $connect->prepare("SELECT customer_address,label_address FROM tblcustomerorder WHERE order_number=? LIMIT 1");
                            $getOrder->bind_param('s',$orderNumber);
                            $getOrder->execute();
                            $getOrder->bind_result($customerAddress,$labelAddress);
                            $getOrder->fetch();
                        ?>
                          <p><strong>Recipient Name: </strong><?=$recipientName?></p>
                        <p><strong>Address: </strong><?=$customerAddress?></p>
                        <p><strong>Label Address: </strong><?=$labelAddress?></p>
                    </article>
                </article>

            </section>
        </main>
        <!--Sidebar-->
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/sidebar-menu.js"></script>
    <script src="assets/sidebar-menu-active.js"></script>
    <script src="assets/table.js"></script>
</body>

</html>