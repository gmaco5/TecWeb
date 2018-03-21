function showDetails(){
    document.getElementById("dettaUser").style.display="block";
	
}

/*function setElements(){
	// vado a recuperarmi i cookie, ATTENZIONE, i COOKIE SONO SEPARATI A ;
	var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++)
    {
        // leggo singolo cookie "Nome = Valore
        var singoloCookie = cookies[i].split("=");
        //mi salvo il nome del cookie
        var nome = singoloCookie[0];
        //mi salvo il valore del cookie
        var valore = singoloCookie[1];
        //Devo andare a mettere a posto i rispettivi campi
        if( nome=="user")
			document.getElementById("user").innerHTML = "<span class='grass'> Username: </span> "+ valore;
        if( nome=="nome")
			document.getElementById("name").innerHTML = "<span class='grass'> Nome: </span> "+ valore;
        if( nome=="cognome")
			document.getElementById("cognome").innerHTML = "<span class='grass'> Cognome: </span> "+ valore;
        if( nome=="email")
			document.getElementById("email").innerHTML = '<a href="mailto:'+valore+'">Scrivi una mail</a>';
        if( nome=="citta")
			document.getElementById("citta").innerHTML = '<span class="grass"> Citt&agrave: </span>'+valore;
        if( nome=="provincia")
			document.getElementById("provincia").innerHTML = '<span class="grass"> Provincia: </span>'+valore;
        if( nome=="numeroTelefono")
			document.getElementById("numeroTelefono").innerHTML = '<span class="grass"> Telefono: </span>'+valore;
    }

}*/

function showButtons(){
    document.getElementById("aDett").style.display="block";
    document.getElementById("cDett").style.display="block";
    document.getElementById("pVend").style.display="none";
}

function closeDetails(){
    showButtons();
    document.getElementById("dettaUser").style.display="none";
}