<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["optionid"])) exit;
if (!isset($params["pollid"])) exit;

//$activepoll=$this->GetPreference("activepoll");
//if ($params["pollid"]==$activepoll) exit;

$db=$this->GetDb();
$q="DELETE FROM ".cms_db_prefix()."module_polloptions WHERE id=?";
$p=array($params["optionid"]);
$result=$db->Execute($q,$p);

$this->Redirect($id,"editpoll",$return,array("pollid"=>$params["pollid"],"module_message"=>$this->Lang("optiondeleted")));

?>