<?php
	class News{
    	public function getNews($connection){
        //Faccio la query per andarmi a prendere gli ultimo 10 inserimenti
        $query = "SELECT codicelibro, titolo FROM copialibro JOIN libro ON copialibro.ISBN = libro.ISBN ORDER BY codicelibro DESC LIMIT 10";
        //faccio la query
        $result = mysqli_query($connection, $query) or die ("Errore nel fare la query");
        //vado a vedere se ha prodotto risultato
        if(mysqli_num_rows($result)>0){
        	$output = array();
            while($row = mysqli_fetch_assoc($result)){
            	$arrayResult = array("codiceLibro" =>  $row['codicelibro'],
                					 "titolo" => $row['titolo']);
                array_push($output, $arrayResult);
            }
            return $output;
        }
        else{
        	return null;
        }
    }
  }
?>
