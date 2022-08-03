<?php
if (!isset($gCms)) exit;

//on prépare une navigation
$eq = '';
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];//c'est le numéro de licence
	$j_ops = new joueurs;
	$details = $j_ops->details_joueur($record_id);
	$nom = $details['nom'];
}
$rowarray = array();
$query = "SELECT licence, nom, prenom FROM ".cms_db_prefix()."module_ping_joueurs WHERE nom > ? AND actif = '1' ORDER BY nom ASC LIMIT 1";//
$dbresult = $db->Execute($query, array($saison,$phase,$idepreuve));
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		
		$onerow= new StdClass();
		$onerow->licence = $row['licence'];
		$onerow->nom = $row['nom'];
		$onerow->prenom = $row['prenom'];		
		$rowarray[]= $onerow;
	}
	
}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
//$smarty->assign('genid', $record_id);
echo $this->ProcessTemplate('player_nav.tpl');
?>
