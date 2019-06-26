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
$spid_ops = new spid_ops;

$smarty->assign('attention_img', '<img src="../modules/Ping/images/warning.gif" alt="'.$this->Lang('missing_sit_mens').'" title="'.$this->Lang('missing_sit_mens').'" width="16" height="16" />');

$dbresult= array ();
//SELECT * FROM ping_module_ping_recup_parties AS rec right JOIN ping_module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT j.id, CONCAT_WS(' ',j.nom, j.prenom) AS joueur, j.licence,rec.maj_spid, rec.maj_fftt, rec.sit_mens, rec.fftt, rec.spid,rec.spid_total,rec.spid_errors, j.actif FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_recup_parties AS rec WHERE j.licence = rec.licence AND j.actif = '1' AND j.type = 'T' ORDER BY joueur ASC";

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
	$onerow->spid= $row['spid'];
	$onerow->spid_errors= $row['spid_errors'];
	$onerow->spid_total= $row['spid_total'];
	$onerow->points = $spid_ops->compte_spid_points($licence);
	$onerow->maj_spid= date('d/m à H:i:s',$row['maj_spid']);	
	$onerow->getpartiesspid= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('import'), '', '', 'systemicon'), array('retrieve'=>'spid_seul','licence'=>$row['licence']));
	$onerow->view= $this->CreateLink($id, 'admin_details_spid', $returnid,$themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view'), '', '', 'systemicon'), array("licence"=>$licence));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$smarty->assign('rafraichir', 
		$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid,'Rafraichir les parties SPID', array("retrieve"=>"spid_all")));



$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Récupérer situation mensuelle"=>"situation", "Récupérer les parties du Spid"=>"spid");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('recupparties.tpl');


#
# EOF
#
?>