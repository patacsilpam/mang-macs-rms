require 'php-mailer/vendor/autoload.php';
            $mail = new PHPMailer;
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
            if($bookStatus == "Reserved"){
                $updateOrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=? WHERE order_number=?");
                $updateOrderStatus->bind_param('ss',$bookStatus,$refNumber);
                $updateOrderStatus->execute();
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
                $updateBookStatus->bind_param('si',$bookStatus,$id);
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
                    </div>
                    ";
                    $mail->AltBody = 'FROM: mangmacspizzahouse@gmail.com';
                    $mail->send();
                    header('Location:reservation.php');
                    //put another mail here
                }
            }
            else if($bookStatus == "Cancelled"){
                $updateOrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=? WHERE order_number=?");
                $updateOrderStatus->bind_param('ss',$bookStatus,$refNumber);
                $updateOrderStatus->execute();
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
                $updateBookStatus->bind_param('si',$bookStatus,$id);
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
                            'body'=>"Hello $customerName,\nsorry, there is no available table for accomodation."
                        );
                        pushNotifcation($sendTo,$data);
                        $mail->Subject = "Your reservation #".$refNumber." is not available";
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
                                <h3>Sorry, there is no available table for accomodation.</h3> 
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
            else{
                $completedTime = date('Y-m-d h:i:s');
                //update order status to order completed in table `tblorderdetails`
                $updateOrderStatus = $connect->prepare("UPDATE tblorderdetails SET order_status=?,completed_time=? WHERE order_number=?");
                $updateOrderStatus->bind_param('sss',$bookStatus,$completedTime,$refNumber);
                $updateOrderStatus->execute();
                //update booking status to finished in table `tblreservation`
                $updateBookStatus = $connect->prepare("UPDATE tblreservation SET status=? WHERE id=?");
                $updateBookStatus->bind_param('si',$bookStatus,$id);
                $updateBookStatus->execute();
                header('Location:reservation.php');
               
            }
        }