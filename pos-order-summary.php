<?php require 'public/admin-inventory.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Orders" content="Mang Macs-Orders">
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
                        <a href="pos-orders.php" title="Back"><i class="fa fa-arrow-circle-left"></i></a> Order # : <?=$_GET['id_number']?>
                    </h3>
                    <i>Orders / Order # : <?=$_GET['id_number']?></i>
                </article>
                <hr>
                <article class="order-summary-details">
                    <article>
                        <?php
                        require 'public/connection.php';
                        $total;
                        $getIdNumber = $_GET['id_number'];
                        $status = "Running";
                        $getPos = $connect->prepare("SELECT id,id_number,pwd_senior_number,customer_type,ordered_date,total,discounted_price,amount_pay,status FROM tblpos WHERE id_number=? LIMIT 1");
                        echo $connect->error;
                        $getPos->bind_param('s',$getIdNumber);
                        $getPos->execute();
                        $getPos->bind_result($id,$idNumber,$pwdSeniorNumber,$customerType,$orderDate,$total,$discountedPrice,$amountPay,$statuss);
                        while( $getPos->fetch()){
                            ?>
                            <p><strong>Order #: </strong><?=$idNumber?></p>
                            <p><strong>PWD/Senior #: </strong><?=$pwdSeniorNumber?></p>
                            <p><strong>Customer Type: </strong><?=$customerType?></p>
                            <p><strong>Order Date: </strong><?=$orderDate?></p>
                        </article>
                        <article>
                            <p><strong>Total Amount: </strong><?=$total?></p>
                            <p><strong>Discounted Price: </strong><?=$discountedPrice?></p>
                            <p><strong>Amount Pay: </strong><?=$amountPay?></p>
                            <p><strong>Status: </strong><?=$statuss?></p>
                            <?php } ?>
                    </article>
                </article>
            </section>
            <section class="order-summary-2">
                <article class="tab-content">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="nav-item w-100">
                            <a class="nav-link active m-1  bg-dark text-white w-100" data-toggle="tab"
                                href="#orderProduct">Order Product</a>
                        </li>
                    </ul>
                    <article class="tab-pane active" id="orderProduct">
                        <div class="table-responsive table-container">
                            <div class="add-product">
                            </div>
                            <table id="example" class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
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
                                    $idNumber = $_GET['id_number'];
                                    $getOrderSummary = $connect->prepare("SELECT id,products,quantity,price,variation,category FROM tblposorders WHERE id_number=?");
                                    echo $connect->error;
                                    $getOrderSummary->bind_param('s',$idNumber);
                                    $getOrderSummary->execute();
                                    $getOrderSummary->bind_result($id,$productName,$quantity,$price,$variation,$category);
                                    while($getOrderSummary->fetch()){
                                   
                                        ?>
                                    <tr>
                                        <td><?=$id?></td>
                                        <td><?=$idNumber?></td>
                                        <td><?=$productName?></td>
                                        <td><?=$quantity?></td>
                                        <td><?=$price?></td>
                                        <td><?=$variation?></td>
                                        <td><?=$category?></td>
                                        <td><?=$subTotal = $price * $quantity;?></td>
                                    </tr>
                                    <?php
                                    }
                                    
                               ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td><b>Total Amount: </b></td>
                                        <td>PHP <?= $total?>.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </article>
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