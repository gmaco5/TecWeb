<?php 
  session_start(); 
  if(!isset($_SESSION["user"])){
    	header("Location:index.php");
    }
    $error = "<div id=\"errore\" class=\"grass\"> ";
    $user=$_SESSION["user"];
            $psw = "";
            $citta ="";
            $provincia="";
            $email="";
            $numeroT="";
   
            require_once 'connectDB.php';
            $log = new connectDB();
            $openConnection = $log -> accessDB();
            if(!$openConnection){
                die("Errore nell'aprire il database");
            }
            else{
        	//Devo andare a farmi dare la connessione
                $connection = $log -> getConnection();
                $query="SELECT * FROM utente WHERE username=\"$user\";";
                $result=$connection->query($query);
                $row = $result->fetch_assoc();
                $psw = $row['password'];
                $citta=$row['citta'];
                $provincia=$row['provincia'];
                $email=$row['email'];
                $numeroT=$row['numeroTelefono'];
            }
        if(isset($_POST["psw"])){
            //Prelevo i dati
             $password = $_POST["psw"];
             $password1 = $_POST["psw1"];
             $city = $_POST["citta"];
             $prov = $_POST["prov"];
             $em = $_POST["em"];
             $tel = $_POST["tel"];

             require_once"connectRegister.php";
             $modifyUser = new acceptNewUser();
             $errori = $modifyUser -> verifyChange($password, $password1, $city, $prov, $em, $tel);
             if(strlen($errori)== 0){
                $ok = $modifyUser -> acceptChanges($password, $city, $prov, $em, $tel, $user);
                if(!$ok){
                       $errori = $errori.'Si è verificato un errore, la modifica non è avvenuta. </br> Torna alla <a href="modProf.php"> Pagina di modifica </a> oppure torna all\' <a href="UserHome.html"> area personale. </a> </p>';
                       $error = $error.'<p class="err" >'.$errori.'</p> </div>';
                }
                else{
                     header("Location:actionModProf.php");
                }
             }

             else{
                $error = $error.'<p class="err" >'.$errori.'</p> </div>';
             }
        }else{
            $error = $error."</div>";
        }
        

            $log->closeConnection();
    

     

            $header = file_get_contents("headerPaginapersonale.html");
            $footer = file_get_contents("footer.html");
            $header = str_replace("<!--posizione -->", "<a href='index.php'> Home </a> - <a href='userHome.php'>Area personale </a> - Modifica Profilo", $header);
            $header = str_replace("<!--load-->", "", $header);
            $header = str_replace("<!--script-->", "<script type=\"text/javascript\" src=\"functions.js\"></script>", $header);
            $con = file_get_contents("modProfCorpo.html");
            $header = str_replace("<!--titolo-->", "Modifica Profilo - Scambio Libri Vi", $header);
            $con = str_replace("<!--password-->", $psw, $con);
            $con = str_replace("<!--citta-->", $citta, $con);
            $con = str_replace("<!--provincia-->", $provincia, $con);
            $con = str_replace("<!--email-->", $email, $con);
            $con = str_replace("<!--telefono-->", $numeroT, $con);
            $menu = file_get_contents("menuPaginaPersonale.html");
            $con = str_replace("<!--messaggioErrore-->", $error , $con);
            $header = str_replace("<!--menu-->", $menu, $header);
            $out = $_SESSION["user"];
            $header = str_replace("<!--sottotitolo-->",$out, $header);
            echo $header;
            echo $con;
            echo $footer;

?>
