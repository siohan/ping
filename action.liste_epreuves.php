<?php
if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
$ping = cms_utils::get_module("Ping");

$query = "SELECT idepreuve, name, saison FROM ".cms_db_prefix()."module_ping_type_competitions WHERE indivs='0' AND actif = 1 ORDER BY name ASC";
$dbresult= $db->Execute($query);

	$rowarray= array();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			$data = array();
    			while ($row= $dbresult->FetchRow())
      			{					
					$data[$row['idepreuve']] = $row['name'].'('.$row['idepreuve'].') - '.$row['saison'];						
      			}
      	}
  		
  		foreach ($data as $key=> $value) 
  		{
			echo "$value=$key,";
		}	
  		
#
# EOF
#
?>
