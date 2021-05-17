<?php 
if(!isset($gCms)) exit;

if(!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
		return;
}
$db = cmsms()->GetDb();

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('exports_teamsresults.tpl'), null, null, $smarty);
$tpl->display();