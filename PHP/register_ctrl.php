<?php
$erreur="";
$msg="";

ini_set('display_errors','off');
require('config.php');

function deleteaccount($email, $password, $username)
{
	require('config.php');
	$sql ='DELETE FROM membres WHILE email = ? AND password = ? AND username = ?';
	$datas = array($email, $password, $username);
	
	try{
	  $req = $bdd->prepare($sql);
	  $req->execute($datas);  
	} 
	catch ( Exception $e ) {
	    // en cas d'erreur :
	    $erreur= " Erreur ! " . $e->getMessage ();
	    //print_r ( $datas );
	    return FALSE;
	}
	return TRUE;
}	

if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['username'])) {
	$username = htmlentities($_POST['username']);
	$email = htmlentities($_POST['email']);
	$password = htmlentities($_POST['password']);

	$requette = $bdd->prepare("SELECT * FROM membres WHERE email = :email");
	$requette->bindParam('email', $email, PDO::PARAM_STR);
	if ($requette->execute()){
		$nbrows=$requette->rowCount();
		if ($nbrows ==0){ //le compte n'existe pas, il peut être créé
			$password= password_hash($password, PASSWORD_DEFAULT); //cryptage password
			$cle = md5(microtime(TRUE)*100000); // Génération aléatoire d'une clé
			$cle=urlencode($cle);
			$newaccount=$bdd->prepare("INSERT INTO membres (username, email, password, cle, actif) VALUES (:username, :email, :password, :cle, 0 )");
			$newaccount->bindParam('username', $username, PDO::PARAM_STR);
			$newaccount->bindParam('email', $email, PDO::PARAM_STR);
			$newaccount->bindParam('password', $password, PDO::PARAM_STR);
			$newaccount->bindParam(':cle', $cle, PDO::PARAM_STR);
			//	print_r($newaccount);
			if ($newaccount->execute()){
				
				// Force PHP to use the UTF-8 charset
				//header('Content-Type: text/html; charset=utf-8'); 

				// Préparation du mail contenant le lien d'activation
				$destinataire = $email;

				$sujet = "LeBouche@Oreille : Activer votre compte" ;
				//$sujet_txt = "LeBouche@Oreille : Activer votre compte" ;
				//$sujet = '=?UTF-8?B?' . base64_encode($sujet_txt) . '?=';
				//					$entete = 'Content-Type: text/plain; charset=utf-8' . "\r\n";
				$entete = "From: inscription@votresite.com" ;
				// Le lien d'activation est composé du username(log) et de la clé(cle)
				
				//$message = base64_encode('Bienvenue sur LeBouche@Oreille,
				$message = 'Bienvenue sur LeBouche@Oreille,
			 
				//Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
				//ou copier/coller dans votre navigateur Internet.
			 
				http://leboucheaoreille.com/activation.php?username='.urlencode($username).'&cle='.$cle.'
			 
			 
					---------------
				//Ceci est un mail automatique, Merci de ne pas y répondre.';
				$envoimail=mail($destinataire, $sujet, $message, $entete);
				if ($envoimail)  {// Envoi du mail
					$erreur="no_errors";
					$msg="Votre demande d'inscription est prise en compte. Nous venons de vous envoyer un email avec un lien pour activer votre compte.";
					$msg.= "<br>***********TEXTE A SUPPRIMER***********<br>".$message;
				}
				else{
					//print_r(error_get_last());
					$msg = "Erreur technique 005 ";
					$msg .= error_get_last()['message'];
					if (!deleteaccount($email, $password, $username))
						$msg="Erreur technique 006";
				}
			}
			else
				$msg='Erreur technique 001'; //impossible d'executer la requête INSERT
		}
		elseif ($nbrows==1){ //le compte existe déjà, inviter l'utilisateur à se connecter'
			$row = $requette->fetch();
			$actif = $row['actif']; // $actif contiendra alors 0 ou 1
			if ($actif==1){
			//	$password_db = $row['password'];
				$msg='Vous avez déjà un compte avec cet email, <a href="login.php">Connectez-vous</a>';
			}
			else //Le compte existe mais n'a pas été activé
				$msg="Vous avez déjà un compte que vous n'avez pas activé. Vous devez l'activer en cliquant sur le lien que vous avez reçu par mail";
		}
		else //Erreur : On trouve plusieurs enregistrements
			$msg='Erreur technique 003';
	}
	else
		$msg='Erreur technique 002'; //impossible d'executer la requête SELECT
}
else
	$msg='Veuillez saisir tous les champs obligatoires';


$msg .= error_get_last()['message'];

$renvoi[0]=$erreur;
$renvoi[1]=$msg;

echo json_encode($renvoi);
return;
?>
