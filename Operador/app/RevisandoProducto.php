<?php
session_start();//inicio de sesion
include '../../conexion.php';
include "../../app/config.php"; //ZONA HORARIA GUATEMALA
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
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
    $desperfectos = NULL;
    $comentario = NULL;

	if(isset($_POST['marca']))           $marca = $_POST['marca'];
	if(isset($_POST['material1']))       $material1 = $_POST['material1'];
	if(isset($_POST['material2']))       $material2 = $_POST['material2'];
	if(isset($_POST['estado']))          $estado = $_POST['estado'];
	if(isset($_POST['color']))           $color = $_POST['color'];
	if(isset($_POST['enciende']))        $enciende = $_POST['enciende'];
	if(isset($_POST['descripcion']))     $descripcion = $_POST['descripcion'];
	if(isset($_POST['uso']))             $uso = $_POST['uso'];
	if(isset($_POST['imei']))            $imei = $_POST['imei'];
	if(isset($_POST['alto']))            $alto = $_POST['alto'];
	if(isset($_POST['ancho']))           $ancho = $_POST['ancho'];
	if(isset($_POST['profundidad']))     $profundidad = $_POST['profundidad'];
	if(isset($_POST['medida']))          $medida = $_POST['medida'];
	if(isset($_POST['accesorios']))      $accesorios = $_POST['accesorios'];
    if(isset($_POST['desperfectos']))    $desperfectos = $_POST['desperfectos'];

    if(isset($_POST['Valor']))           $cumple = $_POST['Valor'];
    if(isset($_POST['comentario']))      $comentario = $_POST['comentario'];

    $idDetalleProducto = $_POST['idDetalleProducto'];
    $usuarioOperador = $_SESSION["Operador"]["usuario"];
    $fecha = date("Y-m-d h:i:s");
    $Transaccion = $_POST['Transaccion'];

    $sentencia = $base_de_datos->prepare("CALL RevisionProducto(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
	$resultado = $sentencia->execute([$marca, $material1, $material2, $estado, $color, $enciende,
    $descripcion, $uso, $imei, $alto, $ancho, $profundidad, $medida, $accesorios, $desperfectos, $cumple, 
    $comentario, $usuarioOperador, $fecha, $idDetalleProducto, $Transaccion]);
    if($resultado == true){
        //exito
        if($cumple == 0){
            header('Location: ../DevolDineroComprador.php?Transaccion=' . $Transaccion);
        }else{
            header('Location: ../TomarTransaccion.php?Codigo=' . $Transaccion);
        }
	}else{
		//error
		echo "Ocurrio un error";
	}

    /*
    echo "marca: " . $marca . "<br>";
    echo "material1: " . $material1 . "<br>";
    echo "material2: " . $material2 . "<br>";
    echo "estado: " . $estado . "<br>";
    echo "color: " . $color . "<br>";
    echo "enciende: " . $enciende . "<br>";
    echo "descripcion: " . $descripcion . "<br>";
    echo "uso: " . $uso . "<br>";
    echo "imei: " . $imei . "<br>";
    echo "alto: " . $alto . "<br>";
    echo "ancho: " . $ancho . "<br>";
    echo "profundidad: " . $profundidad . "<br>";
    echo "medida: " . $medida . "<br>";
    echo "accesorios: " . $accesorios . "<br>";
    echo "desperfectos: " . $desperfectos . "<br>";
    echo "Valor: " . $cumple . "<br>";
    echo "idDetalleProducto: " . $idDetalleProducto . "<br>";
    echo "usuarioOperador: " . $usuarioOperador . "<br>";
    echo "fecha: " . $fecha . "<br>";
    echo "Transaccion: " . $Transaccion . "<br>";*/
?>

