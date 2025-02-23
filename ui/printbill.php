<?php 


//cal the FPDF library

require('./fpdf/fpdf.php');
include_once'connectdb.php';

$id=$_GET["id"];

$select = $pdo->prepare("select * from tbl_invoice where invoice_id =$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);


//add width :219mm
//default margin:10,, eac side
//wrtable horizontal : 219-(10*2)=199mm


//create pdf object
$pdf= new FPDF('p','mm', array(80,200));



//string orinetation (p or l) - portrait or landscape
//string unit (pt,mm,cm, and in) - measure units
// Mixed format (A4, A5,A3, letter and legal ) - format of pages




//add new pages
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', '16');
$pdf->Cell(60,8,'CYBARG INC', 1,1,'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60,5,'PHONE NUMBER : 09123433236',0,1,'C');
$pdf->Cell(60,5,'WEBSITE : www.nathchalantstore.com',0,1,'C');


//line(x1,y1,x2,y2);
$pdf->Line(7,28,722,28);
$pdf->Ln(1);


$pdf->SetFont('Arial', 'BI',8);
$pdf->Cell(20,4,'Bill To:',0,0,'');

$pdf->SetFont('Courier', 'BI', 8);

$pdf->SetFont('Arial', 'BI',8);
$pdf->Cell(20,4,'Invoice NO:',0,0,'');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40,4,$row->invoice_id,0,1,'');


$pdf->SetFont('Arial', 'BI',8);
$pdf->Cell(20,4,'Date:',0,0,'');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40,4,$row->order_date,0,1,'');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(34,5,'PRODUCT',1,0,'C');
$pdf->Cell(7,5,'QTY',1,0,'C');
$pdf->Cell(12,5,'PRC',1,0,'C');
$pdf->Cell(12.2,5,'TOTAL',1,1,'C');


$select = $pdo->prepare("select * from tbl_invoice_details where invoice_id =$id");
$select->execute();


while($product=$select->fetch(PDO::FETCH_OBJ)){

$pdf->SetX(7);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(34,5,$product->product_name, 1,0,'L');
$pdf->Cell(7,5,$product->qty,1,0,'C');
$pdf->Cell(12,5,$product->rate,1,0,'C');
$pdf->Cell(12,5,$product->rate*$product->qty,1,1,'C');



}


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'SUBTOTAL($)', 1,0, 'C');
$pdf->Cell(20,5, $row->subtotal, 1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'DICOUNT %', 1,0, 'C');
$pdf->Cell(20,5, $row->discount, 1,1,'C');

$discount_dollar=$row->discount/100;
$discount_dollar=$discount_dollar*$row->subtotal;




$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'DISCOUNT($)', 1,0, 'C');
$pdf->Cell(20,5, $discount_dollar, 1,1,'C');




$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'SGST %', 1,0, 'C');
$pdf->Cell(20,5, $row->sgst, 1,1,'C');



$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'CGST %', 1,0, 'C');
$pdf->Cell(20,5, $row->cgst, 1,1,'C');



$sgst_dollar=$row->sgst/100;
$sgst_dollar=$sgst_dollar*$row->subtotal;

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'SGST ($)', 1,0, 'C');
$pdf->Cell(20,5, $sgst_dollar, 1,1,'C');


$cgst_dollar=$row->cgst/100;  //2.5/100
$cgst_dollar=$cgst_dollar*$row->subtotal;

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'CGST ($)', 1,0, 'C');
$pdf->Cell(20,5, $cgst_dollar, 1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'G-TOTAL ($)', 1,0, 'C');
$pdf->Cell(20,5, $row->total, 1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'PAID ($)', 1,0, 'C');
$pdf->Cell(20,5, $row->paid, 1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'DUE ($)', 1,0, 'C');
$pdf->Cell(20,5, $row->due, 1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B',8);
$pdf->Cell(20,5,'', 0,0, 'L'); //190
$pdf->Cell(25,5,'PAYMENT_TYPE', 1,0, 'C');
$pdf->Cell(20,5, $row->payment_type, 1,1,'C');


$pdf->Cell(20,5, '', 0,1,'');


$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(35,5, 'Important Notice', 0,1,'C');

$pdf->SetX(7);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,5, 'No product will be replaced or refunded if you dont have receipt with you', 0, 1,'C');


$pdf->SetX(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68,5, 'You can refund within 7 days of purchase', 0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(60, 5, 'Thank you and please come again!!', 0, 1, 'C');
$pdf->Output();






?>