<?php 
//count ongoing orders
function countActiveOrders(){
    require 'public/connection.php';
    $orderCompleted = "Order Completed";
    $orderReceived = "Order Received";
    $orderCancelled = "Cancelled";
    $orderType = "Dine In";
    $count = $connect->prepare("SELECT SUM(COUNT(DISTINCT order_number)) OVER() as 'active_orders' 
    FROM tblorderdetails WHERE order_status != ? AND order_status!=? AND order_status!=? AND order_type != ?
    GROUP BY order_number");
    $count->bind_param('ssss',$orderCompleted,$orderReceived,$orderCancelled,$orderType);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if(isset($fetch['active_orders'])){
        echo $countActiveOrder = $fetch['active_orders']; 
    }
    else{
        echo 0;
    }
}
//count new table reservation(pending and reserved)
function countActiveBooking(){
    require 'public/connection.php';
    date_default_timezone_set("Asia/Manila");
    $bookPending = "Pending";
    $bookReserved = "Reserved";
    $count = $connect->prepare("SELECT COUNT(*) as 'active_booking' FROM tblreservation 
    WHERE  status=? AND status=? AND
    STR_TO_DATE(CONCAT(scheduled_date,' ', scheduled_time),'%Y-%m-%d %h:%i %p') >= DATE_SUB(CURDATE(), INTERVAL 30 MINUTE)");
    $count->bind_param('ss',$bookPending,$bookReserved);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
   if(isset($fetch['active_booking'])){
        echo $countActiveBooking = $fetch['active_booking']; 
   }
   else{
        echo 0;
   }
}
/*
SELECT COUNT(*) as 'dailyDeliver', 
(SELECT COUNT(*) FROM tblorderdetails WHERE order_status IN ('Order Completed','Order Received') AND order_type='Deliver') as 'totalDeliver'
 FROM tblorderdetails WHERE order_status IN ('Order Completed','Order Received') AND order_type='Deliver' AND required_date='2022-08-24';
*/
//count delivery orders
function countDeliveryOrders(){
    require 'public/connection.php';
    $orderType = "Deliver";
    $orderCompleted = "Order Completed";
    $orderReceived = "Order Received";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyDeliver', 
    (SELECT COUNT(*) FROM tblorderdetails WHERE order_status IN (?,?) AND order_type=?) as 'totalDeliver' 
    FROM tblorderdetails WHERE order_status IN (?,?) AND order_type=? AND required_date=?");
    echo $connect->error;
    $count->bind_param('sssssss',$orderCompleted,$orderReceived,$orderType,$orderCompleted,$orderReceived,$orderType,$date);
    $count->execute();
    $row = $count->get_result();
    if($fetch = $row->fetch_assoc()){
        echo $countDeliver = $fetch['dailyDeliver']."/".$fetch['totalDeliver']; 
    } 
}
//count pick up orders
function countPickUpOrders(){
    require 'public/connection.php';
    $orderType = "Pick Up";
    $orderCompleted = "Order Completed";
    $orderReceived = "Order Received";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyPickUp', 
    (SELECT COUNT(*) FROM tblorderdetails WHERE order_status IN (?,?) AND order_type=?) as 'totalPickUp' 
    FROM tblorderdetails WHERE order_status IN (?,?) AND order_type=? AND required_date=?");
    echo $connect->error;
    $count->bind_param('sssssss',$orderCompleted,$orderReceived,$orderType,$orderCompleted,$orderReceived,$orderType,$date);
    $count->execute();
    $row = $count->get_result();
    if( $fetch = $row->fetch_assoc()){
        echo $countDeliver = $fetch['dailyPickUp']."/".$fetch['totalPickUp']; 
    }
}
//count cancelled orders
function countCancelledOrders(){
    require 'public/connection.php';
    $orderDeliver = "Deliver";
    $orderPickUp = "Pick Up";
    $cancelled = "Cancelled";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCancelled', 
    (SELECT COUNT(*) FROM tblorderdetails WHERE order_type IN (?,?) AND order_status=?) as 'totalCancelled' 
    FROM tblorderdetails WHERE order_type IN (?,?) AND order_status=? AND required_date=?");
    $count->bind_param('sssssss',$orderDeliver,$orderPickUp,$cancelled,$orderDeliver,$orderPickUp,$cancelled,$date);
    $count->execute();
    $row = $count->get_result();
    if($fetch = $row->fetch_assoc()){
        echo $countCancelled = $fetch['dailyCancelled']."/".$fetch['totalCancelled']; 
    }
}
//count cancelled table reservation
function countCancelledBooking(){
    require 'public/connection.php';
    $cancelled = "Cancelled";
    $noShows = "No Shows";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCancelled',
    (SELECT COUNT(*) FROM tblreservation WHERE status IN (?,?))  as 'totalCancelled' 
    FROM tblreservation WHERE status IN (?,?) AND scheduled_date=?");
    $count->bind_param('sssss',$cancelled,$noShows,$cancelled,$noShows,$date);
    $count->execute();
    $row = $count->get_result();
    if( $fetch = $row->fetch_assoc()){
        echo $countCancelledBooking = $fetch['dailyCancelled']."/".$fetch['totalCancelled']; 
    }
}

    
//count total point of sales
function countPosOrders(){
    require 'public/connection.php';
    $status = "Settled";
    $count = $connect->prepare("SELECT SUM(COUNT(DISTINCT tblpos.id_number)) OVER() AS 'dailyPos',
    (SELECT SUM(COUNT(DISTINCT tblpos.id_number)) OVER() 
    FROM tblpos LEFT JOIN tblposorders ON 
    tblpos.id_number = tblposorders.id_number WHERE tblpos.status = ?) AS 'totalPos'
    FROM tblpos LEFT JOIN tblposorders ON 
    tblpos.id_number = tblposorders.id_number WHERE tblpos.status = ?");
    $count->bind_param('ss',$status,$status);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyPos'] > 0){
        echo $countPosOrders = $fetch['dailyPos']."/".$fetch['totalPos']; 
    }
    else{
        echo 0;
    }
}
//count completed order
function countTotalOrders(){
    require 'public/connection.php';
    $orderCompleted = "Order Completed";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyOrders',
    (SELECT COUNT(*) FROM tblorderdetails WHERE created_at=? AND order_status=?) as 'totalOrders'
    FROM tblorderdetails WHERE created_at=? AND order_status=?");
    $count->bind_param('ssss',$date,$orderCompleted,$date,$orderCompleted);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyOrders'] > 0){
        echo $countTotalOrder = $fetch['dailyOrders']."/".$fetch['totalOrders']; 
    }
    else{
        echo 0;
    }
}

//count total table reservation 
function countTotalBooking(){
    require 'public/connection.php';
    $status = "Reserved";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyBooking',
    (SELECT COUNT(*) FROM tblreservation WHERE created_at=? AND status=?) as 'totalBooking' 
    FROM tblreservation  WHERE created_at=? AND status=?");
    $count->bind_param('ssss',$date,$status,$date,$status);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyBooking'] > 0){
        echo $countActiveBooking = $fetch['dailyBooking']."/".$fetch['totalBooking'];  
    }
    else{
        echo 0;
    }
   
}

//count total users of mang mac's mobile app
function countCustomers(){
    require 'public/connection.php';
    $date = date('Y-m-d');
    /*$count = $connect->prepare("SELECT COUNT(*) as 'dailyCustomers',
    (SELECT COUNT(*) FROM tblcustomers) as 'totalCustomers'
    FROM tblcustomers WHERE created_account=?");
    $count->bind_param('s',$date);*/
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCustomers' FROM tblcustomers ORDER BY created_account DESC");
    //$count->bind_param('s',$date);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
   // echo $countCustomers = $fetch['dailyCustomers']."/".$fetch['totalCustomers'];
    echo $countCustomers = $fetch['dailyCustomers'];
}

?>