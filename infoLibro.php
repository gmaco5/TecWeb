<?php
	class infoLibro{
    	//questa funzione mi da tutte le informazioni riguardanti il libro TRANNE i generi a lui associati in quanto
    	public function getInfoLibro($connection, $codiceLibro){
        	//la query che devo andare a fare è la seguente
            $query = 'SELECT DISTINCT c.ISBN, u.nome, u.cognome, c.codiceLibro, c.prezzo, c.stato, c.note, l.titolo, l.autore, l.casaEditrice, l.annoPubblicazione, u.username, u.citta, c.foto FROM copialibro c JOIN libro l ON c.ISBN=l.ISBN JOIN utente u ON c.proprietario = u.username WHERE c.codiceLibro ='.$codiceLibro;
            //Provo ad andare ad eseguire la query
            $risultato = mysqli_query($connection, $query) or die("Non è stato possibile trovare le informazioni, ci scusiamo per il diagio");
            if(mysqli_num_rows($risultato)>0){
            	//Significa che ho solo un genere e quindi posso gestrilo normalemnte
                $row = mysqli_fetch_assoc($risultato);
               	$output = array("ISBN" => $row["ISBN"],
                    					 "nome" => $row["nome"],
                                         "cognome" => $row["cognome"],
                                         "codiceLibro" => $row["codiceLibro"],
                                         "prezzo" => $row["prezzo"],
                                         "stato" => $row["stato"],
                                         "note" => $row["note"],
                                         "titolo" => $row["titolo"],
                                         "autore" => $row["autore"],
                                         "casaEditrice" => $row["casaEditrice"],
                                         "annoPubblicazione" => $row["annoPubblicazione"],
                                         "username" => $row["username"],
                                         "citta" => $row["citta"],
                                         "foto" => $row["foto"]);
                //Richiamo la funzione che mi setta i cookie relativi all'utente che ha inserito il libro
                return $output;
            }
            else{
            	return null;
            }
        }

        public function getGeneriLibro($connection, $codiceLibro){
            $queryConGenere = 'SELECT DISTINCT g.nome FROM copialibro c JOIN libro l ON c.ISBN=l.ISBN JOIN generelibro gl ON c.codiceLibro = gl.codiceLibro JOIN genere g ON gl.idGenere=g.id JOIN utente u ON c.proprietario = u.username WHERE c.codiceLibro ='.$codiceLibro;

            $generi= "";
            $resultGeneri = mysqli_query($connection, $queryConGenere);
            if(mysqli_num_rows($resultGeneri)>0){
                while($row = mysqli_fetch_assoc($resultGeneri)){
                    //echo $row["nome"];
                    if(strlen($generi)==0){
                        $generi= $generi." ".$row["nome"];
                    }
                    else{
                    $generi = $generi.", ".$row["nome"];}
                }
            }
            return $generi;
        }
        public function getInfoVenditore($username, $connection){
        	$query = "SELECT username, nome, cognome, citta, provincia, email, numeroTelefono FROM utente WHERE username='".$username."'";
            //provo ad andare ad eseguire la query
            $risultato = mysqli_query($connection, $query)  or die("Non è stato possibile trovare i dati relativi all'utente");
            //vedo se ha prodotto risultato
            if(mysqli_num_rows($risultato)>0){
            	$row = mysqli_fetch_assoc($risultato);
                $output = array("user" => $row["username"],
                    					 "nome" => $row["nome"],
                                         "cognome" => $row["cognome"],
                                         "citta" => $row["citta"],
                                         "provincia" => $row["provincia"],
                                         "email" => $row["email"],
                                         "numeroTelefono" => $row["numeroTelefono"]);
                //Richiamo la funzione che mi setta i cookie relativi all'utente che ha inserito il libro
                return $output;
            }
            else{
            	return null;
            }
        }
    }
?>
