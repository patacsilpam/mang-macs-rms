if($mail->send()){
                        use PHPMailer\PHPMailer\PHPMailer;
                        $mails = new PHPMailer;
                        $mails->isSMTP();
                        $mails->Host = 'smtp.gmail.com';
                        $mails->SMTPAuth = true;
                        $mails->Username = 'mangmacsmarinerospizzahouse@gmail.com';
                        $mails->Password = 'uihz grau bhyt qikw';
                        $mails->SMTPSecure = 'tls';
                        $mails->Port = 587;
                        $mails->setFrom('mangmacsmarinerospizzahouse@gmail.com', "Mang Mac's Marinero");
                        $mails->addAddress($email);
                        $mails->isHTML(true);
                        $mails->Subject("Table Reservation Slip");
                        $mails->Body ="  <div style='background:#ffffff; border:15px solid #36E49A; font-family:arial;  width:450px;   margin:0 auto;  padding:20px;'>
                        <div style='padding:5px; text-align:center;'>
                        <div style='background:#000;  color:#fff;   font-size:2rem; width:70px; height:70px; border-radius:50%; margin:auto;'>
                                <p><span style='line-height:70px;'>$firstLetter</span></p>
                            </div>
                            <div>
                                <p>$customerName</p>
                            </div>
                        </div>
                        <div style='border:1px solid #000;  margin:auto; text-align:center;'>
                            <p>Order #: $refNumer</p>
                        </div>
                        <p style='color:#6F6F6F; font-size:12px; text-align:center;'><?php date_default_timezone_set('Asia/Manila'); echo date('Y-m-d h:i a')?></p>
                        <hr>
                        <div style='color:#6F6F6F; margin:20px 0;'>
                            <div>
                                <span>Email:</span>
                                <span style='float:right;'>$email</span>
                            </div>
                            <div style='margin:20px 0;'>
                                <span>Name:</span>
                                <span style='float:right;'>$customerName</span>
                            </div>
                            <div>
                                <span>Guests:</span>
                                <span style='float:right;'>$guests</span>
                            </div>
                            <div>
                                <span>Scheduled Date:</span>
                                <span style='float:right;'>$schedDate $schedTime</span>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <p style='color:#6F6F6F; font-size:12px; text-align:center;'>Please show this to the counter to process your table reservation.</p>
                        </div>
                        <div>
                            <h1 style='color:#36E49A; font-size:1.3rem; text-align:center;'>MANG MAC'S MARINEROS  <br> PIZZA HOUSE</h1>
                        </div>
                    </div>";
                    $mails->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                    $mails->send();
                    header('Location:reservation.php?updated');