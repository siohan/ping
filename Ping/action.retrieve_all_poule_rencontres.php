<?php
if( !isset($gCms) ) exit;
require_once(dirname(__FILE__).'/include/travaux.php');

// les préférences nécessaires
$saison = $this->GetPreference('saison_en_cours');
$now = trim($db->DBTimeStamp(time()), "'");
$nom_equipes = $this->GetPreference('nom_equipes');
$designation = '';
//on fait une requete pour extraire toutes les infos afin de préparer une boucle
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
$dbresult = $db->Execute($query, array($saison));

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
		$service = new Service();
 		//on instancie un compteur 
	
		for($i=0;$i<=$lignes;$i++)
    			//while ($dbresult && $row = $dbresult->GetRows())
      		{
			$row = $dbresult->FetchRow();
		}
	}
	else 
	{
		$this->SetMessage('Pas d\'équipes trouvées');
		$this->RedirectToAdminTab('equipes');
	}//fin du if dbresult


$iddiv = $params['iddiv'];
$idpoule = $params['idpoule'];

$service = new Service();
$result = $service->getPouleRencontres($iddiv,$idpoule);


//var_dump($result);
     
/**/
$i=0;
foreach($result as $cle =>$tab)
{
	

	$libelle = $tab[libelle];
	$equa = $tab[equa];
	$equb = $tab[equb];
	
	//on fait quelque transformations des infos recueillies
	preg_match_all('#[0-9]+#',$libelle,$extract);
	$tour = $extract[0][0];
	
	$extraction = substr($libelle,-8);
	$date_extract = explode('/', $extraction);
	$annee_date = $date_extract[2] + 2000;
	$date_event = $annee_date."-".$date_extract[1]."-".$date_extract[0];
	$uploaded = 0;
	
	$cluba = strpos($equa,$nom_equipes);
	$clubb = strpos($equb,$nom_equipes);
	if ($cluba !== false || $clubb !== false){
		$club = 1;
	}
	else{
		$club = 0;
	}
	$scorea = $tab[scorea];
	$scoreb = $tab[scoreb];
	$lien = $tab[lien];	
	
	$query = "SELECT lien FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE lien = ? ";
	$dbresult = $db->Execute($query, array($lien));
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	//	echo $query;
		$i++;
		$dbresultat = $db->Execute($query,array($idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));
		
		if(!$dbresultat)
		{
			$designation .= $db->ErrorMsg(); 
		}
	}
}

$comptage = $i;
$status = 'Poules';
$designation = "Récupération de ".$comptage." rencontres de la poule ".$idpoule;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_poules_rencontres";
$dbresult = $db->Execute($query, array($now,$status, $designation,$action));
if(!$dbresult)
{
	$designation.= $db->ErrorMsg(); 
}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('equipes');
#
# EOF
#
?>