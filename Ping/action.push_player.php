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
$saison = $this->GetPreference('saison_en_cours');
//on vérifie la présence ou non du joueur
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ? AND saison = ?";
$dbresult = $db->Execute($query, array($licence, $saison));
$count = $dbresult->RecordCount();
if($count==0)//on est ok
{
	//on fait la totale en récupérant toutes les données ?
	//où on laisse l'admin le faire ?
	//pour l'heure on fait le mini
	$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$dbresult2 = $db->Execute($query2, array($saison,$now,$licence,'Janvier 2000',0,0,0,0,0,0));
	
	//on teste la requete
	if(!$dbresult2)
	{
		//une erreur ? laquelle ?
		$message = $db->ErrorMsg();
		$status = 'Pb Joueur poussé';
		$action = 'push_player';
		ping_admin_ops::ecrirejournal($now,$status,$message,$action);
		$this->SetMessage("$message");
		$this->RedirectToAdminTab('recup');
		
	}
	else //tout s'est bien passé
	{
		//on écrit dans le journal
		$status = 'Joueur poussé';
		$designation = 'joueur poussé : '.$licence;
		$action = 'push_player';
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('recup');
	}
	
}
else
{
	$this->SetMessage('Joueur déjà présent !');
	$this->RedirectToAdminTab('recup');
}

#
#EOF
#
?>