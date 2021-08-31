<?php
//REGISTRO DEL USUARIO EN LA BASE DE DATOS
session_start();
	include '../conexion.php';
	include_once "../Sesiones/sesCliente.php";

	$Nombres = $_POST["nombre"];
    $Apellidos = $_POST["apellido"];
	$DPI = $_POST["DPI"];
	//$imgDPI = addslashes(file_get_contents($_FILES['imgDPI']['tmp_name']));
	//$imgDPI = base64_encode(file_get_contents($_FILES['imgDPI']['tmp_name']));
	$imgDPI = $_SESSION['IMAGEN_DPI'];
	unset($_SESSION["IMAGEN_DPI"]); //Borramos la sesion
	$FechaNacimiento = $_POST["fechanacimiento"];
	$Telefono = $_POST["telefono"];
    $Genero = $_POST["genero"];
    $Correo = $_SESSION['Cliente']['Correo'];
    if($Genero == "Masculino"){
        $Genero = "M";
    }else{
        $Genero = "F";
    }
    
	$sentencia = $base_de_datos->prepare("CALL CompletarUsuario(?,?,?,?,?,?,?,?);");
	$resultado = $sentencia->execute([$Nombres, $Apellidos, $DPI, $imgDPI, $FechaNacimiento, $Telefono, $Genero, $Correo]);

	if($resultado == true){
		//SE AGREGO CORRECTAMENTE
		CrearSesion(-1, $Nombres . " " . $Apellidos, $DPI, $Correo);
		if(isset($_SESSION["CodigoTransaccion"])){
			//ES UN COMPRADOR
			header('Location: ../Cuenta/AgregarDireccion.php'); //Debe agregar una direccion
		}else{
			//ES UN VENDEDOR
			header('Location: AgregarProducto.php'); //Agregamos el producto
		}
	}else{
		echo "ocurrio un error";
	}
?>