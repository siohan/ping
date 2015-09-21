<?php
##################################################################
#                                                               ##
#        Administration des poules insérées pour le classement  ##
#                         et les parties                        ##
##################################################################

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$fede = '100001';
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');

$result= array ();
$query = "SELECT *,dv.libelle FROM ".cms_db_prefix()."module_ping_divisions AS dv, ".cms_db_prefix()."module_ping_div_tours AS pou WHERE dv.idepreuve = pou.idepreuve AND dv.iddivision = pou.iddivision ORDER BY dv.iddivision,pou.tour ASC";

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
	/*
	$indivs = $row['indivs'];
	if($indivs==1){$type='I';}else{$type='E';}
	$idorga = $row['idorga'];
	if($idorga == $fede){$orga = 'Fédération';}
	if($idorga == $zone){$orga = 'Zone';}
	if($idorga == $ligue){$orga = 'Ligue';}
	if($idorga == $dep){$orga = 'Comité';}
	*/
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->idepreuve= $row['idepreuve'];
	$onerow->iddivision= $row['iddivision'];
	$onerow->tour= $row['tour'];
	$onerow->tableau = $row['tableau'];
	$onerow->libelle= $row['libelle'];
	//$onerow->indivs= $row['indivs'];
	//$onerow->orga = $orga;
	//$onerow->idepreuve = $row['idepreuve'];
	
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
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_type_compet', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add_compet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_type_compet', $returnid, 
				  $this->Lang('add_type_compet'), 
				  array()));

echo $this->ProcessTemplate('list_poules.tpl');


#
# EOF
#
?>