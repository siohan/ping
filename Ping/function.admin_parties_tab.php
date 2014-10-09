<?php

if( !isset($gCms) ) exit;

$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');


$result= array ();
$query= "SELECT * FROM ".cms_db_prefix()."module_ping_parties ORDER BY id ASC";
$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->nom= $row['nom'];
	$onerow->prenom= $row['prenom'];
	//$onerow->pts= $row['pts'];
	//$onerow->equipe= $this->createLink($id, 'viewsteamresult', $returnid, $row['equipe'],array('equipe'=>$row['equipe']),$row) ;
//	$onerow->joueur= $row['joueur'];
	
	
	/*	
	$onerow->commune= $row['commune'];
	$onerow->email= $row['email'];
	$onerow->tranche= $row['tranche'];
	$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	*/
	$onerow->id= $this->CreateLink($id, 'edit_joueurs', $returnid, $row['id'],array('record_id'=>$row['id']), $row);
	$onerow->editlink= $this->CreateLink($id, 'edit_joueur', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']));
	$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, 'Situation mensuelle', array('licence'=>$row['licence']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_joueur', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));

echo $this->ProcessTemplate('joueursList.tpl');


#
# EOF
#
?>