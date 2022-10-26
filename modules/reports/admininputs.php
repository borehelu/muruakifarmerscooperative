<?php
// core configuration
include_once "../../config/core.php";

include_once "../../config/database.php";
include_once "../../objects/orderedinputs.php";

require('fpdf183/fpdf.php');

// get database connection
$database = new Database();
$db = $database->getConnection();


$ordered_input = new OrderedInput($db);



$ordered_summary = $ordered_input->readMostDemandedInput();


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
$pdf->Cell(99 ,7,'Input Information',0,1);//end of line


//vertical spacer
$pdf->Cell(189, 5,'',0,1);

$pdf->SetFont('Times','B',12);

$title_str = "PERFORMANCE OF FARM INPUTS ";

//TITLE
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(99 ,7,$title_str,0,1);//end of line



//vertical spacer
$pdf->Cell(189, 10,'',0,1);


//PERFORMANCE SUMMARY
$pdf->Cell(25,7,'Name',1,0);
$pdf->Cell(60,7,'Total Ordered',1,0);
$pdf->Cell(60,7,'Total Revenue',1,0);
$pdf->Cell(40,7,'Price',1,1,'C');

$pdf->SetFont('Times','',11);

$total_sum = "";

if($ordered_summary->rowCount() > 0){

    while($row = $ordered_summary->fetch(PDO::FETCH_ASSOC)){
        extract($row);

       //PERFORMANCE SUMMARY
        $pdf->Cell(25,7,$name,1,0);
        $pdf->Cell(60,7,$total_ordered,1,0);
        $pdf->Cell(60,7,$total_generated,1,0);
        $pdf->Cell(40,7,$price,1,1,'C');
        

    }
    
    
   
  
}



$pdf->SetFont('Times','B',13);




//vertical spacer
$pdf->Cell(189, 5,'',0,1);

$pdf->SetFont('Times','B',12);



//output the result
$pdf->Output();
?>