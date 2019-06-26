<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
//require_once(dirname(__file__).'/include/travaux.php');
require_once(dirname(__file__).'/include/prefs.php');
$db =& $this->GetDb();
global $themeObject;

$error_compte = 0;
$idAppli = $this->GetPreference('idAppli');
$motdepasse = $this->GetPreference('motdepasse');

$rowclass='';
/*
if($idAppli =='')
{
	$error_compte++;
}
if($motdepasse == '')
{
	$error_compte++;
}
*/
//$error_compte =1;
//echo $error_compte;
$error_config = 0;
$club_number = $this->GetPreference('club_number');
$ligue = $this->GetPreference('ligue');
$zone = $this->GetPreference('zone');
$dep = $this->GetPreference('dep');
$smarty->assign('inactifs', $this->CreateLink($id, 'defaultadmin', $returnid, $contents='Inactifs', array('actif'=>'0', "active_tab"=>"joueurs")));
$smarty->assign('actifs', $this->CreateLink($id, 'defaultadmin', $returnid, $contents='Actifs', array('actif'=>'1', "active_tab"=>"joueurs")));
if($club_number =='')
{
	$error_config++;
}
if($ligue =='')
{
	$error_config++;
}
if($zone == '')
{
	$error_config++;
}
if($dep =='')
{
	$error_config++;
}
if($saison_courante != $saison_en_cours)
{
	$error_config++;
}
//echo $error_config;
//$smarty->assign('club', $this->CreateLink($id, 'retrieve', $returnid, 'infos club', array("retrieve"=>"club")));
$smarty->assign('alertConfig', $error_config);
$smarty->assign('alertCompte', $error_compte);
$smarty->assign('saison_en_cours', $saison_en_cours);
$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
$saison = $this->GetPreference('saison_en_cours');
$smarty->assign('saison',$saison);
$mois_courant = date('n');
$annee_courante = date('Y');


$result= array ();
//SELECT * FROM ".cms_db_prefix()."module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT id,CONCAT_WS(' ',nom, prenom) AS joueur, licence, actif, sexe, type, certif, validation,cat FROM ".cms_db_prefix()."module_ping_joueurs ";
$actif = 1;
if(isset($params['actif']) && $params['actif'] == 0)
{
	$query.=" WHERE actif = 0";
	$act = 0;
}
else
{
	$query.=" WHERE actif = 1";
	$act = 1;
}
$query.=" ORDER BY joueur ASC";
$smarty->assign('act', $act);
$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array();

if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$actif = $row['actif'];
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->licence= $row['licence'];
	$onerow->joueur= $row['joueur'];
	$onerow->actif= $row['actif'];
	$onerow->type= $row['type'];
	$onerow->sexe= $row['sexe'];
	$onerow->certif= $row['certif'];
	$onerow->validation= $row['validation'];
	$onerow->cat= $row['cat'];
	if($row['actif'] =='1')
	{
		$onerow->actif= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('unable'), '', '', 'systemicon'),array('retrieve'=>'desactivate','licence'=>$row['licence']));
	}
	else 
	{
		$onerow->actif= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('enable'), '', '', 'systemicon'),array('retrieve'=>'activate','licence'=>$row['licence']));
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
		$this->CreateLink($id, 'retrieve', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieve_users'), '', '', 'systemicon')).
$this->CreateLink($id, 'retrieve', $returnid, 
		  $this->Lang('retrieve_users'), 
		  array("retrieve"=>"users")));


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