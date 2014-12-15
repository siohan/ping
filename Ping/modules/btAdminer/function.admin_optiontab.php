<?php

#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.1
# File   : function.admin_optiontabs.php
# Purpose: tab to btAdminer preferences
# License: GPL
#
#-------------------------------------------------------------------------------

if (!$this->CheckPermission('Set btAdminer Prefs')) return;

$smarty->assign('startForm', $this->CreateFormStart($id, 'admin_editoption', $returnid,'post','multipart/form-data'));
$smarty->assign('endForm',	 $this->CreateFormEnd());
$smarty->assign('submit',    $this->CreateInputSubmit($id, 'submit', lang('submit')));

$smarty->assign('prompt_display', $this->Lang('prompt_display'));
$smarty->assign('input_display',$this->CreateInputDropdown($id, 'display', array('iFrame' => 'iframe', 'Lightbox' => 'lightbox'), -1, $this->GetPreference('display')));

$smarty->assign('prompt_lightboxstyle', $this->Lang('prompt_lightboxstyle'));
$smarty->assign('input_lightboxstyle',$this->CreateInputDropdown($id, 'lightboxstyle', array('white' => 'white', 'dark' => 'dark'), -1, $this->GetPreference('lightboxstyle')));

$smarty->assign('prompt_frameheight', $this->Lang('prompt_frameheight'));
$smarty->assign('input_frameheight', $this->CreateInputText($id, 'frameheight', $this->GetPreference('frameheight', ''), 50));

$smarty->assign('prompt_admin_section', $this->Lang('prompt_admin_section'));
$smarty->assign('input_admin_section', $this->CreateInputDropdown($id, 'admin_section', array($this->Lang('nav_main') => 'main', $this->Lang('nav_content') => 'content', $this->Lang('nav_layout') => 'layout', $this->Lang('nav_usersgroups') => 'usersgroups', $this->Lang('nav_extensions') => 'extensions', $this->Lang('nav_siteadmin') => 'siteadmin', $this->Lang('nav_myprefs') => 'myprefs'), -1, $this->GetPreference('admin_section')));

$smarty->assign('globaloptions', $this->Lang('globaloptions'));

$smarty->assign('prompt_xmlexport', $this->Lang('prompt_xmlexport'));
$smarty->assign('input_xmlexport', $this->CreateInputCheckbox($id, 'xmlexport', '1', $this->GetPreference('xmlexport')));

$smarty->assign('prompt_zipexport', $this->Lang('prompt_zipexport'));
$smarty->assign('input_zipexport', $this->CreateInputCheckbox($id, 'zipexport', '1', $this->GetPreference('zipexport')));

$smarty->assign('prompt_foreign', $this->Lang('prompt_foreign'));
$smarty->assign('input_foreign', $this->CreateInputCheckbox($id, 'foreign', '1', $this->GetPreference('foreign')));

$smarty->assign('prompt_textarea', $this->Lang('prompt_textarea'));
$smarty->assign('input_textarea', $this->CreateInputCheckbox($id, 'textarea', '1', $this->GetPreference('textarea')));

$smarty->assign('prompt_enum', $this->Lang('prompt_enum'));
$smarty->assign('input_enum', $this->CreateInputCheckbox($id, 'enum', '1', $this->GetPreference('enum')));

echo $this->ProcessTemplate('optiontab.tpl');

