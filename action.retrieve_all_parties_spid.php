<?php
##################################################################################
###         RECUPERATION DE TOUTES LES PARTIES SPID                            ###
##################################################################################
if( !isset($gCms) ) exit;
//on vérifie la permission d'utiliser le script
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
require_once(dirname(__FILE__).'/function.calculs.php');
$db = $this->GetDb();
$designation = '';
$now = trim($db->DBTimeStamp(time()), "'");
$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif='1'";
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount() > 0)
{
	 
	//on instancie la classe et on va commencer à boucler
	$service = new retrieve_ops();
	
	while ($row= $dbresult->FetchRow())
	{
		$licence = $row['licence'];		
		$player = $row['player'];
		
		
		$retrieve_spid = $service->retrieve_parties_spid($licence);
		
			
	}//fin du while
	
}


#
# EOF
#
?>