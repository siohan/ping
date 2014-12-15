<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');

require_once(dirname(__FILE__).'/function.calculs.php');
$mois_courant = date('n');
$last_month = $mois_courant -1;
//$mois_courant = 5;
$annee_courante = date('Y');
$result= array ();
//$query = "SELECT * FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";
$query = "SELECT j.licence, CONCAT_WS(' ',j.nom, j.prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN  ".cms_db_prefix()."module_ping_sit_mens AS st  ON st.licence = j.licence AND st.mois = WHERE (st.mois != ? AND st.annee = ?) OR (st.mois IS NULL AND st.annee IS NULL) AND actif = '1' GROUP BY st.licence";
//$query= "SELECT id,mois,points, annee, CONCAT_WS(' ', nom, prenom) AS joueur, progmois  FROM ".cms_db_prefix()."module_ping_sit_mens ORDER BY id ASC";
echo $query;
$dbresult = $db->Execute($query, array($mois_courant,$annee_courante));
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	
	$licence = $row['licence'];
	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_sit_mens ";
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	//$onerow->mois= $row['mois'];
	//$onerow->annee= $row['annee'];
	//$onerow->points= $row['points'];
	//$onerow->progmois= $row['progmois'];
	//$onerow->equipe= $this->createLink($id, 'viewsteamresult', $returnid, $row['equipe'],array('equipe'=>$row['equipe']),$row) ;
	$onerow->joueur= $row['joueur'];
	
	
	/*	
	$onerow->commune= $row['commune'];
	$onerow->email= $row['email'];
	$onerow->tranche= $row['tranche'];
	$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	*/
	$onerow->id= $this->CreateLink($id, 'edit_joueurs', $returnid, $row['id'],array('record_id'=>$row['id']), $row);
	$onerow->editlink= $this->CreateLink($id, 'edit_joueur', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']));
	$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, 'Situation mensuelle', array('licence'=>$row['licence']));
	$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, 'Parties disputées', array('licence'=>$row['licence']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_joueur', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('retrieveallsitmens',
		$this->CreateLink($id,'retrieve_all_sit_mens', $returnid, 'Récupérer toutes les situations mensuelles'));
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));

echo $this->ProcessTemplate('allsitmens.tpl');


#
# EOF
#
?>