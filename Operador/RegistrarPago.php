<?php 
session_start();//inicio de sesion
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
	}
?>
<?php
	include '../conexion.php';
	include "../app/config.php"; //ZONA HORARIA GUATEMALA
	
	$Boleta = $_POST["Boleta"];
	$Monto = $_POST["Monto"];
	$Fecha = date("Y-m-d h:i:s");
	$Banco = $_POST["banco"];
	$IDCompra = $_POST["Transaccion"];
	$tipopago = $_POST["tipopago"];

	$sentencia = $base_de_datos->prepare("CALL GrabarPagoOperador(?,?,?,?,?,?);");
	$resultado = $sentencia->execute([$Monto, $Boleta, $Fecha, $Banco, $IDCompra, $tipopago]);
		
	if($resultado == true){
		$sql = "UPDATE transaccion SET f_estado = '10' WHERE id = '".$IDCompra."'";
		$sentencia2 = $base_de_datos->prepare($sql);
		$sentencia2->execute();
		if($sentencia2){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			//echo "Pago agregado correctamente";
			header('Location: TomarTransaccion.php?Codigo=' .$IDCompra. '');
		}else{
			//No se puedo realizar el cambio
			echo "0";
		}
	}else{
		echo "ocurrio un error";
	}
?>