<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$iddiv = $params['iddiv'];
$idpoule = $params['idpoule'];
$idepreuve = "";
if(isset($params['idepreuve']) && $params['idepreuve'] != "")
{
	$idepreuve = $params['idepreuve'];
}
$message = '';
if(!isset($iddiv) && empty($iddiv)){
	$message.="Paramètres manquants";
	$this->Setmessage("$message");
	$this->RedirectToAdminTab('equipes');
	}
//Les préférences
$now = trim($db->DBTimeStamp(time()), "'");
$nom_equipes = $this->GetPreference('nom_equipes');
$saison = $this->GetPreference('saison_en_cours');
$update = '0';//valeur par défaut
$service = new Servicen();
$page = "xml_result_equ";
$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
$lien = $service->GetLink($page, $var);
$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
if($xml === FALSE)
{
	//le service est coupé
	$array = 0;
	$lignes = 0;
}
else
{
	$array = json_decode(json_encode((array)$xml), TRUE);
	$lignes = count($array['tour']);
}
//echo "le nb de lignes est : ".$lignes;
//$result = $service->getPouleRencontres($iddiv,$idpoule);

$designation = '';
//var_dump($result);
/**/
//on va tester la valeur de la variable $result
//cela permet d'éviter de boucler s'il n'y a rien dans le tableau
if(!is_array($array))
{ 
	
		//le tableau est vide, il faut envoyer un message pour le signaler
		$designation.= "le service est coupé";
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('poules');
}   
else{
$i=0;
foreach($xml as $cle =>$tab)
{
	
	
	$libelle = (isset($tab->libelle)?"$tab->libelle":"");
	$equa = (isset($tab->equa)?"$tab->equa":"");
	$equb = (isset($tab->equb)?"$tab->equb":"");

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

		if ($cluba !== false || $clubb !== false)
		{
			$club = 1;
			$affichage = 1;
		}
		else
		{
			$club = 0;
		}
	
	$scorea = (isset($tab->scorea)?"$tab->scorea":"");
	$scoreb = (isset($tab->scoreb)?"$tab->scoreb":"");
	$lien = (isset($tab->lien)?"$tab->lien":"");
	
	//
	//on vérifie que le score a bien été saisi
	//si le score est saisi on obtient un string pour les variables scorea et scoreb
	//sinon il s'agit d'un array	
	
		if(is_array($scorea) && is_array($scoreb))
		{
			//le score n'est pas parvenu ou le match n'a pas été joué
			//On l'enregistre qd même
			$scorea = 0;
			$scoreb = 0;
			$update = 0;		
		}
		
	//on vérifie si l'enregistrement est déjà là
	$query = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
	$dbresult = $db->Execute($query, array($iddiv,$idpoule, $date_event,$equa,$equb));
	
	//il n'y a pas d'enregistrement auparavant, on peut continuer
			
		if($dbresult->RecordCount() == 0) 
		{
			$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			//echo $query;
			$i++;
			$uploaded = 0;
			$dbresultat = $db->Execute($query1,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));
		
				if(!$dbresultat)
				{
					$designation.= $db->ErrorMsg();
								

				}
		}
		elseif($dbresult->RecordCount() >0)
		{
			//il y a déjà un enregistrement, le score est-il à jour ?
			$update = 1;
			$row = $dbresult->FetchRow();
			$id = $row['id'];
			$scoreA = $row['scorea'];
			$scoreB = $row['scoreb'];
				
				if($scoreA ==0 && $scoreB ==0)
				{
					$query3 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE id = ?";
					$dbresultA = $db->Execute($query3, array($scorea, $scoreb, $id));
					$i++;
					if(!$dbresultA)
					{
						$designation.= $db->ErrorMsg();
					}
				}
		}
		
	
	
	//on remplit le calendrier ?
	if($this->GetPreference('populate_calendar')=='Oui')
	{
		
			//on prépare le tag
			$indivs = 0;//puisqu'on est dans un contexte d'équipes
			$tag = "{Ping action='par-equipes'";
			$tag.=" idepreuve='$idepreuve'";
			
				if(isset($date_event) && $date_event !='')
				{
					$tag.= " date_debut='$date_event'";
				}
				if(isset($date_event) && $date_event !='')
				{
					$tag.= " date_fin='$date_event'";
				}
			$tag.="}";
			//On fait l'inclusion ds la bdd
			// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
			$query = "SELECT numjourn, date_debut, date_fin, type_compet FROM ".cms_db_prefix()."module_ping_calendrier WHERE  numjourn = ? AND date_debut = ? AND date_fin =? AND type_compet = ? ";//AND scorea !=0 AND scoreb !=0";
			$dbresult = $db->Execute($query, array($tour, $date_event, $date_event,$type_compet));

				if ($dbresult->RecordCount()==0)
				{
					
					
					
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,date_debut,date_fin,type_compet, numjourn,tag,saison) VALUES ( '', ?, ?, ?, ?, ?, ?)";
						$dbresult = $db->Execute($query, array($date_event,$date_event,$type_compet,$tour,$tag,$saison));
						
						if($dbresult)
						{
							$designation.= $db->ErrorMsg();
						}
				}
				

		
	}
}//fin du foreach
}//fin du if is_array($result)

$comptage = $i;
$status = 'Poules';
$designation.= "Mise à jour de ".$comptage." rencontres de la poule ".$idpoule;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_poules_rencontres";
$dbresult = $db->Execute($query, array($now,$status, $designation,$action));
if(!$dbresult)
{
	$designation.= $db->ErrorMsg(); 
}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('poules');
/*	*/
#
# EOF
#
?>