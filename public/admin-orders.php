<?php
use PHPMailer\PHPMailer\PHPMailer;

function updateOrderStatus(){
    require 'public/connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['btn-update'])){
            $customerName = $_POST['customerName'];
            $orderType = $_POST['orderType'];
            $orderStatus = $_POST['orderStatus'];
            $orderNumber = $_POST['orderNumber'];
            $orderDate = $_POST['orderDate'];
            $email = $_POST['email'];
            require 'php-mailer/vendor/autoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mangmacsmarinerospizzahouse@gmail.com';
            $mail->Password = 'mangmacsmarineros';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('mangmacsmarinerospizzahouse@gmail.com', "Mang Mac's Marinero");
            $mail->addAddress($email);
            $mail->isHTML(true);
            if($orderType == "Dine in"){
                $OrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=? WHERE order_number=?");
                $OrderStatus->bind_param('ss',$orderStatus,$orderNumber);
                $OrderStatus->execute();
                if($OrderStatus){
                    if($orderStatus == "Delivered"){
                        $mail->Subject = "Your Order #".$orderNumber." has been completed";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <h3>Your order has been completed!</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:justify;''>Thank you for purchasing at <b>Mang Mac's Food Shop.</b> Enjoy your meal.&#128512;</p>
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
                    $getOrders = $connect->prepare("SELECT product_name,product_variation,quantity,price,add_ons,product_image FROM tblorderdetails WHERE order_number=?");
                    $getOrders->bind_param('s',$orderNumber);
                    $getOrders->execute();
                    $getOrders->bind_result($product,$variation,$quantity,$price,$addOns,$productImage);
                    $totalAmount = "";
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
                            <h3>Total Amount:</h3>
                            <p><span>$totalAmount</span><span>.00</span></p>
                        </div>
                        <hr style='border:0.3px solid #dbdbdb;'>
                        <div style='display:flex; flex-direction: column; align-items: center;'>
                            <p>from</p></br>
                            <h3>Mang Mac' s Food Shop</h3></br>
                            <p>Zone 5, Barangay Sta. Lucia Bypass Road, Urdaneta, Philippines</p>
                        </div>
                    </div>";
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:orders.php?updated');
                    }
                }
            }
            //update delivery order status to order received
            else if($orderType == "Delivery"){
                $OrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=? WHERE order_number=?");
                $OrderStatus->bind_param('ss',$orderStatus,$orderNumber);
                $OrderStatus->execute();   
                if($OrderStatus){
                    if($orderStatus == "Order Received"){
                        $mail->Subject = "Your Order #".$orderNumber." has been completed";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <h3>Your order has been confirmed!</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:justify;''>Thank you for purchasing at <b>Mang Mac's Food Shop.</b> Your order <span>".$orderNumber."</span> has been approved. You will receive another email when your order has been shipped.</p>
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
                    tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image
                    FROM tblcustomerorder LEFT JOIN tblorderdetails
                    ON tblcustomerorder.order_number = tblorderdetails.order_number
                    WHERE tblorderdetails.order_number=?");
                    echo $connect->error;
                    $getOrders->bind_param('s',$orderNumber);
                    $getOrders->execute();
                    $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage);
                    $totalAmount="";
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
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:orders.php?updated');
                    }
                    //update delivery order status to shipped
                    else if($orderStatus == "Shipped"){
                        $mail->Subject = "Your Order #".$orderNumber." has been shipped";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <h3>Your order has been shipped!</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:center;''> Your order <span>".$orderNumber."</span> has on its way.</p>
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
                    tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image
                    FROM tblcustomerorder LEFT JOIN tblorderdetails
                    ON tblcustomerorder.order_number = tblorderdetails.order_number
                    WHERE tblorderdetails.order_number=?");
                    echo $connect->error;
                    $getOrders->bind_param('s',$orderNumber);
                    $getOrders->execute();
                    $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage);
                    $totalAmount="";
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
                            <h3>Total Amount:</h3>
                            <p><span>$totalAmount</span><span>.00</span></p>
                        </div>
                        <hr style='border:0.3px solid #dbdbdb;'>
                        <div>
                            <h3>Delivery Details</h3>
                            <p><span style='margin: 0 55px 0 0;' '>Recepient Name:</span><span>$customerName</span></p>
                            <p><span style='margin: 0 60px 0 0;' '>Addresss:</span><span>$customerAddress</span></p>
                            <p><span style='margin: 0 55px 0 0;' '>Phone Number:</span><span>$phoneNumber</span></p>
                        <div>
                        <div style='text-align:center'>
                            <p>from</p></br>
                            <h3>Mang Mac' s Food Shop</h3></br>
                            <p>Zone 5, Barangay Sta. Lucia Bypass Road, Urdaneta, Philippines</p>
                        </div>
                    </div>";
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:orders.php?updated');
                    }
                    else{
                        if($orderStatus == "Delivered"){
                            $mail->Subject = "Your Order #".$orderNumber." has been delivered";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <h3>Your order has been confirmed!</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:justify;''> Thank  you for your purchase.Enjoy your meal &#128512;</p>
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
                        tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image
                        FROM tblcustomerorder LEFT JOIN tblorderdetails
                        ON tblcustomerorder.order_number = tblorderdetails.order_number
                        WHERE tblorderdetails.order_number=?");
                        echo $connect->error;
                        $getOrders->bind_param('s',$orderNumber);
                        $getOrders->execute();
                        $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage);
                        $totalAmount="";
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
                                <h3>Total Amount:</h3>
                                <p><span>$totalAmount</span><span>.00</span></p>
                            </div>
                            <hr style='border:0.3px solid #dbdbdb;'>
                            <div>
                                <h3>Delivery Details</h3>
                                <p><span style='margin: 0 55px 0 0;' '>Recepient Name:</span><span>$customerName</span></p>
                                <p><span style='margin: 0 60px 0 0;' '>Addresss:</span><span>$customerAddress</span></p>
                                <p><span style='margin: 0 55px 0 0;' '>Phone Number:</span><span>$phoneNumber</span></p>
                            <div>
                            <div style='text-align:center'>
                                <p>from</p></br>
                                <h3>Mang Mac' s Food Shop</h3></br>
                                <p>Zone 5, Barangay Sta. Lucia Bypass Road, Urdaneta, Philippines</p>
                            </div>
                        </div>";
                        $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                        $mail->send();
                        header('Location:orders.php?updated');
                        }
                    }
                }
            }
          else{
            $OrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=? WHERE order_number=?");
            $OrderStatus->bind_param('ss',$orderStatus,$orderNumber);
            $OrderStatus->execute();   
            if($OrderStatus){
                if($orderStatus == "Order Received"){
                    $mail->Subject = "Your Order #".$orderNumber." has been confirmed";
                    $mail->Body = "
                    <div class='container' style='padding: 1rem;'>
                    <div style='display: flex; flex-direction: column; align-items: center;'>
                        <div class='logo-section'>
                            <img src='assets/images/logo.png' width='50'>
                            <strong>Mang Macs's Food Shop</strong>
                        </div>
                        <div class='icon-section' style='padding: 1rem;'>
                            <i class='fa-regular fa-circle-check'></i>
                        </div>
                        <div style='text-align: center;'>
                            <h3>Your order has been confirmed!</h3>
                            <!---Display customer name here using php-->
                            <p>Hello ".$customerName."</p>
                            <p style='text-align:justify;''>Thank you for purchasing at <b>Mang Mac's Food Shop.</b> Your order <span>".$orderNumber."</span> has been approved. You will receive another email when your order is ready to pick up.</p>
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
                tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image
                FROM tblcustomerorder LEFT JOIN tblorderdetails
                ON tblcustomerorder.order_number = tblorderdetails.order_number
                WHERE tblorderdetails.order_number=?");
                echo $connect->error;
                $getOrders->bind_param('s',$orderNumber);
                $getOrders->execute();
                $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage);
                $totalAmount="";
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
                $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                $mail->send();
                header('Location:orders.php?updated');
                    }
                    else if($orderStatus == "Shipped"){
                        $mail->Subject = "Your Order #".$orderNumber." is ready to pick up.";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <h3>Your order has been confirmed!</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:justify;''>Your order is ready to pick up.See you!</p>
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
                    tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image
                    FROM tblcustomerorder LEFT JOIN tblorderdetails
                    ON tblcustomerorder.order_number = tblorderdetails.order_number
                    WHERE tblorderdetails.order_number=?");
                    echo $connect->error;
                    $getOrders->bind_param('s',$orderNumber);
                    $getOrders->execute();
                    $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage);
                    $totalAmount="";
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
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:orders.php?updated');
                    }
                    else{
                        $mail->Subject = "Your Order #".$orderNumber." has been completed";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <h3>Your order has been confirmed!</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:justify;''>Thank  you for your purchase.Enjoy your food &#128512;</p>
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
                    tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.add_ons,tblorderdetails.product_image
                    FROM tblcustomerorder LEFT JOIN tblorderdetails
                    ON tblcustomerorder.order_number = tblorderdetails.order_number
                    WHERE tblorderdetails.order_number=?");
                    echo $connect->error;
                    $getOrders->bind_param('s',$orderNumber);
                    $getOrders->execute();
                    $getOrders->bind_result($customerName,$customerAddress,$phoneNumber,$product,$variation,$quantity,$price,$addOns,$productImage);
                    $totalAmount="";
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
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:orders.php?updated');
                    }
                }
            }       
        }
    }
}
updateOrderStatus();
?>