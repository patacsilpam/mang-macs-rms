<?php require 'public/admin-inventory.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4adbff979d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Report Generation</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Report Generation</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php' ?>
            </ul>
        </header>
        <!--Sales' Categories-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <div class="filter-date">
                            <h3> </h3>
                            <form method="GET">
                                <label> Choose User Type</label>
                                <select name="userType">
                                    <option value="Admin"<?php if(isset($_GET['userType']) == "Admin"){echo 'selected ? "selected"';}?>>Admin</option>
                                    <option value="Staff"<?php if(isset($_GET['userType']) == "Staff"){echo 'selected ? "selected"';}?>>Staff</option>
                                    <option value="All"<?php if(isset($_GET['userType']) == "All"){echo 'selected ? "selected"';}?>>All</option>
                                </select>&emsp;
                                <label>From Date:</label>
                                <input type="date" name="startDate" value="<?php  echo $_GET['startDate']?>">&emsp;
                                <label>To Date:</label>
                                <input type="date" name="endDate" value="<?php  echo $_GET['endDate']?>">&emsp;
                                <button type="submit" class="btn btn-primary">
                                    Filter <i class="fa fa-filter" aria-hidden="true"></i>
                                </button>
                                <a href="report-generation.php?startDate=<?php if(isset($_GET['startDate'])) {echo $_GET['startDate'];} else{ echo date('Y-m-d',strtotime("first day of january this year"));}?>&endDate=<?php if(isset($_GET['endDate'])){ echo $_GET['endDate'];} else{ echo date('Y-m-d',strtotime("last day of december this year"));}?>&userType=<?php if(isset($_GET['userType'])){ echo $_GET['userType'];} else{echo "All";}?>"
                                    class="btn btn-success">
                                    <span>Export <i class="fa fa-file-pdf"></i></span>
                                </a>
                            </form>
                        </div><br>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Variation</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Add Ons</th>
                                    <th scope="col">Add Ons Fee</th>
                                    <th scope="col">Order Type</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require 'public/connection.php';
                                    $totalAmount=0;
                                    error_reporting(0);
                                    if($_GET['userType'] == "All"){  
                                        $orderCompleted = "Order Completed";
                                        $orderReceived = "Order Received";     
                                        $startDate = $_GET['startDate'];
                                        $endDate = $_GET['endDate'];
                                        $getTotalOrder = $connect->prepare("SELECT tblreport.fullname,tblreport.sales,tblreport.user_type,tblreport.report_date,
                                        tblorderdetails.product_name,tblorderdetails.product_category,tblorderdetails.product_variation, tblorderdetails.quantity,
                                        tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
                                        tblorderdetails.add_ons,tblorderdetails.add_ons_fee, tblorderdetails.order_type
                                        FROM `tblreport` RIGHT JOIN tblorderdetails ON tblreport.order_number = tblorderdetails.order_number 
                                        WHERE tblorderdetails.order_status IN (?,?)  AND tblreport.report_date BETWEEN (?) AND (?)");
                                        $getTotalOrder->bind_param('ssss',$orderCompleted,$orderReceived,$startDate,$endDate);
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($fullname,$sales,$userType,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$subTotal,$addOns,$addOnsFee,$orderType);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                $totalAmount +=$subTotal;
                                                ?>
                                                <tr>
                                                    <td><?= $fullname?></td>
                                                    <td><?= $userType?></td>
                                                    <td><?= $reportDate?></td>
                                                    <td><?= $productName?></td>
                                                    <td><?= $productCategory?></td>
                                                    <td><?= $productVariation?></td>
                                                    <td><?= $quantity?></td>
                                                    <td><?= $price?></td>
                                                    <td><?= $addOns?></td>
                                                    <td><?= $addOnsFee?></td>
                                                    <td><?= $orderType?></td>
                                                    <td><?= $price * $quantity?></td>
                                                </tr> 
                                            <?php } ?> 
                                                <tr>
                                                    <td colspan="11"></td>
                                                    <td><b>Sales(All):&emsp;</b>₱ <?= $totalAmount?>.00 </td>
                                                </tr>  
                                            <?php }
                                            else{
                                                echo "No Records Found";
                                            }
                                        }
                                        else if(isset($_GET['userType']) == "Admin" || isset($_GET['userType']) == "Staff"){
                                            $orderCompleted = "Order Completed";
                                            $orderReceived = "Order Received";
                                            $userType = $_GET['userType'];       
                                            $startDate = $_GET['startDate'];
                                            $endDate = $_GET['endDate'];
                                            $getTotalOrder = $connect->prepare("SELECT tblreport.fullname,tblreport.sales,tblreport.user_type,tblreport.report_date,
                                            tblorderdetails.product_name,tblorderdetails.product_category,tblorderdetails.product_variation, tblorderdetails.quantity,
                                            tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
                                            tblorderdetails.add_ons,tblorderdetails.add_ons_fee, tblorderdetails.order_type
                                            FROM `tblreport` LEFT JOIN tblorderdetails ON tblreport.order_number = tblorderdetails.order_number 
                                            WHERE tblorderdetails.order_status IN (?,?) AND tblreport.user_type = ? AND tblreport.report_date BETWEEN (?) AND (?)");
                                            $getTotalOrder->bind_param('sssss',$orderCompleted,$orderReceived,$userType,$startDate,$endDate);
                                            $getTotalOrder->execute();
                                            $getTotalOrder->bind_result($fullname,$sales,$userType,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$subTotal,$addOns,$addOnsFee,$orderType);
                                            if($getTotalOrder){
                                                while($getTotalOrder->fetch()){
                                                    $totalAmount += $subTotal;
                                                    ?>
                                                    <tr>
                                                        <td><?= $fullname?></td>
                                                        <td><?= $userType?></td>
                                                        <td><?= $reportDate?></td>
                                                        <td><?= $productName?></td>
                                                        <td><?= $productCategory?></td>
                                                        <td><?= $productVariation?></td>
                                                        <td><?= $quantity?></td>
                                                        <td><?= $price?></td>
                                                        <td><?= $addOns?></td>
                                                        <td><?= $addOnsFee?></td>
                                                        <td><?= $orderType?></td>
                                                        <td><?= $subTotal?></td>
                                                    </tr> 
                                                <?php } ?> 
                                                    <tr>
                                                        <td colspan="11"></td>
                                                        <td><b>Sales in <?=$userType?>:&emsp;</b>₱ <?= $totalAmount?>.00 </td>
                                                    </tr>  
                                                <?php }
                                                else{
                                                    echo "No Records Found";
                                                }
                                        }
                                         else{
                                           // $date = date('Y-m-d');
                                            $orderCompleted = "Order Completed";
                                            $orderReceived = "Order Received";
                                            $getTotalOrder = $connect->prepare("SELECT tblreport.fullname,tblreport.sales,tblreport.user_type,tblreport.report_date, 
                                            tblorderdetails.product_name,tblorderdetails.product_category,tblorderdetails.product_variation, 
                                            tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
                                            tblorderdetails.add_ons,tblorderdetails.add_ons_fee,
                                            tblorderdetails.order_type FROM `tblreport` LEFT JOIN tblorderdetails 
                                            ON tblreport.order_number = tblorderdetails.order_number 
                                            WHERE tblorderdetails.order_status IN (?,?)");
                                            $getTotalOrder->bind_param('ss',$orderCompleted,$orderReceived);
                                            $getTotalOrder->execute();
                                            $getTotalOrder->bind_result($fullname,$sales,$userType,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$subTotal,$addOns,$addOnsFee,$orderType);
                                            if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                $totalAmount += $subTotal;
                                            ?>
                                            <tr>
                                                <td><?= $fullname?></td>
                                                <td><?= $userType?></td>
                                                <td><?= $reportDate?></td>
                                                <td><?= $productName?></td>
                                                <td><?= $productCategory?></td>
                                                <td><?= $productVariation?></td>
                                                <td><?= $quantity?></td>
                                                <td><?= $price?></td>
                                                <td><?= $addOns?></td>
                                                <td><?= $addOnsFee?></td>
                                                <td><?= $orderType?></td>
                                                <td><?= $price * $quantity?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="11"></td>
                                                <td><b>Sales(All):&emsp;</b>₱ <?= number_format($totalAmount)?>.00 </td>
                                            </tr>    
                                            <?php }
                                            else{
                                                echo "No Records Found";
                                            }
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
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
</body>

</html>