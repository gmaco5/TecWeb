<?php 
	session_start();
    
    require_once 'connectDB.php';
    //creo un oggetto per richiedere la connessione
    $conn = new connectDB();
    //cerco di accedere al database
    $tryConnection = $conn ->  accessDB();
    if(!$tryConnection){
    	echo "<p> Errore nella connessione al database, ci scusiamo per il disagio </p>";
    }
    else{
    	//mi faccio dare la connessione 
        $connection = $conn -> getConnection();
        //Creo la query che devo andare ad eseguire
        $query = 'DELETE FROM utente WHERE username="'.$_SESSION["user"].'"';
        //cerco di eseguire la query
        $result = mysqli_query($connection, $query) or die("Errore nel cancellare l'utente");
        if(!$result){
        	return null;
        }else{
        	session_destroy();
            $conn -> closeConnection();
            header("Location: index.php");
        }
    }
?>