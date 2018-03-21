<?php
        session_start();
    	//Vado a recuperarmi l'id del libro
    	$id = $_GET["id"];
    	$output = "";
        $dettagliVend="";
        //Vado ad eseguire la connessione
        require_once 'connectDB.php';
        $lib = new connectDB();
        $openConnection = $lib -> accessDB();
        if(!$openConnection){
        	die("Errore nell'aprire il database");
        }
        else{
        	require_once 'infoLibro.php';
            //mi faccio dare la connessione
            $connection = $lib -> getConnection();
            //Creo l'oggetto per eseguire la query
            $infoL = new infoLibro();
            //vado ad eseguire la query per avere i dati del libro SENZA i generi ad esso associato
            $resultInfo = $infoL -> getInfoLibro($connection, $id);
            //Mi prelevo le informazioni relative al venditore
            $infoVenditore = $infoL -> getInfoVenditore($resultInfo["username"], $connection);
            if(!$infoVenditore){
            	$output = $output."<p> Errore nel trovare i risultati dell'utente </p>";
            }
            else{
                 //Sono andato a prelevare i risultati. Adessso devo andare a settare l'apposita form
                 $dettagliVend = $dettagliVend.' <script type = "text/javascript" src = "showDetailsBook.js"></script> 
                 <button  id="aDett" type="button" onclick="showDetails()"> Vedi i dettagli del venditore </button> 
                        <div id="dettaUser">
                        <h2 id="pVend"> Dettagli Venditore </h2>
                     	<p id="user"> <span class="grass"> Username: </span>'.$infoVenditore["user"].'</p>
                        <p id="name"> <span class="grass"> Nome: </span>'.$infoVenditore["nome"].'</p>
                        <p id="cognome"> <span class="grass"> Cognome: </span>'.$infoVenditore["cognome"].'</p>
                        <p id="citta"> <span class="grass"> Citt&agrave; : </span>'.$infoVenditore["citta"].'</p>
                        <p id="provincia"> <span class="grass"> Provincia: </span>'.$infoVenditore["provincia"].'</p>
                        <p id="email"> <a href="mailto:'.$infoVenditore["email"].'">Scrivi una mail</a></p>';
                        if ($infoVenditore["numeroTelefono"]!=NULL){
                            $dettagliVend = $dettagliVend.'<p id="numeroTelefono"> <span class="grass"> Numero Telefono: </span> '.$infoVenditore["numeroTelefono"].'</p>';
                        }
                        $dettagliVend = $dettagliVend.'<button id="cDett" type="button" onclick="closeDetails()"> Chiudi dettagli </button>
                        </div>';
            }

            //Vado a stampare le informazioni del libro
            if($resultInfo){
                	$output =  $output.'<h1>'.$resultInfo["titolo"].'</h1>'.
                                    '<img src="photo/'.$resultInfo["foto"].'" id="fotoLibro" alt="La foto del libro '.$resultInfo["titolo"].'"/>'.
                                    '<div id="infoL">'.
                    				'<p id="ISBN" class="info"> <span class="grass"> ISBN: </span>'.$resultInfo["ISBN"].'</p>'.
                                    '<p id="autore" class="info"> <span class="grass"> Autore: </span>'.$resultInfo["autore"].'</p>'.
                                    '<p id="prezzo" class="info"> <span class="grass"> Prezzo: </span>'.$resultInfo["prezzo"].'</p>'.
                                    '<p id="stato" class="info"> <span class="grass"> Stato del libro: </span>'.$resultInfo["stato"].'</p>'.
                                    '<p id="casaEditrice" class="info"> <span class="grass"> Casa Editrice: </span>'.$resultInfo["casaEditrice"].'</p>'.
                                    '<p id="annoP" class="info"> <span class="grass"> Anno di pubblicazione: </span>'.$resultInfo["annoPubblicazione"].'</p>'.
                                    '<p id="zona" class="info"> <span class="grass"> Il venditore si trova in zona: </span>'.$resultInfo["citta"].'</p>'.
                                    '</div>';
                     if($resultInfo["note"]!=NULL){
                     	$output = $output. '<p id="note" class="info"> <span class="grass"> Note del venditore: </span>'.$resultInfo["note"].'</p>';
                     }
                //mi faccio sare i generi del libro
                $generi = $infoL -> getGeneriLibro($connection,$resultInfo["codiceLibro"]);
                $output = $output.'<p class="info"> <span class="grass"> Generi di appartenenza:</span>'.$generi."</p>";
            }
            else{
            	$output = $output."<p> Non ci sono informazioni da visualizzare </p>";
            }
            $lib -> closeConnection();
        }
        
        //Vado a prendere 
        $header = file_get_contents("header.html");
        $header = str_replace("<!--script-->", '<script type = "text/javascript" src = "showDetailsBook.js"></script>', $header);
        $header = str_replace("<!--load-->", 'onload="closeDetails()"', $header);
		$footer = file_get_contents("footer.html");
		$header = str_replace("<!--posizione -->", "<a href='index.php'>Home</a> - <a href = 'catalogo.php'>Catalogo </a> - Pagina libro", $header);
		if(!isset($_SESSION["user"])){
		$log = file_get_contents("areaLogin.html");
        $aiuti = "<a href=\"#logForm\" class=\"aiuti\"> Passa alla login </a>
                  <a href=\"registrazione.php\" class=\"aiuti\"> Passa alla form di registrazione </a>";
            }
            else{
                $log = '<a class="abutt" id="aPers" href="userHome.php" title="Vai alla tua pagina personale"> Pagina Personale </a> </br>
                          <a class="abutt" id="logout" href="logout.php" title="Esci"> Logout </a>';
                $aiuti = "<a href=\"logout.php\" class=\"aiuti\"> Fai il logout </a>
                         <a href=\"userHome.php\"  class=\"aiuti\"> Vai alla tua aera personale </a>";
            }
		$header = str_replace("<!-- login -->", $log, $header);
        $header = str_replace("<!--aiuto-->", $aiuti, $header);
		$men = file_get_contents("menuCompleto.html");
		$header = str_replace("<!-- menu -->", $men, $header);
		$con = file_get_contents("corpo.html");
		$con = str_replace("<!--corpo-->", $output, $con);
        $con = str_replace("<!--dettagliVenditore-->", $dettagliVend, $con);
		$header = str_replace("<!--titolo-->", "Scheda Libro - Scambio Libri Vi", $header);
		echo $header;
		echo $con;
		echo $footer;
        
    ?>
