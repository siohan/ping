<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$saison = $this->GetPreference('saison_en_cours');
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
//$query= "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE joueur = ? ORDER BY id ASC";
$query = "SELECT *, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND eq.saison = ? AND ren.affiche = '1' ";//AND ren.tour = ?";
$parms['saison'] = $saison;

	if ($this->GetPreference('affiche_club_uniquement') =='Oui') {
		$query.=" AND ren.club = '1'";
	
	}	
	if(isset($params['tour']) || $params['tour'] !=''){
		$tour = $params['tour'];
		$query.=" AND ren.tour = ?";
		$parms['tour'] = $tour;
		//$dbresult= $db->Execute($query, array($saison_courante, $tour));
	}
	else
	{
		//$dbresult= $db->Execute($query, array($saison_courante));
	}
	if(isset($params['type_compet']) && $params['type_compet'] !='')
	{
		$type_compet = $params['type_compet'];
		$query.=" AND eq.type_compet = ?";
		$parms['type_compet'] = $type_compet;
	}
	
	
//$query.= " GROUP BY ren.date_event ";
$query.=" ORDER BY ren.date_event DESC";
$dbresult= $db->Execute($query, $parms);
//echo $query;
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->date_event= $row['date_event'];
	$equb = $row['equb'];
	$equa = $row['equa'];
	$friendlyname = $row['friendlyname'];
	$libequipe = $row['libequipe'];


	//$onerow->equipe= $row['equipe'];
	$onerow->libelle=  $row['libelle'] ;
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equa)
		{
			$onerow->equa= $row['friendlyname'];
		}
		
		else{
			$onerow->equa= $row['equa'];
		}
		
	}
	else{
		$onerow->equa= $row['equa'];
	}
	$onerow->scorea= $row['scorea'];
	$onerow->scoreb= $row['scoreb'];
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equb)
		{
			$onerow->equb= $row['friendlyname'];
		}
		
		else{
			$onerow->equb= $row['equb'];
		}
		
	}
	else{
		$onerow->equb= $row['equb'];
	}

	$onerow->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row['id']));
//	$onerow->deletelink= $this->CreateLink($id, 'delete_team_result', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }

/**/
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
//on va essayer de construire dynamiquement des liens vers les différentes journées de championnat de France par équipes
/*
for($i=1;$i<=10;$i++){
	$smarty->assign("lienj$i",
	$this->CreateFrontendLink($id,$returnid,'fe_view_teams_results', $contents = "J$i", array("numjourn"=>"$i")));
}
*/
$smarty->assign('lienj1',
		$this->CreateFrontendLink($id,$returnid,'fe_view_teams_results', $contents = 'J1', array('numjourn'=>'1')));
$smarty->assign('lienj2',
		$this->CreateFrontendLink($id,$returnid,'fe_view_teams_results', $contents = 'J2', array('numjourn'=>'2')));

/**/
echo $this->ProcessTemplate('fepoulesRencontres.tpl');


#
# EOF
#
?>