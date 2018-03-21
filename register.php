<?php

    require_once 'connectDB.php';
        $us = new connectDB();
        $openConnection = $us -> accessDB();
        if(!$openConnection){
        	die("Errore nell'aprire il database");
        }
        else{
            $q = $_REQUEST["q"];
            $conn = $us-> getConnection();
             $user = "SELECT username FROM utente WHERE username='$q'";
             $result = $conn->query($user);

             if($result -> num_rows > 0)
                  echo "Utente già presente";
              else
                echo " ";
        }

?>