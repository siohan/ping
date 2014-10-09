<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$saison_courante = $this->GetPreference('saison_en_cours');
/* on fait un formulaire de filtrage des résultats*/
/*
$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin'));  
//$tourlist = array(0 =>"0",1 =>"1",2 =>"2",3 =>"3",4 =>'All');
$typeCompetition = array();
$tourlist = array();
$tourlist[$this->Lang('alltours')] = '';
$allequipes =  ( isset( $params['allequipes'] )?$params['allequipes']:'no');

$equipelist[$this->Lang('allequipes')] = '';

$query = "SELECT * FROM ".cms_db_prefix()."module_ping_rencontres AS ren, ".cms_db_prefix()."module_ping_competitions AS comp WHERE ren.type_compet = comp.code_compet";
$dbresult = $db->Execute($query);
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $tourlist[$row['tour']] = $row['tour'];
    $equipelist[$row['equipe']] = $row['equipe'];
    $typeCompetition[$row['name']] = $row['type_compet'];
  }

if( isset($params['submitfilter']) )
  {
    if( isset( $params['tourlist']) )
      {
	$this->SetPreference('tourChoisi', $params['tourlist']);
      }
    if( isset( $params['equipelist']))
	{
	$this->SetPreference( 'equipeChoisie', $params['equipelist']);
	}
    if( isset( $params['typeCompet']))
		{
		$this->SetPreference( 'competChoisie', $params['typeCompet']);
		}
}
$curtour = $this->GetPreference( 'tourChoisi' );
$curequipe = $this->GetPreference( 'equipeChoisie' );
$curcompet = $this->GetPreference('competChoisie');

$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompetition,-1,$curcompet));

$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_tour',
		$this->CreateInputDropdown($id,'tourlist',$tourlist,-1,$curtour));
		$smarty->assign('prompt_equipe',
				$this->Lang('equipe'));
$smarty->assign('input_equipe',
		$this->CreateInputDropdown($id,'equipelist',$equipelist,-1,$curequipe));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());
*/

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipes');
$smarty->assign('tour', 'Tour');
$smarty->assign('score', 'Score');
$smarty->assign('adversaires', 'Adversaires');

$result= array ();
$query = "SELECT *, eq.id,comp.name FROM ".cms_db_prefix()."module_ping_equipes AS eq, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE eq.saison = ? AND (comp.code_compet = eq.type_compet OR eq.type_compet IS NULL) ";
//$parms['saison_en_cours'] = $saison_courante;

/*
	if( isset($params['submitfilter'] )){
if ($curtour !='')
{
	$query .=" AND ren.tour = ?";
	$parms['tour'] = $curtour;
		
}
else {
	$query.=" AND ren.tour > 0 ";
	$parms ='';
}
if( $curequipe != ''){
	$query .=" AND ren.equipe = ? ";
	$parms['equipe'] = $curequipe;
	
}
if($curcompet != '')
{
	$query.=" AND ren.type_compet = ?";
	$parms['type_compet'] = $curcompet;
}
else
{
	$query.=" AND type_compet LIKE '%'";
	$parms = '';
}

$dbresult= $db->Execute($query,$parms);
}
*/




	$query .=" ORDER BY eq.id ASC";
	$dbresult= $db->Execute($query,array($saison_courante));

//echo $query;
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	//$onerow->equipe= $row['equipe'];
	$onerow->libequipe=  $row['libequipe'];
	$onerow->libdivision= $row['libdivision'];
	$onerow->friendlyname= $row['friendlyname'];
	$onerow->name= $row['name'];
	//$onerow->view= $this->createLink($id, 'viewteamresult', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('download_poule_results'), '', '', 'systemicon'),array('cle'=>$row['cle'])) ;
	$onerow->editlink= $this->CreateLink($id, 'edit_team', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
	$onerow->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('download_poule_results'), '', '', 'systemicon'), array('idpoule'=>$row['idpoule'], 'iddiv'=>$row['iddiv'], 'type_compet'=>$row['type_compet']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_team', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('retrieve_teams',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes (championnat seniors)", array('type'=>'M')));
$smarty->assign('retrieve_teams_autres',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes"));



echo $this->ProcessTemplate('teamscores.tpl');


#
# EOF
#
?>