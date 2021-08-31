<?php
	//Archivo para crear la seseión de nuestro cliente
session_start();//inicio de sesion
	$Descripcion = $_POST['descripcion'];
	$Precio = $_POST['precio'];
	$Direccion = $_POST['direccion'];
	$Detalles = $_POST['detalles'];
	$url = $_POST['url'];

	//OBTENIENDO LAS IMAGENES
	$Imagen1 = $_SESSION['IMAGENES_PRODUCTO'][1];
	$Imagen2 = $_SESSION['IMAGENES_PRODUCTO'][2];
	$Imagen3 = $_SESSION['IMAGENES_PRODUCTO'][3];
	unset($_SESSION['IMAGENES_PRODUCTO']);

	/*
	echo $Imagen1 . "<br><br><br>";
	echo $Imagen2 . "<br><br><br>";
	echo $Imagen3 . "<br><br><br>";
	
	
	$Imagen1 = base64_encode(file_get_contents($_FILES['Imagen1']['tmp_name']));
	$Imagen2 = base64_encode(file_get_contents($_FILES['Imagen2']['tmp_name']));
	$Imagen3 = base64_encode(file_get_contents($_FILES['Imagen3']['tmp_name']));*/
	
	$arrayProducto = array(
			'Descripcion'=>$Descripcion,
			'Precio'=>$Precio,
			'Direccion'=>$Direccion,
			'Detalles'=>$Detalles,
			'url'=>$url,
			'Imagen1'=>$Imagen1,
			'Imagen2'=>$Imagen2,
			'Imagen3'=>$Imagen3
	);

	$_SESSION['Producto'] = $arrayProducto;
	header('Location: ../Vendedor/DetallesProducto.php');
	/*
	//verificamos si el cliente tiene todos sus datos
	if(isset($_SESSION["Cliente"])){
		if($_SESSION["Cliente"]["IDCliente"] != NULL){
			//Si tiene todos sus datos
			header('Location: ../app/AgregarProducto.php');
		}else{
			//Debe completar datos
			header('Location: ../Registro/CompletarDatos.php');
		}
	}*/
?>