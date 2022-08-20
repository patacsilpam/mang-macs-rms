<?php require 'public/admin-inventory.php'; ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Inventory" content="Mang Macs-Inventory">
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
    <title>Inventory</title>
</head>

<body>
    <div class="grid-container">
        <!--header-->
        <header class="nav-container">
            <h3>Stocks</h3>
            <ul class="nav-list">
            <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Inventory Container-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <div class="add-product">
                            <button title="Add Product" type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#addInventory">Add &nbsp;
                                <i class="fas fa-plus"></i>
                            </button>
                            <?php include 'assets/template/admin/inventory.php'?>
                        </div> <br>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                            <table id="example" class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Purchased Date</th>
                                        <th scope="col">EXP Date</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item Purchased</th>
                                        <th scope="col">Item Stock</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $selectInventory = "SELECT * FROM tblinventory";
                                    $displayInventory = $connect->query($selectInventory);
                                    while ($fetch = $displayInventory->fetch_assoc()) {
                                        $today = date('y-m-d');
                                        $expiredDate = $fetch['expiration_date'];
                                        $offset = strtotime("+1 day");
                                        $endDate = date($expiredDate, $offset);
                                        $todayDate = new DateTime($today);
                                        $exp = new DateTime($endDate);
                                        if ($exp > $todayDate) {
                                            $highligtRow = "#e6dccc";
                                        }
                                    ?>
                                        <tr style="background: <?php echo $highligtRow; ?>;">
                                            <th scope="row"><?= $fetch['id'] ?></th>
                                            <td><?= date('F d, Y',strtotime($fetch['created_at'])) ?></td>
                                            <td><?= date('F d, Y',strtotime($fetch['expiration_date'])) ?></td>
                                            <td><?= $fetch['product'] ?></td>
                                            <td><?= $fetch['quantityPurchased'] ?></td>
                                            <td><?= $fetch['quantityInStock'] ?></td>
                                            <td style="display: flex;">
                                                <?php require 'assets/template/admin/inventory.php' ?>
                                                <span><button title="View" type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#viewStocks<?= $fetch['id']; ?>"><i class="fas fa-eye"></i></button></span>
                                                <span><button title="Edit" type="button" class="btn btn-success mr-3" data-toggle="modal" data-target="#editInventory<?= $fetch['id'] ?>"><i class="fas fa-edit"></i></button></span>
                                                <span><button title="Delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteInventory<?= $fetch['id'] ?>"><i class="fas fa-trash"></i></button></span>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </article>
            </section>
        </main>
        <!--Sidebar-->
        <?php include 'assets/template/admin/sidebar.php'?>
         <!--Insert sweet alert message-->
         <?php if(isset($_GET['inserted'])){
            ?>
            <script>
                swal({
                    title: "Successful",
                    text: "Insert new item successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        //error sweet alert message
        else{
            if(isset($_GET['error'])){
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Could not insert item.",
                        icon: "error",
                        button: "Ok",
                        });
                </script>
            <?php
            }
        }
        ?>
       
        <?php
        if(isset($_GET['updated'])){
             //update sweet alert message
            ?>
             <script>
                swal({
                    title: "Successful",
                    text: "Update item successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else{
            if(isset($_GET['update_item_error'])){
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Could not update item.",
                        icon: "error",
                        button: "Ok",
                        });
                </script>
                <?php
            }
        }
        ?>
        <?php
        if(isset($_GET['deleted'])){
            ?>
             <script>
               swal({
                    title: "Successful",
                    text: "Delete item successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else{
            if(isset($_GET['delete_item_error'])){
            ?>
            <script>
                swal({
                    title: "Error",
                    text: "Could not delete item.",
                    icon: "error",
                    button: "Ok",
                    });
            </script>
            <?php
            }
        }
        ?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
</body>

</html>