<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
//$action = (empty($_POST['action'])) ? 'default' : $_POST['action'];
$mois = 7;
$mois_courant = date('n');
$annee_courante = date('Y');
//$mois_pref =$this->SetPreference('defaultMonthSitMens', '6');

$mois_pref = $this->GetPreference('defaultMonthSitMens');
//echo "le mois pref est : ".$mois_pref;
$mois = (!empty($mois_pref)) ? $mois_pref : $mois_courant;
//echo "le mois retenu est : ".$mois;

$result= array ();
$query= "SELECT j.licence,sm.id,sm.mois,sm.points, sm.annee, CONCAT_WS(' ', j.nom, j.prenom) AS joueur, sm.progmois, sm.clnat, sm.rangreg, sm.rangdep  FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_sit_mens AS sm ON j.licence = sm.licence WHERE j.actif = '1' AND (sm.mois = ? OR sm.mois IS NULL) AND (sm.annee = ? OR sm.annee IS NULL) ORDER BY joueur ASC";
echo $query;
$dbresult= $db->Execute($query,array($mois_courant, $annee_courante));
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->licence= $row['licence'];
	$onerow->mois= $row['mois'];
	$onerow->annee= $row['annee'];
	$onerow->points= $row['points'];
	$onerow->clnat= $row['clnat'];
	$onerow->rangreg= $row['rangreg'];
	$onerow->rangdep= $row['rangdep'];
	$onerow->progmois= $row['progmois'];
	$onerow->equipe= $this->createLink($id, 'viewsteamresult', $returnid, $row['equipe'],array('equipe'=>$row['equipe']),$row) ;
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
	$onerow->deletelink= $this->CreateLink($id, 'delete_sit_mens', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('retrieveallsitmens',
		$this->CreateLink($id,'retrieve_all_sit_mens', $returnid, 'Récupérer toutes les situations mensuelles'));
$smarty->assign('missing_sit_mens', 
		$this->CreateLink($id, 'missing_sit_mens', $returnid, 'Les situations manquantes'));
		$smarty->assign('form2start',
				$this->CreateFormStart($id,'mass_action',$returnid));
		$smarty->assign('form2end',
				$this->CreateFormEnd());
				$articles = array("Désactiver"=>"unable","Récupérer situation mensuelle"=>"situation");
		$smarty->assign('actiondemasse',
				$this->CreateInputDropdown($id,'actiondemasse',$articles));
		$smarty->assign('submit_massaction',
				$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
				  

echo $this->ProcessTemplate('allsitmens.tpl');


#
# EOF
#
?>