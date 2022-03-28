<?php
require 'public/admin-inventory.php';
global $fetch;
$unameError = "";
global $waitingTime;
global $deliveryChange;
function updateSalary(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-salary'])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $fname = mysqli_real_escape_string($connect, $_POST['fname']);
            $lname = mysqli_real_escape_string($connect, $_POST['lname']);
            $uname = mysqli_real_escape_string($connect, $_POST['uname']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $position = mysqli_real_escape_string($connect, $_POST['position']);
            $salary = mysqli_real_escape_string($connect, $_POST['salary']);
            //check username and email
            $check_uname_email = $connect->prepare("SELECT * FROM tblusers WHERE uname=? OR email=?");
            $check_uname_email->bind_param('ss', $uname, $email);
            $check_uname_email->execute();
            $row = $check_uname_email->get_result();
            $fetch = $row->fetch_assoc();
            //update salary
            if ($row->num_rows == 1) {
                $updateUser = $connect->prepare("UPDATE tblusers SET fname=?,lname=?,uname=?,email=?,position=?,salary=? WHERE id=?");
                $updateUser->bind_param('sssssii', $fname, $lname, $uname, $email, $position, $salary, $id);
                $updateUser->execute();
                if ($updateUser) {
                    header('Location:settings.php?update-successfully');
                }
            } else {
                if ($fetch['uname'] == $uname) {
                    $GLOBALS['unameError'] = "Username already exist.";
                }
            }
        }
    }
}
function settings(){
    require 'public/connection.php';
   
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
        $selectSettings = "SELECT * FROM tblsettings";
        $displaySettings = $connect->query($selectSettings);
        $fetch = $displaySettings->fetch_assoc();
        $id = $fetch['id'];
        
        if (isset($_POST["save"])) {
            $id = 0;
            $waitingTimeAmount = $_POST['waitingTime'];
            $deliveryChangeAmount = $_POST['deliveryChange'];
            $insertSettingsContent = $connect->prepare("INSERT INTO tblsettings(id,waitingTime,deliveryChange) VALUES(?,?,?)");
            $insertSettingsContent->bind_param('isi', $id, $waitingTimeAmount, $deliveryChangeAmount);
            $insertSettingsContent->execute();
            if ($insertSettingsContent) {
                header('Location:settings.php?');
            }
        }
        if (isset($_POST["edit"])) {
            $waitingTimeAmount = $_POST['waitingTime'];
            $deliveryChangeAmount = $_POST['deliveryChange'];
            $updateSettingsContent = $connect->prepare("UPDATE tblsettings SET waitingTime=?,deliveryChange=? WHERE id=?");
            $updateSettingsContent->bind_param('sii', $waitingTimeAmount, $deliveryChangeAmount, $id);
            $updateSettingsContent->execute();
            if ($updateSettingsContent) {
                header('Location:settings.php?');
            }
        }
    }
}
updateSalary();
settings();

?>