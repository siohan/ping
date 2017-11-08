<?php
if(!isset($gCms)) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$saison = $this->GetPreference('saison_en_cours');
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	echo "il y a une erreur !";
}
$smarty->assign('affectations', 
		$this->CreateLink($id, 'affectations_niveaux', $returnid, 'Affectations', array("idepreuve"=>$idepreuve)));
$query = "SELECT CONCAT_WS(' ',j.nom, j.prenom) AS joueur , j.licence FROM ".cms_db_prefix()."module_ping_participe AS part, ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = part.licence AND part.idepreuve = ? AND part.saison = ?";
//echo $query;
$dbresult = $db->Execute($query, array($idepreuve, $saison));
$rowarray = array();
$rowclass='row1';
if($dbresult && $dbresult->recordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->licence = $row['licence'];
		$onerow->joueur = $row['joueur'];
		
		$onerow->affectation = $this->CreateLink($id, 'participants_tours',$returnid, 'Affectations', array("licence"=>$row['licence'], "idepreuve"=>$idepreuve) );
		//$onerow->affectation = $this->CreateLink($id, 'participants_tours',$returnid, 'Affectations', array("licence"=>$row['licence'], "idepreuve"=>$idepreuve) );
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfound'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
}

echo $this->ProcessTemplate('participants.tpl');
?>