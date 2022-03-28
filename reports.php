<?php require 'public/admin-inventory.php'; ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Reports" content="Mang Macs-Resports">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Reports</title>
</head>

<body>
    <div class="grid-container">
        <!--header-->
        <header class="nav-container">
            <h3>Reports</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php' ?>
            </ul>
        </header>
        <!--Inventory Container-->
        <main class="main-container">
            <section>
                <article>
                    <div class="boxes">
                        <div class="line-box-1">
                            <div class="box1">
                                <h5 class="text-sales">Sales</h5>
                                <div class="generate-pdf-box">
                                    <span class="text-pdf bg-info">View Info</span>
                                    <a href="sales.php" class="icon-pdf btn-info"><i
                                            class="fas fa-arrow-circle-right icons"></i></a>
                                </div>
                            </div>
                            <div class="box2">
                                <h5 class="text-sales">Reservation</h5>
                                <div class="htmlToPdf" style="display:none;">
                                    <span>Mang Macs Marinero</span>
                                </div>
                                <div class="generate-pdf-box">
                                    <span class="text-pdf bg-info">Generate PDF</span>
                                    <a href="total-reservation.php" class="icon-pdf btn-info"><i
                                            class="far fa-file-pdf icons"></i></a>
                                </div>
                            </div>
                            <div class="box3">
                                <h5 class="text-sales">Delivery</h5>
                                <div class="generate-pdf-box">
                                    <span class="text-pdf bg-info">Generate PDF</span>
                                    <a href="delivery.php" class="icon-pdf btn-info"><i
                                            class="far fa-file-pdf icons"></i></a>
                                </div>
                            </div>
                            <div class="box4">
                                <h5 class="text-sales">Stocks</h5>
                                <div class="generate-pdf-box">
                                    <span class="text-pdf bg-info">Generate PDF</span>
                                    <a href="stock.php" class="icon-pdf btn-info"><i
                                            class="far fa-file-pdf icons"></i></a>
                                </div>
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
</body>

</html>
