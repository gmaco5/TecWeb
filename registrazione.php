<?php
    //parte per crearmi l'header
    session_start();
    
    //Variabile per il messaggio di errore
    $error = "<div id=\"errore\" class=\"grass\">";
    if(isset($_POST["us"])){
        //Prelevo i dati
         $user = $_POST["us"];
         $password = $_POST["psw"];
         $nome = $_POST["nom"];
         $cognome = $_POST["cogn"];
         $citta = $_POST["citt"];
         $provincia = $_POST["prov"];
         $email = $_POST["em"];
         $tel = $_POST["tel"];

         require_once"connectRegister.php";
         $newUser = new acceptNewUser();
         //Controllo che i dati inseriti siano corretti
        $errori = $newUser -> verifyParameter($user, $password, $nome, $cognome, $citta, $provincia, $email, $tel);
             //Controllo se sono corretti
             if(strlen($errori)!=0){
                 //controllo anche l'utente se è gia inserito
                 //Se sono qui non si sono presentati errori, vado a controllare che
                 $ok = $newUser -> verifyUser($user);
                 if($ok){
                     $errori = $errori. " - Username già presente. Cambia nikename.";
                 }
                 $error = $error.'<p class="err">'.$errori.'</p> </div>';
             }
             else{
                 
                  $ok = $newUser -> verifyUser($user);
                  if($ok){
                     $errori = $errror. " - Username già presente. Cambia nikename.";
                 }
                  $error = $error.'<p class="err" >'.$errori.'</p> </div>';
                     if(strlen($errori)==0){
                         //non ci sono errori, posso andare ad eseguire la query
                        $inserimento = $newUser -> acceptUser($user, $password, $nome, $cognome, $citta, $provincia, $email, $tel);
                        if($inserimento){
    	                       header("Location:okRegistrazione.php");
                        }
                        else{
                            $error = $error.'Si è verificato un errore, la registrazione non è avvenuta. </br> Torna alla <a href="index.php"> Home </a> oppure prova a <a href="register.html"> Registrarti nuovamente </a> </p>';
                        }
                    }        
                 }
        }

    $header = file_get_contents("header.html");
    $header = str_replace("<!--script-->", "<script type=\"text/javascript\" src=\"functions.js\"></script>", $header);
	$footer = file_get_contents("footer.html");
    $men = file_get_contents("menuCompleto.html");
    $header = str_replace("<!-- menu -->", $men, $header);
	$header = str_replace("<!--posizione -->", "Registazione", $header);
    $header = str_replace("<!--load-->", "", $header);
	$con = file_get_contents("corpo.html");
    $form = file_get_contents("formRegistrazione.html");
    $form = str_replace("<!--messaggioErrore-->", $error , $form);
    $con = str_replace("<!--corpo-->", $form , $con);
	$header = str_replace("<!--titolo-->", "Registrazione - Scambio Libri Vi", $header);
	echo $header;
    echo $con;
    echo $footer;
?>
