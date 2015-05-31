<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__file__).'/function.calculs.php');
$db =& $this->GetDb();
global $themeObject;

$mois_courant = date('n');
$annee_courante = date('Y');
$smarty->assign('display_enable_players',
		$this->CreateLink($id, 'admin_joueurs_recup_tab', $returnid, 'Joueurs actifs'));


$result= array ();
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
	
	if($row['actif'] =='1'){
		$onerow->editlink= $this->CreateLink($id, 'able_player', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('unable'), '', '', 'systemicon'),array('licence'=>$row['licence'], "actif"=>"0"));
	}
	else {
		$onerow->editlink= $this->CreateLink($id, 'able_player', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('enable'), '', '', 'systemicon'),array('licence'=>$row['licence'],"actif"=>"1"));
	}
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