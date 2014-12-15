<?php

#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.1
# File   : method.install.php
# Purpose: install btAdminer
# License: GPL
#
#-------------------------------------------------------------------------------

// set prefs
$this->SetPreference('admin_section', 'siteadmin');
$this->SetPreference('prog', 'adminer');
$this->SetPreference('display', 'lightbox');
$this->SetPreference('lightboxstyle', 'white');
$this->SetPreference('frameheight', '800');
$this->SetPreference('zipexport', '0');
$this->SetPreference('xmlexport', '0');
$this->SetPreference('calendar', '0');
$this->SetPreference('foreign', '0');
$this->SetPreference('textarea', '0');
$this->SetPreference('enum', '0');

// set permission
$this->CreatePermission('Use btAdminer', 'Use btAdminer');
$this->CreatePermission('Set btAdminer Prefs', 'Set btAdminer Prefs');

// message
$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('installed', $this->GetVersion()));
