<?php
#-------------------------------------------------------------------------
# Module: Skeleton - a pedantic "starting point" module
# Version: 1.5, SjG
# Method: Upgrade
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------

/**
 * For separated methods, you'll always want to start with the following
 * line which check to make sure that method was called from the module
 * API, and that everything's safe to continue:
*/ 
if (!isset($gCms)) exit;


/**
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Upgrade() method in the module body.
 */

$current_version = $oldversion;
switch($current_version)
{
  // we are now 1.0 and want to upgrade to latest
 case "0.1beta1":
   //do magic
 case "0.1beta2":
   //and this is here for the next version
 case "1.2":
 case "1.3":
 case "1.4":
 case "1.5":
 case "1.6":
 case "1.7":
 case "1.8":
	// here's an example -- we expand the Skeleton database record to include another field.
	$db = $gCms->GetDb();
	$dict = NewDataDictionary( $db );
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_skeleton", "explanation X");
	$dict->ExecuteSQLArray($sqlarray);
}

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>