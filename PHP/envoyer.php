<?php
session_start();
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['idmembre'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: index.php');
	exit();
}
require('config.php');
// on teste si le formulaire a bien été soumis
if (isset($_POST['idannonce']) && $_POST['recever'] && $_POST['message']) {
	/*if (empty($_POST['receve']) || empty($_POST['idannonce']) || empty($_POST['message_text'])) {
	$erreur = 'Au moins un des champs est vide.';
	}
	else {*/
	

	// si tout a été bien rempli, on insère le message dans notre table SQL
	$requette = $bdd->prepare('INSERT INTO chat_messages(sender,recever,idannonce,message_text) VALUES (:sender,:recever, :idannonce,:message)');
	$requette->bindParam('sender', $_SESSION['idmembre'], PDO::PARAM_INT);
	$requette->bindParam('recever', $_POST['recever'], PDO::PARAM_INT);
	$requette->bindParam('idannonce', $_POST['idannonce'], PDO::PARAM_INT);
	$requette->bindParam('message', $_POST['message'], PDO::PARAM_INT);
	/*print_r($requette);
	echo $_POST['idannonce'];
	echo $_POST['recever'];
	echo $_SESSION['idmembre'];
	echo $_POST['message'];*/
	$requette->execute();
	header('Location: member.php');
	exit();
	//}
}
?>

