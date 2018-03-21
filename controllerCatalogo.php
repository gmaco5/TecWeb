<?php
  class controllerCatalogo{

      public function estraiGeneri($connection){
         $query = "SELECT id, nome FROM genere order by nome";
         $sql = mysqli_query($connection, $query);
         $data = array();
         while($row = mysqli_fetch_assoc($sql)){
           $data[] = $row;
         }
         return $data;
      }

      public function estraiTitoli($connection, $id){
        $query = "SELECT c.codiceLibro, l.titolo, l.autore, l.casaEditrice
        FROM copialibro c
        JOIN generelibro g ON (c.codiceLibro=g.codiceLibro)
        JOIN libro l ON (c.ISBN=l.ISBN)
        WHERE g.idGenere=".$id;
        $sql = mysqli_query($connection, $query);
        $data = array();
        while($row = mysqli_fetch_assoc($sql)){
          $data[] = $row;
        }
        return $data;
      }

  }
?>
