<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function noShowsReservation(){
    require 'php-mailer/vendor/autoload.php';
    //update table reservation status to No shows when the customers did not arrive
    require 'public/connection.php';
    $reserved = 'Reserved';
    $noShows = 'No Shows';
    $bookingNumber = array();
    $email = array();
    $customerName = array();
    $guests = array();
    $scheduledDate = array();
    $getId = $connect->query("SELECT *,(SELECT waitingTime FROM tblsettings WHERE id=1) as 'waitingTime' FROM tblreservation WHERE 
    STR_TO_DATE(CONCAT(scheduled_date,' ',scheduled_time), '%Y-%m-%d %h:%i %p') <= 
    DATE_SUB(NOW(),INTERVAL 'waitingTime' HOUR) AND status IN ('Reserved')");
    while($fetch = $getId->fetch_assoc()){
        $bookingNumber[] =  $fetch['refNumber'];
        $email[] = $fetch['email'];
        $customerName[] = $fetch['fname']." ".$fetch['lname'];
        $guests[] = $fetch['guests'];
        $scheduledDate[] = $fetch['scheduled_date']." ".$fetch['scheduled_time'];
    }
   foreach($bookingNumber as $index => $orderNumber){
        $newOrderNumber = $orderNumber;
        $newEmail = $email[$index];
        $newCustomerName = $customerName[$index];
        $newGuests = $guests[$index];
        $newSched = $scheduledDate[$index];
        $logo = "https://i.ibb.co/CMq6CXs/logo.png";
        $updateRemoveStat = $connect->prepare("UPDATE tblreservation SET status=? WHERE refNumber=?");
        $updateRemoveStat->bind_param('ss',$noShows,$newOrderNumber);
        echo $connect->error;
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mangmacspizzahouse@gmail.com';
        $mail->Password = 'ylzikpnelhxltves'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('mangmacspizzahouse@gmail.com', "Mang Mac's Marinero");
        $mail->addAddress($newEmail);
        $mail->isHTML(true);
        if($updateRemoveStat->execute()){
            $mail->Subject = "No Shows";
            $mail->Body = "
            <div class='container' style='padding: 1rem;'>
            <div style='display: flex; flex-direction: column; align-items: center;'>
                <div class='logo-section'>
                    <img src='$logo' width='50'>
                    <strong>Mang Macs's Food Shop</strong>
                </div>
                <div class='icon-section' style='padding: 1rem;'>
                    <i class='fa-regular fa-circle-check'></i>
                </div>
                <div style='text-align: center;'>
                    <p>Hello ".$newCustomerName."</p>
                    <h3>Due to your delayed arrival on the set scheduled date and time, we have now decided to cancel your table reservation.</h3> 
                </div>
            </div>
            <hr style='border:0.3px solid #dbdbdb;'>
            <div>
                <strong>Booking Summary</strong>
            </div>
            <div style = 'style:display:flex; flex-direction:column;'>
                <div style='display: flex; justify-content: space-between;'>
                    <p style='width:150px;'>Booking Number:</p>
                    <p>".$newOrderNumber."</p>
                </div>
                <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                    <p style='width:150px;'>Guests:</p>
                    <p>".$newGuests."</p>
                </div>
                <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                    <p style='width:150px;'>Schedule:</p>
                    <p>$newSched</p>
                </div> 
            </div>
            <hr style='border:0.3px solid #dbdbdb;'>
            <div style='text-align:center';>
                <p>from</p></br>
                <h3>Mang Mac' s Food Shop</h3></br>
                <p>Zone 5, Barangay Sta. Lucia Bypass Road, Urdaneta, Philippines</p>
            </div>
        </div>
        ";
        $mail->AltBody = 'FROM: mangmacspizzahouse@gmail.com';
        $mail->send();
        header('Location:reservation.php');
        }
    }  
}




?>