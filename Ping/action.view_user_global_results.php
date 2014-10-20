<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');

$saison = $this->GetPreference('saison_en_cours');

$db =& $this->GetDb();
global $themeObject;
$this->SetCurrentTab('results');
/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'view_user_global_results')); 
//$saisonslist[$this->lang('allseasons')] ='';
$datelist[$this->Lang('alltours')] = '';
//$allequipes =  ( isset( $params['allequipes'] )?$params['allequipes']:'no');

$equipelist[$this->Lang('allequipes')] = '';
$playerslist[$this->Lang('allplayers')] = '';
$typeCompet = array();
$typeCompet[$this->Lang('allcompet')] = '';
$query = "SELECT *, pts.epreuve,pts.date_event, j.licence,pts.numjourn , CONCAT_WS(' ',j.nom, j.prenom) AS player FROM ".cms_db_prefix()."module_ping_parties_spid AS pts  , ".cms_db_prefix()."module_ping_joueurs AS j WHERE pts.licence  = j.licence AND pts.saison = ? ORDER BY j.nom ASC, pts.numjourn ASC";//"";
echo $query;
$dbresult = $db->Execute($query, array($saison));
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $datelist[$row['date_event']] = $row['date_event'];
    $playerslist[$row['player']] = $row['licence'];
//$saisonslist[$row['saison']] = $row['saison'];
    //$equipelist[$row['equipe']] = $row['equipe'];
    $typeCompet[$row['epreuve']] = $row['epreuve'];
  }

if( isset($params['submitfilter']) )
  {
    	if( isset( $params['datelist']) )
      	{
	$this->SetPreference('dateChoisi', $params['datelist']);
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
$curdate = $this->GetPreference( 'dateChoisi' );
//$curseason = $this->GetPreference('saisonChoisie');
$curplayer = $this->GetPreference( 'playerChoisi');
$curequipe = $this->GetPreference( 'equipeChoisie' );
$curCompet = $this->GetPreference( 'competChoisie');
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_date',
		$this->CreateInputDropdown($id,'datelist',$datelist,-1,$curdate));
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

$result= array ();
//$query= "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE joueur = ? ORDER BY id ASC";
//$query = "SELECT type_compet, joueur, sum(vic_def) AS victoires, sum(points) AS total, count(*) AS sur FROM ".cms_db_prefix()."module_ping_points  GROUP BY joueur,type_compet ORDER BY joueur,type_compet";
$query = "SELECT sp.id AS record_id,CONCAT_WS(' ',j.nom, j.prenom) AS joueur, sp.date_event, sp.epreuve, sp.nom AS name, sp.classement, sp.victoire, sp.ecart, sp.coeff, sp.pointres, sp.forfait FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_parties_spid AS sp  WHERE j.licence = sp.licence AND sp.saison = ? ";//"  GROUP BY joueur,type_compet ORDER BY joueur,type_compet";

$parms['saison'] = $saison;//si le filtre a été soumis

if( isset($params['submitfilter'] )){
	if ($curdate !='')
	{
		$query .=" AND sp.date_event = ? ";
		$parms['date_event'] = $curdate;
		
	}
	/*
	else {
		$query.=" AND pts.numjourn >= 0 ";
		$parms ='';
	}
	*/
	if ($curplayer !='')
	{
		$query .=" AND sp.licence = ?";
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
	$query.=" AND sp.epreuve = ?";
	$parms['epreuve'] = $curCompet;
}


}

$query.=" ORDER BY joueur ASC, sp.date_event ASC";


$dbresult= $db->Execute($query, $parms);
echo $query;
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->record_id= $row['record_id'];
	$onerow->joueur= $row['joueur'];//$this->CreateLink($id, 'view_user_results', $returnid, $row['joueur'],array('joueur'=>$row['joueur']),$row) ;
	$onerow->date_event= $row['date_event'];
	$onerow->epreuve= $row['epreuve'];
	$onerow->name= $row['name'];
	$onerow->classement= $row['classement'];
	$onerow->victoire= $row['victoire'];
	$onerow->ecart= $row['ecart'];
	$onerow->coeff= $row['coeff'];
	$onerow->pointres= $row['pointres'];
	$onerow->forfait= $row['forfait'];
	//$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
	$onerow->editlink= $this->CreateLink($id, 'edit_player_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['record_id']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_result', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['record_id']), $this->Lang('delete_user_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
/**/
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
$smarty->assign('retrieve_all', 
		$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid,
				$themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('long_import'), '', '', 'systemicon')).
				$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid, 
								  $this->Lang('retrieveallpartiesspid'), 
								  array()));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Mettre le Coeff à 0,5"=>"coeff05","Mettre le Coeff à 0,75"=>"coeff075","Mettre le Coeff à 1"=>"coeff1","Mettre le Coeff à 1,25"=>"coeff125","Mettre le Coeff à 1,5"=>"coeff15", "Récupérer situation mensuelle"=>"situation","Supprimer"=>"supp_spid");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

			
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
/**/
echo $this->ProcessTemplate('globaluserresults.tpl');


#
# EOF
#
?>