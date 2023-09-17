<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mot de passe oublié</title>
<link rel="canonical" href="https://icons.getbootstrap.com/">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<!-- style css -->
<link rel="stylesheet" href="css/sk-style.css">

</head>

<style type="text/css">

#mdpoubliesection
{
	align-content: center;
	text-align: center;
	max-width: 450px;*/
}

</style>
<body>

<section class="container margin-r-l" id="messagesection">
	<div class="row">
		<div class="col-md-12 text-center" id="success_msg">
		</div>
		<div class="col-md-12 error text-center" id="error_msg">
		</div>
		<div class="col-md-12 text-center" id="return_btn">
	   		<a type="button" class="btn btn-primary" href="index.php">Retour à l'accueil</a>
		</div>
	</div>
</section>

<section class="container marrgin-r-l" id="mdpoubliesection">
    <div class="row">
        <div class="boxform col">
			<div class="navbar-dark sk-navbar">
				<a class="navbar-brand mr-0 mr-md-2" href="index.php" aria-label="Bouche@Oreille">
					<?php include("svg/logo.svg"); ?> 
				</a>
			</div>
        	<div>
				<form role="form" method="post" id="mdpoublieform" action="mdpoublie_ctrl.php">
					<hr class="solid" value="test">
			      	<h5>Demander un nouveau mot de passe</h5>
			      	<div class="form-group">
			        	<label for="email">Saisissez l'adresse email associée à votre compte Bouche@Oreille</label>
			        	<input type="email" class="form-control" id="email" name="email" placeholder="Email*" maxlength="50"required>
			            <!-- Error -->
			            <div class="help-block with-errors"></div>
			      	</div>
					<div class="col-md-12 text-center">
					    <button type="submit" id="initmdp" value="Envoyer" class="btn btn-sk-primary btn-block">Envoyer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script type="text/javascript">

$("#error_msg").empty();
$("#success_msg").empty();
$("#return_btn").hide();

// Document is ready 
$(document).ready(function () {

$('#mdpoublieform').validator();

$("#mdpoublieform").on('keyup','INPUT' ,function(e){
	e.preventDefault();
	$("#error_msg").empty();
});

$('#mdpoublieform').validator().on('submit', function (e) {
	console.log("submit");
	if (e.isDefaultPrevented()) {
    	// handle the invalid form...
    	console.log("passage1");
	} 
	else
	{
	    // everything looks good!
    	console.log("passage2");
	    e.preventDefault();
		BtnLoading('button:submit');
		var $form = $(this);
		$.ajax({
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			dataType: "json",
			success: function(data) {
				console.log(data);
				if (data[0]=="no_errors"){
					console.log(data[1]);
					$("#success_msg").empty();
					$("#success_msg").append(data[1]);
					$("#mdpoubliesection").hide();
					$("#return_btn").show();
				}
				else {
					console.log(data[0]);
					$("#error_msg").empty();
					$("#error_msg").append(data[0]);
				}
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
	            console.log("erreur");
	            console.log(XMLHttpRequest.responseText);
				$("#error_msg").empty();
				$("#error_msg").append(XMLHttpRequest.responseText);
            },
			complete : function(resultat, statut, erreur){
					console.log("complete");
					BtnReset('button:submit');
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