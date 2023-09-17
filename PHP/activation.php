<?php
$erreur =""; 
$msg="";
// Connexion à la base de données
require('config.php');
 
if (isset($_GET['username']) && isset($_GET['cle'])){
	$username = htmlentities($_GET['username']);
	$cle = htmlentities($_GET['cle']);
	$actif=0;

	$stmt = $bdd->prepare("SELECT * FROM membres WHERE username = :username AND cle = :cle");
	$stmt->bindParam('username', $username, PDO::PARAM_STR);
	$stmt->bindParam('cle', $cle, PDO::PARAM_STR);

	if ($stmt->execute()) {
		$nbrows=$stmt->rowCount();
		if ($nbrows == 1) {
			$row = $stmt->fetch();
			$idmembre = $row['id'];
			$username = $row['username'];
			$clebdd = $row['cle'];
			$actif = $row['actif'];

			if($actif==0) {
				$stmt =$bdd->prepare("UPDATE membres SET actif = 1 WHERE id = :idmembre");
				$stmt->bindParam(':idmembre', $idmembre);
				if ($stmt->execute()) {
				  	$erreur="no_errors";
				  	$msg = "Votre acompte a été activé avec succès. Vous pouvez vous connecter pour accéder aux annonces";
				}
				else
					$erreur='Erreur technique 002'; //impossible d'executer la requête
			}
			elseif ($actif==1) {
				$erreur = "no_errors";
				$msg = "Ce compte a déjà été activé. Connectez-vous pour accéder aux annonces.";
			}
			else
				$erreur='Erreur technique 000'; //Erreur : On trouve un champ actif différent de 0 et de 1
		}
		elseif ($nbrows ==0 )
			$erreur="Impossible d'activer le compte : Le compte n'existe pas ou le lien est trop ancien";
		else
			$erreur='Erreur technique 003'; //Erreur : On trouve plusieurs enregistrements
	}
	else 
		$erreur='Erreur technique 002'; //impossible d'executer la requête
}
else
	$erreur="Erreur inconnue";
?><!DOCTYPE html>
<html lang="en">
<head>
	<!-- basic -->
	<meta charset="utf-8">
	<!-- mobile metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- site metas -->
	<title>Bouche@Oreille</title>

	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<!-- Tweaks for older IEs-->
	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   	<!-- style css -->
		<link rel="stylesheet" href="css/sk-style.css">
</head>

<!-- body -->
<body>
	<!-- Header-->
	<nav class="navbar navbar-dark sk-navbar bg-faded">
	  <div class="nav navbar-nav mx-auto">
		<a class="nav-item nav-link" href="index.php" aria-label="Bouche@Oreille"><?php include("svg/logo.svg"); ?></a>
	  </div>
	</nav>
	<!-- end Header-->

	<section class="container margin-r-l" id="messagesection"><div class="row">';
	<?php
	if ($erreur=="no_errors") {
		echo '<div class="col-md-12 text-center" id="success_msg"><p>'.$msg.'</p></div>';
		echo '<div class="col-md-12 text-center"><a type="button" class="btn btn-sk-primary" href="login.php">Se connecter</a></div>';
	}
	else {
		echo '<div class="col-md-12 error text-center" id="error_msg"><p>'.$erreur.'</p></div>';
		echo '<div class="col-md-12 text-center"><a type="button" class="btn btn-sk-primary" href="index.php">Retour à l\'accueil</a></div>';
	}
	?>
</div></section>';
</body>
</html>