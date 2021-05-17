<?php
if(!isset($gCms)) exit;
$retourid = 'essai';
$cg_ops = new CGExtensions;
$ops = new adherents_spid;
$page = $cg_ops->resolve_alias_or_id($retourid);

$db = cmsms()->GetDb();
$query="TRUNCATE ".cms_db_prefix()."module_ping_equipes";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_joueurs";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_parties";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_parties_spid";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_recup_parties";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_poules_rencontres";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_sit_mens";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_adversaires";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_classement";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_feuilles_rencontres";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_rencontres_parties";
$dbresult = $db->Execute($query);

$query="TRUNCATE ".cms_db_prefix()."module_ping_joueurs";
$dbresult = $db->Execute($query);

$query = "DELETE FROM ".cms_db_prefix()."module_ping_type_competitions" WHERE idorga != '100001';
$dbresult = $db->Execute($query);

$this->RedirectForFrontEnd($id, $returnid, 'getInitialisation', array("step"=>"2"),  $inline='true');		
?>

