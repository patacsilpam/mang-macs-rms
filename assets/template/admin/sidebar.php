<div class="sidebar">
    <div class="burger"  id="menu">
        <i class="fa fa-bars text-white" style="font-size:1.7rem;"></i>
    </div>
    <h1 class="logo">Mang Macs Marinero <br> Pizza House</h1>
    <img class="img-logo" src="assets/images/logo.png" alt="mang macs logo">
    <ul class="sidebar-links">
         <!--Dashboard-->
        <li title="Dashboard" class="lists">
            <a href="dashboard.php"  class="link"><i class="fa-solid fa-gauge icons"></i><span class="span">Dashboard</span></a>
        </li>
         <!--Orders-->
        <li title="Orders">
            <a class="text-white" href="orders.php" data-toggle="collapse" data-target="#collapseOrders" role="button" aria-expanded="false">
            <i class="fas fa-shopping-cart icons"></i>
                <span class="span">Orders <i class="fas fa-angle-down icons"></i></span>
            </a>
            <!--Status order!-->
            <div class="collapse" id="collapseOrders">
                <div class="card card-body" style="background:#070b2e; padding:0; font-size:.9rem;">
                    <a class="text-white" href="orders.php">All</a>
                    <a class="text-white" href="order-pending.php">Pending</a>
                    <a class="text-white" href="order-processing.php">Order Processing</a>
                    <a class="text-white" href="order-out-for-delivery.php">Out for Delivery/<br/>Ready for Pick Up</a>
                    <a class="text-white" href="order-completed.php">Order Completed</a>
                    <a class="text-white" href="order-received.php">Order Received</a>
                    <a class="text-white" href="order-canceled.php">Canceled Orders</a>
                </div>
            </div>
        </li>
        <!--Reservation-->
        <li title="Reservation">
            <a class="text-white" href="reservation.php" data-toggle="collapse" data-target="#collapseReservation" role="button" aria-expanded="false">
                <i class="fas fa-ticket-alt icons"></i>
                <span class="span">Reservation <i class="fas fa-angle-down icons"></i></span>
            </a>
             <!--Status booking!-->
             <div class="collapse" id="collapseReservation">
                <div class="card card-body" style="background:#070b2e; padding:0; font-size:1rem;">
                    <a class="text-white" href="reservation.php">All</a>
                    <a class="text-white" href="book-pending.php">Pending</a>
                    <a class="text-white" href="book-reserved.php">Reserved</a>
                    <a class="text-white" href="book-completed.php">Completed</a>
                    <a class="text-white" href="book-canceled.php">Canceled/No Shows</a>
                </div>
            </div>
        </li>
        <!--Products-->
        <li title="Products">    
            <a class="text-white" href="products.php" data-toggle="collapse" data-target="#collapseProducts" role="button" aria-expanded="false">
            <i class="fas fa-box icons"></i>
                <span class="span">Products <i class="fas fa-angle-down icons"></i></span>
            </a>
            <div class="collapse" id="collapseProducts">
                <div class="card card-body" style="background:#070b2e; padding:0; font-size:1rem;">
                    <a class="text-white" href="products.php">Products</a>
                    <a class="text-white" href="create-add-on.php">Create Add-on</a>
                    <a class="text-white" href="available-menu.php">Available Menu</a>
                </div>
            </div>
        </li>
        <!--Point of sales-->
        <li title="POS">    
            <a class="text-white" href="pos.php" data-toggle="collapse" data-target="#collapsePOS" role="button" aria-expanded="false">
                <i class="fas fa-cash-register icons"></i>
                <span class="span">POS <i class="fas fa-angle-down icons"></i></span>
            </a>
            <div class="collapse" id="collapsePOS">
                <div class="card card-body"  style="background:#070b2e; padding:0; font-size:.9rem;">
                    <a class="text-white" href="pos.php">POS</a>
                    <a class="text-white" href="pos-orders.php">POS Orders</a>
                </div>
            </div>
        </li>
         <!--Inventory-->
        <li title="Inventory">
            <a href="stocks.php"><i class="fas fa-boxes icons"></i><span class="span">Inventory</span></a>
        </li>
         <!--Users-->
        <li title="Users">
            <a href="users.php"><i class="fas fa-users-cog icons"></i><span class="span">Users</span></a>
        </li>
        <hr style="width:100%;text-align:left;margin-left:0; background:#65656b; opacity:0.5;">
         <!--Report-->
        <li title="Report">
            <a href="report.php"><i class="fas fa-file icons"></i><span class="span">Report</span></a>
        </li>
    </ul>
</div>
</div>
<style>
    .text-collapse{
        color: #ffff;
    }
</style>