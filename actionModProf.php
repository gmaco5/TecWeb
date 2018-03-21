<?php session_start(); 
  if(!isset($_SESSION["user"])){
    	header("Location:index.php");
    }
    $output="<h1> Aggiornamento avvenuto con successo! </h1>
             <p> Torna alla tua <a href=\"userHome.php\" title=\"Pagina personale\"> pagina personale </a> <br/>
             oppure torna alla <a href=\"index.php\" title=\"home\"> <span xml:lang=\"en\"> Home </span> </a>";
    $header = file_get_contents("headerPaginapersonale.html");
    $footer = file_get_contents("footer.html");
    $header = str_replace("<!--posizione -->", "<a href='index.php'> Home </a> - <a href='userHome.php'>Area personale </a> - Modifica profilo", $header);
    $header = str_replace("<!--load-->", "", $header);
    $con = file_get_contents("corpo.html");
    $con = str_replace("<!--corpo-->", $output, $con);
    $header = str_replace("<!--titolo-->", "Modifica Profilo Libro - Scambio Libri Vi", $header);
    $out = $_SESSION["user"];
    $header = str_replace("<!--sottotitolo-->",$out, $header);
    echo $header;
    echo $con;
    echo $footer;
?>    