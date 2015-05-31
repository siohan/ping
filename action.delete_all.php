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

$designation = '';

$query = "DELETE FROM ".cms_db_prefix()."module_ping_adversaires";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_classement";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_calendrier";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_comm";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_equipes";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_joueurs";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_participe";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_recup";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_recup_parties";
$db->Execute($query);
$designation.="Table temporaire vidée !";

$query = "DELETE FROM ".cms_db_prefix()."module_ping_sit_mens";
$db->Execute($query);
$designation.="Table temporaire vidée !";		

$this->SetMessage("$designation");
$this->RedirectToAdminTab('joueurs',array('message'=>'empty'));
?>