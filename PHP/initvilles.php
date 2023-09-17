<?php
  $erreur="";
  $msg="";

  require('config.php');

  $result =$bdd->query('SELECT id AS IDVILLE, nom AS NOMVILLE FROM REF_VILLES');
  while ($villeencours=$result->fetch()) {
    $idville=$villeencours['IDVILLE'];
    $nomville=$villeencours['NOMVILLE'];
    echo '<option value="'.$idville.'">'.$nomville.'</option>';
  }
  $result->closeCursor();
?>