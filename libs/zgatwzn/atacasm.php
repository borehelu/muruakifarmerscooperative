<?php
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

// Set your app credentials
$xdjeefpdra   = "yzjpnca";
$fpdrejeaxd = "d845cd62009f25bd945900756b64979e6ffc61601235cb22d4bbbda0f170ddde";
function sendMsg($snu,$kay,$rsp,$msg){
// Initialize the SDK
$fpdratejeaxd   = new AfricasTalking($snu, $kay);

// Get the SMS service
$xdjemsefpdra   = $fpdratejeaxd  ->sms();

// Set the numbers you want to send to in international format

$vrcvtacasmot = $rsp;

// Set your message
$vrcvtacasmeg    = $msg;

// Set your shortCode or senderId
//$vrcvtacasmfo      = "*******";
	
	try {
    // Thats it, hit send and we'll take care of the rest
    $cldlbrtlrvm= $xdjemsefpdra ->send([
        'to'      => $vrcvtacasmot,
        'message' => $vrcvtacasmeg,
        //'from'    => $vrcvtacasmfo  
    ]);
   return true;
    //print_r($cldlbrtlrvm);
} catch (Exception $e) {
	return false;
    //echo "Error: ".$e->getMessage();
}
}
?>