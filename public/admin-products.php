<?php
require 'public/connection.php';
require 'public/admin-inventory.php';
date_default_timezone_set('Asia/Manila');
function insertProducts(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-save-products'])) {
            $id = $_POST['id'];
            $productName =  $_POST['productName'];
            $productCategory = $_POST['productCategory'];
            $noCategoryPrice = $_POST['price'];
            $pizzaSize = $_POST['pizzaSize'];
            $pizzaPrice = $_POST['pizzaPrice'];
            $bilaoSize = $_POST['bilaoSize'];
            $bilaoPrice = $_POST['bilaoPrice'];
            $stocks = $_POST['stocks'];
            $preparationTime = $_POST['preparedTime'];
            $productImage = basename($_FILES['imageProduct']['name'] ?? '');
            $imageTemp = $_FILES['imageProduct']['tmp_name'] ?? '';
            $imageServerUrl = "http://192.168.1.14/Mang-Macs-Management-System/assets/img-products/".$productImage;
            $created_at = date('Y-m-d h:i:s');
            $imageFolderPath = "assets/img-products/".$productImage;
            move_uploaded_file($imageTemp,$imageFolderPath);
            //check if product name already exist
            $check_uname_email = $connect->prepare("SELECT * FROM tblproducts WHERE productName=?");
            $check_uname_email->bind_param('s', $productName);
            $check_uname_email->execute();
            $row = $check_uname_email->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows > 0){
                if($fetch['productName'] == $productName){
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Product already exist.";
                    header('Location:products.php');
                }
            }
             //insert pizza if selected
            else if($productCategory == "Pizza"){
                foreach($pizzaSize as $key => $value){
                    $newId = $id[$key];
                    $code = bin2hex(random_bytes(20));
                    $newPizzaSize = $value;
                    $newPizzaPrice = $pizzaPrice[$key];
                    $insertProduct = $connect->prepare("INSERT tblproducts(id,code,productName,productCategory,productVariation,stocks,price,preparationTime,productImage,created_at)
                    VALUES(?,?,?,?,?,?,?,?,?,?)");
                    $insertProduct->bind_param('issssiiiss', $newId,$code, $productName, $productCategory, $newPizzaSize,$stocks,$newPizzaPrice, $preparationTime,$imageServerUrl, $created_at);
                    $insertProduct->execute();
                    if ($insertProduct) {
                        $_SESSION['status'] = "Successful";
                        $_SESSION['status_code'] ="success";
                        $_SESSION['message'] = "Insert new product successfully";
                        header('Location:products.php');
                    } else{
                        $_SESSION['status'] = "Error";
                        $_SESSION['status_code'] ="error";
                        $_SESSION['message'] = "Could not insert product";
                        header('Location:products.php');
                    }
                }
            }
              //insert bilao if selected
            else if($productCategory == "Carbonara Bilao" || $productCategory == "Palabok Bilao" || $productCategory == "Pancit Bilao(Bihon Guisado)" || $productCategory == "Pancit Bilao(Canton Bihon)" || $productCategory == "Spaghetti Bilao"){ 
                foreach($bilaoSize as $key => $value){
                    $newId = $id[$key];
                    $code = bin2hex(random_bytes(20));
                    $newBilaoSize = $value;
                    $newBilaoPrice = $bilaoPrice[$key];
                    $insertProduct = $connect->prepare("INSERT tblproducts(id,code,productName,productCategory,productVariation,stocks,price,preparationTime,productImage,created_at)
                    VALUES(?,?,?,?,?,?,?,?,?,?)");
                    $insertProduct->bind_param('issssiiiss', $newId,$code, $productName, $productCategory, $newBilaoSize,$stocks,$newBilaoPrice, $preparationTime,$imageServerUrl, $created_at);
                    $insertProduct->execute();
                    if ($insertProduct) {
                        $_SESSION['status'] = "Successful";
                        $_SESSION['status_code'] ="success";
                        $_SESSION['message'] = "Insert new product successfully";
                        header('Location:products.php');
                    } else{
                        $_SESSION['status'] = "Error";
                        $_SESSION['status_code'] ="error";
                        $_SESSION['message'] = "Could not insert product";
                        header('Location:products.php');
                    }
                }
            }
              //insert product without category if selected
            else{
                $ids = "";
                $noCategorySize = '';
                $code = bin2hex(random_bytes(20));
                $insertProduct = $connect->prepare("INSERT tblproducts(id,code,productName,productCategory,productVariation,stocks,price,preparationTime,productImage,created_at)
                VALUES(?,?,?,?,?,?,?,?,?,?)");
                $insertProduct->bind_param('issssiiiss', $ids,$code, $productName, $productCategory, $noCategorySize,$stocks,$noCategoryPrice, $preparationTime,$imageServerUrl, $created_at);
                $insertProduct->execute();
                if ($insertProduct) {
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Insert new product successfully";
                    header('Location:products.php');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not insert product";
                    header('Location:products.php');
                }
            }
        }
    }
}
function updateProducts(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-update-products'])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $editProductName = mysqli_real_escape_string($connect, $_POST['editProductName']);
            $editProductCategory = mysqli_real_escape_string($connect, $_POST['editProductCategory']);
            $editProductVariation = mysqli_real_escape_string($connect, $_POST['editProductVariation']);
            $editPrice = mysqli_real_escape_string($connect, $_POST['editProductPrice']);
            $editPreparationTime = mysqli_real_escape_string($connect,$_POST['editPreparedTime']);
            $editImageProduct = basename($_FILES['editImageProduct']['name'] ?? '');
            $editImageProductTemp = $_FILES["editImageProduct"]["tmp_name"] ?? '';
            $imageFolderPath = "assets/img-products/".$editImageProduct;
            $imageServerUrl = "http://192.168.1.14/Mang-Macs-Management-System/assets/img-products/".$editImageProduct;
            $edited_at = date('Y-m-d h:i:s');
            //update product
            if  ($editImageProduct  != '') {
                $updateProduct = $connect->prepare("UPDATE tblproducts SET productName=?,productCategory=?,productVariation=?,price=?,preparationTime=?,productImage=?,created_at=? WHERE id=?");
                $updateProduct->bind_param('sssiissi', $editProductName, $editProductCategory, $editProductVariation, $editPrice,$editPreparationTime, $imageServerUrl, $edited_at, $id);
                $updateProduct->execute();
                if ($updateProduct) {
                    move_uploaded_file($editImageProductTemp,$imageFolderPath);
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Update product successfully";
                    header('Location:products.php');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not update product";
                    header('Location:products.php');
                }
            } else {
                //check image product
                $check_image_product = $connect->prepare("SELECT * FROM tblproducts WHERE id=?");
                $check_image_product->bind_param('i', $id);
                $check_image_product->execute();
                $row = $check_image_product->get_result();
                $fetch = $row->fetch_assoc();
                $editProductImage = $fetch['productImage'];
                //update product
                $updateProduct = $connect->prepare("UPDATE tblproducts SET productName=?,productCategory=?,productVariation=?,price=?,preparationTime=?,productImage=?,created_at=? WHERE id=?");
                echo $connect->error;
                $updateProduct->bind_param('sssiissi', $editProductName, $editProductCategory, $editProductVariation,$editPrice,$editPreparationTime,  $editProductImage, $edited_at, $id);
                $updateProduct->execute();
                if ($updateProduct) {
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Update product successfully";
                    header('Location:products.php?');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not update product";
                    header('Location:products.php');
                }
            }
        }
    }
}
function deleteProducts(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if (isset($_POST['btn-delete-products'])) {
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $deleteProduct = $connect->prepare("DELETE FROM tblproducts WHERE id=?");
            $deleteProduct->bind_param('i', $id);
            $deleteProduct->execute();
            //alter table id
            $alterTable = "ALTER TABLE tblproducts AUTO_INCREMENT=1";
            $alter = $connect->query($alterTable);
            if ($alter) {
                $_SESSION['status'] = "Successful";
                $_SESSION['status_code'] ="success";
                $_SESSION['message'] = "Delete product successfully";   
                header('Location:products.php?');
            }  else{
                $_SESSION['status'] = "Error";
                $_SESSION['status_code'] ="error";
                $_SESSION['message'] = "Could not delete item";
                header('Location:products.php');
            }
        }
    }
}

insertProducts();
updateProducts();
deleteProducts();
function updateProductStocks(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-update-stocks'])){
            $productName = $_POST['productName'];
            $size = $_POST['size'];
            $stock = $_POST['stocks'];
            foreach($productName as $key => $nameCode){
                $newSize = $size[$key];
                $newProductName = $nameCode;
                $newStock = $stock[$key];
                $updateNoStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE productName=? AND productVariation=?");
                $updateNoStock->bind_param('iss',$newStock,$newProductName,$newSize);
                $updateNoStock->execute();
                if($updateNoStock){
                    $_SESSION['status'] = "Successful";
                    $_SESSION['status_code'] ="success";
                    $_SESSION['message'] = "Update stock successfully";   
                    header('Location:available-menu.php?');
                } else{
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] ="error";
                    $_SESSION['message'] = "Could not update product";
                    header('Location:available-menu.php?false');
                }
            }
        }
    }
}
updateProductStocks();
?>