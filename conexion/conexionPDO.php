<?php

define('DB_SERVER', '192.168.1.20');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'admindues');
//define('DB_DATABASE', 'dues_drapes_28JUN2021');
//define('DB_DATABASE', 'dues_drapes');
define('DB_DATABASE', 'dues_drapes_tavo');
//define('DB_DATABASE', 'dues_drapes_28JUN2021');

// Conexion PDO

function conectar()
{
	try
	{
		return new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
	} 
	catch(PDOException $e)
	{
	    return null;
	}
}

function select($query, $parametros, $tipo_retorno)
{
	if (!is_null($pdo = conectar()))
	{
		$stmt = $pdo->prepare($query);

		foreach ($parametros as $clave => $valor)
		{	
			$stmt->bindValue(":$clave", $valor);
		}

		$stmt->execute();

		$tipo_retorno == 1 ? $resultado = $stmt->fetch(PDO::FETCH_ASSOC) : $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$stmt = null;
		$pdo = null;

		return $resultado;	
	}
	else
	{
		return null;
	}
}