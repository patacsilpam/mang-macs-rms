<?php

require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
$id=$createdAt=$customerId=$email=$product=$variation=$quantity=$price=$addOns=$orderType=$orderStatus=$totalAmount="";

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
        $this->Cell(10, 10, 'No.', 1, 0, 'C');
        $this->Cell(30, 10, 'Created At', 1, 0, 'C');
        $this->Cell(20, 10, 'Customer ID', 1, 0, 'C');
        $this->Cell(50, 10, 'Email', 1, 0, 'C');
        $this->Cell(40, 10, 'Product', 1, 0, 'C');
        $this->Cell(17, 10, 'Variation', 1, 0, 'C');
        $this->Cell(17, 10, 'Quantity', 1, 0, 'C');
        $this->Cell(15, 10, 'Price', 1, 0, 'C');
        $this->Cell(30, 10, 'Add Ons', 1, 0, 'C');
        $this->Cell(22, 10, 'Order Type', 1, 0, 'C');
        $this->Cell(22, 10, 'Order Status', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$id,$createdAt,$customerId,$email,$product,$variation,$quantity,$price,$addOns,$orderType,$orderStatus,$totalAmount) {
        if(isset($_GET['startDate']) && isset($_GET['endDate'])){ 
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT id,created_at,customer_id,email,product_name,product_variation,quantity,price,add_ons,order_type,order_status, (SELECT SUM(price * quantity) FROM tblorderdetails WHERE created_at BETWEEN (?) AND (?) and order_status='Completed') FROM tblorderdetails WHERE created_at BETWEEN (?) AND (?) and order_status='Completed'");
            echo $connect->error;
            $getTotalOrder->bind_param('ssss',$startDate,$endDate,$startDate,$endDate);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($id,$createdAt,$customerId,$email,$product,$variation,$quantity,$price,$addOns,$orderType,$orderStatus,$totalAmount);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(10, 10, $id, 1, 0, 'C');
                    $this->Cell(30, 10, $createdAt, 1, 0, 'C');
                    $this->Cell(20, 10, $customerId, 1, 0, 'C');
                    $this->Cell(50, 10, $email, 1, 0, 'C');
                    $this->Cell(40, 10, $product, 1, 0, 'C');
                    $this->Cell(17, 10, $variation, 1, 0, 'C');
                    $this->Cell(17, 10, $quantity, 1, 0, 'C');
                    $this->Cell(15, 10, $price, 1, 0, 'C');
                    $this->Cell(30, 10, $addOns, 1, 0, 'C');
                    $this->Cell(22, 10, $orderType, 1, 0, 'C');
                    $this->Cell(22, 10, $orderStatus, 1, 0, 'C');
                    $this->Ln();
                }
            } 
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
$pdf->headerTable();
$pdf->viewTable($connect,$id,$createdAt,$customerId,$email,$product,$variation,$quantity,$price,$addOns,$orderType,$orderStatus,$totalAmount);
$pdf->Output();