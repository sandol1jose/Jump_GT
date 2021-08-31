<?php
//AGREGANDO UNA NUEVA DIRECCION
session_start();
	include '../conexion.php';

    if($_POST["Departamento"] == 0 || $_POST["Municipio"] == 0){
        $_SESSION["Alerta"] = "CompletaCampos";
        header('Location: ../Cuenta/AgregarDireccion.php'); //Agregamos el producto
    }else{
        $Direccion1 = $_POST["dire1"];
        $Direccion2 = $_POST["dire2"];
        $Departamento = $_POST["Departamento"];
        if($_POST["Municipio"] != ""){
            $Municipio = $_POST["Municipio"];
        }else{
            $Municipio = NULL;
        }
        
        $IDCliente = $_SESSION["Cliente"]["IDCliente"];
    
        $sentencia = $base_de_datos->prepare("CALL NuevaDireccion(?,?,?,?);");
        $resultado = $sentencia->execute([$Direccion1, $Direccion2, $Municipio, $IDCliente]);
            
        if($resultado == true){
            //SE AGREGO CORRECTAMENTE
            $_SESSION["Alerta"] = "DireExito";
            header('Location: vincular.php');
        }else{
            echo "ocurrio un error";
        }
    }
?>