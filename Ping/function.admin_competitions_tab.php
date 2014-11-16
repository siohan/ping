<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
/* on fait un formulaire de filtrage des résultats*/
/*
$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin'));  
//$tourlist = array(0 =>"0",1 =>"1",2 =>"2",3 =>"3",4 =>'All');
$typeCompetition = array();
$tourlist = array();
$tourlist[$this->Lang('alltours')] = '';
$allequipes =  ( isset( $params['allequipes'] )?$params['allequipes']:'no');

$equipelist[$this->Lang('allequipes')] = '';

$query = "SELECT * FROM ".cms_db_prefix()."module_ping_competitions"; /*AS ren, ".cms_db_prefix()."module_ping_competitions AS comp WHERE ren.type_compet = comp.code_compet";*/
/*
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


$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipes');
$smarty->assign('tour', 'Tour');
$smarty->assign('score', 'Score');
$smarty->assign('adversaires', 'Adversaires');
*/
$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions";

$dbresult= $db->Execute($query);


//echo $query;
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->name= $row['name'];
	$onerow->code_compet= $row['code_compet'];
	$onerow->coefficient= $row['coefficient'];
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
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_type_compet', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add_compet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_type_compet', $returnid, 
				  $this->Lang('add_type_compet'), 
				  array()));

echo $this->ProcessTemplate('list_compet.tpl');


#
# EOF
#
?>