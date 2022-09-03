<?php

require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
$orderedDate=$idNumber=$products=$quantity=$price=$variation=$customerType=$total="";

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
        $this->SetFont('Arial', 'B',12);
        $this->Cell(50, 10, 'Ordered Date', 1, 0, 'C');
        $this->Cell(35, 10, 'ID Number', 1, 0, 'C');     
        $this->Cell(40, 10, 'Product', 1, 0, 'C');
        $this->Cell(25, 10, 'Quantity', 1, 0, 'C');
        $this->Cell(25, 10, 'Price', 1, 0, 'C');
        $this->Cell(30, 10, 'Variation', 1, 0, 'C');
        $this->Cell(35, 10, 'Customer Type', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$orderedDate,$idNumber,$products,$quantity,$price,$variation,$customerType,$total) {
        if(isset($_GET['startDate']) && isset($_GET['endDate'])){ 
            $totalAmount=0;
            $orderStatus = "Completed";
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT tblpos.ordered_date,tblpos.pwd_senior_number,tblposorders.products,
            tblposorders.quantity, tblposorders.price,tblposorders.category,tblposorders.variation, 
            tblpos.customer_type,tblposorders.price*tblposorders.quantity as 'total'
            FROM tblpos LEFT JOIN tblposorders ON tblpos.id_number = tblposorders.id_number 
            WHERE tblpos.status=? AND tblposorders.ordered_date BETWEEN (?) AND (?)
            ORDER BY tblposorders.ordered_date ASC");
            $getTotalOrder->bind_param('sss',$orderStatus,$startDate,$endDate);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($orderedDate,$idNumber,$products,$quantity,$price,$category,$variation,$customerType,$total);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalAmount+=$total;
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(50, 10, $orderedDate, 1, 0, 'C');
                    $this->Cell(35, 10, $idNumber, 1, 0, 'C');
                    $this->Cell(40, 10, $products, 1, 0, 'C');
                    $this->Cell(25, 10, $quantity, 1, 0, 'C');      
                    $this->Cell(25, 10, $price, 1, 0, 'C');
                    $this->Cell(30, 10, $variation, 1, 0, 'C');
                    $this->Cell(35, 10, $customerType, 1, 0, 'C');
                    $this->Ln();
                }
            } 
            $this->Cell(125,10,'',0,0,'C');
            $this->Cell(50, 10, "Total Sales: PHP $totalAmount.00", 1, 0, 'C');
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
$pdf->setLeftMargin(28);
$pdf->SetFont('Times', '', 8);
$pdf->headerTable();
$pdf->viewTable($connect,$orderedDate,$idNumber,$products,$quantity,$price,$variation,$customerType,$total);
$pdf->Output();