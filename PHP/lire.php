<?php
session_start();
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['idmembre'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: index.php');
	exit();
}
?>

<html>
<head>
<title>Espace membre</title>
</head>

<body>
<a href="membre.php">Retour à l'accueil</a><br /><br />
<?php
require('config.php');
echo $_GET['id_message'];
// on teste si notre paramètre existe bien et qu'il n'est pas vide
if (!isset($_GET['id_message']) || empty($_GET['id_message'])) {
	echo 'Aucun message reconnu.';
}
else {

	// on prépare une requete SQL selectionnant la date, le titre et l'expediteur du message que l'on souhaite lire, tout en prenant soin de vérifier que le message appartient bien au membre connecté
	$requette = $bdd->prepare('SELECT titre, message_time, username,message_text FROM chat_messages m, annonces a, membres mb where a.idannonce=m.idannonce and mb.id=m.sender and m.message_id='.$_GET['id_message'].' and m.recever='.$_SESSION['idmembre']);
	

	// on lance cette requete SQL à MySQL
	if ($requette->execute()){
		$nbrows=$requette->rowCount();
		if ($nbrows == 0) {
		echo 'Aucun message reconnu.';
		}
		else {
		// si le message a été trouvé, on l'affiche
		$data = $requette->fetch();
		echo $data['message_time'] , ' - ' , stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['username']))) , ' ]<br /><br />';
		echo nl2br(stripslashes(htmlentities(trim($data['message_text']))));

		// on affiche également un lien permettant de supprimer ce message de la boite de réception
		echo '<br /><br /><a href="supprimer.php?id_message=' , $_GET['id_message'] , '">Supprimer ce message</a>';
		}
	
	}
}	
?>
<br /><br /><a href="deconnexion.php">Déconnexion</a>
</body>
</html>