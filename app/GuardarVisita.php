<?php
//ARCHIVO PARA GUARDAR UNA NUEVA VISITA EN LA BASE DE DATOS
session_start();//inicio de sesion
	include_once "../conexion.php";
    include "config.php"; //ZONA HORARIA GUATEMALA
    
    if(!isset($_POST["IPUser"]) || !isset($_POST["URLactual"])){
        exit();
    }

	//Recibiendo datos
	$IPUser = $_POST["IPUser"];
    $Fecha = date("Y-m-d h:i:s");
    $URLactual = $_POST["URLactual"];
    $IDUsuario = NULL;
    if(isset($_SESSION["Cliente"])){
       $IDUsuario = $_SESSION["Cliente"]['IDUsuario'];
    }

    $sentencia = $base_de_datos->prepare("CALL NuevaVisita(?,?,?,?);");
    $resultado = $sentencia->execute([$IPUser, $Fecha, $URLactual, $IDUsuario]);
        
    if($resultado == true){
		echo "1"; //Se guardo correctamente
	}else{
		echo "0"; //Ocurrio un error
	}
?>