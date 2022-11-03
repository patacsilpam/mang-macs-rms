<?php 
require 'public/admin-inventory.php';
require 'public/admin-courier.php';
require 'public/admin-orders-orders.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Orders" content="Mang Macs-Orders">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/4adbff979d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/setCourier.js" defer></script>
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
                        <a href="#"  onclick="history.back()" title="Back"><i class="fa fa-arrow-circle-left"></i></a>
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
                        $getOrderSummary = $connect->prepare("SELECT tblcustomerorder.order_number,tblcustomerorder.courier,tblcustomerorder.customer_name,
                            tblorderdetails.created_at,tblorderdetails.required_date,tblorderdetails.required_time,
                            tblorderdetails.order_type,tblorderdetails.order_status,tblcustomerorder.email,
                            tblcustomerorder.phone_number,tblcustomerorder.total_amount,tblcustomerorder.delivery_fee,tblcustomerorder.token
                            FROM tblcustomerorder LEFT JOIN tblorderdetails
                            ON tblcustomerorder.order_number = tblorderdetails.order_number
                            WHERE tblorderdetails.order_number=? LIMIT 1");
                        $getOrderSummary->bind_param('s',$getOrderNumber);
                        $getOrderSummary->execute();
                        $getOrderSummary->bind_result($orderNumber,$courierName,$customerName,$placedOn,$requiredDate,$requiredTime,$orderType,$orderStatus,$email,$phoneNumber,$totalAmount,$deliveryFee,$token);
                        while($getOrderSummary->fetch()){
                        $GLOBALS['totalAmount'] = $totalAmount;
                   ?>
                        <p><strong>Order Number:</strong> <?=$orderNumber?></p>
                        <p><strong>Account name:</strong> <?=$customerName?></p>
                        <p><strong>Date Added:</strong> <?=$placedOn?></p>
                        <p><strong>Delivery Time:</strong> <?=$requiredDate." ". $requiredTime?></p>
                        <p><strong>Order Type:</strong> <?=$orderType; ?></p>
                        <p>
                            <div id="setCourier">
                                <div style="display:flex; align-items:center; flex-direction:row;" >
                                    <strong>Courier</strong>
                                    <?php include 'assets/template/admin/setCourier.php' ?>
                                    <button title="Edit" type="button" class="btn btn-transparent" data-toggle="modal" data-target="#setCourier<?=$orderNumber?>">
                                        <i class="fas fa-edit" style="color: blue;"></i>
                                    </button>
                                </div>
                            </div>
                        </p>
                        <p style="display:none;">
                            <input type="text" value="<?=$orderType?>" id="courier">
                        </p>
                    </article>
                    <article>
                        <p><strong>Order Status:</strong> <?=$orderStatus?></p>
                        <p><strong>Email:</strong> <?=$email?></p>
                        <p><strong>Phone Number:</strong> <?=$phoneNumber?></p>
                        <p><strong>Total Amount: </strong>₱ <?=$totalAmount + $deliveryFee?>.00</p>
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
                                        <th scope="col">Variation</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Add Ons</th>
                                        <th scope="col">Add Ons Price</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require 'public/connection.php';
                                    $recipientName="";
                                    $orderNumber = $_GET['order_number'];
                                    $getOrderSummary = $connect->prepare("SELECT order_number,product_name,product_variation,quantity,price,add_ons,add_ons_fee,recipient_name FROM tblorderdetails WHERE order_number=?");
                                    echo $connect->error;
                                    $getOrderSummary->bind_param('s',$orderNumber);
                                    $getOrderSummary->execute();
                                    $getOrderSummary->bind_result($orderId,$productName,$variation,$quantity,$price,$addOns,$addOnsFee,$recipientName);
                                    while($getOrderSummary->fetch()){
                                   
                                        ?>
                                    <tr>
                                        <td><?=$orderId?></td>
                                        <td><?=$productName?></td>
                                        <td><?=$variation?></td>
                                        <td><?=$quantity?></td>
                                        <td><?=$price?>.00</td>
                                        <td><?=$addOns?></td>
                                        <td><?=$addOnsFee?>.00</td>
                                        <td><?=($price * $quantity) + ($addOnsFee * $quantity);?>.00</td>
                                    </tr>
                                    <?php
                                    }
                                    
                               ?>
                                </tbody>
                               <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td><b>Delivery Fee</b>: </td>
                                        <td><?= $deliveryFee?>.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td><b>Grand Total</b>: </td>
                                        <td>₱ <?= $totalAmount + $deliveryFee?>.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td><b>Order Status</b><span class="mx-3 text-danger" style="font-size:1.5rem">*</span></td>
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                                            <td>
                                                <select name="orderStatus" class="form-control" style="font-size:1.3rem" id="order-status">
                                                    <option value="Pending" <?php if($orderStatus == "Pending") { echo 'selected ? "selected"';}?>>Pending</option>
                                                    <option value="Order Processing" <?php if($orderStatus == "Order Processing") { echo 'selected ? "selected"';}?>>Processing (Confirm Order)</option>
                                                    <option id="out-delivery" value="Out for Delivery" <?php if($orderStatus == "Out for Delivery") { echo 'selected ? "selected"';}?>>Out for Delivery</option>
                                                    <option id="ready-pickup" value="Ready for Pick Up" <?php if($orderStatus == "Ready for Pick Up") { echo 'selected ? "selected"';}?>>Ready for Pick Up</option>
                                                    <option value="Order Completed" <?php if($orderStatus == "Order Completed") { echo 'selected ? "selected"';}?>>Complete</option>
                                                    <option value="Cancelled" <?php if($orderStatus == "Cancelled") { echo 'selected ? "selected"';}?>>Cancel</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" name="email" value="<?=$email?>">
                                                <input type="hidden" name="customerName" value="<?=$customerName?>">
                                                <input type="hidden" name="orderNumber" value="<?=$orderNumber?>">
                                                <input type="hidden" name="sales" value="<?=$totalAmount?>">
                                                <input type="hidden" name="orderType" value="<?=$orderType?>">
                                                <input type="hidden" name="token" value="<?=$token?>">
                                                <input type="hidden" name="orderDate" value="<?=$placedOn?>">
                                                <button type="submit" name="btn-update" class="btn btn-primary">Update Status</button>
                                            </td>
                                        </form>
                                    </tr>
                               </tfoot>
                               
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
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/table.js"></script>
    <script src="assets/js/highlight-order-status.js"></script>
</body>

</html>