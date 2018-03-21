<?php
	session_start();
	require_once 'connectDB.php';
	$output = "";
        $log = new connectDB();
        $openConnection = $log -> accessDB();
        if(!$openConnection){
        	die("Errore nell'aprire il database");
        }
        else{
        	//Devo andare a farmi dare la connessione
            $connection = $log -> getConnection();
            //Vado ad includere i file dove sono contenute le funzioni per verificare se un utente è valido
            require_once "connectLogin.php";
            //creo il nuovo oggetto
            $acceptUs = new acceptUser();
        	//Devo innanzitutto verificare che i contenuti siano validi
            $user = $_POST["us"];
            $password = $_POST["psw"];
            $loggati = $acceptUs -> acceptLogin($user, $password, $connection);
            if($loggati){
            	header("Location: userHome.php");
       		}
            else{
            	$output = $output.'<p> Nome utente o password errati! <a href="registrazione.php"> Registrati</a>! <br/> Oppure torna alla <a href="index.php"> Home </a> </p>';
            }
        }
      //Una volta completate tutte le operazioni devo sloggarmi dal database
    $log -> closeConnection();

	$header = file_get_contents("header.html");
    $header = str_replace("<!--load-->", "", $header);
	$footer = file_get_contents("footer.html");
	$header = str_replace("<!--posizione -->", "<a href='index.php'>Home </a> - Login", $header);
	$men = file_get_contents("menuCompleto.html");
	$header = str_replace("<!-- menu -->", $men, $header);
	$con = file_get_contents("corpo.html");
	$con = str_replace("<!--corpo-->", $output, $con);
	$header = str_replace("<!--titolo-->", "Login - Scambio Libri Vi", $header);
	echo $header;
	echo $con;
	echo $footer;
?>
