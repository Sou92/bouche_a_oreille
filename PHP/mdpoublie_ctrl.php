<?php
$erreur="";
$msg="";

ini_set('display_errors','off');
require('config.php');

if(isset($_POST['email']) && !empty($_POST['email'])) {
	$email = htmlentities($_POST['email']);
	$requete = $bdd->prepare("SELECT * FROM membres WHERE email = :email and actif=1");
	$requete->bindParam('email', $email, PDO::PARAM_STR);
	if ($requete->execute()){
		$nbrows=$requete->rowCount();
		if ($nbrows ==0){ //le compte n'existe pas
			$erreur = 'L\'e-mail saisi ne correspond à aucun compte. Veuillez créer un compte.<a href="register.php">Créer un compte</a>';
		}
		elseif ($nbrows==1){
			$row=$requete->fetch();
			$idmember=$row['id'];
			$username=$row['username'];

			$cle = md5(microtime(TRUE)*100000); // Génération aléatoire d'une clé
			$cle=urlencode($cle);

			$updrequete=$bdd->prepare("UPDATE membres SET cle = :cle where id = :idmember");
			$updrequete->bindParam('cle', $cle, PDO::PARAM_STR);
			$updrequete->bindParam('idmember', $idmember, PDO::PARAM_STR);
			if ($updrequete->execute()){
				// Préparation du mail contenant le lien d'activation
				$destinataire = $email;
				$username=$username;
				$sujet = "Réinitialiser votre mot de passe" ;
				$entete = "From: inscription@votresite.com" ;
				// Le lien de réinitialisation du mot de pase
				$message = 'Bienvenue sur VotreSite,
				//Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci-dessous
				//ou copier/coller dans votre navigateur Internet.
				http://votresite.com/initmdp.php?username='.urlencode($username).'&cle='.$cle.'&id='.$idmember.'
			 
			 
					---------------
				Ceci est un mail automatique, Merci de ne pas y répondre.';

				$envoimail=mail($destinataire, $sujet, $message, $entete);
				if ($envoimail)  {// Envoi du mail
					$erreur="no_errors";					
					//$msg= "Nous venons de envoyer un email avec un lien pour réinitialiser votre mot de passe.";
					$msg= $message;
				}
				else
					$erreur = "Erreur technique 005 ";
			}
			else
				$erreur='Erreur technique 001 '; //impossible d'executer la requête UPDATE
		}
		else //Erreur : On trouve plusieurs enregistrements
			$erreur='Erreur technique 003 ';			
	}
	else
		$erreur='Erreur technique 002 '; //impossible d'executer la requête
}
else
	$erreur='Veuillez saisir tous les champs obligatoires';

$msg .= error_get_last()['message'];

$renvoi[0]=$erreur;
$renvoi[1]=$msg;

echo json_encode($renvoi);
return;
?>

