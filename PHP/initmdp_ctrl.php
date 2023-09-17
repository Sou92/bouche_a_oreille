<?php
$erreur="";
$msg="";

ini_set('display_errors','off');
require('config.php');

if(isset($_POST['id']) && isset($_POST['inputpassword']) && isset($_POST['confirmpassword'])) 
{
	$idmember=htmlentities($_POST['id']);
	$inputpassword = htmlentities($_POST['inputpassword']);
	$confirmpassword = htmlentities($_POST['confirmpassword']);

	if ($inputpassword == $confirmpassword){
		$inputpassword= password_hash($inputpassword, PASSWORD_DEFAULT); //cryptage password
		$updrequete=$bdd->prepare("UPDATE membres SET password = :inputpassword where id = :idmember");
		$updrequete->bindParam('inputpassword', $inputpassword, PDO::PARAM_STR);
		$updrequete->bindParam('idmember', $idmember, PDO::PARAM_STR);
		if ($updrequete->execute()){
			$erreur="no_errors";
			$msg="Votre mot de passe a bien été initialisé. Vous pouvez vous connecter en retournant au site";
		}
		else
			$erreur='Erreur technique 001'; //impossible d'executer la requête UPDATE
	}
	else
		$erreur ="Les deux mot de passe ne sont pas identiques";
}
else 
	$erreur='Veuillez saisir tous les champs obligatoires';

$msg .= error_get_last()['message'];

$renvoi[0]=$erreur;
$renvoi[1]=$msg;

echo json_encode($renvoi);
return;
?>
