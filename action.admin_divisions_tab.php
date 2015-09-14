<?php
#############################################################
##                 DIVISIONS                               ##
##   Affichage des divisions des épreuves                  ##
##                                                         ##
#############################################################
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
require_once(dirname(__file__).'/include/travaux.php');
require_once(dirname(__file__).'/include/prefs.php');
$saison = $this->GetPreference('saison_en_cours');
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
    		/*
if( isset( $params['datelist']) )
      		{
			$this->SetPreference('dateChoisi', $params['datelist']);
      		}

		if( isset( $params['idorgalist']) && $params['idorgalist'] != "Aucun")
      		{
			$this->SetPreference('idorgaChoisi', $params['idorgalist']);
      		}
*/
    		if( isset( $params['typeCompet']) )
		{ 
			$curCompet = $params['typeCompet'];
		}
	}
	
//$curdate = $this->GetPreference( 'dateChoisi' );
//$curplayer = $this->GetPreference( 'idorgaChoisi');
//$curCompet = $this->GetPreference( 'competChoisie');
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
/*
$smarty->assign('input_date',
		$this->CreateInputDropdown($id,'datelist',$datelist,-1,$curdate));
*/
$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompet,-1,(isset($curCompet)?$curCompet:"")));
/*
$smarty->assign('input_player',
		$this->CreateInputDropdown($id,'idorgalist',$idorgalist,-1,$curplayer));
*/		
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());
//on fait maintenant la requete principale...
$result= array ();
$query = "SELECT dv.id,tc.name,tc.indivs, tc.idorga, tc.idepreuve, dv.libelle, dv.iddivision,dv.scope, dv.uploaded FROM ".cms_db_prefix()."module_ping_type_competitions AS tc , ".cms_db_prefix()."module_ping_divisions AS dv WHERE  tc.idepreuve = dv.idepreuve AND dv.saison = ? ";
$parms['saison'] = $saison;

	if( isset($params['submitfilter'] )){
		
	/*
		if ($curdate !='')
		{
			$query .=" AND pts.date_event = ? ";
			$parms['date_event'] = $curdate;
		
		}
		
		if ($curplayer !='' || $curplayer != "Aucun")
		{
			$query .=" AND dv.scope = ?";
			$parms['idorga'] = $curplayer;
		
		}
	*/	
		if ($curCompet !='')
		{
			$query.=" AND tc.idepreuve = ?";
			$parms['idepreuve'] = $curCompet;
		}

		$query.=" ORDER BY tc.idepreuve ASC, dv.libelle ASC";
	}
	else
	{
		$query.=" ORDER BY tc.idepreuve, tc.idorga ASC";
		
	}
	

$dbresult= $db->Execute($query,$parms);
//echo $query;
if (!$dbresult)
{

		die('FATAL SQL ERROR: '.$db->ErrorMsg().'<br/>QUERY2: '.$db->sql);

}

$rowarray= array ();
$rowclass = '';
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$scope = $row['scope'];
	if($scope=='F'){$niveau ='National';}
	if($scope=='Z'){$niveau ='Zone';}
	if($scope=='L'){$niveau ='Régional';}
	if($scope=='D'){$niveau ='Départemental';}
	$indivs = $row['indivs'];
	$uploaded = $row['uploaded'];
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->idorga = $row['idorga'];
	$onerow->idepreuve= $row['idepreuve'];
	$onerow->iddivision= $row['iddivision'];
	$onerow->name= $row['name'];
	$onerow->libelle= $row['libelle'];
	$onerow->indivs = $row['indivs'];
	$onerow->scope = $niveau;
	//$onerow->uploaded = $row['uploaded'];
	if($uploaded ==1)
	{
		$onerow->uploaded= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('already_downloaded'), '', '', 'systemicon');
	}
	
	
	if($indivs ==1)
	{
		$onerow->poule= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Tours',array("direction"=>"tour","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"indivs"=>$row['indivs']));
	}
	else
	{
		$onerow->poule= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Poules',array("direction"=>"tour","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"indivs"=>$row['indivs']));
	}
	//$onerow->classement= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Classement',array("direction"=>"classement","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision']));
	//$onerow->equipe= $this->CreateLink($id, 'create_new_user', $returnid, $row['equipe'], $row);
	$onerow->editlink= $this->CreateLink($id, 'edit_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
	//$onerow->duplicatelink= $this->CreateLink($id, 'edit_results', $returnid, $themeObject->DisplayImage('icons/system/copy.gif', $this->Lang('duplicate'), '', '', 'systemicon'), array('record_id'=>$row['id'], 'duplicate'=>'1'));
	
	if($this->CheckPermission('Ping Delete'))
	{
		$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete_all_div'), '', '', 'systemicon'), array('record_id'=>$row['id'],'type_compet'=>'division'), $this->Lang('delete_all_div'));
	}
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
//deuxièmme requete pour compter les points de cette journée
$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Supprimer"=>"supp_div","Dater"=>"dater");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('divisions.tpl');


#
# EOF
#
?>