<?PHP
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;
$this->smarty->assign('formstart', $this->CreateFormStart($id, "updatetemplate", $returnid));
$this->smarty->assign('formend', $this->CreateFormEnd());
$this->smarty->assign('templateid', $this->CreateInputHidden($id, "template", "resulttemplate"));
$this->smarty->assign('contenttext', $this->Lang("template"));
$this->smarty->assign('contenthelp', $this->Lang("resultcontenthelp"));
//$this->smarty->assign('contentinput', $this->CreateTextArea(false, $id, $resulttemplate, "newcontent"));
$this->smarty->assign('contentinput', $this->CreateTextArea(false, $id, $polltemplate, "newcontent",'', '', '', '', '80', '15','',"html"));
$this->smarty->assign('submit', $this->CreateInputSubmit($id, "submit", $this->Lang("ok")));
$this->smarty->assign('reset', $this->CreateInputSubmit($id, "reset", $this->Lang("resettodefault"), "", "", $this->Lang("confirmtemplate")));
echo $this->ProcessTemplate("template.tpl");
?>