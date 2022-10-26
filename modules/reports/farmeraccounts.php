<?php
// core configuration
include_once "../../config/core.php";

include_once "../../config/database.php";
include_once '../../objects/delivery.php';
include_once "../../objects/accounts.php";
include_once "../../objects/rate.php";
include_once "../../objects/orders.php";

require('fpdf183/fpdf.php');

// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$delivery = new Delivery($db);
$milkrate = new MilkRate($db);
$order = new Order($db);
$account = new Account($db);

$rate = $milkrate->readMilkRate();

$delivery->farmer_id = $_SESSION['user_id'];
$order->farmer_id = $_SESSION['user_id'];
$account->farmer_id = $_SESSION['user_id'];


$deliveries_summary = $delivery->readDeliveriesForReport();
$orders_summary = $order->readAllOrdersByUserReport();
$account_summary = $account->readAccountDetailsForReport();

if($account_summary->rowCount() > 0){

    extract($account_summary->fetch(PDO::FETCH_ASSOC));
}

$account_balance = $gross_pay - $total_deduction;

$account_balance_str = "KES. " . $account_balance;

//A4 width : 219mm
//default margin: 10mm each side
//writable horizontal : 219-(10*2)=189

//create pdf object
$pdf = new FPDF('P','mm','A4');

//add new page
$pdf->AddPage();


//set font to arial, bold, 14pt
$pdf->SetFont('Times','B',20);
//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(189, 5,'',0,1);

//school name
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,10,'MURUAKI FARMERS COOPERATIVE',0,1);//end of line

$pdf->SetFont('Times','B',13);

//address
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,'P.O. BOX 120, NAIROBI.',0,1,'C');//end of line


//address
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,'TEL: 065-2030489',0,1,'C');//end of line

//address
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,'www.muruakifarmers.co.ke',0,1,'C');//end of line

//vertical spacer
$pdf->Cell(189, 5,'',0,1);

$pdf->SetFont('Times','B',12);

//TITLE
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,'Account Information',0,1);//end of line



//vertical spacer
$pdf->Cell(189, 5,'',0,1);

$pdf->Cell(6, 8,'',0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(100,8,'NAME:',0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(80,8,$name,0,1);

$pdf->Cell(6, 8,'',0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(100,8,'EMAIL:',0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(80,8,$email,0,1);

$pdf->Cell(6, 8,'',0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(100,8,'ROUTE:',0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(80,8,$route,0,1);

$pdf->Cell(6, 8,'',0,0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(100,8,'ACCOUNT BALANCE:',0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(80,8,$account_balance_str,0,1);


//vertical spacer
$pdf->Cell(189, 5,'',0,1);

$pdf->SetFont('Times','B',12);

//TITLE
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,'DELIVERIES SUMMARY',0,1);//end of line



//vertical spacer
$pdf->Cell(189, 10,'',0,1);


//PERFORMANCE SUMMARY
$pdf->Cell(45,7,'Date',1,0);
$pdf->Cell(100,7,'Litres Delivered',1,1,'C');

$pdf->SetFont('Times','B',11);

$total_litres = "";

if($deliveries_summary->rowCount() > 0){

    while($row = $deliveries_summary->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $total_litres = $total_delivered;
        //PERFORMANCE
        $pdf->Cell(45,7,$date,1,0);
        $pdf->SetFont('Times','',11);
        $pdf->Cell(100,7,$litres_delivered,1,1,'C');
        $pdf->SetFont('Times','B',11);

    }
    
    
   
  
}



$pdf->SetFont('Times','B',13);



//PERFORMANCE SUBJECT
$pdf->Cell(45,8,'Total',0,0,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(100,8,$total_litres ,1,1,'C');

//vertical spacer
$pdf->Cell(189, 5,'',0,1);

$pdf->SetFont('Times','B',12);

//TITLE
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,'ORDERS SUMMARY',0,1);//end of line



//vertical spacer
$pdf->Cell(189, 10,'',0,1);

//PERFORMANCE SUMMARY
$pdf->Cell(25,7,'Order ID',1,0);
$pdf->Cell(60,7,'Modified',1,0,'C');
$pdf->Cell(60,7,'Total',1,1,'C');
$pdf->SetFont('Times','B',11);

$orders_total_value = "";

if($orders_summary->rowCount() > 0){

    while($row2 = $orders_summary->fetch(PDO::FETCH_ASSOC)){
        extract($row2);
       $orders_total_value = $total_value;
        $pdf->Cell(25,7,$id,1,0);
        $pdf->Cell(60,7,$modified,1,0,'C');
        $pdf->Cell(60,7,$total,1,1,'C');
        $pdf->SetFont('Times','B',11);

    }
    
    
   
  
}





$pdf->SetFont('Times','B',13);



//PERFORMANCE SUBJECT
$pdf->Cell(85,8,'Total',0,0,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,$orders_total_value ,1,1,'C');



$pdf->SetFont('Times','B',13);

//vertical spacer
$pdf->Cell(189, 10,'',0,1);

$gross_pay_str = "KES. " . $gross_pay;
$pdf->SetFont('Times','I',12);

$pdf->Cell(50, 5,'Gross Income',1,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(189, 20,$gross_pay_str,1,1);



//vertical spacer
$pdf->Cell(189, 10,'',0,1);


$pdf->SetFont('Times','I',12);

$pdf->Cell(50, 5,'Net Income',1,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(189, 20,$account_balance_str,1,1);



//output the result
$pdf->Output();
?>