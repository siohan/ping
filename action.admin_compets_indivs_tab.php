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
$saison = $this->GetPreference('saison_en_cours');

$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Récupérer les compétitions individuelles', array("type"=>"I")));
$smarty->assign('divisions_all',
		$this->CreateLink($id,'retrieve_divisions',$returnid,'Récuperer toutes les divisions', array("all"=>TRUE)));
$smarty->assign('tours_all', $this->CreateLink($id, 'retrieve_div_tours',$returnid,'Récupérer tous les tours ou poules', array("all"=>"1"),'', '', '',$addtext="class=\"button\""));
$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id >0";//indivs = '1' ORDER BY name ASC";

$dbresult= $db->Execute($query);
$ping_ops = new ping_admin_ops;

//echo $query;
$rowarray= array();
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
	if(true ==$indivs)
	{
		$onerow->participants = $this->CreateLink($id, 'participe', $returnid, $themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('groupassign'), '', '', 'systemicon'), array("idepreuve"=>$row['idepreuve']));
		$onerow->nb_participants = $this->CreateLink($id, 'participants', $returnid, $ping_ops->nb_participants($row['idepreuve'], $saison), array("idepreuve"=>$row['idepreuve']));
	}
	
	
	$onerow->natio = $this->CreateLink($id, 'retrieve',$returnid,$contents='National', array("retrieve"=>"divisions","idepreuve"=>$row['idepreuve'],"idorga"=>$fede));
	$onerow->zone = $this->CreateLink($id, 'retrieve',$returnid,$contents='Zone', array("retrieve"=>"divisions","idepreuve"=>$row['idepreuve'],"idorga"=>$zone));
	$onerow->ligue = $this->CreateLink($id, 'retrieve',$returnid,$contents='Ligue', array("retrieve"=>"divisions","idepreuve"=>$row['idepreuve'],"idorga"=>$ligue));
	$onerow->dep = $this->CreateLink($id, 'retrieve',$returnid,$contents='Dép', array("retrieve"=>"divisions","idepreuve"=>$row['idepreuve'],"idorga"=>$dep));
	/**/
	//
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


echo $this->ProcessTemplate('list_compet_indivs.tpl');


#
# EOF
#
?>