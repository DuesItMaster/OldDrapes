<?php

/**
 * This example shows sending a message using a local sendmail binary.
 */
/*
require '../clases/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom('krystal.acosta@dues.com.mx', 'First Last');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('mario.rochin@dues.com.mx', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("hola ");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "<br><br><br><br><br><br><br>Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<br><br><br><br><br><br><br><br>Message sent!";
}*/




/*error_reporting(E_STRICT | E_ALL);

//date_default_timezone_set('Etc/UTC');

require '../clases/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$body = "hola";

$mail->isSMTP();
$mail->Host = 'dues.com.mx';
$mail->SMTPSecure = false;
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Port = 587;
$mail->Username = 'krystal.acosta@dues.com.mx';
$mail->Password = 'krystal123.';
$mail->setFrom('krystal.acosta@dues.com.mx', 'Krystal');
//$mail->addReplyTo('list@example.com', 'List manager');

$mail->Subject = "PHPMailer Simple database mailing list test";

//Same body for all messages, so set this before the sending loop
//If you generate a different body for each recipient (e.g. you're using a templating system),
//set it inside the loop
$mail->msgHTML($body);
//msgHTML also sets AltBody, but if you want a custom one, set it afterwards
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database

//$mail->addAddress($row['email'], $row['full_name']);
$mail->addAddress('mario.rochin@dues.com.mx', 'John Doe');

if (!$mail->send()) {
    echo "<br><br><br><br><br><br><br>Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<br><br><br><br><br><br><br><br>Message sent!";
}*/



date_default_timezone_set('Etc/UTC');

require '../clases/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
//$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 3;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Set the hostname of the mail server
$mail->Host = "dues.com.mx";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Username to use for SMTP authentication
$mail->Username = "krystal.acosta@dues.com.mx";
//Password to use for SMTP authentication
$mail->Password = "krystal123.";
//Set who the message is to be sent from
$mail->SetFrom('krystal.acosta@dues.com.mx', 'First Last');
//Set an alternative reply-to address
$mail->AddReplyTo('krystal.acosta@dues.com.mx', 'First Last');
//Set who the message is to be sent to
$mail->AddAddress('krystal.acosta@dues.com.mx', ' 2 22John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->msgHTML("si");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "<br><br><br><br><br>Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<br><br><br><br><br>Message sent!";
}


/*
date_default_timezone_set('Etc/UTC');

require '../clases/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "dues.com.mx";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Set who the message is to be sent from
$mail->setFrom('fkrystal.acosta@dues.com.mx', 'First Last');
//Set an alternative reply-to address
$mail->addReplyTo('mario.rochin@dues.com.mx', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('mario.rochin@dues.com.mx', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP without auth test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("hi");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "<br><br><br><br><br><br><br><br>Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<br><br><br><br><br><br><br><br>Message sent!";
}*/


?>