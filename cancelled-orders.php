<?php require 'public/admin-inventory.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <title>Cancelled Orders</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h5>Cancelled Orders (<?php echo date('F d, Y')?>)</h5>
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
                            <h3>
                                <a href="dashboard.php" title="Back"><i class="fa fa-arrow-circle-left"></i></a>
                            </h3>
                            <form method="GET">
                                <label>From Date:</label>
                                <input type="date" name="startDate" value="<?php  echo $_GET['startDate']?>">&emsp;
                                <label>To Date:</label>
                                <input type="date" name="endDate" value="<?php  echo $_GET['endDate']?>">&emsp;
                                <button type="submit" class="btn btn-primary">
                                    Filter <i class="fa fa-filter" aria-hidden="true"></i>
                                </button> 
                            </form>
                        </div><br>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ordered Date</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Variation</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Order Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require 'public/connection.php';
                                    $totalAmount="";
                                    
                                    if(isset($_GET['startDate']) && isset($_GET['endDate'])){   
                                        $orderDeliver = "Deliver";
                                        $orderPickUp = "Pick Up"; 
                                        $orderStatus = "Cancelled";     
                                        $startDate = $_GET['startDate'];
                                        $endDate = $_GET['endDate'];
                                        $getTotalOrder = $connect->prepare("SELECT tblorderdetails.order_number,tblorderdetails.required_date,
                                        tblcustomerorder.customer_name,tblorderdetails.product_name,tblorderdetails.product_variation,
                                        tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
                                        tblorderdetails.add_ons,tblorderdetails.order_type 
                                        FROM tblorderdetails LEFT JOIN tblcustomerorder ON tblorderdetails.order_number = tblcustomerorder.order_number
                                        WHERE tblorderdetails.order_type IN (?,?) AND tblorderdetails.order_status=? 
                                        AND tblorderdetails.required_date  BETWEEN (?) AND (?)
                                        ORDER BY STR_TO_DATE(CONCAT(required_date,' ',required_time),'%Y-%m-%d %h:%i %p') ASC");
                                        echo $connect->error;
                                        $getTotalOrder->bind_param('sssss',$orderDeliver,$orderPickUp,$orderStatus,$startDate,$endDate);
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($orderNumber,$requiredDate,$customerName,$product,$variation,$quantity,$price,$subtotal,$addOns,$orderType);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                ?>
                                                <tr>
                                                    <td><?= $orderNumber?></td>
                                                    <td><?= $requiredDate?></td>
                                                    <td><?= $customerName?></td>
                                                    <td><?= $product?></td>
                                                    <td><?= $variation?></td>
                                                    <td><?= $quantity?></td>
                                                    <td><?= $price?></td>
                                                    <td><?= $subtotal?></td>
                                                    <td><?= $orderType?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else{
                                            echo "No Records Found";
                                        }
                                    
                                    } else{
                                        $orderDeliver = "Deliver";
                                        $orderPickUp = "Pick Up"; 
                                        $orderStatus = "Cancelled";
                                        $date = date('Y-m-d');
                                        $getTotalOrder = $connect->prepare("SELECT tblorderdetails.order_number,tblorderdetails.required_date,
                                        tblcustomerorder.customer_name,tblorderdetails.product_name,tblorderdetails.product_variation,
                                        tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
                                        tblorderdetails.add_ons,tblorderdetails.order_type 
                                        FROM tblorderdetails LEFT JOIN tblcustomerorder ON tblorderdetails.order_number = tblcustomerorder.order_number
                                        ORDER BY STR_TO_DATE(CONCAT(required_date,' ',required_time),'%Y-%m-%d %h:%i %p') ASC");
                                        $getTotalOrder->bind_param('ss',$date,$orderStatus);
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($orderNumber,$requiredDate,$customerName,$product,$variation,$quantity,$price,$subtotal,$addOns,$orderType);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                ?>
                                                <tr>
                                                    <td><?= $orderNumber?></td>
                                                    <td><?= $requiredDate?></td>
                                                    <td><?= $customerName?></td>
                                                    <td><?= $product?></td>
                                                    <td><?= $variation?></td>
                                                    <td><?= $quantity?></td>
                                                    <td><?= $price?></td>
                                                    <td><?= $subtotal?></td>
                                                    <td><?= $orderType?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
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
    <script src="assets/js/table.js"></script>
</body>

</html>