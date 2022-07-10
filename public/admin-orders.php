<?php
use PHPMailer\PHPMailer\PHPMailer;
function updateOrderStatus(){
    require 'public/connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['btn-update'])){
           date_default_timezone_set("Asia/Manila");
            $customerName = $_POST['customerName'];
            $orderType = $_POST['orderType'];
            $orderStatus = $_POST['orderStatus'];
            $orderNumber = $_POST['orderNumber'];
            $orderDate = $_POST['orderDate'];
            $email = $_POST['email'];
            $completedTime = date('y-m-d h:i:s');
            $notifDate = date('y-m-d h:i:s');
            require 'php-mailer/vendor/autoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';
            $mail->Password = '';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('', "Mang Mac's Marinero");
            $mail->addAddress($email);
            $mail->isHTML(true);
            if($orderType == "Dine in"){
                $OrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=?,completed_time=? WHERE order_number=?");
                $OrderStatus->bind_param('sss',$orderStatus,$completedTime,$orderNumber);
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
            else if($orderType == "Deliver"){
                $OrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=?,completed_time=?,notif_date=? WHERE order_number=?");
                $OrderStatus->bind_param('ssss',$orderStatus,$completedTime,$notifDate,$orderNumber);
                $OrderStatus->execute();
                if($OrderStatus){
                    if($orderStatus == "Order Received"){
                        function pushNotifcation($sendTo,$data){
                            $apiKey = "";
                            $url = "https://fcm.googleapis.com/fcm/send";
                            $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                            // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                        
                            $headers = array();
                            $headers[] = 'Authorization:key='.$apiKey;
                            $headers[] = 'Content-Type: application/json';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                            $result = curl_exec($ch);
                            if (curl_errno($ch)) {
                                echo 'Error:' . curl_error($ch);
                            }
                            curl_close($ch);
                            }
                            $sendTo = $_POST['token'];
                            $data = array(
                                'title'=>"$orderStatus",
                                'body'=>"Hello $customerName,\nyour order #$orderNumber has been confirmed."
                            );
                            pushNotifcation($sendTo,$data);
                        $mail->Subject = "Your Order #".$orderNumber." has been confirm";
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
                                <p style='text-align:justify;''>Thank you for purchasing at <b>Mang Mac's Food Shop.</b> Your order <span>".$orderNumber."</span> has been confirm.</p>
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
                    //update delivery order status to order processing
                    else if($orderStatus == "Order Processing"){
                        $mail->Subject = "Your Order #".$orderNumber." is on its process";
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
                                <h3>Your order is on its process</h3>
                                <!---Display customer name here using php-->
                                <p>Hello ".$customerName."</p>
                                <p style='text-align:center;''> We are preparing your order.</p>
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
                    else if($orderStatus == "Out for Delivery"){
                        function pushNotifcation($sendTo,$data){
                            $apiKey = "";
                            $url = "https://fcm.googleapis.com/fcm/send";
                            $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                            // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                        
                            $headers = array();
                            $headers[] = 'Authorization:key='.$apiKey;
                            $headers[] = 'Content-Type: application/json';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                            $result = curl_exec($ch);
                            if (curl_errno($ch)) {
                                echo 'Error:' . curl_error($ch);
                            }
                            curl_close($ch);
                            }
                            $sendTo = $_POST['token'];
                            $data = array(
                                'title'=>"$orderStatus",
                                'body'=>"Hello $customerName,\nyour order #$orderNumber is out for delivery."
                            );
                            pushNotifcation($sendTo,$data);
                            $mail->Subject = "Your Order #".$orderNumber." is out for delivery";
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
                                <p style='text-align:justify;''> Your order ".$orderNumber." is on the way.</p>
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
                        else {
                            function pushNotifcation($sendTo,$data){
                                $apiKey = "";
                                $url = "https://fcm.googleapis.com/fcm/send";
                                $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                                // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                            
                                $headers = array();
                                $headers[] = 'Authorization:key='.$apiKey;
                                $headers[] = 'Content-Type: application/json';
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            
                                $result = curl_exec($ch);
                                if (curl_errno($ch)) {
                                    echo 'Error:' . curl_error($ch);
                                }
                                curl_close($ch);
                                }
                                $sendTo = $_POST['token'];
                                $data = array(
                                    'title'=>"$orderStatus",
                                    'body'=>"Hello $customerName,\nyour order #$orderNumber has been delivered."
                                );
                                pushNotifcation($sendTo,$data);
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
                                    <p style='text-align:justify;''> Thankk you for your purchase. Enjoy your food &#128512.</p>
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
            //send email notification to order type pick up
          else{
            $OrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=?,completed_time=?,notif_date=? WHERE order_number=?");
            $OrderStatus->bind_param('ssss',$orderStatus,$completedTime,$notifDate,$orderNumber);
            $OrderStatus->execute();
            if($OrderStatus){
                if($orderStatus == "Order Received"){
                    function pushNotifcation($sendTo,$data){
                        $apiKey = "";
                        $url = "https://fcm.googleapis.com/fcm/send";
                        $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                    
                        $headers = array();
                        $headers[] = 'Authorization:key='.$apiKey;
                        $headers[] = 'Content-Type: application/json';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {
                            echo 'Error:' . curl_error($ch);
                        }
                        curl_close($ch);
                        }
                        $sendTo = $_POST['token'];
                        $data = array(
                            'title'=>"$orderStatus",
                            'body'=>"Hello $customerName,\nyour order #$orderNumber has been confirmed."
                        );
                        pushNotifcation($sendTo,$data);
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
                            <p style='text-align:justify;''>Thank you for purchasing at <b>Mang Mac's Food Shop.</b> Your order <span>".$orderNumber."</span> has been confirm.</p>
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
                    else if($orderStatus == "Order Processing"){
                        $mail->Subject = "Your Order #".$orderNumber." is on its process.";
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
                                <p style='text-align:justify;''>We are preparing for your order.</p>
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
                    else if($orderStatus == "Ready for Pick Up"){
                        function pushNotifcation($sendTo,$data){
                            $apiKey = "";
                            $url = "https://fcm.googleapis.com/fcm/send";
                            $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                            // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                        
                            $headers = array();
                            $headers[] = 'Authorization:key='.$apiKey;
                            $headers[] = 'Content-Type: application/json';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                            $result = curl_exec($ch);
                            if (curl_errno($ch)) {
                                echo 'Error:' . curl_error($ch);
                            }
                            curl_close($ch);
                            }
                            $sendTo = $_POST['token'];
                            $data = array(
                                'title'=>"$orderStatus",
                                'body'=>"Hello $customerName,\nyour order #$orderNumber is ready for pick up."
                            );
                            pushNotifcation($sendTo,$data);
                        $mail->Subject = "Your Order #".$orderNumber." is ready for pick up";
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
                                <p style='text-align:justify;''>Your Order #".$orderNumber." is ready for pick up</p>
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
                        if($orderStatus == "Order Completed"){
                            function pushNotifcation($sendTo,$data){
                                //$apiKey = "";
                                $url = "https://fcm.googleapis.com/fcm/send";
                                $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                                // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                            
                                $headers = array();
                                $headers[] = 'Authorization:key='.$apiKey;
                                $headers[] = 'Content-Type: application/json';
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            
                                $result = curl_exec($ch);
                                if (curl_errno($ch)) {
                                    echo 'Error:' . curl_error($ch);
                                }
                                curl_close($ch);
                                }
                                $sendTo = $_POST['token'];
                                $data = array(
                                    'title'=>"$orderStatus",
                                    'body'=>"Hello $customerName,\nyour order #$orderNumber has been delivered."
                                );
                                pushNotifcation($sendTo,$data);
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
}
updateOrderStatus();
?>
