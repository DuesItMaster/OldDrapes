<?php
$db_cotizador="COTIZADOR_PROD";
//$db_cotizador="DUES_TEXTIL_20NOV25";
if (function_exists('mssql_connect')) {
    $msconnect=mssql_connect("192.168.1.224", "sa", "B1Admin");
    $msdb=mssql_select_db($GLOBALS['db_cotizador'],$msconnect);
} else {
    // PHP 7+ ya no trae mssql_*, se usa la extension sqlsrv
    $msconnect=sqlsrv_connect("192.168.1.224", array("Database" => $db_cotizador, "UID" => "sa", "PWD" => "B1Admin", "CharacterSet" => "UTF-8", "TrustServerCertificate" => true));
}

function get_usuarios (){

    $msQuery = "SELECT RecordId, Usuario , Siglas
    FROM Usuarios
    WHERE  Activo=1 and Siglas is not null AND Siglas !='' ORDER BY ModificarUsuarios,Siglas";
    if (function_exists('mssql_query')) {
        $msresults= mssql_query($msQuery);
        while ($row = mssql_fetch_assoc($msresults)) {
            echo '<option value="">'.$row['Siglas'].'</option>';
        }
    } else {
        $msresults= sqlsrv_query($GLOBALS['msconnect'], $msQuery);
        while ($msresults && $row = sqlsrv_fetch_array($msresults, SQLSRV_FETCH_ASSOC)) {
            echo '<option value="">'.$row['Siglas'].'</option>';
        }
    }
}

?>