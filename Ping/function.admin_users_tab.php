<?php

if( !isset($gCms) ) exit;

$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipe');
$smarty->assign('tour', 'Tour');
$smarty->assign('joueur', 'Joueur');
$smarty->assign('adversaire', 'Adversaire');
$smarty->assign('victoire', 'Vic/déf');
$smarty->assign('points', 'Points');

$result= array ();
$query= "SELECT * FROM ".cms_db_prefix()."module_ping_joueurs ORDER BY id ASC";
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
	$onerow->tour= $row['username'];
	$onerow->equipe= $row['points'];
	//$onerow->equipe= $this->createLink($id, 'viewsteamresult', $returnid, $row['equipe'],array('equipe'=>$row['equipe']),$row) ;
	$onerow->joueur= $this->CreateLink($id, 'view_user_results', $returnid, $row['joueur'],array('joueur'=>$row['joueur'])) ;
	
	
	/*	
	$onerow->commune= $row['commune'];
	$onerow->email= $row['email'];
	$onerow->tranche= $row['tranche'];
	$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	*/
	$onerow->id= $this->CreateLink($id, 'edit_results', $returnid, $row['id'],array('record_id'=>$row['id']), $row);
	$onerow->editlink= $this->CreateLink($id, 'edit_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_user', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
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