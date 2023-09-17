<?php
session_start();
if(!isset($_SESSION['username'])) {
//      Client non connecté => Ne pas autoriser
        header ('Location: index.php');
        exit();
}
else {
//	echo "je rentre dan enregistrerannonce";

	if($_SERVER["REQUEST_METHOD"] == "POST") { 	// Vérifier si le formulaire a été soumis
//		print_r($_FILES);
		// Vérifie si le fichier a été uploadé sans erreur.
		if(isset($_FILES["photo1"]) && $_FILES["photo1"]["error"] == 0) {
			$allowed1 = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$filename1 = $_FILES["photo1"]["name"];
			$filetype1 = $_FILES["photo1"]["type"];
			$filesize1 = $_FILES["photo1"]["size"];

			// Vérifie l'extension du fichier
			$ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
			if(!array_key_exists($ext1, $allowed1)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

			// Vérifie la taille du fichier - 5Mo maximum
			$maxsize = 5 * 1024 * 1024;
			if($filesize1 > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

			// Vérifie le type MIME du fichier
			if(in_array($filetype1, $allowed1)){
				// Vérifie si le fichier existe avant de le télécharger.
				if(file_exists('./TEMP/membres/'.$id.'/images/' . $_FILES["photo1"]["name"])) {
					echo $_FILES["photo1"]["name"] . " existe déjà.";
				} 
				else{
					move_uploaded_file($_FILES["photo1"]["tmp_name"], 'TEMP/membres/'.$id.'/images/' . $_FILES["photo1"]["name"]);
					echo "Votre fichier a été téléchargé avec succès.";
				} 
			} 
			else{
				echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
			}
		} 
		else {
			echo "Error: " . $_FILES["photo1"]["error"];
		}
		if(isset($_FILES["photo2"]) && $_FILES["photo2"]["error"] == 0){
			$allowed2 = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$filename2 = $_FILES["photo2"]["name"];
			$filetype2 = $_FILES["photo2"]["type"];
			$filesize2 = $_FILES["photo2"]["size"];

			// Vérifie l'extension du fichier
			$ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
			if(!array_key_exists($ext2, $allowed2)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

			// Vérifie la taille du fichier - 5Mo maximum
			$maxsize = 5 * 1024 * 1024;
			if($filesize2 > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
            $id=$_POST["service"];
			// Vérifie le type MIME du fichier
			if(in_array($filetype2, $allowed2)) {
				$chemin=realpath('.');
				echo $chemin;
				// Vérifie si le fichier existe avant de le télécharger.
				if(file_exists('./TEMP/membres'.$id.'/images/' . $_FILES["photo2"]["name"])) {
					echo $_FILES["photo2"]["name"] . " existe déjà.";
				} 
				else {
					move_uploaded_file($_FILES["photo2"]["tmp_name"], './TEMP/membres/'.$id.'/images/'. $_FILES["photo2"]["name"]);
					echo "Votre fichier a été téléchargé avec succès.";
				} 
			} 
			else {
				echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
			}
		} 
		else {
			echo "Error: " . $_FILES["photo2"]["error"];
		}

		require('config.php');
		$idmembre=$_SESSION['idmembre'];
		echo $idmembre;
		$idville=$_POST["ville"];
		$idservice=$_POST["service"];
		$titre=$_POST["titre"];
		$description=$_POST["description"];
		//$srcimage=$_POST["photo"];
		$srcimage1=$filename1;
		$srcimage2=$filename2;
		/*$prep_req_ville = $bdd->prepare('SELECT id FROM REF_VILLES WHERE nom=:nom');
		$prep_req_ville->bindValue(':nom', $ville, PDO::PARAM_STR);*/
				
		/*if($prep_req_ville->execute()) {
			echo "je rentre dan enregistrerannonce aprés execute";
			echo '<br>';
			print_r($prep_req_ville);
			echo 'ville='.$ville;
			echo '<br>';

			if ($data_ville=$prep_req_ville->fetch()) {
				echo "je rentre dan enregistrerannonce aprés le fetch";
				$idville=$data_ville["id"];*/
				$prep_req_annonce = $bdd->prepare('INSERT into annonces(idmembre, titre, description, idservice, idville, srcimage1, srcimage2)
				VALUES(:idmembre, :titre, :description, :idservice, :idville, :srcimage1, :srcimage2)');
				$prep_req_annonce->bindValue(':idmembre', $idmembre, PDO::PARAM_INT);
				$prep_req_annonce->bindValue(':titre', $titre, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':description', $description, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':idservice', $idservice, PDO::PARAM_INT);
				$prep_req_annonce->bindValue(':idville', $idville, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':srcimage1', $srcimage1, PDO::PARAM_STR);
				$prep_req_annonce->bindValue(':srcimage2', $srcimage2, PDO::PARAM_STR);
				//$prep->execute() or die(print_r($bdd->errorInfo(), true)); // incorrect;
				echo '<br>';
				echo 'idmembre='.$idmembre;
				echo '<br>';
				echo 'titre='.$titre;
				echo '<br>';
				echo 'description='.$description;
				echo '<br>';
				echo 'idservice='.$idservice;
				echo '<br>';
				echo 'idville='.$idville;
				echo '<br>';
				echo 'srcimage1='.$srcimage1;
				echo '<br>';
				echo 'srcimage2='.$srcimage2;
					
				print_r($prep_req_annonce);
				if (!$prep_req_annonce->execute()) {
				  echo "Impossible de créer l'enregistrement";
				}
				else {
					$pre_req_pmembre = $bdd->prepare('SELECT * FROM MEMBRES WHERE :id');
					$pre_req_pmembre->bindValue(':id', $idmembre, PDO::PARAM_INT);

					if($pre_req_pmembre->execute() && $data_membre=$pre_req_pmembre->fetch()) {
						echo '<section>
						<p>Bonjour,	<strong>'.$data_membre['civilite'].' '.$data_membre['prenom'].' '.$data_membre['nom'].'</p></strong>
						<p>Votre annonce est en cours de traitement.
						<p>Une fois validée, vous recevrez un email de confirmation à l\'adresse <strong>'.$data_membre['email'].'</p></strong>
						<p>Merci d\'avoir choisi <strong>"LE BOUCHE @ OREILLE"</strong></p>
						<p>A bientôt !</>
						<p>L\'équipe "Le Bouche @ Oreille"</p>
						<a class="logo-site" href="index.html"> <img src="icone/boucheaoreille2.jpg" alt="accueil"></a>
						</section>';
					}
				} 
			//}
			/*else {
				echo "Service inéxistant";
			}*/
		//}
	}
}
?>