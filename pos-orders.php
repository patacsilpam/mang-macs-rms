<?php

require 'public/admin-pos.php'
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="POS" content="Mang Macs-POS">
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
    <title>POS Orders</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h5>POS Orders (<?php echo date('F d, Y')?>)</h5>
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
                                    <th scope="col">Total</th>
                                    <th scope="col">Discounted Price</th>
                                    <th scope="col">Amount Pay</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require 'public/connection.php';
                                    $status = "Processing";
                                    $getPos = $connect->prepare("SELECT id,id_number,pwd_senior_number,customer_type,ordered_date,total,discounted_price,amount_pay,status FROM tblpos WHERE status=?");
                                    echo $connect->error;
                                    $getPos->bind_param('s',$status);
                                    $getPos->execute();
                                    $getPos->bind_result($id,$idNumber,$pwdSeniorNumber,$customerType,$orderDate,$total,$discountedPrice,$amountPay,$statuss);
                                    while( $getPos->fetch()){
                                        ?>
                                       <tr>
                                            <td><?=$id;?></td>
                                            <td>₱ <?=$total;?></td>
                                            <td>₱ <?=$discountedPrice;?></td>
                                            <td>₱ <?=$amountPay;?></td>
                                            <td>
                                                <?=$statuss;?>
                                                <button title="Edit" type="button" class="btn btn-transparent" data-toggle="modal" data-target="#editPosOrder<?=$idNumber?>"><i class="fas fa-edit" style="color: blue;"></i></button>
                                                <?php include 'assets/template/admin/pos-orders.php' ?>
                                            </td>
                                            <td>
                                                <a href="pos-order-summary.php?id_number=<?=$idNumber?>" title="View Order Details">
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
    <script src="assets/js/tab.js"></script>
</body>

</html>