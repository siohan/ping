<?php
if(!isset( $gCms) ) exit;
#################################################################
###           Top ou flop                                     ###
#################################################################
require_once(dirname(__FILE__).'/include/prefs.php');
//debug_display($params,'Parameters');
$saison_courante = (isset($params['saison']))?$params['saison']:$this->GetPreference('saison_en_cours');
//on commence direct par la requete
$db =& $this->GetDb();
$titletable = '';//Ceci est le titre de la balise H1
$getmore === FALSE;//pour afficher ou non le lien plus par défaut non.
$parms = array();
$query1 = "SELECT CONCAT_WS(' ',j.nom, j.prenom) AS joueur,sp.advnompre,sp.advclaof,sp.vd, sp.pointres FROM ".cms_db_prefix()."module_ping_parties AS sp, ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = sp.licence AND sp.saison = ? ";//

//On regarde si on a mis des parametres
// déjà la saison
$parms['saison'] = $saison_courante;

//top ou flop ?
//on essaie le top d'abord
	if (isset($params['perf']) && $params['perf'] !='')
	{
		$query1.= " AND sp.vd = ?";
		
		if($params['perf'] =='top')
		{
			$parms['victoire'] = 1;
			$titletable = 'Les meilleures perfs';
		}
		else
		{
			$parms['victoire'] = 0;
			$titletable = 'Les pires flops';
		}
	}
	else
	{
		$query1.= " AND sp.vd = ?";
		$parms['victoire'] = 1;
		$titletable = 'Les meilleures perfs';
	}

	if(isset($params['licence']) && $params['licence'] !='')
	{
		$query1.=" AND j.licence = ?";
		$parms['licence'] = $params['licence'];
	}
	//on teste aussi le mois
	if(isset($params['mois']) && $params['mois'] != '')
	{
		$mois_choisi = $params['mois'];
		$query1.= " AND MONTH(sp.date_event) = ?";
		$parms['mois'] = $mois_choisi;
	}
$query1.= " ORDER BY sp.pointres DESC";	
	if(isset($params['limit']) && $params['limit']>0)
	{
		$query1.= " LIMIT 0, ?";
		$parms['limit'] = $params['limit'];
		$getmore = 'True';
	}
	

	
	
	
//echo $query1;
$dbresult = $db->Execute($query1,$parms);
$rowarray = array();
$rowclass= 'row1';
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->joueur = $row['joueur'];
		$onerow->adv = $row['advnompre'];
		$onerow->advclaof = $row['advclaof'];
		$onerow->pointres = $row['pointres'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
}
else
{
	echo $db->ErrorMsg();
}
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('getmore',$getmore);
$smarty->assign('more',
	$this->CreateFrontendLink($id, $returnid,'topFlop',$contents='Plus',array("perf"=>"top"),'','', $inline='true','',$targetcontentonly='true'));
echo $this->ProcessTemplate('topflop.tpl');

#
#EOF
#
?>