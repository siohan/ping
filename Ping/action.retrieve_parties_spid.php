<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
require_once(dirname(__FILE__).'/function.calculs.php');
$now = trim($db->DBTimeStamp(time()), "'");

//$result = $service->getJoueurParties("07290229");
$licence = $params['licence'];
$designation = '';
$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
$dbretour = $db->Execute($query, array($licence));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$player = $row['player'];
	//return $player;
	}
	
}
else{
	$designation.="Joueur introuvable";
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
}

$service = new Service();
$result = $service->getJoueurPartiesSpid("$licence");
//var_dump($result);
//le service est-il ouvert ?
/**/
//on teste le resultat retourné     

if(!is_array($result)){
	
	
		$this->SetMessage('Le service est coupé');
		$this->RedirectToAdminTab('recuperation');	
}
else 
{

	
	$i = 0;
	$compteur = 0;
	foreach($result as $cle =>$tab)
	{
		$compteur++;
	
		$dateevent = $tab[date];
		$chgt = explode("/",$dateevent);
		$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
		
		//on extrait le mois pour retrouver la situation mensuelle
			if (substr($chgt[1], 0,1)==0){
				$mois_event = substr($chgt[1], 1,1);
				//echo "la date est".$date_event;
			}
			else
			{
				$mois_event = $chgt[1];
			}
		
		$nom = $tab[nom];
		$classement = $tab[classement];
		$cla = substr($classement, 0,1);
		
			if($cla == 'N'){
				$newclassement = explode('-', $classement);
				$newclass = $newclassement[1];
			}
			else {
				$newclass = $classement;
			}
		//on va calculer la différence entre le classement de l'adversaire et le classement du joueur du club
		$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ?";//" AND saison = ?";
		$dbresult = $db->Execute($query, array($licence,$mois_event));
		
			if ($dbresult && $dbresult->RecordCount() == 0)
			{
				$designation.="Ecart non calculé";
				$ecart = 0;
			}
			
		$row = $dbresult->FetchRow();
		$points = $row[points];
		$ecart_reel = $points - $newclass;
		//on calcule l'écart selon la grille de points de la FFTT
		$type_ecart = CalculEcart($ecart_reel);
		
		$epreuve = $tab[epreuve];
		
		// de quelle compétition s'agit-il ? 
		//On a la date et le type d'épreuve
		//on peut donc en déduire le tour via le calendrier
		//et le coefficient pour calculer les points via la table type_competitons
		
		//1 - on récupére le tour s'il existe
		//on va fdonc chercher dans la table calendrier
		$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE name_compet =? AND date_compet = ?";
		$resultat = $db->Execute($query, array($epreuve, $date_event));
		
			if ($resultat && $resultat->RecordCount()>0){
				$row = $resultat->FetchRow();
				$numjourn = $row[numjourn];
			}
			else
			{
				$numjourn = 0;
			}
		
		//2 - on récupère le coefficient de la compétition
		$coeff = coeff($epreuve);
		
		//$pointres = $points*$coeff;
		//fin du point 2
		$victoire = $tab[victoire];
		
			if ($victoire =='V'){
				$victoire = 1;
			}
			else 
			{
				$victoire = 0;
			}
		
		//on peut désormais calculer les points 
		echo "la victoire est : ".$victoire."<br />";
		 $points1 = CalculPointsIndivs($type_ecart, $victoire);
		echo "le coeff est : ".$coeff."<br />";
		echo "le type ecart est : ".$type_ecart."<br />";
		echo "les points 1 sont : ".$points1."<br />";
		$pointres = $points1*$coeff; 
		
		
		$forfait = $tab[forfait];
	
	
		$query = "SELECT licence, date_event,nom FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND date_event = ? AND nom = ?";
	//echo $query;
	$dbresult = $db->Execute($query, array($licence, $date_event,$nom));
	
		if($dbresult  && $dbresult->RecordCount() == 0) {
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$i++;
			//echo $query;
			$dbresultat = $db->Execute($query,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $coeff,$pointres, $forfait));
		
			if(!$dbresultat)
				{
					$designation.=$db->ErrorMsg(); 
				}
			}
			else 
			{ 
				echo "Partie déjà enregistrée";
			}
		}

$comptage = $i;
$status = 'Parties SPID';
$designation .= "Récupération spid de ".$comptage." parties sur ".$compteur."  de ".$player;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_parties_spid";
$dbresult = $db->Execute($query, array($now, $status,$designation,$action));

	if(!$dbresult)
	{
		$designation.= $db->ErrorMsg(); 
	}
	
	if($compteur >0)
	{
	$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = ? WHERE licence = ?";
	$dbresult = $db->Execute($query, array($compteur,$licence));
	
		if(!$dbresult)
		{
			$designation.= $db->ErrorMsg(); 
	
		}
	}	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('recuperation');

	}




/**/
#
# EOF
#
?>