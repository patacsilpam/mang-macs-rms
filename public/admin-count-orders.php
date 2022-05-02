<?php 
//count ongoing orders
function countActiveOrders($countActiveOrder){
    require 'public/connection.php';
    $pending = "Pending";
    $orderReceived = "Order Received";
    $shipped = "Shipped";
    $count = $connect->prepare("SELECT COUNT(*) as 'active_orders' FROM tblorderdetails WHERE order_status=? OR order_status=? OR order_status=?");
    $count->bind_param('sss',$pending,$orderReceived,$shipped);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countActiveOrder = $fetch['active_orders']; 
}
//count completed order
function countTotalOrders($countTotalOrder){
    require 'public/connection.php';
    $cancelled = "cancelled orders";
    $count = $connect->prepare("SELECT COUNT(*) as 'completed_orders' FROM tblorderdetails WHERE order_status=?");
    $count->bind_param('s',$cancelled);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countTotalOrder = $fetch['completed_orders']; 
}
//count cancelled orders
function countCancelledOrders($countCancelledOrder){
    require 'public/connection.php';
    $cancelled = "Cancelled";
    $count = $connect->prepare("SELECT COUNT(*) as 'cancelled_orders' FROM tblorderdetails WHERE order_status=?");
    $count->bind_param('s',$cancelled);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countCancelledOrder = $fetch['cancelled_orders']; 
}
//count delivery orders
function countDeliveryOrders($countDeliveryOrders){
    require 'public/connection.php';
    $delivery = "Deliver";

    $count = $connect->prepare("SELECT COUNT(*) as 'delivery_orders' FROM tblorderdetails WHERE order_type=?");
    $count->bind_param('s',$delivery);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countDeliveryOrders = $fetch['delivery_orders']; 
}
function countDineInOrders($countDineInOrders){
    require 'public/connection.php';
    $dineIn = "Dine In";
    $count = $connect->prepare("SELECT COUNT(*) as 'dineIn_orders' FROM tblorderdetails WHERE order_type=?");
    $count->bind_param('s',$dineIn);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countDineInOrders = $fetch['dineIn_orders']; 
}
function countPickUpOrders($countPickUpOrders){
    require 'public/connection.php';
    $pickUp = "Pick Up";
    $count = $connect->prepare("SELECT COUNT(*) as 'dineIn_orders' FROM tblorderdetails WHERE order_type=?");
    $count->bind_param('s',$pickUp);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countDineInOrders = $fetch['dineIn_orders']; 
}
function countActiveBooking($countActiveBooking){
    require 'public/connection.php';
    $pending = "Pending";
    $bookingReceived = "Booking Received";
    $count = $connect->prepare("SELECT COUNT(*) as 'active_booking' FROM tblreservation WHERE status=? OR status=?");
    $count->bind_param('ss',$pending,$bookingReceived);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countActiveBooking = $fetch['active_booking']; 
}
function countTotalBooking($countTotalBooking){
    require 'public/connection.php';
    $completed = "Completed";
    $count = $connect->prepare("SELECT COUNT(*) as 'completed_booking' FROM tblreservation WHERE status=?");
    $count->bind_param('s',$completed);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countTotalBooking = $fetch['completed_booking']; 
}
function countCancelledBooking($countCancelledBooking){
    require 'public/connection.php';
    $cancelled = "cancelled";
    $count = $connect->prepare("SELECT COUNT(*) as 'cancelled_booking' FROM tblreservation WHERE status=?");
    $count->bind_param('s',$cancelled);
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countCancelledBooking = $fetch['cancelled_booking']; 
}
function countCustomers($countCustomers){
    require 'public/connection.php';
    $cancelled = "cancelled";
    $count = $connect->prepare("SELECT COUNT(*) as 'totalCustomers' FROM tblcustomers");
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countCancelledBooking = $fetch['totalCustomers']; 
}
function countPosOrders($countPosOrders){
    require 'public/connection.php';
    $cancelled = "cancelled";
    $count = $connect->prepare("SELECT COUNT(*) as 'totalPosOrders' FROM tblpos");
    $count->execute();
    $row = $count->get_result();
    $fetch = $row->fetch_assoc();
    echo $countCancelledBooking = $fetch['totalPosOrders']; 
}
?>