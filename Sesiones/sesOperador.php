<?php
	//Archivo para crear la seseión de nuestro cliente
	function CrearSesion($usuario, $IDOperador){
		session_start();//inicio de sesion
		$arrayOperador = array(
				'usuario'=>$usuario,
				'IDOperador'=>$IDOperador
		);
		$_SESSION['Operador'] = $arrayOperador;
	}

?>