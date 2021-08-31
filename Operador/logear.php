<?php
	include_once "../conexion.php";
	include_once "../Sesiones/sesOperador.php";

	//Recaptcha es valido
	$usuario = $_POST["usuario"];
	$password = $_POST["password"];

	//verificando si el usuario no existe en la base de datos
	//Verificamos que sea de tipo 3 = Usuario
	$sql = "SELECT u.password password, o.id IDOperador FROM usuario u 
	JOIN operador o ON o.f_usuario = u.id 
	WHERE u.f_tipousuario = 2 AND u.email = '".$usuario."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$contar = count($registros);
	if($contar == 1){
		foreach ($registros as $registro) {
			$PassReal = $registro["password"];
			if($PassReal === $password){
				//contrasenia correcta
				//echo "Contraseña y usuario correcto";
				$IDOperador = $registro["IDOperador"];
				CrearSesion($usuario, $IDOperador);
				header('Location: Transacciones.php'); //envia a la cuenta
			}else{
				echo "Contraseña incorrecta";
			}
		}
	}else{
		echo "Correo no existe";
	}
?>