<?php
//AGREGANDO NUEVA CUENTA BANCARIA
session_start();//inicio de sesion
	include '../conexion.php';
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

    $Banco = $_POST["banco"];
    $IDCLiente = $_SESSION["Cliente"]["IDCliente"];
    $cuenta = $_POST["cuenta"];
    $nombrecuenta = $_POST["nombrecuenta"];
	$Modo = $_POST["Modo"];
    
    $sentencia = $base_de_datos->prepare("CALL NewCuentaBancaria(?,?,?,?);");
    $resultado = $sentencia->execute([$Banco, $IDCLiente, $cuenta, $nombrecuenta]);
		
	if($resultado == true){
		//SE AGREGO CORRECTAMENTE LA CUENTA BANCARIA
		if($Modo == "Comprador"){
			header('Location: ../Cuenta/CuentaVirtual.php'); //Lo redirigimos a la cuenta virtual
		}else if($Modo == "Vendedor"){
			header('Location: ../Ventas'); //Lo redirigimos a sus ventas
		}
	}else{
		echo "ocurrio un error";
	}
?>