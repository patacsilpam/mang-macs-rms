<?php
require 'public/admin-inventory.php';

function addToCart(){
    require 'public/connection.php';
    if (!empty($_GET['action'])) {
        switch ($_GET['action']) {
            case "add":
                if (!empty($_POST["quantity"])) {
                    $id = $_GET['code'];
                    $getProduct = $connect->prepare("SELECT * FROM tblproducts WHERE code=?");
                    $getProduct->bind_param('s', $id);
                    $getProduct->execute();
                    $row = $getProduct->get_result();
                    while ($fetch = $row->fetch_array()) {
                        $itemArray = array($fetch["code"] => array(
                            'name' => $fetch["productName"],
                            'id' => $fetch["code"],
                            'name' => $fetch["productName"],
                            'quantity' => $_POST["quantity"],
                            'variation' => $fetch["productVariation"],
                            'price' => $fetch["price"]
                        ));
                        if (!empty($_SESSION["cart_item"])) {
                            if (in_array($fetch["code"], array_keys($_SESSION["cart_item"]))) {
                                foreach ($_SESSION["cart_item"] as $k => $v) {
                                    if ($fetch["code"] == $k) {
                                        if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                            $_SESSION["cart_item"][$k]["quantity"] = 0;
                                        }
                                        $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                        header('Location:pos.php');
                                    }
                                }
                            } else {
                                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                                header('Location:pos.php');
                            }
                        } else {
                            $_SESSION["cart_item"] = $itemArray;
                            header('Location:pos.php');
                        }
                    }
                }
    
                break;
            case "remove":
                if (!empty($_SESSION["cart_item"])) {
                    foreach ($_SESSION["cart_item"] as $k => $v) {
                        if ($_GET["code"] == $k) {
                            unset($_SESSION["cart_item"][$k]);
                        }
                        if (empty($_SESSION["cart_item"])) {
                            unset($_SESSION["cart_item"]);
                        }
                    }
                }
                break;
            case "empty":
                unset($_SESSION["cart_item"]);
                break;
        }
    }
}
addToCart();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    date_default_timezone_set('Asia/Manila');
    if (isset($_POST['btn-save-cart'])) {
        $id = $_POST['id'];
        $posId = "";
        $orderedDate = date('y-m-d h:i:s');
        $quantity = $_POST['quantity'];
        $productName = $_POST['productName'];
        $variation =  $_POST['variation'];
        $price = $_POST['price'];
        $subtotal = $_POST['subTotal'];
        $total = $_POST['totalPrice'];
        $status = "POS";
        $fname = " ";
        $lname = " ";
        $amountPay = $_POST['amountPay'];
        $returnChange = $_POST['returnChange'];
        $selectedCustomer = $_POST['selectedCustomer'];
        $noSelectedCustomer="";
        $discount = $_POST['discount'];
        $idNumber = $_POST['idNumber'];
        $noIdNumber = bin2hex(openssl_random_pseudo_bytes(11));
        $discountedPrice = $_POST['discountedPrice'];
        $category = '';
        $productCode = '';
        /*
            Reminder:
            Please add the category and product code value to insert in database
        */
        
            foreach ($id as $index => $code) {
            $ids = $code;
            $ordered_date = $orderedDate[$index];
            $s_quantity = $quantity[$index];
            $s_productName = $productName[$index];
            $s_variation = $variation[$index];
            $s_price = $price[$index];
            $s_subtotal = $subtotal[$index];
            $s_discountedPrice = $discountedPrice[$index];
            $s_total = $total[$index];
            $_amountPay = $amountPay[$index];
            $s_returnChange = $returnChange[$index];
            if($selectedCustomer == "PWD" || $selectedCustomer == "Senior Citizen"){
                $insertCart = $connect->prepare("INSERT INTO tblposorders(id,id_number,products,quantity,price,variation) 
                VALUES(?,?,?,?,?,?)");
                $insertCart->bind_param('issiis', $ids,$idNumber,$s_productName,$s_quantity,$s_price,$s_variation);
                $insertCart->execute();
                if ($insertCart) {
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                } else{
                    header('Location:pos.php?error');
                    unset($_SESSION["cart_item"]);
                }
            }
            else{
                $insertCart = $connect->prepare("INSERT INTO tblposorders(id,id_number,products,quantity,price,variation) 
                VALUES(?,?,?,?,?,?)");
                echo $connect->error;
                $insertCart->bind_param('issiis', $ids,$noIdNumber,$s_productName,$s_quantity,$s_price,$s_variation);
                $insertCart->execute();
                if ($insertCart) {
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                } else{
                    header('Location:pos.php?error');
                    unset($_SESSION["cart_item"]);
                }
            }
        }
        
           if($selectedCustomer == "PWD" || $selectedCustomer == "Senior Citizen"){
                $insertPOS = $connect->prepare("INSERT INTO tblpos(id,id_number,customer_type,ordered_date,fname,lname,total,amount_pay,amount_change) VALUES(?,?,?,?,?,?,?,?,?)");
                echo $connect->error;
                $insertPOS->bind_param('isssssiii',$posId,$idNumber,$selectedCustomer,$orderedDate,$fname,$lname,$total,$amountPay,$returnChange);
                $insertPOS->execute();
                if ($insertPOS) {
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                }
            } else{
                $insertPOS = $connect->prepare("INSERT INTO tblpos(id,id_number,customer_type,ordered_date,fname,lname,total,amount_pay,amount_change) VALUES(?,?,?,?,?,?,?,?,?)");
                $insertPOS->bind_param('isssssiii',$posId,$noIdNumber,$noSelectedCustomer,$orderedDate,$fname,$lname,$total,$amountPay,$returnChange);
                $insertPOS->execute();
                if ($insertPOS) {
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                } else{
                    header('Location:pos.php?error');
                    unset($_SESSION["cart_item"]);
                }
           }
    }
}
?>