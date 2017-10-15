<?php
#################################################################################
###           RECUPERATION DES PARTIES SPID                                   ###
#################################################################################
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
require_once(dirname(__FILE__).'/function.calculs.php');
$now = trim($db->DBTimeStamp(time()), "'");
$error = 0;
$licence = '';
if(isset($params['licence']) && $params['licence'] !='')
{
	$licence = $params['licence'];
}
else
{
	$this->SetMessage('pas de numéro de licence !');
	$this->RedirectToAdminTab('joueurs');
}

$designation = '';


$query = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS player, adh.cat FROM ".cms_db_prefix()."module_ping_joueurs as j, ".cms_db_prefix()."module_adherents_adherents AS adh WHERE j.licence = adh.licence AND j.licence = ?";
$dbretour = $db->Execute($query, array($licence));
if ($dbretour && $dbretour->RecordCount() > 0)
{
    while ($row= $dbretour->FetchRow())
      	{
		$player = $row['player'];
		$cat = $row['cat'];
		//return $player;
		$service = new retrieve_ops();
		$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
		//var_dump($resultats);
	}
	
}
else
{
	$designation.="Joueur introuvable";
}
	
$this->SetMessage("$designation");
$this->RedirectToAdminTab('recup');

#
# EOF
#
?>