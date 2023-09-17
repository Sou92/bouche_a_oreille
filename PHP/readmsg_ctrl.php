<?php
$erreur="";
$msg="";

ini_set('display_errors','off');
require('config.php');

function getallmessages($service, $ville, $maxlimite)
{
	require('config.php');
	$requeteannonce='SELECT ref_villes.nom AS ville, ref_services.nom as service, annonces.*
					FROM ANNONCES INNER JOIN REF_VILLES ON ANNONCES.IDVILLE=REF_VILLES.ID
					INNER JOIN REF_SERVICES ON ANNONCES.IDSERVICE=REF_SERVICES.ID ';
	if ($service!=0){
			$requeteannonce=$requeteannonce.' AND ANNONCES.IDSERVICE='.$service;
		}
	if ($ville!=0){
			$requeteannonce=$requeteannonce.' AND ANNONCES.IDVILLE='.$ville;
		}
	$requeteannonce=$requeteannonce.' ORDER BY ANNONCES.DATEPUBLICATION DESC LIMIT '.$maxlimite;
	$result = $bdd->query($requeteannonce);

	if (!$result)
	{
		$listeannonces=$result->fetchAll();
		$result->closecursor();
		return $listeannonces;
	}
	else
	{
		$erreur='Erreur technique 002-1'; //impossible d'executer la requête SELECT
		return 0;
	}
}

function getlistemessages($annonce, $sender, $limit, $offset)
{
	require('config.php');
	$requete='SELECT * FROM CHAT_MESSAGES INNER JOIN MEMBRES ON CHAT_MESSAGES.SENDER=MEMBRES.ID ORDER BY CHAT_MESSAGES.dateDESC LIMIT '.$limit.' OFFSET '.$offset;
//	echo $requeteannonce;
	
	$result = $bdd->query($requete);

	if ($result !=false){
		$liste=$result->fetchAll();
		$result->closecursor();
		return $liste;
	}
	else {
		$erreur='Erreur technique 002-3'; //impossible d'executer la requête SELECT
		return 0;
	}
}

function getnextannonces($annonce, $sender, $limite, $id)
{
	require('config.php');
	$requeteannonce='SELECT * FROM CHAT_MESSAGES INNER JOIN MEMBRES ON CHAT_MESSAGES.SENDER=MEMBRES.ID 
                    INNER JOIN MEMBRES ON ANNONCES.IDMEMBRE=MEMBRES.ID ';
	if ($service!=0){
			$requeteannonce=$requeteannonce.' AND ANNONCES.IDSERVICE='.$service;
		}

	if ($ville!=0){
			$requeteannonce=$requeteannonce.' AND ANNONCES.IDVILLE='.$ville;
		}
	$requeteannonce=$requeteannonce.' ORDER BY ANNONCES.DATEPUBLICATION DESC LIMIT '.$limite.' OFFSET '.$id;
//	echo $requeteannonce;
	$result = $bdd->query($requeteannonce);

	if(!$result){
		$listeannonces=$result->fetchAll();
		return $listeannonces;
	}
	else {
		$erreur='Erreur technique 002-4'; //impossible d'executer la requête SELECT
		return 0;
	}
}

function afficherpagination($nbannonce, $num_per_page){
	$html="";
	 //on borne ou pas
	$borne=200;
	if($nbannonce<$borne) {
		$num_pages=ceil($nbannonce/$num_per_page);
	}
	else{
		$num_pages=ceil($borne/$num_per_page);
	}
	$pageur=Array();

	for ($i=0;$i<$num_pages;$i++){
		$pageur[]='<button type="button" class="btn btn-secondary page_btn" id='.$i.'>'.($i+1).'</button>';
	}

	if(!empty($pageur)){
		$html .= '<div class="row" id="zone_pagination"><div class="col-xl-12"><div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups"><div class="btn-group mr-2" role="group" aria-label="First group">';
		$html .= implode($pageur);
		$html .='</div></div></div></div>';
	}
	return $html;
}

function afficherresultat($listeannonces, $num_per_page){
   	$nbannonce=count($listeannonces);
   	$liste="";
	if ($num_per_page>0) {
		$liste= '<div class="col-12">';
		for ($i=0;$i<$num_per_page;$i++) {
			$annonce=$listeannonces[$i];
			$idimage='membres/noimage.png';
			if ($annonce['srcimage1']!=NULL)
				$idimage='membres/'.$annonce['idmembre'].'/images/'.$annonce['idannonce'].'/'.$annonce['srcimage1'];
			$liste .= '<div class="row annonce" id="annonce_'.$i.'">';
			$liste .= '<div class="col-4 photo"><img class="vignette" src="'.$idimage.'"></div>';
			$liste .= '<div class="col-8 description">';
			$liste .= '<div class="row"><div class="col-12"><p class=" float-right">'.$annonce['datepublication'].'</p></div></div>';
			$liste .= '<div class="row"><div class="col-12">';
			$liste .= '<h5>'.$annonce['service'].' - '.$annonce['ville'].'</h5>';
			$liste .= '<h6>'.$annonce['username'].'</h6>';
			$liste .= '<h6>'.$annonce['titre'].'</h6>';
			$liste .= '<p hidden>'.$annonce['description'].'</p>';
			$liste .= '</div></div>';
			$liste .= '<div class="row"><div class="col-12">';
			$liste .= '<a class="btn btn-sk-primary btn-sm float-right" href="m-viewitem.php?id='.$annonce['idannonce'].'&idmembre='.$annonce['idmembre'].'">Voir</a>';
			$liste .= '</div></div>';
			$liste .= '</div>';
			$liste .= '</div>';
		}
		$liste .= '</div>';
	}
	return $liste;
}

	$idmembre = htmlentities($_SESSION['idmembre']);

	if (!isset($_POST['idgetmessages'])) { //First time : when loading the page

	$idmembre = htmlentities($_SESSION['idmembre']);

	$nbtotalmsg=getnbmsg($idmembre, NULL, NULL); //get total msg number
	if ($nbtotalmsg==0){
		$erreur="no_errors";
		$msg='<h3 id="zone_synthese">Aucun résultat trouvé"</h3>';
	}
	else {
		$erreur="no_errors";
		$msg='<h3 id="zone_synthese">Vous avez '.$nbtotalmsg.' messages non lus</h3>';
		$listeannonces=getlistemsgann($idmembre);
		for
			
	}

	$nbmsg=getnbmsg($idmembre, $idannonce, $idsender);


	$nbmsg=getnbmsg($idmembre, $idannonce, $idsender);


	$requetemessages = $bdd->prepare('select chat_messages.idannonce, annonces.titre, COUNT(*) nbmsgann from chat_messages 
		INNER JOIN annonces ON chat_messages.idannonce=annonces.idannonce where chat_messages.recever = :idmembre AND chat_messages.lu=0 GROUP BY idannonce ORDER by chat_messages.idannonce DESC, chat_messages.message_time DESC');

	$requetemessages->bindParam('idmembre', $idmembre, PDO::PARAM_INT);
	if ($requette1->execute()){
		$nbrows1=$requette1->rowCount();
		if ($nbrows1 > 0){
			echo '<div class="row"><div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3"><div class="chat-search-box"><div class="input-group">
			<input class="form-control" placeholder="Search"><div class="input-group-btn"><button type="button" class="btn btn-sk-primary"><i class="fa fa-search"></i></button></div></div></div><div class="users-container">';
			$listeannonces=$requette1->fetchAll();
			$r=getlisteusers($listeannonces, $limit, 0); //	$offset=0;
			if ($r != 0) {
				$nbresultat=count($r);
				if ($nbresultat!=0){
					$msg .='<div class="row" id="zone_messages">';
					$msg .= afficherresultat($r, $nbresultat);
					$msg .='</div>';
				   	$msg .= afficherpagination($nbannonce, $num_per_page);
				   	$erreur="no_errors";

			}
			else{

			}

		else{
			$erreur="no_errors";
			$msg='<h3 id="zone_synthese">Vous n\'avez aucun message"</h3>';
		}


	$result=$bdd->query($requetemessages);
		if ($result != false)
		{
			$row=$result->fetch();
			$nbmessages=$row['nbre'];
			$result->closecursor();

			if ($nbmessages==0){
				$erreur="no_errors";
				$msg='<h3 id="zone_synthese">Vous n\'avez aucun message"</h3>';
			}
			else {
				$erreur="no_errors";
				$msg='<h3 id="zone_synthese">Vous avez '.$nbmessages.' non lus</h3>';

				$r=getlistemessages($service, $ville, $limit, 0); //	$offset=0;
				if ($r != 0) {
					$nbresultat=count($r);
					if ($nbresultat!=0){
						$msg .='<div class="row" id="zone_messages">';
						$msg .= afficherresultat($r, $nbresultat);
						$msg .='</div>';
					   	$msg .= afficherpagination($nbannonce, $num_per_page);
					   	$erreur="no_errors";
				    }
				    else
						$erreur="Erreur inatendue : la liste est vide";
				}
				else
					$erreur="Erreur lors de la lecture des enregistrements";
			}
		}
		else 
			$erreur='Erreur technique 002-5'; //impossible d'executer la requête SELECT
	}
	else { //When click on selected item
		$start=(int)htmlentities($_POST['getLastContentId']);
		$offset=($start*$num_per_page);
		$limit=$num_per_page;
		
		$r=getlistemessages($service, $ville,$limit, $offset);
		$nbresultat=count($r);
		if ($nbresultat!=0){
			$msg .= afficherresultat($r, $nbresultat);
		}
	}

echo $msg;
?>

<script type="text/javascript">
    $('.page_btn').click(function() {
        var service= $("#listeservice").val();
        var ville= $("#listeville").val();
        var getId = $(this).attr("id");
        console.log('onclick#page_btn:'+'service:'+service+'ville:'+ville+'getid='+getId);
        if(getId)
        {
          $("#annonce_"+getId).html('<img src="images/loading.gif" style="padding:10px 0 0 100px;"/>');
          $.ajax({
			type: "POST",
			url: "find_ctrl.php",
			data: {ville: ville, service: service, getLastContentId: getId},
			cache: false,
			success: function(html){
				$("#zone_annonces").empty();
				$("#zone_annonces").append(html);
			},
	        error: function(XMLHttpRequest, textStatus, errorThrown) {
		            console.log("erreur");
		            console.log(XMLHttpRequest);
		            console.log(textStatus);
		            console.log(errorThrown);
					$("#resultsection#error_msg").empty();
					$("#resultsection#error_msg").append(XMLHttpRequest.responseText);
		        },
				complete : function(resultat, statut, erreur){
					console.log("complete");
				}
          });
        }
        else
        {
        $(".more_tab").html('The End');
        }
        return false;
    });
	
</script>