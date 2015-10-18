<?php
##################################################################
#                                                               ##
#        Administration des classements                             ##
#                                                               ##
##################################################################

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');

$nom_equipes = $this->GetPreference('nom_equipes');
/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin2','', 'post', '',false,'',array('active_tab'=>'divisions')));
$datelist[$this->Lang('alldates')] = '';	
//$idorgalist[$this->Lang('allplayers')] = 'Toutes';
$typeCompet = array();
$typeCompet[$this->Lang('allcompet')] = '';
$query1 = "SELECT tc.idepreuve,tc.idorga, tc.name FROM ".cms_db_prefix()."module_ping_type_competitions AS tc, ".cms_db_prefix()."module_ping_div_tours AS dt WHERE tc.idepreuve = dt.idepreuve ORDER BY tc.name ASC ";//" , ".cms_db_prefix()."module_ping_joueurs AS j WHERE pts.licence  = j.licence AND pts.saison = ? ORDER BY j.nom ASC, pts.date_event ASC";//"";
$dbresult = $db->Execute($query1);
while ($dbresult && $row = $dbresult->FetchRow())
  {
    //$datelist[$row['date_event']] = $row['date_event'];
    //$playerslist[$row['player']] = $row['licence'];
    //$idorgalist =  array("Aucun"=>"Aucun","National"=>"F","Zone"=>"Z", "Régional"=>"L","Départemental"=>"D");//$idorgalist[$row['idorga']] = $row['name'];
    $typeCompet[$row['name']] = $row['idepreuve'];
  }

	if( isset($params['submitfilter']) )
  	{
    		if( isset( $params['typeCompet']) )
		{ 
			$curCompet = $params['typeCompet'];
		}
	}
	
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompet,-1,(isset($curCompet)?$curCompet:"")));	
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$fede = '100001';
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');

$result= array ();
$query = "SELECT id, idepreuve,iddivision,tableau,tour,rang, nom,clt,club,points, saison FROM ".cms_db_prefix()."module_ping_div_classement";

$dbresult= $db->Execute($query);
// the top nav bar
//$smarty->assign('returnlink', $this->CreateLink($id,'defaultadmin',$returnid,$themeObject->DisplayImage('icons/system/back.gif', $this->Lang('back'), '', '', 'systemicon'),array("active_tab"=>"divisions")));
//$this->CreateLink($id, 'edit_type_compet',$returnid,$themeObject->DisplayImage('icons/topfiles/template.gif', $this->Lang('edit'), '', '', 'systemicon'),array("record_id"=>$row['id']));

$rowclass = '';
//echo $query;
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$club = $row['club'];
	if(substr_count($club,$nom_equipes)>0)
	{
		$mon_club = 1;
	}
	else
	{
		$mon_club = 0;
	}
	
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->tour_id = $row['id'];
	$onerow->idepreuve= $row['idepreuve'];
	$onerow->iddivision= $row['iddivision'];
	$onerow->tour= $row['tour'];
	$onerow->tableau = $row['tableau'];
	$onerow->rang= $row['rang'];
	$onerow->nom= $row['nom'];
	$onerow->clt = $row['clt'];
	$onerow->mon_club = $mon_club;
	$onerow->club = $row['club'];
	
	//$onerow->poule= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Poule',array("direction"=>"tour","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision']));
	$onerow->classement= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Classement',array("direction"=>"classement","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"tableau"=>$row['tableau'],"tour"=>$row['tour']));
	$onerow->partie= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Parties',array("direction"=>"partie","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"tableau"=>$row['tableau'],"tour"=>$row['tour']));
	
	//$onerow->editlink = $this->CreateLink($id, 'edit_type_compet',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array("record_id"=>$row['id']));
	
	if($this->CheckPermission('Ping Delete'))
	{
		$onerow->deletelink = $this->CreateLink($id, 'delete', $returnid,$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'),array("record_id"=>$row['id'], "type_compet"=>"type_compet"));
	}
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
else {
	echo "<p>Aucun résultats !</p>";
}
$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Supprimer"=>"supp_div_classement");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('list_classement.tpl');


#
# EOF
#
?>