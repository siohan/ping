<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
require_once(dirname(__FILE__).'/include/travaux.php');

$saison = $this->GetPreference('saison_en_cours');
/* on fait un formulaire de filtrage des résultats*/
/**/
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_poules_tab'));  
//$tourlist = array(0 =>"0",1 =>"1",2 =>"2",3 =>"3",4 =>'All');
//$typeCompetition = array();
$pouleslist = array();
$pouleslist[$this->Lang('allpoules')] = '';
//$allequipes =  ( isset( $params['allequipes'] )?$params['allequipes']:'no');

//$equipelist[$this->Lang('allequipes')] = '';

$query = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
$dbresult = $db->Execute($query,array($saison));
echo $query;
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $pouleslist[$row['idpoule']] = $row['libdivision'];
    //$equipelist[$row['equipe']] = $row['equipe'];
    //$typeCompetition[$row['name']] = $row['type_compet'];
  }

if( isset($params['submitfilter']) )
  {
    if( isset( $params['pouleslist']) )
      {
	$this->SetPreference('pouleChoisi', $params['pouleslist']);
      }
/*
    if( isset( $params['equipelist']))
	{
	$this->SetPreference( 'equipeChoisie', $params['equipelist']);
	}
    if( isset( $params['typeCompet']))
		{
		$this->SetPreference( 'competChoisie', $params['typeCompet']);
		}
*/
}
$curpoule = $this->GetPreference( 'pouleChoisi' );
//$curequipe = $this->GetPreference( 'equipeChoisie' );
//$curcompet = $this->GetPreference('competChoisie');

$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompetition,-1,$curcompet));

$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_tour',
		$this->CreateInputDropdown($id,'pouleslist',$pouleslist,-1,$curpoule));
		$smarty->assign('prompt_equipe',
				$this->Lang('equipe'));
$smarty->assign('input_equipe',
		$this->CreateInputDropdown($id,'equipelist',$equipelist,-1,$curequipe));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());


$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipes');
$smarty->assign('tour', 'Tour');
$smarty->assign('score', 'Score');
$smarty->assign('adversaires', 'Adversaires');

$result= array ();
$query = "SELECT *,  eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND eq.saison = ?";
$parms['saison_en_cours'] = $saison;
echo $query;
if( isset($params['submitfilter'] )){
if ($curpoule !='')
{
	$query .=" AND idpoule = ?";
	$parms['idpoule'] = $curpoule;
		
}
else {
	$query.=" AND idpoule > 0 ";
	$parms ='';
}
/*
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
*/
$dbresult= $db->Execute($query,$parms);
}




else {
	//$query .=" ORDER BY id ASC";
	$dbresult= $db->Execute($query,$parms);
}

if($travaux=='true'){echo $query;}
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$equb = $row['equb'];
	$equa = $row['equa'];
	$friendlyname = $row['friendlyname'];
	$libequipe = $row['libequipe'];
	$uploaded = $row['uploaded'];
	
	
	//$onerow->equipe= $row['equipe'];
	$onerow->libelle= $this->createLink($id, 'viewteamresult', $returnid, $row['libelle'],array('cle'=>$row['lien'])) ;
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equa)
		{
			$onerow->equa= $row['friendlyname'];
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
		
	}
	else{
		$onerow->equb= $row['equb'];
	}
	/*	
	$onerow->commune= $row['commune'];
	$onerow->email= $row['email'];
	$onerow->tranche= $row['tranche'];
	$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	*/
	//$onerow->equipe= $this->CreateLink($id, 'create_new_user', $returnid, $row['equipe'], $row);
	if($uploaded == '0'){
		$onerow->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('upload_result'), '', '', 'systemicon'), array('idpoule'=>$row['idpoule'], 'iddiv'=>$row['iddiv']));
	}
	else
	{
				$onerow->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_detail_rencontres', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('upload_result'), '', '', 'systemicon'), array('idpoule'=>$row['idpoule'], 'iddiv'=>$row['iddiv']));
	}$onerow->deletelink= $this->CreateLink($id, 'delete_team_result', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'retrieve_all_poule_rencontres', $returnid,
				  $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('download_all_poule_results'), '', '', 'systemicon')).
		$this->CreateLink($id, 'retrieve_all_poule_rencontres', $returnid, 
				  $this->Lang('download_all_poule_results'), 
				  array()));

echo $this->ProcessTemplate('poulesRencontres.tpl');


#
# EOF
#
?>