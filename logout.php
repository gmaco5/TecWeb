<?php
	session_start();
    echo $_SESSION["user"];
    if(isset($_SESSION["user"])){
		unset($_SESSION['user']);
    }
    header("Location: index.php");
?>