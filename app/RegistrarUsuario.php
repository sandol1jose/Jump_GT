<?php
//REGISTRO DEL USUARIO EN LA BASE DE DATOS
session_start();
	include '../conexion.php';
	include 'EnviarCorreo.php';
	include "config.php"; //ZONA HORARIA GUATEMALA

	$Correo = $_POST["correo"];
	$Correo = strtolower($Correo);//Convirtiendo todo el correo a minusculas

	//VERIFICAMOS QUE EL CORREO NO EXISTA EN LA BASE DE DATOS
	$sql = "SELECT u.id FROM usuario u WHERE u.email = '".$Correo."';";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$contUsuarios = count($registros);
	if($contUsuarios == 0){ //El correo no existe en nuestra base de datos

		$Pass = $_POST["pass"];
		$PassCifrada = password_hash($Pass, PASSWORD_DEFAULT); //Encriptando contraseñas
		$sentencia = $base_de_datos->prepare("CALL NuevoUsuario(?,?);");
		$resultado = $sentencia->execute([$Correo, $PassCifrada]);
			
		if($resultado == true){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			//echo "agregado correctamente";
			//header('Location: ../Registro'); //envia a la página de inicio.
			EnviarEmail($Correo, $base_de_datos);
			header('Location: ../Registro/Verificacion.php?email=' . $Correo); //envia a la página de inicio.
		}else{
			echo "ocurrio un error";
		}
	}else{
		//El correo ya existe en la base de datos
		$_SESSION["Alerta"] = "CorreoYaExiste";
		header('Location: ../Registro/registro.php'); //envia a la página de inicio.
	}
?>
<?php/*
	function EnviarEmail($Email, $base_de_datos){
		$Codigo = BuscarCodigo($base_de_datos, $Email);
		$to = $Email;
		$subject = "Confirmación de correo electrónico";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$from = "jumpchiquimula@gmail.com";
		$headers .= "From:" . $from;
		 
		$message = "
		<html>
		<head>
		<title>Confirmación de correo electrónico</title>
		</head>
		<body>
		<h2>Debes confirmar tu correo electronico</h2>
		<p>Ingresa el siguiente codigo para verificar tu correo electrónico</p>
		<H1>".$Codigo."</H1><br><br>
		<p>Jump GT</p>
		<p>https://www.jumpgt.com</p>
		</body>
		</html>";
		 
		mail($to, $subject, $message, $headers);
	}


	function BuscarCodigo($base_de_datos, $Email){
		$Codigo = generarCodigo(5);//Generamos un codigo nuevo
		//Lo buscamos en la base de datos
		$sql = "SELECT id FROM verificacion WHERE clave = '".$Codigo."'";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$contar = count($registros);
		if($contar == 0){
			if(GrabarCodigo($Codigo, $base_de_datos, $Email) == 1){
				return $Codigo;
			}else{
				BuscarCodigo($base_de_datos, $Email);
			}
		}else{
			BuscarCodigo($base_de_datos, $Email);
		}
	}

	function GrabarCodigo($Codigo, $base_de_datos, $Email){
		$sql = "SELECT u.id FROM usuario u WHERE u.email = '".$Email."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$IDusuario;
		foreach($registros as $registro){
			$IDusuario = $registro['id'];
		}
		$Fecha = date("Y-m-d h:i:s");

		$sentencia2 = $base_de_datos->prepare("CALL NewCodVerificacion(?,?,?);");
		$resultado2 = $sentencia2->execute([$Codigo, $Fecha, $IDusuario]);
			
		if($resultado2 == true){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			return 1;
		}else{
			return 0;
		}
	}

	function generarCodigo($longitud) {
		$key = '';
		//$pattern = '1234567890';
		$pattern = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$max = strlen($pattern)-1;
		for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		return $key;
	}*/
?>

