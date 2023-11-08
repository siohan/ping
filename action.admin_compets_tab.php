<?php

if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
debug_display($params, 'Parameters');

$parms = array();

$query = "SELECT id, name, tag, coefficient, indivs, idorga, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve =  ?";

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
		/*$idorga = $row['idorga'];
		if($idorga == $fede){$orga = 'Fédération';}
		if($idorga == $zone){$orga = 'Zone';}
		if($idorga == $ligue){$orga = 'Ligue';}
		if($idorga == $dep){$orga = 'Comité';}*/
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->name= $row['name'];
		$onerow->tag= $row['tag'];
		$onerow->coefficient= $row['coefficient'];
		$onerow->indivs= $row['indivs'];
		$onerow->idorga = $row['idorga'];
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
