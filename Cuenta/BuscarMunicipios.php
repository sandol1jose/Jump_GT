<?php 
	include_once "../conexion.php";

	$IDDepartamento = $_POST["Departamento"];
	if($IDDepartamento != 0){
		$sql = "SELECT * FROM municipio WHERE f_departamento  = '".$IDDepartamento."'";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	
		echo "<select class='SelectVisual' id='Municipio' name='Municipio'>";
		//echo "<option>Municipios</option>";
		foreach ($registros as $registro) {
			$IDMunicipio = $registro["id"];
			$NombreMunicipio = $registro["nombre"];
			echo '<option value="'.$IDMunicipio.'">'. $NombreMunicipio .'</option>';
		}
		echo "</select>";
	}else{
		echo "<select class='SelectVisual' id='Municipio' name='Municipio'>";
		echo '<option value="0">Municipio</option>';
		echo "</select>";
	}
 ?>