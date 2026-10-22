<?php
/**
 * This uses the SMTP class alone to check that a connection can be made to an SMTP server,
 * authenticate, then disconnect
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

//require '../PHPMailerAutoload.php';
require '../clases/PHPMailer/PHPMailerAutoload.php';

//Create a new SMTP instance
$smtp = new SMTP;

//Enable connection-level debug output
$smtp->do_debug = SMTP::DEBUG_CONNECTION;

try {
//Connect to an SMTP server
    if ($smtp->connect('dues.com.mx', 587)) {
        //Say hello
        if ($smtp->hello('localhost')) { //Put your host name in here
            //Authenticate
            if ($smtp->authenticate('krystal.acosta@dues.com.mx', 'krystal123.')) {
                echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>Connected ok!";
            } else {
             //   throw new Exception('Authentication failed: ' . $smtp->getLastReply());
                echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>nel autenticas";
            }
        } else {
           // throw new Exception('HELO failed: '. $smtp->getLastReply());
            echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>nel localhost";
        }
    } else {
        //throw new Exception('Connect failed');
        echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>nel conectar";
    }
} catch (Exception $e) {
    echo '<br><br><br><br><br><br><br><br><br><br><br><br><br>SMTP error: '. $e->getMessage(), "\n";
}
//Whatever happened, close the connection.
$smtp->quit(true);
