<?php

#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.1
# File   : function.admin_adminertab.php
# Purpose: tab to display btAdminer
# License: GPL
#
#-------------------------------------------------------------------------------

if (!$this->CheckPermission('Use btAdminer')) return;

$url = $config['root_url'].'/modules/btAdminer/btAdminer.php?lang='.$lang.'&db='.$config['db_name'].'&server='.$config['db_hostname'].'&username='.$config['db_username'];

$smarty->assign('url', $url);
$smarty->assign('frameheight', $this->GetPreference('frameheight'));
$smarty->assign('display', $this->GetPreference('display'));
$smarty->assign('prompt_openinlightbox', $this->Lang('openinlightbox'));

echo $this->ProcessTemplate('adminertab.tpl');

