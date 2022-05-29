<?php require 'public/admin-inventory.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <title>POS Orders</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>POS Orders</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php' ?>
            </ul>
        </header>
        <!--Sales' Categories-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <div class="add-product">
                            <a href="dashboard.php" class="btn btn-primary" title="Back to Dashboard">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <form method="GET">
                                <label>From Date:</label>
                                <input type="date" name="startDate" value="<?php  echo $_GET['startDate']?>">&emsp;
                                <label>To Date:</label>
                                <input type="date" name="endDate" value="<?php  echo $_GET['endDate']?>">&emsp;
                                <button type="submit" class="btn btn-primary">
                                    Filter <i class="fa fa-filter" aria-hidden="true"></i>
                                </button>
                                <a href="total-pos-report.php?startDate=<?php if(isset($_GET['startDate'])) {echo $_GET['startDate'];} else{ echo date('Y-m-d',strtotime("first day of january this year"));}?>&endDate=<?php if(isset($_GET['endDate'])){ echo $_GET['endDate'];} else{ echo date('Y-m-d',strtotime("last day of december this year"));}?>"
                                    class="btn btn-success">
                                    <span>Export <i class="fa fa-file-pdf"></i></span>
                                </a>
                            </form>
                        </div><br>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Ordered Date</th>
                                    <th scope="col">ID Number</th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Variation</th>
                                    <th scope="col">Customer Type</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require 'public/connection.php';    
                                    $totalRevenue = 0;                   
                                    if(isset($_GET['startDate']) && isset($_GET['endDate'])){
                                        $startDate = $_GET['startDate'];
                                        $endDate = $_GET['endDate'];
                                        $getTotalOrder = $connect->prepare("SELECT tblpos.ordered_date,tblpos.id_number,tblposorders.products,
                                        tblposorders.quantity, tblposorders.price,tblposorders.category,tblposorders.variation, 
                                        tblpos.customer_type,tblpos.total 
                                        FROM tblpos LEFT JOIN tblposorders ON tblpos.id_number = tblposorders.id_number
                                        WHERE ordered_date BETWEEN (?) AND (?)");
                                        echo $connect->error;
                                        $getTotalOrder->bind_param('ss',$startDate,$endDate);
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($orderedDate,$idNumber,$products,$quantity,$price,$category,$variation,$customerType,$total);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                $totalRevenue += $total;
                                                ?>
                                            <tr>
                                                <td><?= $orderedDate;?></td>
                                                <td><?= $idNumber;?></td>
                                                <td><?= $products;?></td>
                                                <td><?= $quantity?></td>
                                                <td><?= $price?></td>
                                                <td><?= $category?></td>
                                                <td><?= $variation?></td>
                                                <td><?= $customerType?></td>
                                                <td><?= $total?></td>
                                            </tr>
                                <?php
                                        }
                                      }
                                        else{
                                            echo "No Records Found";
                                        }
                                    } else{
                                        $getTotalOrder = $connect->prepare("SELECT tblpos.ordered_date,tblpos.id_number,tblposorders.products,
                                        tblposorders.quantity, tblposorders.price,tblposorders.category,tblposorders.variation, 
                                        tblpos.customer_type,tblpos.total 
                                        FROM tblpos LEFT JOIN tblposorders ON tblpos.id_number = tblposorders.id_number");
                                        echo $connect->error;
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($orderedDate,$idNumber,$products,$quantity,$price,$category,$variation,$customerType,$total);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                $totalRevenue += $total;
                                                ?>
                                <tr>
                                    <td><?= $orderedDate;?></td>
                                    <td><?= $idNumber;?></td>
                                    <td><?= $products;?></td>
                                    <td><?= $quantity?></td>
                                    <td><?= $price?></td>
                                    <td><?= $category?></td>
                                    <td><?= $variation?></td>
                                    <td><?= $customerType?></td>
                                    <td><?= $total?></td>
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
                            <tfoot>
                                <tr>
                                    <td colspan="8">Total Revenue: PHP <?=$totalRevenue;?>.00</td>
                                </tr>
                            </tfoot>
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