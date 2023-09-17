<?php
// Connect to the database. 
	try	{
		$bdd = new PDO('mysql:host=localhost;dbname=boucheaoreille;charset=utf8','root', '');
	}
	catch (PDOException $e) {
			$erreur = $e->getMessage();
			die('Erreur : ' . $erreur);
	}
	return $bdd;
?>