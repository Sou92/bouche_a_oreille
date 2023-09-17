<?php
session_start();


if(!isset($_SESSION['idmembre'])) {
  //Membre non connecté : Renvoi vers la page de connexion
    header ('Location: login.php');
    exit();
}
else {
	function getallmessages($annonce, $sender)
	{
		require('config.php');
		$requeteannonce='select chat_messages.idannonce, annonces.titre from chat_messages 
			INNER JOIN annonces ON chat_messages.idannonce=annonces.idannonce where chat_messages.recever = :idmembre AND chat_messages.lu=0 GROUP BY idannonce ORDER by chat_messages.idannonce DESC, chat_messages.message_time DESC ';


		$requeteannonce=$requeteannonce.' ORDER BY ANNONCES.DATEPUBLICATION DESC LIMIT '.$maxlimite;
		$result = $bdd->query($requeteannonce);

		if (!$result)
		{
			$listeannonces=$result->fetchAll();
			$result->closecursor();
			return $listeannonces;
		}
		else
		{
			$erreur='Erreur technique 002-1'; //impossible d'executer la requête SELECT
			return 0;
		}
	}

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
			echo '<div class="row"><div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3"><div class="chat-search-box"><div class="input-group">
			<input class="form-control" placeholder="Search"><div class="input-group-btn"><button type="button" class="btn btn-sk-primary"><i class="fa fa-search"></i></button></div></div></div><div class="users-container">';
			$i=0;
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
						$listmsguser[$i][0]=$idannonce;
						$listmsguser[$i][1]=$idsender;
						$listmsguser[$i][2]=$nbmsguser;
						$j++;
						echo '<li><a class="list-group-item" id=ann-'.$idannonce.'-user-'.$idsender.' data-toggle="list" href="#listmsg-'.$idannonce.'-user-'.$idsender.'" role="tab">'.$sendername.'</a></li>';
					}
					echo '</ul>';
				}
				else 
					$erreur='Erreur technique 002-1'; //impossible d'executer la requête SELECT
			}
			$erreur='No_erros';
//			include ('lire.php?id_message='.$id_message);
      		echo '</div></div>';
      		echo '<div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9"><div class="tab-content" id="nav-tabContent"><div class="tab-pane" id="listemsg-1-user-1" role="tabpanel" aria-labelledby="listemsg-1-user-1">';
      		//getallmessages();
	        echo '</div></div></div></div>';                  
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

