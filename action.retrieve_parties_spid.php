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

$licence = $params['licence'];
$designation = '';


$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
$dbretour = $db->Execute($query, array($licence));
if ($dbretour && $dbretour->RecordCount() > 0)
{
    while ($row= $dbretour->FetchRow())
      	{
		$player = $row['player'];
		//return $player;
		$service = new retrieve_ops();
		$resultats = $service->retrieve_parties_spid2($licence);
		//var_dump($resultats);
	}
	
}
else
{
	$designation.="Joueur introuvable";
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('recup');

#
# EOF
#
?>