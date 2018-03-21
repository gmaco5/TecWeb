<?php
	
		class acceptNewUser{     	   
        	  //Ritorna true sse l'username inserito è presente nel database
        	  public function verifyUser($user){
                 require_once 'connectDB.php';
                    $reg = new connectDB();
                    $openConnection = $reg -> accessDB();
                    if(!$openConnection){
                        die("Errore nell'aprire il database");
                    }
                  $connection = $reg -> getConnection();
              	$query = "SELECT * FROM utente WHERE username='".$user."'";
                $result = $connection->query($query);
                    $rows = mysqli_num_rows($result);
                    if( $rows > 0){
                        $reg ->closeConnection();
                        return true;
                    }
                    else{
                        $reg -> closeConnection();
                      return null;
                    }
                }
              
              public function verifyParameter($user, $password, $nome, $cognome, $citta, $provincia, $email, $tel){
                  $error = "";
                  if(strlen($password)>12){
                      $error = $error."- Password troppo lunga! </br>";
                  }
                  if(strlen($user)==0){
                      $error = $error."- User richiesto! </br>";
                  }
                  if(strlen($nome)==0){
                      $error = $error."- Nome richiesto! </br>";
                  }
                  if(strlen($cognome)==0){
                      $error = $error."- Cognome richiesto! </br>";
                  }
                  if(strlen($password)==0){
                      $error = $error."- Password richiesta! </br>";
                  }
                  else if(strlen($password) > 12 ){
                      $error = $error."- Password troppo lunga! </br>";
                  }
                  if(strlen($citta)==0){
                      $error = $error."- Citt&agrave; richiesta! </br> ";
                  }
                  if(strlen($provincia)==0){
                      $error = $error."- Provincia richiesta! </br>";
                  }
                  if(strlen($email)==0){
                      $error = $error."- Email richiesta! </br>";
                  }
                  if(!strpos($email, "@")){
                      $error = $error."- Email non valida! </br>";
                  }
                  return $error;
                  
              }
            
              public function verifyChange($psw, $psw1, $city, $prov, $email, $tel){
                $error = "";
                if($psw != $psw1 ){ 
                     $error = $error."- La password e la conferma devono essere uguali! <br/>";
                }
                if(strlen($psw)>12){
                      $error = $error."- Password troppo lunga! <br/>";
                }
                if(strlen($city)==0){
                      $error = $error."- Citt&agrave; richiesta! <br/> ";
                }
                if(strlen($prov)==0){
                      $error = $error."- Provincia richiesta! <br/>";
                }
                if(strlen($email)==0){
                      $error = $error."- Email richiesta! <br/>";
                }
                if(!strpos($email, "@")){
                      $error = $error."- Email non valida! <br/>";
                 }
                  
                return $error;
                
              }
            
            public function acceptChanges($psw, $city, $prov, $email, $tel, $user){
                    require_once 'connectDB.php';
                    $reg = new connectDB();
                    $openConnection = $reg -> accessDB();
                    if(!$openConnection){
                        die("Errore nell'aprire il database");
                    }
                    $connection = $reg -> getConnection();
                    
                    if($tel==""){
                       $tel= NULL;
                    }
                
                $query="UPDATE utente SET password=\"$psw\", citta=\"$city\", provincia=\"$prov\", email=\"$email\", numeroTelefono=\"$tel\" WHERE username=\"$user\";";
                $result = $connection -> query($query);
                if($result){
                    $reg->closeConnection();
                    return true;
                }
                else{
                    $reg -> closeConnection();
                    return false;
                }
                
            }
            
              //Ritorna tue se è stato inserito correttamente
              public function acceptUser($user, $password, $nome, $cognome, $citta, $provincia, $email, $tel){   
                    //Vado a creare una connessione
                    require_once 'connectDB.php';
                    $reg = new connectDB();
                    $openConnection = $reg -> accessDB();
                    if(!$openConnection){
                        die("Errore nell'aprire il database");
                    }
                    $connection = $reg -> getConnection();
                    //Controllo se il campo opzionale Tel è presente o meno
                    if($tel==""){
                       $tel= NULL;
                    }
                    //$query ="SELECT * FROM utente";
                    $query = "INSERT INTO utente VALUES ('".$user."', '".$password."','".$nome."', '".$cognome."', '".$citta."', '".$provincia."','".$email."',' ".$tel."')";
                    //Provo ad andare ad eseguire la query
                    $result = $connection->query($query);
                    //Controllo che la quesy sia stata eseguita correttamente
                    if($result){
                        $reg -> closeConnection();
                        return true;
                    }
                    else{
                      $reg -> closeConnection();
                      return null;
                    }
                }
              }
 ?>
   
    
