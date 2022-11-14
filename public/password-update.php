<?php
require 'public/admin-inventory.php';
//update password
$pwordError = $newPwordError= $confirmPwordError = $pwordNotMatch = "";

function updatePassword(){
    require 'public/connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btn-change-password'])) {
            $email = mysqli_real_escape_string($connect,$_POST['email']);
            $currentPassword = mysqli_real_escape_string($connect, $_POST['currentPassword']);
            $newPassword = mysqli_real_escape_string($connect, $_POST['newPassword']);
            $confirmPassword = mysqli_real_escape_string($connect, $_POST['confirmPassword']);
            $passwordHash = password_hash($confirmPassword, PASSWORD_DEFAULT);
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                echo "Fill out all fields.";
            }
            else if ($newPassword === $confirmPassword) {
                $check_admin_password = $connect->prepare("SELECT * FROM tblusers WHERE email=?"); //check password
                $check_admin_password->bind_param('s', $email);
                $check_admin_password->execute();
                $row = $check_admin_password->get_result();
                $fetch = $row->fetch_assoc();
                if ($row->num_rows > 0) {
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
                       header('Location:profile.php?pwordError');
                    }
                }
            }
            else{
                header('Location:profile.php?pwordNotMatch');
            }
        }
    }
}
updatePassword();
?>