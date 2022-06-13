<?php
require 'public/connection.php';
include 'fpdf/fpdf.php';
date_default_timezone_set('Asia/Manila');
$id=$createdAt=$customerId=$email=$fname=$lname=$guests=$schedDate=$schedTime=$bookStatus="";
class PDF extends FPDF
{
    function Header()
    {
        $date = date('Y');
        $this->Image('assets/images/logo.png', 230, 6, 45); //display the logo
        $this->SetFont('Arial', 'B', 12);  // Select Arial bold 15
        $this->Cell(0, 10, "Mang Mac's Marineros Pizza House", 0, 0, 'C'); //title
        $this->Ln(); //line break
        $this->SetFont('Arial', '', 12);  //select arial 15, regular
        $this->Cell(0, 10, 'Lists of Reservation (' . $date.')', 0, 0, 'C'); //title
        $this->SetX($this->lMargin); //align text to center
        $this->Ln(20);
    }
    function headerTable()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 10, 'No.', 1, 0, 'C');
        $this->Cell(45, 10, 'Created_At', 1, 0, 'C');
        $this->Cell(20, 10, 'Customer ID', 1, 0, 'C');
        $this->Cell(45, 10, 'Customer Name', 1, 0, 'C');
        $this->Cell(50, 10, 'Email', 1, 0, 'C');
        $this->Cell(25, 10, 'Guests', 1, 0, 'C');
        $this->Cell(50, 10, 'Schedule', 1, 0, 'C');
        $this->Cell(40, 10, 'Status', 1, 0, 'C');
        $this->Ln();
    }
    function viewTable($connect,$id,$createdAt,$customerId,$email,$fname,$lname,$guests,$schedDate,$schedTime,$bookStatus)
    {
        if(isset($_GET['startDate']) && isset($_GET['endDate'])){           
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            $getTotalOrder = $connect->prepare("SELECT id,created_at,customer_id,email,fname,lname,guests,scheduled_date,scheduled_time,status FROM tblreservation WHERE created_at BETWEEN (?) AND (?) AND status='Reserved'");
            echo $connect->error;
            $getTotalOrder->bind_param('ss',$startDate,$endDate);
            $getTotalOrder->execute();
            $getTotalOrder->bind_result($id,$createdAt,$customerId,$email,$fname,$lname,$guests,$schedDate,$schedTime,$bookStatus);
            if($getTotalOrder){
                while($getTotalOrder->fetch()){
                    $this->Cell(10, 10, $id, 1, 0, 'C');
                    $this->Cell(45, 10, $createdAt, 1, 0, 'C');
                    $this->Cell(20, 10, $customerId, 1, 0, 'C');
                    $this->Cell(45, 10, $fname.$lname, 1, 0, 'C');
                    $this->Cell(50, 10, $email, 1, 0, 'C');
                    $this->Cell(25, 10, $guests, 1, 0, 'C');
                    $this->Cell(50, 10, $schedDate.$schedTime, 1, 0, 'C');
                    $this->Cell(40, 10, $bookStatus, 1, 0, 'C');
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
$pdf->SetFont('Times', '', 12);
$pdf->headerTable();
$pdf->viewTable($connect,$id,$createdAt,$customerId,$email,$fname,$lname,$guests,$schedDate,$schedTime,$bookStatus);
$pdf->Output();