<?php
if( !isset($gCms) ) exit;

$parms = array();
$result= array();
$mois_en_cours = date('m');
$mois_en_cours2 = $mois_en_cours - 1;
//$nom_equipes = $this->GetPreference('nom_equipes');
$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
}
if(isset($params['tour']) && $params['tour'] !='')
{
	$tour = $params['tour'];
}
$rowarray = array();
$rowclass = 'row1';
$query = "SELECT cla.idepreuve,cla.iddivision,dv.libelle,cla.tableau,cla.tour, cla.rang,cla.nom, cla.points  FROM ".cms_db_prefix()."module_ping_div_classement AS cla , ".cms_db_prefix()."module_ping_div_tours AS dv WHERE dv.idepreuve = cla.idepreuve AND dv.iddivision = cla.iddivision  AND dv.tableau = cla.tableau AND dv.tour = ? AND dv.idepreuve = ? AND dv.saison = ? AND cla.club LIKE '%FOUESNANT%' ";	
$dbresult = $db->Execute($query, array($tour,$idepreuve, $saison_courante));		
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
	
		$iddivision = $row['iddivision'];
		//nouvelle requete pour extraire le libellé du tableau, plus agréable et plus compréhensible
		$query3 = "SELECT libelle FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve = ? AND iddivision = ?";
		$dbresult3 = $db->Execute($query3, array($idepreuve, $iddivision));
		$row3 = $dbresult3->FetchRow();
		$libelle2 = $row3['libelle'];
		$smarty->assign('libelle', $libelle2);
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->idepreuve = $row['idepreuve'];
		$onerow->libelle = $libelle2;//$row2['libelle'];
		$onerow->iddivision = $row['iddivision'];
		$onerow->tableau = $row['tableau'];
		$onerow->rang= $row['rang'];
		$onerow->nom= $row['nom'];
		$onerow->tour= $row['tour'];
		//$onerow2->points= $row2['points'];
		$onerow->compteur = $compteur;
	//	$onerow->details = $this->CreateFrontendLink($id, $returnid, 'details',$contents='Détails', array('record_id'=>$row2['tableau']));
		
		$rowarray[]  = $onerow;	
	}	
	$smarty->assign('items', $rowarray);
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));	
	
}

echo $this->ProcessTemplate('individuelles4.tpl');


#
# EOF
#
?>