<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Delete'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$saison = (isset($params['saison'])?$params['saison'] : $this->GetPreference('saison_en_cours'));
$phase = (isset($params['phase'])?$params['phase'] : $this->GetPreference('phase_en_cours'));
$db = cmsms()->GetDb();
//content, c'est le numéro de l'équipe en bdd, 
//le content_id, c'est le numéro de la page
$query = "SELECT content, content_id FROM ".cms_db_prefix()."content_props WHERE content >0  AND prop_name= 'equipeAffiche'";
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount()>0)
{
	$eq_ops = new equipes_ping; 
	$rowarray= array();	
	$rowclass = '';
	
	while($row = $dbresult->FetchRow())
	{
		//on va chercher les détails de chq équipe 
		$details = $eq_ops->details_equipe($row['content']);
		
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->id = $details['id'];
		$onerow->equipe = $details['libequipe'];
		$onerow->libdivision = $details['libdivision'];
		$onerow->saison = $details['saison'];
		$onerow->phase = $details['phase'];
		$onerow->page_contenu = $row['content_id'];
		$rowarray[] = $onerow;
		
	}
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	$smarty->assign('saison_en_cours', $saison);
	$smarty->assign('phase_en_cours', $phase);
}
echo $this->ProcessTemplate('page_contenu.tpl');

