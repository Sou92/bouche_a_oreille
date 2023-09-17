<!DOCTYPE html>
<html lang="fr">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Inscription sur le Bouche@Oreille</title>
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

<style type="text/css">

#registersection
{
	align-content: center;
	text-align: center;
	max-width: 450px;
}

</style>
<body>

<section class="container margin-r-l" id="messagesection">
	<div class="row">
		<div class="col-md-12 text-center" id="register_success">
		</div>
		<div class="col-md-12 error text-center" id="register_err">
		</div>
		<div class="col-md-12 text-center" id="return_btn">
	   		<a type="button" class="btn btn-primary" href="index.php">Retour à l'accueil</a>
		</div>
	</div>
</section>

<!--Registersection -->
<section class="container marrgin-r-l" id="registersection" >
    <div class="row">
        <div class="boxform col">
			<div class="navbar-dark sk-navbar">
				<a class="navbar-brand mr-0 mr-md-2" href="index.php" aria-label="Bouche@Oreille">
					<?php include("svg/logo.svg"); ?> 
				</a>
			</div>
        	<div>
				<form role="form" method="post" id="registerform" action="register_ctrl.php">
					<hr class="solid" value="test">
			      	<legend>Devenir membre</legend>
			      	<div class="form-group">
			        	<input type="email" class="form-control" id="email" name="email" placeholder="Email*" maxlength="50"required>
			            <!-- Error -->
			            <div class="help-block with-errors"></div>
			      	</div>
			      	<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" data-minlength="8" data-error="Saisissez au moins 8 caractères" placeholder="Mot de passe*" maxlength="20" required>
			            <!-- Error -->
			            <div class="help-block with-errors"></div>
					</div>
			      	<div class="form-group">
						<input type="text" class="form-control" id="username" name="username" data-minlength="5" data-error="Saisissez au moins 5 caractères" placeholder="Nom d'utilisateur*" maxlength="20" required/>
			            <!-- Error -->
			            <div class="help-block with-errors"></div>
					</div>
					<small>En cliquant sur S’inscrire, vous acceptez nos Conditions générales. Découvrez comment nous recueillons, utilisons et partageons vos données en lisant notre Politique d’utilisation des données et comment nous utilisons les cookies et autres technologies similaires en consultant notre Politique d’utilisation des cookies. Vous recevrez peut-être des notifications par texto de notre part et vous pouvez à tout moment vous désabonner.
					</small>
					<div class="col-md-12 text-center">
					    <button type="submit" id="inscription" value="Inscription" class="btn btn-sk-primary btn-block">S'inscrire</button>
					</div>
				</form>
				<hr class="solid" value="test">
				<p>Vous avez déjà un compte ?</p>
				<div class="col-md-12 ">
					<button type="submit" onclick="document.location.href='index.php#loginsection'" class="btn btn-secondary btn-block" id="connexion">Connexion</button>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Registersection -->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script type="text/javascript">

$("#register_err").empty();
$("#register_success").empty();
$("#return_btn").hide();

// Document is ready 
$(document).ready(function () {

$('#registerform').validator();

$("#registerform").on('keyup','INPUT' ,function(e){
	e.preventDefault();
	$("#register_err").empty();
});

$('#registerform').validator().on('submit', function (e) {
	console.log("submit");
	if (e.isDefaultPrevented()) {
    	// handle the invalid form...
    	console.log("passage1");
	} 
	else
	{
	    // everything looks good!
	    e.preventDefault();
		BtnLoading('#inscription');
		var $form = $(this);
		$.ajax({
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			dataType: "json",
			success: function(data) {
				console.log("sucess");
				if (data[0]=="no_errors"){
					$("#register_success").empty();
					$("#register_success").append(data[1]);
					$("#registersection").hide();
					$("#return_btn").show();
				}
				else {
					$("#register_err").empty();
					$("#register_err").append(data[1]);
				}
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
	            console.log("erreur");
				$("#register_err").empty();
				$("#register_err").append(XMLHttpRequest.responseText);
            },
			complete : function(resultat, statut, erreur){
					console.log("complete");
					BtnReset('#inscription');
			}
		});
	}
})

});

function BtnLoading(elem) {
    $(elem).attr("data-original-text", $(elem).html());
    $(elem).prop("disabled", true);
    $(elem).html('<i class="spinner-border spinner-border-sm"></i> Loading...');
}

function BtnReset(elem) {
    $(elem).prop("disabled", false);
    $(elem).html($(elem).attr("data-original-text"));
}

</script>
</body>
</html>