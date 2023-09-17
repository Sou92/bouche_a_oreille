<!DOCTYPE html>
<html lang="en">
<head>
	<!-- basic -->
	<meta charset="utf-8">
	<!-- mobile metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- site metas -->
	<title>Connexion au site Bouche@Oreille</title>

	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Bouche@Oreille">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<!-- Tweaks for older IEs-->
	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   	<!-- style css -->
	<link rel="stylesheet" href="css/sk-style.css">
</head>

<body>

<nav class="navbar navbar-dark sk-navbar bg-faded">
  <div class="nav navbar-nav mx-auto">
	<a class="nav-item nav-link" href="index.php" aria-label="Bouche@Oreille"><?php include("svg/logo.svg"); ?></a>
  </div>
</nav>

<section class="container margin-r-l" id="messagesection">
	<div class="row">
		<div class="col-md-12 text-center" id="login_success">
		</div>
		<div class="col-md-12 error text-center" id="login_err">
		</div>
	</div>
</section>

  <!--Login section -->
  <section class="container marrgin-r-l" id="loginsection">
    <h1>Connectez-vous pour accéder accéder à l'espace membre du Bouche@Oreille</h1>
      <div class="row">
        <div class="col-md-8"> 
        <div class="carousel" data-ride="carousel" id="carouselIndicators">
          <ol class="carousel-indicators">
            <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselIndicators" data-slide-to="1"></li>
            <li data-target="#carouselIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="vignette" src="images\banner1.png" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>C'est gratuit</h5>
              <p>Pour déposer ou consulter les annonces il vous suffit de créer un compte.</p>
            </div>
            </div>
            <div class="carousel-item">
              <img class="vignette" src="images\banner2.png" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>C'est simple</h5>
              <p>Recherchez, consulter et enregister les annonces qui vous intérèssent</p>
            </div>
            </div>
            <div class="carousel-item">
              <img class="vignette" src="images\banner3.png" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>C'est pratique</h5>
              <p>Vous bénéficiez des avis des autres membres du site sur les artisans avant de les contacter</p>
            </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="boxform" id="loginbox">
            <form role="form" method="post" id="loginform" action="login_ctrl.php">
                <legend>Connexion</legend>
                <hr class="solid" value="test">
                <div class="form-group">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email*" maxlength="50" required>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" data-minlength="8" data-error="Saisissez au moins 8 caractères" placeholder="Mot de passe*" maxlength="20" required>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
              <a href="mdpoublie.php">Mot de passe oublié ?</a>
            </div>
            <div class="form-group text-center">
                    <button type="submit" id="connexion" value="Connexion" class="btn btn-sk-primary btn-block">Se connecter</button>
            </div>
          </form>
          <hr>Vous ne posssédez pas de compte ?</hr>
          <div class="form-group text-center">
                <button type="submit" onclick="document.location.href='register.php'" class="btn btn-secondary btn-block" id="inscription">Devenir membre</button>
            </div>
        </div>
      </div>
      </div>
  </section>
  <!--Login section -->

<!-- Javascript files--> 
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

<script src="js/plugin.js"></script> 
<script src="js/custom.js"></script>

</body>
</html>