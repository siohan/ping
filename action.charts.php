<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
/**/
$db = cmsms()->GetDb();
$record_id = '292271';
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	$smarty->assign('record_id', $record_id);
}


	$saison = (isset($params['saison']) ? $params['saison'] : $this->GetPreference('saison_en_cours'));
	$phase = $this->GetPreference('phase');
	$tableau_mois_courts = array("1"=>"Jan","2"=>"Fev","3"=>"Mar","4"=>"Avr","5"=>"Mai","6"=>"Juin","7"=>"Juil","8"=>"Aout","9"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec");
	
	$j = new joueurs;	
	$det_j = $j->details_joueur($record_id);
	$nom = $det_j['prenom']." ".$det_j['nom'];
	$smarty->assign('nom', $nom);
	$voyelle = array("a", "e", "i","o","u", "y");
	if (true == in_array(substr($det_j['prenom'], 1,1),$voyelle))
	{
			$smarty->assign('voyelle', 1);
			$smarty->assign('pagetitle', 'Les résultats de '.$nom);
	}
	else
	{
			$smarty->assign('voyelle', 0);
			$smarty->assign('pagetitle', 'Les résultats d\''.$nom);
	}
	$victoires = (int) $j->victoires($record_id,$saison);
	$parties = (int) $j->parties_disputees($record_id, $saison);
	if($parties == 0)
	{
		echo $nom." n'a pas encore de résultats";
	}
	else
	{
		
		$defaites = $parties-$victoires;
		$pourcentage_victoires = round(($victoires/$parties)*100,2);
		$pourcentage_defaites = round(100-$pourcentage_victoires, 2);
		$victoires_normales = (int)$j->victoires_normales($record_id, $saison);
		$victoires_anormales = (int)$j->victoires_anormales($record_id, $saison);
		$defaites_normales = (int)$j->defaites_normales($record_id, $saison);
		$defaites_anormales = (int)$j->defaites_anormales($record_id, $saison);
		$perf = $j->meilleure_perf($record_id, $saison);
		//var_dump($perf);
		//echo json_encode($victoires_normales);
		
		$smarty->assign('victoires', json_encode($victoires));
		$smarty->assign('defaites', json_encode($defaites));
		
		$smarty->assign('victoires_normales', json_encode($victoires_normales));
		$smarty->assign('victoires_anormales', json_encode($victoires_anormales));
		$smarty->assign('defaites_normales', json_encode($defaites_normales));
		$smarty->assign('defaites_anormales', json_encode($defaites_anormales));
		
		$smarty->assign('pourcentage_victoires', json_encode($pourcentage_victoires));
		$smarty->assign('pourcentage_defaites', json_encode($pourcentage_defaites));
		
		//on va chercher les points du joueur depuis le début de saison
		//pour réaliser des courbes de points
		$query = "SELECT licence, mois, points, progmois,progann FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND saison = ? ORDER BY datemaj ASC";
		$dbresult = $db->Execute($query, array($record_id, $saison));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$dataPoints = array();
				$i = 0;
				while($row = $dbresult->FetchRow())
				{
					
					$dataPoints[] = json_encode(["'".$tableau_mois_courts[$row['mois']]."'",$row['points']]);
					
				}
			}
		}
		foreach($dataPoints as $ar)
		    {
		        $newdata[]=str_replace('"', " ", trim($ar,'"')); 
		
		    }
		
		$dataPoints2 = implode(',',$newdata);
		$smarty->assign('dataPoints2', $dataPoints2);
		
		
		$query2 = "SELECT SUM(pointres) AS points, licence, epreuve FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ? GROUP BY epreuve";
		$dbresult2 = $db->Execute($query2, array($record_id, $saison));
		if($dbresult2)
		{
			if($dbresult2->RecordCount()>0)
			{
				
				$data2 = array();
				while($row2 = $dbresult2->FetchRow())
				{
					$data2[] = json_encode(["'".$row2['epreuve']."'",$row2['points']]);
				}
			}
		}
		
		
		foreach($data2 as $ar)
		{
		        $newdata2[]=str_replace('"', " ", trim($ar,'"')); 
		
		}
		$bardata = implode(',',$newdata2);
		$smarty->assign('bardata', $bardata);
		
		echo $this->ProcessTemplate('google_charts.tpl');
	}
$smarty->assign('record_id', $record_id);
	
		

#
# EOF
#
?>
