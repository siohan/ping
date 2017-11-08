<?php
if(!isset($gCms) )exit;
##############################################################################
# auteur : Claude SIOHAN                                                   ###
# Cette page récupère les compétitions individuelles                      ###
##############################################################################
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/include/prefs.php');


$db = cmsms()->GetDb();
$ping_ops = new ping_admin_ops();
$saison = $this->GetPreference('saison_en_cours');
global $themeObject;
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
}
if(isset($params['tour']) && $params['tour'] != '')
{
	$tour = $params['tour'];
}
$rowclass = '';
//echo $query;
$rowarray= array();
$query = "SELECT DISTINCT iddivision FROM ".cms_db_prefix()."module_ping_participe_tours WHERE idepreuve = ? AND tour = ? AND saison = ? ORDER BY idorga DESC";
$dbresult = $db->Execute($query, array($idepreuve, $tour, $saison));
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$iddivision = $row['iddivision'];
		//on va chercher le libelle
		$libelle = $ping_ops->nom_division($idepreuve,$iddivision,$saison);
		echo $libelle;
		//on fait une deuxième requete
		$query2 = "SELECT rang, nom, club FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND tour = ? AND iddivision = ? AND saison = ?";
		$dbresult2 = $db->Execute($query2, array($idepreuve, $tour, $iddivision, $saison));
		
		if($dbresult2 && $dbresult2->RecordCount()>0)
		{
			while($row = $dbresult2->FetchRow())
			{
				$onerow = new StdClass();
				$onerow->rang = $row['rang'];
				$onerow->nom = $row['nom'];
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
			}
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfound'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
	echo $this->ProcessTemplate('individuelles2.tpl');	
	}
	
}
else
{
	echo "Pas encore de résultats disponibles";
}

?>