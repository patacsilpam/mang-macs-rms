<?php
function setCourierInCharge(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-set-courier'])){
            $orderNumber = mysqli_real_escape_string($connect,$_POST['orderNumber']);
            $courierName = mysqli_real_escape_string($connect,$_POST['courierName']);
            $setCourier = $connect->prepare("UPDATE tblcustomerorder SET courier=? WHERE order_number=?");
            $setCourier->bind_param('ss',$courierName,$orderNumber);
            if($setCourier->execute()){
                header('Location:order_summary.php?order_number='.$orderNumber);
            }
        }
    }
}
setCourierInCharge();    
?>