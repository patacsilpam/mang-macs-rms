<?php

require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
$id=$createdAt=$customerName=$product=$variation=$quantity=$price=$subtotal=$addOns=$orderType="";

class PDF extends FPDF
{
    
    function Header()
    {
        $startDate = $_GET['startDate'];
        $endDate = $_GET['endDate'];
        $formatStartDate = date('F d, Y',strtotime($startDate));
        $formatEndDate = date('F d, Y',strtotime($endDate));
        $this->Image('assets/images/logo.png', 230, 6, 45); //display the logo
        $this->SetFont('Arial', 'B', 12);  // Select Arial bold 15
        $this->Cell(0, 10, "Mang Mac's Marineros Pizza House", 0, 0, 'C'); //title
        $this->Ln(); //line break
        $this->SetFont('Arial', '', 12);  //select arial 15, regular
        $this->Cell(0, 10, "Sales From $formatStartDate - $formatEndDate", 0, 0, 'C'); //title
        $this->SetX($this->lMargin); //align text to center
        $this->Ln(20);
    }
    function headerTable()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(30, 10, 'No.', 1, 0, 'C');
        $this->Cell(30, 10, 'Ordered Date', 1, 0, 'C');
        $this->Cell(50, 10, 'Customer Name', 1, 0, 'C');
        $this->Cell(40, 10, 'Food', 1, 0, 'C');
        $this->Cell(22, 10, 'Order Type', 1, 0, 'C');
        $this->Cell(17, 10, 'Variation', 1, 0, 'C');
        $this->Cell(17, 10, 'Quantity', 1, 0, 'C');
        $this->Cell(20, 10, 'Unit Price', 1, 0, 'C');
        $this->Cell(25, 10, 'Total Amount', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$id,$createdAt,$customerName,$product,$variation,$quantity,$price,$subtotal,$addOns,$orderType) {
        if(isset($_GET['startDate']) && isset($_GET['endDate'])){ 
            $totalAmount=0;
            $orderCompleted = "Order Completed";
            $orderReceived = "Order Received";
            $reserved = "Reserved";
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT tblorderdetails.order_number,tblorderdetails.required_date,
            tblcustomerorder.customer_name,tblreservation.fname,tblreservation.lname,tblorderdetails.product_name,tblorderdetails.product_variation,
            tblorderdetails.quantity,tblorderdetails.price,tblorderdetails.price * tblorderdetails.quantity as 'subtotal',
            tblorderdetails.add_ons,tblorderdetails.order_type 
            FROM tblorderdetails LEFT JOIN tblcustomerorder ON tblorderdetails.order_number = tblcustomerorder.order_number
            LEFT JOIN tblreservation ON tblorderdetails.order_number = tblreservation.refNumber
            WHERE tblorderdetails.order_status IN (?,?,?)  AND tblorderdetails.required_date BETWEEN (?) AND (?)
            ORDER BY tblorderdetails.required_date ASC");
            echo $connect->error;
            $getTotalOrder->bind_param('sssss',$orderCompleted,$orderReceived,$reserved,$startDate,$endDate);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($orderNumber,$requiredDate,$customerName,$fname,$lname,$product,$variation,$quantity,$price,$subtotal,$addOns,$orderType);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalAmount+=$subtotal;
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(30, 10, $orderNumber, 1, 0, 'C');
                    $this->Cell(30, 10, $requiredDate, 1, 0, 'C');
                    $this->Cell(50, 10, $customerName."".$fname." ".$lname, 1, 0, 'C');
                    $this->Cell(40, 10, $product, 1, 0, 'C');
                    $this->Cell(22, 10, $orderType, 1, 0, 'C');
                    $this->Cell(17, 10, $variation, 1, 0, 'C');
                    $this->Cell(17, 10, $quantity, 1, 0, 'C');
                    $this->Cell(20, 10, $price.".00", 1, 0, 'C');
                    $this->Cell(25, 10, $price * $quantity.".00", 1, 0, 'C');
                    $this->Ln();
                }
            }
            $this->Cell(206, 10, "", 0, 0, 'C');
            $this->Cell(45, 10, "Total Sales: PHP $totalAmount.00", 1, 0, 'C');
        
        } 
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
$pdf->setLeftMargin('28');
$pdf->headerTable();
$pdf->viewTable($connect,$id,$createdAt,$customerName,$product,$variation,$quantity,$price,$subtotal,$addOns,$orderType);
$pdf->Output();