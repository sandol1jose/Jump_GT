<?php
$contraseña = "$6y9KUtAs2sVWF";
$usuario = "u126918558_root";
$nombre_base_de_datos = "u126918558_jump";
try{
	$base_de_datos = new PDO('mysql:host=localhost;dbname=' . $nombre_base_de_datos, $usuario, $contraseña);
	$base_de_datos->exec("set names utf8");
}catch(Exception $e){
	echo "Ocurrió algo con la base de datos: " . $e->getMessage();
}
?>
