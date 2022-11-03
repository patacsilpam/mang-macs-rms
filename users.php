<?php require 'public/admin-users.php' ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Users" content="Mang Macs-Users">
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
    <title>Users</title>
   
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Users</h3>
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
                            <button title="Add Product" type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#addUsers">Add &nbsp;
                                <i class="fas fa-plus"></i>
                            </button>
                            <?php include 'assets/template/admin/users.php'?>
                        </div> <br>
                       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                       <!--Show All users in a table--->
                            <table id="example" class="table table-hover">
                                <thead class="thead-dark"> 
                                    <th scope="col">#</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Account Type</th>
                                    <th scope="col">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $selectUsers = "SELECT * FROM tblusers";
                                    $displayUsers = $connect->query($selectUsers);
                                    while ($fetch = $displayUsers->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $fetch['id'] ?></th>
                                            <td><?= $fetch['created_at'] ?></td>
                                            <td><?= $fetch['fname'] . ' ' . $fetch['lname'] ?></td>
                                            <td><?= $fetch['uname'] ?></td>
                                            <td><?= $fetch['email'] ?></td>
                                            <td><?= $fetch['position'] ?></td>
                                            <td style="display: flex;">
                                                <span><button title="View" type="button" class="btn btn-primary" data-toggle="modal" data-target="#showUsers<?= $fetch['id'] ?>"><i class="fas fa-eye"></i></button></span>&emsp;
                                                <span><button title="Edit" type="button" class="btn btn-success" data-toggle="modal" data-target="#editUsers<?= $fetch['id'] ?>" onclick="clickPos(this)" value="<?=$fetch['position']?>"><i class="fas fa-edit"></i></button></span>
                                                <?php include 'assets/template/admin/users.php' ?>&emsp;
                                                <span><button title="Delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUsers<?= $fetch['id'] ?>"><i class="fas fa-trash"></i></button></span>
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
        <?php require_once 'public/admin-alert-inventory.php'?>
    </div>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/activePage.js"></script>
    <script src="assets/js/table.js"></script>
    <script src="assets/js/password-visibility.js"></script>
</body>

</html>