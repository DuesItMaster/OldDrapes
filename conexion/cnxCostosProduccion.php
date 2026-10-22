<?php

define('DB_SERVERC', '192.168.1.20');
define('DB_USERNAMEC', 'root');
define('DB_PASSWORDC', 'admindues');
define('DB_DATABASEC', 'CostosProduccion');


$dbC = mysqli_connect(DB_SERVERC, DB_USERNAMEC, DB_PASSWORDC, DB_DATABASEC);
if ($dbC->connect_errno) {
    die("No hay conexion: (" . $dbC->mysqli_connect_errno() . ") " . $dbC->mysqli_connect_error());
}

?>