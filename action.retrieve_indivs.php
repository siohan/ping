<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
//on vérifie les permissions
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage('Permission manquante');
	$this->RedirectToAdminTab('compets');
}
$error = 0;
//on vérifie les variables reçues
$type_compet = '';

if(isset($params['type_compet']) && $params['type_compet'] !='')
{
	$type_compet = $params['type_compet'];
}
else
{
	$error++;
}
$coefficient = '';
if(isset($params['coefficient']) && $params['coefficient'] !='')
{
	$coefficient = $params['coefficient'];
}
else
{
	$error++;
}
if($error>0)
{
	$this->SetMessage('Paramètres manquants');
	$this->RedirectToAdminTab('calendrier');
}
//on fait la requete pour retirer toutes les licences inscrites à cette compet
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_participe WHERE type_compet = ?";
$dbresult = $db->Execute($query, array($type_compet));

if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$licence = $row['licence'];
		ping_admin_ops::retrieve_parties_spid($licence);
	}
}

$this->SetMessage('Retrouvez les infos dans le journal');
$this->RedirectToAdminTab('calendrier');
#
#EOF
#
?>