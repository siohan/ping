<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
/*
$cle_compte = $_SESSION['cle_compte'];

echo 'la clef du compte est : '.$cle_compte;
*/

$db =& $this->GetDb();
global $themeObject;

$result= array ();
//$query= "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE joueur = ? ORDER BY id ASC";
//$query = "SELECT CONCAT_WS(' ' , j.nom, j.prenom) AS joueur, j.licence,sum(p.vd) AS victoires, sum(p.pointres) AS total, count(*) AS sur FROM ".cms_db_prefix()."module_ping_parties_spid as p, ".cms_db_prefix()."module_ping_joueurs AS j WHERE p.licence = j.licence AND p.saison = ? GROUP BY joueur ORDER BY joueur";
$query = "SELECT p.date_event, p.nom, p.classement, p.victoire, p.ecart, p.coeff, p.pointres, CONCAT_WS(' ' , j.nom, j.prenom) AS joueur, j.licence FROM ".cms_db_prefix()."module_ping_parties_spid as p, ".cms_db_prefix()."module_ping_joueurs AS j WHERE p.licence = j.licence AND p.saison = ? AND  p.epreuve = 'Critérium fédéral' AND j.licence = ? ORDER BY p.date_event DESC, joueur ASC";
echo $query;
$dbresult= $db->Execute($query, array($saison_courante));
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	//$onerow->type_compet= $row['type_compet'];
	$onerow->joueur= $this->CreateLink($id, 'bar-charts2', $returnid, $row['joueur'],array('licence'=>$row['licence'])) ;
	$onerow->victoires= $row['victoires'];
	$onerow->sur= $row['sur'];
	$onerow->total= $row['total'];
	$onerow->date= $row['date_event'];
	$onerow->epreuve= $row['epreuve'];
	$onerow->coeff= $row['coeff'];
	$onerow->nom= $row['nom'];
	$onerow->classement= $row['classement'];
	$onerow->points= $row['pointres'];
	
//	$onerow->points= $row['points'];
	//$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	//$onerow->id= $this->CreateLink($id, 'edit_results', $returnid, $row['id'],array('record_id'=>$row['id']), $row);
	//$onerow->editlink= $this->CreateLink($id, 'edit_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']), $row);
	//$onerow->deletelink= $this->CreateLink($id, 'delete_user', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;//disabled by Claude
	//array_push($rowarray,$onerow);
      }
  }

/**/
//$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
//$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
/*$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
*/
				
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
/**/
echo $this->ProcessTemplate('fe_globaluserresults.tpl');


#
# EOF
#
?>