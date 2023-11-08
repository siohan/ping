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

$query= "SELECT j.id, CONCAT_WS(' ',j.nom, j.prenom) AS joueur, j.licence,rec.maj_spid, rec.maj_fftt, rec.sit_mens, rec.fftt, rec.spid,rec.spid_total,rec.spid_errors, j.actif FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_recup_parties AS rec ON j.licence = rec.licence WHERE j.actif = '1' AND type = 'T' ORDER BY joueur ASC";

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
	$onerow->fftt= $row['fftt'];// $fftt;
	$onerow->maj_fftt= $row['maj_fftt'];	
	$onerow->view = $this->CreateLink($id, 'admin_fftt_tab', $returnid,$themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view'), '', '', 'systemicon'), array("licence"=>$row['licence']));
	$onerow->getpartieslink= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_parties'), '', '', 'systemicon'), array("retrieve"=>"fftt_seul", "licence"=>$row['licence']));
	
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
$articles = array("Récupérer les parties FFTT"=>"fftt_parties");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('fftt2.tpl');


#
# EOF
#
?>
