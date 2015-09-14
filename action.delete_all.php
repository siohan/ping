<?php
if (!isset($gCms)) exit;
$message = '';

if (!$this->CheckPermission('Ping Delete'))
{
$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
$this->Redirect($id, 'defaultadmin','', $params);
/*echo $this->ShowErrors($this->Lang('needpermission'));
return;*/
}
$saison = $this->GetPreference('saison_en_cours');
$designation = '';

$query = "DELETE FROM ".cms_db_prefix()."module_ping_adversaires";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query2 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET saison = ?, spid_total = '0'";
$dbresult - $db->Execute($query2, array($saison));



$this->SetMessage("$designation");
$this->RedirectToAdminTab('joueurs',array('message'=>'empty'));
?>