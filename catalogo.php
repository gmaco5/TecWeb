<?php

	session_start();
	$output= ' <h1 id="titleCat">  Il nostro catalogo </h1>
               <h2>Scegli una categoria di libri e comincia a sfogliare il nostro catalogo! </h2>';
	
	require_once 'connectDB.php';
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
            $results = $controller -> estraiGeneri($connection);

            if($results){
              $output = $output.'<ul id="cata">';
                $index = 0;
                foreach($results as $array){
                  //$output = $output.'<li> <a href="schedaLibro.php?id='.$array["codiceLibro"].'" class="scheda" title="Vai alla scheda del libro"'.$array["titolo"].'">'.$array["titolo"].'</a></li>';
                  if($index == 0){
                    $output = $output.'<li id="primoCata"> <a  href = \'elencoTitoli.php?id="'.$array['id'].'"\' >'.$array['nome']."</a></li>";
                    $index = $index+1;
                  }
                  else{
                  	$output = $output.'<li> <a href = \'elencoTitoli.php?id="'.$array['id'].'"\'>'.$array['nome']."</a></li>";
                  }
                }
                $output = $output.'</ul>
                <a href="#titleCat" id="tornaSuCata"> Torna su </a>';
            }
            else{
              $output = "<p> Non ci sono nuovi inserimenti </p> </div>";
            }
        }
        $header = file_get_contents("header.html");
        $header = str_replace("<!--load-->", "", $header);
		$footer = file_get_contents("footer.html");
		$header = str_replace("<!--posizione -->", "<a href='index.php'>Home</a> - Catalogo", $header);
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
		$men = file_get_contents("menuCatalogo.html");
		$header = str_replace("<!-- menu -->", $men, $header);
		$con = file_get_contents("corpo.html");
		$con = str_replace("<!--corpo-->", $output, $con);
		$header = str_replace("<!--titolo-->", "Catalogo - Scambio Libri Vi", $header);
		echo $header;
		echo $con;
		echo $footer;
?>
