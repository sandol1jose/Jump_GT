

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Hola</h1>
	<a href=""></a>
</body>
</html>



<script type="text/javascript">
	Imprimir(2201, 2217);
	
	function Imprimir(Inicio, Fin){
		var Total = Fin - Inicio;
		console.log(Total);
		var Variable = "";
		for (var i = 0; i <= Total; i++) {
			Variable = Variable + " " + "'" + Inicio + "',";
			console.log(Inicio);
			Inicio ++;
		}
		console.log(Variable);
	}

</script>