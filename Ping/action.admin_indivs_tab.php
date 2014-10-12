<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
require_once(dirname(__file__).'/include/travaux.php');
require_once(dirname(__file__).'/include/prefs.php');

/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_indivs_tab')); 
//$saisonslist[$this->lang('allseasons')] ='';
$tourlist[$this->Lang('alltours')] = '';
//$allequipes =  ( isset( $params['allequipes'] )?$params['allequipes']:'no');

$equipelist[$this->Lang('allequipes')] = '';
$playerslist[$this->Lang('allplayers')] = '';
$typeCompet = array();
$typeCompet[$this->Lang('allcompet')] = '';
$query = "SELECT * , CONCAT_WS(' ',j.nom, j.prenom) AS player FROM ".cms_db_prefix()."module_ping_parties AS pts  , ".cms_db_prefix()."module_ping_joueurs AS j WHERE pts.licence  = j.licence ORDER BY j.nom ASC, pts.numjourn ASC";//"";
$dbresult = $db->Execute($query, array($saison_courante));
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $tourlist[$row['numjourn']] = $row['numjourn'];
    $playerslist[$row['player']] = $row['licence'];
//$saisonslist[$row['saison']] = $row['saison'];
    //$equipelist[$row['equipe']] = $row['equipe'];
    $typeCompet[$row['codechamp']] = $row['codechamp'];
  }

if( isset($params['submitfilter']) )
  {
    	if( isset( $params['tourlist']) )
      	{
	$this->SetPreference('tourChoisi', $params['tourlist']);
      	}
/*
	if( isset( $params['saisonslist']) )
      	{
	$this->SetPreference('saisonChoisie', $params['saisonslist']);
      	}
*/
	if( isset( $params['playerslist']) )
      	{
	$this->SetPreference('playerChoisi', $params['playerslist']);
      	}
    /*if( isset( $params['equipelist']))
	{
	$this->SetPreference( 'equipeChoisie', $params['equipelist']);
	}
	*/
    if( isset( $params['typeCompet']) )
	{ 
	$this->SetPreference ( 'competChoisie', $params['typeCompet']);
	}
}
$curtour = $this->GetPreference( 'tourChoisi' );
//$curseason = $this->GetPreference('saisonChoisie');
$curplayer = $this->GetPreference( 'playerChoisi');
$curequipe = $this->GetPreference( 'equipeChoisie' );
$curCompet = $this->GetPreference( 'competChoisie');
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_tour',
		$this->CreateInputDropdown($id,'tourlist',$tourlist,-1,$curtour));
/*
$smarty->assign('input_saison',
				$this->CreateInputDropdown($id,'saisonslist',$saisonslist,-1,$curseason));
*/
/*		$smarty->assign('prompt_equipe',
				$this->Lang('equipe'));

$smarty->assign('input_equipe',
		$this->CreateInputDropdown($id,'equipelist',$equipelist,-1,$curequipe));
*/		
		$smarty->assign('input_compet',
				$this->CreateInputDropdown($id,'typeCompet',$typeCompet,-1,$curCompet));
				
		$smarty->assign('input_player',
				$this->CreateInputDropdown($id,'playerslist',$playerslist,-1,$curplayer));
		
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());


$smarty->assign('id', $this->Lang('id'));
$smarty->assign('joueur', 'Joueur');
$smarty->assign('victoire', 'Victoire');
$smarty->assign('adversaire', 'Adversaire');
$smarty->assign('points', 'Points');

$result= array ();
$query = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur, pts.id, pts.vd, pts.numjourn,pts.date_event, pts.advnompre,pts.pointres, pts.advclaof  FROM ".cms_db_prefix()."module_ping_parties AS pts , ".cms_db_prefix()."module_ping_joueurs AS j WHERE pts.licence = j.licence AND pts.saison = ?";
$parms['saison'] = $saison_courante;
if( isset($params['submitfilter'] )){
	if ($curtour !='')
	{
		$query .=" AND pts.numjourn = ? ";
		$parms['numjourn'] = $curtour;
		
	}
	/*
	else {
		$query.=" AND pts.numjourn >= 0 ";
		$parms ='';
	}
	*/
	if ($curplayer !='')
	{
		$query .=" AND pts.licence = ?";
		$parms['licence'] = $curplayer;
		
	}
	/*
	else {
		$query.=" AND pts.licence >= 0 ";
		$parms ='';
	}
	*/
if ($curCompet !='')
{
	$query.=" AND pts.codechamp = ?";
	$parms['codechamp'] = $curCompet;
}


}
$dbresult= $db->Execute($query,$parms);
/*
else {
	$query .=" ORDER BY pts.numjourn DESC";
	$dbresult= $db->Execute($query,$parms);
}
*/
//echo $query;
if (!$dbresult)
{

		die('FATAL SQL ERROR: '.$db->ErrorMsg().'<br/>QUERY2: '.$db->sql);

}

$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->numjourn= $row['numjourn'];
	$onerow->joueur= $row['joueur'];
	$onerow->vd= $row['vd']; 
	$onerow->advnompre= $row['advnompre'];
//	$onerow->adversaire= $row['adversaire'];
	$onerow->pointres= $row['pointres'];
	//$onerow->equipe= $this->CreateLink($id, 'create_new_user', $returnid, $row['equipe'], $row);
	$onerow->editlink= $this->CreateLink($id, 'edit_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_result', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_user_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
//deuxièmme requete pour compter les points de cette journée
$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
/*
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_indivs', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_indivs', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));

$smarty->assign('retrieve_all_parties', 
		$this->CreateLink($id, 'retrieve_all_parties', $returnid,
				$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('import'), '', '', 'systemicon')).
						$this->CreateLink($id, 'retrieve_all_parties', $returnid, 
								  $this->Lang('import'), 
								  array()));
*/
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Désactiver"=>"unable","Récupérer situation mensuelle"=>"situation");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

$smarty->assign('retour',
		$this->CreateLink($id,'admin_indivs_tab', $returnid,$contents ='Retour à la liste'));
echo $this->ProcessTemplate('indivscores.tpl');


#
# EOF
#
?>