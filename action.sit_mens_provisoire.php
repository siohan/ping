<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;

$saison_courante = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');

$mois_courant = date('n');
$jour_courant = date('j');

if($jour_courant <=10)
{
	$mois_courant = $mois_courant-1;
}

//$mois_courant = 3;

$query="SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur, SUM(sp.pointres) AS Total, j.licence FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_parties_spid AS sp  ON sp.licence = j.licence WHERE sp.saison = ? AND j.actif='1' AND MONTH(date_event) = ? OR MONTH(date_event) IS NULL";	
/*
if($phase == 1)
{
	
	$query.=" AND MONTH(date_event) > 8 AND MONTH(date_event)<=12";
}
else
{
	
		$query.="  AND MONTH(date_event)<=7";
	
}
*/
$query.=" GROUP BY joueur ORDER BY Total DESC";
$dbresult = $db->Execute($query, array($saison_courante,$mois_courant));
//echo $query;
$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount()>0)	
	{
		while($row= $dbresult->FetchRow())
		{
			$licence = $row['licence'];
			$joueur = $row['joueur'];
			$pointres = $row['Total'];	
			$query2 = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND saison = ?";
			$dbresult2 = $db->Execute($query2,array($licence,$mois_courant, $saison_courante));
			$row2 = $dbresult2->FetchRow();
						
			$points_ref = $row2['points'];
			$somme = $points_ref+$pointres;
			
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->joueur= $row['joueur'];
			$onerow->clt= $points_ref;
			$onerow->somme= $somme;
			$onerow->bilan= $pointres;
			$onerow->details= $this->CreateLink($id, 'user_results_prov', $returnid, 'Détails',array('licence'=>$row['licence'],'month'=>$mois_courant));
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
	}
	
$smarty->assign('returnlink', 
		$this->CreateFrontendLink($id,$returnid, 'sit_mens_provisoire',$addtext='Retour'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('sitmens_prov.tpl');


#
# EOF
#
?>