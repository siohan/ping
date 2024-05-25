<?php
if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
$ping = cms_utils::get_module("Ping");
$epreuves = new EpreuvesIndivs;
$club = $epreuves->nom_club();

$nclub="%".$club."%";
$query = "SELECT tc.idepreuve,tc.friendlyname, tc.saison FROM ".cms_db_prefix()."module_ping_type_competitions AS tc, ".cms_db_prefix()."module_ping_div_classement AS cla WHERE tc.idepreuve = cla.idepreuve AND tc.indivs= 1 AND tc.actif = 1 AND cla.club LIKE ? ORDER BY saison DESC,friendlyname ASC";
$dbresult= $db->Execute($query, array($nclub));
	
	$rowarray= array();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			$data = array();
    			while ($row= $dbresult->FetchRow())
      			{					
					
						//$data[$row['idepreuve'].'-'.$key] = $row['name'].'('.$row['idepreuve'].') - '.$row['saison'].' - '.$tab;
						$data[$row['idepreuve']] = $row['friendlyname'];		
									
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
