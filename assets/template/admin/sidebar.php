<div class="sidebar">
    <div class="burger"  id="menu">
        <i class="fa fa-bars text-white" style="font-size:1.7rem;"></i>
    </div>
    <h1 class="logo">Mang Macs Marinero <br> Pizza House</h1>
    <img class="img-logo" src="assets/images/logo.png" alt="mang macs logo">
    <ul class="sidebar-links">
        <li title="Dashboard" class="lists">
            <a href="dashboard.php"  class="link"><i class="fas fa-tachometer-alt icons"></i><span class="span">Dashboard</span></a>
        </li>
        <li title="Orders">
            <a href="orders.php"><i class="fas fa-shopping-cart icons"></i><span class="span">Orders</span></a>
        </li>
        <li title="Reservation">
            <a href="reservation.php"><i class="fas fa-ticket-alt icons"></i><span class="span">Reservation</span></a>
        </li>
        <li title="Products">    
            <a class="text-white" href="products.php" data-toggle="collapse" data-target="#collapseProducts" role="button" aria-expanded="false">
            <i class="fas fa-box icons"></i>
                <span class="span">Products <i class="fas fa-angle-down icons"></i></span>
            </a>
            <div class="collapse" id="collapseProducts">
                <div class="card card-body" style="background:#040720; padding:0;">
                    <a class="text-white" href="products.php">Products</a>
                    <a class="text-white" href="available-menu.php">Available Menu</a>
                </div>
            </div>
        </li>
        <li title="POS">    
            <a class="text-white" href="pos.php" data-toggle="collapse" data-target="#collapsePOS" role="button" aria-expanded="false">
                <i class="fas fa-cash-register icons"></i>
                <span class="span">POS <i class="fas fa-angle-down icons"></i></span>
            </a>
            <div class="collapse" id="collapsePOS">
                <div class="card card-body" style="background:#040720; padding:0;">
                    <a class="text-white" href="pos.php">POS</a>
                    <a class="text-white" href="pos-orders.php">POS Orders</a>
                </div>
            </div>
        </li>
        <li title="Stocks">
            <a href="inventory.php"><i class="fas fa-boxes icons"></i><span class="span">Inventory</span></a>
        </li>
        <li title="Users">
            <a href="users.php"><i class="fas fa-users-cog icons"></i><span class="span">Users</span></a>
        </li>
        <hr style="width:100%;text-align:left;margin-left:0; background:#65656b; opacity:0.5;">
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