<?php

if( !isset($gCms) ) exit;

$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
$saison = $this->GetPreference('saison_en_cours');
/**/
//$journee_sit_mens = $this->GetPreference('jour_sit_mens');
$jour_sit_mens = (isset($journee_sit_mens)?$journee_sit_mens:'10');
//echo $jour_sit_mens;
/**/
$mois_courant = date('n');
$annee_courante = date('Y');
$jour_courant = date('d');
/**/
$calcul = $this->GetPreference('spid_calcul');
if($calcul == 1)
{
	$smarty->assign('affichage', TRUE);
}
else
{
	$smarty->assign('affichage', FALSE);
}


$smarty->assign('retrieve_users', 
		$this->CreateLink($id, 'retrieve', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_users'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve', $returnid, 
		  $this->Lang('retrieve_users'), 
		  array("retrieve"=>"users")));
$smarty->assign('display_unable_players', 
		$this->CreateLink($id,'display_unable_players', $returnid, 'liste des joueurs inactifs'));
$smarty->assign('attention_img', '<img src="../modules/Ping/images/warning.gif" alt="'.$this->Lang('missing_sit_mens').'" title="'.$this->Lang('missing_sit_mens').'" width="16" height="16" />');

$dbresult= array ();
//SELECT * FROM ping_module_ping_recup_parties AS rec right JOIN ping_module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT j.id, CONCAT_WS(' ',j.nom, j.prenom) AS joueur, j.licence,rec.maj_spid, rec.maj_fftt, rec.sit_mens, rec.fftt, rec.spid,rec.spid_total,rec.spid_errors, j.actif FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_recup_parties AS rec ON j.licence = rec.licence WHERE j.actif = '1' ORDER BY joueur ASC";

$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$actif = $row['actif'];
	$licence = $row['licence'];
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->joueur= $row['joueur'];
	$onerow->licence= $row['licence'];
	$onerow->sit_mens= $row['sit_mens'];
	$onerow->fftt= $row['fftt'];// $fftt;
	$onerow->maj_fftt= $row['maj_fftt'];
	$onerow->spid= $row['spid'];
	$onerow->spid_errors= $row['spid_errors'];
	$onerow->spid_total= $row['spid_total'];
	$onerow->maj_spid= $row['maj_spid'];

	if($row['actif'] =='1'){
		$onerow->editlink= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('unable'), '', '', 'systemicon'),array('retrieve'=>'desactivate','licence'=>$row['licence']));
	} 
	else {
		$onerow->editlink= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('enable'), '', '', 'systemicon'),array('retrieve'=>'activate','licence'=>$row['licence']));
	}
	
	if($row['sit_mens'] =='')
	{
		$onerow->push_player = $this->CreateLink($id, 'push_player',$returnid, 'Récupérer le joueur',array('licence'=>$row['licence']));
	}
	
	$onerow->correction= $this->CreateLink($id, 'add_sit_mens', $returnid, 'Corriger',  array('licence'=>$row['licence']));
	$onerow->sitmenslink= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_sit_mens'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve', $returnid, 
	  	$this->Lang('retrieve_sit_mens'), array("retrieve"=>"sit_mens",'sel'=>$row['licence']));
	$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_parties'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_parties', $returnid, 
	  	$this->Lang('retrieve_parties'), array('licence'=>$row['licence']));
	$onerow->getpartiesspid= $this->CreateLink($id, 'retrieve_parties_spid', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_parties_spid'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve_parties_spid', $returnid, 
	  	$this->Lang('retrieve_parties_spid'), array('licence'=>$row['licence']));
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }

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
$articles = array("Récupérer situation mensuelle"=>"situation", "Récupérer les parties du Spid"=>"spid", "Récupérer les parties FFTT"=>"fftt_parties");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('recupparties.tpl');


#
# EOF
#
?>