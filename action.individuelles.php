<?php
if(!isset($gCms) )exit;
##############################################################################
# auteur : Claude SIOHAN                                                   ###
# Cette page récupère les compétitions individuelles                      ###
##############################################################################
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/include/prefs.php');
if(!$this->CheckPermission('Ping Use'))
{
	
}

$db = cmsms()->GetDb();
$ping_ops = new ping_admin_ops();
$parms = array();
$saison = $this->GetPreference('saison_en_cours');

global $themeObject;
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$parms['idepreuve'] = $idepreuve;
}

$rowclass = '';
//echo $query;
$rowarray= array();
$rowarray2 = array();
$i = 0;
$query = "SELECT DISTINCT iddivision FROM ".cms_db_prefix()."module_ping_participe_tours WHERE idepreuve = ?";//" AND tour = ? 
if(isset($params['tour']) && $params['tour'] != '')
{
	$tour = $params['tour'];
	$parms['tour'] = $tour;
	$query.= " AND tour = ?";
}
$parms['saison'] = $saison;
$query.=" AND saison = ? ORDER BY idorga DESC";
$dbresult = $db->Execute($query, $parms);//array($idepreuve, $tour, $saison));
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$i++;
		$iddivision = $row['iddivision'];
		//on va chercher le libelle
		$onerow = new StdClass();
		$onerow->libelle = $ping_ops->nom_division($idepreuve,$iddivision,$saison);
		$onerow->valeur = $i;
		//echo $libelle;
		//on fait une deuxième requete
			$query2 = "SELECT rang, nom, club FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ?";//" AND tour = ? AND iddivision = ? AND saison = ? ORDER BY id ASC";
			if(isset($params['tour']) && $params['tour'] != '')
			{
				$tour = $params['tour'];
				//$parms['tour'] = $tour;
				$query2.= " AND tour = ? AND iddivision = ? AND saison = ? ORDER BY id ASC";
				$dbresult2 = $db->Execute($query2, array($idepreuve, $tour, $iddivision, $saison));
			}
			else
			{
				$query2.= " AND iddivision = ? AND saison = ? ORDER BY id ASC";
				$dbresult2 = $db->Execute($query2, array($idepreuve,$iddivision, $saison));
			}
			//$dbresult2 = $db->Execute($query2, array($idepreuve, $tour, $iddivision, $saison));
		
			if($dbresult2 && $dbresult2->RecordCount()>0)
			{
				while($row2 = $dbresult2->FetchRow())
				{
					$onerow2 = new StdClass();
					$onerow2->rang = $row2['rang'];
					$onerow2->nom = $row2['nom'];
					$onerow2->club = $row2['club'];
					
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray2[]= $onerow2;
				}
				
				$smarty->assign('prods_'.$i,$rowarray2);
				unset($rowarray2);
			//	unset($idepreuve2);
			
			
			}
		$rowarray[]  = $onerow;
	}
	
}

$smarty->assign('items', $rowarray);
//$smarti->assign('itemcount', count($rowarray));
echo $this->ProcessTemplate('individuelles2.tpl');

?>