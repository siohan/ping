<?php
##################################################################
#                                                               ##
#        Administration des parties                             ##
#                                                               ##
##################################################################

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$idepreuve = '';
$iddivision = '';
$tableau = '';
$tour = 0;
$error = 0; //on instancie un compteur d'erreurs
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
//on construit un lie de récupération des résultats
$smarty->assign('lien_retour',
		$this->CreateReturnLink($id, $returnid,$contents='Retour'));
$smarty->assign('recup_parties',
		$this->CreateLink($id,'retrieve_div_results', $returnid, $contents='Récupérer les parties', array("direction"=>"partie","idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga, "licence"=>$licence)));
$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_div_parties WHERE tableau = ?";

$dbresult= $db->Execute($query,array($tableau));
// the top nav bar
//$smarty->assign('returnlink', $this->CreateLink($id,'defaultadmin',$returnid,$themeObject->DisplayImage('icons/system/back.gif', $this->Lang('back'), '', '', 'systemicon'),array("active_tab"=>"divisions")));
//$this->CreateLink($id, 'edit_type_compet',$returnid,$themeObject->DisplayImage('icons/topfiles/template.gif', $this->Lang('edit'), '', '', 'systemicon'),array("record_id"=>$row['id']));

$rowclass = '';
//echo $query;
$rowarray= array();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->tour_id = $row['id'];
	$onerow->idepreuve= $row['idepreuve'];
	$onerow->iddivision= $row['iddivision'];
	//$onerow->tour= $row['tour'];
	$onerow->tableau = $row['tableau'];
	$onerow->libelle= $row['libelle'];
	$onerow->vain= $row['vain'];
	$onerow->perd = $row['perd'];
	$onerow->idepreuve = $row['idepreuve'];
	
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

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Supprimer"=>"supp_div_parties");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('list_parties.tpl');


#
# EOF
#
?>