<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) exit;

/*
 * $activepoll=$this->GetPreference("activepoll");
if ($params["pollid"]==$activepoll) exit;
*/

$db=&$this->GetDb();
$q="UPDATE ".cms_db_prefix()."module_polloptions SET count=0 WHERE pollid=?";
$p=array($params["pollid"]);
$result=$db->Execute($q,$p);

$q="DELETE FROM ".cms_db_prefix()."module_pollblocked WHERE pollid=?";
$p=array($params["pollid"]);
$result=$db->Execute($q,$p);

$this->Redirect($id,"editpoll",$returnid,array("module_message"=>$this->Lang("pollreset"),"pollid"=>$params["pollid"]));

?>