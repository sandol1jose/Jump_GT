<?php
session_start();//inicio de sesion
	include '../conexion.php';
	include "config.php"; //ZONA HORARIA GUATEMALA
	
	if(!isset($_SESSION["Cliente"]) || !isset($_SESSION["Producto"]) || !isset($_SESSION["DetallesProducto"])){
		header('Location: ../indexLogeo.php'); //Lo regresamos
	}
	$IDVendedor = $_SESSION["Cliente"]['IDCliente'];

	$arrayProducto = $_SESSION['Producto'];
	$Descripcion = $arrayProducto['Descripcion'];
	$Precio = $arrayProducto['Precio'];
	$Direccion = $arrayProducto['Direccion'];
	$Detalles = $arrayProducto['Detalles'];
	$url = $arrayProducto['url'];
	$Imagen1 = $arrayProducto['Imagen1'];
	$Imagen2 = $arrayProducto['Imagen2'];
	$Imagen3 = $arrayProducto['Imagen3'];
	$Vendedor = $IDVendedor;
	$CodigoTransaccion = BuscarCodigo($base_de_datos);
	$Fecha = date("Y-m-d h:i:s");

	//DESCRIPCION DEL PRODUCTO
	$arrayDetallesProducto = $_SESSION['DetallesProducto'];
	$marca = $arrayDetallesProducto['marca'];
	$material1 = $arrayDetallesProducto['material1'];
	$material2 = $arrayDetallesProducto['material2'];
	$estado = $arrayDetallesProducto['estado'];
	$color = $arrayDetallesProducto['color'];
	$enciende = $arrayDetallesProducto['enciende'];
	$descripcion = $arrayDetallesProducto['descripcion'];
	$uso = $arrayDetallesProducto['uso'];
	$imei = $arrayDetallesProducto['imei'];
	$alto = $arrayDetallesProducto['alto'];
	$ancho = $arrayDetallesProducto['ancho'];
	$profundidad = $arrayDetallesProducto['profundidad'];
	$medida = $arrayDetallesProducto['medida'];
	$accesorios = $arrayDetallesProducto['accesorios'];
	$desperfectos = $arrayDetallesProducto['desperfectos'];

	$sentencia = $base_de_datos->prepare("CALL NuevaTransaccion(?,?,?,?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
	$resultado = $sentencia->execute([$Descripcion, $Precio, $Direccion, $Detalles, $url, $Imagen1, $Imagen2, $Imagen3, $CodigoTransaccion, $Vendedor, $Fecha,
	$marca, $material1, $material2, $estado, $color, $enciende, $descripcion, $uso, $imei,
	$alto, $ancho, $profundidad, $medida, $accesorios, $desperfectos]);
	//$resultado = true;
	if($resultado == true){
		//SE AGREGO CORRECTAMENTE
		$arrayTransaccionFirebase = array(
			'IDVendedor'=>$IDVendedor,
			'IDTransaccion'=>$CodigoTransaccion
		);
		$_SESSION['TransaccionFirebase'] = $arrayTransaccionFirebase;
		header('Location: ../Vendedor/CompartirCodigo.php?Codigo=' . $CodigoTransaccion . '');
	}else{
		//echo "ocurrio un error";
	}
?>

<?php 
	function BuscarCodigo($base_de_datos){
		$Codigo = generarCodigo(4);//Generamos un codigo nuevo
		//Lo buscamos en la base de datos
		$sql = "SELECT id FROM transaccion WHERE id = '".$Codigo."'";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$contar = count($registros);
		if($contar == 0){
			return $Codigo;
			//GrabarTransaccion($Codigo, $IDComprador, $base_de_datos);
		}else{
			BuscarCodigo();
		}
	}

/*
	function GrabarTransaccion($Codigo, $IDComprador, $base_de_datos){
		//echo $Codigo;
		$Fecha = "2020/09/24";
		$sentencia = $base_de_datos->prepare("CALL CrearCodigoTransaccion(?,?,?);");
		$resultado = $sentencia->execute([$Codigo, $Fecha, $IDComprador]);
			
		if($resultado == true){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			echo $Codigo;
		}else{
			echo "ocurrio un error";
		}
	}*/

	function generarCodigo($longitud) {
		$key = '';
		$pattern = '1234567890';
		//$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
		$max = strlen($pattern)-1;
		for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		return $key;
	}
?>