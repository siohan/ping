<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
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

$query1 = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
$dbresult = $db->Execute($query1,array($saison));
//echo $query1;
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $pouleslist[$row['libdivision']] = $row['idpoule'];
    //$equipelist[$row['equipe']] = $row['equipe'];
    //$typeCompetition[$row['name']] = $row['type_compet'];
  }

if( isset($params['submitfilter']) )
  {
    if( isset( $params['pouleslist']) )
      {
	$this->SetPreference('pouleChoisi', $params['pouleslist']);
      }
}
$curpoule = $this->GetPreference( 'pouleChoisi' );

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




$result= array ();
$query2 = "SELECT *,ren.affiche, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND eq.saison = ?";
$parms['saison_en_cours'] = $saison;

if( isset($params['submitfilter'] )){
	
	if ($curpoule !='')
	{
		$query2 .=" AND eq.idpoule = ?";
		$parms['idpoule'] = $curpoule;
		
	}


}
$dbresult= $db->Execute($query2,$parms);
//echo $query2;

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
	$affiche = $row['affiche'];	
	
	
	//$onerow->equipe= $row['equipe'];
	$onerow->libelle= $this->createLink($id, 'viewteamresult', $returnid, $row['libelle'],array('cle'=>$row['lien'])) ;
	
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equa)
		{
			$onerow->equa= $row['friendlyname'];
		}
		else
		{
			$onerow->equa= $row['equa'];
		}
		
	}
	else
	{
		$onerow->equa= $row['equa'];
	}
	
	$onerow->scorea= $row['scorea'];
	$onerow->scoreb= $row['scoreb'];
	$onerow->libequipe= $row['libequipe'];
	
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equb)
		{
			$onerow->equb= $row['friendlyname'];
		}
		else
		{
			$onerow->equb= $row['equb'];
		}
		
	}
	else
	{
		$onerow->equb= $row['equb'];
	}
	
	if($affiche ==1)
	{
		$onerow->display= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('do_not_display'), '', '', 'systemicon');
	}
	else
	{
		$onerow->display= $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('display_on_frontend'), '', '', 'systemicon');
	}
	
	//$onerow->affichage = 
	$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
	$onerow->deletelink= $this->CreateLink($id, 'delete_team_result', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
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
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Afficher sur le site"=>"display_on_frontend","Ne plus afficher sur le site"=>"do_not_display","Supprimer"=>"delete_team_result");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
echo $this->ProcessTemplate('poulesRencontres.tpl');


#
# EOF
#
?>