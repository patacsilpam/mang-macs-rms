<?php

function updateProfile(){
    require 'public/connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btn-update-account'])) {
            $id = mysqli_real_escape_string($connect, $_POST['number']);
            $fname = mysqli_real_escape_string($connect, $_POST['fname']);
            $lname = mysqli_real_escape_string($connect, $_POST['lname']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $uname = mysqli_real_escape_string($connect, $_POST['uname']);
            $position = mysqli_real_escape_string($connect, $_POST['position']);
            $adminImage = basename($_FILES['adminImage']['name'] ?? '');
            $adminImageTemp = $_FILES['adminImage']['tmp_name'] ?? '';
            $imgUserDecodeUrl = "http://192.168.1.70/mang-macs-admin-web/assets/user-profile-pic/".$adminImage;
            $targetFilePath =  "assets/user-profile-pic/".$adminImage; //file upload path
            move_uploaded_file($adminImageTemp, $targetFilePath);
            //
            $folderPath = "assets/signature-uploads/";
            $splitImgStr = explode(";base64,", $_POST['e-signed']) ?? '';//split the image in to two (image type,image string)
            $imgTypeAux = explode("image/", $splitImgStr[0]) ?? '';//split data:image/png    
            $imgType = $imgTypeAux [1] ?? ''; //get the array index 1 -- png  
            $imgDecodeBase64 = base64_decode($splitImgStr[1]) ?? ''; //decode the lengthy image string 
            $file = $folderPath . uniqid() . '.'.$imgType; //set the format of the image (assets/uploads/uniqueId.png)
            file_put_contents($file, $imgDecodeBase64);//set a unique id and upload to specified folder path (see 56 line of code)
            $imgSigDecodeUrl = "http://192.168.1.70/mang-macs-admin-web/".$file;
           
            if ($adminImageTemp != '' || $imgDecodeBase64 != '') 
            {
                $check_admin_profile = $connect->prepare("SELECT * FROM tblusers WHERE id=?");
                $check_admin_profile->bind_param('i', $id);
                $check_admin_profile->execute();
                $row = $check_admin_profile->get_result();
                $fetch = $row->fetch_assoc();
                $userProfilePic = (empty($adminImageTemp)) ? $fetch['profile'] : $imgUserDecodeUrl;
                $userSignature = (empty($imgDecodeBase64)) ? $fetch['e_signature'] : $imgSigDecodeUrl;
                //update user's profile
                $update_admin_profile = $connect->prepare("UPDATE tblusers SET fname=?,lname=?,uname=?,email=?,profile=?,position=?,e_signature=? WHERE id=?");
                $update_admin_profile->bind_param('sssssssi', $fname, $lname, $uname, $email, $userProfilePic, $position,$userSignature ,$id);
                $update_admin_profile->execute();
                if ($update_admin_profile) {  
                    header('Location:profile.php?updated');
                } else{
                    header('Location:profile.php?error');
                }
            } 
            else {
                //update user's profile
                $update_admin_profile = $connect->prepare("UPDATE tblusers SET fname=?,lname=?,uname=?,email=?,position=? WHERE id=?");
                $update_admin_profile->bind_param('sssssi', $fname, $lname, $uname, $email, $position ,$id);
                $update_admin_profile->execute();
                if ($update_admin_profile) {  
                    header('Location:profile.php?updated');
                } else{
                    header('Location:profile.php?error');
                }
            }
        }
    }

}
updateProfile();
?>