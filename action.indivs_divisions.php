<?php
if(!isset($gCms)) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$saison = $this->GetPreference('saison_en_cours');
$fede = '100001';
$ping = cms_utils::get_module('Ping'); 
$zone = $ping->GetPreference('zone');
$ligue = $ping->GetPreference('ligue');
$dep = $ping->GetPreference('dep');
$retrieve_ops = new retrieve_ops;
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
	//on va chercher les divisions
	$retrieve_ops->retrieve_divisions($fede, $idepreuve, $type="I");
	$retrieve_ops->retrieve_divisions($zone, $idepreuve, $type="I");
	$retrieve_ops->retrieve_divisions($ligue, $idepreuve, $type="I");
	$retrieve_ops->retrieve_divisions($dep, $idepreuve, $type="I");
	
}
else
{
	echo "il y a une erreur !";
}
if(isset($params['tour']) && $params['tour'] !='')
{
	$tour = $params['tour'];
}
else
{
	echo "il y a une erreur !";
}

	//pas de résultat, on créé un formulaire dynamique
	//On choisit d'abord le niveau
	//on fait une requete pour les données du formulaire
	$query = "SELECT id,idepreuve, iddivision, idorga, libelle FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve= ? AND saison = ? ORDER BY idorga DESC, id ASC";
	$dbresult = $db->Execute($query, array($idepreuve, $saison));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$epreuve[$row['libelle']]  = $row['iddivision'];
		}
	}
	
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'affectation2', $returnid ) );
	
	$smarty->assign('tour', $this->CreateInputHidden($id,'tour',$tour));
	$smarty->assign('idepreuve', $this->CreateInputHidden($id,'idepreuve',$idepreuve));
	
	//$niveaux = array("Nationale"=>$fede,"Zone"=>$zone,"Régional"=>$ligue, "Départemental"=>$dep);
	$smarty->assign('epreuve',
			$this->CreateInputDropdown($id, 'epreuve',$epreuve));
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));
	$smarty->assign('back',
			$this->CreateInputSubmit($id,'back',
						$this->Lang('back')));

	$smarty->assign('formend',
			$this->CreateFormEnd());


	echo $this->ProcessTemplate('affectation_niveaux2.tpl');
	



?>