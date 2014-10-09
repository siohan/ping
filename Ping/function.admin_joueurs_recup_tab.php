<?php

if( !isset($gCms) ) exit;
require_once(dirname(__file__).'/include/travaux.php');
$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
$saison = $this->GetPreference('saison_en_cours');
$mois_courant = date('n');
$annee_courante = date('Y');
//$month = mois_francais("$mois_courant");
//echo "le mois en français : ".$month;
//$smarty->assign('mois-en-francais', "$month");
$sit_courante = 'Juin 2014';
$smarty->assign('sit_courante', "$sit_courante");
$smarty->assign('display_unable_players', 
		$this->CreateLink($id,'display_unable_players', $returnid, 'liste des joueurs inactifs'));


$result= array ();
//SELECT * FROM ping_module_ping_recup_parties AS rec right JOIN ping_module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT j.id, CONCAT_WS(' ',j.nom, j.prenom) AS joueur, j.licence, rec.sit_mens, rec.fftt, rec.spid, j.actif FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_recup_parties AS rec ON j.licence = rec.licence WHERE j.actif = '1' AND (rec.saison = ? OR rec.saison IS NULL) ORDER BY j.id ASC";
if($travaux=='true'){echo $query;}
$dbresult= $db->Execute($query, array($saison));
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$actif = $row['actif'];
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->joueur= $row['joueur'];
	$onerow->licence= $row['licence'];
	//$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	$onerow->sit_mens= $row['sit_mens'];
	$onerow->fftt= $row['fftt'];
	$onerow->spid= $row['spid'];
	$onerow->doedit= $this->CreateLink($id, 'edit_joueur', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('licence'=>$row['licence']), $row);
	if($row['actif'] =='1'){
		$onerow->editlink= $this->CreateLink($id, 'unable_player', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('unable'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	} 
	else {
		$onerow->editlink= $this->CreateLink($id, 'enable_player', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('enable'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	}
	//$onerow->editlink= $this->CreateLink($id, 'unable_player', $returnid, 'Désactiver',array('licence'=>$row['licence']));
	$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, $themeObject->DisplayImage('icons/system/download.gif', $this->Lang('retrieve_sit_mens'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_sit_mens', $returnid, 
	  $this->Lang('retrieve_sit_mens'), array('licence'=>$row['licence']));
	$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, 'Parties disputées', array('licence'=>$row['licence']));
	$onerow->getpartiesspid= $this->CreateLink($id, 'retrieve_parties_spid', $returnid, 'Parties SPID', array('licence'=>$row['licence']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_joueur', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('barcharts',
		$this->CreateLink($id, 'barcharts', $returnid, 'Voir graphique'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('retrieve_users', 
		$this->CreateLink($id, 'retrieve_users', $returnid,'Récupération de tous les joueurs'));
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
		$articles = array("Désactiver"=>"unable","Récupérer situation mensuelle"=>"situation", "Récupérer les parties du Spid"=>"spid");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('recupparties.tpl');


#
# EOF
#
?>