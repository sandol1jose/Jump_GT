<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Detalles del Proudcto</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/registro.css">
	<link rel="stylesheet" type="text/css" href="../Registro/css/select.css">
	<link rel="stylesheet" type="text/css" href="../Registro/Less.css">
	<script src="../js/general.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<body>

<?php
	if(isset($_SESSION['Alerta'])){
		$Alerta = $_SESSION['Alerta'];
		if (strcmp($Alerta, "ImagenNo") === 0){
			echo "<script> alertsweetalert2('Error', 'Por favor carga una imagen', 'error'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>


<div class="base">
	<div class="Hijo">
	<div class="Titulo">
		<h5>Detalles del producto</h5>
	</div>

	<p style="font-size: 12px;">Necesitamos que llenes éstos datos de tu producto, si algún campo
    no aplica puedes dejarlo en blanco</p>

	<form method="POST" action="../Sesiones/sesDetallesProducto.php" autocomplete="off">
		<div class="Campos">
<center>
			<table style="width: 95%">
				<tr>
					<td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Marca</label>
                            <input type="text" class="form-control" name="marca">
                        </div>
					</td>
				</tr>

				<tr>
					<td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Material 1</label>
                            <input type="text" class="form-control" name="material1">
                        </div>
					</td>
				</tr>

				<tr>
					<td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Material 2</label>
                            <input type="text" class="form-control" name="material2">
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <label class="form-label" style="font-size: 14px;">Estado</label>
                        <div style="padding-bottom: 18px;">
                        <select class="form-select" name="estado">
                            <option value="Nuevo">Nuevo</option>
                            <option value="Seminuevo">Seminuevo</option>
                            <option value="Usado">Usado</option>
                        </select>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Color</label>
                            <input type="text" class="form-control" name="color">
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <label class="form-label" style="font-size: 14px;">Enciende</label>
                        <div style="padding-bottom: 18px;">
                        <select class="form-select" name="enciende">
                            <option value="3">No aplica</option>
                            <option value="1">Si</option>
                            <option value="2">No</option>
                        </select>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="form-floating" style="padding-bottom: 18px;">
                            <textarea class="form-control" name="descripcion" style="height: 100px"></textarea>
                            <label style="font-size: 12px;" >Descripción detallada del estado del producto</label>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="form-floating" style="padding-bottom: 18px;">
                            <textarea class="form-control" name="desperfectos" style="height: 100px"></textarea>
                            <label style="font-size: 12px;" >Desperfectos</label>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Tiempo de uso</label>
                            <input type="text" class="form-control" name="uso">
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">IMEI</label>
                            <input type="text" class="form-control" name="imei">
                            <div class="form-text" style="font-size: 12px;">En caso de ser un teléfono celular, de lo contrario no llenar ésta casilla</div>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Alto</label>
                            <input type="text" class="form-control" name="alto">
                            <div class="form-text" style="font-size: 12px;">Altura del producto en centimetros</div>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Ancho</label>
                            <input type="text" class="form-control" name="ancho">
                            <div class="form-text" style="font-size: 12px;">Anchura del producto en centimetros</div>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Profundidad</label>
                            <input type="" class="form-control" name="profundidad">
                            <div class="form-text" style="font-size: 12px;">Profundidad del producto en centimetros</div>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Medida</label>
                            <input type="text" class="form-control" name="medida">
                            <div class="form-text" style="font-size: 12px;">En caso de ser prenta o calzado. Ejemplo "M", "S", "32", "38", etc.</div>
                        </div>
					</td>
				</tr>

				<tr>
                    <td>
                        <div class="form-floating" style="padding-bottom: 18px;">
                            <textarea class="form-control" name="accesorios" style="height: 100px"></textarea>
                            <label style="font-size: 12px;" >Acesorios que incluye</label>
                        </div>
					</td>
				</tr>
			</table>

		</div>


        </center>
		<div class="divBoton">
			<input class="button" type="submit" name="botonEnviar" id="botonEnviar" value="Continuar">
		</div>

		<center>
			<a style="font-size: 12px;">Éstos datos los utilizará un operador de Jump para verificar y revisar
            tu producto.</a>
		</center><br>

		<div class="Logo">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</form>
	</div>



</div>

</body>
</html>