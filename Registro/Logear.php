<?php
session_start();
	include_once "../conexion.php";
	include_once "../Sesiones/sesCliente.php";

	$correo = $_POST["email"];
	$password = $_POST["password"];

	//verificando si el usuario no existe en la base de datos
	//Verificamos que sea de tipo 1 = Cliente
	$BaseDatos1 = $base_de_datos;
	$BaseDatos2 = $base_de_datos;
	$sql = "SELECT u.id, u.password password, u.verificado, c.id IDCliente, CONCAT(c.nombres, ' ', c.apellidos) NombreCliente, c.dpi DPI 
	FROM usuario u JOIN cliente c ON u.id = c.f_usuario WHERE u.f_tipousuario = 1 AND u.email = '".$correo."'";
	$sentencia = $BaseDatos1->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$contar = count($registros);
	
	if($contar == 1){
		RecorrerRegistros($registros, $password, 1, $correo);
	}else{
		$sql2 = "SELECT u.id, u.password password, u.verificado FROM usuario u WHERE u.f_tipousuario = 1 AND u.email = '".$correo."';";
		$sentencia2 = $BaseDatos2->prepare($sql2);
		$sentencia2->execute();
		$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
		$contar2 = count($registros2);
		if($contar2 == 1){
			RecorrerRegistros($registros2, $password, 2, $correo);
		}else{
			//correo no existe
			$_SESSION['Alerta'] = "EmailIsNotExist";
			header('Location: index.php');
		}
	}

	
	//$modo es para verificar si el usuario ya tiene todos sus datos o no
	function RecorrerRegistros($Reg, $pass, $modo, $email){
		foreach ($Reg as $registro) {
			$PassReal = $registro["password"];
			$Verificado = $registro["verificado"];
			if(password_verify($pass, $PassReal)){
				//contrasenia correcta
				if($Verificado == 1){//Vemos si el correo esta verificado
					$IDCliente = NULL;
					$Nombre = NULL;
					$DPI = NULL;
					$IDUsuario = $registro["id"];
					if($modo == 1){
						$IDCliente = $registro["IDCliente"];
						$Nombre = $registro["NombreCliente"];
						$DPI = $registro["DPI"];
					}
	
					//Creando la sesion
					CrearSesion($IDUsuario, $IDCliente, $Nombre, $DPI, $email);
					CargarEstadosTransacciones($IDCliente);

					//Creando las cookies
					setcookie("COOKIE_CLIENTE_EMAIL", $email, time() + (86400 * 30)); // 86400 = 1 day
					setcookie("COOKIE_CLIENTE_PASS", $pass, time() + (86400 * 30)); // 86400 = 1 day
					$_SESSION['Alerta'] = "inicioSesion";
					header('Location: ../indexLogeo.php');
				}else{
					//El correo no ha sido verificado
					header('Location: AnuncioEmailNoVerificado.php?email=' . $email);
				}
			}else{
				//contraseña incorrecta
				$_SESSION['Alerta'] = "passIncorrect";
				header('Location: index.php');
			}
		}
	}



	function CargarEstadosTransacciones($IdClie){
		/*Cargamos los estados actuales de las transacciones
		Servira para comparar con firebese cuando cambie de estado y no me notifique de todas las transacciones
		si no solo de la que cambio*/
		include "../conexion.php";
		
		$sql2 = "SELECT t.id, t.f_estado FROM transaccion t
		WHERE t.f_comprador = '".$IdClie."' OR t.f_vendedor = '".$IdClie."';";
		$sentencia2 = $base_de_datos->prepare($sql2);
		$sentencia2->execute();
		$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
		$contar2 = count($registros2);
		if($contar2 > 0){
			foreach($registros2 as $reg){
				$IDtrans = $reg['id'];
				$estado = $reg['f_estado'];
				$_SESSION['ESTADO_TRANSACCIONES'][$IDtrans] = $estado;
			}
		}
	}
?>