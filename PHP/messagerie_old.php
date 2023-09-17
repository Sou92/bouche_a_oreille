<?php
session_start();
if(!isset($_SESSION['idmembre'])) {
  //Membre non connecté : Renvoi vers la page de connexion
    header ('Location: login.php');
    exit();
}
else {
	//Membre connecté : Accès à l'espace memebre
	$erreur="";
	$msg="";

	ini_set('display_errors','off');
	require('config.php');

	$id = htmlentities($_SESSION['idmembre']);

	$requette1 = $bdd->prepare('select chat_messages.idannonce, annonces.titre, COUNT(*) nbmsgann from chat_messages 
		INNER JOIN annonces ON chat_messages.idannonce=annonces.idannonce where chat_messages.recever = :idmembre AND chat_messages.lu=0 GROUP BY idannonce ORDER by chat_messages.idannonce DESC, chat_messages.message_time DESC');
	

	$requette1->bindParam('idmembre', $id, PDO::PARAM_INT);
	if ($requette1->execute()){
		$nbrows1=$requette1->rowCount();
		if ($nbrows1 > 0){

			while($annonceencours=$requette1->fetch()){
				$idannonce=$annonceencours['idannonce'];
				$titreannonce=$annonceencours['titre'];
				$nbmsgann=$annonceencours['$nbmsgann'];

				echo '<button class="menu-collapse d-flex w-100 justify-content-between align-items-left" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#ann-'.$idannonce.'" aria-controls="ann-'.$idannonce.'">'.$titreannonce.'<span class="badge btn-sk-primary rounded-pill">'.$nbmsgann.'</span></button>';

				$requette2 = $bdd->prepare('select membres.id, membres.username, COUNT(*) nbmsguser from chat_messages INNER JOIN membres ON chat_messages.sender=membres.id
				where chat_messages.idannonce = :idannonce GROUP BY chat_messages.sender ORDER by chat_messages.message_time DESC');
				$requette2->bindParam('idannonce', $idannonce, PDO::PARAM_INT);
				if ($requette2->execute()){
					$nbrows2=$requette2->rowCount();
					echo '<ul class="group-list collapse" id=ann-'.$idannonce.'>';
					while($messageencours=$requette2->fetch()){
				    	$idsender=$messageencours['id'];
				    	$sendername=$messageencours['username'];
				    	$nbmsguser=$messageencours['nbmsguser'];
						echo '<li><a class="list-group-item" id=ann-'.$idannonce.'-user-'.$idsender.' data-toggle="list" href="#listmsg-'.$idannonce.'-user-'.$idsender.'" role="tab">'.$sendername.'</a></li>';
					}
					echo '</ul>';
				}
				else 
					$erreur='Erreur technique 002-1'; //impossible d'executer la requête SELECT
			}
			$erreur='No_erros';
//			include ('lire.php?id_message='.$id_message);
		}
		else
			$msg="<h6>Vous n'avez aucun message</h6>";	
	}
	else
		$erreur='Erreur technique 002-1'; //impossible d'executer la requête SELECT

//	$renvoi[0]=$erreur;
//	$renvoi[1]=$msg;

//echo json_encode($renvoi);
	//return;
}
?>

