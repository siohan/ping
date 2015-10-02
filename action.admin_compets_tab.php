<?php

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

$smarty->assign('divisions', $this->CreateLink($id, 'defaultadmin2',$returnid, '=> Accédez aux divisions'));
$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Zone indivs', array("idorga"=>$zone,"type"=>"I")));
$smarty->assign('zone_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'Zone Equipes', array("idorga"=>$zone,"type"=>"E")));
$smarty->assign('Nat_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'National indivs', array("idorga"=>$fede,"type"=>"I")));
$smarty->assign('Nat_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'National Equipes', array("idorga"=>$fede,"type"=>"E")));
$smarty->assign('ligue_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Ligue indivs', array("idorga"=>$ligue,"type"=>"I")));
$smarty->assign('ligue_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'Ligue Equipes', array("idorga"=>$ligue,"type"=>"E")));
$smarty->assign('dep_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Dép indivs', array("idorga"=>$dep,"type"=>"I")));
$smarty->assign('dep_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'Dép Equipes', array("idorga"=>$dep,"type"=>"E")));
$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions ORDER BY name ASC";

$dbresult= $db->Execute($query);


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
	
	
	if($row['indivs'] =='1')
	{
		$onerow->national = $this->CreateLink($id,'retrieve_divisions',$returnid,'N', array("idorga"=>$fede, "idepreuve"=>$row['idepreuve'],"type"=>$type));
		$onerow->zone = $this->CreateLink($id,'retrieve_divisions',$returnid,'Z', array("idorga"=>$zone, "idepreuve"=>$row['idepreuve'],"type"=>$type));
		$onerow->ligue = $this->CreateLink($id,'retrieve_divisions',$returnid,'L', array("idorga"=>$ligue, "idepreuve"=>$row['idepreuve'],"type"=>$type));
		$onerow->dep = $this->CreateLink($id,'retrieve_divisions',$returnid,'D', array("idorga"=>$dep, "idepreuve"=>$row['idepreuve'],"type"=>$type));
	}
	else
	{
		$onerow->national = $this->CreateLink($id,'retrieve_divisions',$returnid,'N', array("idorga"=>$fede, "idepreuve"=>$row['idepreuve'],"type"=>$type));
	}
	$onerow->editlink = $this->CreateLink($id, 'edit_type_compet',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array("record_id"=>$row['id']));
	
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

echo $this->ProcessTemplate('list_compet.tpl');


#
# EOF
#
?>