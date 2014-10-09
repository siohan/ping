<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');

/*
require_once(dirname(__FILE__).'/action.authentification.php');
$cle_compte = $_SESSION['cle_compte'];

echo 'la clef du compte est : '.$cle_compte;
*/
$licence = $params['licence'];

$db =& $this->GetDb();
//global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipe');
$smarty->assign('tour', 'Tour');
$smarty->assign('joueur', 'Joueur');
$smarty->assign('adversaire', 'Adversaire');
$smarty->assign('victoire', 'Vic/déf');
$smarty->assign('points', 'Points');

$result= array ();
$query= "SELECT * FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ?  ORDER BY date_compet ASC";
echo $query;
$dbresult= $db->Execute($query, array($joueur, $cle_compte));
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->tour= $row['tour'];
	$onerow->equipe= $row['equipe'];
	$onerow->joueur= $row['joueur'];
	$onerow->adversaire= $row['adversaire'];
	$onerow->vic_def= $row['vic_def'];
	$onerow->points= $row['points'];
	
	/*	
	$onerow->commune= $row['commune'];
	$onerow->email= $row['email'];
	$onerow->tranche= $row['tranche'];
	$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	*/
	/*
	$onerow->idlink= $this->CreateLink($id, 'fe_edit_results', $returnid, $row['id'],array('id'=>$row['id']), $row);
	$onerow->editlink= $this->CreateLink($id, 'fe_edit_results', $returnid, 'Modifier',array('record_id'=>$row['id']), $row);
	$onerow->deletelink= $this->CreateLink($id, 'delete_user', $returnid, '', array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	*/
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
/*
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
*/
$smarty->assign('items', $rowarray);
/*
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
*/
				
				
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal

echo $this->ProcessTemplate('fe_userslist.tpl');


#
# EOF
#
?>