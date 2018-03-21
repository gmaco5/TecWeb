
<?php
    session_start();
    if(!isset($_SESSION["user"])){
            header("Location:index.php");
        }
        $output = "";
        require_once 'connectDB.php';
        $reg = new connectDB();
        $openConnection = $reg -> accessDB();
        $connection = $reg -> getConnection();
        if(!$connection){
        	die("Errore nell'aprire il database");
        }
        else{
            foreach ($_POST as $key => $value)
                if($value=="del") {
                    $photo="photo/$key.jpg";
                    if(file_exists($photo))
                        unlink($photo);
                    $r=$connection->query("DELETE FROM generelibro WHERE codiceLibro=$key;");
                    $r=$connection->query("DELETE FROM copialibro WHERE codiceLibro=$key;");
                }
            $output = $output."I libri sono stati eliminati <br/> <a href=\"userHome.php\"> Torna alla tua area personale </a>";
        }
        $reg -> closeConnection();

    $header = file_get_contents("headerPaginapersonale.html");
    $footer = file_get_contents("footer.html");
    $header = str_replace("<!--posizione -->", "<a href='index.php'> Home </a> - <a href='userHome.php'>Area personale </a> - Elimina Libro", $header);
    $header = str_replace("<!--load-->", "", $header);
    $con = file_get_contents("corpo.html");
    $con = str_replace("<!--corpo-->", $output, $con);
    $header = str_replace("<!--titolo-->", "Elimina Libro - Scambio Libri Vi", $header);
    $out = $_SESSION["user"];
    $header = str_replace("<!--sottotitolo-->",$out, $header);
    echo $header;
    echo $con;
    echo $footer;
?>
