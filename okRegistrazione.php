<?php
    $header = file_get_contents("header.html");
	$footer = file_get_contents("footer.html");
	$header = str_replace("<!--posizione -->", "Home", $header);
	if(!isset($_SESSION["user"])){
		$log = file_get_contents("areaLogin.html");
	}
	else{
		$log = '<a class="abutt" id="aPers" href="userHome.php" title="Vai alla tua pagina personale"> Pagina Personale </a> </br>
                  <a class="abutt" id="logout" href="logout.php" title="Esci"> Logout </a>';
	}
	$header = str_replace("<!-- login -->", $log, $header);
    $header = str_replace("<!--load-->", "", $header);
    $header = str_replace("<!--posizione -->", '<a href="index.php"> Home </a> - Registrazione con successo', $header);
	$men = file_get_contents("menuCompleto.html");
	$header = str_replace("<!-- menu -->", $men, $header);
	$con = file_get_contents("corpo.html");
    $con = str_replace("<!--corpo-->", '<p> Registrazione avvenuta con successo! </br> Torna alla <a href="index.php"> Home </a>', $con);
	$header = str_replace("<!--titolo-->", "Registrazione avvenuta con successo - Scambio Libri Vi", $header);
	echo $header;
	echo $con;
	echo $footer;
?>