

function VerificarBanco(IDImput){
	var ValorImput = document.getElementById(IDImput).value;
	var numeroCaracteres = ValorImput.length;
	if(numeroCaracteres == 10 || numeroCaracteres == 14){
		console.log("La cadena tiene " + numeroCaracteres);
		var PrimerNumero = ValorImput.charAt(0);
		console.log("Empieza con " + PrimerNumero);
		if(PrimerNumero == 3 || PrimerNumero == 4 || PrimerNumero == 0){
			console.log("Es un Numero de cuenta de Banrural");
		}else{
			alert("No es un numero de Banrural");
			document.getElementById(IDImput).value = "";
		}
	}else{
		alert("No es un numero de Banrural");
		document.getElementById(IDImput).value = "";
	}
}