<?php
#################################################################
#    Première étape de récupération des organismes              #
#################################################################



if( !isset($gCms) ) exit;

//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$designation = "";
//on vérifie que tous les paramètres nécessaires sont renseignés (type)
$tableau = array('F','Z','L','D');
//on instancie la classe servicen
$service = new Servicen();
$page = "xml_organisme";
foreach($tableau as $valeur)
{
	$var = "type=".$valeur;
	echo $var;
	$scope = $valeur;
	echo "la valeur est : ".$valeur;
	$lien = $service->GetLink($page,$var);
	echo $lien;
	$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
	if($xml === FALSE)
	{
		var_dump($xml);
		//$this->SetMessage("Impossible de récupérer les organismes !");
		//$this->RedirectToAdminTab('configuration');
	}
	else
	{
		$array = json_decode(json_encode((array)$xml), TRUE);
		///on initialise un compteur général $i
		$i=0;
		//on initialise un deuxième compteur
		$compteur=0;

			foreach($xml as $cle =>$tab)
			{

				$i++;
				$idorga = (isset($tab->id)?"$tab->id":"");
				$code  = (isset($tab->code)?"$tab->code":"");
				$libelle = (isset($tab->libelle)?"$tab->libelle":"");
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
			
	}
	unset($scope);
	unset($var);
	unset($lien);
	unset($xml);
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