<?php

define('DB_SERVERE', '192.168.1.20');
define('DB_USERNAMEE', 'root');
define('DB_PASSWORDE', 'admindues');
define('DB_DATABASEE', 'EMBARQUES_PROD'); //embarques_drapes_prueba


$dbE = mysqli_connect(DB_SERVERE, DB_USERNAMEE, DB_PASSWORDE, DB_DATABASEE);
if ($dbE->connect_errno) {
    die("No hay conexion: (" . $dbE->mysqli_connect_errno() . ") " . $dbE->mysqli_connect_error());
}

?>