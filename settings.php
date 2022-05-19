<?php require 'public/admin-settings.php'; ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Dashboard" content="Mang Macs-Settings">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Settings</title>

</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Settings</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Settings Categories-->
        <main class="main-container">
            <section>
                <article>
                    <div class="settings-container">        
                        <!--Users Container--->
                        <div class="users-container" style="overflow-x:auto;">
                            <h4>Employee</h4>
                            <div>
                                <?php
                                //message box
                                if (isset($_GET['update-successfully'])) {
                                ?>
                                <small style="width:30%" class="alert alert-success msg-Success">User successfully
                                    updated.</small>
                                <?php
                                }
                                if ($unameError) {
                                ?>
                                <small style="width:30%" class="alert alert-danger msg-Error">Username already
                                    exists.</small>
                                <?php
                                }
                                ?>
                            </div>
                            <table class="display table" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name of Employee</th>
                                        <th>Employee</th>
                                        <th>Position</th>
                                        <th>Salary</th>
                                        <th>Date Registered</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $selectProduct = "SELECT * FROM tblusers";
                                    $displayProduct = $connect->query($selectProduct);
                                    while ($fetch = $displayProduct->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $fetch['id'] ?></td>
                                        <td><?= $fetch['fname'] . ' ' . $fetch['lname'] ?></td>
                                        <td><?= $fetch['uname'] ?></td>
                                        <td><?= $fetch['position'] ?></td>
                                        <td><?= $fetch['salary'] ?></td>
                                        <td><?= $fetch['created_at'] ?></td>
                                        <td style="display: flex;">
                                            <span><button title="Edit" type="button" class="btn btn-success"
                                                    data-toggle="modal" data-target="#editSalary<?= $fetch['id'] ?>"><i
                                                        class="fas fa-edit"></i></button></span>
                                            <?php require 'assets/template/admin/users.php' ?>&emsp;
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    
                        <div class="payment-container">
                            <!--Reservation Container--->
                            <div class="reservation-container">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                                    <div>
                                        <h3>Estimated Time of Delivery</h3>
                                        <input type="hidden" name="id">
                                        <input type="text" class="form-control" name="waitingTime"
                                            placeholder="Waiting Time (ex. 1 hr)" value="<?= $waitingTime ?>"
                                            required>&emsp;
                                    </div>
                                    <div>
                                        <h3>Delivery Charge</h3>
                                        <input type="number" class="form-control" name="deliveryChange"
                                            placeholder="Delivery Charge (ex. 50)" value="<?= $deliveryChange; ?>"
                                            required>
                                    </div><br>
                                    <div> 
                                        <button type="submit" name="edit" class="btn btn-success">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </article>
            </section>
        </main>
        <!--Sidebar-->
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/multiple-table.js"></script>
</body>

</html>