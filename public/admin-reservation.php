<?php
use PHPMailer\PHPMailer\PHPMailer;
function updateBookingStatus(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-update'])){
            $customerName = $_POST['customerName'];
            $refNumber = $_POST['refNumber'];
            $id = $_POST['id'];
            $email = $_POST['email'];
            $createAt = $_POST['reservedDate'];
            $bookStatus = $_POST['bookStatus'];
            $guests = $_POST['guests'];
            $placedOn = $_POST['placedOn'];
            require 'php-mailer/vendor/autoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mangmacsmarinerospizzahouse@gmail.com';
            $mail->Password = 'mangmacsmarineros';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('mangmacsmarinerospizzahouse@gmail.com', "Mang Mac's Marinero");
            $mail->addAddress($email);
            $mail->isHTML(true);
            if($bookStatus == "Booking Received"){
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
                $updateBookStatus->bind_param('si',$bookStatus,$id);
                $updateBookStatus->execute();
                if($updateBookStatus){
                    $mail->Subject = "Your Booking #".$refNumber." has been confirmed";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <p>Hello ".$customerName."</p>
                                <h3>Your booking at Mang Mac’s Food Shop is now confirmed.</h3> 
                            </div>
                        </div>
                        <hr style='border:0.3px solid #dbdbdb;'>
                        <div>
                            <strong>Booking Summary</strong>
                        </div>
                        <div style = 'style:display:flex; flex-direction:column;'>
                            <div style='display: flex; justify-content: space-between;'>
                                <p style='width:150px;'>Booking Number:</p>
                                <p>".$id."</p>
                            </div>
                            <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                                <p style='width:150px;'>Guests:</p>
                                <p>".$guests."</p>
                            </div>
                            <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                                <p style='width:150px;'>Schedule:</p>
                                <p>".$createAt."</p>
                            </div>
                            <div style='display: flex; justify-content: space-between;'>
                                <p style='width:150px;'>Placed on:</p>
                                <p>".$placedOn."</p>
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
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:reservation.php?updated');
                }
            }
            else{
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
                $updateBookStatus->bind_param('si',$bookStatus,$id);
                $updateBookStatus->execute();
                if($updateBookStatus){
                    $mail->Subject = "Your Booking #".$refNumber." has been completed";
                        $mail->Body = "
                        <div class='container' style='padding: 1rem;'>
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                            <div class='logo-section'>
                                <img src='assets/images/logo.png' width='50'>
                                <strong>Mang Macs's Food Shop</strong>
                            </div>
                            <div class='icon-section' style='padding: 1rem;'>
                                <i class='fa-regular fa-circle-check'></i>
                            </div>
                            <div style='text-align: center;'>
                                <p>Hello ".$customerName."</p>
                                <h3>Your booking at Mang Mac’s Food Shop is now completed.</h3> 
                                <p>See you next time.&#128512;</p>
                            </div>
                        </div>
                        <hr style='border:0.3px solid #dbdbdb;'>
                        <div>
                            <strong>Booking Summary</strong>
                        </div>
                        <div style = 'style:display:flex; flex-direction:column;'>
                            <div style='display: flex; justify-content: space-between;'>
                                <p style='width:150px;'>Booking Number:</p>
                                <p>".$id."</p>
                            </div>
                            <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                                <p style='width:150px;'>Guests:</p>
                                <p>".$guests."</p>
                            </div>
                            <div style='display: flex; justify-content: space-between; margin: -20px 0;'>
                                <p style='width:150px;'>Schedule:</p>
                                <p>".$createAt."</p>
                            </div>
                            <div style='display: flex; justify-content: space-between;'>
                                <p style='width:150px;'>Placed on:</p>
                                <p>".$placedOn."</p>
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
                    $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mail->send();
                    header('Location:reservation.php?updated');
                }
            }
        }
    }
}
updateBookingStatus();
?>