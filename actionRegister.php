<?php
            require_once 'connectDB.php';
            $reg = new connectDB();
            $openConnection = $reg -> accessDB();
            if(!$openConnection){
                die("Errore nell'aprire il database");
            }
            else{
                require_once"connectRegister.php";
                $newUser = new acceptNewUser();
                //vado a richiedere la connessione al gestore delle connessioni
                $connessione= $reg -> getConnection();
                //Vado a prendere gli elementi da $_POST e li mando in pasto alla funzione per mettere dentro nuovi elementi

                //Prima di andare ad inserire un utente devo vedere se l'user NON sia già inserito all'interno del database
                $isInDB = $newUser -> verifyUser($user,$connessione);
                //Controllo il risultato e vado a segnalare se c'è stato un errore
                if($isInDB){
                    $output = $output.'<p> Username già presente nel nostro database, torna alla pagina di <a href="register.html"> registrazione </a> ed effettua la registrazione con un altro usurname</p>';
                }
                else{
                    //vado a richiamare la funzione per accettare un nuovo utente, ricordandomi di passargli anche la connessione
                    $inserimento = $newUser -> acceptUser($connessione, $user, $password, $nome, $cognome, $citta, $provincia, $email, $tel);
                    if($inserimento){
                        $output = $output.'<p> Registrazione avvenuta correttamente. Torna alla <a href="index.php" title="Torna alla home"> HOME </a> ed effettua il login per scambiare i tuoi libri, o prenderne di nuovi! </p>';
                    }
                    else{
                        $output = $output.'Si è verificato un errore, la registrazione non è avvenuta. </br> Torna alla <a href="index.php"> Home </a> oppure prova a <a href="register.html"> Registrarti nuovamente </a> </p>';
                    }
                }          
            }
            //Devo andare a chiudere la connessione sennò rimane latente 
        $reg -> closeConnection();
        $header = file_get_contents("header.html");
        $header = str_replace("<!--load-->", "", $header);
		$footer = file_get_contents("footer.html");
		$header = str_replace("<!--posizione -->", "<a href='index.php'>Home </a> - Registrazione", $header);
		if(!isset($_SESSION["user"])){
			$log = file_get_contents("areaLogin.html");
		}
		else{
			$log = '<a class="abutt" id="aPers" href="userHome.php" title="Vai alla tua pagina personale"> Pagina Personale </a> </br>
					  <a class="abutt" id="logout" href="logout.php" title="Esci"> Logout </a>';
		}
		$header = str_replace("<!-- login -->", $log, $header);
		$men = file_get_contents("menuIndex.html");
		$header = str_replace("<!-- menu -->", $men, $header);
		$con = file_get_contents("corpo.html");
		$con = str_replace("<!--corpo-->", $output, $con);
		$header = str_replace("<!--titolo-->", "Registrazione - Scambio Libri Vi", $header);
		echo $header;
		echo $con;
		echo $footer;
?>
   
  

