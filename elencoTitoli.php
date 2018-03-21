<?php
	session_start();
	require_once 'connectDB.php';
	$output = "";
        $reg = new connectDB();
        $openConnection = $reg -> accessDB();
        if(!$openConnection){
          die("Errore nell'aprire il database");
        }
        else{
          //Devo andare ad eseguire le operazioni per tirare giu' le prime 10 novita'
            //Vado a richiedere il file .php che mi consente di eseguire l'operazione
            require_once 'controllerCatalogo.php';
            $controller = new controllerCatalogo();
            //vado a richedere a reg di darmi la connessione dove operare
            $connection = $reg-> getConnection();
            //Vado ad eseguire la query che mi ritorna un array associativo dei risultati
            $results = $controller -> estraiTitoli($connection,$_GET['id']);
            if($results){
              $output = $output.'<ul id="titleCat">';
                $index = 0;
                foreach($results as $array){
                  //$output = $output.'<li> <a href="schedaLibro.php?id='.$array["codiceLibro"].'" class="scheda" title="Vai alla scheda del libro"'.$array["titolo"].'">'.$array["titolo"].'</a></li>';
                  $output = $output."<li> <a href = 'schedaLibro.php?id=".$array['codiceLibro']."'>".$array['titolo']."</a>"." - ".$array['autore']." - ".$array['casaEditrice']."</li>";
                }
                $output = $output.'</ul>';
                $output = $output.'<a href="#titleCat" id="tornaSuCata"> Torna su </a>';
            }
            else{
              $output = $output."<p> Non ci sono nuovi inserimenti </p> <p><a href=catalogo.php> Torna al catalogo </a></p>";
            }
        }
        
	$header = file_get_contents("header.html");
    $header = str_replace("<!--load-->", "", $header);
	$footer = file_get_contents("footer.html");
	$header = str_replace("<!--posizione -->", "<a href='index.php'>Home </a> - <a href= 'catalogo.php'> Catalogo </a> - Titoli", $header);
	if(!isset($_SESSION["user"])){
		$log = file_get_contents("areaLogin.html");
	}
	else{
		$log = '<a class="abutt" id="aPers" href="userHome.php" title="Vai alla tua pagina personale"> Pagina Personale </a> </br>
                  <a class="abutt" id="logout" href="logout.php" title="Esci"> Logout </a>';
	}
	$header = str_replace("<!-- login -->", $log, $header);
	$men = file_get_contents("menuCompleto.html");
	$header = str_replace("<!-- menu -->", $men, $header);
	$con = file_get_contents("corpo.html");
	$con = str_replace("<!--corpo-->", $output, $con);
	$header = str_replace("<!--titolo-->", "Catalogo - Scambio Libri Vi", $header);
	echo $header;
	echo $con;
	echo $footer;
	
?>
