<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) exit;

$this->SetPreference("defaultpoll",$params["pollid"]);

$this->Redirect($id,"defaultadmin");

?>