<?php
	session_start();
    //controllo se sono presenti delle sessioni attive, in caso contrario reindirizzo alla homepage
    if(!isset($_SESSION["user"])){
    	header("Location:index.php");
    }
	$header = file_get_contents("headerPaginapersonale.html");
	$footer = file_get_contents("footer.html");
	$header = str_replace("<!--posizione -->", "<a href='index.php'> Home </a> - Area personale", $header);
	$con = file_get_contents("contenutoPaginaPersonale.html");
	$header = str_replace("<!--titolo-->", "Pagina personale - Scambio Libri Vi", $header);
    $menu = file_get_contents("menuPaginaPersonale.html");
    $header = str_replace("<!--load-->", "", $header);
    $header = str_replace("<!--menu-->", $menu, $header);
	$out = $_SESSION["user"];
	$header = str_replace("<!--sottotitolo-->",$out, $header);
	echo $header;
	echo $con;
	echo $footer;
 ?>
 

     
