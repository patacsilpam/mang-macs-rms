<?php
require 'public/admin-inventory.php';
//update password
$pwordError = $newPwordError= $confirmPwordError = $pwordNotMatch = "";

function updatePassword(){
    require 'public/connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btn-change-password'])) {
            $currentPassword = mysqli_real_escape_string($connect, $_POST['currentPassword']);
            $newPassword = mysqli_real_escape_string($connect, $_POST['newPassword']);
            $confirmPassword = mysqli_real_escape_string($connect, $_POST['confirmPassword']);
            $passwordHash = password_hash($confirmPassword, PASSWORD_DEFAULT);
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                echo "Fill out all fields.";
            }
            if (strlen($newPassword) < 8) {
                $GLOBALS['newPwordError'] = "Password must contain at least 8 characters"; //check the length of new password field
            }
            if (strlen($confirmPassword) < 8) {
                $GLOBALS['confirmPwordError'] =  "Password must contain at least 8 characters"; //check the length of confirm password field
            }
            if ($newPassword === $confirmPassword) {
                $check_admin_password = $connect->prepare("SELECT * FROM tblusers WHERE email=?"); //check password
                $check_admin_password->bind_param('s', $email);
                $check_admin_password->execute();
                $row = $check_admin_password->get_result();
                $fetch = $row->fetch_assoc();
                if ($row->num_rows == 1) {
                    if ($currentPassword == $fetch['user_password'] || password_verify($currentPassword, $fetch['user_password'])) { //check the password if correct
                        $update_admin_password = $connect->prepare("UPDATE tblusers SET user_password=? WHERE email=?");
                        $update_admin_password->bind_param('ss', $passwordHash, $email);
                        $update_admin_password->execute();
                        if ($update_admin_password) {
                            header('Location:profile.php?updated');
                        } else{
                            header('Location:profile.php?error');
                        }
                    } else {
                       $GLOBALS['pwordError'] = "Incorrect password.";
                    }
                }
            }
            else{
                $GLOBALS['pwordNotMatch'] = "Password do not match";
            }
        }
    }
}
updatePassword();
?>