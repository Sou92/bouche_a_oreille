<?php
session_start();
if(!isset($_SESSION['username'])) {
//        echo "vous n'êtes pas connecté";
        header ('Location: login.php');
        exit();
    }
else {
  //Membre connecté : Accès à l'espace memebre
  // on teste si notre paramètre existe bien et qu'il n'est pas vide
  if (!isset($_GET['id']) || empty($_GET['idmembre'])) {
    echo 'Aucun message reconnu.';
  }
  else{
    $idannonce=$_GET['id'];
    $recever=$_GET['idmembre'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

<body>

  <section class="container marrgin-r-l" style="text-align: center;">
    <h1>Page Détail de l'annonce Bouche@Oreille</h1>
    <div class="row">
      </div class="col-md8">
        <h1>Ici le détail de l'annonce </h1>
      </div>
      </div class="col-md-4">
        <form role="form" method="post" id="registerform" action="envoyer.php">
          <hr class="solid" value="test">
            <legend>Contacter membre</legend>
            <div class="form-group">
             <textarea name="message" id="message" class="form-control" rows="4" maxlength="300" placeholder="Description" required></textarea>
               <!-- Error -->
                <div class="help-block with-errors"></div>
                </div>
                <input type="hidden" value=<?php echo $idannonce ?>  name="idannonce" />
                <input type="hidden" value=<?php echo $recever ?> name="recever" />
          <div class="col-md-12 text-center">
              <button type="submit" id="contacter" value="contacter" class="btn btn-sk-primary btn-block">Envoyer</button>
          </div>
        </form>
      </div>
    </div>

  </section>

<?php echo $_GET['id'];
echo $_GET['idmembre'];
?>
<!-- footer -->
<?php include("p-footer.php");?>
<!-- end footer -->

<!-- Javascript files--> 
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

</body>
</html>
<?php
}
}
?>