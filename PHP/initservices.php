<?php
//initservices.php : Initialiser la liste des services
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=boucheaoreille;charset=utf8','root', '');
  }
  catch (PDOException $e) {
      die('Erreur : ' . $e->getMessage());
  }

  $result1 =$bdd->query('SELECT id AS IDCATEGORIE, nom AS NOMCATEGORIE FROM REF_CATEGORIEDESERVICE');
  while ($categorieencours = $result1->fetch()) {
    $idcategorie=$categorieencours['IDCATEGORIE'];
    $nomcategorie=$categorieencours['NOMCATEGORIE'];
    $result2 =$bdd->query('SELECT id AS IDSERVICE, nom AS NOMSERVICE FROM REF_SERVICES WHERE IDCATEGORIE='.$idcategorie);
    echo '<optgroup label="'.$nomcategorie.'">';
    while ($serviceencours=$result2->fetch()) {
      $idservice=$serviceencours['IDSERVICE'];
      $nomservice=$serviceencours['NOMSERVICE'];
      echo '<option value="'.$idservice.'">'.$nomservice.'</option>';
    }
    $result2->closeCursor();
    echo '</optgroup>';
  }
  $result1->closeCursor();
?>
