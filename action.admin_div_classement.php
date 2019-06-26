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
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$fede = '100001';
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');
// On récupère les paramètres transmis
$idepreuve = '';
$iddivision = '';
$tableau = '';
$tour = 0;
$error = 0; //on instancie un compteur d'erreurs
if(isset($params['essai']) && $params['essai'] !='0')
{
	$essai = $params['essai'];
}
else
{
	$essai = 0;//Par défaut 0, si pas de résultats en bdd, recherche automatique
}
$licence = '';
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
	
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	
}
else
{
	$error++;
}
if(isset($params['iddivision']) && $params['iddivision'] != '')
{
	$iddivision = $params['iddivision'];
	
}
else
{
	$error++;
}
if(isset($params['tableau']) && $params['tableau'] != '')
{
	$tableau = $params['tableau'];

}
else
{
	$error++;
}
if(isset($params['tour']) && $params['tour'] != '')
{
	$tour = $params['tour'];

}
else
{
	$error++;
}
if(isset($params['idorga']) && $params['idorga'] != '')
{
	$idorga = $params['idorga'];

}
$saison = $this->GetPreference('saison_en_cours');
$smarty->assign('returnlink', $this->CreateLink($id,'admin_poules',$returnid,$themeObject->DisplayImage('icons/system/back.gif', $this->Lang('back'), '', '', 'systemicon'),array("idepreuve"=>$idepreuve, "iddivision"=>$iddivision, "idorga"=>$idorga)));
//on construit un lie de récupération des résultats
$smarty->assign('recup_classement',
		$this->CreateLink($id,'retrieve_div_results', $returnid, $contents='Récupérer le classement', array("direction"=>"classement","idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga)));
$result= array ();
$query = "SELECT id, idepreuve,iddivision,tableau,tour,rang, nom,clt,club,points, saison FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND iddivision = ? AND tableau = ? AND saison = ? ORDER BY id ASC";

$dbresult= $db->Execute($query,array($idepreuve,$iddivision, $tableau,$saison));
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
	if(substr_count($club,'Fouesnant')>0)
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
else
{
	//pas de résultats, on va les chercher automatiquement ?
	//on regarde si l'essai est à 0 ou non
	if($essai == '0')
	{
		$this->Redirect($id,'retrieve_div_results',$returnid, array("direction"=>"classement","idepreuve"=>$idepreuve, "iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga,"licence"=>$licence));
	}
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