    <button type="button" class="btn btn-sk-primary" data-toggle="modal" data-target="#loginmodal">Connexion</button>


	<!--Loginmodal -->
	<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog " role="document">
		<div class="modal-content">
	  		<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Connexion</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">×</span>
	        	</button>
	    	</div>
	    	<div class="modal-body">
				<form role="form" data-toggle="validator" method="post" name="loginform" id="loginformmodal" action="login_ctrl.php">
	        		<div class="error" id="loginm_err"></div>
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
	            		<button type="submit" id="connexionm" value="Connexion" class="btn btn-sk-primary btn-block">Se connecter</button>
	        		</div>
	      		</form>
	      		<hr>Vous ne posssédez pas de compte ?</hr>
	      		<div class="form-group text-center">
	            	<button type="submit" onclick="document.location.href='register.php'" class="btn btn-secondary btn-block" id="inscription">Devenir membre</button>
	        	</div>
			</div>
			</div>
		</div>
	</div>
	<!--Loginmodal-->

<script type="text/javascript">

$("#loginm_err").empty();
$("#loginm_success").empty();

// Document is ready 
$(document).ready(function () {

$('#loginformmodal').validator();

$("#loginformmodal").on('keyup','INPUT' ,function(e){
	e.preventDefault();
	$("#loginm_err").empty();
});

$('#loginformmodal').validator().on('submit', function (e) {
	console.log("submit");
	if (e.isDefaultPrevented()) {
    	// handle the invalid form...
    	console.log("passage1");
	} 
	else
	{
	    // everything looks good!
	    e.preventDefault();
		BtnLoading('#connexionm');
		var $form = $(this);
		$.ajax({
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			dataType: "json",
			success: function(data) {
				console.log("sucess");
				if (data[0]=="no_errors"){
					console.log("Accès espace memebre")
					window.location.href="member.php";
				}
				else {
					$("#loginm_err").empty();
					$("#loginm_err").append(data[0]);
				}
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
	            console.log("erreur");
				$("#loginm_err").empty();
				$("#loginm_err").append(XMLHttpRequest.responseText);
            },
			complete : function(resultat, statut, erreur){
					console.log("complete");
					BtnReset('#connexionm');
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


/*	
// Document is ready 
$(document).ready(function () {

		$('#loginformmodal').validator();

		$("#loginformmodal").on('keyup','INPUT' ,function(e){
			console.log("keyup");
			e.preventDefault();
			$("#loginm_err").empty();
		});

		$('#loginformmodal').validator().on('submit', function (e) {
			console.log("submit");
			if (e.isDefaultPrevented()) {
		    	// handle the invalid form...
		    	console.log("passage1");
			} 
			else
			{
			    // everything looks good!
			    e.preventDefault();
//				BtnLoading('#connexion');
				var $form = $(this);
				$.ajax({
					type: 'POST',
					url: $form.attr('action'),
					data: $form.serialize(),
					dataType: "json",
					success: function(data) {
				    	console.log("success");
						if (data[0]=="no_errors"){
							console.log("Accès espace memebre")
							window.location.href="member.php";
						}
						else {
							$("#loginm_err").empty();
							$("#loginm_err").append(data[0]);
						}
					},
		            error: function(XMLHttpRequest, textStatus, errorThrown) {
			            console.log("erreur");
			            console.log(XMLHttpRequest.responseText);
						$("loginm_err").empty();
						$("loginm_err").append(XMLHttpRequest.responseText);
		            },
					complete : function(resultat, statut, erreur){
							console.log("complete");
//							BtnReset('#connexion');
					}
				});
			}
		})
});*/

</script>
