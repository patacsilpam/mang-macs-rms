<?php
function updateOrderStatus(){
    require 'public/connection.php';
    require 'php-mailer/vendor/autoload.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['btn-update'])){
            date_default_timezone_set("Asia/Manila");
            $customerName = $_POST['customerName'];
            $orderStatus = $_POST['orderStatus'];
            $orderType = $_POST['orderType'];
            $orderNumber = $_POST['orderNumber'];
            $orderDate = $_POST['orderDate'];
            $email = $_POST['email'];
            $sendTo = $_POST['token'];
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
                        include 'email-notifications/mail-order-processing.php';
                        include 'local-notification/firebase-notification.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber has been confirmed.");
                        pushNotifcation($sendTo,$data);
                        mailOrderProcessing($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    case "Out for Delivery":
                        include 'email-notifications/mail-out-for-delivery.php';
                        include 'local-notification/firebase-notification.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is out for delivery.");
                        pushNotifcation($sendTo,$data);
                        mailOutForDelivery($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    case "Ready for Pick Up":
                        include 'email-notifications/mail-ready-for-pick-up.php';
                        include 'local-notification/firebase-notification.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is out for delivery.");
                        pushNotifcation($sendTo,$data);
                        mailReadyForPickUp($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    case "Order Completed":
                        include 'email-notifications/mail-order-completed.php';
                        include 'local-notification/firebase-notification.php';
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
                        $insertSale = $connect->prepare("INSERT INTO tblreport(id,fullname,sales,user_type,report_date) VALUES(?,?,?,?,?)");
                        $insertSale->bind_param('isiss',$id,$fullname,$sales,$userType,$reportDate);
                        $insertSale->execute();
                        break;

                    case "Cancelled":
                        include 'email-notifications/mail-order-cancelled.php';
                        include 'local-notification/firebase-notification.php';
                        $data = array('title'=>"$orderStatus",'body'=>"Hello $customerName,\nyour order #$orderNumber is canceled due to your invalid payment.");
                        pushNotifcation($sendTo,$data);
                        mailOrderCanceled($email,$orderNumber,$logo,$customerName,$orderDate,$orderType);
                        break;

                    default:
                    header('Location:order_summary.php?false');
                }
               
                header('Location:order_summary.php?order_number='.$orderNumber);
                
            }

        }
    
    }
}
updateOrderStatus ();
?>