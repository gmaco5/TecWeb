<?php
	class acceptUser{      
      public function acceptLogin($user, $password, $connection){
         $query ='SELECT* FROM utente WHERE BINARY username="'.$user.'" AND BINARY password="'.$password.'"';
         $result = mysqli_query($connection, $query) or die ("Errore nel trovare l'utente");
            //Controllo che la quesy sia stata eseguita correttamente
            if(mysqli_num_rows($result) > 0){
                session_start();
                $_SESSION["user"] = $user;
                return true;
            }
            else{
              return null;
            }
      }
}
?>