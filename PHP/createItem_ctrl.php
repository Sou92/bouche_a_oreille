<?php
session_start();
if(!isset($_SESSION['username'])) {
	//Client non connecté => Renvoi vers site public
    header ('Location: index.php');
    exit();
}
else {
	//Client non connecté => Enregister Item
	$errs = array();
	$erreur="";
	$msg="";

	ini_set('display_errors','off');
	require('config.php');

//	ini_set('display_errors','off');
	require('config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") { 	// Vérifier si le formulaire a été soumis
		if(isset($_POST['titre']) && isset($_POST['description'])) {
			//lire les données du formulaire
			$idmembre=$_SESSION['idmembre'];
			$idville=$_POST["ville"];
			$idservice=$_POST["service"];
			$titre=htmlentities($_POST["titre"]);
			$description=htmlentities($_POST["description"]);
			$filename1=NULL;
			$filename2=NULL;
			//Vérifie si le fichier a été uploadé sans erreur.
			$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$maxsize = 1 * 1024 * 1024;
		
			//vérifier les données du formulaire
			if (empty($titre))
				$errs["titre"][]="Le titre ne peut pas être vide";
			
			if (empty($description))
				$errs["description"][]="La description ne peut pas être vide";

			if(isset($_FILES["photo1"]) && $_FILES["photo1"]["error"] == 0) {
				$filename1 = $_FILES["photo1"]["name"];
				$filetype1 = $_FILES["photo1"]["type"];
				$filesize1 = $_FILES["photo1"]["size"]/1024;
				$filetmpname1= $_FILES["photo1"]["tmp_name"];
				// Vérifie l'extension du fichier
				$ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
				if(array_key_exists($ext1, $allowed)){
					// Vérifie la taille du fichier - 1Mo maximum
					if($filesize1 > $maxsize) 
						$errs["photo1"][]="La taille du fichier est supérieure à la limite autorisée.";
				}
				else
					$errs["photo1"][]=$ext1." est un format invalide.Veuillez sélectionner un format de fichier valide.";
			}
				
			if(isset($_FILES["photo2"]) && $_FILES["photo2"]["error"] == 0) {
				$filename2 = $_FILES["photo2"]["name"];
				$filetype2 = $_FILES["photo2"]["type"];
				$filesize2 = $_FILES["photo2"]["size"]/1024;
				$filetmpname2= $_FILES["photo2"]["tmp_name"];
				// Vérifie l'extension du fichier

				$ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
				if(array_key_exists($ext2, $allowed)){
					// Vérifie la taille du fichier - 1Mo maximum
					if($filesize2 > $maxsize) 
						$errs["photo2"][]="La taille du fichier est supérieure à la limite autorisée.";
				}
				else
					$errs["photo2"][]=$ext2." est un format invalide. Veuillez sélectionner un format de fichier valide.";
			}

			if (count($errs) == 0){
				$prep_req_annonce = $bdd->prepare('INSERT into annonces(idmembre, titre, description, idservice, idville, srcimage1, srcimage2)
				VALUES(:idmembre, :titre, :description, :idservice, :idville, :srcimage1, :srcimage2)');
				$prep_req_annonce->bindValue(':idmembre', $idmembre, PDO::PARAM_INT);
				$prep_req_annonce->bindValue(':titre', $titre, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':description', $description, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':idservice', $idservice, PDO::PARAM_INT);
				$prep_req_annonce->bindValue(':idville', $idville, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':srcimage1', $filename1, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':srcimage2', $filename2, PDO::PARAM_STR);
				//print_r($prep_req_annonce);
				if ($prep_req_annonce->execute()) {
					$idannonce=$bdd->lastInsertId();
					$erreur="no_errors";

					$destfilename = 'membres/'.$idmembre.'/images/'.$idannonce;
					if (mkdir($destfilename, 0700, true)){

						if($filename1 != NULL) {
							if(!move_uploaded_file($filetmpname1, $destfilename.'/'.$filename1))
								$errs["serveur"][]="Votre annonce a été enregistré avec des erreurs : Impossible d'enregister l'image 1";
						}
						
						if($filename2 != NULL) {
							if(!move_uploaded_file($filetmpname2, $destfilename.'/'.$filename2))
								$errs["serveur"][]="Votre annonce a été enregistré avec des erreurs : Impossible d'enregister l'image 2";
						}
					}
					else
						$errs["serveur"][]="Impossible de créer le répertoire de destination";
				}
				else
					$errs='Erreur technique 001'; //impossible d'executer la requête 
			}
			else
				$errs="fom_errors";

			if ($erreur=="no_errors"){
				$msg='<p>Bonjour,	<strong>'.$_SESSION['username'].'</p></strong>
				<p>Votre annonce est en cours de traitement.
				<p>Une fois validée, vous recevrez un email de confirmation</p></strong>
				<p>Merci d\'avoir choisi <strong>"LE BOUCHE @ OREILLE"</strong></p>
				<p>A bientôt !</>
				<p>L\'équipe "Le Bouche @ Oreille"</p>
				<a class="logo-site" href="index.html"> <img src="" alt="accueil"></a>';
			}
			else {
				$erreur ='Oups ! une erreur empêche la prise en compte de votre demande'.implode("'br",$errs);
			}
		}
	}

	$msg .= error_get_last()['message'];

	$renvoi[0]=$erreur;
	$renvoi[1]=$msg;

//	print_r("<br>erreur:".$renvoi[0]);
//	print_r("<br>msg :".$renvoi[1]);
//	echo "Erreur=".$erreur;
//	print_r($errs);
	echo json_encode($renvoi);
//	return;
}
?>