<?php

if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$smarty->assign('fede', $this->GetPreference('fede'));
$smarty->assign('zone', $this->GetPreference('zone'));
$smarty->assign('ligue', $this->GetPreference('ligue'));
$smarty->assign('dep', $this->GetPreference('dep'));
$saison = $this->GetPreference('saison_en_cours');
$ep_ops = new fftt_organismes;
$epreuves = new EpreuvesIndivs;
$club = $epreuves->nom_club();
$smarty->assign('club', $club);
$nclub="%".$club."%";
$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Récupérer les compétitions individuelles', array("type"=>"I")));
$smarty->assign('titreTableau', 'Liste des compétitions par équipes');
$smarty->assign('suivi', false);
$result= array ();
$active = 1;
$indivs = false;

if(isset($params['active']) && $params['active'] != '')
{
	if($params['active'] == '2'){$active = 0;}else{$active = $params['active'];}
}
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE actif = ? ";
if(isset($params['indivs_suivies']))
{
	
	$query.=" AND typepreuve IN ('C','I')";
	
	
	if($params['indivs_suivies'] == 1)
	{
		$query.=" AND suivi = 1 ";
		$smarty->assign('titreTableau', 'Liste des compétitions individuelles suivies');
		$smarty->assign('suivi', true);
		
	}
	else
	{
		$query.=" AND suivi = 0";
		$smarty->assign('titreTableau', 'Liste des compétitions individuelles non suivies');
		$smarty->assign('suivi', false);
	}
	$indivs = 'true';
}
elseif($params['active'] == '2')
{
	$smarty->assign('titreTableau', 'Liste des compétitions désactivées');
}
else
{
	$query.=" AND typepreuve NOT IN ('C', 'I')";
}
$smarty->assign('indivs', $indivs);
$query.=" ORDER BY name ASC, idepreuve DESC";
$dbresult= $db->Execute($query, array($active));
$ping_ops = new ping_admin_ops;

//echo $query;
$rowarray= array();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->name= $row['name'];
		$onerow->friendlyname= $row['friendlyname'];
		$onerow->tag= $row['tag'];
		$onerow->coefficient= $row['coefficient'];
		$onerow->indivs= $row['indivs'];
		$onerow->idepreuve = $row['idepreuve'];
		$onerow->actif = $row['actif'];
		$onerow->typepreuve = $row['typepreuve'];
		$onerow->divisions = (int)$epreuves->nb_divisions($row['idepreuve']);
		$onerow->tours = (int)$epreuves->nb_tours($row['idepreuve']);
		$onerow->nb_cla = (int)$epreuves->nb_classements($row['idepreuve']);
		$onerow->suivi = $row['suivi'];
		$onerow->saison = $row['saison'];
		$onerow->nb_players = (int) $epreuves->nb_players_incla($row['idepreuve'], $nclub);
		$onerow->orga = $ep_ops->organisateur($row['idorga']);
		$onerow->idorga = $row['idorga'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
      }
  }

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Activer"=>"activate_epr", "Désactiver"=>"desactivate_epr","Suivre"=>"suivi_ok", "Ne plus suivre"=>"suivi_ko", "Supprimer"=>"delete_epr");
	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('list_compet_indivs.tpl');


#
# EOF
#
?>
