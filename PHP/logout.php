<?php
session_start();
if(!isset($_SESSION['username'])) {
	echo $_SESSION['username'];
    echo "vous n'avez pas de session ouverte";
    //    header ('Location: index.php');
    //    exit();
    }
else {
    echo 'Au revoir '.htmlentities(trim($_SESSION['username']));
	session_start();
	session_unset();
	session_destroy();
	header('Location: index.php');
	exit();
}
?>