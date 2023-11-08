<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$saison_en_cours = $this->GetPreference('saison_en_cours');
$phase_en_cours = $this->GetPreference('phase_en_cours');
$db = cmsms()->GetDb();

$query = "SELECT p.content, p.content_id,c.menu_text, c.hierarchy_path FROM  ".cms_db_prefix()."content_props AS p,  ".cms_db_prefix()."content AS c WHERE c.content_id = p.content_id  AND p.prop_name= 'epreuveAffiche' AND p.content !=''";
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount()>0)
{
	$eq_ops = new equipes_ping; 
	$rowarray= array();	
	$rowclass = '';
	
	while($row = $dbresult->FetchRow())
	{
		$epr = new EpreuvesIndivs;
		$tab = explode('-',$row['content']);
		$epreuve = $tab[0]; //il faut déterminer si cette épreuve est dans la saison en cours 
		$det_epr = $epr->details_epreuve($epreuve);
		$season = $det_epr['saison'];
		$phase = $tab[1];
		$liste_epreuves = $epr->liste_epreuves_res();
				
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->content = $row['content'];
		$onerow->content_id = $row['content_id'];
		$onerow->menu_text = $row['menu_text'];
		$onerow->hierarchy_path = $row['hierarchy_path'];
		$onerow->saison = $season;
		$onerow->phase = $phase;
		$rowarray[] = $onerow;
		
	}
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	$smarty->assign('saison_en_cours', $saison_en_cours);
	$smarty->assign('phase_en_cours', $phase_en_cours);
}
echo $this->ProcessTemplate('page_resultats.tpl');

