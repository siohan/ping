<?php

if( !isset($gCms) ) exit;
require_once(dirname(__file__).'/include/travaux.php');
$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
$saison = $this->GetPreference('saison_en_cours');
/**/
$journee_sit_mens = $this->GetPreference('jour_sit_mens');
$jour_sit_mens = (isset($journee_sit_mens)?$journee_sit_mens:'10');
//echo $jour_sit_mens;
/**/
$mois_courant = date('n');
$annee_courante = date('Y');
$jour_courant = date('d');
/**/
if($jour_courant < $jour_sit_mens)
{
	$smarty->assign('affichage', FALSE);
}
else
{
	$smarty->assign('affichage', TRUE);
}
/**/
//$month = mois_francais("$mois_courant");
//echo "le mois en français : ".$month;
//$smarty->assign('mois-en-francais', "$month");
$sit_courante = 'Juin 2014';
$smarty->assign('sit_courante', "$sit_courante");
$smarty->assign('display_unable_players', 
		$this->CreateLink($id,'display_unable_players', $returnid, 'liste des joueurs inactifs'));
$smarty->assign('attention_img', '<img src="../modules/Ping/images/warning.gif" alt="'.$this->Lang('missing_sit_mens').'" title="'.$this->Lang('missing_sit_mens').'" width="16" height="16" />');

$dbresult= array ();
//SELECT * FROM ping_module_ping_recup_parties AS rec right JOIN ping_module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT j.id, CONCAT_WS(' ',j.nom, j.prenom) AS joueur, j.licence,rec.maj_spid, rec.maj_fftt, rec.sit_mens, rec.fftt, rec.spid,rec.spid_total, j.actif FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_recup_parties AS rec ON j.licence = rec.licence WHERE j.actif = '1' ORDER BY joueur ASC";

$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$actif = $row['actif'];
	$licence = $row['licence'];
	//$sit_mens = ping_admin_ops::$row['sit_mens'];
	
	$fftt = ping_admin_ops::compte_fftt($licence);
	$spid = ping_admin_ops::compte_spid($licence);
	$sit_mens = ping_admin_ops::sit_mens($licence);
	$spid_errors = ping_admin_ops::compte_spid_errors($licence);
	//var_dump($sit_mens);
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->joueur= $row['joueur'];
	$onerow->licence= $row['licence'];
	//$onerow->active= ($row['active'] == 1) ? $this->Lang('yes') : '';
	$onerow->sit_mens= $sit_mens;//$row['sit_mens'];
	$onerow->fftt= $fftt;
	//$onerow->fftt= $row['fftt'];
	$onerow->maj_fftt= $row['maj_fftt'];
	//$onerow->spid= $row['spid'];
	$onerow->spid= $spid;
	//$onerow->error_link= $this->CreateLink($id, 'defaultadmin',$returnid, 'Corriger', array("active_tab"=>"spid","submitfilter"=>"Ok","curplayer"=>$row['licence'],"error_only"=>"0"));
	$onerow->spid_errors = $spid_errors;
	$onerow->spid_total= $row['spid_total'];
	$onerow->maj_spid= $row['maj_spid'];
	//$onerow->doedit= $this->CreateLink($id, 'edit_joueur', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('licence'=>$row['licence']), $row);
	if($row['actif'] =='1'){
		$onerow->editlink= $this->CreateLink($id, 'unable_player', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('unable'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	} 
	else {
		$onerow->editlink= $this->CreateLink($id, 'enable_player', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('enable'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	}
	
	if($row['sit_mens'] =='')
	{
		$onerow->push_player = $this->CreateLink($id, 'push_player',$returnid, 'Récupérer le joueur',array('licence'=>$row['licence']));
	}
	
	$onerow->correction= $this->CreateLink($id, 'add_sit_mens', $returnid, 'Corriger',  array('licence'=>$row['licence']));
	//$onerow->editlink= $this->CreateLink($id, 'unable_player', $returnid, 'Désactiver',array('licence'=>$row['licence']));
	$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_sit_mens'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_sit_mens', $returnid, 
	  	$this->Lang('retrieve_sit_mens'), array('licence'=>$row['licence']),$warn_message='Attention ! Accès libre ?');
	$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_parties'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_parties', $returnid, 
	  	$this->Lang('retrieve_parties'), array('licence'=>$row['licence']));
	$onerow->getpartiesspid= $this->CreateLink($id, 'retrieve_parties_spid', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_parties_spid'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_parties_spid', $returnid, 
	  	$this->Lang('retrieve_parties_spid'), array('licence'=>$row['licence']));
	//$onerow->deletelink= $this->CreateLink($id, 'delete_joueur', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('barcharts',
		$this->CreateLink($id, 'barcharts', $returnid, 'Voir graphique'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
/*
$smarty->assign('retrieve_users', 
		$this->CreateLink($id, 'retrieve_users', $returnid,'Récupération de tous les joueurs'));
*/


$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Désactiver"=>"unable","Récupérer situation mensuelle"=>"situation", "Récupérer les parties du Spid"=>"spid", "Récupérer les parties FFTT"=>"fftt_parties");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('recupparties.tpl');


#
# EOF
#
?>