<?php
require 'public/connection.php';

session_start();
if (!isset($_SESSION['loggedIn'])) {
    header('Location:login.php');
}
date_default_timezone_set('Asia/Manila');
//display notification
$countNotif = "SELECT COUNT(*) FROM tblinventory WHERE expiration_date BETWEEN curdate() + 1 AND DATE_ADD(curdate(), INTERVAL 6 DAY)";
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
            $getCode = mysqli_real_escape_string($connect, $_POST['product']);
            $quantityPurchased= mysqli_real_escape_string($connect, $_POST['quantityPurchased']);
            $quantityInStock = $quantityPurchased;
            $quantitySold = 0;
            $status ='';
            $inCharge = '';
            $lastPiece = explode("=",$product);//split product code and product name
            $strProduct = array_pop($lastPiece);//remove last word and store it in a variable
            $code = strtok($getCode,"=");//get product code
            //check product if already exists and update quantity stock
            $getStock = $connect->prepare("SELECT code,quantityInStock FROM tblinventory WHERE code=?");
            $getStock->bind_param('s',$code);
            $getStock->execute();
            $row = $getStock->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows>0){
                $totalStock = $quantityPurchased + $fetch['quantityInStock'];
                $updateStock = $connect->prepare("UPDATE tblinventory SET quantityInStock=? WHERE code=?");
                $updateStock->bind_param('is',$totalStock,$code);
                $updateStock->execute();
                if ($updateStock) {
                    //if stock already updated insert in table inventory
                    $insertInventory = $connect->prepare("INSERT tblinventory(id,code,expiration_date,created_at,product,quantityPurchased,quantityInStock,quantitySold,status)
                    VALUES (?,?,?,?,?,?,?,?,?)");
                    $insertInventory->bind_param('issssiiis', $id,$code,$expirationDate, $created_at, $strProduct,$quantityPurchased,$totalStock,$quantitySold, $status);
                    $insertInventory->execute();
                    if ($insertInventory) {
                        header('Location:inventory.php?inserted');
                    } else{
                        header('Location:inventory.php?error');
                    }
                } else{
                    header('Location:inventory.php?error');
                }
            }
             //insert non existent product in table inventory
            else{
            $insertInventory = $connect->prepare("INSERT tblinventory(id,code,expiration_date,created_at,product,quantityPurchased,quantityInStock,quantitySold,status)
            VALUES (?,?,?,?,?,?,?,?,?)");
            $insertInventory->bind_param('issssiiis', $id,$code,$expirationDate, $created_at, $strProduct,$quantityPurchased,$quantityInStock,$quantitySold, $status);
            $insertInventory->execute();
            if ($insertInventory) {
                header('Location:inventory.php?inserted');
            } else{
                header('Location:inventory.php?item_error');
            }
        }      
        }
    }
}
function updateStocks(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST["btn-edit-inventory"])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $code = mysqli_real_escape_string($connect,$_POST['code']);
            $purchasedDate =  mysqli_real_escape_string($connect, $_POST['purchasedDate']);
            $expirationDate = mysqli_real_escape_string($connect, $_POST['expirationDate']);
            $product = mysqli_real_escape_string($connect, $_POST['product']);
            $quantityPurchased = mysqli_real_escape_string($connect, $_POST['quantityPurchased']);
            $status = '';
            //check product code
            $getStock = $connect->prepare("SELECT code,quantityPurchased,quantityInStock FROM tblinventory WHERE  id=? AND code=?");
            $getStock->bind_param('is',$id,$code);
            $getStock->execute();
            $row = $getStock->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows>0){
              $totalStocks = $fetch['quantityInStock'] + $quantityPurchased;
              $purchased = $fetch['quantityPurchased'] + $quantityPurchased;
              echo $totalStocks;
               // $quantityInStock = $fetch['quantityInStock'];
               // $purchased = $fetch['quantityPurchased'];
               $updateStocks = $connect->prepare("UPDATE tblinventory SET quantityInStock=? WHERE code=?");
               $updateStocks->bind_param('is',  $totalStocks,$code);
               $updateStocks->execute();
                $updateInventory = $connect->prepare("UPDATE tblinventory SET created_at=?,expiration_date=?,product=?,quantityPurchased=?,quantitySold=?,status=? WHERE id=?");
                $updateInventory->bind_param('sssiisi', $purchasedDate,$expirationDate, $product, $purchased,$quantitySold, $status, $id);
                $updateInventory->execute();
              
                if ($updateInventory) {
                    header('Location:inventory.php?updated');
                }  else{
                    header('Location:inventory.php?update_item_error');
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
            $code = mysqli_real_escape_string($connect, $_POST['code']);
            $purchased = mysqli_real_escape_string($connect, $_POST['purchased']);
            $getStock = $connect->prepare("SELECT code,quantityPurchased,quantityInStock FROM tblinventory WHERE  id=?");
            $getStock->bind_param('i',$id);
            $getStock->execute();
            $row = $getStock->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows>0){
                $quantityPurchased = $fetch['quantityInStock'] - $purchased;
                $updateStock = $connect->prepare("UPDATE tblinventory SET quantityInStock=? WHERE code=?");
                echo $connect->error;
                $updateStock->bind_param('is',$quantityPurchased,$code);
                $updateStock->execute();
                $deleteInventory = $connect->prepare("DELETE FROM tblinventory WHERE id=?");
                $deleteInventory->bind_param('i', $id);
                $deleteInventory->execute();
                if ($deleteInventory) {
                    //alter table id column
                    $alterTable = "ALTER TABLE tblinventory AUTO_INCREMENT = 1";
                    $alterTableId = $connect->query($alterTable);
                    if ($alterTableId) {
                        header('Location:inventory.php?deleted');
                    } else{
                        header('Location:inventory.php?delete_item_error');
                    }
                }
            }
        }
    }
}
function autoDeletion(){
    require 'public/connection.php';
    $autoDelProduct = $connect->prepare("DELETE FROM tblinventory WHERE expiration_date < CURDATE()");
    $autoDelProduct->execute();
}
insertStocks();
updateStocks();
deleteStocks();
autoDeletion();
?>