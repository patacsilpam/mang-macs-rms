<?php
session_start();
$unameEmailError = $pwordError = "";
function login(){
    require 'public/connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btnSignin'])) {
            $unameEmail = mysqli_real_escape_string($connect, $_POST['unameEmail']);
            $pword = mysqli_real_escape_string($connect, $_POST['pword']);
            $position = 'Admin';
            //check username and email
            $check_uname_email = $connect->prepare("SELECT * FROM tblusers WHERE uname=? OR email=? OR position=?");
            $check_uname_email->bind_param('sss', $unameEmail, $unameEmail,$position);
            $check_uname_email->execute();
            $row_uname_email = $check_uname_email->get_result();
            $fetch = $row_uname_email->fetch_assoc();
            if ($row_uname_email->num_rows == 1) {
                if ($pword == $fetch['user_password'] ||  password_verify($pword, $fetch['user_password'])) {
                    $_SESSION['id'] = $fetch['id'];
                    $_SESSION['fname'] = $fetch['fname'];
                    $_SESSION['lname'] = $fetch['lname'];
                    $_SESSION['uname'] = $fetch['uname'];
                    $_SESSION['email'] = $fetch['email'];
                    $_SESSION['loggedIn'] = true;
                    header('Location:dashboard.php');
                } else {
                    $GLOBALS['pwordError'] = "Incorrect Password.";
                }
            } else {
                $GLOBALS['unameEmailError'] = "Username or email not found.";
            }
        }
    }
}
login();
?>