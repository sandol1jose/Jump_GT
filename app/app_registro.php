<?php 

	function BuscarDepartamentos(){
		include "../conexion.php";
		$sql = "SELECT * FROM departamento;";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		//echo "<script>alert('sisisisis');</script>";

		echo "<select class='SelectVisual' onchange='BuscarMunicipios();' id='Departamento' name='Departamento'>";
		echo "<option value='0'>Departamento</option>";
		foreach ($registros as $registro) {
			$id = $registro["id"]; //id de la tienda
			$nombre = $registro["nombre"]; //Nombre de la tienda
			echo '<option value="'.$id.'">'. $nombre .'</option>';

			//$sitio = $registro["sitio"]; //Sitio de la tienda
		}
		echo '</select>';
	}

	function BuscarMunicipios(){
		include "../conexion.php";
		$sql = "SELECT * FROM municipio;";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		//echo "<script>alert('sisisisis');</script>";

		echo "<select class='SelectVisual' id='Municipio' name='Municipio'>";
		echo "<option value='0'>Municipio</option>";
		foreach ($registros as $registro) {
			$id = $registro["id"]; //id de la tienda
			$nombre = $registro["nombre"]; //Nombre de la tienda
			echo '<option value="'.$id.'">'. $nombre .'</option>';

			//$sitio = $registro["sitio"]; //Sitio de la tienda
		}
		echo '</select>';
	}

	function BuscarBancos(){
		include "../conexion.php";
		$sql = "SELECT * FROM banco;";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		//echo "<script>alert('sisisisis');</script>";

		echo "<select class='SelectVisual' id='banco' name='banco'>";
		foreach ($registros as $registro) {
			$id = $registro["id"]; //id de la tienda
			$nombre = $registro["nombrebanco"]; //Nombre de la tienda
			echo '<option value="'.$id.'">'. $nombre .'</option>';

			//$sitio = $registro["sitio"]; //Sitio de la tienda
		}
		echo '</select>';
	}

	function BuscarBancos2(){
		include "../conexion.php";
		$sql = "SELECT * FROM banco;";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		//echo "<script>alert('sisisisis');</script>";

		echo "<select class='form-select' id='banco' name='banco'>";
		foreach ($registros as $registro) {
			$id = $registro["id"]; //id de la tienda
			$nombre = $registro["nombrebanco"]; //Nombre de la tienda
			echo '<option value="'.$id.'">'. $nombre .'</option>';

			//$sitio = $registro["sitio"]; //Sitio de la tienda
		}
		echo '</select>';
	}

 ?>