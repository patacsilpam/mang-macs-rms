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
$countRunningStock = "SELECT COUNT(DISTINCT(code)) FROM tblinventory WHERE quantityInStock <= 20 ";
$displayRunStock = $connect->query($countRunningStock);
$fetchRunOfStock = $displayRunStock->fetch_row();
function insertStocks(){
    require 'public/connection.php';
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST["btn-save-inventory"])) {
            $itemCode = bin2hex(random_bytes(5));
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $created_at = mysqli_real_escape_string($connect,$_POST['purchasedDate']);
            $expirationDate = mysqli_real_escape_string($connect, $_POST['expirationDate']);
            $product = mysqli_real_escape_string($connect, $_POST['product']);
            $quantityPurchased= mysqli_real_escape_string($connect, $_POST['quantityPurchased']);
            $itemCategory = mysqli_real_escape_string($connect,$_POST['itemCategory']);
            $itemVariation = mysqli_real_escape_string($connect,$_POST['itemVariation']);
            $code = $product."-".$itemVariation."-".$itemCategory;
            $quantityInStock = $quantityPurchased;
            $quantitySold = 0;
            $status ='';
            $inCharge = '';
            $lastPiece = explode("=",$product);//split product code and product name (this is for insert name of the product)
            $statusDb = "expired";
            $getStock = $connect->prepare("SELECT itemCode,code,quantityInStock FROM tblinventory WHERE code=? AND status != ?");
            $getStock->bind_param('ss',$code,$statusDb);
            $getStock->execute();
            $row = $getStock->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows>0){
                date_default_timezone_set('Asia/Manila'); 
                $today = date('Y-m-d');
                $expDate = date('Y-m-d',strtotime($expirationDate));
                if($today <= $expDate){
                    $codeDb = $fetch['code'];
                    $totalStock = $quantityPurchased + $fetch['quantityInStock'];
                    $updateStock = $connect->prepare("UPDATE tblinventory SET quantityInStock=? WHERE code=? AND status != ?");
                    $updateStock->bind_param('iss',$totalStock,$codeDb,$statusDb);
                    $updateStock->execute();
                    //if stock already updated insert in table inventory
                    $insertInventory = $connect->prepare("INSERT tblinventory(id,itemCode,code,expiration_date,created_at,product,quantityPurchased,quantityInStock,quantitySold,status,itemCategory,itemVariation)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $insertInventory->bind_param('isssssiiisss', $id,$itemCode,$codeDb,$expirationDate, $created_at, $product,$quantityPurchased,$totalStock,$quantitySold, $status,$itemCategory,$itemVariation);
                    $insertInventory->execute();
                    if ($insertInventory) {
                        if($product == "Pizza Bread"){
                            $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productCategory=? AND productVariation=?");
                            $updateProductStock->bind_param('iss',$totalStock,$itemCategory,$itemVariation);
                            $updateProductStock->execute();
                            header('Location:inventory.php?inserted');
                        }
                        else{
                            $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE  productName=? AND productCategory=?");
                            $updateProductStock->bind_param('iss',$totalStock,$product,$itemCategory);
                            $updateProductStock->execute();
                            header('Location:inventory.php?inserted');
                        }
                       
                    } else{
                        header('Location:inventory.php?error');
                    }
                } 
                else{
                    header('Location:inventory.php?error');
                }
            }
             //insert non existent product in table inventory
            else{
                date_default_timezone_set('Asia/Manila'); 
                $today = date('Y-m-d');
                $expDate = date('Y-m-d',strtotime($expirationDate));
                if($today <= $expDate) {
                    $insertInventory = $connect->prepare("INSERT tblinventory(id,itemCode,code,expiration_date,created_at,product,quantityPurchased,quantityInStock,quantitySold,status,itemCategory,itemVariation)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $insertInventory->bind_param('isssssiiisss', $id,$itemCode,$code,$expirationDate, $created_at, $product,$quantityPurchased,$quantityInStock,$quantitySold, $status,$itemCategory,$itemVariation);
                    $insertInventory->execute();
                        if($product == "Pizza Bread"){
                            $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productCategory=? AND productVariation=?");
                            $updateProductStock->bind_param('iss',$quantityPurchased,$itemCategory,$itemVariation);
                            $updateProductStock->execute();
                            header('Location:inventory.php?inserted');
                        }
                        else{
                            $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productCategory=? AND productName=?");
                            $updateProductStock->bind_param('iss',$quantityPurchased,$itemCategory,$product);
                            $updateProductStock->execute();
                            header('Location:inventory.php?inserted');
                        }
                    }
                else{
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
            $itemCategory = mysqli_real_escape_string($connect,$_POST['itemCategory']);
            $itemVariation = mysqli_real_escape_string($connect,$_POST['itemVariation']);
            $quantityPurchased = mysqli_real_escape_string($connect, $_POST['quantityPurchased']);
            $status = '';
            //check product code
            //$statusDb = "expired";
            $getStock = $connect->prepare("SELECT code,quantityPurchased,quantityInStock FROM tblinventory WHERE  id=? AND code=?");
            $getStock->bind_param('is',$id,$code);
            $getStock->execute();
            $row = $getStock->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows>0){

              $totalStocks = $fetch['quantityInStock'] + $quantityPurchased;
              $purchased = $fetch['quantityPurchased'] + $quantityPurchased;
              date_default_timezone_set('Asia/Manila'); 
              $today = date('Y-m-d');
              $expDate = date('Y-m-d',strtotime($expirationDate));
              if($today <= $expDate){
                $updateStocks = $connect->prepare("UPDATE tblinventory SET quantityInStock=? WHERE code=?");
                $updateStocks->bind_param('is',  $totalStocks,$code);
                $updateStocks->execute();
                 $updateInventory = $connect->prepare("UPDATE tblinventory SET created_at=?,expiration_date=?,product=?,quantityPurchased=?,quantitySold=?,status=?,itemCategory=?,itemVariation=? WHERE id=?");
                 $updateInventory->bind_param('sssiisssi', $purchasedDate,$expirationDate, $product, $purchased,$quantitySold, $status,$itemCategory,$itemVariation, $id,);
                 $updateInventory->execute();
                 if ($updateInventory) {
                     if($product == "Pizza Bread"){
                         $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productCategory=? AND productVariation=?");
                         $updateProductStock->bind_param('iss',$totalStocks,$itemCategory,$itemVariation);
                         $updateProductStock->execute();
                         header('Location:inventory.php?updated');
                     }
                     else{
                         $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productName=? AND productCategory=?");
                         $updateProductStock->bind_param('iss',$totalStocks,$product,$itemCategory);
                         $updateProductStock->execute();
                         header('Location:inventory.php?updated');
                     }
                 }  else{
                     header('Location:inventory.php?update_item_error');
                 }
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
            $product = mysqli_real_escape_string($connect, $_POST['product']);
            $itemCategory = mysqli_real_escape_string($connect, $_POST['itemCategory']);
            $itemVariation = mysqli_real_escape_string($connect, $_POST['itemVariation']);
            $getStock = $connect->prepare("SELECT code,quantityPurchased,quantityInStock FROM tblinventory WHERE  id=?");
            $getStock->bind_param('i',$id);
            $getStock->execute();
            $row = $getStock->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows>0){
                $quantityPurchased = $fetch['quantityInStock'] - $purchased;
                $updateStock = $connect->prepare("UPDATE tblinventory SET quantityInStock=? WHERE code=?");
                $updateStock->bind_param('is',$quantityPurchased,$code);
                $updateStock->execute();

                if($product == "Pizza Bread"){
                    $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productCategory=? AND productVariation=?");
                    $updateProductStock->bind_param('iss',$quantityPurchased,$itemCategory,$itemVariation);
                    $updateProductStock->execute();
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
                else{
                    $updateProductStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productName=? AND productCategory=?");
                    $updateProductStock->bind_param('iss',$quantityPurchased,$product,$itemCategory);
                    $updateProductStock->execute();
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
}
function autoDeletion(){
    require 'public/connection.php';
    
    $selectProduct = "SELECT * FROM tblinventory WHERE expiration_date < CURDATE()";
     $displayProduct = $connect->query($selectProduct);
    while($fetch = $displayProduct->fetch_assoc()){
        $id = NULL;
        $idDb = $fetch['id'];
        $itemCodeDb = $fetch['itemCode'];
        $codeDb = $fetch['code'];
        $expDateDb = $fetch['expiration_date'];
        $createAtDb = $fetch['created_at'];
        $productDb = $fetch['product'];
        $qtyPurchasedDb = $fetch['quantityPurchased'];
        $itemCategoryDb = $fetch['itemCategory'];
        $itemVariationDb = $fetch['itemVariation'];
        $insertExpItemDb = $connect->prepare("INSERT INTO tblexpired(id,itemCode,item_name,code,expiration_date,created_at,quantity_purchased,item_category,item_variation) VALUES(?,?,?,?,?,?,?,?,?)");
        $insertExpItemDb->bind_param('isssssiss',$id,$itemCodeDb,$productDb,$codeDb,$expDateDb,$createAtDb,$qtyPurchasedDb,$itemCategoryDb,$itemVariationDb);
        $insertExpItemDb->execute();
        $deleteExpItemDb = $connect->prepare("DELETE FROM tblinventory WHERE id=?");
        $deleteExpItemDb->bind_param('i',$idDb);
        $deleteExpItemDb->execute();
    }
   
}

insertStocks();
updateStocks();
deleteStocks();
autoDeletion();

?>