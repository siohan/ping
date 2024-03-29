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
$justnow = time();
$now = trim($db->DBTimeStamp(time()), "'");
$query = "SELECT CONCAT_WS(' ',j.nom,j.prenom) as player, j.licence, j.cat FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_recup_parties AS rc WHERE j.licence = rc.licence AND j.actif='1' AND j.type = 'T' ORDER BY maj_spid ASC LIMIT 15";// AND rc.maj_spid < ($justnow - 3600) 
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount() > 0)
{
	 
	//on instancie la classe et on va commencer à boucler
	$service = new retrieve_ops;
	$ping_ops = new ping_admin_ops;
	$spid_ops = new spid_ops;
	
	while ($row= $dbresult->FetchRow())
	{
		$licence = $row['licence'];		
		$player = $row['player'];
		$cat = $row['cat'];
		
		$retrieve_spid = $service->retrieve_parties_spid2($licence, $player, $cat);
		$spid_ops->compte_spid($licence);		
		$calcul_pts_spid = $spid_ops->compte_spid_points($licence);
		$spid_ops->maj_points_spid($licence,$calcul_pts_spid);
	//	$spid_ops->recalcul($licence);
		
		
			
	}//fin du while
	$this->Redirect($id, 'retrieve_all_parties_spid2',$returnid);
}
else
{
	$this->RedirectToAdminTab('spid');
}


#
# EOF
#
?>
