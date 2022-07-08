<?php
use PHPMailer\PHPMailer\PHPMailer;
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
            $notifDate = date('d-m-y h:i:s');
            require 'php-mailer/vendor/autoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mangmacsmarinerospizzahouse@gmail.com';
            $mail->Password = 'uihz grau bhyt qikw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('mangmacsmarinerospizzahouse@gmail.com', "Mang Mac's Marinero");
            $mail->addAddress($email);
            $mail->isHTML(true);
            if($bookStatus == "Approve"){
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=?,notif_date=? WHERE id=?");
                $updateBookStatus->bind_param('ssi',$bookStatus,$notifDate,$id);
                $updateBookStatus->execute();
                if($updateBookStatus){
                    function pushNotifcation($sendTo,$data){
                        $apiKey = "AAAAozYNVDs:APA91bFDRuJDQZCnFaAmQFP_uTUUzp9fYQZRJI01XtZ34XYr1ifB2f7jDa1R7WVxavsv-hSZZ7qivrEUk37O7-s1VcB8wMJuhIW0R6-ldwv9UQnxlJssMGvEdOq7admem2vfrCkAUqo2";
                        $url = "https://fcm.googleapis.com/fcm/send";
                        $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                    
                        $headers = array();
                        $headers[] = 'Authorization:key='.$apiKey;
                        $headers[] = 'Content-Type: application/json';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {
                            echo 'Error:' . curl_error($ch);
                        }
                        curl_close($ch);
                        }
                        $sendTo = $_POST['token'];
                        $data = array(
                            'title'=>"$bookStatus",
                            'body'=>"Hello $customerName,\nyour table reservation for $guests guests  is already confirmed. See you at $schedDate - $schedTime"
                        );
                        pushNotifcation($sendTo,$data);
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
                                <p>".$schedDate + $schedTime."</p>
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
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=?,notif_date=? WHERE id=?");
                $updateBookStatus->bind_param('ssi',$bookStatus,$notifDate,$id);
                $updateBookStatus->execute();
                if($updateBookStatus){
                    function pushNotifcation($sendTo,$data){
                        $apiKey = "AAAAozYNVDs:APA91bFDRuJDQZCnFaAmQFP_uTUUzp9fYQZRJI01XtZ34XYr1ifB2f7jDa1R7WVxavsv-hSZZ7qivrEUk37O7-s1VcB8wMJuhIW0R6-ldwv9UQnxlJssMGvEdOq7admem2vfrCkAUqo2";
                        $url = "https://fcm.googleapis.com/fcm/send";
                        $fields = json_encode(array('to'=>$sendTo,'notification'=>$data));
                        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,($fields));
                    
                        $headers = array();
                        $headers[] = 'Authorization:key='.$apiKey;
                        $headers[] = 'Content-Type: application/json';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {
                            echo 'Error:' . curl_error($ch);
                        }
                        curl_close($ch);
                        }
                        $sendTo = $_POST['token'];
                        //$sendTo = "cdTa3xCs0ic:APA91bFC1mOiCzhY0cqVUUqbLB7mEwFD1J2fkovFy_nLX9hxZAj0vweLFu9HkGGXzN8Kruimqp_m0JGXH4wNk4YnrCSLyTwpmX0bEYKYTqgLeMMwuMRXgMrLNOVm86mvA8ofnYex1OIe";
                        $data = array(
                            'title'=>"$bookStatus",
                            'body'=>"Hello $customerName,\nsorry, there is no available table for accomodation."
                        );
                        pushNotifcation($sendTo,$data);
                    $mail->Subject = "Your reservation #".$refNumber." is not available";
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
                                <h3>Sorry, there is no available table for accomodation.</h3> 
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
                                <p>".$schedDate + $schedTime."</p>
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
function deleteTable(){
    require 'public/connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['btn-deleteTable'])){
            //soft delete -- remove list from the table of reservation
            $id = $_POST['id'];
            $removeStatus = 'Remove';
            $updateRemoveStat = $connect->prepare("UPDATE tblreservation SET remove_status=? WHERE id=?");
            $updateRemoveStat->bind_param('si',$removeStatus,$id);
            $updateRemoveStat->execute();
            if($updateRemoveStat){
                header('Location:reservation.php');
            }
            else{
                header('Location:reservation.php?false');
            }
        }
    }
}

updateBookStatus();
deleteTable();



?>