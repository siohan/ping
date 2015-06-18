<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');

$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions";

$dbresult= $db->Execute($query);


//echo $query;
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->name= $row['name'];
	$onerow->tag= $row['tag'];
	$onerow->coefficient= $row['coefficient'];
	$onerow->indivs= $row['indivs'];
	/*
	if($row['indivs'] =='1')
	{
		$onerow->participe = $this->CreateLink($id, 'participe', $returnid, 'Participants', array('type_compet'=>$row['code_compet']));
	}
	*/
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