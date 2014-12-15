<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) exit;

$activepoll=$this->GetPreference("activepoll");
if ($params["pollid"]==$activepoll) exit;

$db=$this->GetDb();

$q="DELETE FROM ".cms_db_prefix()."module_polloptions WHERE pollid=?";
$p=array($params["pollid"]);
$result=$db->Execute($q,$p);

$q="DELETE FROM ".cms_db_prefix()."module_pollblocked WHERE pollid=?";
$p=array($params["pollid"]);
$result=$db->Execute($q,$p);

$q="DELETE FROM ".cms_db_prefix()."module_polls WHERE id=?";
$p=array($params["pollid"]);
$result=$db->Execute($q,$p);

$this->Redirect($id,"defaultadmin",$return,array("module_message"=>$this->Lang("polldeleted")));

?>