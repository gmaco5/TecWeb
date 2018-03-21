<?php
    session_start();
      if(!isset($_SESSION["user"])){
    	header("Location:index.php");
    }
    require_once 'connectDB.php';
    $reg = new connectDB();
    $output ="";
    $openConnection = $reg -> accessDB();
    if(!$openConnection){
        die("Errore nell'aprire il database");
    }
    else{
        $connessione= $reg -> getConnection();
        //creo un nuovo oggetto per eseguire la query nel database
        $user=$_SESSION["user"];
        $result=$connessione-> query("SELECT l.titolo,l.autore,c.codiceLibro AS cl FROM libro l INNER JOIN copialibro c ON (l.ISBN=c.ISBN) WHERE c.proprietario='$user' ORDER BY c.codiceLibro;");
        if($result->num_rows ==0)
            $output = $output.'<p>Non hai libri presenti</p>';
        else{
            $output = $output."<p>Seleziona i libri che vuoi eliminare</p>"
                    .'<form id="elLibForm" action="actionEliminaLibro.php" method="post">'. "<fieldset> <legend> Elimina Libri </legend>"
                    ."<ul class=\"delBook\">";
            while($row=mysqli_fetch_assoc($result)){
                 $cl=$row['cl'];
                 $title=$row['titolo'];
                 $author=$row['autore'];
                 $output = $output."<li><input type=\"checkbox\" name=\"$cl\" value=\"del\"/> $title di $author</li>";
            }
            $output = $output.'</ul><input class="abutt" type="submit" value="Elimina"/> </fieldset> </form>';
        }
    }

    $header = file_get_contents("headerPaginapersonale.html");
    $footer = file_get_contents("footer.html");
    $header = str_replace("<!--posizione -->", "<a href='index.php'> Home </a> - <a href='userHome.php'>Area personale </a> - Elimina libro", $header);
    $header = str_replace("<!--load-->", "", $header);
    $con = file_get_contents("eliminaLibriCorpo.html");
    $con = str_replace("<!--elencoLibri-->", $output, $con);
    $header = str_replace("<!--titolo-->", "Elimina Libro - Scambio Libri Vi", $header);
    $menu = file_get_contents("menuPaginaPersonale.html");
    $header = str_replace("<!--menu-->", $menu, $header);
    $out = $_SESSION["user"];
    $header = str_replace("<!--sottotitolo-->",$out, $header);
    echo $header;
    echo $con;
    echo $footer;
?>
