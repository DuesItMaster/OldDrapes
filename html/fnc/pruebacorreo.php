<?php
include_once '../cotizar/EnviarCorreoGmail.php';

$correo='krystal.acosta@dues.com.mx';
$nombre='keap';
echo '<br><br><br><br><br><br><br><br>' . EnviarCorreo($correo,$nombre);


?>