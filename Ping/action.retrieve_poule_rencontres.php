<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$iddiv = $params['iddiv'];
$idpoule = $params['idpoule'];
$type_compet = $params['type_compet'];
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

$service = new Service();
$result = $service->getPouleRencontres($iddiv,$idpoule);

$designation = '';
//var_dump($result);
/**/
//on va tester la valeur de la variable $result
//cela permet d'éviter de boucler s'il n'y a rien dans le tableau
if(!is_array($result))
{ 
	
		//le tableau est vide, il faut envoyer un message pour le signaler
		$designation.= "le service est coupé";
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('poules');
}   
else{
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
	$uploaded = 0;//initialement mis à 0, indique si le détail des matchs a été uploadé ou non.
	
	$cluba = strpos($equa,$nom_equipes);
	$clubb = strpos($equb,$nom_equipes);
	if ($cluba !== false || $clubb !== false){
		$club = 1;
		$affichage = 1;
	}
	else{
		$club = 0;
		//on affiche ou pas ?
		//On regarde ce que l'admin a décidé ds la configuration
		
	}
	$scorea = $tab[scorea];
	$scoreb = $tab[scoreb];
	//echo gettype($scorea);
	$lien = $tab[lien];
	
	//
	//on vérifie que le score a bien été saisi
	//si le score est saisi on obtient un string pour les variables scorea et scoreb
	//sinon il s'agit d'un array	
	
	if(is_array($scorea) && is_array($scoreb))
	{
			//on regarde la valeur du populate_calendar
			//à True, elle permet 
			//de remplir la table calendrier automatiquement
			$designation = "Score non parvenu entre ".$equa." et ".$equb;
			$status = "Echec";
			$action = "retrieve_poule_rencontres";
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
			$action = "retrieve_poules_rencontres";
			$dbresult = $db->Execute($query, array($now,$status, $designation,$action));
		
				if(!$dbresult)
				{
					$designation.=$db->ErrorMsg(); 
				}			
			
			
	
	}
	else 
	{
		
	
			//on vérifie si l'enregistrement est déjà là
			$query = "SELECT lien FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE lien = ? ";
			$dbresult = $db->Execute($query, array($lien));
	
			//il n'y a pas d'enregistrement auparavant, on peut continuer
			
				if($dbresult  && $dbresult->RecordCount() == 0) 
				{
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					//echo $query;
					$i++;
					$dbresultat = $db->Execute($query,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));
		
						if(!$dbresultat)
							{
								$designation.= $db->ErrorMsg();
								

							}
						
							
		
		
		
		
				}
	}
	
	
	//on remplit le calendrier ?
	if($this->GetPreference('populate_calendar')=='Oui'){
		{
			//On fait l'inclusion ds la bdd
			// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
			$query = "SELECT iddiv, idpoule, numjourn, date_compet FROM ".cms_db_prefix()."module_ping_calendrier WHERE iddiv = ? AND idpoule = ? AND numjourn = ? AND date_compet = ?";
			$dbresult = $db->Execute($query, array($iddiv, $idpoule,$tour, $date_event));

				if ($dbresult->RecordCount()==0)
					{
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,date_compet,iddiv, idpoule, numjourn) VALUES ( '', ?, ?, ?, ?)";
						$dbresult = $db->Execute($query, array($date_event, $iddiv, $idpoule,$tour));
						
						if($dbresult){
							$designation.= $db->ErrorMsg();
						}
					}

		}
	}
}//fin du foreach
}//fin du if is_array($result)

$comptage = $i;
$status = 'Poules';
$designation.= "Récupération de ".$comptage." rencontres de la poule ".$idpoule;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_poules_rencontres";
$dbresult = $db->Execute($query, array($now,$status, $designation,$action));
if(!$dbresult)
{
	$designation.= $db->ErrorMsg(); 
}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('equipes');
/*	*/
#
# EOF
#
?>