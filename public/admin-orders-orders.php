<?php
function fetchOrderTimeType($orderNumber,$requiredTime,$prepTime){
    require 'public/connection.php';
    if($requiredTime == "-- --"){
        date_default_timezone_set('Asia/Manila');
        $time = ltrim(strtotime(date("h:i a")),"0");
        $milTime =  date("H:i", strtotime("+$prepTime min",$time));
        $estTime = ltrim(date("h:i a",strtotime($milTime)),"0");
        echo $connect->error;
        $updateEstTime = $connect->prepare("UPDATE tblorderdetails SET required_time=? WHERE order_number=?");
        $updateEstTime->bind_param('ss',$estTime,$orderNumber);
        $updateEstTime->execute();
        header('Location:order-summary.php');
    }
}

function updateStockQty($product,$quantity,$itemCategory,$itemVariation){
    require 'public/connection.php';
    foreach($itemCategory as $index => $value){
        $s_product = $product[$index];
        $s_quantity = $quantity[$index];
        $s_itemCategory = $value;
        $s_itemVariation = $itemVariation[$index];
        $variation = '%'.$s_itemVariation.'%';
        if($s_itemCategory == "Pizza"){
            $updateItemQty = $connect->prepare("UPDATE tblinventory SET quantityInStock = quantityInStock + (?) WHERE itemCategory=? AND itemVariation LIKE (?)");
            $updateItemQty->bind_param('iss',$s_quantity,$s_itemCategory,$variation);
            $updateItemQty->execute();
            header('Location:order-summary.php');
        }
        if($s_itemCategory != "Pizza"){
            $updateStockDb = $connect->prepare("UPDATE tblinventory SET quantityInStock = quantityInStock + (?) WHERE product=? AND itemCategory=?");
            $updateStockDb->bind_param('iss',$s_quantity,$s_product,$s_itemCategory);
            $updateStockDb->execute();
        }
    }
}

function updateOrderStatus(){
    require 'public/connection.php';
    require 'php-mailer/vendor/autoload.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['btn-update'])){
            date_default_timezone_set("Asia/Manila");
            $customerName = $_POST['customerName'];
            $orderStatus = $_POST['orderStatus'];
            $product = $_POST['productName'];
            $quantity = $_POST['quantity'];
            $category = $_POST['category'];
            $variation = $_POST['variation'];
            $orderType = $_POST['orderType'];
            $orderNumber = $_POST['orderNumber'];
            $orderDate = $_POST['orderDate'];
            $email = $_POST['email'];
            $sendTo = $_POST['token'];
            $requiredTime = $_POST['requiredTime'];
            $prepTime = $_POST['preparedTime'];
            //$firstLetter = substr($customerName,0,1);
            $logo = "https://i.ibb.co/CMq6CXs/logo.png";
            $completedTime = date('Y-m-d h:i:s');
            $notifDate = date('Y-m-d h:i:s');
            //update order status
            $editOrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=?,completed_time=?,notif_date=? WHERE order_number=?");
            $editOrderStatus->bind_param('ssss',$orderStatus,$completedTime,$notifDate,$orderNumber);
            if($editOrderStatus->execute()){
                switch($orderStatus){
                    case "Order Processing":
                        include 'public/email-notifications/mail-order-processing.php';
                        include 'public/local-notification/firebase-notifcation.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber has been confirmed.");
                        pushNotifcation($sendTo,$data);
                        mailOrderProcessing($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        fetchOrderTimeType($orderNumber,$requiredTime,$prepTime);
                        break;

                    case "Out for Delivery":
                        include 'public/email-notifications/mail-out-for-delivery.php';
                        include 'public/local-notification/firebase-notifcation.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is out for delivery.");
                        pushNotifcation($sendTo,$data);
                        mailOutForDelivery($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    case "Ready for Pick Up":
                        include 'public/email-notifications/mail-ready-for-pick-up.php';
                        include 'public/local-notification/firebase-notifcation.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is ready for pick up.");
                        pushNotifcation($sendTo,$data);
                        mailReadyForPickUp($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    case "Order Completed":
                        include 'public/email-notifications/mail-order-completed.php';
                        include 'public/local-notification/firebase-notifcation.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber has been delivered.");
                        pushNotifcation($sendTo,$data);
                        mailOrderCompleted($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        //insert report sale
                        $id = $_POST['id'];
                        $fullname = $_SESSION['fname']." ".$_SESSION['lname'];
                        $sales = $_POST['sales'];
                        $userType = "Admin";
                        $reportDate = date('Y-m-d h:i:s');
                        //insert report sale
                        $insertSale = $connect->prepare("INSERT INTO tblreport(id,order_number,fullname,sales,user_type,report_date) VALUES(?,?,?,?,?,?)");
                        $insertSale->bind_param('ississ',$id,$orderNumber,$fullname,$sales,$userType,$reportDate);
                        $insertSale->execute();
                        break;

                    case "Invalid Payment":
                        include 'public/email-notifications/mail-order-cancelled.php';
                        include 'public/local-notification/firebase-notifcation.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is canceled due to your invalid payment.");
                        pushNotifcation($sendTo,$data);
                        mailOrderCanceled($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        updateStockQty($product,$quantity,$category,$variation);
                        break;
                    case "Out of Stock":
                        include 'public/email-notifications/mail-order-out-of-stock.php';
                        include 'public/local-notification/firebase-notifcation.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is out of stock.");
                        pushNotifcation($sendTo,$data);
                        mailOutOfStock($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    default:
                    header('Location:order_summary.php?false');
                }
               
                header('Location:order_summary.php?order_number='.$orderNumber);
                
            }

        }
    
    }
}
function changeDevTime(){
    require 'public/connection.php';
    require 'php-mailer/vendor/autoload.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['update-dev-time'])){
            $devTime = date('h:i a',strtotime($_POST['devTime']));
            $modDevTime = $_POST['modDevTime'];
            $email = $_POST['email'];
            $orderNumber = $_POST['orderNumber'];
            $logo = "https://i.ibb.co/CMq6CXs/logo.png";
            $customerName = $_POST['customerName'];
            $orderDate = $_POST['orderDate'];
            $orderType = $_POST['orderType'];
            $sendTo = $_POST['token'];
            $requiredTime = $_POST['requiredTime'];
            $prepTime = $_POST['preparedTime'];
            $updateDevTime = $connect->prepare("UPDATE tblorderdetails SET required_time=? WHERE order_number=?");
            $updateDevTime->bind_param('ss',$devTime,$orderNumber);
            if($updateDevTime->execute()){
                /**/
                if($modDevTime == "Order Quantity"){
                    include 'public/email-notifications/mail-qty-orders.php';
                    include 'public/local-notification/firebase-notifcation.php';
                    $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nDue to the quantity of your orders, we have decided to adjust your set order time. Thank you for your patience.");
                    pushNotifcation($sendTo,$data);
                    mailQtyOrder($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                }
                if($modDevTime == "Queued Orders"){
                    include 'public/email-notifications/mail-queued-orders.php';
                    include 'public/local-notification/firebase-notifcation.php';
                    $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nDue to the multiple queued orders, we have decided to adjust your set order time. Thank you for your patience");
                    mailQueuedOrder($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                }
                header('Location:order_summary.php?order_number='.$orderNumber);
            }
           
        }
    }
}

updateOrderStatus ();
changeDevTime();
?>