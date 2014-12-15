<?php
#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.1
# File   : action.admin_editoption.php
# Purpose: saves the preferences in the database
# License: GPL
#
#-------------------------------------------------------------------------------

if (!$this->CheckPermission('Set btAdminer Prefs')) return;

$this->SetPreference('admin_section', isset($params['admin_section']) ? $params['admin_section'] : 'siteadmin');
$this->SetPreference('display', isset($params['display']) ? $params['display'] : 'iframe');
$this->SetPreference('lightboxstyle', isset($params['lightboxstyle']) ? $params['lightboxstyle'] : 'white');
$this->SetPreference('frameheight', isset($params['frameheight']) ? $params['frameheight'] : '800');
$this->SetPreference('zipexport', isset($params['zipexport']) ? $params['zipexport'] : '0');
$this->SetPreference('xmlexport', isset($params['xmlexport']) ? $params['xmlexport'] : '0');
$this->SetPreference('foreign', isset($params['foreign']) ? $params['foreign'] : '0');
$this->SetPreference('textarea', isset($params['textarea']) ? $params['textarea'] : '0');
$this->SetPreference('enum', isset($params['enum']) ? $params['enum'] : '0');

$this->Redirect($id, 'defaultadmin', $returnid, array('message'=> 'options_updated', 'active_tab' => 'optiontab'));
