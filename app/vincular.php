<?php
session_start();//inicio de sesion
	include '../conexion.php';
	if(!isset($_SESSION["Cliente"])){
		exit();
	}

$IDComprador = $_SESSION["Cliente"]['IDCliente'];
$CodigoTransaccion;
if(isset($_POST['codigotransaccion'])){
	$CodigoTransaccion = $_POST['codigotransaccion'];
}else{
	$CodigoTransaccion = $_SESSION["CodigoTransaccion"];
}
	
if(ExisteTransaccion($base_de_datos, $CodigoTransaccion) == true){
	if($_SESSION["Cliente"]['IDCliente'] == NULL){
		//ES SU PRIMERA COMPRA
		$_SESSION["CodigoTransaccion"] = $CodigoTransaccion;
		header('Location: ../Registro/CompletarDatos.php'); //Enviamos a completar datos
	}else{
		if(VerificarDireccion($IDComprador, $base_de_datos) == true){	
			unset($_SESSION["CodigoTransaccion"]); //Eliminamos la variable de session
			try {
				$sentencia = $base_de_datos->prepare("CALL vincular(?,?);");
				$resultado = $sentencia->execute([$CodigoTransaccion, $IDComprador]);

				if($resultado == true){
					$_SESSION['TransaccionFirebase'] = $CodigoTransaccion;
					header('Location: ../Comprador/DetallesDeTransaccion.php');
				}else{
					echo "ocurrio un error";
				}
			} catch (Exception $e) {
				echo "Error: " . $e;
			}
		}else{
			//AGREGAR UNA DIRECCION
			$_SESSION["CodigoTransaccion"] = $CodigoTransaccion;
			header('Location: ../Cuenta/AgregarDireccion.php'); //Debe agregar una direccion
		}
	}
}else{
	$_SESSION["Alerta"] = "TransaccionNoExist";
	header('Location: ../Comprador/Vinculacion.php');
}
?>
<?php
	function ExisteTransaccion($base_de_datos, $Transaccion){
		//Verifica si existe la transaccion a vincular
		$sql = "SELECT t.id FROM transaccion t WHERE (t.f_estado = 1 OR t.f_estado = 2 ) AND t.id = '".$Transaccion."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$contCodigo = count($registros);
		if($contCodigo == 1){
			return true; //Si existe
		}else{
			return false; //No existe
		}
	}


	function VerificarDireccion($IDComprador, $base_de_datos){
		//VERIFICAMOS SI TIENE DIRECCION REGISTRADA
		$sql = "SELECT * FROM cliente c
		JOIN direccion d ON c.f_direccion = d.id 
		WHERE c.id = '".$IDComprador."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$contCodigo = count($registros);
		if($contCodigo == 1){
			return true; //Si existe
		}else{
			return false; //No existe
		}
	}

?>