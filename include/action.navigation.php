<?php
if (!isset($gCms)) exit;

//on prépare une navigation
$eq = '';
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
}
$rowarray = array();
$query = "SELECT id, libequipe, friendlyname FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ? AND idepreuve = ? ORDER BY numero_equipe ASC";//
$dbresult = $db->Execute($query, array($saison,$phase,$idepreuve));
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$friendlyname = $row['friendlyname'];
		if(null !==$friendlyname)
		{
			$libequipe = $friendlyname;
		}
		else
		{
			$libequipe = $row['libequipe'];
		}
		$onerow= new StdClass();
		$onerow->record_id = $row['id'];
		$onerow->libequipe = $libequipe;
		$onerow->idepreuve = $idepreuve;
		$rowarray[]= $onerow;
	}
	
}
$smarty->assign('record_id', $record_id);
$smarty->assign('idepreuve', $idepreuve);
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
//$smarty->assign('genid', $record_id);
echo $this->ProcessTemplate('navigation.tpl');
?>