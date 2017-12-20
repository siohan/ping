<?php
if( !isset($gCms) ) exit;
echo 'Ok !';
//debug_display($params, 'Parameters');
$feu = cms_utils::get_module('FrontEndUsers');
$userid = $feu->LoggedInId();
$username = $feu->GetUsername($userid);
echo "le username est : ".$username;
echo "en route ! ";
global $themeObject;
$ping = new Ping();
$saison = (isset($params['saison'])?$params['saison']:$ping->GetPreference('saison_en_cours'));
$mois_courant = date('m');
//mon spid
//un lien pour récupérer mes parties spid ? Go !

//$joueur = $row1['joueur'];
//$smarty->assign('joueur', $joueur);
$db = cmsms()->GetDb();
$query= "SELECT nom, classement,pointres, victoire,date_event,epreuve,numjourn FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND MONTH(date_event) = ? AND licence = ?";//" ORDER BY date_event ASC";
$query.=" ORDER BY date_event DESC";
echo $query;
$dbresult = $db->Execute($query, array($saison,$mois_courant,$username));

$rowarray= array();

if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {

	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->date_event= $row['date_event'];
	$onerow->epreuve= $row['epreuve'];
	$onerow->nom= $row['nom'];
	$onerow->classement= $row['classement'];
	$onerow->victoire= $row['victoire'];
	//$onerow->coeff= $row['coeff'];
//	$onerow->pointres= $row['pointres'];
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('resultats',
		$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$licence)));


$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
$this->CreateReturnLink($id, $returnid,'Retour'));
$smarty->assign('items', $rowarray);

$smarty->assign('resultats',
$this->CreateLink($id,'user_results',$returnid, array('licence'=>$licence)));

echo $this->ProcessTemplate('fe-sportif.tpl');
//mon FFTT

?>