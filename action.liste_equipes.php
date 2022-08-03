<?php
if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
$ping = cms_utils::get_module("Ping");

$phase_courante = $ping->GetPreference('phase_en_cours');

$phase = (isset($_POST['phase']))?$_POST['phase']:$phase_courante;
$saison = (isset($_POST['saison_en_cours']))?$_POST['saison_en_cours']:$ping->GetPreference('saison_en_cours');


$query = "SELECT DISTINCT *, friendlyname,CONCAT_WS('-', libequipe, libdivision, saison) AS equipe,eq.id AS eq_id FROM ".cms_db_prefix()."module_ping_equipes AS eq ";//WHERE eq.saison = ? AND phase = ?";
$query.=" ORDER BY eq.saison DESC, eq.phase DESC,eq.idepreuve ASC,eq.numero_equipe ASC";	
//echo $query;
$dbresult= $db->Execute($query);//, array($saison, $phase));

	$rowarray= array();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			$data = array();
    			while ($row= $dbresult->FetchRow())
      			{					
					$data[$row['eq_id']] = $row['equipe'];						
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
