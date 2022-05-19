<?php
require 'public/admin-inventory.php';
if (!isset($_SESSION['loggedIn'])) {
    header('Location:login.php');
}
date_default_timezone_set('Asia/Manila');
$unameError = $emailError = $pwordError = "";
//add users
function insertUsers(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-save-user'])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $fname = mysqli_real_escape_string($connect, $_POST['fname']);
            $lname = mysqli_real_escape_string($connect, $_POST['lname']);
            $uname = mysqli_real_escape_string($connect, $_POST['uname']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $password = mysqli_real_escape_string($connect, $_POST['password']);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $profile = "no image";
            $position = mysqli_real_escape_string($connect, $_POST['position']);
            $created_at = date('y-m-d h:i:s');
            $verification_code = 0;
            //check username and email
            $check_uname_email = $connect->prepare("SELECT * FROM tblusers WHERE uname=? OR email=?");
            $check_uname_email->bind_param('ss', $uname, $email);
            $check_uname_email->execute();
            $row = $check_uname_email->get_result();
            $fetch = $row->fetch_assoc();
            //check if username already exists
            if ($row->num_rows == 1) {
                if ($uname == $fetch['uname']) {
                    $GLOBALS['unameError'] =  "Username already exist.";
                }
                if ($email == $fetch['email']) {
                    $GLOBALS['emailError'] =  "Email already exist.";
                }
            }
            if (strlen($password) <= 8) {
                $pwordError = "Password must contain at least 8 characters";
            } else {
                //insert user
                $insertUser = $connect->prepare("INSERT INTO tblusers(id,fname,lname,uname,email,user_password,profile,position,created_at,verification_code)
                VALUES(?,?,?,?,?,?,?,?,?,?)");
                $insertUser->bind_param('issssssssi', $id, $fname, $lname, $uname, $email, $passwordHash, $profile, $position, $created_at, $verification_code);
                $insertUser->execute();
                if ($insertUser) {
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Insert new user successfully";
                    header('Location:users.php');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not insert user";
                    header('Location:products.php');
                }
            } 
        }
    }
}
function editUsers(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-edit-user'])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $fname = mysqli_real_escape_string($connect, $_POST['fname']);
            $lname = mysqli_real_escape_string($connect, $_POST['lname']);
            $uname = mysqli_real_escape_string($connect, $_POST['uname']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $position = mysqli_real_escape_string($connect, $_POST['position']);
            $created_at = date('y-m-d h:i:s');
            //check username and email
            $check_uname_email = $connect->prepare("SELECT * FROM tblusers WHERE uname=? OR email=?");
            $check_uname_email->bind_param('ss', $uname, $email);
            $check_uname_email->execute();
            $row = $check_uname_email->get_result();
            $fetch = $row->fetch_assoc();
            if ($row->num_rows == 1) {
                $updateUser = $connect->prepare("UPDATE tblusers SET fname=?,lname=?,uname=?,email=?,position=? WHERE id=?");
                $updateUser->bind_param('sssssi', $fname, $lname, $uname, $email, $position, $id);
                $updateUser->execute();
                if ($updateUser) {
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Update user successully";
                    header('Location:users.php');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not update user";
                    header('Location:users.php');
                }
            }
        }
    }
}
function deleteUsers(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-delete-users'])) {
            $code = mysqli_real_escape_string($connect, $_POST['id']);
            $deleteInventory = $connect->prepare("DELETE FROM tblusers WHERE id=?");
            $deleteInventory->bind_param('i', $code);
            $deleteInventory->execute();
            if ($deleteInventory) {
                //alter table id column
                $alterTable = "ALTER TABLE users AUTO_INCREMENT = 1";
                $alterTableId = $connect->query($alterTable);
                if ($alterTableId) {
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Delete user successfully";
                    header('Location:users.php');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not delete user";
                    header('Location:users.php');
                }
            }
        }
    }
}
insertUsers();
editUsers();
deleteUsers();
?>