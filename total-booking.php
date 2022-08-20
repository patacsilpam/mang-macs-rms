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
    <title>Total Booking</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h5>Total Reservation (<?php echo date('F d, Y')?>)</h5>
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
                                <a href="total-booking-report.php?startDate=<?php if(isset($_GET['startDate'])) {echo $_GET['startDate'];} else{ echo date('Y-m-d',strtotime("first day of january this year"));}?>&endDate=<?php if(isset($_GET['endDate'])){ echo $_GET['endDate'];} else{ echo date('Y-m-d',strtotime("last day of december this year"));}?>"
                                    class="btn btn-success">
                                    <span>Export <i class="fa fa-file-pdf"></i></span>
                                </a>
                            </form>
                        </div><br>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Booked Date</th>
                                    <th scope="col">Customer ID</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Guests</th>
                                    <th scope="col">Scheduled Date</th>             
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require 'public/connection.php';   
                                    $bookStatus = "Approve";
                                    $removeStatus = "Remove";          
                                    if(isset($_GET['startDate']) && isset($_GET['endDate'])){           
                                        $startDate = $_GET['startDate'];
                                        $endDate = $_GET['endDate'];
                                        $getTotalOrder = $connect->prepare("SELECT id,created_at,customer_id,email,fname,lname,guests,scheduled_date,scheduled_time FROM tblreservation WHERE status=?  HAVING created_at BETWEEN (?) AND (?)");
                                        echo $connect->error;
                                        $getTotalOrder->bind_param('sss',$bookStatus,$startDate,$endDate);
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($id,$createdAt,$customerId,$email,$fname,$lname,$guests,$schedDate,$schedTime);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                ?>
                                                <tr>
                                                    <td><?= $id?></td>
                                                    <td><?= $createdAt?></td>
                                                    <td><?= $customerId?></td>
                                                    <td><?= $email?></td>
                                                    <td><?= $fname." ".$lname?></td>
                                                    <td><?= $guests?></td>
                                                    <td><?= $schedDate."  ".$schedTime?></td>     
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else{
                                            echo "No Records Found";
                                        }
                                    
                                    } else{
                                        $date = date('Y-m-d');
                                        $getTotalOrder = $connect->prepare("SELECT id,created_at,customer_id,email,fname,lname,guests,scheduled_date,scheduled_time FROM tblreservation WHERE status=? AND created_at=?");
                                        $getTotalOrder->bind_param('ss',$bookStatus,$date);        
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($id,$createdAt,$customerId,$email,$fname,$lname,$guests,$schedDate,$schedTime);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                ?>
                                                <tr>
                                                    <td><?= $id?></td>
                                                    <td><?= $createdAt?></td>
                                                    <td><?= $customerId?></td>
                                                    <td><?= $email?></td>
                                                    <td><?= $fname." ".$lname?></td>
                                                    <td><?= $guests?></td>
                                                    <td><?= $schedDate." ".$schedTime?></td>    
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