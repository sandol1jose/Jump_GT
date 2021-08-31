<?php
//VERIFICAR EMAIL
session_start();
	include '../conexion.php';

	$codigo = $_POST["codigo"];
    $Correo = $_POST["email"];
	$Correo = strtolower($Correo);//Convirtiendo todo el correo a minusculas
    
	//VERIFICAMOS QUE EL CODIGO EXISTA
	$sql = "SELECT v.fecha FROM verificacion v 
	JOIN usuario u ON v.f_usuario = u.id WHERE v.clave = '".$codigo."' AND u.email = '".$Correo."';";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$contCodigo = count($registros);
	if($contCodigo == 1){ //El CODIGO EXISTE

		$sentencia = $base_de_datos->prepare("CALL VerificarEmail(?,?);");
		$resultado = $sentencia->execute([$codigo, $Correo]);
			
		if($resultado == true){
			//SE AGREGO CORRECTAMENTE
			header('Location: ../Registro/VerificacionExito.php'); 
		}else{
			echo "ocurrio un error";
		}
	}else{
		//El codigo no existe en la base de datos
		$_SESSION["Alerta"] = "CodigoIncorrecto";
		header('Location: ../Registro/Verificacion.php?email='.$Correo);
	}
?>