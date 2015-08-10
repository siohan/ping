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
$service = new Service();

$result = '';
$result = $service->getEpreuves("$idorga","$type");

//var_dump($result);
/**/
//on va tester si la variable est bien un tableau   
	if(!is_array($result))  {
		
		$this->SetMessage("Le service est coupé");
		$this->RedirectToAdminTab('epreuves');
	}

///on initialise un compteur général $i
$i=0;
//on initialise un deuxième compteur
$compteur=0;
foreach($result as $cle =>$tab)
{
	
	$i++;
	$idepreuve = $tab['idepreuve'];
	$idorga  = $tab['idorga'];
	$libelle = $tab['libelle'];
	// 1- on vérifie si cette épreuve est déjà dans la base
	$query = "SELECT name FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
	$dbresult = $db->Execute($query, array($libelle));
	
		if($dbresult  && $dbresult->RecordCount() == 0) 
		{
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, indivs, idepreuve, idorga) VALUES ('', ?, ?, ?, ?)";
			//echo $query;
			$compteur++;
			$dbresultat = $db->Execute($query,array($libelle,$indivs,$idepreuve,$idorga));
		
			if(!$dbresultat)
			{
				$designation .= $db->ErrorMsg();			
			}

		}
		else
		{
			//l'épreuve est déjà renseignée, on fait un update
			$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET idepreuve = ?, idorga = ? WHERE name = ? ";
			$dbresult = $db->Execute($query, array($idepreuve,$idorga,$libelle));
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