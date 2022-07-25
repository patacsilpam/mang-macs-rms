<?php

require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
$id=$fullname=$userType=$reportDate=$sales="";

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
        $this->Cell(10, 10, 'No.', 1, 0, 'C');
        $this->Cell(30, 10, 'Name', 1, 0, 'C');
        $this->Cell(50, 10, 'User Type', 1, 0, 'C');
        $this->Cell(40, 10, 'Date', 1, 0, 'C');
        $this->Cell(40, 10, 'Sales', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$id,$fullname,$userType,$reportDate,$sales) {
        if($_GET['userType'] == "Admin" || $_GET['userType'] == "Staff"){ 
            $totalAmount=0;
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $userType = $_GET['userType'];
            $getTotalOrder = $connect->prepare("SELECT * FROM tblreport WHERE report_date BETWEEN (?) AND (?) HAVING user_type=?");
            $getTotalOrder->bind_param('sss',$startDate,$endDate,$userType);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($id,$fullname,$sales,$reportDate,$userType);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalAmount+=$sales;
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(10, 10, $id, 1, 0, 'C');
                    $this->Cell(30, 10, $fullname, 1, 0, 'C');
                    $this->Cell(50, 10, $userType, 1, 0, 'C');
                    $this->Cell(40, 10, $reportDate, 1, 0, 'C');
                    $this->Cell(40, 10, $sales, 1, 0, 'C');
                    $this->Ln();
                }
            }
            $this->Cell(130, 10, "", 0, 0, 'C');
            $this->Cell(40, 10, "Total Sales: PHP $totalAmount.00", 1, 0, 'C');
        
        }
        else{
            $totalAmount=0;
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT * FROM tblreport WHERE report_date BETWEEN (?) AND (?)");
            $getTotalOrder->bind_param('ss',$startDate,$endDate);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($id,$fullname,$sales,$reportDate,$userType);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalAmount+=$sales;
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(10, 10, $id, 1, 0, 'C');
                    $this->Cell(30, 10, $fullname, 1, 0, 'C');
                    $this->Cell(50, 10, $userType, 1, 0, 'C');
                    $this->Cell(40, 10, $reportDate, 1, 0, 'C');
                    $this->Cell(40, 10, $sales, 1, 0, 'C');
                    $this->Ln();
                }
            }
            $this->Cell(130, 10, "", 0, 0, 'C');
            $this->Cell(40, 10, "Total Sales: PHP $totalAmount.00", 1, 0, 'C');
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
$pdf->setLeftMargin('65');
$pdf->headerTable();
$pdf->viewTable($connect,$id,$fullname,$userType,$reportDate,$sales);
$pdf->Output();