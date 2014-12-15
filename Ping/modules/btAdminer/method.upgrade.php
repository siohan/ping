<?php
#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.0
# File   : method.uninstall.php
# Purpose: upgrade btAdminer
# License: GPL
#
#-------------------------------------------------------------------------------

// Check authorisation
if(!is_object(cmsms())) exit;

// Get version
$current_version = $oldversion;

// Get db handle
$tbDb = cmsms()->GetDb();
$dict = NewDataDictionary($tbDb);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

switch ($current_version) {
	case '1.3':
		$current_version = '1.4';
		
		$this->SetPreference('lightboxstyle', 'white');
		
}
// Write message to admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('updated',$this->GetVersion()));


// EOF