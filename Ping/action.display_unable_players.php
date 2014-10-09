<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__file__).'/function.calculs.php');
$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
$saison = '2013-2014';
$mois_courant = date('n');
$annee_courante = date('Y');
//$month = mois_francais("$mois_courant");
//echo "le mois en français : ".$month;
//$smarty->assign('mois-en-francais', "$month");
$sit_courante = 'Juin 2014';
$smarty->assign('sit_courante', "$sit_courante");
$smarty->assign('display_enable_players',
		$this->CreateLink($id, 'admin_joueurs_recup_tab', $returnid, 'Joueurs actifs'));


$result= array ();
//SELECT * FROM ping_module_ping_recup_parties AS rec right JOIN ping_module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT id, CONCAT_WS(' ',nom, prenom) AS joueur, licence, actif FROM ".cms_db_prefix()."module_ping_joueurs  WHERE actif = '0'  ORDER BY id ASC";
//echo $query;
$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->joueur= $row['joueur'];
	//$onerow->prenom= $row['prenom'];
	
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
		$this->CreateLink($id, 'retrieve_users', $returnid,'Récupération de tous les joueurs'));
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));

echo $this->ProcessTemplate('unable_players.tpl');


#
# EOF
#
?>