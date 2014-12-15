<?php

#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.1
# File   : action.defaultadmin.php
# Purpose: performs the default backend action if "Extensions->btAdminer" is selected
# License: GPL
#
#-------------------------------------------------------------------------------

if(!function_exists('cmsms') || !is_object(cmsms())) exit;

if (!$this->CheckPermission('Use btAdminer')) {
	return;
}

$config = cmsms()->GetConfig();
$gCms = cmsms();
$language = get_preference(get_userid(FALSE),"default_cms_language","en_US");
$langshort = substr($language, 0,2);
$adminerlang = array("en", "cs", "sk", "nl", "es", "de", "fr", "it", "et", "hu", "pl", "ca", "pt", "sl", "tr", "ru", "zh", "ar");

$lang = in_array($langshort, $adminerlang) ? $langshort : 'en';

// Adminer Session
// Need to have cookie visible from parent directory
session_set_cookie_params(0, '/', '', 0);
// Create signon session
$session_name = 'btAdminer';
session_name($session_name);
//session_start();

$host = $config['db_hostname'];
if (isset($config["db_port"]) and $config['db_port'] != '') $host.=':'.$config['db_port'];

// Store there credentials in the session
$_SESSION['ADM_driver'] = 'server';
$_SESSION['ADM_user'] = $config['db_username'];
$_SESSION['pwds'][$_SESSION['ADM_driver']][$host][$config['db_username']] = $config['db_password'];
$_SESSION['ADM_password'] = $config['db_password'];
$_SESSION['ADM_server'] = $host;
$_SESSION['ADM_db'] = $config['db_name'];
$_SESSION['ADM_hideOtherDBs'] = '';
// Get signon uri for redirect
$_SESSION['ADM_SignonURL'] = $config['root_url'].'/modules/btAdminer/btAdminer.php';
$_SESSION['ADM_LogoutURL'] = $config['root_url'].'/'.$config['admin_dir'].'/logout.php';
$_SESSION['ADM_uploadDir'] = $config['uploads_path'];
// Plugins
$_SESSION['ADM_plugin_zipexport'] = $this->GetPreference('zipexport');
$_SESSION['ADM_plugin_xmlexport'] = $this->GetPreference('xmlexport');
$_SESSION['ADM_plugin_foreign'] = $this->GetPreference('foreign');
$_SESSION['ADM_plugin_textarea'] = $this->GetPreference('textarea');
$_SESSION['ADM_plugin_enum'] = $this->GetPreference('enum');
// root_url
$_SESSION['ADM_root_url'] = $config['root_url'];

$sid = session_id();
// Force to set the cookie
setcookie($session_name, $sid, 0, '/', '');
// Close that session
session_write_close();



if (isset($params['message'])) {
	echo $this->ShowMessage($this->Lang($params['message']));
}

if (isset($params['errors']) && count($params['errors'])) {
	echo $this->ShowErrors($params['errors']);
}

if($this->CheckPermission('Set btAdminer Prefs')) {

	if (!empty($params['active_tab'])) {
		$tab = $params['active_tab'];
	} else {
		$tab = $this->CheckPermission('Set btAdminer Prefs') ? 'adminertab' : 'optiontab';
	}

	echo $this->StartTabHeaders();

	echo $this->SetTabHeader('adminertab', 'btAdminer', ($tab == 'adminertab'));
	echo $this->SetTabHeader('optiontab', $this->Lang('options'), ($tab == 'optiontab'));


	echo $this->EndTabHeaders();
	echo $this->StartTabContent();

	echo $this->StartTab('adminertab', $params);
	include dirname(__FILE__) . '/function.admin_adminertab.php';
	echo $this->EndTab();

	echo $this->StartTab('optiontab', $params);
	include dirname(__FILE__) . '/function.admin_optiontab.php';
	echo $this->EndTab();

	echo $this->EndTabContent();

} else {
	include dirname(__FILE__) . '/function.admin_adminertab.php';
}
