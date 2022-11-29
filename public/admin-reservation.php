<?php
 include 'public/email-notifications/mail-no-shows-reserved.php';
function updateBookStatus(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-update'])){
            date_default_timezone_set("Asia/Manila");
            $customerName = $_POST['customerName'];
            $refNumber = $_POST['refNumber'];
            $id = $_POST['id'];
            $email = $_POST['email'];
            $createAt = $_POST['reservedDate'];
            $bookStatus = $_POST['bookStatus'];
            $guests = $_POST['guests'];
            $schedDate = date('M-d-Y',strtotime($_POST['schedDate']));
            $schedTime = $_POST['schedTime'];
            $notifDate = date('Y-m-d h:i:s');
            $firstLetter = substr($customerName,0,1);
            $logo = "https://i.ibb.co/CMq6CXs/logo.png";
            $sendTo = $_POST['token'];

            switch($bookStatus){
                case "Reserved":
                    include 'public/email-notifications/mail-booking-reserved.php';
                    $data = array('title'=>"$bookStatus",'body'=>"Hello $customerName,\nyour table reservation for $guests guests  is already confirmed. See you at $schedDate - $schedTime");
                    mailBookingReserved($id,$email,$refNumber,$logo,$customerName,$guests,$createAt,$schedDate,$schedTime,$bookStatus);
                    pushNotifcation($sendTo,$data);
                    break;
                case "Not Available":
                    include 'public/email-notifications/mail-not-available-reserved.php';
                    $data = array('title'=>"$bookStatus",'body'=>"Hello $customerName,\nsorry, there is no available table for accomodation.");
                    noShowsReservation();
                    pushNotifcation($sendTo,$data);
                    break;
                case "No Shows":
                    include 'public/email-notifications/mail-no-shows-reserved.php';
                    $data = array('title'=>"$bookStatus",'body'=>"Hello $customerName,\ndue to your delayed arrival on the set scheduled date and time, we have now decided to cancel your table reservation.");
                    noShowsReservation();
                    pushNotifcation($sendTo,$data);
                    break;
                case "Finished";
                    $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
                    $updateBookStatus->bind_param('si',$bookStatus,$id);
                    $updateBookStatus->execute();
                    header('Location:reservation.php');
                    break;
                default:
                return;
            }
        } 
    }
}
updateBookStatus();
noShowsReservation();



?>
