<?php

require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
session_start();
$fullname=$userType=$sales=$reportDate=$productName=$productCategory=$productVariation=$quantity=$price=$addOns=$addOnsFee=$orderType="";

class PDF extends FPDF
{
    
    function Header()
    {
        $startDate = $_GET['startDate'];
        $endDate = $_GET['endDate'];
        $userType = $_GET['userType'];
        $formatStartDate = date('F d, Y',strtotime($startDate));
        $formatEndDate = date('F d, Y',strtotime($endDate));
        $this->Image('assets/images/logo.png', 230, 6, 45); //display the logo
        $this->SetFont('Arial', 'B', 12);  // Select Arial bold 15
        $this->Cell(0, 10, "Mang Mac's Marineros Pizza House", 0, 0, 'C'); //title
        $this->Ln(); //line break
        $this->SetFont('Arial', '', 12);  //select arial 15, regular
        $this->Cell(0, 10, "Sales in $userType - From $formatStartDate - $formatEndDate", 0, 0, 'C'); //title
        $this->SetX($this->lMargin); //align text to center
        $this->Ln(20);
    }
    function headerTable()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 10, 'Name', 1, 0, 'C');
        $this->Cell(15, 10, 'User Type', 1, 0, 'C');
        $this->Cell(30, 10, 'Date', 1, 0, 'C');
        $this->Cell(40, 10, 'Product', 1, 0, 'C');
        $this->Cell(35, 10, 'Category', 1, 0, 'C');
        $this->Cell(20, 10, 'Variation', 1, 0, 'C');
        $this->Cell(20, 10, 'Quantity', 1, 0, 'C');
        $this->Cell(20, 10, 'Price', 1, 0, 'C');
        $this->Cell(20, 10, 'Add Ons', 1, 0, 'C');
        $this->Cell(20, 10, 'Add Ons Fee', 1, 0, 'C');
        $this->Cell(20, 10, 'Order Type', 1, 0, 'C');
        $this->Cell(20, 10, 'Subtotal', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$fullname,$userType,$sales,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$addOns,$addOnsFee,$orderType) {
        if($_GET['userType'] == "Admin" || $_GET['userType'] == "Staff"){ 
            $totalAmount = 0;
            $orderCompleted = "Order Completed";
            $orderReceived = "Order Received";
            $userType = $_GET['userType'];       
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT tblreport.fullname,tblreport.sales,tblreport.user_type,tblreport.report_date,
            tblorderdetails.product_name,tblorderdetails.product_category,tblorderdetails.product_variation, tblorderdetails.quantity,
            tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
            tblorderdetails.add_ons,tblorderdetails.add_ons_fee, tblorderdetails.order_type
            FROM `tblreport` LEFT JOIN tblorderdetails ON tblreport.order_number = tblorderdetails.order_number 
            WHERE tblorderdetails.order_status IN (?,?)  AND tblreport.report_date BETWEEN (?) AND (?) HAVING tblreport.user_type=?");
            $getTotalOrder->bind_param('sssss',$orderCompleted,$orderReceived,$startDate,$endDate,$userType);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($fullname,$sales,$userType,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$subTotal,$addOns,$addOnsFee,$orderType);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalAmount+=$subTotal;
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(25, 10, $fullname, 1, 0, 'C');
                    $this->Cell(15, 10, $userType, 1, 0, 'C');
                    $this->Cell(30, 10, $reportDate, 1, 0, 'C');
                    $this->Cell(40, 10, $productName, 1, 0, 'C');
                    $this->Cell(35, 10, $productCategory, 1, 0, 'C');
                    $this->Cell(20, 10, $productVariation, 1, 0, 'C');
                    $this->Cell(20, 10, $quantity, 1, 0, 'C');
                    $this->Cell(20, 10, $price, 1, 0, 'C');
                    $this->Cell(20, 10, $addOns, 1, 0, 'C');
                    $this->Cell(20, 10, $addOnsFee, 1, 0, 'C');
                    $this->Cell(20, 10, $orderType, 1, 0, 'C');
                    $this->Cell(20, 10, $subTotal, 1, 0, 'C');
                    $this->Ln();
                    //$this->Cell(40, 10, $eSignature, 1, 0, 'C');
                   // $this->Cell(40,40,$this->Image($eSignature,$this->GetX(),$this->GetY(),33.78),0,0,'L',false);
                  
                }
            }
        }
        else{
            $totalAmount=0;
            $orderCompleted = "Order Completed";
            $orderReceived = "Order Received";
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT tblreport.fullname,tblreport.sales,tblreport.user_type,tblreport.report_date,
            tblorderdetails.product_name,tblorderdetails.product_category,tblorderdetails.product_variation, tblorderdetails.quantity,
            tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
            tblorderdetails.add_ons,tblorderdetails.add_ons_fee, tblorderdetails.order_type
            FROM `tblreport` LEFT JOIN tblorderdetails ON tblreport.order_number = tblorderdetails.order_number 
            WHERE tblorderdetails.order_status IN (?,?)");
            $getTotalOrder->bind_param('ss',$orderCompleted,$orderReceived);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($fullname,$sales,$userType,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$subTotal,$addOns,$addOnsFee,$orderType);
            $sig = "";
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalAmount+=$subTotal;
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(25, 10, $fullname, 1, 0, 'C');
                    $this->Cell(15, 10, $userType, 1, 0, 'C');
                    $this->Cell(30, 10, $reportDate, 1, 0, 'C');
                    $this->Cell(40, 10, $productName, 1, 0, 'C');
                    $this->Cell(35, 10, $productCategory, 1, 0, 'C');
                    $this->Cell(20, 10, $productVariation, 1, 0, 'C');
                    $this->Cell(20, 10, $quantity, 1, 0, 'C');
                    $this->Cell(20, 10, $price, 1, 0, 'C');
                    $this->Cell(20, 10, $addOns, 1, 0, 'C');
                    $this->Cell(20, 10, $addOnsFee, 1, 0, 'C');
                    $this->Cell(20, 10, $orderType, 1, 0, 'C');
                    $this->Cell(20, 10, $subTotal, 1, 0, 'C');
                    $this->Ln();
                    //$this->Cell(40, 10, (empty($eSignature) || $eSignature == 'no signature') ? '' : $this->Image(''.$eSignature,$this->GetX(),$this->GetY(),0,10),1,0,'L',false); //show signature if it is not empty
                }
            }
        }
        $this->Cell(245, 10, "", 0, 0, 'C');
        $this->Cell(40, 10, "Total Sales: PHP ".number_format($totalAmount).".00", 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->Cell(0,10,"Prepared by:",0,0,'L');
        $this->Ln();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0,10,$_SESSION['fname']."".$_SESSION['lname'],0,0,'L');
    }
    function Footer()
    {
        /* Position at 1.5 cm from bottom */
        $this->SetY(-15);
        /* Arial italic 8 */
        $this->SetFont('Arial', 'I', 8);
        /* Page number */
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        //line break
    }
}
$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 8);
$pdf->headerTable();
$pdf->viewTable($connect,$fullname,$userType,$sales,$reportDate,$productName,$productCategory,$productVariation,$quantity,$price,$addOns,$addOnsFee,$orderType);
$pdf->Output();