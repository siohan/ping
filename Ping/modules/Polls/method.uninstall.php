<?php
if (!function_exists("cmsms")) exit;

$db =$this->GetDb();

// remove the database table
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_polls" );
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence( cms_db_prefix()."module_polls_seq" );

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_polloptions" );
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence( cms_db_prefix()."module_polloptions_seq" );

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_pollresults" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_pollblocked" );
$dict->ExecuteSQLArray($sqlarray);

// remove the permissions
$this->RemovePermission('administratepolls');

// remove the preference
$this->RemovePreference();

// remove the event
//$this->RemoveEvent( 'OnSkeletonPreferenceChange' );

// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));
?>