<?php
	session_start();
	
	$header = file_get_contents("header.html");
	$footer = file_get_contents("footer.html");
	$header = str_replace("<!--posizione -->", "<a href='index.php'>Home</a> - Contattaci", $header);
	if(!isset($_SESSION["user"])){
		$log = file_get_contents("areaLogin.html");
        $aiuti = "<a href=\"#logForm\" class=\"aiuti\"> Passa alla login </a>
                  <a href=\"registrazione.php\" class=\"aiuti\"> Passa alla form di registrazione </a>";
	}
	else{
		$log = '<a class="abutt" id="aPers" href="userHome.php" title="Vai alla tua pagina personale"> Pagina Personale </a> </br>
                  <a class="abutt" id="logout" href="logout.php" title="Esci"> Logout </a>';
        $aiuti = "<a href=\"logout.php\" class=\"aiuti\"> Fai il logout </a>
                 <a href=\"userHome.php\" class=\"aiuti\"> Vai alla tua aera personale </a>";
	}
    $header = str_replace("<!--aiuto-->", $aiuti, $header);
	$header = str_replace("<!-- login -->", $log, $header);
    $header = str_replace("<!--load-->", "", $header);
	$men = file_get_contents("menuContattaci.html");
	$header = str_replace("<!-- menu -->", $men, $header);
	$con = file_get_contents("contenutoContatti.html");
	$header = str_replace("<!--titolo-->", "Contattaci - Scambio Libri Vi", $header);
	echo $header;
	echo $con;
	echo $footer;
?>
