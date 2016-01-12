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
$typeCompet = array("Toutes"=>0,"Nationales"=>$fede,"Zone"=>$zone,"Régionales"=>$ligue, "Départementales"=>$dep);
$indivOrNot = array("Indifférent"=>10,"Par équipes"=>0,"Individuelles"=>1);
$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin','', 'post', '',false,'', array('active_tab'=>'compets')));
$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompet,-1,(!empty($params['typeCompet'])?$params['typeCompet']:"")));
$smarty->assign('input_indivs',
		$this->CreateInputDropdown($id,'indivOrNot',$indivOrNot,-1,(!empty($params['indivOrNot'])?$params['indivOrNot']:"")));
		$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());

$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Zone indivs', array("idorga"=>$zone,"type"=>"I")));
$smarty->assign('zone_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'Zone Equipes', array("idorga"=>$zone,"type"=>"E")));
$smarty->assign('Nat_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'National indivs', array("idorga"=>$fede,"type"=>"I")));
$smarty->assign('Nat_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'National Equipes', array("idorga"=>$fede,"type"=>"E")));
$smarty->assign('ligue_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Ligue indivs', array("idorga"=>$ligue,"type"=>"I")));
$smarty->assign('ligue_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'Ligue Equipes', array("idorga"=>$ligue,"type"=>"E")));
$smarty->assign('dep_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Dép indivs', array("idorga"=>$dep,"type"=>"I")));
$smarty->assign('dep_equipes', $this->CreateLink($id, 'retrieve_compets',$returnid,'Dép Equipes', array("idorga"=>$dep,"type"=>"E")));

$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id > ?";
$parms['id'] = 0;
if( isset($params['submitfilter'] ))
{
	if (isset( $params['typeCompet']) && $params['typeCompet'] !='' && $params['typeCompet'] != 0)
	{
		$query.=" AND idorga = ? ";
		$parms['typeCompet'] = $params['typeCompet'];
		
	}
	if(isset( $params['indivOrNot']) && $params['indivOrNot'] !='' && $params['indivOrNot'] != 10)
	{
		$query.=" AND indivs = ?";
		$parms['indivOrNot'] = $params['indivOrNot'];
	}
	

}

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
	
	//
	if($indivs=='1')
	{
		if($orga == 'Comité')
		{
			//$onerow->dep = $this->CreateLink($id,'retrieve_divisions',$returnid,'D', array("idorga"=>$dep, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			
		}
		elseif($orga == 'Ligue')
		{
			//$onerow->ligue = $this->CreateLink($id,'retrieve_divisions',$returnid,'L', array("idorga"=>$ligue, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			//$onerow->dep = $this->CreateLink($id,'retrieve_divisions',$returnid,'D', array("idorga"=>$dep, "idepreuve"=>$row['idepreuve'],"type"=>$type));
		}
		elseif($orga == 'Zone')
		{
			//$onerow->zone = $this->CreateLink($id,'retrieve_divisions',$returnid,'Z', array("idorga"=>$zone, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			//$onerow->ligue = $this->CreateLink($id,'retrieve_divisions',$returnid,'L', array("idorga"=>$ligue, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			//$onerow->dep = $this->CreateLink($id,'retrieve_divisions',$returnid,'D', array("idorga"=>$dep, "idepreuve"=>$row['idepreuve'],"type"=>$type));
		}
		elseif($orga == 'Fédération')
		{
			//$onerow->national = $this->CreateLink($id,'retrieve_divisions',$returnid,'N', array("idorga"=>$fede, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			//$onerow->zone = $this->CreateLink($id,'retrieve_divisions',$returnid,'Z', array("idorga"=>$zone, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			//$onerow->ligue = $this->CreateLink($id,'retrieve_divisions',$returnid,'L', array("idorga"=>$ligue, "idepreuve"=>$row['idepreuve'],"type"=>$type));
			//$onerow->dep = $this->CreateLink($id,'retrieve_divisions',$returnid,'D', array("idorga"=>$dep, "idepreuve"=>$row['idepreuve'],"type"=>$type));

		}
		else
		{
			//$onerow->national = $this->CreateLink($id,'retrieve_divisions',$returnid,'N', array("idorga"=>$fede, "idepreuve"=>$row['idepreuve'],"type"=>$type));
		}
		
		$onerow->natio = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='National', array("active_tab"=>"compets","idepreuve"=>$row['idepreuve'],"idorga"=>$fede));
		$onerow->zone = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='Zone', array("idepreuve"=>$row['idepreuve'],"idorga"=>$zone));
		$onerow->ligue = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='Ligue', array("idepreuve"=>$row['idepreuve'],"idorga"=>$ligue));
		$onerow->dep = $this->CreateLink($id, 'admin_divisions_tab',$returnid,$contents='Dép', array("idepreuve"=>$row['idepreuve'],"idorga"=>$dep));
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
else
{
	//il n'y a pas de résultats, on fait quoi ?
}

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);


echo $this->ProcessTemplate('list_compet.tpl');


#
# EOF
#
?>