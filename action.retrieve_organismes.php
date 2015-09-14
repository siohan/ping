<?php
#################################################################
#    Première étape de récupération des organismes              #
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

//on vérifie que tous les paramètres nécessaires sont renseignés (type)
$tableau = array('F','Z','L','D');
//on instancie la classe service
$service = new Service();
foreach($tableau as $valeur)
{
	$result = '';
	$result = $service->getOrganismes("$valeur");
	$scope = $valeur;
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
			$idorga = $tab['id'];
			$code  = $tab['code'];
			$libelle = $tab['libelle'];
			// 1- on vérifie si cette épreuve est déjà dans la base
			$query = "SELECT idorga FROM ".cms_db_prefix()."module_ping_organismes WHERE idorga = ?";
			$dbresult = $db->Execute($query, array($idorga));
	
				if($dbresult  && $dbresult->RecordCount() == 0) 
				{
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_organismes (id, libelle, idorga, code, scope) VALUES ('', ?, ?, ?, ?)";
					//echo $query;
					$compteur++;
					$dbresultat = $db->Execute($query,array($libelle,$idorga,$code,$scope));
		
					if(!$dbresultat)
					{
						$designation .= $db->ErrorMsg();			
					}

				}
				else
				{
					//l'épreuve est déjà renseignée, on fait un update
					$query = "UPDATE ".cms_db_prefix()."module_ping_organismes SET libelle = ?, code = ?, scope = ? WHERE idorga = ? ";
					$dbresult = $db->Execute($query, array($libelle,$code,$scope,$idorga));
				}//fin du if $dbresult
	
	
		}// fin du foreach
		unset($scope);
}//fin du premier foreach
$designation .= "Récupération de ".$compteur." organismes";

	
	
$status = 'Ok';
$action = 'retrieve_teams';
//ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('configuration');

#
# EOF
#

?>