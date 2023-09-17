<?php
session_start();
if(!isset($_SESSION['username'])) {
//        echo "vous n'êtes pas connecté";
        header ('Location: index.php');
        exit();
    }
else {
//Membre connecté : charger la page
?><!DOCTYPE html>
<html lang="en">
<head>
  <!-- basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- mobile metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">
  <!-- site metas -->
  <title>Déposer une annonce sur le Bouche@Oreille</title>

  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-grid.min.css">
  <!-- Tweaks for older IEs-->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

  <!-- style css -->
  <link rel="stylesheet" href="css/sk-style.css">

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
  <script src="js/mycustom.js"></script>
</head>

<body>
  <!-- loader  -->
  <div class="loader_bg">
    <div class="loader"><img src="images/loading.gif" alt="#" /></div>
  </div>
  <!-- end loader --> 

	<nav class="navbar navbar-expand-lg navbar-dark member-navbar">
	  <?php include("p-header.php"); ?>
	  <ul class="navbar-nav my-2 my-lg-0">
	    <li class="nav-item">
	      <a title="deposer une annonce" class="nav-link" href="createitem.php">
	        <div align="center">
	          <svg class="svg-icon" viewBox="0 0 20 20">
	            <path d="M17.33 10.67h-4v-4a1.33 1.33 0 10-2.66 0v4h-4a1.33 1.33 0 100 2.66h4v4a1.33 1.33 0 102.66 0v-4h4a1.33 1.33 0 100-2.66z"></path>
	            <path d="M21.6 0H2.4A2.41 2.41 0 000 2.4v19.2A2.41 2.41 0 002.4 24h19.2a2.41 2.41 0 002.4-2.4V2.4A2.41 2.41 0 0021.6 0zm0 20.4a1.2 1.2 0 01-1.2 1.2H3.6a1.2 1.2 0 01-1.2-1.2V3.6a1.2 1.2 0 011.2-1.2h16.8a1.2 1.2 0 011.2 1.2v16.8z">
	            </path>
	          </svg>
	          <br><span data-text="Deposer une annonce" data-reactid="48">Deposer une annonce</span>
	        </div>
	      </a>
	    </li>
	    <li class="nav-item">
	      <a title="Mon compte" class="nav-link" href="/mon-compte">
	        <div align="center">
	          <svg class="svg-icon" viewBox="0 0 20 20">
	              <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
	          </svg>
	          <br><span data-text="Compte" data-reactid="48"><?php echo $_SESSION['username'];?></span>
	        </div>
	      </a>
	    </li>
	    <li class="nav-item">
	      <a title="Mes messages" class="nav-link" href="/mes-messages">
	        <div align="center">
	          <svg class="svg-icon" viewBox="0 0 20 20">
	            <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
	          </svg>
	          <br><span data-text="Messages" data-reactid="48">Messages</span>
	        </div>
	      </a>
	    </li>
	    <li class="nav-item">
	      <a title="Mes favoris"  class="nav-link" href="/mes-favoris">
	        <div align="center">
	          <svg class="svg-icon" viewBox="0 0 20 20">
	            <path d="M9.719,17.073l-6.562-6.51c-0.27-0.268-0.504-0.567-0.696-0.888C1.385,7.89,1.67,5.613,3.155,4.14c0.864-0.856,2.012-1.329,3.233-1.329c1.924,0,3.115,1.12,3.612,1.752c0.499-0.634,1.689-1.752,3.612-1.752c1.221,0,2.369,0.472,3.233,1.329c1.484,1.473,1.771,3.75,0.693,5.537c-0.19,0.32-0.425,0.618-0.695,0.887l-6.562,6.51C10.125,17.229,9.875,17.229,9.719,17.073 M6.388,3.61C5.379,3.61,4.431,4,3.717,4.707C2.495,5.92,2.259,7.794,3.145,9.265c0.158,0.265,0.351,0.51,0.574,0.731L10,16.228l6.281-6.232c0.224-0.221,0.416-0.466,0.573-0.729c0.887-1.472,0.651-3.346-0.571-4.56C15.57,4,14.621,3.61,13.612,3.61c-1.43,0-2.639,0.786-3.268,1.863c-0.154,0.264-0.536,0.264-0.69,0C9.029,4.397,7.82,3.61,6.388,3.61"></path>
	          </svg>
	          <br><span data-text="Favoris" data-reactid="48">Favoris</span>
	        </div>
	      </a>
	    </li>
	  </ul>
	  <a class="btn btn-dark" href="logout.php" role="button">Déconnexion</a>
	</nav>
	<!-- End header-->

<body>

	<section class="container marrgin-r-l" style="text-align: center;">
		<h1>Déposez votre annonce sur le Bouche@Oreille</h1>
	</section>

	<section class="container margin-r-l" id="messagesection">
		<div class="row">
			<div class="col-md-12 text-center" id="create_success">
			</div>
			<div class="col-md-12 error text-center" id="create_err">
			</div>
		</div>
	</section>

	<!-- Depot section -->
	<section class="container marrgin-r-l" id="createitemsection">
	  <form method="post" action="createitem_ctrl.php" enctype="multipart/form-data" >
	    <div class="form-row">
	      <div class="form-group col-md-6">
	        <SELECT class="form-control" name="service" id="service_list">
	          <optgroup value="0">
	             <option selected="" value="0">Choisissez un service</option>
	          </optgroup>
	          <?php include("initservices.php");?>
	        </SELECT>
	      </div>
	      <div class="form-group col-md-6">
	        <SELECT class="form-control" name="ville" id="ville_list">
	          <option selected value="0">Choisissez une ville--</option>
	          <?php include("initvilles.php");?>
	        </SELECT>
	      </div>
	    </div>
	    <div class="form-row">
	      <div class="form-group col-md-12">
	        <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre" required>
	          <!-- Error -->
	        <div class="help-block with-errors"></div>
	      </div>
	    </div>
	    <div class="form-row">
	      <div class="form-group col-md-12">
	        <textarea name="description" id="description" class="form-control" rows="4" maxlength="300" placeholder="Description" required></textarea>
	        <!-- Error -->
	        <div class="help-block with-errors"></div>
	      </div>
	    </div>
	    <div class="form-row">
	      <div class="form-group col-md-12">
	        <small>Mettez en valeur votre annonce en y ajoutant des photos (.jpg, .jpeg, .jpeg, .gif, .png et taille maximale 5 Mo).</small>
	      </div>
	    </div>
	    <div class="form-row">
	      <div class="form-group col-md-6">
	        <div class="preview-zone hidden">
	          <div class="box box-solid">
	            <div class="box-header with-border">
	              <div><b>Image 1</b></div>
	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-danger btn-xs remove-preview">
	                  <i class="fa fa-times"></i> Effacer
	                </button>
	              </div>
	            </div>
	            <div class="box-body"></div>
	          </div>
	        </div>
	        <div class="dropzone-wrapper">
	          <div class="dropzone-desc">
	            <i class="glyphicon glyphicon-download-alt"></i>
	            <small>Choisissez ou faites glisser une image ici.<br> Format accepté : jpg, jpeg, jpeg, png<br>Taille maximale : 5 Mo.</small>
	          </div>
	          <input type="file" name="photo1" class="dropzone">
	        </div>
	      </div>
	      <div class="form-group col-md-6">
	        <div class="preview-zone hidden">
	          <div class="box box-solid">
	            <div class="box-header with-border">
	              <div><b>Image 2</b></div>
	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-danger btn-xs remove-preview">
	                  <i class="fa fa-times"></i> Effacer
	                </button>
	              </div>
	            </div>
	            <div class="box-body"></div>
	          </div>
	        </div>
	        <div class="dropzone-wrapper">
	          <div class="dropzone-desc">
	            <i class="glyphicon glyphicon-download-alt"></i>
	            <span>Choisissez ou faites glisser une image ici.<br> Format accepté : jpg, jpeg, jpeg, png<br>Taille maximale : 5 Mo.</span>
	          </div>
	          <input type="file" name="photo2" class="dropzone">
	        </div>
	      </div>
	    </div>
	    <div class="form-row">
	      <div class="col text-center">
	        <input class="btn btn-primary" name="envoyer" type="submit" value="Envoyer">
	      </div>
	    </div>
	  </form>
	</section>
	<!-- End Depot section -->

	<!-- footer -->
	<?php include("p-footer.php");?>
	<!-- end footer -->

<!-- Javascript files--> 
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

<script src="js/plugin.js"></script> 
<script src="js/custom.js"></script>

<script type="text/javascript">
// Document is ready 
$(document).ready(function () {
    $("#but_upload").click(function(){

        var fd = new FormData();
        var files = $('#file')[0].files;
        
        // Check file selected or not
        if(files.length > 0 ){
           fd.append('file',files[0]);

           $.ajax({
              url: 'upload.php',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                 if(response != 0){
                    $("#img").attr("src",response); 
                    $(".preview img").show(); // Display image element
                 }else{
                    alert('file not uploaded');
                 }
              },
           });
        }else{
           alert("Please select a file.");
        }
    });
});

</script>

<script type="text/javascript">
  // Code By Webdevtrick ( https://webdevtrick.com )
function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
 
    reader.onload = function(e) {
      var htmlPreview =
        '<img width="200" src="' + e.target.result + '" />' +
        '<p>' + input.files[0].name + '</p>';
      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');
 
      wrapperZone.removeClass('dragover');
      previewZone.removeClass('hidden');
      boxZone.empty();
      boxZone.append(htmlPreview);
    };
 
    reader.readAsDataURL(input.files[0]);
  }
}
 
function reset(e) {
  e.wrap('<form>').closest('form').get(0).reset();
  e.unwrap();
}
 
$(".dropzone").change(function() {
  readFile(this);
});
 
$('.dropzone-wrapper').on('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).addClass('dragover');
});
 
$('.dropzone-wrapper').on('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});
 
$('.remove-preview').on('click', function() {
  var boxZone = $(this).parents('.preview-zone').find('.box-body');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
});
</script>

</body>
</html>
<?php
}
?>