<?php
if( !isset($gCms) ) exit;
##############################################################################
# auteur : Claude SIOHAN                                                   ###
# Cette page récupère les compétitions individuelles                      ###
##############################################################################
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/include/prefs.php');

$db =& $this->GetDb();
global $themeObject;
$parms = array();
$result1= array();
$mois_en_cours = date('m');
$mois_en_cours2 = $mois_en_cours - 1;
$nom_equipes = $this->GetPreference('nom_equipes');
$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));

$query1 = "SELECT cla.idepreuve,cla.iddivision,dv.libelle,cla.tableau,cla.tour, cla.rang,cla.nom, cla.points  FROM ".cms_db_prefix()."module_ping_div_classement AS cla , ".cms_db_prefix()."module_ping_divisions AS dv WHERE dv.idepreuve = cla.idepreuve AND dv.iddivision = cla.iddivision AND cla.club LIKE ?";
$i=0;
$parms['club'] = '%'.$nom_equipes.'%';

if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$query1.= " AND dv.idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
}

//$query1.=" GROUP BY dv.libelle";
$query1.=" ORDER BY cla.tour ASC";

//echo $query1;
$result1 = $db->Execute($query1,$parms);
$lignes = $result1->RecordCount();	
//echo "le nb de lignes est : ".$lignes;
	if($result1 && $result1->RecordCount()>0)
	{
		$rowclass= 'row1';
		$rowarray= array();
		
		while($row1 = $result1->FetchRow())
		{
			//on récupère les résultats
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->idepreuve = $row1['idepreuve'];
			$onerow->libelle = $row1['libelle'];
			$onerow->iddivision = $row1['iddivision'];
			$onerow->tableau = $row1['tableau'];
			$onerow->rang= $row1['rang'];
			$onerow->nom= $row1['nom'];
			$onerow->tour= $row1['tour'];
			$onerow->points= $row1['points'];
		$rowarray[]  = $onerow;	
		}	
		
	//	$smarty->assign('items', $rowarray);
				
		
	}//fin du if $result1
	

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);				

echo $this->ProcessTemplate('individuelles2.tpl');


#
# EOF
#
?>