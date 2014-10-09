<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
//$action = (empty($_POST['action'])) ? 'default' : $_POST['action'];

$mois_courant = date('n');
$jour = date('j');
//$mois_pref =$this->SetPreference('defaultMonthSitMens', '6');

$mois_pref = $this->GetPreference('defaultMonthSitMens');
//echo "le mois pref est : ".$mois_pref;
$mois = (!empty($mois_pref)) ? $mois_pref : $mois_courant;
//echo "le mois retenu est : ".$mois;

$result= array ();
$query = "SELECT mois, points, CONCAT_WS(' ', nom, prenom) AS joueur,
   SUM(IF(mois = '5', points, 0)) AS mai ";
if($mois_courant >= '6' ){
$query .=", SUM(IF(mois = '6', points,0)) AS juin ";
}
if($mois_courant >= '7'){
	$query.= " , SUM(IF(mois = '7', points, 0)) AS Juillet ";
}

$query .="   
FROM ".cms_db_prefix()."module_ping_sit_mens
GROUP BY joueur";
echo $query;
//$query= "SELECT id,mois,points, annee, CONCAT_WS(' ', nom, prenom) AS joueur, progmois  FROM ".cms_db_prefix()."module_ping_sit_mens WHERE mois = ?  ORDER BY id ASC";
$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->joueur= $row['joueur'];
	$onerow->mai= $row['mai'];
	$onerow->juin= $row['juin'];
	//$onerow->progmois= $row['progmois'];
//	$onerow->equipe= $this->createLink($id, 'viewsteamresult', $returnid, $row['equipe'],array('equipe'=>$row['equipe']),$row) ;
	//$onerow->joueur= $row['joueur'];
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('fe_allsitmens.tpl');


#
# EOF
#
?>