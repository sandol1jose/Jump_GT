<?php
	//Archivo para crear la seseión de detalles del producto
session_start();//inicio de sesion

    //verificamos que exista un producto agregado
    if(!isset($_SESSION["Cliente"]) || !isset($_SESSION["Producto"])){
		header('Location: ../indexLogeo.php'); //Lo regresamos
	}

    $marca = NULL;
    $material1 = NULL;
    $material2 = NULL;
    $estado = NULL;
    $color = NULL;
    $enciende = NULL;
    $descripcion = NULL;
    $uso = NULL;
    $imei = NULL;
    $alto = NULL;
    $ancho = NULL;
    $profundidad = NULL;
    $medida = NULL;
    $accesorios = NULL;
    $desperfectos = NULL;

	if($_POST['marca'] != "")           $marca = $_POST['marca'];
	if($_POST['material1'] != "")       $material1 = $_POST['material1'];
	if($_POST['material2'] != "")       $material2 = $_POST['material2'];
	if($_POST['estado'] != "")          $estado = $_POST['estado'];
	if($_POST['color'] != "")           $color = $_POST['color'];
	if($_POST['enciende'] != "")        $enciende = $_POST['enciende'];
	if($_POST['descripcion'] != "")     $descripcion = $_POST['descripcion'];
	if($_POST['uso'] != "")             $uso = $_POST['uso'];
	if($_POST['imei'] != "")            $imei = $_POST['imei'];
	if($_POST['alto'] != "")            $alto = $_POST['alto'];
	if($_POST['ancho'] != "")           $ancho = $_POST['ancho'];
	if($_POST['profundidad'] != "")     $profundidad = $_POST['profundidad'];
	if($_POST['medida'] != "")          $medida = $_POST['medida'];
	if($_POST['accesorios'] != "")      $accesorios = $_POST['accesorios'];
    if($_POST['desperfectos'] != "")    $desperfectos = $_POST['desperfectos'];
	
	$arrayDetallesProducto = array(
        'marca'=>$marca,
        'material1'=>$material1,
        'material2'=>$material2,
        'estado'=>$estado,
        'color'=>$color,
        'enciende'=>$enciende,
        'descripcion'=>$descripcion,
        'uso'=>$uso,
        'imei'=>$imei,
        'alto'=>$alto,
        'ancho'=>$ancho,
        'profundidad'=>$profundidad,
        'medida'=>$medida,
        'accesorios'=>$accesorios,
        'desperfectos'=>$desperfectos
    );
	
	$_SESSION['DetallesProducto'] = $arrayDetallesProducto;

	//verificamos si el cliente tiene todos sus datos
	if(isset($_SESSION["Cliente"])){
		if($_SESSION["Cliente"]["IDCliente"] != NULL){
			//Si tiene todos sus datos
			header('Location: ../app/AgregarProducto.php');
		}else{
			//Debe completar datos
			header('Location: ../Registro/CompletarDatos.php');
		}
	}
?>