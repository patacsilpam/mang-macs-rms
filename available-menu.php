<?php require 'public/admin-products.php'?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Products" content="Mang Macs-Products">
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
    <title>Products</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Available Menu</h3>
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
                                    <th scope="col">Category</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Variation</th>
                                    <th scope="col">Stocks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $getProductCategory = $connect->prepare("SELECT id,productCategory,productName,productVariation,stocks FROM tblproducts GROUP BY productName");
                                    $getProductCategory->execute();
                                    $getProductCategory->store_result();
                                    $getProductCategory->bind_result($id,$productCategory,$productName,$productVariation,$stocks);
                                    while($getProductCategory->fetch()){
                                        ?>
                                        <tr>
                                            <td><?=$id?></td>
                                            <td><?=$productCategory?></td>
                                            <td><?=$productName?></td>
                                            <td><?=$productVariation?></td>
                                            <td><small>Starts from </small><?=$stocks?></td>
                                            <td>
                                            <button title="View" type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#viewStocks<?= $id; ?>"><i
                                                class="fas fa-eye"></i></button>&emsp;
                                            <?php include 'assets/template/admin/editStocks.php'; ?> 
                                            <button value="<?php if(empty($productVariation)) {echo "null";} else{ echo $productVariation;} ?>" title="Edit" type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#editStocks<?=$id;?>" onclick="clickStocks(this)"><i
                                                class="fas fa-edit"></i></button>    
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
        <?php if(isset($_SESSION['status']) && isset($_SESSION['status']) != ""){
            ?>
            <script>
                swal({
                    title: "<?php echo $_SESSION['status']; ?>",
                    text: "<?php echo $_SESSION['message']; ?>",
                    icon: "<?php echo $_SESSION['status_code']; ?>",
                    button: "Ok",
                    });
            </script>
            <?php
            unset($_SESSION['status']);
        } ?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
    <script src="assets/js/products.js"></script>
  
</body>

</html>

<?php 


?>