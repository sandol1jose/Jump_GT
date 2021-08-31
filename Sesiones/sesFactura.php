<?php
	//Archivo para crear la seseión de nuestro cliente
	function CrearSesionFactura($PrecioProducto, $Comision, $Envioajump, $Envioacomprador, $IVA, $Redondeo){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();//inicio de sesion
		}

		$arrayFactura = array(
				'PrecioProducto'=>$PrecioProducto,
				'Comision'=>$Comision,
				'Envioajump'=>$Envioajump,
				'Envioacomprador'=>$Envioacomprador,
				'IVA'=>$IVA,
				'Redondeo'=>$Redondeo
		);
		$_SESSION['Factura'] = $arrayFactura;
	}

 ?>