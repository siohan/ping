<?php
if( !isset($gCms)) exit;
//mettre les perms
#
# Cette page va pousser un joueur vers la table recup
//mettre les bonnes permissions
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
$licence = '';
if(!isset($params['licence']) || $params['licence'] =='')
{
	$this->SetMessage($this->Lang('missing_parameters'));
	$this->RedirectToAdminTab('joueurs');
}
else
{
	$licence = $params['licence'];
}
require_once(dirname(__FILE__).'/include/prefs.php');
//$saison = $this->GetPreference('saison_en_cours');
//on vérifie la présence ou non du joueur
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
$dbresult = $db->Execute($query, array($licence));
$count = $dbresult->RecordCount();
if($count==0)//on est ok
{
	$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$dbresult2 = $db->Execute($query2, array($saison,$now,$licence,'Janvier 2000',0,'1970-01-01',0,'1970-01-01',0,0));//on récupère la situation mensuelle du joueur
	
	if($dbresult2)
	{
		$retrieve_ops = new retrieve_ops();
				
		$fftt = $retrieve_ops->retrieve_parties_fftt($licence);
		$sit_mens = $retrieve_ops->retrieve_sit_mens($licence,$ext='');
		if($sit_mens !== FALSE)
		{
		//	$spid = $retrieve_ops->retrieve_parties_spid2($licence, $player, $cat);
		}
	}
	
}
else
{
	$this->SetMessage('Joueur déjà présent !');
	
}
$this->RedirectToAdminTab('joueurs');
#
#EOF
#
?>