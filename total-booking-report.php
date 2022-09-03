<?php
require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
$refNumber=$fname=$lname=$guests=$schedDate=$schedTime="";
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
        $this->Cell(0, 10, "Lists of Reservation $formatStartDate - $formatEndDate", 0, 0, 'C'); //title
        $this->SetX($this->lMargin); //align text to center
        $this->Ln(20);
    }
    function headerTable()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 10, 'No.', 1, 0, 'C');
        $this->Cell(45, 10, 'Customer Name', 1, 0, 'C');
        $this->Cell(25, 10, 'Guests', 1, 0, 'C');
        $this->Cell(50, 10, 'Schedule', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$refNumber,$fname,$lname,$guests,$schedDate,$schedTime)
    {
        if(isset($_GET['startDate']) && isset($_GET['endDate'])){
            $totalGuests=0;
            $orderCompleted = "Reserved";
            $orderReceived = "Order Received";          
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT refNumber,fname,lname,guests,scheduled_date,scheduled_time 
            FROM tblreservation WHERE status IN (?,?)  AND scheduled_date BETWEEN (?) AND (?)
            ORDER BY STR_TO_DATE(CONCAT(scheduled_date,' ',scheduled_time),'%Y-%m-%d %h:%i %p') ASC");
            echo $connect->error;
            $getTotalOrder->bind_param('ssss',$orderCompleted,$orderReceived,$startDate,$endDate);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($refNumber,$fname,$lname,$guests,$schedDate,$schedTime);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $totalGuests+=$guests;
                    $this->Cell(30, 10, $refNumber, 1, 0, 'C');
                    $this->Cell(45, 10, $fname." ".$lname, 1, 0, 'C');
                    $this->Cell(25, 10, $guests, 1, 0, 'C');
                    $this->Cell(50, 10, $schedDate." ".$schedTime, 1, 0, 'C');
                    $this->Ln();
                }
            }
            $this->Cell(75,10,'',0,0,'C');
            $this->Cell(25,10,"Total Guests: $totalGuests", 1, 0, 'C');
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
$pdf->SetFont('Times', '', 12);
$pdf->SetLeftMargin(70);
$pdf->headerTable();
$pdf->viewTable($connect,$refNumber,$fname,$lname,$guests,$schedDate,$schedTime);
$pdf->Output();