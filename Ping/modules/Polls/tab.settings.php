<?php

if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

$this->smarty->assign('formstart', $this->CreateFormStart($id, "savesettings", $returnid));
$this->smarty->assign('formend', $this->CreateFormEnd());
$this->smarty->assign('submit', $this->CreateInputSubmit($id, "submit", $this->Lang("savesettings")));
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, "cancel", $this->Lang("cancel")));

$this->smarty->assign('showpeekbuttontext', $this->Lang("showpeekbutton"));
$this->smarty->assign('showpeekbutton', $this->CreateInputCheckBox($id, "showpeekbutton", 1, $showpeekbutton));

$this->smarty->assign('showwhatpolltext', $this->Lang("showwhatpoll"));
$showwhatpollarray = array($this->Lang("defaultpoll") => "defaultpoll", $this->Lang("randompoll") => "randompoll", $this->Lang("allopen") => "allopen");
$this->smarty->assign('showwhatpolldropdown', $this->CreateInputDropdown($id, "showwhatpoll", $showwhatpollarray, -1, $showwhatpoll));

$this->smarty->assign('registervotedbytext', $this->Lang("registervotedby"));
$registervotedbyarray= array($this->Lang("oncepersession") => "session", $this->Lang("onceperip") => "ip", $this->Lang("always") => "always");
$this->smarty->assign('registervotedbydropdown', $this->CreateInputDropdown($id, "registervotedby", $registervotedbyarray, -1, $registervotedby));


echo $this->ProcessTemplate("settings.tpl");
?>
