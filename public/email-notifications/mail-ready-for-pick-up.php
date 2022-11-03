<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function mailReadyForPickUp($email,$orderNumber,$logo,$customerName,$orderDate,$orderType) {
    require 'public/connection.php';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mangmacspizzahouse@gmail.com';
    $mail->Password = ''; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('mangmacspizzahouse@gmail.com', "Mang Mac's Marinero");
    $mail->addAddress($email);
    $mail->isHTML(true);   
    $mail->Subject = "Your Order #".$orderNumber." is ready for pick up";
    $mail->Body =$mail->Body = "
        <div class='container' style='padding: 1rem;'>
        <div style='display: flex; flex-direction: column; align-items: center;'>
            <div class='logo-section'>
                <img src='$logo' width='50'>
                <strong>Mang Macs's Food Shop</strong>
            </div>
            <div class='icon-section' style='padding: 1rem;'>
                <i class='fa-regular fa-circle-check'></i>
            </div>
            <div style='text-align: center;'>
                <h3>Your order is ready for pick up!</h3>
                <!---Display customer name here using php-->
                <p>Hello ".$customerName."</p>
                <p style='text-align:justify;''>Your Order #".$orderNumber." is ready for pick up.</p>
            </div>
        </div>
        <hr style='border:0.3px solid #dbdbdb;'>
        <div>
            <strong>Order Summary</strong>
        </div>
        <div style = 'style:display:flex; flex-direction:column;'>
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
        </div>";
    $getOrders = $connect->prepare("SELECT tblcustomerorder.customer_name,tblcustomerorder.customer_address,
    tblcustomerorder.phone_number,tblorderdetails.product_name,tblorderdetails.product_variation,
    tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image,
    tblcustomerorder.total_amount,tblcustomerorder.delivery_fee
    FROM tblcustomerorder LEFT JOIN tblorderdetails
    ON tblcustomerorder.order_number = tblorderdetails.order_number
    WHERE tblorderdetails.order_number=?");
    $getOrders->bind_param('s',$orderNumber);
    $getOrders->execute();
    $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage,$totalAmount,$deliveryFee);
    while($getOrders->fetch()){
        $totalAmount = $price * $quantity;
        $mail->Body .= "<div>
        <div style='display: flex; flex-direction: row;'>
            <div>
                <img src='$productImage' width='150'>
            </div>
            <div>
                <p>$product</p>
                <p>$variation</p>
                <p> <span>Quantity:</span> <span>$quantity</span></p>
                <p><span>Price: PHP</span> <span> $price</span><span>.00</span></p>
                <p><span>Add Ons:</span> <span> $addOns</span></p>
            </div>
        </div>
    </div><hr style='border:0.3px solid #dbdbdb;'>";
    }
    $mail->Body .= " 
        <div style='display:flex; flex-direction: row; align-items: center;'>
            <h3>Delivery Fee:</h3>
            <p><span>$deliveryFee</span><span>.00</span></p>
        </div>
        <div style='display:flex; flex-direction: row; align-items: center;'>
            <h3>Total Amount:</h3>
            <p><span>$totalAmount</span><span>.00</span></p>
        </div>
        <hr style='border:0.3px solid #dbdbdb;'>
        <div>
            <h3>Delivery Details</h3>
            <p><span style='margin: 0 55px 0 0;' '>Recepient Name:</span><span>$customerName</span></p>
            <p><span style='margin: 0 60px 0 0;' '>Address:</span><span>$customerAddress</span></p>
            <p><span style='margin: 0 55px 0 0;' '>Phone Number:</span><span>$phoneNumber</span></p>
        
        <div>
        <div style='text-align:center'>
            <p>from</p></br>
            <h3>Mang Mac' s Food Shop</h3></br>
            <p>Zone 5, Barangay Sta. Lucia Bypass Road, Urdaneta, Philippines</p>
        </div>
    </div>";
    $mail->AltBody = 'FROM: mangmacspizzahouse@gmail.com';
    $mail->send();
}
?>