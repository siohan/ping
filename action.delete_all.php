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
$compteur = 0;
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
//$this->SetPreference('club_number', '');
$query = "TRUNCATE ".cms_db_prefix()."module_ping_adversaires";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_classement";
$db->Execute($query);
$designation.="Table classements vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_divisions";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_div_classement";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_div_parties";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_div_tours";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_equipes";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_feuilles_rencontres";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_joueurs";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_participe";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_participe_tours";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties_spid";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_poules_rencontres";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_rencontres_parties";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_sit_mens";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "TRUNCATE ".cms_db_prefix()."module_ping_recup";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$query = "DELETE ".cms_db_prefix()."module_ping_type_competitions WHERE idorga !='100001";
$db->Execute($query);
$designation.="Table adversaires vidée !";

$this->SetPreference('donnees_exemple', 0);



$this->SetMessage("$designation");
$this->RedirectToAdminTab('joueurs',array('message'=>'empty'));
?>