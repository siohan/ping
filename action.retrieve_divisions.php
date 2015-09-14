<?php
#################################################################
#    Première étape de récupération des divisions               #
#################################################################



if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');

$club_number = $this->GetPreference('club_number');
$saison = $this->GetPreference('saison_en_cours');
$fede = '100001';
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');
$designation = '';
if(!isset($club_number) && $club_number =='')
{
	$message = "Votre numéro de club n'est pas configuré !!";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
$smarty->assign('returnlink', $this->CreateLink($id,'defaultadmin',$returnid,$themeObject->DisplayImage('icons/system/back.gif', $this->Lang('back'), '', '', 'systemicon'),array("active_tab"=>"divisions")));
$now = trim($db->DBTimeStamp(time()), "'");
$error = 0;//on instancie une variable d'erreur
//on vérifie que tous les paramètres nécessaires sont renseignés (idorga et type et idepreuve)
/**/
if(isset($params['idorga']) && $params['idorga'] !='')
{
	$idorga = $params['idorga'];
	
}
else
{
	$error++;
}
/**/
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
	$type == 'E';
}
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	$error++;
}
$page="xml_division";
//on instancie la classe service
$service = new Servicen();


	$var = "organisme=".$idorga."&epreuve=".$idepreuve."&type=".$type;
		//echo $valeur;
		if($idorga == $fede) {$scope = 'F';}
		if($idorga == $zone) {$scope = 'Z';}
		if($idorga == $ligue) {$scope = 'L';}
		if($idorga == $dep) {$scope = 'D';}
		//
		$lien = $service->GetLink($page,$var);
		//var_dump($lien);
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
			$lignes = count($array['division']);
		}
		//echo "le nb de lignes est : ".$lignes;
		$i=0;
		//on initialise un deuxième compteur
		$compteur=0;
		foreach($xml as $value)
		{

			$i++;
			$iddivision = htmlentities($value->iddivision);
			$libelle = htmlentities($value->libelle);

			// 1- on vérifie si cette épreuve est déjà dans la base
			$query = "SELECT iddivision FROM ".cms_db_prefix()."module_ping_divisions WHERE iddivision = ? AND idorga = ? AND saison = ? AND idepreuve = ?";
			$dbresult = $db->Execute($query, array($iddivision, $idorga,$saison,$idepreuve));

				if($dbresult  && $dbresult->RecordCount() == 0) 
				{
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_divisions (id, idorga, idepreuve,iddivision,libelle,saison,indivs,scope) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
					//echo $query;
					$compteur++;
					$dbresultat = $db->Execute($query,array($idorga,$idepreuve,$iddivision,$libelle,$saison,$indivs,$scope));

					if(!$dbresultat)
					{
						$designation .= $db->ErrorMsg();			
					}

				}
				/*
				else
				{
					//l'épreuve est déjà renseignée, on fait un update
					$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET idepreuve = ?, idorga = ? WHERE name = ? ";
					$dbresult = $db->Execute($query, array($idepreuve,$idorga,$libelle));
				}//fin du if $dbresult
				*/

		}// fin du foreach
		unset($scope);
	//}//fin du premier foreach
	$designation .= "Récupération de ".$compteur." divisions";



	$status = 'Ok';
	$action = 'retrieve_teams';
	//ping_admin_ops::ecrirejournal($now,$status,$designation,$action);

		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('compets');


#
# EOF
#

?>