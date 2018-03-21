<?php
    class Book {
        private $isbn="";
        private $proprietario="";
        private $title="";
        private $author="";
        private $editor="";
        private $year="";
        private $price="";
        private $kinds=array();
        private $state="";
        private $photo=false;
        private $note="";
        private $errore="";
        
        function __construct($i,$pr, $t, $a, $e, $y, $p, $k, $s, $n) {
            $errI=$this->setISBN($i);
            $this->proprietario=$pr;
            $errT=$this->setTitle($t);
            $errA=$this->setAuthor($a);
            $errE=$this->setEditor($e);
            $errY=$this->setYear($y);
            $errP=$this->setPrice($p);
            $errK=$this->setKind($k);
            $errS=$this->setState($s);
            $errPhoto=$this->setPhoto();
            $errN=$this->setNote($n);
            
            $this->errore=$errI.$errT.$errA.$errE.$errY.$errP.$errK.$errS.$errPhoto.$errN;
        }
        
        public function __toString() {
            return $this->errore;
        }
        
        function save() {
            if($this->errore)
                return;
            require_once 'connectDB.php';
            $reg = new connectDB();
                        
            if(!$reg->accessDB()) {
                die("Errore nell'aprire il database");
            }
            $connessione=$reg->getConnection();
            if(!$connessione) {
                die("Errore nell'aprire il database");
            }
            $connessione->query("INSERT INTO `libro` VALUES('$this->title', '$this->author', '$this->editor', '$this->isbn', $this->year);");
            if(!$connessione->query("INSERT INTO `copialibro` (`ISBN`, `proprietario`, `prezzo`, `stato`, `note`, `foto`) VALUES('$this->isbn', '$this->proprietario', $this->price, '$this->state', $this->note, 'noImage.jpg');"))
                die("Errore nell'inserire il libro nel database");
            $id = $connessione->insert_id;
            foreach($this->kinds as $kind)
                $connessione->query("INSERT INTO `generelibro` VALUES('$id','$kind');");
            if($this->photo) {
                $target_dir = "photo/";
                $target_file = $target_dir.$id.".jpg";
                move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
                $r=$connessione->query("UPDATE `copialibro` SET foto= '$id.jpg' WHERE codiceLibro='$id';");
            }
            $reg->closeConnection();
        }
        
        function setISBN($i) {
            $errore="";
            $isbn = str_replace(' ', '', $i);
            if(strlen($isbn)==0) {
                $errore="Il codice ISBN deve essere presente</br>";
            } else if(!preg_match("/^([0-9]){13}$/", $isbn)) {
                $errore="Formato del codice ISBN non &eacute; corretto! Inserire 13 caratteri numerici</br>";
            } else {
                $this->isbn=$isbn;
            }
            return $errore;
        }
        
        function setTitle($i) {
            $errore="";
            $title = trim($i);
            if(strlen($title)==0) {
                $errore="Il titolo deve essere presente</br>";
            } else if(strlen($title)>150){
                $errore = "Il titolo &eacute; troppo lungo</br>";
            } else {
                $this->title = htmlentities($title);
            }
            return $errore;
        }
        
        function setAuthor($i) {
            $errore="";
            $aut = trim($i);
            if(strlen($aut)==0) {
                $errore="L'Autore deve essere presente</br>";
            } else if(strlen($aut)>150){
                $errore = "L'Autore &eacute; troppo lungo</br>";
            } else {
                $this->author = htmlentities($aut);
            }
            return $errore;
        }
        
        function setEditor($i) {
            $errore="";
            $aut = trim($i);
            if(strlen($aut)==0) {
                $errore="L'editore deve essere presente</br>";
            } else if(strlen($aut)>150){
                $errore = "L'editore &eacute; troppo lungo</br>";
            } else {
                $this->editor = htmlentities($aut);
            }
            return $errore;
        }
        
        function setYear($i) {
            $errore="";
            $year=trim($i);
            
            if(strlen($year)!=0) {
                if(!preg_match("/^([0-9]){0,4}$/", $year)) {
                    $errore="L'anno &eacute; deve essere un numero</br>";
                }
                else if(!(is_numeric($year)) || (int)$year > date("Y")) {
                    $errore="L'anno non &eacute; valido</br>";
                }
                $this->year=$year;
            }else{
                $this->year="NULL";
            }
            return $errore;
        }
        
        function setPrice($i) {
            $errore="";
            $pr=trim($i);
            
            if(strlen($pr)==0) {
                $errore="Il prezzo &eacute; obbligatorio</br>";
            }else if(!preg_match("/^[0-9]+(\.\[0-9]{1,2})?$/", $pr)) {
                $errore="Inserire un prezzo valido: usare il punto come separatore e massimo 2 cifre decimali<br/>";
            }else {
                $this->price=$pr;
            }
            return $errore;
        }
        
        function setKind($kinds) {
            $errore="";
            if(count($kinds)==0) {
                $errore="Selezionare almeno un genere</br>";
            } else if(count($kinds)>3) {
                $errore="Selezionare al massimo 3 generi</br>";
            } else {
                $this->kinds=$kinds;
            }
            return $errore;
        }
        
        function setState($state) {
            $errore="";
            if(strlen($state)==0) {
                $errore="Selezionare lo stato</br>";
            } else {
                $this->state=$state;
            }
            return $errore;
        }
        
        function setPhoto() {
            $errore="";
            if(file_exists($_FILES['photo']['tmp_name'])) {
                echo "foto esiste";
                // Allow only jpg
                $allowed =  array('jpeg' ,'jpg');
                $ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    $errore="Selezionare un file con estensione .jpeg o .jpg<br/>";
                } else if(getimagesize($_FILES["photo"]["tmp_name"])==false) {
                    $errore="Il file non &egrave; un'immagine<br/>";
                } else if ($_FILES["photo"]["size"] > 2000000) {
                    $errore="La dimensione massima &egrave; 2 MB. Prova con un file di dimensione inferiore<br/>";
                } else
                    $this->photo=true;
            }
            return $errore;
        }
        
        function setNote($note) {
            $note=trim($note);
            if(strlen($note)!=0)
                $this->note="'$note'";
            else
                $this->note="NULL";
        }
    }
?>