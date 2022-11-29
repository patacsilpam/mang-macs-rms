<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function mailBookingReserved($id,$email,$refNumber,$logo,$customerName,$guests,$createAt,$schedDate,$schedTime,$bookStatus) {
    require 'public/connection.php';
    require 'php-mailer/vendor/autoload.php';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mangmacspizzahouse@gmail.com';
    $mail->Password = 'ylzikpnelhxltves'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('mangmacspizzahouse@gmail.com', "Mang Mac's Marinero");
    $mail->addAddress($email);
    $mail->isHTML(true);   

    $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
    $updateBookStatus->bind_param('si',$bookStatus,$id);
    if($updateBookStatus->execute()){
        $mail->Subject = "Your Booking #".$refNumber." has been confirmed";
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
                    <p>Hello ".$customerName."</p>
                    <h3>Your table reservation for ".$guests." guests is already confirmed. See you at </h3> 
                </div>
                </div>
                <hr style='border:0.3px solid #dbdbdb;'>
                <div>
                    <strong>Booking Summary</strong>
                </div>
                <div style = 'style:display:flex; flex-direction:column;'>
                    <div style='display: flex; justify-content: space-between;'>
                        <p style='width:150px;'>Booking Number:</p>
                        <p>".$refNumber."</p>
                    </div>
                    <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                        <p style='width:150px;'>Guests:</p>
                        <p>".$guests."</p>
                    </div>
                    <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                        <p style='width:150px;'>Schedule:</p>
                        <p>".$schedDate." ".$schedTime."</p>
                    </div> 
                    <div style='display: flex; justify-content: space-between;'>
                        <p style='width:150px;'>Reminder</p><br>
                        <p style='text-align:center'>Don't be an hour late, please. 
                        Your table reservation will be canceled 
                        if you arrive more than 30 minutes late.</p>
                    </div>
                        </div>
                    <hr style='border:0.3px solid #dbdbdb;'>
                    <div style='text-align:center';>
                        <p>from</p></br>
                        <h3>Mang Mac' s Food Shop</h3></br>
                        <p>Zone 5, Barangay Sta. Lucia Bypass Road, Urdaneta, Philippines</p>
                    </div>
                </div>";
            $mail->AltBody = 'FROM: mangmacspizzahouse@gmail.com';
            $mail->send();
            header('Location:reservation.php');
    }
}

?>