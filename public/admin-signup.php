<?php
session_start();
date_default_timezone_set('Asia/Manila');
use PHPMailer\PHPMailer\PHPMailer;
$fnameError = $lnameError = $passwordError = $confirmPwordError = $pwordError = $unameError = $emailError = $otpError = "";
  //check email to recover password
function updateVerificationCode(){ 
    require 'public/connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['btn-continue'])) {
        $email = mysqli_real_escape_string($connect, $_POST['email']); 
        $logo = "https://i.ibb.co/CMq6CXs/logo.png";
        if (!empty($email)) {
            $getUserRecord = $connect->prepare("SELECT * FROM tblusers WHERE email=?");
            $getUserRecord->bind_param('s', $email);
            $getUserRecord->execute();
            $row = $getUserRecord->get_result();
            $fetchUserRecord = $row->fetch_assoc();
            if ($row->num_rows == 1) {
                if ($email == $fetchUserRecord['email']) {
                    $code = rand(999999, 111111);
                    $fetchCode = $fetchUserRecord['verification_code'];
                    $updateOtp = $connect->prepare("UPDATE tblusers SET verification_code=? WHERE email=?");
                    $updateOtp->bind_param('ss', $code, $email);
                    $updateOtp->execute();
                    if ($updateOtp) {
                        require 'php-mailer/vendor/autoload.php';
                        $mail = new PHPMailer;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = '';
                        $mail->Password = '';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->setFrom('mangmacsmarinerospizzahouse@gmail.com', "Mang Mac's Marinero");
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = "Your Mang Mac's reset password code";
                        $mail->Body = "<main style='background: #ffffff; width: 350px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); padding: 1rem;'>
                        <header style='display: flex; align-items: center;'>
                            <img src='$logo' width='100' alt='mang-macs-logo'>
                            <h1 style='font-size: .9rem;  font-family: Arial, Helvetica, sans-serif;'> Mang Mac's Foodshop</h1>
                        </header>
                        <article>
                            <p style='font-size: 1rem; line-height: 1.3rem; font-family: Arial, Helvetica, sans-serif; color: #747474;'>
                                Hi,<br>Welcome to Mang Mac's Foodshop. Please use the mentioned code below to reset your password.
                            </p>
                        </article>
                        <article style='display: flex; justify-content: center;'>
                            <strong style='width:100%; text-align:center; background: #E7E7E7; padding: 2rem; font-size: 2rem; letter-spacing: 3px;'>$code</strong>
                        </article>
                        <footer style='text-align: center; margin-top: 30px;'>
                            <p style='margin: 10px 0 5px 0; font-family: Arial, Helvetica, sans-serif; color: #747474;'>from</p>
                            <strong style='font-family: Arial, Helvetica, sans-serif;'>MangMac's Foodshop</strong>
                            <p style='margin: 7px 0 0 0; font-family: Arial, Helvetica, sans-serif; color: #747474;'>Zone 5, Brgy. Sta. Lucia Bypass Road,<br>Urdaneta Philippines</p>
                        </footer>
                        </main>";
                        $mail->AltBody = 'FROM: mangmacsmarinerospizzahouse@gmail.com';
                        if ($mail->send()) {
                            $info = "We've sent a verification code to your email - $email to reset your password.";
                            $_SESSION['info'] = $info;
                            $_SESSION['email'] = $email;
                            $_SESSION['password'] = $password;
                            header('location: otp-reset.php?msg-success');
                            exit();
                        } else {
                            header('Location:forgot-password.php?Failed');
                        }
                    }
                }

            } else {
                $GLOBALS['emailError'] = "Email not found";
            }
        }
    }
    }
}
function verifiyCode(){
    require 'public/connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['btn-otp-reset'])) {
            $otpReset = mysqli_real_escape_string($connect, $_POST['otp-reset']);
            $getUserOtp = $connect->prepare("SELECT * FROM tblusers WHERE verification_code=?");
            $getUserOtp->bind_param('s', $otpReset);
            $getUserOtp->execute();
            $row = $getUserOtp->get_result();
            $fetchOtp = $row->fetch_assoc();
            $email = $fetchOtp['email'];
            $_SESSION['emailAddress'] = $email;
            if ($row->num_rows == 1) {
                if ($otpReset == $fetchOtp['verification_code']) {
                    header('Location:reset-password.php');
                }
            } else {
                $GLOBALS['otpError'] = "Incorrect Code";
            }
    
        }
    }
}
function resetPassword(){
    require 'public/connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btn-reset'])) {
            $newPassword = mysqli_real_escape_string($connect, $_POST['newPassword']);
            $confirmPassword = mysqli_real_escape_string($connect, $_POST['confirmPassword']);
            $resetPasswordHash = password_hash($confirmPassword, PASSWORD_DEFAULT);
            $code = 0;
            $email = $_SESSION['emailAddress'];
            //verify code
            if ($newPassword === $confirmPassword) {
                $updateUserPassword = $connect->prepare("UPDATE tblusers SET user_password=?,verification_code=? WHERE email=?");
                echo $connect->error;
                $updateUserPassword->bind_param('sss', $resetPasswordHash, $code, $email);
                $updateUserPassword->execute();
                if ($updateUserPassword) {
                    header('Location:reset-password.php?password-changed');
                }
            } else {
                $GLOBALS['confirmPwordError'] = "Password do not match.";
            }
        }
    }
}
updateVerificationCode();
verifiyCode();
resetPassword();
?>
