function VerificarBanco(IDImput, SelectBanco){
	var ValorImput = document.getElementById(IDImput).value;
    var BancoSelect = document.getElementById(SelectBanco).value;
	var numeroCaracteres = ValorImput.length;

    switch(BancoSelect){
        case '1': //Banrural
            Banrural(numeroCaracteres, IDImput, ValorImput);
            break;
    }

}

function Banrural(numeroCaracteres, IDImput, ValorImput){
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