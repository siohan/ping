<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__file__).'/include/prefs.php');
$saison_courante = $this->GetPreference('saison_en_cours');
$db =& $this->GetDb();
global $themeObject;
$smarty->assign('Label_victoires', 'Victoires');
$smarty->assign('Label_defaite', 'Défaites');
$licence = '292271';
/**/
$result = array();
$query = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur,p.licence,SUM(p.pointres) as sumpoints,SUM(p.vd) AS victoires,count(p.vd) AS matchs, MONTH(p.date_event) AS mois FROM `cms_module_ping_parties` AS p, `cms_module_ping_joueurs` AS j WHERE j.licence = p.licence AND saison = ? AND licence = ?
ORDER BY YEAR(p.date_event) ASC,mois";
//$query = "SELECT SUM(vd) AS victoires, count(vd) AS total, count(vd) - SUM(vd) AS defaites  FROM ".cms_db_prefix()."module_ping_parties WHERE saison = ?";
$dbresult = $db->Execute($query, array($saison_courante, $licence));
echo $query;
$rowclass= 'row1';
$rowarray= array ();
if($dbresult && $dbresult->RecordCount()>0){
	while($row= $dbresult->FetchRow())
	{
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->victoires = $row['victoires'];
		$onerow->total = $row['total'];
		$onerow->defaites = $row['defaites'];
		//$onerow->defaites = $row['total'] - $row['victoires'];
		$datadonnees = array('Victoires'=>$row['victoires'], 'Defaites'=>$row['defaites']);
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
}
else{
	echo 'pb bdd !';
}
/**/
$smarty->assign('items', $rowarray);

//$datadonnees = array('Victoires'=>'12', 'Total'=>'16');
$smarty->assign('donnees', $datadonnees);
//$smarty->assign('donnees', array('Victoires'=>'12', 'Total'=>'12'));
$smarty->assign('donnees2', $donnees2);
//echo $this->ProcessTemplate('pie-charts.tpl');
echo $this->ProcessTemplate('bar-charts.tpl');


#
# EOF
#
?>