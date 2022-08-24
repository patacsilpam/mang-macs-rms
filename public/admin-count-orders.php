<?php 
//count ongoing orders
function countActiveOrders(){
    require 'public/connection.php';
    $orderStatus = "Order Completed";
    $orderType = "Dine In";
    $count = $connect->prepare("SELECT SUM(COUNT(DISTINCT order_number)) OVER() as 'active_orders' FROM tblorderdetails WHERE order_status != ? AND order_type != ? GROUP BY order_number");
    $count->bind_param('ss',$orderStatus,$orderType);
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
//count new table reservation
function countActiveBooking(){
    require 'public/connection.php';
    date_default_timezone_set("Asia/Manila");
    $time = date('h:i a');
    $count = $connect->prepare("SELECT COUNT(*) as 'active_booking' FROM tblreservation WHERE scheduled_date >= CURDATE()");
   // $count->bind_param('s',$time);
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
//count delivery orders
function countDeliveryOrders(){
    require 'public/connection.php';
    $deliver = "Deliver";
    $orderStatus = "Order Completed";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyDeliver', 
    (SELECT COUNT(*) FROM tblorderdetails WHERE order_type=? AND order_status=?) as 'totalDeliver' 
    FROM tblorderdetails WHERE created_at=? AND  order_type=? AND order_status=?");
    $count->bind_param('sssss',$deliver,$orderStatus,$date,$deliver,$orderStatus);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyDeliver'] > 0){
        echo $countDeliver = $fetch['dailyDeliver']."/".$fetch['totalDeliver']; 
    }
    else{
        echo 0;
    }
}
//count pick up orders
function countPickUpOrders(){
    require 'public/connection.php';
    $pickUp = "Pick Up";
    $orderStatus = "Order Completed";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyPickUp', 
    (SELECT COUNT(*) FROM tblorderdetails WHERE order_type=? AND order_status=?) as 'totalPickUp' 
    FROM tblorderdetails WHERE created_at=? AND  order_type=? AND order_status=?");
    $count->bind_param('sssss',$pickUp,$orderStatus,$date,$pickUp,$orderStatus);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyPickUp'] > 0){
        echo $countPickUp = $fetch['dailyPickUp']."/".$fetch['totalPickUp']; 
    }
    else{
        echo 0;
    }
}
//count cancelled orders
function countCancelledOrders(){
    require 'public/connection.php';
    $cancelled = "Cancelled";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCancelled', 
    (SELECT COUNT(*) FROM tblorderdetails WHERE order_status=?) as 'totalCancelled' 
    FROM tblorderdetails WHERE created_at=? AND  order_status=?");
    $count->bind_param('sss',$cancelled,$date,$cancelled);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyCancelled'] > 0){
        echo $countCancelled = $fetch['dailyCancelled']."/".$fetch['totalCancelled']; 
    }
    else{
        echo 0;
    }
    
}
//count cancelled table reservation
function countCancelledBooking(){
    require 'public/connection.php';
    $cancelled = "Cancelled";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCancelled',
    (SELECT COUNT(*) FROM tblreservation WHERE status=? AND scheduled_date=?)  as 'totalCancelled' 
    FROM tblreservation WHERE status=? AND scheduled_date=?");
    $count->bind_param('ssss',$cancelled,$date,$cancelled,$date);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    if($fetch['dailyCancelled'] > 0){
        echo $countCancelledBooking = $fetch['dailyCancelled']."/".$fetch['totalCancelled']; 
    }
    else{
        echo 0;
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