<?php
################################################################
#      Ce script rafraichit les données de la récupération    ##
################################################################
if( !isset($gCms)) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$saison = $this->GetPreference('saison_en_cours');
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";
$dbresult = $db->Execute($query);

if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$licence = $row['licence'];
		$fftt = ping_admin_ops::compte_fftt($licence);
		$spid = ping_admin_ops::compte_spid($licence);
		
		$query2 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = ?, fftt = ? WHERE licence = ? AND saison = ?";
		$dbresultat = $db->Execute($query2, array($spid,$fftt,$licence,$saison));
	}
}

#
# EOF
#
?>