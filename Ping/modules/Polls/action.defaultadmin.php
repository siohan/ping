<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

$showwhatpoll=$this->GetPreference("showwhatpoll","defaultpoll");

$showpeekbutton=$this->GetPreference("showpeekbutton");
$registervotedby=$this->GetPreference("registervotedby","session");
$polltemplate=$this->GetPreference("polltemplate", $this->GetTemplateFromFile("defaultpoll"));
$resulttemplate=$this->GetPreference("resulttemplate", $this->GetTemplateFromFile("defaultresult"));
$polllisttemplate=$this->GetPreference("polllisttemplate", $this->GetTemplateFromFile("defaultpolllist"));

if (isset($params["hidedonationssubmit"])) {
  $this->SetPreference("hidedonationstab",$this->GetVersion());
}

$tab="";
if (isset($params["tab"])) $tab=$params["tab"];

echo $this->StartTabHeaders();

if ($this->CheckPermission('administratepolls')) {
  echo $this->SetTabHeader("polls",$this->Lang("polls"),($tab=="polls"));
}

if ($this->CheckPermission('Modify Site Preferences')) {
  echo $this->SetTabHeader("settings",$this->Lang("settings"),($tab=="settings"));
}
if ($this->CheckPermission('Modify Templates')) {
  echo $this->SetTabHeader("polltpl",$this->Lang("polltemplate"),($tab=="polltemplate"));
  echo $this->SetTabHeader("resulttpl",$this->Lang("resulttemplate"),($tab=="resulttemplate"));
}

if ($this->ShowDonationsTab()) {
  echo $this->SetTabHeader("donations",$this->lang("donationstab"),($tab=="donations"));
}

echo $this->EndTabHeaders();
echo $this->StartTabContent();

if ($this->CheckPermission('administratepolls')) {
  echo $this->StartTab("polls");
  include(dirname(__FILE__)."/tab.pollist.php");
  echo $this->EndTab();
}

if ($this->CheckPermission('Modify Site Preferences')) {
  echo $this->StartTab("settings");
  include(dirname(__FILE__)."/tab.settings.php");
  echo $this->EndTab();
}

if ($this->CheckPermission('Modify Templates')) {
  echo $this->StartTab("polltpl");
  include(dirname(__FILE__)."/tab.polltemplate.php");
  echo $this->EndTab();

  echo $this->StartTab("resulttpl");
  include(dirname(__FILE__)."/tab.resulttemplate.php");
  echo $this->EndTab();
}

if ($this->ShowDonationsTab()) {
  echo $this->StartTab("donations");
  include(dirname(__FILE__)."/tab.donation.php");
  echo $this->EndTab();
}

echo $this->EndTabContent();



?>