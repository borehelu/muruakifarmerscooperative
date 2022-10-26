<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../libs/vendor/autoload.php';

$mail = new PHPMailer(true);
try {
	#$mail->SMTPDebug = 2;									
	$mail->isSMTP();											
	$mail->Host	 = 'smtp.gmail.com;';					
	$mail->SMTPAuth = true;							
	$mail->Username = '';				
	$mail->Password = '';						
	$mail->SMTPSecure = 'tls';							
	$mail->Port	 = 587;

	$mail->setFrom('helussandbox@gmail.com', 'Admin');		
	$mail->addAddress($mailTo,$nameTo);
	//$mail->addAddress('receiver2@gfg.com', 'Name');
	
	$mail->isHTML(true);								
	$mail->Subject = $subject;
	$mail->Body = $body;
	//$mail->AltBody = 'Body in plain text for non-HTML mail clients';
	
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
