<?php
require 'public/admin-inventory.php';
global $fetch;
$unameError = "";
$waitingTime="";
$deliveryChange="";
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
function deliveryFee(){
    require 'public/connection.php';
   
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
        $selectSettings = "SELECT * FROM tblsettings";
        $displaySettings = $connect->query($selectSettings);
        $fetch = $displaySettings->fetch_assoc();
        $id = $fetch['id'];
        $GLOBALS['waitingTime'] = $fetch['waitingTime'];
        $GLOBALS['deliveryChange'] = $fetch['deliveryChange'];
        
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

function waitingTime(){
    require 'public/connection.php';
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
        if(isset($_POST['btn-waiting-time'])){
            $id = 1;
            $waitingTimeAmount = $_POST['waitingTime'];
            $updateSettingsContent = $connect->prepare("UPDATE tblsettings SET waitingTime=? WHERE id=?");
            $updateSettingsContent->bind_param('si', $waitingTimeAmount, $id);
            $updateSettingsContent->execute();
            if ($updateSettingsContent) {
                header('Location:settings.php?');
            }
        }
    }
}
updateSalary();
deliveryFee();
waitingTime();

?>