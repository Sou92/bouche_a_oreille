<?php
  $erreur="";
  $msg="";

  ini_set('display_errors','off');
  require('config.php');

    $requete = $bdd->prepare( "SELECT count(*) as nbre FROM ANNONCES WHERE 1=1 LIMIT 2000");
    if ($requete->execute()) {
      $result=$requete->fetch();
      $nbannonces=$result['nbre'];
      $erreur="no_errors";
    }
    else
      $erreur='Erreur technique 002'; //impossible d'executer la requête SELECT

  $requete->closecursor();
?>

<!--Searchsection -->
<div id="searchsection">
  <form id="searchform" method="post" action="find_ctrl.php">
    <div class="form-row">
      <div class="input-group col-md-9 ml-auto">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <svg class="search-icon" viewBox="0 0 20 20">
             <path fill="none" d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896
              c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519
              c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461
              s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
            </svg>
          </span>
        </div>
        <input class="form-control" type="text" name="searchword" aria-label="searchword" placeholder="Que cherchez vous ?" aria-label="searchword" aria-describedby="basic-addon1">
        <SELECT class="form-control" aria-label="Choisissez une ville" name="ville" id="listeville">
          <option selected value="0">Choisissez une ville</option>
          <?php include("initvilles.php");?>
        </SELECT>
        <select class="form-control" aria-label="Choisissez un service" name="service" id="listeservice">
        <optgroup value="0">
           <option selected="" value="0">Choisissez un service</option>
        </optgroup>
        <?php include("initservices.php");?>
        </SELECT>
      </div>      
      <div class="form-group col-md-3">
        <button type="submit" class="btn btn-sk-primary" id="rechercheannonce" name="recherche" style="width: 80%; ">Voir <?php if (isset($nbannonces)) echo '('.$nbannonces. ' résultats)';?></button>
      </div>      
    </div>
  </form>
</div>
<!--End Searchsection -->

<!-- Result section -->
<section class="container marrgin-r-l" id="resultsection">
  <div class="error" id="error_msg"></div>
</section>
<!-- End resultsection -->  
