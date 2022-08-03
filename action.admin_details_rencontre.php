<?php
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
$saison_en_cours = $this->GetPreference('saison_en_cours');
$saison = (isset($params['saison']))?$params['saison']:$saison_en_cours;
$record_id = '';
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	$smarty->assign('record_id', $record_id);
}
else
{
	$message = 'Un pb est survenu';
}
if(isset($params['eq_id']) && $params['eq_id'] >0)
{
	$eq_id = (int)$params['eq_id'];
	$smarty->assign('eq_id', $eq_id);
}

//le numéro de l'équipe est ok, on continue
//on va d'abord récupérer la feuille de match
$query = "SELECT id, fk_id, xja, xca, xjb, xcb FROM ".cms_db_prefix()."module_ping_feuilles_rencontres  WHERE fk_id = ? ORDER BY id ASC";
$dbresult= $db->Execute($query, array($record_id));
$lignes = $dbresult->RecordCount();
$rowarray = array();
$rowclass = 'row1';
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->fk_id = $row['fk_id'];
		$onerow->xja = $row['xja'];
		$onerow->xca= $row['xca'];
		$onerow->xjb=  $row['xjb'];
		$onerow->xcb= $row['xcb'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
}
else
{
	//pas de résultats ? on télécharge celui-ci ?
	
}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);


/**/

$query2 = "SELECT id, fk_id, joueurA, scoreA, joueurB, scoreB, detail FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ? ORDER BY id ASC";


$dbresultat = $db->Execute($query2,array($record_id));
$rowarray2 = array();
$i = 0;
if($dbresultat && $dbresultat->RecordCount()>0)
{
	
	while($row2 = $dbresultat->FetchRow())
	{
		$i++;
		$id = $row2['id'];
		//$fk_id = $row2['idpoule'];
		//$iddiv = $row2['iddiv'];
		$onerow2 = new StdClass();
		$onerow2->rowclass =$rowclass;
		$onerow2->id = $row2['id'];
		$onerow2->fk_id = $row2['fk_id'];
		$onerow2->joueurA = $row2['joueurA'];
		$onerow2->scoreA = $row2['scoreA'];
		$onerow2->joueurB = $row2['joueurB'];
		$onerow2->scoreB = $row2['scoreB'];
		$onerow2->detail= $row2['detail'];
		$rowarray2[]  = $onerow2;
	}
	
	$smarty->assign('itemcount2', count($rowarray2));
	$smarty->assign('items2', $rowarray2);
}
echo $this->ProcessTemplate('admin_details_rencontre.tpl');
#
#EOF
#
?>
