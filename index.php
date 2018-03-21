<?php
	session_start();
	
	//Contenuto della pagina
		$output="";
    	require_once 'connectDB.php';
        $reg = new connectDB();
        $openConnection = $reg -> accessDB();
        if(!$openConnection){
        	die("Errore nell'aprire il database");
        }
        else{
        	//Devo andare ad eseguire le operazioni per tirare giu' le prime 10 novita'
            //Vado a richiedere il file .php che mi consente di eseguire l'operazione
            require_once 'phpNews.php';
            $news = new News();
            //vado a richedere a reg di darmi la connessione dove operare
            $connection = $reg-> getConnection();
            //Vado ad eseguire la query che mi ritorna un array associativo dei risultati
            $results = $news -> getNews($connection);
            if($results){
            	$output = '<ul>';
                $index = 0;
                foreach($results as $array){
                	$output = $output.'<li> <a href="schedaLibro.php?id='.$array["codiceLibro"].'" class="scheda" title="Vai alla scheda del libro '.$array["titolo"].'">'.$array["titolo"].'</a></li>';
                }
                $output = $output.'</ul>';
            }
            else{
            	$output = "<p> Non ci sono nuovi inserimenti </p>";
            }
        }
	
	$header = file_get_contents("header.html");
	$footer = file_get_contents("footer.html");
	$header = str_replace("<!--posizione -->", "Home", $header);
	if(!isset($_SESSION["user"])){
		$log = file_get_contents("areaLogin.html");
        $aiuti = "<a href=\"#logForm\" class=\"aiuti\"> Passa alla login </a>
                  <a href=\"registrazione.php\" class=\"aiuti\"> Passa alla form di registrazione </a>";
	}
	else{
		$log = '<a class="abutt" id="aPers" href="userHome.php"> Pagina Personale </a> </br>
                  <a class="abutt" id="logout" href="logout.php" title="Esci"> Logout </a>';
        $aiuti = "<a href=\"logout.php\" class=\"aiuti\"> Fai il logout </a>
                 <a href=\"userHome.php\" class=\"aiuti\"> Vai alla tua atea personale </a>";
	}
	$header = str_replace("<!-- login -->", $log, $header);
    $header = str_replace("<!--aiuto-->", $aiuti, $header);
    $header = str_replace("<!--load-->", "", $header);
	$men = file_get_contents("menuIndex.html");
	$header = str_replace("<!-- menu -->", $men, $header);
	$con = file_get_contents("contenutoHome.html");
	$con = str_replace("<!--novita-->", $output, $con);
	$header = str_replace("<!--titolo-->", "Home - Scambio Libri Vi", $header);
	echo $header;
	echo $con;
	echo $footer;
?>
