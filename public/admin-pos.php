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
                            'category' => $fetch["productCategory"],
                            'id' => $fetch["code"],
                            'price' => $fetch["price"],
                            'productCode' => $fetch["code"],
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

function insertCart(){
    require 'public/connection.php';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        date_default_timezone_set('Asia/Manila');
        if (isset($_POST['btn-save-cart'])) {
            $id = $_POST['id'];
            $posId = "";
            $fname = "";
            $lname = "";
            $customerIDS = "";
            $email = "";
            $addOns = "";
            $addOnsFee = "";
            $specialRequest = "";
            $productImage = "";
            $preparationTime = "";
            $orderedDate = date('y-m-d');
            $orderedTime = date('h:i a');
            $completedTime = date('y-m-d h:i:s');
            $quantity = $_POST['quantity'];
            $productName = $_POST['productName'];
            $variation =  $_POST['variation'];
            $price = $_POST['price'];
            $subtotal = $_POST['subTotal'];
            $total = $_POST['totalPrice'];
            $productCode = $_POST['productCode'];
            $category = $_POST['productCategory'];
            $orderType = "POS";
            $amountPay = $_POST['amountPay'];
            $returnChange = $_POST['returnChange'];
            $selectedCustomer = $_POST['selectedCustomer'];
            $noSelectedCustomer="";
            $discount = $_POST['discount'];
            $pwdSeniorNumber = $_POST['idNumber'];
            $dateCode = date('Ymd');
            $bindHexCode =  rand(1000,9999);
            $noIdNumber = $dateCode.$bindHexCode;
            $discountedPrice = $_POST['discountedPrice'];
            $noDiscount = "";
            $notPwdSenior = "";
            $status = "Order Completed";
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
                $s_productCode = $productCode[$index];
                $s_category = $category[$index];
                /*update stock quantity and products*/
                if($s_category == "Pizza"){
                    $updateStockDb = $connect->prepare("UPDATE tblinventory SET quantityInStock = quantityInStock - (?) WHERE itemVariation=? AND itemCategory=?");
                    $updateStockDb->bind_param('iss',$s_quantity,$s_variation,$s_category);
                    $updateStockDb->execute();
                }
                else{
                    $updateStockDb = $connect->prepare("UPDATE tblinventory SET quantityInStock = quantityInStock - (?) WHERE product=? AND itemCategory=?");
                    $updateStockDb->bind_param('iss',$s_quantity,$s_productName,$s_category);
                    $updateStockDb->execute();
                }
                //insert orders in tblorderdetails
                $insertOrderDetails = $connect->prepare("INSERT INTO tblorderdetails(id,order_number,customer_id,recipient_name,product_code,order_id,email,product_name,product_category,product_variation,quantity,price,add_ons,add_ons_fee,special_request,product_image,order_type,order_status,created_at,required_date,required_time,completed_time,notif_date,preparation_time) 
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $insertOrderDetails->bind_param('isssssssssiisissssssssss',$ids,$noIdNumber,$customerIDS,$fname,$s_productCode,$ids,$email,$s_productName,$s_category,$s_variation,$s_quantity,$s_price,$addOns,$addOnsFee,$specialRequest,$productImage,$orderType,$status,$orderedDate,$orderedDate,$orderedTime,$completedTime,$completedTime,$preparationTime);
                if($insertOrderDetails->execute()){
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                }

                /*if($selectedCustomer == "PWD" || $selectedCustomer == "Senior Citizen"){
                    $insertCart = $connect->prepare("INSERT INTO tblposorders(id,id_number,product_code,products,quantity,price,variation,category,ordered_date) 
                    VALUES(?,?,?,?,?,?,?,?,?)");
                    $insertCart->bind_param('isssiisss', $ids,$noIdNumber,$s_productCode,$s_productName,$s_quantity,$s_price,$s_variation,$s_category,$orderedDate);
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
                    $insertCart = $connect->prepare("INSERT INTO tblposorders(id,id_number,product_code,products,quantity,price,variation,category,ordered_date) 
                    VALUES(?,?,?,?,?,?,?,?,?)");
                    $insertCart->bind_param('isssiisss', $ids,$noIdNumber,$s_productCode,$s_productName,$s_quantity,$s_price,$s_variation,$s_category,$orderedDate);
                    $insertCart->execute();
                    if ($insertCart) {
                        header('Location:pos.php?success');
                        unset($_SESSION["cart_item"]);
                    } else{
                        header('Location:pos.php?error');
                        unset($_SESSION["cart_item"]);
                    }
                }*/
            }
            
            if($selectedCustomer == "PWD" || $selectedCustomer == "Senior Citizen"){
                $insertPOS = $connect->prepare("INSERT INTO tblpos(id,id_number,pwd_senior_number,customer_type,ordered_date,fname,lname,total,discounted_price,amount_pay,amount_change,status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                echo $connect->error;
                $insertPOS->bind_param('issssssidiis',$posId,$noIdNumber,$pwdSeniorNumber,$selectedCustomer,$orderedDate,$fname,$lname,$discountedPrice,$discountedPrice,$amountPay,$returnChange,$status);
                $insertPOS->execute();
                if ($insertPOS) {
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                }
            } else{
                $insertPOS = $connect->prepare("INSERT INTO tblpos(id,id_number,pwd_senior_number,customer_type,ordered_date,fname,lname,total,discounted_price,amount_pay,amount_change,status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $insertPOS->bind_param('issssssidiis',$posId,$noIdNumber,$notPwdSenior,$noSelectedCustomer,$orderedDate,$fname,$lname,$total,$noDiscount,$amountPay,$returnChange,$status);
                $insertPOS->execute();
                if ($insertPOS) {
                    header('Location:pos.php?success');
                    unset($_SESSION["cart_item"]);
                } else{
                    header('Location:pos.php?error');
                    unset($_SESSION["cart_item"]);
                }
            }
             //insert report sale
             $ids = null;
             $fullname = $_SESSION['fname']." ".$_SESSION['lname'];
             $sales = 0;//$_POST['sales'];
             $userType = "Admin";
             $reportDate = date('Y-m-d h:i:s');
             //insert report sale
             $insertSale = $connect->prepare("INSERT INTO tblreport(id,order_number,fullname,sales,user_type,report_date) VALUES(?,?,?,?,?,?)");
             echo $connect->error;
             $insertSale->bind_param('ississ',$ids,$noIdNumber,$fullname,$sales,$userType,$reportDate);
             $insertSale->execute();
        }
    }
}
function updateOrderStatus(){
    require 'public/connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['btn-update'])){
            $status = mysqli_real_escape_string($connect,$_POST['orderStatus']);
            $idNumber = mysqli_real_escape_string($connect,$_POST['idNumber']);
            $updateStatus = $connect->prepare("UPDATE tblpos SET status = ? WHERE id_number = ?");
            $updateStatus->bind_param('ss',$status,$idNumber);
            $updateStatus->execute();
            if($updateStatus){
                header('Location:pos-orders.php?true');
                
            }
        }
    }
}

addToCart();
insertCart();
updateOrderStatus();
?>