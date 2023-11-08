<?php
if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
$ping = cms_utils::get_module("Ping");

$query = "SELECT idepreuve, CONCAT(saison, ' | ',name) AS epr, saison FROM ".cms_db_prefix()."module_ping_type_competitions WHERE indivs= 0 AND actif = 1 ORDER BY saison DESC,name ASC";
$dbresult= $db->Execute($query);
	$phase = array("1"=>"Phase 1", "2"=>"phase 2");
	$rowarray= array();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			$data = array();
    			while ($row= $dbresult->FetchRow())
      			{					
					foreach ($phase as $key=>&$tab)
					{
						//$data[$row['idepreuve'].'-'.$key] = $row['name'].'('.$row['idepreuve'].') - '.$row['saison'].' - '.$tab;
						$data[$row['idepreuve'].'-'.$key] = $row['epr'].' | '.$tab;		
					}				
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
