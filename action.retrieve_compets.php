<?php
#################################################################
#    Première étape de récupération des compétitions                 #
#################################################################



if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
if(!isset($club_number) && $club_number =='')
{
	$message = "Votre numéro de club n'est pas configuré !!";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
$now = trim($db->DBTimeStamp(time()), "'");

//on vérifie que tous les paramètres nécessaires sont renseignés (idorga et type)
if(isset($params['idorga']) && $params['idorga'] !='')
{
	$idorga = $params['idorga'];
}
if(isset($params['type']) && $params['type'] !='')
{
	$type = $params['type'];
	if($type == 'E')
	{
		$indivs = 0;
	}
	else
	{
		$indivs = 1;
	}
}
else
{
	$type = 'E';
}
//on instancie la classe service
$service = new Servicen();

$result = '';
$page = "xml_epreuve";
$var = "organisme=".$idorga."&type=".$type;
$lien = $service->GetLink($page, $var);
$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);

if($xml === FALSE)
{
	// Le service est coupé
	$array = 0;
}
else
{
	$array = json_decode(json_encode((array)$xml), TRUE);
	$lignes = count($array['epreuve']);
}

//var_dump($result);
/**/
//on va tester si la variable est bien un tableau   
	if(!is_array($array) || $lignes == 0)  {
		
		$this->SetMessage("Le service est coupé ou il n'y a pas encore de résultats");
		$this->RedirectToAdminTab('epreuves');
	}

///on initialise un compteur général $i
$i=0;
//on initialise un deuxième compteur
$compteur=0;
foreach($xml as $cle =>$tab)
{
	
	$i++;
	$idepreuve = (isset($tab->idepreuve)?"$tab->idepreuve":"");
	$idorga  = (isset($tab->idorga)?"$tab->idorga":"");
	$libelle = (isset($tab->libelle)?"$tab->libelle":"");
	// 1- on vérifie si cette épreuve est déjà dans la base
	$query = "SELECT name FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
	$dbresult = $db->Execute($query, array($libelle));
	
		if($dbresult  && $dbresult->RecordCount() == 0) 
		{
			$query1 = "SHOW TABLE STATUS LIKE '".cms_db_prefix()."module_ping_equipes' ";
			$dbresult = $db->Execute($query1);
			$row = $dbresult->FetchRow();
			$record_id = $row['Auto_increment'];
			$tag = ping_admin_ops::tag($record_id, $idepreuve, $indivs);
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, indivs, idepreuve,tag, idorga) VALUES ('', ?, ?, ?, ?, ?)";
			//echo $query;
			$compteur++;
			$dbresultat = $db->Execute($query,array($libelle,$indivs,$idepreuve,$tag,$idorga));
		
			if(!$dbresultat)
			{
				$designation .= $db->ErrorMsg();			
			}

		}
		else
		{
			//l'épreuve est déjà renseignée, on fait un update
			//if($idorga == $this->GetPreference(''))
			$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET idepreuve = ? WHERE name = ? ";
			$dbresult = $db->Execute($query, array($idepreuve,$libelle));
		}//fin du if $dbresult
	
	
}// fin du foreach

$designation .= "Récupération de ".$compteur." épreuves";

	
	
$status = 'Ok';
$action = 'retrieve_teams';
//ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('compets');

#
# EOF
#

?>