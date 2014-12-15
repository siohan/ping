<?php
if (!function_exists("cmsms")) exit;
$this->smarty->assign("module",$this);

$this->smarty->assign("formstart",$this->CreateFormStart($id,"defaultadmin"));
$this->smarty->assign("formend",$this->CreateFormEnd());
$this->smarty->assign("hidesubmit",$this->CreateInputSubmit($id,"hidedonationssubmit",$this->Lang("hidedonationssubmit")));
$this->smarty->assign("donationstext",$this->Lang("donationstext"));
$this->smarty->assign("sponsorstext",$this->Lang("sponsors"));

echo $this->ProcessTemplate("admindonations.tpl");

?>
