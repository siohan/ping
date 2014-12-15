<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) exit;

$activepoll=$this->GetPreference("defaultpoll");
if ($params["pollid"]==$activepoll) exit;

$db=&$this->GetDb();
$q="UPDATE ".cms_db_prefix()."module_polls SET closed=?,closetime=? WHERE id=?";
$p=array(1,time(),$params["pollid"]);
$result=$db->Execute($q,$p);


$this->Redirect($id,"defaultadmin",$return,array("module_message"=>$this->Lang("pollwasclosed")));

?>