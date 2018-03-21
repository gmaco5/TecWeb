<?php
    session_start();

    if(!isset($_SESSION["user"])){
        header("Location:index.php");
    }

    $header = file_get_contents("headerPaginapersonale.html");
    $header = str_replace("<!--script-->", "<script type=\"text/javascript\" src=\"functions.js\"></script>", $header);
    $header = str_replace("<!--posizione -->", "<a href='index.php'> Home </a> - <a href='userHome.php'>Area personale </a> - Aggiungi Libro", $header);
    $header = str_replace("<!--titolo-->", "Aggiungi Libro - Scambio Libri Vi", $header);
    $header = str_replace("<!--load-->", "", $header);
    $menu = file_get_contents("menuPaginaPersonale.html");
    $header = str_replace("<!--menu-->", $menu, $header);
    $header = str_replace("<!--sottotitolo-->",$_SESSION["user"], $header);
    $footer = file_get_contents("footer.html");
    
    if(!isset($_POST['submit'])) {
        $con = file_get_contents("aggiungiLibroCorpo.html");
    } else {
        
        require_once("CBook.php");
        if(!isset($_REQUEST["kind"]))
            $_REQUEST["kind"]=array();
        $book=new Book($_REQUEST["isbn"], $_SESSION["user"], $_REQUEST["title"], $_REQUEST["author"], $_REQUEST["editor"], $_REQUEST["year"], $_REQUEST["price"],$_REQUEST["kind"], $_REQUEST["state"],  $_REQUEST["note"]);
        $book->save();
        
        if($book==""){
            // caso in cui il libro sia stato inserito correttamente
            $con = file_get_contents("corpo.html");
            $con = str_replace("<!--corpo-->", "Il libro &egrave stato inserito correttamente", $con);
        } else {
            // caso in cui sia avvenuto un arrore
            $con = file_get_contents("aggiungiLibroCorpo.html");
            $con = str_replace("<!--messaggioErrore-->", "<div id=\"errore\" class=\"grass\"><p class=\"err\">".$book."</p></div>", $con);
        }
    }

    echo $header;
    echo $con;
    echo $footer;
?>
