<?php
require 'public/connection.php';

session_start();
if (!isset($_SESSION['loggedIn'])) {
    header('Location:login.php');
}
date_default_timezone_set('Asia/Manila');
//display notification
$countNotif = "SELECT COUNT(*) FROM
            (SELECT * FROM tblinventory WHERE expiration_date < now()
            UNION
            SELECT * FROM tblinventory WHERE expiration_date BETWEEN curdate() + 1 AND DATE_ADD(curdate(), INTERVAL 6 DAY)) tblinventory ";
$displayNotif = $connect->query($countNotif);
$fetchNotif = $displayNotif->fetch_row();
//
function insertStocks(){
    require 'public/connection.php';
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST["btn-save-inventory"])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $created_at = mysqli_real_escape_string($connect,$_POST['purchasedDate']);
            $expirationDate = mysqli_real_escape_string($connect, $_POST['expirationDate']);
            $product = mysqli_real_escape_string($connect, $_POST['product']);
            $quantityPurchased= mysqli_real_escape_string($connect, $_POST['quantityPurchased']);
            $quantityInStock = $quantityPurchased;
            $quantitySold = 0;
            $status ='';
            $inCharge = '';
            //insert inventory
            $insertInventory = $connect->prepare("INSERT tblinventory(id,expiration_date,created_at,product,quantityPurchased,quantityInStock,quantitySold,status,in_charge)
            VALUES (?,?,?,?,?,?,?,?,?)");
            $insertInventory->bind_param('isssiiiss', $id, $expirationDate, $created_at, $product,$quantityPurchased,$quantityInStock,$quantitySold, $status,$inCharge);
            $insertInventory->execute();
            if ($insertInventory) {
                $_SESSION['status'] = "Successful";
                $_SESSION['status_code'] ="success";
                $_SESSION['message'] = "Insert new item successfully";
                header('Location:inventory.php');
            } else{
                $_SESSION['status'] = "Error";
                $_SESSION['status_code'] ="error";
                $_SESSION['message'] = "Could not insert item";
                header('Location:products.php');
            }
        }
    }
}
function updateStocks(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST["btn-edit-inventory"])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $purchasedDate =  mysqli_real_escape_string($connect, $_POST['purchasedDate']);
            $expirationDate = mysqli_real_escape_string($connect, $_POST['expirationDate']);
            $product = mysqli_real_escape_string($connect, $_POST['product']);
            $quantityPurchased = mysqli_real_escape_string($connect, $_POST['quantityPurchased']);
            $quantityInStock = mysqli_real_escape_string($connect,$_POST['quantityInStock']);
            $quantitySold = $quantityPurchased - $quantityInStock;
            $status = '';
            $inCharge = '';
            //insert inventory
            if (!empty($expirationDate) && !empty($product) && !empty($quantityPurchased) && !empty($quantityInStock)) {
                $updateInventory = $connect->prepare("UPDATE tblinventory SET created_at=?,expiration_date=?,product=?,quantityPurchased=?,quantityInStock=?,quantitySold=?,status=?,in_charge=? WHERE id=?");
                $updateInventory->bind_param('sssiiissi', $purchasedDate,$expirationDate, $product, $quantityPurchased,$quantityInStock,$quantitySold, $status,$inCharge, $id);
                $updateInventory->execute();
                if ($updateInventory) {
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Update item successfully";
                    header('Location:inventory.php');
                }  else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not update item";
                    header('Location:products.php');
                }
            }
        }
    }
}
function deleteStocks(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-delete'])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $deleteInventory = $connect->prepare("DELETE FROM tblinventory WHERE id=?");
            $deleteInventory->bind_param('i', $id);
            $deleteInventory->execute();
            if ($deleteInventory) {
                //alter table id column
                $alterTable = "ALTER TABLE tblinventory AUTO_INCREMENT = 1";
                $alterTableId = $connect->query($alterTable);
                if ($alterTableId) {
                    header('Location:inventory.php');
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Delete item successfully";
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not delete item";
                    header('Location:products.php');
                }
            }
        }
    }
}
insertStocks();
updateStocks();
deleteStocks();
?>