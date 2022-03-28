<?php

echo " <div class='container' style='padding: 1rem;'>
<div style='display: flex; flex-direction: column; align-items: center;'>
    <div class='logo-section'>
        <img src='assets/images/logo.png' width='50'>
        <strong>Mang Macs's Food Shop</strong>
    </div>
    <div class='icon-section' style='padding: 1rem;'>
        <i class='fa-regular fa-circle-check'></i>
    </div>
    <div>
        <h3 style='text-align: center;'>Your order has been confirmed!</h3>
        <p style='text-align: center;'>Hello ".$customerName."</p>
        <p style='text-align: center;>
        Your order $orderNumber has on its way.</p>
    </div>
</div>
<hr style='border:0.3px solid #dbdbdb;'>
<div>
    <strong>Order Summary</strong>
</div>
<div>
    <div style='display: flex; justify-content: space-between;'>
        <p style='width:150px;'>Order Number:</p>
        <p>".$orderNumber."</p>
    </div>
    <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
        <p style='width:150px;'>Order Date:</p>
        <p>".$orderDate."</p>
    </div>
    <div style='display: flex; justify-content: space-between;'>
        <p style='width:150px;'>Order Type:</p>
        <p>".$orderType."</p>
    </div>  
</div>
</div>";
?>


  