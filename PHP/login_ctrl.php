<?php
$erreur="";
$msg="";

ini_set('display_errors','off');
require('config.php');

if ((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['password']) && !empty($_POST['password']))) {
	$email = htmlentities($_POST['email']);
	$passwordsaisi = htmlentities($_POST['password']);
	$requete = $bdd->prepare( "SELECT * FROM membres WHERE email= :email");
	$requete->bindParam('email', $email, PDO::PARAM_STR);
	$options = ['cost' => 12,];
	if ($requete->execute()){
		$nbrows=$requete->rowCount();
		if ($nbrows ==0){ //le compte n'existe pas
			$erreur = 'L\'e-mail saisi ne correspond à aucun compte. Veuillez créer un compte.<a href="register.php">Créer un compte</a>';
		}
		elseif ($nbrows==1){
			$result=$requete->fetch();
			$option=['cost' => 12,];
			//echo 'passowrd='.password_hash($passwordsaisi, PASSWORD_BCRYPT, $option);
			if (password_verify($passwordsaisi,$result['password']))
			{
				if ($result['actif']==1)
				{
					session_start();
					//error_reporting(0);
					//le compte existe, autoriser le client Ã  aller sur son espace membre'
					$_SESSION['username'] = $result['username'];
					$_SESSION['idmembre'] = $result['id'];
					$msg='Ouverture session';
					$erreur="no_errors";
				}
				else
					$Erreur="Ce compte n'est pas actif.";
			}
			else
			{
				$erreur = 'Le mot de passe entré est incorrect.<a href="mdpoublie.php">Mot de passe oublié ?</a>';
			}
		}
		else //Erreur : On trouve plusieurs enregistrements
			$erreur='Erreur technique 003';
	}
	else
		$erreur='Erreur technique 002'; //impossible d'executer la requête SELECT
}
else 
	$erreur='Veuillez saisir tous les champs obligatoires';

if (!error_get_last()) 
	$renvoi[0]=$erreur.error_get_last()['message'];
//	echo $renvoi[0];
else
	$renvoi[0]=$erreur;
	$renvoi[1]=$msg;

echo json_encode($renvoi);
return;
?>