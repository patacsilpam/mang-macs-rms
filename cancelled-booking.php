<?php require 'public/admin-inventory.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <title>Cancelled Booking</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h5>Cancelled Table Reservation (<?php echo date('F d, Y')?>)</h5>
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
                                    <th scope="col">Date</th>
                                    <th scope="col">Date Schedule</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">No. of Guests</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require 'public/connection.php';    
                                    $cancelled = "Cancelled";    
                                    $notApproved = "Not Approve";     
                                    if(isset($_GET['startDate']) && isset($_GET['endDate'])){           
                                        $startDate = $_GET['startDate'];
                                        $endDate = $_GET['endDate'];
                                        $getTotalOrder = $connect->prepare("SELECT id,created_at,customer_id,fname,lname,guests,scheduled_date,scheduled_time,status FROM tblreservation WHERE created_at BETWEEN (?) AND (?) HAVING status=? OR status=?");
                                        $getTotalOrder->bind_param('ssss',$startDate,$endDate,$cancelled,$notApproved);
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($id,$createdAt,$customerId,$fname,$lname,$guests,$schedDate,$schedTime,$bookStatus);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                ?>
                                                <tr>
                                                    <td><?= $id?></td>
                                                    <td><?= $createdAt?></td>
                                                    <td><?= $schedDate."  ".$schedTime?></td> 
                                                    <td><?= $fname." ".$lname?></td>
                                                    <td><?= $guests?></td>    
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else{
                                            echo "No Records Found";
                                        }
                                    
                                    } else{
                                        $date = date('Y-m-d');
                                        $getTotalOrder = $connect->prepare("SELECT id,created_at,customer_id,fname,lname,guests,scheduled_date,scheduled_time,status FROM tblreservation WHERE created_at=? HAVING status=? OR status=?");
                                        $getTotalOrder->bind_param('sss',$date,$cancelled,$notApproved);          
                                        $getTotalOrder->execute();
                                        $getTotalOrder->bind_result($id,$createdAt,$customerId,$fname,$lname,$guests,$schedDate,$schedTime,$bookStatus);
                                        if($getTotalOrder){
                                            while($getTotalOrder->fetch()){
                                                ?>
                                                <tr>
                                                    <td><?= $id?></td>
                                                    <td><?= $createdAt?></td>
                                                    <td><?= $schedDate." ".$schedTime?></td>
                                                    <td><?= $fname." ".$lname?></td>
                                                    <td><?= $guests?></td>          
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