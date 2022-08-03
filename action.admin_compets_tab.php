<?php

if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$fede = '100001';
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');

$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve',$returnid,'Zone indivs', array("retrieve"=>"compets","idorga"=>$zone,"type"=>"I")));
$smarty->assign('Nat_indivs', $this->CreateLink($id, 'retrieve',$returnid,'National indivs', array("retrieve"=>"compets","idorga"=>$fede,"type"=>"I")));
$smarty->assign('ligue_indivs', $this->CreateLink($id, 'retrieve',$returnid,'Ligue indivs', array("retrieve"=>"compets","idorga"=>$ligue,"type"=>"I")));
$smarty->assign('dep_indivs', $this->CreateLink($id, 'retrieve',$returnid,'Dép indivs', array("retrieve"=>"compets","idorga"=>'29',"type"=>"I")));
$parms = array();
$result= array();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id > ?";
$parms['id'] = 0;

	$query.=" ORDER BY name ASC";
//echo $query;
	$dbresult= $db->Execute($query,$parms);
//echo $query;
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
{
    while ($row= $dbresult->FetchRow())
    {
		$indivs = $row['indivs'];
		if($indivs==1){$type='I';}else{$type='E';}
		$idorga = $row['idorga'];
		if($idorga == $fede){$orga = 'Fédération';}
		if($idorga == $zone){$orga = 'Zone';}
		if($idorga == $ligue){$orga = 'Ligue';}
		if($idorga == $dep){$orga = 'Comité';}
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->name= $row['name'];
		$onerow->tag= $row['tag'];
		$onerow->coefficient= $row['coefficient'];
		$onerow->indivs= $row['indivs'];
		$onerow->orga = $idorga;
		$onerow->idepreuve = $row['idepreuve'];
		/*$onerow->natio = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='National', array("active_tab"=>"compets","idepreuve"=>$row['idepreuve'],"idorga"=>$fede));
		$onerow->zone = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='Zone', array("idepreuve"=>$row['idepreuve'],"idorga"=>$zone));
		$onerow->ligue = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='Ligue', array("idepreuve"=>$row['idepreuve'],"idorga"=>$ligue));
		$onerow->dep = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='Dép', array("idepreuve"=>$row['idepreuve'],"idorga"=>$dep));
		$onerow->editlink = $this->CreateLink($id, 'edit_type_compet',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array("record_id"=>$row['id']));
		*/
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
	//il n'y a pas de résultats, on fait quoi ?
	//ou une erreur
	echo $db->errorMsg();
}

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);


echo $this->ProcessTemplate('list_compet.tpl');


#
# EOF
#
?>
