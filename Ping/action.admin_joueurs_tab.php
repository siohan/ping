<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
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
//SELECT * FROM ".cms_db_prefix()."module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT id, CONCAT_WS(' ',nom, prenom) AS joueur, licence, actif, sexe, birthday FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif= '1'  ORDER BY joueur ASC";
if($travaux=='true'){echo $query;}
$dbresult= $db->Execute($query);
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
	$onerow->licence= $row['licence'];
	$onerow->joueur= $row['joueur'];
	$onerow->actif= $row['actif'];
	$onerow->sexe= $row['sexe'];
	$onerow->birthday= $row['birthday'];
	$onerow->view_contacts= $this->CreateLink($id,'view_contacts', $returnid,$themeObject->DisplayImage('icons/topfiles/myaccount.gif', $this->Lang('view_contacts'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	$onerow->doedit= $this->CreateLink($id, 'add_joueur', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	if($row['actif'] =='1'){
		$onerow->editlink= $this->CreateLink($id, 'unable_player', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('unable'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	}
	else {
		$onerow->editlink= $this->CreateLink($id, 'enable_player', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('enable'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	}
	//$onerow->editlink= $this->CreateLink($id, 'unable_player', $returnid, 'Désactiver',array('licence'=>$row['licence']));
	$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, 'Situation mensuelle', array('licence'=>$row['licence']));
	$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, 'Parties disputées', array('licence'=>$row['licence']));
	$onerow->getpartiesspid= $this->CreateLink($id, 'retrieve_parties_spid', $returnid, 'Parties SPID', array('licence'=>$row['licence']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_joueur', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('retrieve_users', 
		$this->CreateLink($id, 'retrieve_users', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_users'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_users', $returnid, 
		  $this->Lang('retrieve_users'), 
		  array()));
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_joueur', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add_user'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_joueur', $returnid, 
				  $this->Lang('add_user'), 
				  array()));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Désactiver"=>"unable","Mettre à masculin"=>"masculin", "Mettre à Féminin"=>"feminin");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('joueurs.tpl');


#
# EOF
#
?>