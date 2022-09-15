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
            $likeProduct = $productName."%";
            $productCategory = $_POST['productCategory'];
            $noCategoryPrice = $_POST['price'];
            $pizzaSize = $_POST['pizzaSize'];
            $pizzaPrice = $_POST['pizzaPrice'];
            $bilaoSize = $_POST['bilaoSize'];
            $bilaoPrice = $_POST['bilaoPrice'];
            $stocks = $_POST['stocks'];
            $mainIngredients = $_POST['mainIngredients'];
            $preparationTime = $_POST['preparedTime'];
            $productImage = basename($_FILES['imageProduct']['name'] ?? '');
            $imageTemp = $_FILES['imageProduct']['tmp_name'] ?? '';
            $imageServerUrl = "http://10.68.253.181/mang-macs-admin-web/assets/img-products/".$productImage;
            $created_at = date('Y-m-d h:i:s');
            $imageFolderPath = "assets/img-products/".$productImage;
            move_uploaded_file($imageTemp,$imageFolderPath);
            $code="";
            //check if product name already exist
            $check_product_name = $connect->prepare("SELECT * FROM tblproducts WHERE productName LIKE (?) AND productCategory=?");
            $check_product_name ->bind_param('ss', $likeProduct,$productCategory);
            $check_product_name ->execute();
            $row = $check_product_name ->get_result();
            $fetch = $row->fetch_assoc();
            if($row->num_rows > 0){
                header('Location:products.php?error');
            }
             //insert pizza if selected
            else if($productCategory == "Pizza"){
                foreach($pizzaSize as $key => $value){
                    $newId = $id[$key];
                    $code = bin2hex(random_bytes(20));
                    $newPizzaSize = $value;
                    $newPizzaPrice = $pizzaPrice[$key];
                    $insertProduct = $connect->prepare("INSERT INTO tblproducts(id,code,productName,productCategory,productVariation,stocks,price,preparationTime,mainIngredients,productImage,created_at)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                    $insertProduct->bind_param('issssiiisss', $newId,$code, $productName, $productCategory, $newPizzaSize,$stocks,$newPizzaPrice, $preparationTime,$mainIngredients,$imageServerUrl, $created_at);
                    $insertProduct->execute();
                    if ($insertProduct) {
                        header('Location:products.php?inserted');
                    } else{
                        header('Location:products.php?error');
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
                    $insertProduct = $connect->prepare("INSERT INTO tblproducts(id,code,productName,productCategory,productVariation,stocks,price,preparationTime,mainIngredients,productImage,created_at)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                    $insertProduct->bind_param('issssiiisss', $newId,$code, $productName, $productCategory, $newBilaoSize,$stocks,$newBilaoPrice, $preparationTime,$mainIngredients,$imageServerUrl, $created_at);
                    $insertProduct->execute();
                    if ($insertProduct) {
                        header('Location:products.php?inserted');
                    } else{
                        header('Location:products.php?error');
                    }
                }
            }
              //insert product without category if selected
            else{
                $ids = "";
                $noCategorySize = '';
                $code = bin2hex(random_bytes(20));
                $insertProduct = $connect->prepare("INSERT INTO tblproducts(id,code,productName,productCategory,productVariation,stocks,price,preparationTime,mainIngredients,productImage,created_at)
                VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $insertProduct->bind_param('issssiiisss', $ids,$code, $productName, $productCategory, $noCategorySize,$stocks,$noCategoryPrice, $preparationTime,$mainIngredients,$imageServerUrl, $created_at);
                if ($insertProduct->execute()) {
                    header('Location:products.php?inserted');
                   
                } else{
                    header('Location:products.php?error');
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
            $editMainIngredients = mysqli_real_escape_string($connect,$_POST['editMainIngredients']);
            $editImageProduct = basename($_FILES['editImageProduct']['name'] ?? '');
            $editImageProductTemp = $_FILES["editImageProduct"]["tmp_name"] ?? '';
            $imageFolderPath = "assets/img-products/".$editImageProduct;
            $imageServerUrl = "http://10.68.253.181/mang-macs-admin-web/assets/img-products/".$editImageProduct;
            $edited_at = date('Y-m-d h:i:s');
            //update product
            if  ($editImageProduct  != '') {
                $updateProduct = $connect->prepare("UPDATE tblproducts SET productName=?,productCategory=?,productVariation=?,price=?,preparationTime=?,mainIngredients=?,productImage=?,created_at=? WHERE id=?");
                $updateProduct->bind_param('sssiisssi', $editProductName, $editProductCategory, $editProductVariation, $editPrice,$editPreparationTime,$editMainIngredients, $imageServerUrl, $edited_at, $id);
                $updateProduct->execute();
                if ($updateProduct) {
                    move_uploaded_file($editImageProductTemp,$imageFolderPath);
                    header('Location:products.php?updated');
                } else{
                    header('Location:products.php?error');
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
                $updateProduct = $connect->prepare("UPDATE tblproducts SET productName=?,productCategory=?,productVariation=?,price=?,preparationTime=?,mainIngredients=?,productImage=?,created_at=? WHERE id=?");
                echo $connect->error;
                $updateProduct->bind_param('sssiisssi', $editProductName, $editProductCategory, $editProductVariation,$editPrice,$editPreparationTime,$editMainIngredients,$editProductImage, $edited_at, $id);
                $updateProduct->execute();
                if ($updateProduct) {
                    
                    header('Location:products.php?updated');
                } else{
                  
                    header('Location:products.php?error');
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
                header('Location:products.php?deleted');
            }  else{
                header('Location:products.php?error');
            }
        }
    }
}

function updateProductStocks(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-update-stocks'])){
            $id = $_POST['ids'];
            $stock = $_POST['stocks'];
            $updateNoStock = $connect->prepare("UPDATE tblproducts SET stocks=? WHERE id=?");
            $updateNoStock->bind_param('ii',$stock,$id);
            $updateNoStock->execute();
            if($updateNoStock){ 
                header('Location:available-menu.php?update_stock');
            } else{
                header('Location:available-menu.php?update_product_error');
            }
        }
    }
}
//create or insert add-on data
function createAddOns(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-save-choices'])){
            $id = null;
            $code = bin2hex(random_bytes(20));
            $addOnsName = $_POST['add-ons-name'];
            $addOnsPrice = $_POST['add-ons-price'];
            $productName =  mysqli_real_escape_string($connect,$_POST['choiceGroup']);
            foreach($addOnsName as $addOnsIndex => $addOnsValue){
                $newAddOns = $addOnsValue;
                $newAddOnsPrice = $addOnsPrice[$addOnsIndex];
                $insertAddOns = $connect->prepare("INSERT INTO tbladdons(id,add_ons_code,add_ons,add_ons_price,add_ons_category) VALUES(?,?,?,?,?)");
                $insertAddOns->bind_param('issis',$id,$code,$newAddOns,$newAddOnsPrice,$productName);
                if($insertAddOns->execute()){
                    header('Location:create-add-on.php');
                }
            }
        }
    }

}
//update each add-on name and price
function editChoiceGroup(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-edit-choices'])){
            $ids = $_POST['ids'];
            $addOnsName = $_POST['addOns'];
            $addOnsPrice = $_POST['addOnsPrice'];
            foreach($ids as $idsIndex => $idsVal) {
                $newId = $idsVal;
                $newAddOnsName = $addOnsName[$idsIndex];
                $newAddOnsPrice = $addOnsPrice[$idsIndex];

                $editChoices = $connect->prepare("UPDATE tbladdons SET add_ons=?,add_ons_price=? WHERE id=?");
                $editChoices->bind_param('ssi',$newAddOnsName,$newAddOnsPrice,$newId);
                if($editChoices->execute()){
                    header('Location:create-add-on.php');
                }
            }
        }
    }
}
//remove specific add-on of menu category
function removeAddOn(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-remove-addOns'])){
            $id = mysqli_real_escape_string($connect,$_POST['id']);

            $removeChoices = $connect->prepare("DELETE FROM tbladdons WHERE id=?");
            $removeChoices->bind_param('i',$id);
            if($removeChoices->execute()){
                header('Location:create-add-on.php?deleted');
            }
        }
    }
}
//remove group of add-on in specific menu category
function removeChoiceGroup(){
    require 'public/connection.php';
    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST['btn-delete-choiceGroup'])){
            $code = mysqli_real_escape_string($connect,$_POST['code']);

            $removeGroup = $connect->prepare("DELETE FROM tbladdons WHERE add_ons_code=?");
            $removeGroup->bind_param('s',$code);
            if($removeGroup->execute()){
                header('Location:create-add-on.php?deleted');
            }
        }
    }
}
insertProducts();
updateProducts();
deleteProducts();
updateProductStocks();
createAddOns();
editChoiceGroup();
removeAddOn();
removeChoiceGroup();
?>
