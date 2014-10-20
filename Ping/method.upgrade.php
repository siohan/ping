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
	$dict = NewDataDictionary( $db );
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_equipes",
					      "type_compet C(3)");
	$dict->ExecuteSQLArray( $sqlarray );
	
	
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_poules_rencontres",
					      "affiche L");
	$dict->ExecuteSQLArray( $sqlarray );
	
	
	$sqlarray = $dict->DropColumnSQL(cms_db_prefix()."module_ping_competitions",
					      "indivs");
	$dict->ExecuteSQLArray( $sqlarray );
	
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_parties_spid",
					      "type_ecart I(11)");
	$dict->ExecuteSQLArray( $sqlarray );
	//qqs changements dans la table calendrier
	$sqlarray = $dict->RenameColumnSQL(cms_db_prefix()."module_ping_calendrier",
					      "date_compet", "date_debut");
 	$dict->ExecuteSQLArray( $sqlarray );

	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_calendrier",
					     "date_debut D");
 	$dict->ExecuteSQLArray( $sqlarray );
	$sqlarray = $dict->AddcolumnSQL(cms_db_prefix()."module_ping_calendrier",
					      "date_fin D");
	$dict->ExecuteSQLArray( $sqlarray );
	
	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup_parties",
					     "datemaj ". CMS_ADODB_DT. "");
 	$dict->ExecuteSQLArray( $sqlarray );

	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_sit_mens",
					     "datecreated ". CMS_ADODB_DT. "");
 	$dict->ExecuteSQLArray( $sqlarray );

	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_sit_mens",
					     "datemaj ". CMS_ADODB_DT. "");
 	$dict->ExecuteSQLArray( $sqlarray );


	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_comm",
					     "datecreated ". CMS_ADODB_DT. "");
 	$dict->ExecuteSQLArray( $sqlarray );

	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_comm",
					     "datemaj ". CMS_ADODB_DT. "");
 	$dict->ExecuteSQLArray( $sqlarray );

	$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup",
					     "datecreated ". CMS_ADODB_DT. "");
 	$dict->ExecuteSQLArray( $sqlarray );

	



 case "0.1beta3" : 

	
	$dict = NewDataDictionary( $db );
	$flds = "
		licence I(11),
		type_compet C(3)";

	// create it. 
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_participe",
					   $flds, 
					   $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);
	

}

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>