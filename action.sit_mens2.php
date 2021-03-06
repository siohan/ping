<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;
$mois_courant = date('n');
$annee_choisie = date('Y');
$mois_choisi = '';
$phase = $this->GetPreference('phase_en_cours');

if(isset($params['mois']) && $params['mois'] !='')
{
	$mois_choisi = $params['mois'];
}
else
{
	$mois_choisi = $mois_courant;
}

if($mois_choisi ==1)
{
	$mois_precedent = 12;
	$annee_choisie = $annee_choisie;
}
else
{
	$mois_precedent = $mois_choisi -1;
}
if($mois_choisi==12)
{
	$mois_suivant = 1;
	$annee_choisie = $annee_choisie - 1;
}
else
{
	$mois_suivant = $mois_choisi + 1;
}

$smarty->assign('mois_precedent',
		$this->CreateLink($id,'sit_mens2',$returnid, '<< Précédent',array("mois"=>"$mois_precedent")));
/*
$smarty->assign('mois_suivant',
		$this->CreateLink($id,'defaultadmin',$returnid, 'Suivant >>', array("active_tab"=>"calendrier","mois"=>"$mois_suivant") ));
*/
$smarty->assign('mois_suivant',
		$this->CreateLink($id,'sit_mens2',$returnid, 'Suivant >>', array("mois"=>"$mois_suivant") ));




$jour = date('j');
//Faire une préférence pour ne pas afficher le mois pas encore en accès libre ?

$phase_courante = $this->GetPreference('phase');

$query = "SELECT licence,mois, points, clnat, rangreg, rangdep, progmois, CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_sit_mens";//" WHERE annee = ? AND mois = ?";
if(isset($params['mois']) && $params['mois'] !='')
{
	$query.=" WHERE mois = ?";
	$parms['mois'] = $mois_choisi;
	
}
else
{
	$query.=" WHERE mois = ?";
	$parms['mois'] = $mois_choisi;
}
$query.=" AND annee = ?";
$parms['annee'] = $annee_choisie;
//echo $query;
$dbresult = $db->Execute($query, $parms);

$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount() > 0)
{
    	while ($row= $dbresult->FetchRow())
	{
	
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->joueur= $this->CreateLink($id,'user_results',$returnid, $row['joueur'], array("licence"=>$row['licence'],"month"=>$mois_choisi-1));
		$onerow->points = $row['points'];
		$onerow->clnat= $row['clnat'];
		$onerow->rangreg= $row['rangreg'];
		$onerow->rangdep= $row['rangdep'];
		$onerow->progmois= $row['progmois'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
}
else
{
	echo "<p>Pas de résultats disponibles.</p>";
}
	

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('sitmens.tpl');


#
# EOF
#
?>