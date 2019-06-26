<?php
#############################################################
##                  FFTT                                   ##
#############################################################
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
$this->SetCurrenTab('fftt');
//debug_display($params, 'Parameters');
require_once(dirname(__file__).'/include/prefs.php');
$saison = $this->GetPreference('saison_en_cours');
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
	$det = new joueurs;
	$details = $det->details_joueur($licence);
	$nom = $details['nom'];
	$prenom = $details['prenom'];
	
	$smarty->assign('joueur',$prenom.' '.$nom );
}
$smarty->assign('retour', $this->CreateLink($id,'defaultadmin', $returnid, $contents='<= Revenir', array("active_tab"=>"fftt")));
$smarty->assign('retrieve_fftt', $this->CreateLink($id, 'retrieve', $returnid, $contents='Télécharger ses parties FFTT', array("retrieve"=>"fftt_seul", "licence"=>$licence)));
$smarty->assign('rafraichir', $this->CreateLink($id, 'retrieve', $returnid, $contents='Rafraichir les données', array("retrieve"=>"recup_parties")));
$query = "SELECT  pts.id, pts.vd, pts.numjourn,pts.date_event, pts.advnompre,pts.pointres, pts.advclaof, pts.codechamp, pts.coefchamp  FROM ".cms_db_prefix()."module_ping_parties AS pts  WHERE pts.licence = ? AND pts.saison = ?";
$dbresult= $db->Execute($query,array($licence, $saison));

$rowarray= array();
$rowclass = 'row1';
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->date_event = $row['date_event'];
	$onerow->numjourn= $row['numjourn'];
	$onerow->vd= $row['vd']; 
	$onerow->advnompre= $row['advnompre'];
	$onerow->pointres= $row['pointres'];
	$onerow->codechamp= $row['codechamp'];
	$onerow->coefchamp= $row['coefchamp'];
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
//deuxièmme requete pour compter les points de cette journée
$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
echo $this->ProcessTemplate('fftt.tpl');


#
# EOF
#
?>