<?php
session_start();
if(!isset($_SESSION['username'])) {
//        echo "vous n'êtes pas connecté";
        header ('Location: index.php');
        exit();
    }
else {
//    echo 'Bonjour '.htmlentities(trim($_SESSION['username'])).'</h1>';
?>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bouche@Oreille</title>
<link rel="canonical" href="https://icons.getbootstrap.com/">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-grid.min.css">

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<style type="text/css">
/* Style pour le Header*/
  /* -----
  SVG Icons - svgicons.sparkk.fr
  ----- */

  .svg-icon {
    width: 1.5em;
    height: 1.5em;
  }

  .svg-icon path,
  .svg-icon polygon,
  .svg-icon rect {
    fill: white;
  }

  .svg-icon circle {
    stroke: white;
    stroke-width: 1;
  }

</style>

<style type="text/css">
/*Style pour la section de recherche*/
  #searchsection {
    padding: 30px;
      margin:120px auto;
    border-radius:4px;
    -webkit-box-shadow: -1px -1px 14px -1px #3d3c3c; 
    box-shadow: -1px -1px 14px -1px #3d3c3c;
    max-width: 800px;
  }

/*Style pour la section résultat de recherche*/
  #resultsection {
      margin:90px auto;
    max-width: 700px;
    min-width: 350;
  }

  .annonce {
      margin:15px auto;
    padding: 10px;
    border-radius:4px;
    -webkit-box-shadow: -1px -1px 14px -1px #3d3c3c; 
    box-shadow: -1px -1px 14px -1px #3d3c3c;
    width: 100%;
    height: 200px;
  }

  .photo, .description {
    margin:0;
    padding: 5px;
    height:100%;
    width: 100%;
  }

  .detail {
    height: 4em;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap:break-word;
    white-space: nowrap;
  }

  .vignette {
    width:100%;
    height:100%;  
  }

  .green {
    background-color: rgb(84, 201,167);
  }

/*Fin - Style pour la section résultat de recherche*/

</style>

<style type="text/css">

/*Style pour les formulaires de saisie*/

  .has-error label,
  .has-error input,
  .has-error textarea {
      color: red;
      border-color: red;
  }

  .list-unstyled li {
      font-size: 13px;
      padding: 4px 0 0;
      color: red;
  }

/*Form déposer annonce*/
 #deposerannonce {
    padding: 50px 10%;
  }

.box {
  position: relative;
  background: #ffffff;
  width: 100%;
}

.box-header {
  color: #444;
  display: block;
  padding: 10px;
  position: relative;
  border-bottom: 1px solid #f4f4f4;
  margin-bottom: 10px;
}

.box-tools {
  position: absolute;
  right: 10px;
  top: 5px;
}

.dropzone-wrapper {
  border: 2px dashed #91b0b3;
  color: #92b0b3;
  position: relative;
  height: 150px;
}

.dropzone-desc {
  position: absolute;
  margin: 0 auto;
  left: 0;
  right: 0;
  text-align: center;
  width: 80%;
  top: 50px;
  font-size: 16px;
}

.dropzone,
.dropzone:focus {
  position: absolute;
  outline: none !important;
  width: 100%;
  height: 150px;
  cursor: pointer;
  opacity: 0;
}

.dropzone-wrapper:hover,
.dropzone-wrapper.dragover {
  background: #ecf0f5;
}

.preview-zone {
  text-align: center;
}

.preview-zone .box {
  box-shadow: none;
  border-radius: 0;
  margin-bottom: 0;
}

</style>

</head>

<body>

<header class="navbar navbar-expand flex-column flex-md-row bd-navbar navbar-dark bg-primary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <a class="navbar-brand mr-0 mr-md-2" href="#" aria-label="Bouche@Oreille">
        <svg width="122" height="52">
            <ellipse cx="61" cy="26" rx="58" ry="24" style="fill:transparent; stroke:currentColor;stroke-width:4" />
          Sorry, your browser does not support inline SVG. 
            <title>Bouche@Oreille</title>
            <linearGradient id="shaded" x1="0" x2="0" y1="0" y2="1">
              <stop offset="0%" stop-color="#bbccee" stop-opacity="0"/>
              <stop offset="80%" stop-color="#6699cc"/>
            </linearGradient>
            <text font-size="28" fill="fill:url(#shaded)" stroke="currentColor" stroke-width="1px" x="28" y="36"
               font-family="Arial">
              B@A
            </text>
          </svg> 
    </a>

</header>
<!-- End header-->

<body>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="index.html">Retour à l'accueil</button>

</body>
</html>
<?php
}
?> 