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

	$requette = $bdd->prepare('SELECT message_id, username, titre, message_time, message_text FROM chat_messages m, annonces a, membres mb
	where a.idannonce=m.idannonce and recever='.$id.' and m.sender=mb.id ORDER BY message_time ASC LIMIT 0,100');
	/*LEFT JOIN membres ON membres.id = message_user WHERE  membres.id=:id ORDER BY message_time ASC LIMIT 0,100");*/
	//$requette->bindParam('id', $id, PDO::PARAM_INT);
	if ($requette->execute()){
		$nbrows=$requette->rowCount();
		$liste="";
		echo '<ul class="nav flex-column">';
		while ($data = $requette->fetch())
		{
		
			/*echo $data['date'] , ' - <a href="lire.php?id_message=' , $data['message_id'] , '">' ,
			stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['username']))) , ' ]<br />';*/

			  echo '<li class="nav-item dropdown">';
			  echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">'.$data['titre'].'</a>';

			  echo " <div class="dropdown-menu">";
			  echo '<a href="lire.php?id_message='.$data['message_id'].'">'.$data['username'].' - Le '.$data['date'].' pour '.htmlentities(trim($data['titre'])).'</a></li>';

			/*$liste='<div nombre messages : '.$nbrows.'></div>';
			$liste .= '<table>';
			$liste.='<thead>';
			$liste.='<tr>';
			$liste.='<th>date reception</th>';
			$liste.='<th>annaonce</th>';
			$liste.='<th>message</th>';
			$liste.='<th>envoyé par</th>';
			$liste.='</tr>';
			$liste.='</thead>';
			$liste.= '</table>';
			
			$liste.= '<table>';
			$liste.='<tbody>';
			$liste.='<tr>';
			$liste.='<th>'.$data['message_time'].'</th>';
			$liste.='<th>'.$data['titre'].'</th>';
			$liste.='<th>'.$data['message_text'].'</th>';
			$liste.='<th>'.$data['username'].'</th>';
			$liste.='</tr>';
			$liste.='</tbody>';
			$liste.= '</table>';*/
			
		}
		echo '</ul>';
		echo '<br /><a href="envoyer.php">Envoyer un message</a>';
		echo '<br /><br /><a href="deconnexion.php">Déconnexion</a>';

		/*
		    <ul class="list-group">
      <li class="list-group-item active">Message 1</li>
      <li class="list-group-item">Message 2</li>
      <li class="list-group-item">Message 2</li>
      <li class="list-group-item">Message 3</li>
      <li class="list-group-item">Message 4</li>
    </ul>*/

		
	}
	else
	{
		$msg .= error_get_last()['message'];
	}
	$renvoi[0]=$erreur;
	$renvoi[1]=$msg;

	//echo json_encode($renvoi);
	return;
}
?>

