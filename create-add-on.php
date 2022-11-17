<?php require 'public/admin-products.php'?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Products" content="Mang Macs-Products">
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
    <title>Create Add-On</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Create Add-On</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Sales' Categories-->
        <main class="main-container">
            <section>
                <article>
                    <div class="table-responsive table-container">
                        <div class="add-product">
                            <button title="Add Product" type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAddOn">Create Choice Group &nbsp;
                                <i class="fas fa-plus"></i>
                            </button>
                            <?php include 'assets/template/admin/addOns.php'?>
                        </div> <br>
                        <table id="example" class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Choice Group</th>
                                    <th scope="col">Add Ons</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $getProductCategory = $connect->prepare("SELECT id,GROUP_CONCAT(add_ons SEPARATOR ','),
                                    GROUP_CONCAT(add_ons_price SEPARATOR ','),add_ons_category,GROUP_CONCAT(add_ons_quantity SEPARATOR ',') 
                                    FROM tbladdons GROUP BY add_ons_category");
                                    $getProductCategory->execute();
                                    $getProductCategory->store_result();
                                    $getProductCategory->bind_result($id,$addOnsName,$addOnsPrice,$addOnsCategory,$addOnsQty);
                                    while($getProductCategory->fetch()){
                                        ?>
                                        <tr>
                                            <td>Add ons of <?=$addOnsCategory?></td>
                                            <td><?=$addOnsName?></td>
                                            <td><?=$addOnsPrice?></td>
                                            <td style="display:flex;">
                                                <button title="View" type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewAddOns<?= $id; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>&nbsp;
                                                <button title="Edit" type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#editAddons<?=$id;?>">
                                                    <i class="fas fa-edit"></i>
                                                </button><?php include 'assets/template/admin/addOns.php'; ?> &nbsp;
                                                <button title="Delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteChoiceGroup<?=$id?>">
                                                    <i class="fas fa-trash"></i>
                                                </button> 
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
        <?php require_once 'public/admin-alert-product.php'?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
    <script src="assets/js/create-add-ons.js"></script>
</body>

</html>

<?php 


?>