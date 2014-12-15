<?php

if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["newcontent"])) exit;
if (!isset($params["template"])) exit;

$message="";$tab="";
if (isset($params["submit"])) {
  $this->SetPreference($params["template"],$params["newcontent"]);
  $message=$this->Lang("templatesaved");
} elseif (isset($params["reset"])) {
	switch ($params["template"]) {
		case "polltemplate" : $this->SetPreference("polltemplate", $this->GetTemplateFromFile("defaultpoll")); $tab="polltemplate"; break;
		case "resulttemplate" : $this->SetPreference("resulttemplate", $this->GetTemplateFromFile("defaultresult"));$tab="resulttemplate";  break;
		case "polllisttemplate" : $this->SetPreference("polllisttemplate", $this->GetTemplateFromFile("defaultpolllist")); break;
	}
	$message=$this->Lang("templatereset");
} //else what??

$this->Redirect($id,"defaultadmin",$returnid,array("module_message"=>$message,"tab"=>$tab));

?>