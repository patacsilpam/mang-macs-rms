<?php 
//count ongoing orders
function countActiveOrders(){
    require 'public/connection.php';
    $pending = "Pending";
    $orderReceived = "Order Received";
    $shipped = "Order Processing";
    $readyForPickUp = "Ready For Pick Up";
    $outForDelivery = "Out for Delivery";
    $count = $connect->prepare("SELECT COUNT(*) as 'active_orders' FROM tblorderdetails WHERE order_status=? OR order_status=? OR order_status=? OR order_status=? OR order_status=? GROUP BY order_number");
    $count->bind_param('sssss',$pending,$orderReceived,$shipped,$readyForPickUp,$outForDelivery);
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
    $time = date('h:i a');
    $count = $connect->prepare("SELECT COUNT(*) as 'active_booking' FROM tblreservation WHERE scheduled_date >= CURDATE() AND scheduled_time >=?");
    $count->bind_param('s',$time);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countActiveBooking = $fetch['active_booking']; 
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
    echo $countDeliver = $fetch['dailyDeliver']."/".$fetch['totalDeliver']; 
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
    echo $countPickUp = $fetch['dailyPickUp']."/".$fetch['totalPickUp']; 
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
    echo $countCancelled = $fetch['dailyCancelled']."/".$fetch['totalCancelled']; 
}
//count cancelled table reservation
function countCancelledBooking(){
    require 'public/connection.php';
    $cancelled = "Not Available";
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCancelled',
    (SELECT COUNT(*) FROM tblreservation WHERE status=?)  as 'totalCancelled' 
    FROM tblreservation WHERE status=? AND created_at=?");
    $count->bind_param('sss',$cancelled,$cancelled,$date);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countCancelledBooking = $fetch['dailyCancelled']."/".$fetch['totalCancelled']; 
}
//count total point of sales
function countPosOrders(){
    require 'public/connection.php';
    $date = date('Y-m-d');
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyPos',
    (SELECT COUNT(*) FROM tblposorders) as 'totalPos'
    FROM tblposorders WHERE ordered_date=?");
    $count->bind_param('s',$date);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countPosOrders = $fetch['dailyPos']."/".$fetch['totalPos']; 
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
    echo $countTotalOrder = $fetch['dailyOrders']."/".$fetch['totalOrders']; 
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
    echo $countActiveBooking = $fetch['dailyBooking']."/".$fetch['totalBooking'];  
}

//count total users of mang mac's mobile app
function countCustomers(){
    require 'public/connection.php';
    $date = date('Y-m-d');
    /*$count = $connect->prepare("SELECT COUNT(*) as 'dailyCustomers',
    (SELECT COUNT(*) FROM tblcustomers) as 'totalCustomers'
    FROM tblcustomers WHERE created_account=?");
    $count->bind_param('s',$date);*/
    $count = $connect->prepare("SELECT COUNT(*) as 'dailyCustomers' FROM tblcustomers");
    //$count->bind_param('s',$date);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
   // echo $countCustomers = $fetch['dailyCustomers']."/".$fetch['totalCustomers'];
    echo $countCustomers = $fetch['dailyCustomers'];
}

?>