<?php require 'public/admin-inventory.php'; ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Inventory" content="Mang Macs-Inventory">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <button title="Add" type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#addInventory">Add &nbsp;<i class="fas fa-plus"></i></button>
                            <?php require 'assets/template/admin/inventory.php' ?>
                            <br><br>
                        </div>
                        <div>
                            <?php
                            //message box for registration
                            if (isset($_GET['insert-successfully'])) {
                            ?>
                                <small style="width:30%" class="alert alert-success msg-Success">Item successfully inserted.</small>
                            <?php
                            }
                            if (isset($_GET['update-successfully'])) {
                            ?>
                                <small style="width:30%" class="alert alert-success msg-Success">Item successfully updated.</small>
                            <?php
                            }
                            ?>
                        </div>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">EXP</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity Purchased</th>
                                    <th scope="col">Quantity in Stock</th>
                                    <th scope="col">Quantity Sold</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">In charge</th>
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
                                    if ($exp < $todayDate) {
                                        $highligtRow = "#ff4444";
                                    }
                                    if ($exp > $todayDate) {
                                        $highligtRow = "#ffffff";
                                    }
                                ?>
                                    <tr style="background: <?php echo $highligtRow; ?>;">
                                        <th scope="row"><?= $fetch['id'] ?></th>
                                        <td><?= $fetch['created_at'] ?></td>
                                        <td><?= $fetch['expiration_date'] ?></td>
                                        <td><?= $fetch['product'] ?></td>
                                        <td><?= $fetch['quantityPurchased'] ?></td>
                                        <td><?= $fetch['quantityInStock'] ?></td>
                                        <td><?= $fetch['quantitySold'] ?></td>
                                        <td><?= $fetch['status'] ?></td>
                                        <td><?= $fetch['in_charge'] ?></td>
                                        <td style="display: flex;">
                                            <span><button title="Edit" type="button" class="btn btn-success" data-toggle="modal" data-target="#editInventory<?= $fetch['id'] ?>"><i class="fas fa-edit"></i></button></span>
                                            <?php require 'assets/template/admin/inventory.php' ?>&emsp;
                                            <span><button title="Delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteInventory<?= $fetch['id'] ?>"><i class="fas fa-trash"></i></button></span>
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
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/table.js"></script>
</body>

</html>