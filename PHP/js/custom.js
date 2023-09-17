/*---------------------------------------------------------------------
    File Name: custom.js
---------------------------------------------------------------------*/

$(function () {

	"use strict";

	/* Preloader
	-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */

	setTimeout(function () {
		$('.loader_bg').fadeToggle();
	}, 1500);

	function BtnLoading(elem) {
		console.log("BtnLoading");
	    $(elem).attr("data-original-text", $(elem).html());
	    $(elem).prop("disabled", true);
	    $(elem).html('<i class="spinner-border spinner-border-sm"></i> Loading...');
	};

	function BtnReset(elem) {
		console.log("BtnReset");

	    $(elem).prop("disabled", false);
	    $(elem).html($(elem).attr("data-original-text"));
	};

	/* Contact-form
	-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */
	$.validator.setDefaults({
		submitHandler: function () {
			alert("submitted!");
		}
	});

	$(document).ready(function () {

	    $("#searchsection").on('change','INPUT, SELECT' ,function(e){
	      e.preventDefault();
	      var service= $("#listeservice").val();
	      var ville= $("#listeville").val();
	      console.log('change sur #rechercheannonce:'+'service:'+service+'ville:'+ville);
	       $.ajax({
	        type:"POST",
	          url: "getnbannonces.php",
	          data: {ville: ville, service: service},
	          success:function(html){
	          console.log('Fin de traiement formulaire');
	          //$("#rechercheannonce").val(html);
	          $("#rechercheannonce").text(html);
	          }
	      })
	    });

	    $("#searchform").on('submit', function(e){
	    	e.preventDefault();
			BtnLoading('#rechercheannonce');
			var $form = $(this);
			console.log('submit#searchform:'+$form.serialize());
			$.ajax({
		        type:"POST",
				//url: "find.php",
				url: $form.attr('action'),
				data: $form.serialize(),
				success:function(html){
				console.log('success');
				$("#resultsection").empty();
				$("#resultsection").append(html);
				$("#resultsection").show();
				},
		        error: function(XMLHttpRequest, textStatus, errorThrown) {
		            console.log("erreur");
		            console.log(XMLHttpRequest);
		            console.log(textStatus);
		            console.log(errorThrown);
					$("#error_msg").empty();
					$("#error_msg").append(XMLHttpRequest.responseText);
		        },
				complete : function(resultat, statut, erreur){
					console.log("complete");
					BtnReset('#rechercheannonce');
				}
			})
	    });


		$('#loginform').validator();

		$("#loginform").on('keyup','INPUT' ,function(e){
			console.log("keyup");
			e.preventDefault();
			$("#login_err").empty();
		});

		$('#loginform').validator().on('submit', function (e) {
			console.log("submit");
			if (e.isDefaultPrevented()) {
		    	// handle the invalid form...
		    	console.log("passage1");
			} 
			else
			{
			    // everything looks good!
			    e.preventDefault();
				BtnLoading('#connexion');
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
							$("#login_err").empty();
							$("#login_err").append(data[0]);
						}
					},
		            error: function(XMLHttpRequest, textStatus, errorThrown) {
			            console.log("erreur");
			            console.log(XMLHttpRequest.responseText);
						$("login_err").empty();
						$("login_err").append(XMLHttpRequest.responseText);
		            },
					complete : function(resultat, statut, erreur){
							console.log("complete");
							BtnReset('#connexion');
					}
				});
			}
		})

		$("#contact-form").validate({
			rules: {
				firstname: "required",
				email: {
					required: true,
					email: true
				},
				lastname: "required",
				message: "required",
				agree: "required"
			},
			messages: {
				firstname: "Please enter your firstname",
				email: "Please enter a valid email address",
				lastname: "Please enter your lastname",
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				message: "Please enter your Message",
				agree: "Please accept our policy"
			},
			errorElement: "div",
			errorPlacement: function (error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");

				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.parent("input"));
				} else {
					error.insertAfter(element);
				}
			},
			highlight: function (element, errorClass, validClass) {
				$(element).parents(".col-md-4, .col-md-12").addClass("has-error").removeClass("has-success");
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).parents(".col-md-4, .col-md-12").addClass("has-success").removeClass("has-error");
			}
		});
	});


});
